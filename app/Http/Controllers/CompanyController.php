<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CompanyController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Company::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(string $id, Request $request) {
    try {
      $item = Company::getItem($id, $request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function store(Request $request) {
    return $this->storeUpdate(null, $request);
  }

  public function update(string $id, Request $request) {
    return $this->storeUpdate($id, $request);
  }

  public function destroy(string $id, Request $request) {
    return $this->setActive(Company::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(Company::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();

    try {
      $store_mode = is_null($id);

      $valid = Company::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = FacturapiController::validCustomer($request);
      if ($valid->msg !== null) {
        return $this->apiRsp(422, $valid->msg);
      }


      if ($store_mode) {
        $item = new Company();
        $item->created_by_id = $request->user()->id;
        $item->updated_by_id = $request->user()->id;
      } else {
        $item = Company::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $item->updated_by_id = $request->user()->id;
      }

      $payload = $request->all();
      $payload['logo_doc'] = $request->file('logo_doc');

      $item = Company::saveData($item, $payload);

      DB::commit();

      return $this->rsp(
        $store_mode ? 201 : 200,
        'Registro ' . ($store_mode ? 'agregado' : 'editado') . ' correctamente',
        $store_mode ? ['item' => ['id' => $item->id]] : null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  //COMPANY

  public function comapnyShow(Request $request) {
    try {
      $item = Company::getCompanyItem($request);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Registro retornado correctamente', [
        'item' => $item,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function companyStore(Request $request) {
    DB::beginTransaction();

    try {
      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      $valid = Company::validCompanyData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $valid = FacturapiController::validCustomer($request);
      if ($valid->msg !== null) {
        return $this->apiRsp(422, $valid->msg);
      }

      $item = Company::find((int) $company_user->company_id);

      if (is_null($item)) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      $request->fiscal_organization_id = $item->fiscal_organization_id;
      $facturapi = FacturapiController::storeOrganization($request);

      if (!$facturapi->status) {
        return $this->apiRsp(422, $facturapi->msg);
      }

      $payload = $request->all();
      $payload['fiscal_organization_id'] = $facturapi->fiscal_organization_id;
      $payload['logo_doc'] = $request->file('logo_doc');

      $item = Company::saveCompanyData($item, $payload);

      DB::commit();

      return $this->rsp(
        201,
        'Registro editado correctamente',
        ['item' => ['id' => $item->id]]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }

  public function certificatesStore(Request $request) {
    DB::beginTransaction();

    try {
      $company_user = CompanyUser::getFirstByUser($request->user()->id);

      $valid = Company::validCertificateData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }

      $item = Company::find((int) $company_user->company_id);

      if (is_null($item)) {
        DB::rollBack();
        return $this->rsp(404, 'Registro no encontrado');
      }

      if (is_null($item->fiscal_organization_id)) {
        DB::rollBack();
        return $this->rsp(404, 'No se han cargado sus datos fiscales');
      }

      $facturapi = FacturapiController::storeCertificationOrganization($request, $item->fiscal_organization_id);

      if (!$facturapi->status) {
        return $this->apiRsp(422, $facturapi->msg);
      }

      $item->fiscal_certificate_updated_at = $facturapi->fiscal_certificate_updated_at;
      $item->fiscal_certificate_expires_at = $facturapi->fiscal_certificate_expires_at;
      $item->fiscal_certificate_serial_number = $facturapi->fiscal_certificate_serial_number;

      $item->save();

      DB::commit();

      return $this->rsp(
        200,
        'Registro editado correctamente'
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}

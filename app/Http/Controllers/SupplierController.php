<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HasActiveToggle;
use App\Models\SupplierUser;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\UploadedFile;
use App\Models\BuyerUser;
use App\Models\Supplier;
use App\Models\SupplierCertification;
use App\Services\StorageMgrService;
use DB;
use Illuminate\Http\Request;
use Throwable;

class SupplierController extends Controller {
  use HasActiveToggle;

  /**
   * ===========================================
   * CRUD
   * ===========================================
   */
  public function index(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Supplier::getItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function show(Request $request) {
    try {
      $item = Supplier::getItem($request);

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
    return $this->setActive(Supplier::class, $id, $request, false);
  }

  public function activate(string $id, Request $request) {
    return $this->setActive(Supplier::class, $id, $request, true);
  }

  protected function storeUpdate(?string $id, Request $request) {
    DB::beginTransaction();
    $supplier = Supplier::getItem($request);
    $id = $supplier->id;

    try {
      $store_mode = is_null($id);

      $valid = Supplier::validData($request->all());
      if ($valid->fails()) {
        DB::rollBack();
        return $this->rsp(422, $valid->errors()->first(), null, $valid->errors()->toArray());
      }


      if ($store_mode) {
        $item = new Supplier();
        $item->created_by_id = $request->user()->id;
        $item->updated_by_id = $request->user()->id;
      } else {
        $item = Supplier::find((int) $id);

        if (is_null($item)) {
          DB::rollBack();
          return $this->rsp(404, 'Registro no encontrado');
        }

        $item->updated_by_id = $request->user()->id;
      }

      $payload = $request->all();
      $payload['logo_doc'] = $request->file('logo_doc');
      $payload['tax_certificate_doc'] = $request->file('tax_certificate_doc');
      $payload['positive_opinion_doc'] = $request->file('positive_opinion_doc');

      $item = Supplier::saveData($item, $payload);

      $supplier_certifications_data = json_decode($request->supplier_certifications);
      // $supplier_certifications_data = json_decode($supplier_certifications_data);

      SupplierCertification::deactivateBySupplier($item->id);

      foreach ($supplier_certifications_data as $key => $supplier_certification_data) {

        $supplier_certification = SupplierCertification::where('supplier_id', $item->id)
          ->where('certification_id', $supplier_certification_data->certification_id)
          ->first();

        if (!$supplier_certification) {
          $supplier_certification = new SupplierCertification;
        }

        $certification_doc = $request->file('certification_doc_' . $key);

        $supplier_certification->is_active = true;
        $supplier_certification->supplier_id = $item->id;
        $supplier_certification->certification_id = $supplier_certification_data->certification_id;

        $supplier_certification->certification_path = StorageMgrService::syncPath(
          $supplier_certification->certification_path,
          $certification_doc instanceof UploadedFile ? $certification_doc : null,
          'SupplierCertification'
        );


        $supplier_certification->save();
      }

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

  public function getMatchedBuyerAreas(Request $request) {
    try {
      $result = Supplier::getMatchedBuyerAreas($request);

      if (!$result['has_available_hours']) {
        return $this->rsp(200, 'Ya tienes tus horarios completos para este evento.', [
          'items' => [],
          'has_available_hours' => false,
        ]);
      }

      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => $result['items'],
        'has_available_hours' => true,
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function status(Request $request) {
    try {
      $supplier_user = SupplierUser::getFirstByUser($request->user()->id);
      $item = Supplier::find($supplier_user->supplier_id,['is_reviewed','reviewed_comment']);

      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }

      return $this->rsp(200, 'Estado del perfil', [
        'item' => $item,
      ]);

    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  //COMPANY

  public function CompanyIndex(Request $request) {
    try {
      return $this->rsp(200, 'Registros retornados correctamente', [
        'items' => Supplier::getNotReviewItems($request),
      ]);
    } catch (Throwable $err) {
      return $this->rsp(500, null, $err);
    }
  }

  public function CompanyShow(Request $request) {
    try {
      $item = Supplier::getNotReviewItem($request);

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

  public function validSupplier(Request $request) {
    DB::beginTransaction();

    try {
      $item = Supplier::find($request->supplier_id);
      if (is_null($item)) {
        return $this->rsp(404, 'Registro no encontrado');
      }
      $item->is_reviewed = $request->is_reviewed;
      $item->reviewed_by_id = $request->user()->id;
      $item->reviewed_at = date('Y-m-d H:i:s');
      $item->reviewed_comment = $request->reviewed_comment;
      $item->save();

      DB::afterCommit(function () use ($item) {
        $supplier_user = SupplierUser::where('supplier_id',$item->id)->first();
        $user = User::find($supplier_user->user_id);
        EmailService::ProfileStatus(
          [$user->email],
          [
            'is_reviewed' => $item->is_reviewed,
            'reviewed_comment' => $item->reviewed_comment,
          ]
        );
      });

      DB::commit();

      return $this->rsp(
        200,
        'Registro validado correctamente',
        null
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}

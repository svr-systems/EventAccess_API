<?php

namespace App\Http\Controllers;

use App\Models\PresentationTicket;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use App\Services\EmailService;
use App\Support\Input;
use DB;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class SaleController extends Controller {

  public function store(Request $request) {
    DB::beginTransaction();
    try {
      $item = new Sale();

      $item->user_id = Input::toId($request->user_id);
      $item->save();

      $amount = 0;
      $files = [];

      foreach ($request->presentation_tickets as $presentation_ticket) {
        $presentation_ticket_id = Input::toId(data_get($presentation_ticket, 'id'));


        $presentation_ticket_item = PresentationTicket::where('id', $presentation_ticket_id)
          ->lockForUpdate()
          ->first();

        if (!$presentation_ticket_item) {
          return $this->rsp(422, null, 'Tipo de boleto no encontrado');
        }

        if (!is_null($presentation_ticket_item->capacity) && $presentation_ticket_item->sold >= $presentation_ticket_item->capacity) {
          return $this->rsp(422, null, 'Boletos agotados');
        }

        for ($i = 0; $i < (int) $presentation_ticket['total']; $i++) {
          $sale_item = new SaleItem;
          $sale_item->sale_id = $item->id;
          $sale_item->presentation_ticket_id = $presentation_ticket_item->id;
          $sale_item->sale_item_status_id = 1;
          $sale_item->purchase_price = $presentation_ticket_item->price;

          $sale_item->save();

          $sale_item->ticket_code = 'TCK-' . str_pad($sale_item->id, 8, '0', STR_PAD_LEFT);
          $sale_item->save();

          $presentation_ticket_item->increment('sold');

          $amount += $presentation_ticket_item->price;
          $pdf = new PdfController;
          $pdf_name = $pdf->ticket($sale_item->id);

          $file = [
            'path' => $pdf_name,
            'name' => $sale_item->ticket_code . '.pdf',
            'mime' => 'application/pdf'
          ];

          array_push($files, $file);
        }
      }

      $item->amount = $amount;

      $item->save();

      $user = User::find($request->user_id);

      DB::afterCommit(function () use ($user, $files) {
        EmailService::tickets_purchased(
          [$user->email],
          [],
          $files
        );
      });

      DB::commit();

      return $this->rsp(
        200,
        'Compra registrada correctamente',
        ['item' => ['id' => $item->id]]
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}

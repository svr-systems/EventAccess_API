<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\TicketCheckin;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Throwable;

class TicketCheckinController extends Controller {

  /**
   * ===========================================
   * HELPERS
   * ===========================================
   */
  private function decryptId(string $token): ?string {
    try {
      $id = Crypt::decryptString($token);
      return $id;
    } catch (Throwable $err) {
      return null;
    }
  }

  public function store(Request $request) {
    DB::beginTransaction();

    try {
      $ticket_code = $this->decryptId($request->sale_item_id);

      if (!$ticket_code) {
        return $this->rsp(500, null, 'Este boleto no existe');
      }

      $ticket_sale_item = SaleItem::getItemByTicketCode($ticket_code, $request->user()->id);

      if (!$ticket_sale_item) {
        return $this->rsp(500, null, 'Este boleto no existe');
      }

      // if ($ticket_sale_item->date != now()->toDateString()) {
      //   return $this->rsp(500, null, 'El boleto no corresponde a la función de hoy');
      // }

      if(!$ticket_sale_item->is_checked_in){
        $ticket_checkin = new TicketCheckin;
        $ticket_checkin->created_by_id = $request->user()->id;
        $ticket_checkin->updated_by_id = $request->user()->id;
        $ticket_checkin->sale_item_id = $ticket_sale_item->id;
        $ticket_checkin->save();
      }

      DB::commit();

      return $this->rsp(
        200,
        'Boleto leído correctamente',
        $ticket_sale_item
      );
    } catch (Throwable $err) {
      DB::rollBack();
      return $this->rsp(500, null, $err);
    }
  }
}

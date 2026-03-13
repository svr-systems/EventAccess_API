<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class SaleItem extends Model {

  /**
   * ===========================================
   * CONVERSIONES DE TIPO
   * ===========================================
   */
  protected $casts = [
    'is_active' => 'boolean',
    'created_at' => 'datetime:Y-m-d H:i:s',
    'updated_at' => 'datetime:Y-m-d H:i:s'
  ];

  /**
   * ===========================================
   * RELACIONES
   * ===========================================
   */

  public function assistant(): BelongsTo {
    return $this->belongsTo(User::class, 'user_id');
  }

  public static function getItemByTicketCode($ticket_code, $user_id) {

    $items = self::query();

    $items->select([
      'sale_items.id',
      'sale_items.is_active',
      'sale_items.presentation_ticket_id',
      'sale_items.sale_item_status_id',
      'sale_items.purchase_price',
      'sale_items.ticket_code',
      'sales.user_id',
      DB::raw('IF(ticket_checkins.id IS NULL, 0, 1) as is_checked_in')
    ]);

    $items->join('presentation_tickets', 'presentation_tickets.id', '=', 'sale_items.presentation_ticket_id')
      ->join('presentation_dates', 'presentation_dates.id', '=', 'presentation_tickets.presentation_date_id')
      ->join('events', 'events.id', '=', 'presentation_dates.event_id')
      ->join('company_users', 'company_users.company_id', '=', 'events.company_id')
      ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
      ->join('users as assistants', 'assistants.id', '=', 'sales.user_id')
      ->leftJoin('ticket_checkins', 'ticket_checkins.sale_item_id', '=', 'sale_items.id');

    $items->where('sale_items.is_active', 1)->
      where('sale_items.ticket_code', $ticket_code)->
      where('sale_items.sale_item_status_id', 1)->
      where('company_users.user_id', $user_id);

    $items->with(['assistant:id,name,paternal_surname,maternal_surname']);

    return $items->first();
  }
}

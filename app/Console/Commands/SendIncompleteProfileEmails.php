<?php

namespace App\Console\Commands;

use App\Models\Buyer;
use App\Models\Supplier;
use App\Services\EmailService;
use Illuminate\Console\Command;

class SendIncompleteProfileEmails extends Command {
  protected $signature = 'profiles:send-incomplete-emails';

  protected $description = 'Envía correos a compradores y proveedores con perfil incompleto';

  public function handle(): int {
    $this->sendBuyerEmails();
    $this->sendSupplierEmails();

    return self::SUCCESS;
  }

  private function sendBuyerEmails(): void {
    $buyers = Buyer::query()
      ->select([
        'buyers.id',
        'buyers.name',
        'buyers.is_reviewed',
        'buyers.zip',
      ])
      ->with([
        'buyer_users' => function ($query) {
          $query->select([
            'buyer_users.id',
            'buyer_users.buyer_id',
            'buyer_users.user_id',
          ])
            // ->where('buyer_users.is_active', true)
            ->orderBy('buyer_users.id');
        },
        'buyer_users.user:id,email,name,paternal_surname,maternal_surname',
      ])
      ->where('buyers.is_active', true)
      ->whereNull('buyers.is_reviewed')
      ->whereNull('buyers.zip')
      ->get();

    foreach ($buyers as $buyer) {
      $buyer_user = $buyer->buyer_users->first();
      $user = $buyer_user?->user;

      if (!$user?->email) {
        continue;
      }

      EmailService::IncompleteProfile(
        [$user->email],
        [
          'profile_type' => 'comprador',
          'company_name' => $buyer->name,
          'user_name' => $user->full_name ?? $user->name,
        ]
      );
    }
  }

  private function sendSupplierEmails(): void {
    $suppliers = Supplier::query()
      ->select([
        'suppliers.id',
        'suppliers.name',
        'suppliers.is_reviewed',
        'suppliers.fiscal_regime_id',
      ])
      ->with([
        'supplier_users' => function ($query) {
          $query->select([
            'supplier_users.id',
            'supplier_users.supplier_id',
            'supplier_users.user_id',
          ])
            // ->where('supplier_users.is_active', true)
            ->orderBy('supplier_users.id');
        },
        'supplier_users.user:id,email,name,paternal_surname,maternal_surname',
      ])
      ->where('suppliers.is_active', true)
      ->whereNull('suppliers.is_reviewed')
      ->whereNull('suppliers.fiscal_regime_id')
      ->get();

    foreach ($suppliers as $supplier) {
      $supplier_user = $supplier->supplier_users->first();
      $user = $supplier_user?->user;

      if (!$user?->email) {
        continue;
      }

      EmailService::IncompleteProfile(
        [$user->email],
        [
          'profile_type' => 'proveedor',
          'company_name' => $supplier->name,
          'user_name' => $user->full_name ?? $user->name,
        ]
      );
    }
  }
}
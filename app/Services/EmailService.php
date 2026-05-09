<?php

namespace App\Services;

use App\Mail\GenMailable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class EmailService
{
  /**
   * ===========================================
   * USER EMAILS
   * ===========================================
   */
  public static function userAccountConfirmation(array $emails, array $data): void
  {
    $data['link'] = self::frontLinkWithEncryptedId('/confirmar-cuenta', (string) data_get($data, 'id'));
    self::send($emails, $data, 'Confirmar cuenta', 'UserAccountConfirmation');
  }

  public static function userAccountConfirm(array $emails, array $data): void
  {
    $email = (string) data_get($data, 'email', '');
    $data['link'] = self::frontLink('/iniciar-sesion', $email !== '' ? ['email' => $email] : []);
    self::send($emails, $data, 'Cuenta confirmada', 'UserAccountConfirm');
  }

  public static function userPasswordRecover(array $emails, array $data): void
  {
    $data['link'] = self::frontLinkWithEncryptedId('/restablecer-contrasena', (string) data_get($data, 'id'));
    self::send($emails, $data, 'Recuperación de contraseña', 'UserPasswordRecover');
  }

  public static function userPasswordReset(array $emails, array $data): void
  {
    $email = (string) data_get($data, 'email', '');
    $data['link'] = self::frontLink('/iniciar-sesion', $email !== '' ? ['email' => $email] : []);
    self::send($emails, $data, 'Contraseña restablecida', 'UserPasswordReset');
  }
  
  /**
   * ===========================================
   * TICKET EMAILS
   * ===========================================
   */
  public static function tickets_purchased(array $emails, array $data, array $files): void
  {
    // $data['link'] = self::frontLinkWithEncryptedId('/confirmar_cuenta', (string) data_get($data, 'id'));
    self::send($emails, $data, 'Boletos comprados', 'TicketsPurchased',$files);
  }

  /**
   * ===========================================
   * MEETING EMAILS
   * ===========================================
   */
  public static function MeetingConfirmed(array $emails, array $data): void
  {
    self::send($emails, $data, 'Confirmación de reunión', 'MeetingConfirmed');
  }
  public static function MeetingRejected(array $emails, array $data): void
  {
    self::send($emails, $data, 'Cancelación de reunión', 'MeetingRejected');
  }
  public static function MeetingSupplierRejected(array $emails, array $data): void
  {
    self::send($emails, $data, 'Cancelación de reunión', 'MeetingSupplierRejected');
  }
  public static function MeetingRequest(array $emails, array $data): void
  {
    self::send($emails, $data, 'Nueva de solicitud de reunión', 'MeetingRequest');
  }
  public static function MeetingRequestRejected(array $emails, array $data): void
  {
    self::send($emails, $data, 'Cancelación de solicitud de reunión', 'MeetingRequestRejected');
  }
  public static function ProfileStatus(array $emails, array $data): void
  {
    $subjet = "Perfil rechazado";
    if($data['is_reviewed']){
      $subjet = "Perfil aprobado";
    }
    self::send($emails, $data, $subjet, 'ProfileStatus');
  }

  /**
   * ===========================================
   * CORE
   * ===========================================
   */
  private static function send(array $emails, array $data, string $subject, string $view, array $files = []): void
  {
    $to_emails = self::resolveEmails($emails);

    foreach ($to_emails as $to) {
      Mail::to($to)->send(new GenMailable($data, $subject, $view,$files));
    }
  }

  private static function frontLink(string $path, array $query = []): string
  {
    $front_url = rtrim((string) config('app.front_url'), '/');
    $path = '/' . ltrim($path, '/');

    if (empty($query)) {
      return $front_url . $path;
    }

    return $front_url . $path . '?' . http_build_query($query);
  }

  private static function frontLinkWithEncryptedId(string $path, string $id): string
  {
    $token = Crypt::encryptString($id);
    return self::frontLink($path . '/' . $token);
  }

  private static function resolveEmails(array $emails): array
  {
    $is_debug = (bool) config('app.debug');
    $debug_to = trim((string) config('mail.debug_to', ''));

    if ($is_debug && $debug_to !== '') {
      return [$debug_to];
    }

    $out = [];

    foreach ($emails as $email) {
      $email = trim((string) $email);
      if ($email !== '') {
        $out[] = $email;
      }
    }

    return array_values(array_unique($out));
  }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenMailable extends Mailable {
  use Queueable, SerializesModels;

  public array $data;
  public string $mail_subject;
  public string $view_name;
  public array $files;

  public function __construct(array $data, string $subject, string $view, array $files = []) {
    $this->data = $data;
    $this->mail_subject = $subject;
    $this->view_name = $view;
    $this->files = $files;
  }

  public function build() {
    $mail = $this
      ->subject($this->mail_subject)
      ->view('email.' . $this->view_name, [
        'data' => $this->data,
      ]);

    foreach ($this->files as $file) {
      $mail->attach($file['path'], [
        'as' => $file['name'] ?? null,
        'mime' => $file['mime'] ?? null,
      ]);
    }

    return $mail;
  }
}

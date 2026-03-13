<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceAttachmentMailable extends Mailable {
  use Queueable, SerializesModels;

  public $data;
  public $subject;
  public $view;
  public $file_path_xml;
  public $file_path_pdf;

  public function __construct($data, $subject, $view, $file_path_xml, $file_path_pdf) {
    $this->data = $data;
    $this->subject = $subject;
    $this->view = $view;
    $this->file_path_xml = $file_path_xml;
    $this->file_path_pdf = $file_path_pdf;
  }

  public function build() {
    return $this->view('email.' . $this->view, [
      'data' => $this->data
    ]);
  }
  public function attachments(): array {
    return [
      Attachment::fromPath($this->file_path_xml),
      Attachment::fromPath($this->file_path_pdf),
    ];
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Event;
use App\Models\PaymentForm;
use App\Models\PresentationDate;
use App\Models\PresentationTicket;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Ticket;
use App\Models\User;
use Crypt;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Storage;

class PdfController extends Controller {
  private $fpdf;
  public function ticket($sale_item_id) {
    try {
      $sale_item = SaleItem::find($sale_item_id);
      $presentation_ticket = PresentationTicket::getItem($sale_item->presentation_ticket_id);
      $presentation_date = PresentationDate::find($presentation_ticket->presentation_date_id);
      $event = Event::find($presentation_date->event_id);
      $company = Company::find($event->company_id);
      $sale = Sale::find($sale_item->sale_id);
      $user = User::getItem($sale->user_id);
      // return $user;
      
      $this->fpdf = new Fpdf('P', 'mm', [110, 250]);
      $this->fpdf->SetAutoPageBreak(true, 6);
      $this->fpdf->SetMargins(5, 5, 5);
      $this->fpdf->AddPage();

      $this->fpdf->Ln(5);

      $this->fpdf->Line(10,35,100,35);
      $this->fpdf->Line(10,35,10,135);
      $this->fpdf->Line(10,135,100,135);
      $this->fpdf->Line(100,35,100,135);

      $logo_w = 50;
      $logo_h = 50;
      $logo_x = ($this->fpdf->GetPageWidth() - $logo_w) / 2;

      $this->fpdf->Image(
        Storage::disk('public')->path('logo.png'),
        $logo_x,
        $this->fpdf->GetY(),
        $logo_w,
        $logo_h,
        'png'
      );

      date_default_timezone_set("America/Mexico_City");
      setlocale(LC_TIME, 'es_MX.UTF-8');
      $date = strtotime($presentation_date->date);

      $this->fpdf->Ln(48);
      $this->pdfCenter('P R E S E N T A', 13);
      $this->fpdf->Ln(1);
      $this->pdfCenter($company->name, 18, 'times', 'B');
      $this->fpdf->Ln();
      $this->pdfCenter('DIRECCIÓN', 10);
      $this->fpdf->Ln(1);
      $this->pdfCenter($event->place_name, 12);
      $this->fpdf->Ln(1);
      $this->pdfCenter($event->address, 12);
      $this->fpdf->Ln();
      $this->pdfCenter('FECHA DEL EVENTO', 10);
      $this->fpdf->Ln(1);
      $this->pdfCenter(strftime('%A %e de %B de %Y', $date), 12);

      $this->fpdf->Ln();
      $this->pdfDoubleColumn('RECEPCIÓN', 'INICIAMOS', 10);
      $this->fpdf->Ln(4);
      $this->pdfDoubleColumn($this->time_to_text($presentation_date->reception_time), $this->time_to_text($presentation_date->start_time), 12);

      $this->fpdf->Ln(7);
      $this->pdfCenter('V E N   C O N   N O S O T R O S   A', 13);
      $this->fpdf->Ln(1);
      $this->pdfCenter($event->name, 15,'times','B');

      $this->fpdf->Line(10,140,100,140);
      $this->fpdf->Line(10,140,10,218);
      $this->fpdf->Line(10,218,100,218);
      $this->fpdf->Line(100,140,100,218);

      $this->fpdf->Line(3,3,107,3);
      $this->fpdf->Line(3,3,3,247);
      $this->fpdf->Line(3,247,107,247);
      $this->fpdf->Line(107,3,107,247);
      
      $this->fpdf->Ln(10);
      $this->pdfCenter('ACCESO AL PANEL', 13);

      $title = $sale_item->ticket_code;
      

      $folio_encrypted = Crypt::encryptString((string) $sale_item->ticket_code);

      $qr_name = 'user_qr_' . $title . '.png';
      $qr_path = Storage::disk('temp')->path($qr_name);

      \QrCode::format('png')
        ->size(512)
        ->generate($folio_encrypted, $qr_path);

      $qr_w = 60;
      $qr_x = ($this->fpdf->GetPageWidth() - $qr_w) / 2;

      $this->fpdf->Image($qr_path, $qr_x, $this->fpdf->GetY() + 3, $qr_w, 0, 'png');
      
      $this->fpdf->Ln(63);
      $this->pdfCenter('Escanee para acceder', 12);

      $this->fpdf->Ln(3);
      $this->pdfCenter('ASISTENTE:' . $user->full_name, 11);
      $this->fpdf->Ln(0);
      $this->pdfCenter('BOLETO:' . $sale_item->ticket_code, 11);

      $filename = public_path('..') . "/storage/app/private/temp/" . $title . ".pdf";
      $this->fpdf->Output($filename, 'F');
      $pdf = file_get_contents($filename);
      $pdf64 = base64_encode($pdf);

      // Storage::disk('temp')->delete($title . ".pdf");

      $data = new \stdClass;
      // $data->pdf64 = $pdf64;
      $data->path = $filename;

      return $filename;

      // return response($this->fpdf->Output('S'))
      //   ->header('Content-Type', 'application/pdf')
      //   ->header('Content-Disposition', 'inline; filename="' . $title . '.pdf"');

    } catch (\Throwable $th) {
      return response()->json([
        "success" => false,
        "message" => "ERR. " . $th
      ], 200);
    }
  }

  function time_to_text($time)
{
    return \Carbon\Carbon::parse($time)->format('g:i A');
}

  private function pdfCenter(string $text, int $size = 12, string $font = 'times', string $style = ''): void {
    $this->fpdf->SetFont($font, $style, $size);
    $this->fpdf->Cell(0, 5, utf8_decode($text), 0, 1, 'C');
  }

  private function pdfLeft(string $text, int $size = 12, string $font = 'times', string $style = ''): void {
    $this->fpdf->SetFont($font, $style, $size);
    $this->fpdf->Cell(0, 5, utf8_decode($text), 0, 1, 'L');
  }

  private function pdfDoubleColumn(string $label, string $value, int $size = 12, string $font = 'times', string $style = ''): void {
    $this->fpdf->SetFont($font, $style, $size);
    $half = ($this->fpdf->GetPageWidth())/2;
    $this->fpdf->SetX(0);
    $this->fpdf->Cell($half, 5, utf8_decode($label), 0, 0, 'C');
    $this->fpdf->Cell($half, 5, utf8_decode($value), 0, 0, 'C');
  }

  private function pdfKv(
    string $label,
    string $value,
    float $line_h = 6,
    int $label_size = 11,
    int $value_size = 11
  ): void {
    $this->fpdf->SetFont('times', 'B', $label_size);
    $this->fpdf->Cell(0, $line_h, utf8_decode($label), 0, 1, 'C');
    $this->fpdf->SetFont('times', '', $value_size);
    $this->fpdf->MultiCell(0, $line_h, utf8_decode($value), 0, 'C');
  }
}

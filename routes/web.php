<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('ticket', function () {
  $pdf = new PdfController;
  return $pdf->ticket(2);
});

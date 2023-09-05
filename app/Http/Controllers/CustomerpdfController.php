<?php

namespace App\Http\Controllers;

use App\Models\CustomPackage;
use App\Models\HotelCategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CustomerpdfController extends Controller
{
    public function pdf(CustomPackage $record){
        $pdf = Pdf::loadView('pdf.print',compact(['record']));
        return $pdf->download($record->customers->customer.'.pdf');
    }
    public function view(CustomPackage $record){
        return view('pdf.print',compact(['record']));
    }
}

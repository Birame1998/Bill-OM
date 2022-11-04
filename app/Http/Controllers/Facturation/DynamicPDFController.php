<?php

namespace App\Http\Controllers\Facturation;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Facturation\Facturation;

class DynamicPDFController extends Controller
{
    function index()
    {
     $customer_data = $this->get_customer_data();
     return view('Facturation.Facturation.dynamic_pdf')->with('customer_data', $customer_data);
    }

    function get_customer_data()
    {
     $customer_data =  Facturation::where("statut",2)->get();
     return $customer_data;
    }

    function pdf()
    {
    //  $pdf = \App::make('dompdf.wrapper');
    // $pdf->loadHTML($this->convert_customer_data_to_html());
    // //  return $pdf->stream();
    // return $pdf->download("eff.pdf");
    $facture =  Facturation::where("statut",2)->get();
    $data = [
        'title' => 'Welcome to Mywebtuts.com',
        'date' => date('m/d/Y'),
        'facture' => $facture
    ];

    $pdf = PDF::loadView('Facturation.Facturation.pdf', $data);
    return $pdf->download('mywebtuts.pdf');
    }

}

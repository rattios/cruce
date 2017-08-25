<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Fpdf;
use Mail;
use Session;
use Redirect;


class MailController extends Controller
{
    public function enviarMail(Request $request)
    {

        $aux = Mail::send('emails.contact', $request->all(), function ($msj) use ($request)
        {

             $pdf = new Fpdf();
        // Títulos de las columnas
        $header = array('N Interno', 'N Serie', 'Capacidad', 'Tipo','Manguera', 'Ruedas', 'Manometro', 'Etiquetas','Vencimientos', 'Accesibilidad', 'Baliza', 'Observaciones');
        
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://tecprecincsrl.com.ar/laravelAPI/api/public/inspecciones/reporte_email/'.$request->get('remito'),
            CURLOPT_USERAGENT => 'Codular Sample cURL Request'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        $vart=json_decode($resp);
        //print_r(($vart->inspecciones[0]));
        // Close request to clear up some resources
        $data =$vart->inspecciones;
         curl_close($curl);
         $pdf::AliasNbPages();
         $pdf::AddPage();
         // Logo
            $pdf::Image('http://tecprecincsrl.com.ar/inspecciones/assets/images/logos/logoSinFondo2.png',10,8,33);
            // Arial bold 15
            $pdf::SetFont('Times','B',15);
            // Movernos a la derecha
            
            $pdf::Cell(75);
            // Título
            $pdf::Cell(30,10,'REGISTRO OPERATIVO','C');
            $pdf::SetFont('Times','B',12);
            $pdf::Ln(5);
            $pdf::Cell(45);
            $pdf::Cell(30,10,'PLANTILLA DE CONTROL VISUAL DE EXTINTORES '. $data[0]->nom_empresa,'C');
            // Salto de línea
            $pdf::SetFont('Times','B',9);
            $pdf::Ln(20);
            $pdf::Cell(40,10,'EMPRESA: '. $data[0]->nom_empresa);
            $pdf::Ln();
            $pdf::Cell(40,10,'YACIMIENTO: '. $data[0]->yacimiento);
            $pdf::Ln();
            $pdf::Cell(40,10,'INSTALACION: '.$data[0]->nom_localidad);
            $pdf::Ln();
            $pdf::Cell(40,10,'FECHA: '.date("Y-m-d"));
            $pdf::Ln();

             $pdf::SetFont('Times','B',12);
            // Movernos a la derecha
            $pdf::Cell(75);
            // Título
            $pdf::Cell(30,10,'Remito/Comprobante de campo',0,0,'C');
            $pdf::Ln();
            $pdf::Cell(45);
            $pdf::Cell(90,10,$request->get('remito'),1,0,'C');
            $pdf::Ln(20);
         $pdf::SetFont('Times','',8);
         //$pdf::ImprovedTable($header,$data);
         $w = array(12, 12, 13, 23,12, 10, 14, 13,20, 16, 8, 42);
            // Cabeceras
            for($i=0;$i<count($header);$i++)
                $pdf::Cell($w[$i],7,$header[$i],1,0,'C');
            $pdf::Ln();
            // Datos
            $obs='';
            for ($i=0; $i < count($data); $i++)
            {
                $pdf::Cell($w[0],6,$data[$i]->interno,1,'LR');
                $pdf::Cell($w[1],6,$data[$i]->serie,1,'LR');
                $pdf::Cell($w[2],6,$data[$i]->capacidad,1,'LR');
                $pdf::Cell($w[3],6,$data[$i]->tipo,1,'LR');
                $pdf::Cell($w[4],6,$data[$i]->manguera,1,'LR');
                $pdf::Cell($w[5],6,$data[$i]->ruedas,1,'LR');
                $pdf::Cell($w[6],6,$data[$i]->manometro,1,'LR');
                $pdf::Cell($w[7],6,$data[$i]->etiquetas,1,'LR');
                $pdf::Cell($w[8],6,$data[$i]->vencimientos,1,'LR');
                $pdf::Cell($w[9],6,$data[$i]->accesibilidad,1,'LR');
                $pdf::Cell($w[10],6,$data[$i]->baliza,1,'LR');

                if ($data[$i]->manguera_observaciones!='') {
                    $obs.=' -'.$data[$i]->manguera_observaciones;
                }else if ($data[$i]->ruedas_observaciones!='') {
                    $obs.=' -'.$data[$i]->ruedas_observaciones;
                }else if ($data[$i]->manometro_observaciones!='') {
                    $obs.=' -'.$data[$i]->manometro_observaciones;
                }else if ($data[$i]->etiquetas_observaciones!='') {
                    $obs.=' -'.$data[$i]->etiquetas_observaciones;
                }else if ($data[$i]->vencimientos_observaciones!='') {
                    $obs.=' -'.$data[$i]->vencimientos_observaciones;
                }else if ($data[$i]->accesibilidad_observaciones!='') {
                    $obs.=' -'.$data[$i]->accesibilidad_observaciones;
                }else if ($data[$i]->baliza_observaciones!='') {
                    $obs.=' -'.$data[$i]->baliza_observaciones;
                }
                //$obs=wordwrap($obs, 5, "<br />\n");
                $pdf::MultiCell($w[11],6,$obs,1,'LR');
                // $this->Cell($w[11],6,$data[$i]->manguera_observaciones.' -'.$data[$i]->ruedas_observaciones.' -'.$data[$i]->manometro_observaciones.' -'.$data[$i]->etiquetas_observaciones.' -'.$data[$i]->vencimientos_observaciones.' -'.$data[$i]->accesibilidad_observaciones.' -'.$data[$i]->baliza_observaciones,'LR');

               // $this->Ln();
                 $obs='';
            }
            // Línea de cierre
            $pdf::Cell(array_sum($w),0,'','T');
            $pdf::Ln(20);
            $pdf::SetFont('Times','B',10);
            $pdf::Cell(40,10,'Control P/TEC-PRECINC: '. $data[0]->nombre);
            $pdf::Ln();
             // image
            //$pdf::Image($data[0]->firma,10,88,33);
            // Arial bold 15
         $file='Reporte.pdf';
         $pdf::Output($file,"f");


            $msj->subject('Reporte de inspeccion');
            $msj->to($request->get('correo'));
            $msj->attach($file);

        });

        return $aux;
    }
    
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SorteoWebController extends Controller
{
    public function getEmails()
    {
        $registros = \App\SorteoWeb::select('id', 'email', 'telefono')->get();

        $emails = []; 
        for ($i=0; $i < count($registros); $i++) { 
            if ($registros[$i]->email != null) {
                array_push($emails, $registros[$i]);
            }
        }

        $seleccionados = [];
        $seleccionados[0] = $emails[0];

        for ($i=1; $i < count($emails); $i++) { 
            $repetido = false;
            for ($j=0; $j < count($seleccionados); $j++) { 
                if($emails[$i]->email != null && ($emails[$i]->email == $seleccionados[$j]->email)){
                    $repetido = true;
                    break;
                }
            }

            if(!$repetido){
                array_push($seleccionados, $emails[$i]);
            }
        }

        //return $seleccionados;

        return response()->json([
            'count'=>count($seleccionados),
            'emails' => $seleccionados
        ],200);

    }

    public function getRegistros($email)
    {
        $registros = \App\SorteoWeb::where('email',$email)->orderBy('fecha', 'asc')->get();

        $emails = []; 
        for ($i=0; $i < count($registros); $i++) { 
            if ($registros[$i]->email != null) {
                array_push($emails, $registros[$i]);
            }
        }

        return response()->json([
            'count'=>count($emails),
            'emails' => $emails
        ],200);

    }

    public function getEmailsOrdenados()
    {
        /*$registros = \App\SorteoWeb::select('id', 'email', 'telefono', 'fecha')
                    ->orderBy('fecha', 'asc')->get();*/

        $registros = \App\Parse::select('id', 'email', 'telefono', 'createdAt')
                    ->orderBy('createdAt', 'asc')->get();

        return response()->json([
            'count'=>count($registros),
            'emails' => $registros
        ],200);
    }

    public function getTelefonos()
    {
        $registros = \App\SorteoWeb::select('id', 'email', 'usuario', 'dni', 'telefono')->get();

        $telefonos = []; 
        for ($i=0; $i < count($registros); $i++) { 
            if ($registros[$i]->telefono != null) {
                array_push($telefonos, $registros[$i]);
            }
        }

        $seleccionados = [];
        $seleccionados[0] = $telefonos[0];

        for ($i=1; $i < count($telefonos); $i++) { 
            $repetido = false;
            for ($j=0; $j < count($seleccionados); $j++) { 
                if($telefonos[$i]->telefono != null && (substr($telefonos[$i]->telefono,-4) == substr($seleccionados[$j]->telefono,-4))){
                    
                    $repetido = true;
                    break;
                }
            }

            if(!$repetido){
                array_push($seleccionados, $telefonos[$i]);
            }
        }

        //return $seleccionados;

        return response()->json([
            'count'=>count($seleccionados),
            'telefonos' => $seleccionados
         ],200);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ParseController extends Controller
{
    /*
    Funcion para llenar la tabla Messages
    con la data que viene en una peticion que 
    se hace ha:
    https://parseapi.back4app.com/classes/Messages
    */
    public function llenarTablaMessages()
    {
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://parseapi.back4app.com/classes/Messages?limit=900");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                   'X-Parse-Application-Id: Je0WGiqUlWkywilRqlBKPU2s3EwOLa6bozs2HoCv',
                                                   'X-Parse-REST-API-Key: S0FHUaPkFSha1hAAKJN5kMG6NK4tw31unMRwCYPn'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        //print($response); 
        //return $response;

        //$data = json_decode($response,true);     
        //print_r($data);

        $aux = json_decode($response); 

        $data = $aux->results;

        //return $data[0];
        //print_r($data[0]->file->name);

        //print($data);

        $count = 0;

        for ($i=0; $i < count($data); $i++)  
        {

            $count+=1;

            //Crear las variables en null
            $objectId= null;
            $fileType= null;
            $__type= null;
            $name= null;
            $url= null;
            $telefono= null;
            $recipientIds= null;
            $email= null;
            $recipientNames= null;
            $fileTime= null;
            $nombre= null;
            $descripcion= null;
            $createdAt= null;
            $updatedAt= null;

            //Setear las variables
            $objectId=$data[$i]->objectId;
           
            if ( property_exists($data[$i], 'fileType')) {
                $fileType=$data[$i]->fileType;
            } 
           
            if ( property_exists($data[$i], 'file')) {
                $__type=$data[$i]->file->__type;
                $name=$data[$i]->file->name;
                $url=$data[$i]->file->url; 
            } 

            if ( property_exists($data[$i], 'telefono')) {
                $telefono=$data[$i]->telefono;
            } 
            
            if ( property_exists($data[$i], 'recipientIds')) {
                $recipientIds=$data[$i]->recipientIds[0];
            } 

            if ( property_exists($data[$i], 'email')) {
                $email=$data[$i]->email;
            } 

            if ( property_exists($data[$i], 'recipientNames')) {
                $recipientNames=$data[$i]->recipientNames[0];
            } 

            if (property_exists($data[$i], 'fileTime')) {
                $fileTime=$data[$i]->fileTime;
             } 

            if ( property_exists($data[$i], 'nombre')) {
                $nombre=$data[$i]->nombre;
            } 

            if (property_exists($data[$i], 'descripcion')) {
                $descripcion=$data[$i]->descripcion;
            }  

            $createdAt=$data[$i]->createdAt;   
            $updatedAt=$data[$i]->updatedAt;
            
            //Crear el modelo
            $registro = new \App\Parse;

            //Asignar las variables al modelo
            if ($objectId) {
                $registro->objectId=$objectId;
            }
            if ($fileType) {
                $registro->fileType=$fileType;
            }
            if ($__type) {
                $registro->__type=$__type;
            }
            if ($name) {
                $registro->name=$name;
            }
            if ($url) {
                $registro->url=$url;
            }
            if ($telefono) {
                $registro->telefono=$telefono;
            }
            if ($recipientIds) {
                $registro->recipientIds=$recipientIds;
            }
            if ($email) {
                $registro->email=$email;
            }
            if ($recipientNames) {
                $registro->recipientNames=$recipientNames;
            }
            if ($fileTime) {
                $registro->fileTime=$fileTime;
            }
            if ($nombre) {
                $registro->nombre=$nombre;
            }
            if ($descripcion) {
                $registro->descripcion=$descripcion;
            }
            if ($createdAt) {
                $registro->createdAt=$createdAt;
            }
            if ($updatedAt) {
                $registro->updatedAt=$updatedAt;
            }

            //Insertar el registro en la BD
            //$registro->save();
        }

        return response()->json(['status' => 'ok',
         'count'=>$count],200);
    
             

    }

    public function getEmails()
    {
        $registros = \App\Parse::select('id', 'email', 'nombre', 'telefono')->get();

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
        $registros = \App\Parse::where('email',$email)->orderBy('createdAt', 'asc')->get();

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

    public function getTelefonos()
    {
        $registros = \App\Parse::select('id', 'email', 'nombre', 'telefono')->get();

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
                if($telefonos[$i]->telefono != null && (substr($telefonos[$i]->telefono,-7) == substr($seleccionados[$j]->telefono,-7))){
                    
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

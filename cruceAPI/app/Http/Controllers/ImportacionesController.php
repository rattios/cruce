<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ImportacionesController extends Controller
{

    public function index()
    {
    	$importaciones = \App\Importaciones::orderBy('fecha', 'desc')->get();
    	if(count($importaciones)>0){
    		return response()->json(['importaciones_mongo' => $importaciones],200);
    	}else if(count($importaciones)==0){
    		return response()->json(['error' => 'no existen datos en mongo'],404);
    	}else{
    		return response()->json(['error' => 'no existen datos en mongo'],404);
    	}

    	
    }
    public function get_for_id($id)
    {
    	$importaciones = \App\Parse::where('importaciones_id',$id)->orderBy('createdAt', 'desc')->get();

    	for ($i=0; $i <count($importaciones) ; $i++) { 
            $importaciones[$i]->fecha = $importaciones[$i]->createdAt;
            $importaciones[$i]->evento = 'Mongo Mensajes'; 
        }

    	return response()->json(['importaciones_mongo' => $importaciones],200);
    }

    public function import($fecha){

      if($fecha=='0000-00-00 00:00:00'){
      	$url='https://parseapi.back4app.com/classes/Messages?limit=1000';
      	//return $fecha;
      }else{
      	$t = date_create($fecha); 
        $t->setTimezone(new \DateTimeZone("UTC")); 
        $date= $t->format("Y-m-d\TH:i:s\Z"); 
        //return $date;
      	$url='https://parseapi.back4app.com/classes/Messages?limit=1000&where={"createdAt":{"$gt":{"__type":"Date","iso":"'.$date.'"}}}';
      }
    	
      
    	//return date_format(,"Y-m-d\TH:i:s\Z");
    	$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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

       $aux = json_decode($response); 

        $data = $aux->results;


        $count = 0;
        $nuevos_clientes=[];
        $ultima_fecha='';

        $importaciones = new \App\Importaciones;

	    $importaciones->nombre='Mongo messages';
	    $importaciones->fecha=date_create($data[count($data)-1]->createdAt);
	    $importaciones->cant=count($data);
	    if ($importaciones->save()) {

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
	                $ultima_fecha=$createdAt;
	            }
	            if ($updatedAt) {
	                $registro->updatedAt=$updatedAt;
	            }
	            $registro->importaciones_id=$importaciones->id;
	            //Insertar el registro en la BD
	            $registro->save();

				array_push($nuevos_clientes, (object) array("email"=>$email,"telefono"=>$telefono));
	        }
        }else{
	    	return response()->json(['error' => 'error al insertar en la tabla importaciones'],500);
	    }

        //-------------------------------------------------------------------------------------------------------

        $nuevos_insertados=[];
        for ($i=0; $i < count($nuevos_clientes); $i++) { 
        
	        $cliente = \App\Cliente::select('id', 'email')
	            ->where('email', $nuevos_clientes[$i]->email)->get();

	            //return $cliente;
	        //No existe
	        if (count($cliente)==0) {
	            //Crear el modelo
	            $registro = new \App\Cliente;

	            //Asignar las variables al modelo
	            $registro->email=$nuevos_clientes[$i]->email;

	            //$registro->telefono=$nuevos_clientes[$i]->telefono;

	            //Insertar el registro en la BD
	            if ($registro->save()) 
	            {
	               $registro2 = new \App\Cliente_Telefono;

	                //Asignar las variables al modelo
	                $registro2->cliente_id=$registro->id;
	                $registro2->telefono=$nuevos_clientes[$i]->telefono;
	               if ($registro2->save()) 
	               {
	               		array_push($nuevos_insertados, (object) array("email"=>$nuevos_clientes[$i]->email,"telefono"=>$nuevos_clientes[$i]->telefono));
	                    continue;
	                }else
	                    {
	                        continue;
	                    } 
	            }else
	                {
	                    continue;
	                } 
	        }
	        //Existe
	        else{

	            //Verificar si el telefono ya existe
	            $cliente_telefono = \App\Cliente_Telefono::select('telefono')
	            ->where('telefono', $nuevos_clientes[$i]->telefono)->get();

	            //El telefono ya existe y no se debe insertar
	            if(count($cliente_telefono)>0){
	                continue;
	            }else{

	            //Crear el modelo
	            $registro = new \App\Cliente_Telefono;

	            //Asignar las variables al modelo
	            $registro->cliente_id=$cliente[0]->id;
	            $registro->telefono=$nuevos_clientes[$i]->telefono;

	            //Insertar el registro en la BD
	            $registro->save();

	            continue;
	            }
	            
	        }
	    }


	    	$importaciones = \App\Importaciones::orderBy('fecha', 'desc')->get();
	        return response()->json(['status' => 'ok',
	        	'msg'=>'Importación realizada con éxito!',
	        	'nuevos_clientes' => $nuevos_clientes,
	        	'nuevos_insertados' => $nuevos_insertados,
	        	'count_insertados' => count($nuevos_insertados),
	        	'importaciones_mongo' => $importaciones,
	         	'count'=>$count],200);
	    


        


    }

}
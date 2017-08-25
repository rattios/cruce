<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{

    /*Retorna la lista de clietes, tabla clientes*/
    //
    public function listaClientes()
    {
        $clientes = \App\Cliente::get();

        return response()->json([
            'clientes' => $clientes
        ],200);
    }

    /*Funcion para crear la tabla clientes,
    con los registros de parse y de sorteo web*/
    public function clientes()
    {
        //Peticion 1
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cruceAPI/public/sorteo/web/emails");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $responseSorteoWebEmails = curl_exec($ch);
        curl_close($ch);

        $objSorteoWebEmails = json_decode($responseSorteoWebEmails); 

        $SorteoWebEmails = $objSorteoWebEmails->emails;

        //Peticion 2
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cruceAPI/public/parse/emails");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $responseParseEmails = curl_exec($ch);
        curl_close($ch);

        $objParseEmails = json_decode($responseParseEmails); 

        $ParseEmails = $objParseEmails->emails;

        //Arreglo final
        $clientes = $ParseEmails;

        for ($i=0; $i < count($SorteoWebEmails) ; $i++) { 
            $repetido = false;
            for ($j=0; $j < count($ParseEmails); $j++) { 
                if($ParseEmails[$j]->email == $SorteoWebEmails[$i]->email){
                    $repetido = true;
                    break;
                }
            }

            if(!$repetido){
                array_push($clientes, $SorteoWebEmails[$i]);
            }
        }

        /*return response()->json([
            'count'=>count($clientes),
            'emails' => $clientes
        ],200);*/

        $count = 0;

        for ($i=0; $i < count($clientes); $i++)  
        {

            $count+=1;

            //Crear las variables en null
            $nombre= null;
            $telefono= null;
            $email= null;
            $dni= null;
            
            //Setear las variables
            $email=$clientes[$i]->email;
           
            if ( property_exists($clientes[$i], 'telefono')) {
                $telefono=$clientes[$i]->telefono;
            }  

            if ( property_exists($clientes[$i], 'nombre')) {
                $nombre=$clientes[$i]->nombre;
            } 
            
            //Crear el modelo
            $registro = new \App\Cliente;

            //Asignar las variables al modelo
            if ($email) {
                $registro->email=$email;
            }
            

            //Insertar el registro en la BD
            //$registro->save();
        }

        return response()->json(['status' => 'ok',
         'count'=>$count],200);
    }

    public function cruceTelefonos()
    {
        //Peticion pricipal: Traer los clientes con sus telefonos
        $clientes = \App\Cliente::with('telefonos')->get();
        //$clientes = json_decode($clientes);

        //return $clientes;

       //Peticion 1
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cruceAPI/public/sorteo/web/telefonos");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $responseSorteoWebTelefonos = curl_exec($ch);
        curl_close($ch);

        $objSorteoWebTelefonos = json_decode($responseSorteoWebTelefonos); 

        $ParseTelefonos = $objSorteoWebTelefonos->telefonos;


        //Arreglo pre-final
        $clientes_telefonos = $ParseTelefonos;
        $repetidos = [];
        //return $ParseTelefonos; 
        for ($i=0; $i < count($ParseTelefonos) ; $i++) { 
            for ($j=0; $j < count($clientes); $j++) { 
                if (count($clientes[$j]->telefonos)>0){ 
                        if ($ParseTelefonos[$i]->email==$clientes[$j]->email) {
                            
                            if(!$this->registrar($ParseTelefonos[$i],$clientes[$j]->email)) {
                                     return 'error';
                                 }
                                 array_push($repetidos, $clientes[$j]->email);

                        }
                }else{
                    if ($ParseTelefonos[$i]->email==$clientes[$j]->email) {
                        if(!$this->registrar($ParseTelefonos[$i],$clientes[$j]->email)) {
                                         return 'error';
                        }
                    }
                }        
            }
        }

        return response()->json([
            'count-noRepetidos'=>count($clientes_telefonos),
            'telefonos' => $clientes_telefonos,
            'count-Repetidos'=>count($repetidos),
            'telefonos-repetidos' => $repetidos
        ],200);

    }

    public function getParticipaciones($email)
    {
        //Peticion 1
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cruceAPI/public/sorteo/web/registros/".$email);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $responseSorteoWebEmails = curl_exec($ch);
        curl_close($ch);

        $objSorteoWebEmails = json_decode($responseSorteoWebEmails); 

        $SorteoWebEmails = $objSorteoWebEmails->emails;

        //Peticion 2
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/cruceAPI/public/parse/registros/".$email);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $responseParseEmails = curl_exec($ch);
        curl_close($ch);

        $objParseEmails = json_decode($responseParseEmails); 

        $ParseEmails = $objParseEmails->emails;

        //Seleccionar los registros de la BD
        $Cleaned_members = DB::select("
            select
                *
            from
                cleaned_members
            where 
                Email = '".$email."'
             ORDER BY CONFIRM_TIME
                "
                );

        //return $Cleaned_members;

        //Seleccionar los registros de la BD
        $Subscribed_members = DB::select("
            select
                *
            from
                subscribed_members 
            where 
                Email = '".$email."'
             ORDER BY CONFIRM_TIME
                "
                );

        //Obj a retornar
        $participaciones = [];

        for ($i=0; $i <count($ParseEmails) ; $i++) { 
            $ParseEmails[$i]->fecha = $ParseEmails[$i]->createdAt;
            $ParseEmails[$i]->evento = 'Parse Mensajes'; 
            array_push($participaciones, $ParseEmails[$i]);
        }
        for ($i=0; $i <count($SorteoWebEmails) ; $i++) {
            $SorteoWebEmails[$i]->evento = 'Sorteo web'; 
            array_push($participaciones, $SorteoWebEmails[$i]);
        }
        for ($i=0; $i <count($Cleaned_members) ; $i++) { 
            $Cleaned_members[$i]->fecha = $Cleaned_members[$i]->CONFIRM_TIME;
            $Cleaned_members[$i]->evento = 'Cleaned members'; 
            array_push($participaciones, $Cleaned_members[$i]);
        }
        for ($i=0; $i <count($Subscribed_members) ; $i++) { 
            $Subscribed_members[$i]->fecha = $Subscribed_members[$i]->CONFIRM_TIME;
            $Subscribed_members[$i]->evento = 'Subscribed   members'; 
            array_push($participaciones, $Subscribed_members[$i]);
        }

        
        function cb($a, $b)
        {
            return strtotime($a->fecha)-strtotime($b->fecha);
        }

        usort($participaciones,function ($a, $b)
        {
            return strtotime($a->fecha)-strtotime($b->fecha);
        });

        return response()->json([
            'countParse'=>count($ParseEmails),
            'emailsParse' => $ParseEmails,
            'countSorteoWeb'=>count($SorteoWebEmails),
            'emailsSorteoWeb' => $SorteoWebEmails,
            'countParticipaciones'=>count($participaciones),
            'participaciones' => $participaciones,
        ],200);


        
    }

    /*Funcion para ordenar un array
    por el campo fecha*/
    public function cb($a, $b)
    {
        return strtotime($a->fecha)-strtotime($b->fecha);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $email = $request->input('email');
        $telefono = $request->input('telefono');

        if (!$email || !$telefono) {
            return response()->json(
                ['errors'=>array(['code'=>422,
                'message'=>'Faltan datos necesarios para el proceso de alta.'])],422);
        }

        //Verificar si el cliente ya existe
        $cliente = \App\Cliente::select('id', 'email')
            ->where('email', $email)->get();

            //return $cliente;
        //No existe
        if (count($cliente)==0) {
            //Crear el modelo
            $registro = new \App\Cliente;

            //Asignar las variables al modelo
            $registro->email=$email;

            $registro->telefono=$telefono;

            //Insertar el registro en la BD
            if ($registro->save()) 
            {
               $registro2 = new \App\Cliente_Telefono;

                //Asignar las variables al modelo
                $registro2->cliente_id=$registro->id;
                $registro2->telefono=$telefono;
               if ($registro2->save()) 
               {
                    return response()->json([
                                'status'=>'ok-1' 
                                ],200);
                }else
                    {
                        return response()->json([
                                'status'=>'else de relacion telefono' 
                                ],400);
                    } 
            }else
                {
                    return response()->json([
                                'status'=>'else cliente' 
                                ],400);
                } 
        }
        //Existe
        else{
            //Crear el modelo
            $registro = new \App\Cliente_Telefono;

            //Asignar las variables al modelo
            $registro->cliente_id=$cliente[0]->id;
            $registro->telefono=$telefono;

            //Insertar el registro en la BD
            $registro->save();

            return response()->json([
            'status'=>'ok-2'
            ],200);
            
        }   
         

    }

    /*Funcion para crear un cliente con su telefono*/
    public function registrar($obj,$email)
    {
       // $email = $obj->email;
        $telefono = $obj->telefono;

        //Verificar si el cliente ya existe
        $cliente = \App\Cliente::select('id', 'email')
            ->where('email', $email)->get();

            //return $cliente;
        //No existe
        if (count($cliente)==0) {
            //Crear el modelo
            $registro = new \App\Cliente;

            //Asignar las variables al modelo
            $registro->email=$email;

            $registro->telefono=$telefono;

            //Insertar el registro en la BD
            if ($registro->save()) 
            {
               $registro2 = new \App\Cliente_Telefono;

                //Asignar las variables al modelo
                $registro2->cliente_id=$registro->id;
                $registro2->telefono=$telefono;
               if ($registro2->save()) 
               {
                    return TRUE;
                }else
                    {
                        return FALSE;
                    } 
            }else
                {
                    return FALSE;
                } 
        }
        //Existe
        else{

            //Verificar si el telefono ya existe
            $cliente_telefono = \App\Cliente_Telefono::select('telefono')
            ->where('telefono', $telefono)->get();

            //El telefono ya existe y no se debe insertar
            if(count($cliente_telefono)>0){
                return TRUE;
            }

            //Crear el modelo
            $registro = new \App\Cliente_Telefono;

            //Asignar las variables al modelo
            $registro->cliente_id=$cliente[0]->id;
            $registro->telefono=$telefono;

            //Insertar el registro en la BD
            $registro->save();

            return TRUE;
            
        }   
    }

    /*Funcion para regitrar clientes que
    provienen de tablas que no tienen el
    campo telefono*/
    public function registarSinTelefono()
    {
        //Seleccionar los registros de la BD
        $registros = DB::select("
            select
                *
            from
                /*cleaned_members*/
                subscribed_members 
            where 
                1
                "
                );

        //return $registros;

        for ($i=0; $i <count($registros) ; $i++) { 

            //Verificar si el cliente ya existe
            $cliente = \App\Cliente::select('id', 'email')
                ->where('email', $registros[$i]->Email)->get();

            //No existe
            if (count($cliente)==0) {
                //Crear el modelo
                $registro = new \App\Cliente;

                //Asignar las variables al modelo
                $registro->email=$registros[$i]->Email;

                //Insertar el registro en la BD
                if ($registro->save()) 
                {

                    continue;

                }else
                    {
                        return response()->json([
                        'error'=>'Error al insertar',
                        'email'=>$registros[$i]->Email
                        ],200);
                } 
            }
        }

        return response()->json([
            'status'=>'ok'
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

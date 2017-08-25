<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Exception;

class InspectorController extends Controller
{

    /*Funcion para setear el campo resetter_app
     de todos los operadores,
     desde el panel una vez que se programa la
     inspeccion del mes.
    */
    public function setResetterAppPanel()
    {

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        foreach ($inspectores as $inspector) {

            $inspector->resetter_app=1;

            $inspector->save();
        }

        return response()->json(['status' => 'ok'],200);
    }

    /*Funcion para consultar el campo resetter_app
     asociado al operador $id_operador.
    Si resetter_app=1 se debe resetear la app.
    Si resetter_app=0 no se hace nada en la app.
    */
    public function getResetterApp($id_operador)
    {
        $aux = \App\TecUserInsp::select('resetter_app')
            ->where('uid', $id_operador)->get();

        $resetter_app = $aux[0]->resetter_app;

        return response()->json(['status'=>'ok',
            'resetter_app'=>$resetter_app], 200);
    }

    /*Funcion para setear el campo resetter_app
     asociado al operador $id_operador.
    */
    public function setResetterApp(Request $request, $id_operador)
    {
        $resetter_app = $request->input('resetter_app');

        if (!$resetter_app) {
            return response()->json(['error' => 'resetter_app absent'], 401);
        }

        $inspector = \App\TecUserInsp::where('uid', $id_operador)->get();

        if (!$inspector) {
            return response()->json(['error'=>'No existe un operador con ese id.',
                "id_operador" => $id_operador],404);
        }

        $inspector[0]->resetter_app = $resetter_app;

        $aux = $inspector[0];

        // Almacenamos en la base de datos el registro.
        if($aux->save()){
            return response()->json(['status'=>'ok'], 200);
        }else{
            return response()->json(['error'=>'No se pudo actualizar el campo resetter_app.'], 304);
        }
    }

    /*Funcion para verificar la valides de un token que se pasa en el request*/
    public function validarToken(Request $request)
    {

        try {
            $user = JWTAuth::toUser($request->input('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return 0;
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return 0;
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException){
                return 0;
            }else{
                return 0;
            }
        }

        return 1;
    }


    /*Funcion para actualizar el push del operador para las notificaciones*/
    public function actualizarPush(Request $request, $id_operador)
    {
        $push = $request->input('push');



        if (!$push) {
            return response()->json(['error' => 'push absent'], 401);
        }

        $inspector = \App\TecUserInsp::where('uid', $id_operador)->get();

        if (!$inspector) {
            return response()->json(['error'=>'No existe un operador con ese id.',
                "id_operador" => $id_operador],404);
        }

        $inspector[0]->push = $push;

        $aux = $inspector[0];

        // Almacenamos en la base de datos el registro.
        if($aux->save()){
            return response()->json(['status'=>'ok'], 200);
        }else{
            return response()->json(['error'=>'No se pudo actualizar el campo push.'], 304);
        }
    }

    public function sincronizar(Request $request, $id_operador)
    {     

        $uid_celular = $request->input('uid_celular');

        if (!$uid_celular) {
            return response()->json(['error' => 'uid_celular absent'], 401);
        }

        $inspector = null;

        $inspector = \App\TecUserInsp::select('uid_celular')->where('uid', $id_operador)->get();

        if($inspector[0]->uid_celular == null){
            return response()->json(['error' => 'Para poder ejecutar esta operación el identificador de tu teléfono debe estar asociado a tu perfil en Excalibur Inspecciones.'], 401);
        }
        if($inspector[0]->uid_celular != $uid_celular){
            return response()->json(['error' => 'El identificador de tu teléfono no coincide con el registrado en Excalibur Inspecciones'], 401);
        }

        $query = "
            SELECT 
            ins.id_inspeccion, e.id, e.serie,e.interno, e.anio,
            t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, em.nom_empresa,nom_localidad, e.id_yacimiento,y.yacimiento,
            e.id_ubicacion, e.ubicacion ubic1ext, e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento   
            FROM `tec_tipo_extintor` AS t, `tec_cap_extintor` AS c,
            tec_marca_extintor AS m, `tec_extintores` AS e
            LEFT OUTER JOIN `tec_empresas` AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN `tec_yacimientos` AS y ON e.id_yacimiento = y.id
            LEFT OUTER JOIN `tec_ubicacion` AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN `tec_localidad` AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN `view_extintor_ultimo_movimiento` AS vu ON ( e.id = vu.id_extintor )
            LEFT OUTER JOIN `insp_inspecciones` AS ins ON ( e.id = ins.id_extintor )
            WHERE
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            (ins.insp_estado='P' or ins.insp_estado = 'R') and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_operador = ";

        $inspecciones = DB::select($query.$id_operador);

        if (!$inspecciones) {
            return response()->json(['error'=>'El inspector no tiene inspecciones asignadas.',
                "id_operador" => $id_operador],404);
        }

        return response()->json(['status' => 'ok',
                                'inspecciones' => $inspecciones], 200);
    }

    public function ejecutarInsp(Request $request, $id_inspeccion)
    {

        $uid_celular = $request->input('uid_celular');

        if (!$uid_celular) {
            return response()->json(['error' => 'uid_celular absent'], 401);
        }

        $inspeccion = \App\InspInspeccion::
        find($id_inspeccion);

        if (!$inspeccion) {
            return response()->json(['error'=>'No se encuntra una inspeccion con ese codigo',
                'id_inspeccion' => $id_inspeccion],404);
        }

        $inspector = \App\TecUserInsp::select('uid_celular')->where('uid', $inspeccion->id_operador)->get();

        if($inspector[0]->uid_celular == null){
            return response()->json(['error' => 'Para poder ejecutar esta operación el identificador de tu teléfono debe estar asociado a tu perfil en Excalibur Inspecciones.'], 401);
        }
        if($inspector[0]->uid_celular != $uid_celular){
            return response()->json(['error' => 'El identificador de tu teléfono no coincide con el registrado en Excalibur Inspecciones'], 401);
        }

        

        $detalleInsp = \App\InspDetalleInspeccion::
        find($id_inspeccion);

        //$timestamp = strftime( "%Y-%m-%d-%H-%M-%S", time() );

        if ($detalleInsp) {
            return response()->json(['error'=>'La inseccion ya está en el servidor',
                'id_inspeccion' => $id_inspeccion],200);
        }

        // Listado de campos recibidos teóricamente.
        $fecha_insp=$request->input('fecha_insp');
        $fecha_envio=$request->input('fecha_envio');
        $insp_remito=$request->input('insp_remito');

        $manguera=$request->input('manguera');
        $manguera_observaciones=$request->input('manguera_observaciones');
        $ruedas=$request->input('ruedas');
        $ruedas_observaciones=$request->input('ruedas_observaciones');
        $manometro=$request->input('manometro');
        $manometro_observaciones=$request->input('manometro_observaciones');
        $etiquetas=$request->input('etiquetas');
        $etiquetas_observaciones=$request->input('etiquetas_observaciones');
        $vencimientos=$request->input('vencimientos');
        $vencimientos_observaciones=$request->input('vencimientos_observaciones');
        $accesibilidad=$request->input('accesibilidad');
        $accesibilidad_observaciones=$request->input('accesibilidad_observaciones');
        $baliza=$request->input('baliza');
        $baliza_observaciones=$request->input('baliza_observaciones');
        $imagen=$request->input('imagen');
        $lat=$request->input('lat');
        $lng=$request->input('lng');


        $inspeccion->insp_estado = 'E';
        $inspeccion->fecha_insp = $fecha_insp;
        $inspeccion->fecha_envio = $fecha_envio;
        $inspeccion->insp_remito = $insp_remito;

        // Almacenamos en la base de datos el registro.
        $inspeccion->save();
        

        $detalleInspeccion = new \App\InspDetalleInspeccion;

        $detalleInspeccion->id_inspeccion = $id_inspeccion;

        $detalleInspeccion->manguera = $manguera;

        $detalleInspeccion->manguera_observaciones = $manguera_observaciones;

        $detalleInspeccion->ruedas = $ruedas;

        $detalleInspeccion->ruedas_observaciones = $ruedas_observaciones;

        $detalleInspeccion->manometro = $manometro;

        $detalleInspeccion->manometro_observaciones = $manometro_observaciones;

        $detalleInspeccion->etiquetas = $etiquetas;

        $detalleInspeccion->etiquetas_observaciones = $etiquetas_observaciones;

        $detalleInspeccion->vencimientos = $vencimientos;

        $detalleInspeccion->vencimientos_observaciones = $vencimientos_observaciones;

        $detalleInspeccion->accesibilidad = $accesibilidad;

        $detalleInspeccion->accesibilidad_observaciones = $accesibilidad_observaciones;

        $detalleInspeccion->baliza = $baliza;

        $detalleInspeccion->baliza_observaciones = $baliza_observaciones;

        $detalleInspeccion->imagen = $imagen;

        $detalleInspeccion->lat = $lat;

        $detalleInspeccion->lng = $lng;

        // Almacenamos en la base de datos el registro.
        if($detalleInspeccion->save()){
            return response()->json(['status'=>'ok'], 200);
        }else{
            return response()->json(['error'=>'No se pudo guardar la inspeccion.'], 304);
        }      
    }

    /*Retorna el estado actual de la inspeccion con el id 
    que se pasa como parametro*/
    public function getEstadoInsp($id_inspeccion)
    {
        $inspeccion = \App\InspInspeccion::
                    select('id_inspeccion','insp_estado','id_operador')
                    ->where('id_inspeccion', $id_inspeccion)->get();

        if (count($inspeccion) == 0) {
            return response()->json(['error'=>'No se encuntra una inspección con ese código.',
                "id_inspeccion" => $id_inspeccion],404);
        }

        return response()->json(['status' => 'ok',
                                'inspeccion' => $inspeccion], 200);
    }

}

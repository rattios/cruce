<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{

    //Las inspecciones tendrán estado  Pendiente , Ejecutado , Anulado , Bloqueado

    //-------------------------------
    //2* Buscar nuevos extintores para agregar a la agenda, insertarlos en la
    // agenda en estado pendiente.
     
    //Query búsqueda de extintores para realizar inspección, extintores con 3
    // meses de mantenimiento,
        
    //revisar que no exista una inspección si ya existió una de menos de 3 meses
    //  para los extintores nuevos
    //** el query tendrá una clausula extra que verifique si la empresa está activa
    public function agendarInspecciones()
    {   
        //Verifica si la inspeccion para el periodo(mes) actual ya esta programada,
        //no permite agendar nuevas inspecciones.
        $ultimaInsp = DB::select("SELECT insp_periodo FROM insp_inspecciones WHERE
         id_inspeccion = (SELECT MAX(id_inspeccion) FROM insp_inspecciones)
          AND insp_periodo = MONTH(now())");

        if ($ultimaInsp) {
                //la inspeccion ya esta programada
                return 'insp_ya_programada';
        }

        //Seleccionar los programas de las 4 empresas
        $prog_empresa_ySur = DB::select("
            select
                programa
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = 80"
                );
        

        $prog_empresa_ypfRdls = DB::select("
            select
                programa
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = 241"
                );
        

        $prog_empresa_ypfSaCiph = DB::select("
            select
                programa
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = 77"
                );
          


        $prog_empresa_ypfSaUnng = DB::select("
            select
                programa
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = 1"
                ); 


        
        if (!$prog_empresa_ySur || !$prog_empresa_ypfRdls || !$prog_empresa_ypfSaCiph || !$prog_empresa_ypfSaUnng ) {
            //falta generar uno o varios programas anuales
            return 'falta_programa';
            /*return response()->json([
                'error'=>'Debe generar los programas anuales de todas las empresas.'
                ],404);*/
        }

        $programa1 = json_decode($prog_empresa_ySur[0]->programa);
        $programa2 = json_decode($prog_empresa_ypfRdls[0]->programa);
        $programa3 = json_decode($prog_empresa_ypfSaCiph[0]->programa);
        $programa4 = json_decode($prog_empresa_ypfSaUnng[0]->programa);       

        set_time_limit(300);

        //Seleccionar las inspecciones que quedaron resagadas (P o R o bl) del periodo(mes) anterior.
        $extintoresResagados = DB::select("
            SELECT insps.id_extintor, insps.insp_optativa
            FROM insp_inspecciones AS insps 
            WHERE insps.insp_periodo =
                (SELECT insp_periodo FROM insp_inspecciones
                WHERE id_inspeccion =
                    (SELECT MAX(id_inspeccion) FROM insp_inspecciones))
            AND insps.insp_anio = 
                (SELECT insp_anio FROM insp_inspecciones
                WHERE id_inspeccion =
                    (SELECT MAX(id_inspeccion) FROM insp_inspecciones))
            AND (insps.insp_estado = 'P' or insps.insp_estado = 'R' or insps.insp_estado = 'bl')
        ");


        //mes actual
        $periodo_actual = date("m");

        //extintores para inspeccionar
        $extintores = [];
        
        //Recorro los 4 programas para seleccionar los
        //extintores(id) que le corresponde inspeccion
        for ($i=0; $i < count($programa1); $i++) { 
        
            if($programa1[$i]->I1->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa1[$i]->id,'insp_optativa' => $programa1[$i]->I1->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa1[$i]->I2->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa1[$i]->id,'insp_optativa' => $programa1[$i]->I2->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa1[$i]->I3->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa1[$i]->id,'insp_optativa' => $programa1[$i]->I3->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa1[$i]->I4->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa1[$i]->id,'insp_optativa' => $programa1[$i]->I4->i_optativa);
                array_push($extintores, $extintor);
            }
        }

        for ($i=0; $i < count($programa2); $i++) { 
        
            if($programa2[$i]->I1->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa2[$i]->id,'insp_optativa' => $programa2[$i]->I1->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa2[$i]->I2->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa2[$i]->id,'insp_optativa' => $programa2[$i]->I2->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa2[$i]->I3->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa2[$i]->id,'insp_optativa' => $programa2[$i]->I3->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa2[$i]->I4->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa2[$i]->id,'insp_optativa' => $programa2[$i]->I4->i_optativa);
                array_push($extintores, $extintor);
            }
        }

        for ($i=0; $i < count($programa3); $i++) { 
        
            if($programa3[$i]->I1->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa3[$i]->id,'insp_optativa' => $programa3[$i]->I1->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa3[$i]->I2->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa3[$i]->id,'insp_optativa' => $programa3[$i]->I2->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa3[$i]->I3->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa3[$i]->id,'insp_optativa' => $programa3[$i]->I3->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa3[$i]->I4->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa3[$i]->id,'insp_optativa' => $programa3[$i]->I4->i_optativa);
                array_push($extintores, $extintor);
            }
        }

        for ($i=0; $i < count($programa4); $i++) { 
        
            if($programa4[$i]->I1->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa4[$i]->id,'insp_optativa' => $programa4[$i]->I1->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa4[$i]->I2->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa4[$i]->id,'insp_optativa' => $programa4[$i]->I2->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa4[$i]->I3->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa4[$i]->id,'insp_optativa' => $programa4[$i]->I3->i_optativa);
                array_push($extintores, $extintor);
            }
            else if($programa4[$i]->I4->i_periodo == $periodo_actual){
                $extintor = (object) array('id_extintor' => $programa4[$i]->id,'insp_optativa' => $programa4[$i]->I4->i_optativa);
                array_push($extintores, $extintor);
            }
        }

        /*Nota: Esto ya no es necesario porque las inspecciones que quedaron
        resagadas se van a insertar como bl (bloqueadas)*/
        //Recorro los extintores resagados y sino esta en la nueva 
        //lista de inspecciones, lo inserto
        /*$enLista = false;
        for ($i=0; $i < count($extintoresResagados) ; $i++) { 
            for ($j=0; $j < count($extintores) ; $j++) { 
                if ($extintoresResagados[$i]->id_extintor == $extintores[$j]->id_extintor) {
                    $enLista = true;
                    break;
                }
            }

            if(!$enLista){
                array_push($extintores, $extintoresResagados[$i]);
            }else{
                $enLista = false;
            }
        }*/

        /*insert en la tabla insp_inspecciones, es autoincremental automático
         el id_inspeccion solo insertamos el id del extintor, el query 
         anterior es para referencia de los datos que van a ser necesario
         asociar para en la app.*/

        /*foreach ($extintores as $extintor) {
            $inspeccion = new \App\InspInspeccion;

            $inspeccion->id_extintor = $extintor->id;
            $inspeccion->insp_estado = 'P';

            $inspeccion->save();
        }*/

        //echo json_encode($extintores);

        $insp_anio = date("Y");
        $insp_periodo = date("m");

        //$nuevasIspecciones = count($extintores);

        set_time_limit(300);

        //Insertar las nuevas inspecciones.
        foreach ($extintores as $extintor) {
            DB::table('insp_inspecciones')->insert([
                'insp_anio'=> $insp_anio,
                'insp_periodo'=> $insp_periodo,
                'id_extintor' => $extintor->id_extintor,
                'insp_optativa' => $extintor->insp_optativa,
                'insp_estado' => 'P',
                ]);
        }

        set_time_limit(300);

        //Marcar las resagadas, si las hay.
        /*if($extintoresResagados){
          foreach ($extintoresResagados as $resagada) {
            DB::table('insp_inspecciones')
                ->where('id_extintor', '=', $resagada->id_extintor)
                ->where('insp_anio', '=', $insp_anio)
                ->where('insp_periodo', '=', $insp_periodo)
                ->update(['insp_estado' => 'R']);
            }  
        }*/

        //Insertar las resagadas, si las hay.
        if($extintoresResagados){
          foreach ($extintoresResagados as $resagada) {
            DB::table('insp_inspecciones')->insert([
                'insp_anio'=> $insp_anio,
                'insp_periodo'=> $insp_periodo,
                'id_extintor' => $resagada->id_extintor,
                'insp_optativa' => $resagada->insp_optativa,
                'insp_estado' => 'bl',
                ]);
            }  
        }

        

        //return response()->json(['status' => 'ok', 'nuevasIspecciones' => $nuevasIspecciones],200);
        //return response()->json(['status' => 'ok'],200);
        return 'insp_lista';
    }

//NO ESTA EN USO
//-------------------------------
    //1* Validacion Inspecciones Pendientes
    //anular inspecciones pendientes de la tabla insp_inspecciones
    //que no son necesarias por tener modificado el periodo de mantenimiento.
//NO ESTA EN USO
    public function validarInspPendientes(){
        //$raw1 = DB::raw('DATE_FORMAT(view_prueba_ext_ult_mov.ultimo_mov,"%Y%m")');

        //$raw2 = DB::raw('DATE_FORMAT(STR_TO_DATE(CONCAT(insp_anio,insp_periodo),"%Y%m"),"%Y%m")');

        /*$inspinspecciones = \App\InspInspeccion::select('id_inspeccion')
            ->leftJoin('view_prueba_ext_ult_mov',  
                'insp_inspecciones.id_extintor', '=', 'view_prueba_ext_ult_mov.id_extintor')
            ->where('insp_estado', '=', 'P')
            ->where($raw1, '>', $raw2)
            ->where('view_prueba_ext_ult_mov.tipo_mov', '=', 'man')
            //->get();
            ->update(['insp_estado' => 'A']);*/

        set_time_limit(300);

        $inspinspecciones = DB::select("
            select id_inspeccion from insp_inspecciones as ins
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu
            ON ( ins.id_extintor = vu.id_extintor )
            where (ins.insp_estado = 'P' or ins.insp_estado = 'R') 
            and ins.insp_periodo = MONTH(now())
            and DATE_FORMAT(vu.ultimo_mov,'%Y%m') >=
            DATE_FORMAT(STR_TO_DATE(CONCAT(insp_anio,insp_periodo),'%Y%m'),'%Y%m')
            and vu.tipo_mov='man'
            ");

        //set_time_limit(60);

        /*foreach ($inspinspecciones as $inspinspeccion) {
            DB::table('insp_inspecciones')
                ->where('id_inspeccion', '=', $inspinspeccion->id_inspeccion)
                ->update(['insp_estado' => 'A']);
        }*/

        //return response()->json(['status' => 'ok'],200);
        return true;
    }

    //Bloquear las inspecciones de las empresas inactivas
    public function bloquearInspEmpInactivas(){

        $inspinspecciones = DB::select("select id_inspeccion 
            from  insp_inspecciones as  ins, tec_extintores AS e
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            where (ins.insp_estado = 'P' or ins.insp_estado = 'R')
            and ins.insp_anio = YEAR(now()) 
            and ins.insp_periodo = MONTH(now()) 
            and ins.id_extintor=e.id
            and em.estado=0");

        set_time_limit(300);

        foreach ($inspinspecciones as $inspinspeccion) {
            DB::table('insp_inspecciones')
                ->where('id_inspeccion', $inspinspeccion->id_inspeccion)
                ->update(['insp_estado' => 'B']);
        }

        //return response()->json(['status' => 'ok'],200);
        return true;

    }

    //Programa la inspeccion para el mes(periodo actual)
    public function programarInspeccion(){
        $aux = $this->agendarInspecciones();

        if ($aux == 'insp_lista') {
                if ($this->bloquearInspEmpInactivas()) {

                    return response()->json(['status' => 'ok'],200);
                }
        }
        else if($aux == 'insp_ya_programada'){
            return response()->json(['status' => 'ok-2', 'msg'=>'La inspección para este periodo ya está programada.'],200);
        }
        else if($aux == 'falta_programa'){
            return response()->json([
                'error'=>'Debe generar los programas anuales de todas las empresas.'
                ],404);
        }
    }

    //Retorna todos los inspectores
    public function inspectores(){

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        $users = DB::select(
            "SELECT uid, user FROM tecprecinc_user_insp WHERE uid = ANY 
            (SELECT uid FROM tec_user_insp WHERE tipo_user = 'o')"
            );

        return response()->json(['status' => 'ok',
                                'inspectores'=> $inspectores, 'users'=> $users], 200);
    }

    //Retorna el inspector que se pasa como parametro
    public function inspector($id_operador){
        $inspector = \App\TecUserInsp::find($id_operador);

        if (!$inspector) {
            return response()->json(['error'=>'No se encuntra un operario con ese código.',
                "id_operador" => $id_operador],404);
        }

        $user = \App\Tec_user::select('user')->where('uid', $id_operador)->get();

        return response()->json(['status' => 'ok',
                                'inspector'=>$inspector, 'user'=>$user], 200);
    }

    //Edita el inspector que se para como parametro
    public function editarInspector(Request $request, $id_operador){

        $inspector = \App\TecUserInsp::find($id_operador);

        if (!$inspector) {
            return response()->json(['error'=>'No se encuntra un operario con ese código.',
                "id_operador" => $id_operador],404);
        }

        // Listado de campos recibidos teóricamente.
        $nombre=$request->input('nombre');
        $telefono=$request->input('telefono');
        $uid_celular=$request->input('uid_celular');
        $correo=$request->input('correo');
        $firma=$request->input('firma');

        /*if($nombre){
            $inspector->nombre = $nombre;
        }
        if ($telefono) {
            $inspector->telefono = $telefono;
        }
        if ($uid_celular) {
            $inspector->uid_celular = $uid_celular;
        }*/
        $inspector->nombre = $nombre;
        $inspector->telefono = $telefono;
        $inspector->uid_celular = $uid_celular;
        $inspector->correo = $correo;
        if ($firma) {
           $inspector->firma = $firma;
        }
        
        $inspector->save();
            return response()->json(['status'=>'ok','inspector'=>$inspector], 200);

    }

    //Retorna el numero de inspecciones resagadas del periodo anterior
    public function inspResagadas(Request $request){

        // Listado de campos recibidos teóricamente.
        $insp_anio = $request->input('insp_anio');
        $insp_periodo = $request->input('insp_periodo');

        if (!$insp_anio || !$insp_periodo)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan valores para completar el procesamiento.'],422);
        }

        $inspResagadas = DB::select("
            select count(id_inspeccion) contador
            from insp_inspecciones
            where 
            insp_anio = ".$insp_anio." and
            insp_periodo = ".$insp_periodo." and
            (insp_estado = 'P' or insp_estado = 'R' or
            insp_estado = 'bl')

                ");

        return response()->json(['status' => 'ok',
                                'inspResagadas'=>$inspResagadas  ], 200);
    }

//NO ESTA EN USO
    //Retorna las inpecciones que ya no corresponden por haber 
    //tenido un mantenimiento
    public function inspParaAnular()
    {
        //set_time_limit(60);

        //Seleccionar las inspecciones candidatas a anular.
        $inspParaAnular = DB::select("
            select ins.id_inspeccion from insp_inspecciones as ins
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( ins.id_extintor = vu.id_extintor )
            where (ins.insp_estado = 'P' or ins.insp_estado = 'R' or ins.insp_estado = 'bl')
            and ins.insp_anio = YEAR(now()) 
            and ins.insp_periodo = MONTH(now())
            and DATE_FORMAT(vu.ultimo_mov,'%Y%m') >=
            DATE_FORMAT(STR_TO_DATE(CONCAT(insp_anio,insp_periodo),'%Y%m'),'%Y%m')
            and vu.tipo_mov='man'
            ");

        return response()->json(['status' => 'ok',
                                 'inspParaAnular'=>$inspParaAnular], 200);
    }

    //Retorna todas la inspecciones del mes(periodo) actual
    //para pintar la consola 
    public function consola(){
        $inspPeriodoActual = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado <> 'A' and
            ins.insp_estado <> 'an' and
            ins.insp_estado <> 'B'
                ");

        if (!$inspPeriodoActual) {
            return response()->json(['error'=>'No se ha programado la inspección para este periodo.'],404);
        }

        return response()->json(['status' => 'ok',
                                'inspPeriodoActual'=>$inspPeriodoActual], 200);

    }

//NO ESTA EN USO
    //Retorna las inspecciones anuladas del periodo actual y las que ya no 
    //corresponden por haber tenido manteniento
    public function listaAnuladasYparaAnular(){

        set_time_limit(300);

        $inspPeriodoActual = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio,
            e.id, e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado <> 'B'
                ");

        if (!$inspPeriodoActual) {
            return response()->json(['error'=>'No se ha programado la inspección para este periodo.'],404);
        }

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        //Seleccionar las inspecciones candidatas a anular.
        $inspParaAnular = DB::select("
            select ins.id_inspeccion from insp_inspecciones as ins
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( ins.id_extintor = vu.id_extintor )
            where (ins.insp_estado = 'P' or ins.insp_estado = 'R' or ins.insp_estado = 'bl')
            and ins.insp_anio = YEAR(now()) 
            and ins.insp_periodo = MONTH(now())
            and DATE_FORMAT(vu.ultimo_mov,'%Y%m') >=
            DATE_FORMAT(STR_TO_DATE(CONCAT(insp_anio,insp_periodo),'%Y%m'),'%Y%m')
            and vu.tipo_mov='man'
            ");



        return response()->json(['status' => 'ok',
                                'inspPeriodoActual'=>$inspPeriodoActual,
                                 'inspParaAnular'=>$inspParaAnular,
                                 'inspectores'=>$inspectores], 200);

    }


    //Retorna las inspecciones bloqueadas del periodo actual
    public function listaBloqueadas(){

        set_time_limit(300);

        $inspBloqueadas = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado = 'bl'
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspBloqueadas) {
            return response()->json(['error'=>'No hay inspecciones bloqueadas.'],404);
        }


        return response()->json(['status' => 'ok',
                                'inspBloqueadas'=>$inspBloqueadas], 200);

    }

    //Retorna las inspecciones anuladas del periodo actual
    public function listaAnuladas(){

        set_time_limit(300);

        $inspAnuladas = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            (ins.insp_estado = 'A' or ins.insp_estado = 'an')
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspAnuladas) {
            return response()->json(['error'=>'No hay inspecciones anuladas.'],404);
        }


        return response()->json(['status' => 'ok',
                                'inspAnuladas'=>$inspAnuladas], 200);

    }

    //Retorna todas la inspecciones pendientes, ejecutadas y bloqueadas del mes(periodo) actual
    //para pintar las inspecciones en curso
    public function listaInspPeriodoActual(){

        set_time_limit(300);

        $inspPeriodoActual = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado <> 'A' and
            ins.insp_estado <> 'B'
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspPeriodoActual) {
            return response()->json(['error'=>'No se ha programado la inspección para este periodo.'],404);
        }

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();


        /*Prueba de hacer el tratamiento del objeto antes de enviarlo al front*/
        /*for ($i = 0; $i < count($inspPeriodoActual); $i++) {
            $inspPeriodoActual[$i]->check=false;
            $inspPeriodoActual[$i]->showPendiente=false;
            $inspPeriodoActual[$i]->showBloqueadoAnulado=false;
            $inspPeriodoActual[$i]->showEjecutado=false;
            $inspPeriodoActual[$i]->operador=null;

            if ($inspPeriodoActual[$i]->insp_estado == 'P' || $inspPeriodoActual[$i]->insp_estado == 'R') {
                $inspPeriodoActual[$i]->showPendiente=true;
            }
            else if ($inspPeriodoActual[$i]->insp_estado == 'bl' || $inspPeriodoActual[$i]->insp_estado == 'an') {
                $inspPeriodoActual[$i]->showBloqueadoAnulado=true;
            }
            else if ($inspPeriodoActual[$i]->insp_estado == 'E') {
                $inspPeriodoActual[$i]->showEjecutado=true;
            }

            //Agregar el estilo a las optativas
            if(vm.employees[i].insp_optativa == 1){
                vm.employees[i].estilo = $scope.conEstilo;
            }

            for ($j = 0; $j <count($inspectores); $j++) {
                if ($inspPeriodoActual[$i]->id_operador == $inspectores[$j]->uid) {
                    if($inspectores[$j]->nombre == null){
                        $inspPeriodoActual[$i]->operador=$inspectores[$j]->uid;
                    }else{
                        $inspPeriodoActual[$i]->operador=$inspectores[$j]->nombre;
                    }
                    
                }
            }

        }*/

        return response()->json(['status' => 'ok',
                                'inspPeriodoActual'=>$inspPeriodoActual,
                                 'inspectores'=>$inspectores], 200);

    }


    //Retorna todas la inspecciones no asignadas del mes(periodo) actual
    //menos las bloqueadas
    public function listaInspNoAsignadas(){

        $inspNoAsignadas = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.id_operador IS NULL and
            ins.insp_estado <> 'A' and
            ins.insp_estado <> 'bl' and
            ins.id_extintor=e.id
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspNoAsignadas) {
            return response()->json(['error'=>'No hay inspecciones para asignar.'],404);
        }

        return response()->json(['status' => 'ok',
                                'inspNoAsignadas'=>$inspNoAsignadas], 200);

    }

   //Retorna todas la inspecciones asignadas del mes(periodo) actual
    public function listaInspEnCampo(){

        $inspEnCampo = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            (ins.insp_estado = 'P' or ins.insp_estado = 'R') and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspEnCampo) {
            return response()->json(['error'=>'No hay inspecciones en campo.'],404);
        }

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();


        return response()->json(['status' => 'ok',
                                'inspEnCampo'=>$inspEnCampo,
                                'inspectores'=>$inspectores], 200);

    }

   //Retorna todas la inspecciones ejecutadas del mes(periodo) actual
    public function listaInspEjecutadas(){

        $inspEjecutadas = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id
            ORDER BY y.yacimiento, ubic1ext, capacidad
                ");

        if (!$inspEjecutadas) {
            return response()->json(['error'=>'No hay inspecciones ejecutadas.'],404);
        }

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        return response()->json(['status' => 'ok',
                                'inspEjecutadas'=>$inspEjecutadas,
                                'inspectores'=>$inspectores], 200);

    }

    /*Funcion para discriminar cuantas inspecciones tiene un inspector en su agenda
    bien sea, ejecutadas o por ejecutar*/
    public function vistaAgenda(){
        $inspPeriodoActual = DB::select("
            select 
            ins.id_inspeccion, 
            ins.id_operador,
            ins.insp_estado
            from
            insp_inspecciones as ins
            where 
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado <> 'A' and
            ins.insp_estado <> 'B'
                ");

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        $users = DB::select(
            "SELECT uid, user FROM tecprecinc_user_insp WHERE uid = ANY 
            (SELECT uid FROM tec_user_insp WHERE tipo_user = 'o')"
            );
        
        if (!$inspPeriodoActual) {
            return response()->json(['inspectores'=>$inspectores, 'users'=>$users],404);
        }

        return response()->json(['status' => 'ok',
                                'inspPeriodoActual'=>$inspPeriodoActual,
                                 'inspectores'=>$inspectores, 'users'=>$users], 200);

    }

    /*Retorna la agneda actual de un inspector,
    bien sea inspecciones que ha ejecutado y que
    le faltan por ejecutar*/
    public function agendaDeInspector($id_operador){

        //Tres posibles formas de recuperar los parametros que bienen en una peticion:
        //$id_operador = $request->input('id_operador');
        //$id_operador = $request->id_operador;
        //$id_operador = $request->get('id_operador');

        $query = "
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            /*vu.tipo_mov='man' and
            vu.ultimo_mov is null and */
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado <> 'A' and
            ins.insp_estado <> 'B' and
            ins.id_extintor=e.id and
            ins.id_operador = ";

        $agendaInspector = DB::select($query.$id_operador." ORDER BY y.yacimiento, ubic1ext, capacidad");

        if (!$agendaInspector) {
            return response()->json(['error'=>'El operario no tiene inspecciones asignadas.',
                "id_operador" => $id_operador],404);
        }

        return response()->json(['status' => 'ok',
                                'agendaInspector' => $agendaInspector], 200);

    }

    public function historialCalendarioDeInspector($id_operador){

        // Listado de campos recibidos teóricamente.
        //$id_operador = $request->input('id_operador');
        //$id_operador = $request->id_operador;
        //$id_operador = $request->get('id_operador');

        $query = "
            select ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, em.nom_empresa,l.nom_localidad,
            y.yacimiento, e.ubicacion ubic1ext, e.referencia, u.ubicacion ubic2ext 
            from insp_inspecciones as ins, tec_extintores AS e
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado  = 'E' and
            ins.id_extintor=e.id and
            ins.id_operador = ";

        $historialCalendarioInspector = DB::select($query.$id_operador);

        if (!$historialCalendarioInspector) {
            return response()->json(['error'=>'El operario no tiene historial.',
                "id_operador" => $id_operador],404);
        }


        return response()->json(['status' => 'ok',
                                'historialCalendarioInspector' => $historialCalendarioInspector], 200);

    }

    public function historialLineaTiempoDeInspector($id_operador){

        // Listado de campos recibidos teóricamente.
        //$id_operador = $request->input('id_operador');
        //$id_operador = $request->id_operador;
        //$id_operador = $request->get('id_operador');

        $query = "
            select
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_remito,
            em.nom_empresa,l.nom_localidad,
            y.yacimiento, e.ubicacion ubic1ext, e.referencia, e.serie, e.interno, t.tipo,
            c.capacidad, u.ubicacion ubic2ext,
            d.manguera,
            d.manguera_observaciones,
            d.ruedas,
            d.ruedas_observaciones,
            d.manometro,
            d.manometro_observaciones,
            d.etiquetas,
            d.etiquetas_observaciones,
            d.vencimientos,
            d.vencimientos_observaciones,
            d.accesibilidad,
            d.accesibilidad_observaciones,
            d.baliza,
            d.baliza_observaciones,
            d.imagen
            from tec_tipo_extintor AS t, tec_cap_extintor AS c,
            insp_inspecciones as ins, insp_detalle_inspecciones as d, tec_extintores AS e

            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )

            where e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado  = 'E' and
            ins.id_extintor=e.id and
            ins.id_inspeccion = d.id_inspeccion and
            ins.id_operador = ";

        $lineaTiempo = DB::select($query.$id_operador." ORDER BY ins.fecha_insp");

        if (!$lineaTiempo) {
            return response()->json(['error'=>'El operario no ha ejecutado inspecciones.',
                "id_operador" => $id_operador],404);
        }


        return response()->json(['status' => 'ok',
                                'lineaTiempo' => $lineaTiempo], 200);        

    }

    public function detalleDeInsp($id_inspeccion)
    {
        $inspeccion = \App\InspInspeccion::with('detalleinspeccion')
        ->find($id_inspeccion);

        if (!$inspeccion) {
            return response()->json(['error'=>'No se encuntra una inspeccion con ese código.',
                "id_inspeccion" => $id_inspeccion],404);
        }

        if (!($detalleInspeccion = \App\InspInspeccion::find($id_inspeccion)->detalleinspeccion))
         {
            return response()->json(['error'=>'No se encuntran detalles para esta inspeccion.',
                "id_inspeccion" => $id_inspeccion],404);
        }

        //$inspector = \App\TecUserInsp::find($inspeccion->id_operador);
        $inspector = \App\TecUserInsp::select('uid','nombre')->where('uid', $inspeccion->id_operador)->get();

        //$aux = $inspeccion->toArray();

        return response()->json(['status' => 'ok',
                                'inspeccion' => $inspeccion, 'inspector'=>$inspector], 200);
    }

    public function asignarInspeccion(Request $request, $id_inspeccion){

        // Comprobamos si la inspeccion que nos están pasando existe o no.
        $inspeccion=\App\InspInspeccion::find($id_inspeccion);

        // Si no existe esa inspeccion devolvemos un error.
        if (!$inspeccion)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['error'=>'No se encuentra una inspeccion con ese código.'],404);
        }   

        // Listado de campos recibidos teóricamente.
        $id_operador = $request->input('id_operador');

        if (!$id_operador)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan valores para completar el procesamiento.'],422);
        }

        $inspeccion->id_operador = $id_operador;

        // Almacenamos en la base de datos el registro.
        $inspeccion->save();
        return response()->json(['status'=>'ok','inspeccion'=>$inspeccion], 200);

    }

    //Pone en estado de P o R la inspeccion que se pasa como parametro
    public function activarInspeccion($id_inspeccion){

        // Comprobamos si la inspeccion que nos están pasando existe o no.
        $inspeccion=\App\InspInspeccion::find($id_inspeccion);

        // Si no existe esa inspeccion devolvemos un error.
        if (!$inspeccion)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['error'=>'No se encuentra una inspeccion con ese código.'],404);
        }   

        //Anio y periodo actual
        $insp_anio = date("Y");
        $insp_periodo = date("m");

        if ($insp_periodo == 1) {
            $insp_anio_anterior = $insp_anio - 1;
            $insp_periodo_anterior = 12;
        }else{
            $insp_anio_anterior = $insp_anio;
            $insp_periodo_anterior = $insp_periodo - 1;
        }

        $extintor = $inspeccion->id_extintor;

        $inspeccion_anterior=\App\InspInspeccion::
        where('insp_anio', $insp_anio_anterior)
        ->where('insp_periodo', $insp_periodo_anterior)
        ->where('id_extintor', $extintor)
        ->get();

        //saco el numero de elementos
        $longitud = count($inspeccion_anterior);

        //Si no estaba en el periodo anterior
        if($longitud == 0){
            $inspeccion->insp_estado = 'P';

            // Almacenamos en la base de datos el registro.
            $inspeccion->save();
            return response()->json(['status'=>'ok','data'=>$inspeccion_anterior], 200);
        }
        //si estaba en el perido anterior
        else {
            $inspeccion->insp_estado = 'R';

            // Almacenamos en la base de datos el registro.
            $inspeccion->save();
            return response()->json(['status'=>'ok','data'=>$inspeccion_anterior], 200);
        }



        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$insp_estado)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan valores para completar el procesamiento.'],422);
        }

        $inspeccion->insp_estado = $insp_estado;

        // Almacenamos en la base de datos el registro.
        $inspeccion->save();
        return response()->json(['status'=>'ok','data'=>$inspeccion], 200);

    }

    public function modificarEstado(Request $request, $id_inspeccion){

        // Comprobamos si la inspeccion que nos están pasando existe o no.
        $inspeccion=\App\InspInspeccion::find($id_inspeccion);

        // Si no existe esa inspeccion devolvemos un error.
        if (!$inspeccion)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['error'=>'No se encuentra una inspeccion con ese código.'],404);
        }   

        // Listado de campos recibidos teóricamente.
        $insp_estado = $request->input('insp_estado');

        if (!$insp_estado)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan valores para completar el procesamiento.'],422);
        }

        $inspeccion->insp_estado = $insp_estado;

        // Almacenamos en la base de datos el registro.
        $inspeccion->save();
        return response()->json(['status'=>'ok','data'=>$inspeccion], 200);

    }

    /*Se usa cuando se asigna
        cuando se reasigna
        cuando se bloquea o se anula una inspeccion asignada
        */
    public function modificarEstadoV2(Request $request, $id_inspeccion){

        // Comprobamos si la inspeccion que nos están pasando existe o no.
        $inspeccion=\App\InspInspeccion::find($id_inspeccion);

        // Si no existe esa inspeccion devolvemos un error.
        if (!$inspeccion)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
            // En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
            return response()->json(['error'=>'No se encuentra una inspeccion con ese código.'],404);
        }   

        // Listado de campos recibidos teóricamente.
        $insp_estado = $request->input('insp_estado');
        $id_operador = $request->input('id_operador');

        if (!$insp_estado)
        {
            // Se devuelve un array errors con los errores encontrados y cabecera HTTP 422 Unprocessable Entity – [Entidad improcesable] Utilizada para errores de validación.
            return response()->json(['error'=>'Faltan valores para completar el procesamiento.'],422);
        }

        /*Para no tomar en cuenta el estado cuando
        se eliminan inspecciones de una agenda*/
        if ($insp_estado != 'F') {
            $inspeccion->insp_estado =$insp_estado;
        } 
        $inspeccion->id_operador =$id_operador;       

        // Almacenamos en la base de datos el registro.
        $inspeccion->save();
        return response()->json(['status'=>'ok','data'=>$inspeccion], 200);

    }

    public function editarDetalleDeInsp(Request $request, $id_inspeccion)
    {
        $detalleInspeccion = \App\InspInspeccion::
        find($id_inspeccion)->detalleinspeccion;

        if (!$detalleInspeccion) {
            return response()->json(['error'=>'No se encuntran detalles para la inspeccion.',
                'id_inspeccion' => $id_inspeccion],404);
        }


        // Listado de campos recibidos teóricamente.
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
        $lat=$request->input('lat');
        $lng=$request->input('lng');
        
        // Actualización de campos.
        
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
         
            $detalleInspeccion->lat = $lat;
        
            $detalleInspeccion->lng = $lng;
               
            // Almacenamos en la base de datos el registro.
            $detalleInspeccion->save();
            return response()->json(['status'=>'ok','detalleInspeccion'=>$detalleInspeccion], 200);
       
    }

//NO ESTA EN USO
    public function listaEmpresasActivas()
    {
        

        $empresasActivas = DB::select("
            SELECT
            em.id, em.nom_empresa, em.particular, em.cuit,
            em.email, em.telefono, em.estado
            FROM `tec_empresas` AS em
            WHERE em.estado = 1
            AND (em.id = 1 or em.id = 77 or em.id = 80 or em.id = 241)
            ");
        
        return response()->json(['status' => 'ok',
                                'empresasActivas'=>$empresasActivas], 200);
    }

    /*Retorna la data necesaria para generar el programa anual de la empresa 
    que se pasa como parametro.*/
    public function dataProgramaAnual($id_empresa)
    {
        set_time_limit(300);

        //verifico si ya se creo el programa para esa empresa
        $programaAnual = DB::select("
            select
                id
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = ".$id_empresa
                );


        if($programaAnual){
            return response()->json(['status' => 'ok-2'], 200);
        }
        

        /*Seleccion de los extintores nuevos, agregados el anio pasado
        unidos con los mateniminetos del año pasado de los extintores
        de la empresa $id_empresa*/
        $man_anio_pasado = DB::select("
            SELECT
            e.id, e.serie,e.interno, e.anio, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, em.nom_empresa,nom_localidad, e.id_yacimiento,y.yacimiento,
            e.id_ubicacion, e.ubicacion ubic1ext, e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov 
            FROM
            `tec_tipo_extintor` AS t, `tec_cap_extintor` AS c, `tec_marca_extintor` AS m, `tec_extintores` AS e
            LEFT OUTER JOIN `tec_empresas` AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN `tec_yacimientos` AS y ON e.id_yacimiento = y.id
            LEFT OUTER JOIN `tec_ubicacion` AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN `tec_localidad` AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN `view_prueba_ext_ult_mov` AS vu ON ( e.id = vu.id_extintor )
            WHERE e.id_marca = m.id 
            and e.id_capacidad = c.id
            AND e.tipo = t.id     
            and vu.tipo_mov='man'
            and vu.ultimo_mov is null
            and YEAR(e.fecha) = YEAR(now()) - 1
            AND e.id_empresa = ".$id_empresa."   

            union

            SELECT
            e.id, e.serie,e.interno, e.anio, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, em.nom_empresa,nom_localidad, e.id_yacimiento,y.yacimiento,
            e.id_ubicacion, e.ubicacion ubic1ext, e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov 
            FROM
            `tec_tipo_extintor` AS t, `tec_cap_extintor` AS c, `tec_marca_extintor` AS m, `tec_extintores` AS e
            LEFT OUTER JOIN `tec_empresas` AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN `tec_yacimientos` AS y ON e.id_yacimiento = y.id
            LEFT OUTER JOIN `tec_ubicacion` AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN `tec_localidad` AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN `view_prueba_ext_ult_mov` AS vu ON ( e.id = vu.id_extintor )
            WHERE e.id_marca = m.id 
            and e.id_capacidad = c.id
            AND e.tipo = t.id     
            and vu.tipo_mov='man'
            and YEAR(vu.ultimo_mov) = YEAR(now()) - 1
            AND e.id_empresa = ".$id_empresa.
            " ORDER BY yacimiento, ubic1ext , capacidad"    
            );

        return response()->json(['status' => 'ok',
                'man_anio_pasado'=>$man_anio_pasado], 200);
        

    }

    /*Guarda el programa que se genera en el front con la data enviada con el metodo
    anterio (dataProgramaAnual)*/
    public function guardarProgramaAnual(Request $request,$id_empresa)
    {

        $anio = date("Y");
        $programa = $request->input('programa');

        set_time_limit(300);

        DB::table('insp_programa_anual')->insert([
            'anio'=> $anio,
            'id_empresa'=>$id_empresa,
            'programa'=>$programa
            ]);

        return response()->json(['status' => 'ok'], 200);
 
    }

    /*guarda los cambios que hace el supervisor al programa de la empresa $id_empresa*/
    public function actualizarProgramaAnual(Request $request,$id_empresa)
    {
        $id_programa = $request->input('id_programa');
        $programa = $request->input('programa');

        DB::table('insp_programa_anual')
                ->where('id', $id_programa)
                ->where('id_empresa', $id_empresa)
                ->update(['programa' => $programa]);

        return response()->json(['status' => 'ok'], 200);
    }

    /*Retorna el programa anual del anio actual*/
    public function leerProgramaAnual($id_empresa)
    {
        set_time_limit(300);

        $programaAnual = DB::select("
            select
                id, anio, id_empresa, programa
            from
                insp_programa_anual 
            where 
            anio = YEAR(now())
            and id_empresa = ".$id_empresa
                );

        if (!$programaAnual) {
            return response()->json(['error'=>'Esta empresa no tiene un programa anual generado.',
                "id_empresa" => $id_empresa],404);
        }

        /*Seleccion de las inspecciones del anio actual*/
        $insp_anio_actual = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa,
            e.id, e.serie,e.interno, t.tipo, CAST(c.capacidad AS DECIMAL(10,2)) AS capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov Ult_mantenimiento
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN view_prueba_ext_ult_mov AS vu ON ( e.id = vu.id_extintor )
            where 
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.id_extintor=e.id and
            ins.insp_anio = YEAR(now()) and
            e.id_empresa = ".$id_empresa.
            " ORDER BY ins.insp_periodo, y.yacimiento, ubic1ext, capacidad"
                );

        $inspectores = \App\TecUserInsp::where('tipo_user', 'o')->get();

        return response()->json(['status' => 'ok',
                                'programaAnual'=>$programaAnual,
                                'insp_anio_actual'=>$insp_anio_actual,
                                'inspectores'=>$inspectores], 200);
 
    }

    //retorna los extintores nuevos de la empresa id_empresa
    //NOTA: VERIFICAR ESTA CONSULTA
    public function extintoresNuevos($id_empresa)
    {

        $extNuevos = DB::select("SELECT
            e.id, e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio, em.nom_empresa,nom_localidad, e.id_yacimiento,y.yacimiento,
            e.id_ubicacion, e.ubicacion ubic1ext, e.referencia, u.ubicacion ubic2ext,
            vu.ultimo_mov 
            FROM
            `tec_tipo_extintor` AS t, `tec_cap_extintor` AS c, `tec_marca_extintor` AS m, `tec_extintores` AS e
            LEFT OUTER JOIN `tec_empresas` AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN `tec_yacimientos` AS y ON e.id_yacimiento = y.id
            LEFT OUTER JOIN `tec_ubicacion` AS u ON ( e.id_ubicacion = u.id )
            LEFT OUTER JOIN `tec_localidad` AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN `view_prueba_ext_ult_mov` AS vu ON ( e.id = vu.id_extintor )
            WHERE e.id_marca = m.id 
            and e.id_capacidad = c.id
            AND e.tipo = t.id     
            and vu.tipo_mov='man'
            and vu.ultimo_mov is null
            and YEAR(e.fecha) = YEAR(now())
            AND e.id_empresa = ".$id_empresa."    
            ORDER BY e.id");

        return response()->json(['status' => 'ok',
                                'extNuevos'=>$extNuevos,
                                ], 200);
    }


    /*public function reportes()
    {
        //Seleccionar las inspecciones ejecutadas para generar los reportes
        $inspecciones = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.insp_estado,ins.id_operador,ins.fecha_envio, ins.insp_optativa, ins.insp_remito,
            e.id, e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext, m.marca,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            d.manguera, d.manguera_observaciones,
            d.ruedas, d.ruedas_observaciones,
            d.manometro, d.manometro_observaciones,
            d.etiquetas, d.etiquetas_observaciones,
            d.vencimientos, d.vencimientos_observaciones,
            d.accesibilidad, d.accesibilidad_observaciones,
            d.baliza, d.baliza_observaciones,
            user.uid, user.nombre
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_marca_extintor AS m,
            insp_detalle_inspecciones AS d,
            tec_user_insp AS user, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where
            ins.id_inspeccion = d.id_inspeccion and
            ins.id_operador = user.uid and
            e.id_marca = m.id and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id");

        if (!$inspecciones) {
            return response()->json(['error'=>'No hay reportes para mostrar.'],404);
        }

        return response()->json(['status' => 'ok',
                                'inspecciones'=>$inspecciones], 200);
    }
*/

    /*Retorna los reportes que se pueden generar*/
    public function reportes()
    {
        //Seleccionar las inspecciones ejecutadas para generar los reportes
        $inspecciones = DB::select("
            select 
            ins.id_inspeccion, ins.id_extintor, ins.id_operador, ins.insp_remito,
            e.id_empresa, e.anio, em.nom_empresa,
            l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            u.ubicacion ubic2ext,
            user.uid, user.nombre
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c,
            tec_user_insp AS user, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where
            ins.id_operador = user.uid and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id");

        if (!$inspecciones) {
            return response()->json(['error'=>'No hay reportes para mostrar.'],404);
        }

        $reportes = [];
        $reportes[0] = $inspecciones[0];

        $reportes[0]->contExtintores = 0; //Cantidad de extintores por remito

        //Recorro las inspecciones y selecciono las no repetidas(remito)
        //y las inserto en el array reportes
        for ($i=1; $i < count($inspecciones); $i++) { 
            $repetido = false;
            for ($j=0; $j < count($reportes); $j++) { 
                if($inspecciones[$i]->insp_remito == $reportes[$j]->insp_remito){
                    $repetido = true;
                    break;
                }
            }

            if(!$repetido){
                array_push($reportes, $inspecciones[$i]);
                $aux = count($reportes) - 1;
                $reportes[$aux]->contExtintores = 0;
            }
        }

        //recorro el array de reportes para contar 
        //el numero de extintores por remito
        for ($i=0; $i < count($reportes); $i++) { 
            for ($j=0; $j < count($inspecciones); $j++) { 
                if($inspecciones[$j]->insp_remito == $reportes[$i]->insp_remito){
                    $reportes[$i]->contExtintores += 1;
                }
            }
        }

        return response()->json(['status' => 'ok',
                                'reportes'=>$reportes], 200);

    }

    /*Retorna los reportes de la empresa que se pasa como parametro*/
    public function reportesEmpresa($id_empresa)
    {
        //Seleccionar las inspecciones ejecutadas para generar los reportes
        $inspecciones = DB::select("
            select 
            ins.id_inspeccion, ins.id_extintor, ins.id_operador, ins.insp_remito,
            e.id_empresa, e.anio, em.nom_empresa,
            l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            u.ubicacion ubic2ext,
            user.uid, user.nombre
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c,
            tec_user_insp AS user, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where
            ins.id_operador = user.uid and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id and
            e.id_empresa = ".$id_empresa);

        if (!$inspecciones) {
            return response()->json(['error'=>'No hay reportes para mostrar.'],404);
        }

        $reportes = [];
        $reportes[0] = $inspecciones[0];

        $reportes[0]->contExtintores = 0; //Cantidad de extintores por remito

        //Recorro las inspecciones y selecciono las no repetidas(remito)
        //y las inserto en el array reportes
        for ($i=1; $i < count($inspecciones); $i++) { 
            $repetido = false;
            for ($j=0; $j < count($reportes); $j++) { 
                if($inspecciones[$i]->insp_remito == $reportes[$j]->insp_remito){
                    $repetido = true;
                    break;
                }
            }

            if(!$repetido){
                array_push($reportes, $inspecciones[$i]);
                $aux = count($reportes) - 1;
                $reportes[$aux]->contExtintores = 0;
            }
        }

        //recorro el array de reportes para contar 
        //el numero de extintores por remito
        for ($i=0; $i < count($reportes); $i++) { 
            for ($j=0; $j < count($inspecciones); $j++) { 
                if($inspecciones[$j]->insp_remito == $reportes[$i]->insp_remito){
                    $reportes[$i]->contExtintores += 1;
                }
            }
        }

        return response()->json(['status' => 'ok',
                                'reportes'=>$reportes], 200);

    }

    /*Retorna la data de las inspecciones que tiene el remito que se pasa como parametro*/
    public function dataReporte($remito)
    {
        $inspecciones = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.id_operador,ins.fecha_envio, ins.insp_optativa, ins.insp_remito,
            e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            user.uid, user.nombre, user.firma,
            d.manguera, d.manguera_observaciones,
            d.ruedas, d.ruedas_observaciones,
            d.manometro, d.manometro_observaciones,
            d.etiquetas, d.etiquetas_observaciones,
            d.vencimientos, d.vencimientos_observaciones,
            d.accesibilidad, d.accesibilidad_observaciones,
            d.baliza, d.baliza_observaciones
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_user_insp AS user, 
            insp_detalle_inspecciones AS d, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where
            ins.id_operador = user.uid and
            ins.id_inspeccion = d.id_inspeccion and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id and
            ins.insp_remito= '".
                $remito."'");

        $aux = \App\TecUserInsp::select('correo')
                ->where('id_empresa', '=', $inspecciones[0]->id_empresa)->get();

        $correo = $aux[0]->correo;

        return response()->json(['status' => 'ok',
                                'inspecciones'=>$inspecciones,
                                'correo' => $correo], 200);
    }

    /*Retorna la data de las inspecciones que tiene el remito
     que se pasa como parametro y que pertenecen a la empresa
     id_empresa que viene el la request.
     Para evitar que se mezclen los extintores que puedan tener 
     el mismo remito y sean de diferentes empresas*/
    public function dataReporteEmpresa(Request $request, $remito)
    {
        $id_empresa = $request->input('id_empresa');

        $inspecciones = DB::select("
            select 
            ins.id_inspeccion, ins.insp_anio, ins.insp_periodo, ins.fecha_insp,
            ins.id_operador,ins.fecha_envio, ins.insp_optativa, ins.insp_remito,
            e.serie,e.interno, t.tipo, c.capacidad, e.fecha fecha_ext,
            e.id_empresa, e.anio,
            em.nom_empresa, l.nom_localidad, y.yacimiento, e.ubicacion ubic1ext,
            e.referencia, u.ubicacion ubic2ext,
            user.uid, user.nombre, user.firma,
            d.manguera, d.manguera_observaciones,
            d.ruedas, d.ruedas_observaciones,
            d.manometro, d.manometro_observaciones,
            d.etiquetas, d.etiquetas_observaciones,
            d.vencimientos, d.vencimientos_observaciones,
            d.accesibilidad, d.accesibilidad_observaciones,
            d.baliza, d.baliza_observaciones
            from
            insp_inspecciones as ins, tec_tipo_extintor AS t,
            tec_cap_extintor AS c, tec_user_insp AS user, 
            insp_detalle_inspecciones AS d, tec_extintores AS e          
            LEFT OUTER JOIN tec_empresas AS em ON ( e.id_empresa = em.id )
            LEFT OUTER JOIN tec_yacimientos AS y ON (e.id_yacimiento = y.id)
            LEFT OUTER JOIN tec_localidad AS l ON ( e.id_localidad = l.id )
            LEFT OUTER JOIN tec_ubicacion AS u ON ( e.id_ubicacion = u.id )
            where
            ins.id_operador = user.uid and
            ins.id_inspeccion = d.id_inspeccion and
            e.id_capacidad = c.id and
            e.tipo = t.id and
            ins.insp_anio = YEAR(now()) and
            ins.insp_periodo = MONTH(now()) and
            ins.insp_estado='E' and
            ins.id_operador IS NOT NULL and
            ins.id_extintor=e.id and
            e.id_empresa = ".$id_empresa." and
            ins.insp_remito= '".
                $remito."'");

        return response()->json(['status' => 'ok',
                                'inspecciones'=>$inspecciones], 200);
    }



}

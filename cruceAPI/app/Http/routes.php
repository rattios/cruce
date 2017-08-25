<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //return view('welcome');

//-------------------------------
    //Prueba de relacion de TecMarcaExtintor con TecExtintor
    //$tecextintores = \App\TecMarcaExtintor::find(4)->tecextintores()->where('serie', '=', '101953')->first();
    //$tecextintores = \App\TecMarcaExtintor::find(4)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$tecmarcaextintor = \App\TecExtintor::find(10001)->tecmarcaextintor;
    //echo $tecmarcaextintor;

//-------------------------------
    //Prueba de Relación de TecUbicacion con TecExtintor
    //$tecextintores = \App\TecUbicacion::find(4)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$tecubicacion = \App\TecExtintor::find(10001)->tecubicacion;
    //echo $tecubicacion;

//-------------------------------
    //Prueba de Relación de TecTipoExtintor con TecExtintor
    //$tecextintores = \App\TecTipoExtintor::find(4)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$tectipoextintor = \App\TecExtintor::find(10001)->tectipoextintor;
    //echo $tectipoextintor;

//-------------------------------
    //Prueba de Relación de TecCapExtintor con TecExtintor
    //$tecextintores = \App\TecCapExtintor::find(1)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$teccapextintor = \App\TecExtintor::find(10001)->teccapextintor;
    //echo $teccapextintor;

//-------------------------------
    //Prueba de Relación de TecLocalidad con TecExtintor
    //$tecextintores = \App\TecLocalidad::find(5)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$teclocalidad = \App\TecExtintor::find(10001)->teclocalidad;
    //echo $teclocalidad;

//-------------------------------
    //Prueba de Relación de TecEmpresa con TecExtintor
    //$tecextintores = \App\TecEmpresa::find(5)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$tecempresa = \App\TecExtintor::find(10001)->tecempresa;
    //echo $tecempresa;

//-------------------------------
    //Prueba de Relación de TecYacimiento con TecExtintor
    //$tecextintores = \App\TecYacimiento::find(5)->tecextintores;
    //echo $tecextintores;

    //Prueba de relacion inversa
    //$tecyacimiento = \App\TecExtintor::find(10001)->tecyacimiento;
    //echo $tecyacimiento;

//-------------------------------
    //Prueba de Relación de TecExtintor con InspInspeccion
    //$inspinspecciones = \App\TecExtintor::find(10009)->inspinspecciones;
    //echo $inspinspecciones;

    //Prueba de relacion inversa
    //$tecextintor = \App\InspInspeccion::find(1)->tecextintor;
    //echo $tecextintor;

        //Nota ->Esta prueba no pasa xq la tabla insp_innspecciones
                //actualmente esta vacia
            

//-------------------------------
    //Prueba de Relación de TecEmpresa con TecYacimiento
    //$tecyacimientos = \App\TecEmpresa::find(1)->tecyacimientos;
    //echo $tecyacimientos;

    //echo "<br><br>";

    //$auxyacimientos = \App\TecEmpresa::find(1)->auxyacimientos;
    //echo $auxyacimientos;

    //echo "<br><br>";

    //Prueba de relacion inversa
    //$tecempresas = \App\TecYacimiento::find(1)->tecempresas;
    //echo $tecempresas;

    //echo "<br><br>";

    //$auxempresas = \App\TecYacimiento::find(1)->auxempresas;
    //echo $auxempresas;

//-------------------------------
    //Prueba de Relación de TecEmpresa con TecOt
    //$tecot = \App\TecEmpresa::find(1)->tecot;
    //echo $tecot;

    //Prueba de relacion inversa
    //$tecempresa = \App\TecOt::find(1)->tecempresa;
    //echo $tecempresa;

//-------------------------------
    //Prueba de Relación de TecEmpresa con TecLocalidad
    //$auxlocalidades = \App\TecEmpresa::find(1)->auxlocalidades;
    //echo $auxlocalidades;

    //Prueba de relacion inversa
    //$auxempresas = \App\TecLocalidad::find(2)->auxempresas;
    //echo $auxempresas;

//-------------------------------
    //Prueba de Relación de TecExtintor con TecOTExtintor
    //$auxotextintores = \App\TecExtintor::find(10001)->auxotextintores;
    //echo $auxotextintores;

    //Prueba de relacion inversa
    //$auxextintores = \App\TecOTExtintor::find(1)->auxextintores;
    //echo $auxextintores;

//-------------------------------
    //Prueba de Relación de InspInspeccion con InspDetalleInspeccion
    //$inspdetalleinspeccion = \App\InspInspeccion::find(1)->inspdetalleinspeccion;
    //echo $inspdetalleinspeccion;

    //Prueba de relacion inversa
    //$inspinspeccion = \App\InspDetalleInspeccion::find(1)->inspinspeccion;
    //echo $inspinspeccion;

//-------------------------------
    //Prueba de Relación de TecExtintor con ViewExtUltMov
    //$viewextultmov = \App\TecExtintor::find(10001)->viewextultmov;
    //echo $viewextultmov;

    //Prueba de relacion inversa
    //$tecextintor = \App\ViewExtUltMov::find(10001)->tecextintor;
    //echo $tecextintor;

//-------------------------------
    //Prueba de Relación de InspDetalleInspeccion con InspInspeccion
    //$inspdetalleinspeccion = \App\InspInspeccion::find(1)->inspdetalleinspeccion;
    //echo $inspdetalleinspeccion;

    //Prueba de relacion inversa
    //$inspinspeccion = \App\InspDetalleInspeccion::find(1)->inspinspeccion;
    //echo $inspinspeccion;

    //Nota ->Esta prueba no pasa xq las tablas actualmente 
            //estan vacias

//-------------------------------
    //Prueba de Relación de ViewExtUltMov con InspInspeccion:
    //$inspeccion = \App\ViewExtUltMov::find(10083)->inspeccion;
    //echo $inspeccion;

    //Prueba de relacion inversa
    //$viewextultmov = \App\InspInspeccion::find(1)->viewextultmov;
    //echo $viewextultmov;

    /*$inspinspecciones = \App\InspInspeccion::
    with('tecextintor.teclocalidad.auxempresas')
    ->where('insp_estado', '=', 'P')
    ->find(1);*/
    //->get();

    //dd($inspinspecciones->toJson());
    //dd($inspinspecciones->toArray());

    //$tecuserinsp = \App\Tec_user::find(1)->tecuserinsp;
    //echo $tecuserinsp;

    
});

Route::group(  ['middleware' =>'cors'], function(){

    //Parse
    //Route::get('/parse','ParseController@llenarTablaMessages');
    Route::get('/parse/emails','ParseController@getEmails');
    Route::get('/parse/telefonos','ParseController@getTelefonos');
    Route::get('/parse/registros/{email}','ParseController@getRegistros');
    //SorteoWeb
    Route::get('/sorteo/web/emails','SorteoWebController@getEmails');
    Route::get('/sorteo/web/emails/ordenados','SorteoWebController@getEmailsOrdenados');
    Route::get('/sorteo/web/telefonos','SorteoWebController@getTelefonos');
    Route::get('/sorteo/web/registros/{email}','SorteoWebController@getRegistros');
    //Cliente
    Route::get('/cruce/clientes','ClienteController@clientes');
    Route::get('/lista/clientes','ClienteController@listaClientes');
    Route::get('/cruce/clientes/telefonos','ClienteController@cruceTelefonos');
    Route::post('/cliente','ClienteController@store');
    Route::get('/clientes/participaciones/{email}','ClienteController@getParticipaciones');
    Route::get('/clientes/registrar/sinTelefono','ClienteController@registarSinTelefono');



    //-------------------------------------------------------------------

	//Route::post('/login','LoginController@userAuth');
    Route::post('/login/web','LoginController@loginWeb');
    Route::post('/login/app','LoginController@loginApp');

    Route::get('/inspecciones/notificaciones','NotificacionesController@index');

    Route::post('/inspecciones/validar/token','InspectorController@validarToken');

    Route::post('/inspecciones/mail','MailController@enviarMail');
    Route::get('/inspecciones/reporte_email/{remito}','SupervisorController@dataReporte');

    //Pruebas
    Route::get('/inspecciones/resetter_app/{id_operador}','InspectorController@getResetterApp');
    Route::post('/inspecciones/resetter_app/{id_operador}','InspectorController@setResetterApp');
    Route::post('/inspecciones/resetter/inspectores','InspectorController@setResetterAppPanel');


    
    Route::group(['middleware' => 'jwt-auth'], function(){

    //----Pruebas SupervisorController
    //Route::get('/inspecciones/agendar','SupervisorController@agendarInspecciones');
    //Route::get('/inspecciones/validar','SupervisorController@validarInspPendientes');
    //Route::get('/inspecciones/bloquear','SupervisorController@bloquearInspEmpInactivas');
    //Route::get('/inspecciones/lista','SupervisorController@listaInspPendientes');

    Route::get('/inspecciones/programar','SupervisorController@programarInspeccion');
    Route::get('/inspecciones/inspectores','SupervisorController@inspectores');
    Route::get('/inspecciones/inspector/{id_operador}','SupervisorController@inspector');
    Route::put('/inspecciones/inspector/{id_operador}/editar','SupervisorController@editarInspector');
    Route::get('/inspecciones/consola','SupervisorController@consola');
    Route::get('/inspecciones/periodoActual','SupervisorController@listaInspPeriodoActual');
    Route::get('/inspecciones/resagadas','SupervisorController@inspResagadas');
    Route::get('/inspecciones/paraAnular','SupervisorController@inspParaAnular');    
    //Route::get('/inspecciones/enCurso','SupervisorController@listaInspEnCurso');
    Route::get('/inspecciones/noAsignadas','SupervisorController@listaInspNoAsignadas');
    Route::get('/inspecciones/enCampo','SupervisorController@listaInspEnCampo');
    Route::get('/inspecciones/ejecutadas','SupervisorController@listaInspEjecutadas');
    //Route::get('/inspecciones/anuladas','SupervisorController@listaAnuladasYparaAnular');
    Route::get('/inspecciones/bloqueadas','SupervisorController@listaBloqueadas');
    Route::get('/inspecciones/anuladas','SupervisorController@listaAnuladas');
    Route::get('/inspecciones/agendaInspector/{id_operador}','SupervisorController@agendaDeInspector');
    Route::get('/inspecciones/vistaAgenda','SupervisorController@vistaAgenda');
    Route::get('/inspecciones/historialCalendarioInspector/{id_operador}','SupervisorController@historialCalendarioDeInspector');
    Route::get('/inspecciones/historialLineaTiempoInspector/{id_operador}','SupervisorController@historialLineaTiempoDeInspector');
    Route::get('/inspecciones/{id_inspeccion}/detalles','SupervisorController@detalleDeInsp');
    Route::put('/inspecciones/asignar/{id_inspeccion}','SupervisorController@asignarInspeccion');
    Route::put('/inspecciones/{id_inspeccion}/estado','SupervisorController@modificarEstado');
    Route::put('/inspecciones/{id_inspeccion}/estadoV2','SupervisorController@modificarEstadoV2');
    Route::put('/inspecciones/{id_inspeccion}/activar','SupervisorController@activarInspeccion');
    Route::put('/inspecciones/editar/{id_inspeccion}','SupervisorController@editarDetalleDeInsp');

    //Programa anual
    //Route::get('/inspecciones/empresasActivas','SupervisorController@listaEmpresasActivas');
    //Route::get('/inspecciones/mantenimientos/extintores/empresa/{id_empresa}','SupervisorController@mantenimientos');
    //Route::put('/inspecciones/generarPrograma/empresa/{id_empresa}','SupervisorController@generarPrograma');
    Route::get('/inspecciones/dataPrograma/empresa/{id_empresa}','SupervisorController@dataProgramaAnual');
    Route::put('/inspecciones/guardarPrograma/empresa/{id_empresa}','SupervisorController@guardarProgramaAnual');
    Route::get('/inspecciones/leerPrograma/empresa/{id_empresa}','SupervisorController@leerProgramaAnual');
    Route::get('/inspecciones/extintoresNuevos/empresa/{id_empresa}','SupervisorController@extintoresNuevos');
    Route::put('/inspecciones/actualizarPrograma/empresa/{id_empresa}','SupervisorController@actualizarProgramaAnual');

    //Reportes
    Route::get('/inspecciones/reportes','SupervisorController@reportes');
    Route::get('/inspecciones/reporte/{remito}','SupervisorController@dataReporte');
    Route::get('/inspecciones/reporte/empresa/{remito}','SupervisorController@dataReporteEmpresa');
    Route::get('/inspecciones/reportes/empresa/{id_empresa}','SupervisorController@reportesEmpresa');
    
    //----Pruebas InspectorController
    Route::get('/inspecciones/sincronizar/{id_operador}','InspectorController@sincronizar');
    Route::put('/inspecciones/ejecutar/{id_inspeccion}','InspectorController@ejecutarInsp');
    Route::put('/inspecciones/push/operador/{id_operador}','InspectorController@actualizarPush');
    Route::get('/inspecciones/estado/{id_inspeccion}','InspectorController@getEstadoInsp');

    //----Pruebas NotificacionesController
    Route::post('/inspecciones/notificaciones','NotificacionesController@store');

    //----Pruebas UsuarioController
    Route::get('/inspecciones/usuarios','UsuarioController@index');
    Route::post('/inspecciones/usuarios','UsuarioController@store');
    Route::put('/inspecciones/usuarios/{uid}','UsuarioController@edit');
    Route::delete('/inspecciones/usuarios/{uid}','UsuarioController@destroy');

    });
});

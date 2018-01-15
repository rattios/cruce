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

    //----Pruebas LoginController
    Route::post('/login/web','LoginController@loginWeb');

    //----Pruebas UsuarioController
    Route::get('/usuarios','UsuarioController@index');
    Route::post('/usuarios','UsuarioController@store'); 
    //Route::put('/usuarios/{id}','UsuarioController@update');
    Route::delete('/usuarios/{id}','UsuarioController@destroy');
    Route::get('/usuarios/{id}','UsuarioController@show');

    
    Route::group(['middleware' => 'jwt-auth'], function(){

    

    });
});

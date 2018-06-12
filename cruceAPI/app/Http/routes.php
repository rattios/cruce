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
    return view('welcome'); 
});

Route::group(  ['middleware' =>'cors'], function(){

    //Login para acceder al config del .env
    Route::post('/','LoginController@loginLaravel');
    //SetEnv
    Route::post('/variables','SetEnvController@setEnv');

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
    Route::get('/dashboard','ClienteController@dashboard');
    Route::get('/cruce/clientes/telefonos','ClienteController@cruceTelefonos');
    Route::post('/cliente','ClienteController@store');
    Route::get('/clientes/participaciones/{email}','ClienteController@getParticipaciones');
    Route::get('/clientes/registrar/sinTelefono','ClienteController@registarSinTelefono');

    Route::get('/importaciones','ImportacionesController@index');
    Route::get('/importaciones/{id}','ImportacionesController@get_for_id');
    Route::post('/importar/{id}','ImportacionesController@import');

    Route::post('/login/web','LoginController@loginWeb');
    Route::post('/login/facebook','FacebookController@store');
    Route::post('/login/twitter','TwitterController@store');
    Route::put('/login/instagram/{id}','InstagramController@update');
    Route::put('/login/instagrams','InstagramController@edit');
    Route::get('/instagram/{id}','InstagramController@show');

    Route::get('/datos/twitter','TwitterController@datos'); 

    Route::post('twitterUserTimeLine', 'TwitterController@twitterUserTimeLine');
    Route::post('twitterFollowers', 'TwitterController@twitterFollowers');

    Route::post('tweet', ['as'=>'post.tweet','uses'=>'TwitterController@tweet']);   

    Route::get('createFriends', 'facebook_friendsController@createFriends');
    Route::get('facebookFriends', 'facebook_friendsController@facebookFriends');
    Route::get('facebookPosts', 'facebook_friendsController@facebookPosts');
    Route::get('facebook_comments', 'facebook_friendsController@facebook_comments');
    Route::get('facebook_likes', 'facebook_friendsController@facebook_likes');
    Route::get('posts', 'facebook_friendsController@posts');

    Route::get('twitter_followers', 'facebook_friendsController@twitter_followers');
    Route::get('twitter_tweets', 'facebook_friendsController@twitter_tweets');
    Route::get('twitter_tweets_other', 'facebook_friendsController@twitter_tweets_other');
    Route::get('getTeewts', 'facebook_friendsController@getTeewts');

    Route::post('eventos', 'EventosController@store');
    Route::get('eventos', 'EventosController@index');
    Route::put('eventos','EventosController@update');
    Route::get('/eventos/{id}','EventosController@show');
    Route::delete('/eventos/{id}','EventosController@destroy');

    Route::post('eventos_usuarios', 'Eventos_usuariosController@store');
    Route::get('eventos_usuarios', 'Eventos_usuariosController@index');
    Route::put('eventos_usuarios','Eventos_usuariosController@update');
    Route::get('/eventos_usuarios/{id}','Eventos_usuariosController@show');
    Route::delete('eventos_usuarios','Eventos_usuariosController@destroy');

    Route::post('importar', 'ImportarEventosController@store');
    Route::get('importar', 'ImportarEventosController@index');
    Route::put('importar/{id}','ImportarEventosController@update');
    Route::get('/importar/{id}','ImportarEventosController@show');
    Route::delete('importar/{id}','ImportarEventosController@destroy');

    Route::post('agendas', 'AgendasController@store');
    Route::get('agendas', 'AgendasController@index');
    Route::put('agendas','AgendasController@update');
    Route::get('/agendas/{id}','AgendasController@show');
    Route::delete('agendas','AgendasController@destroy');

    Route::post('agendaseventos', 'AgendasEventosController@store');
    Route::get('agendaseventos', 'AgendasEventosController@index');
    Route::put('agendaseventos','AgendasEventosController@update');
    Route::get('/agendaseventos/{id}','AgendasEventosController@show');
    Route::delete('agendaseventos','AgendasEventosController@destroy');

    Route::get('youtube', 'YoutubeController@index');
    
    Route::group(['middleware' => 'jwt-auth'], function(){


    });
});

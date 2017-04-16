<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('/teams', 'TeamController');
Route::resource('/informations', 'InformationController');
Route::resource('/events', 'EventController');
Route::resource('/users', 'UserController');
Route::resource('/orders', 'OrderController');
Route::resource('/profiles', 'ProfileController');
//Route::resource('/places', 'PlaceController');
//Route::resource('/programs', 'ProgramController');
//Route::resource('/logistic', 'LogisticrequirimentController');

Route::get('/onSuccessCreate', 'UserController@onSuccessCreate');
Route::post('/profiles/team', ['as' => 'profiles.team',
    'uses' => 'ProfileController@team'
]);
Route::post('/evento/editarEventoBase', ['as' => 'evento.editarEventoBase',
    'uses' => 'EventController@editBase'
]);
Route::post('/informations/store', ['as' => 'informations.store',
    'uses' => 'InformationController@store'
]);
Route::post('/places/store', ['as' => 'places.store',
    'uses' => 'PlaceController@store'
]);
Route::post('/programs/store', ['as' => 'programs.store',
    'uses' => 'ProgramController@store'
]);
Route::post('/logistic/store', ['as' => 'logistic.store',
    'uses' => 'LogisticrequirimentController@store'
]);
Route::get('/findEventsByTeam/{id}', 'SearchController@findEventsByTeam');
Route::get('/findEventsById/{id}', 'EventController@show');
Route::get('/borrar/evento/{id}', 'EventController@destroy');
Route::get('/borrar/usuario/{id}', 'UserController@destroy');
Route::get('/borrar/equipo/{id}', 'TeamController@destroy');
Route::get('/borrar/bossplace/{id}', 'BossplaceController@destroy');
Route::get('/borrar/comitereception/{id}', 'ComitereceptionController@destroy');
Route::get('/borrar/presidium/{id}', 'PresidiummemberController@destroy');
Route::get('/borrar/invitado/{id}', 'EspecialassistanController@destroy');
Route::get('/borrar/primeralinea/{id}', 'FirstlineController@destroy');
Route::get('/borrar/ordendia/{id}', 'DayorderController@destroy');
Route::get('/findSeccionalByMunicipio/{id}', 'SearchController@findSeccionalByMunicipio');
Route::get('/borrar/materialresources/{id}', 'SearchController@borrarMaterial');
Route::get('/borrar/imageresources/{id}', 'SearchController@borrarImage');
Route::get('/borrar/securitysupplies/{id}', 'SearchController@borrarSecurity');

Route::get('/generarpdf/{id}', 'EventController@generatePdf');
Route::get('/generarficha/{id}', 'EventController@generarFicha');
Route::get('/generarficha1', 'EventController@generarFicha1');
Route::get('/generarficha2', 'EventController@generarFicha2');

Route::post('/eventosCalendar', ['as' => 'evento.calendar',
    'uses' => 'EventController@eventosCalendar'
]);
Route::get('/calendario', ['as' => 'evento.calendario',
    'uses' => 'EventController@calendario'
]);
Route::get('/fullagenda', ['as' => 'evento.fullagenda',
    'uses' => 'EventController@fullagenda'
]);
Route::post('/borrarEvento', ['as' => 'evento.borrarEvento',
    'uses' => 'EventController@borrarEvento'
]);

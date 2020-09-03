<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Route::get('/updateapp', function()
{
    \Artisan::call('dump-autoload');
    echo 'dump-autoload complete';
});


Auth::routes();

Route::get('/test', 'HomeController@test');
Route::get('/test-save', 'HomeController@startTestSave');

Route::get('/dashboard', 'HomeController@index')->middleware('auth');
Route::get('/graficos-diagnostico/{campaign}', 'ChartController@index')->middleware('auth');
Route::get('/graficos', 'ChartController@create')->middleware('auth');
Route::resource('/usuarios','UserController')->middleware('auth');
Route::get('/usuario/{usuario}/cargos','UserController@roles')->middleware('auth');

Route::get('/cidades','CityController@index')->middleware('auth');

Route::get('/usuario-status/{usuario}','UserController@status')->middleware('auth');
Route::resource('/cargos','RoleController')->middleware('auth');
Route::resource('/permissoes','PermissionController')->middleware('auth');

Route::get('/cargo/{cargo}/permissoes','RoleController@permissions')->middleware('auth');
Route::get('/cargo/{cargo}/usuarios','RoleController@users')->middleware('auth');

Route::get('/vincular-permissao','RoleController@createPermissionRole')->middleware('auth');
Route::post('/salvar-vincular-permissao','RoleController@changePermissionRole')->middleware('auth');

Route::get('/vincular-usuario','RoleController@createRoleUser')->middleware('auth');
Route::post('/salvar-vincular-usuario','RoleController@changeRoleUser')->middleware('auth');

Route::resource('/perguntas','QuestionController')->middleware('auth');

Route::post('/salvar-vincular-categoria','QuestionController@changeCategoryQuestion')->middleware('auth');
Route::get('/vincular-categoria','QuestionController@createCategoryQuestion')->middleware('auth');


Route::resource('/respostas','AnswerController')->middleware('auth');
Route::resource('/categorias','CategoryController')->middleware('auth');
Route::get('/categoria/{categoria}/perguntas','CategoryController@questions')->middleware('auth');


Route::get('/pergunta/{pergunta}/respostas','QuestionController@answers')->middleware('auth');
Route::get('/pergunta/{pergunta}/categorias','QuestionController@categories')->middleware('auth');

Route::resource('/campanhas','CampaignController')->middleware('auth');

Route::get('/responder-campanha/{campaign}','CampaignController@createCampaignAnswer')->middleware('auth');
Route::post('/responder-campanha','CampaignController@saveCampaignAnswer')->middleware('auth');
Route::get('/respondidas/{campaign}','CampaignController@answers')->middleware('auth');

Route::resource('/campanha-respostas','CampaignAnswerController')->middleware('auth');


//cruzar Respostas
Route::get('/cruzar-respostas','CruzeAnswerController@create')->middleware('auth');
Route::get('/cruzar-perguntas','CruzeQuestionController@create')->middleware('auth');

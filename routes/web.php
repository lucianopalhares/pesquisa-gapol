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

Route::get('/test', 'App\Http\Controllers\HomeController@test');
Route::get('/test-save', 'App\Http\Controllers\HomeController@startTestSave');

Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->middleware('auth');
Route::get('/graficos-diagnostico/{campaign}', 'App\Http\Controllers\ChartController@index')->middleware('auth');
Route::get('/graficos', 'App\Http\Controllers\ChartController@create')->middleware('auth');
Route::resource('/usuarios','App\Http\Controllers\UserController')->middleware('auth');
Route::get('/usuario/{usuario}/cargos','App\Http\Controllers\UserController@roles')->middleware('auth');

Route::get('/cidades','App\Http\Controllers\CityController@index')->middleware('auth');

Route::get('/usuario-status/{usuario}','App\Http\Controllers\UserController@status')->middleware('auth');
Route::resource('/cargos','App\Http\Controllers\RoleController')->middleware('auth');
Route::resource('/permissoes','App\Http\Controllers\PermissionController')->middleware('auth');

Route::get('/cargo/{cargo}/permissoes','App\Http\Controllers\RoleController@permissions')->middleware('auth');
Route::get('/cargo/{cargo}/usuarios','App\Http\Controllers\RoleController@users')->middleware('auth');

Route::get('/vincular-permissao','App\Http\Controllers\RoleController@createPermissionRole')->middleware('auth');
Route::post('/salvar-vincular-permissao','App\Http\Controllers\RoleController@changePermissionRole')->middleware('auth');

Route::get('/vincular-usuario','App\Http\Controllers\RoleController@createRoleUser')->middleware('auth');
Route::post('/salvar-vincular-usuario','App\Http\Controllers\RoleController@changeRoleUser')->middleware('auth');

Route::resource('/perguntas','App\Http\Controllers\QuestionController')->middleware('auth');

Route::post('/salvar-vincular-categoria','App\Http\Controllers\QuestionController@changeCategoryQuestion')->middleware('auth');
Route::get('/vincular-categoria','App\Http\Controllers\QuestionController@createCategoryQuestion')->middleware('auth');


Route::resource('/respostas','App\Http\Controllers\AnswerController')->middleware('auth');
Route::resource('/categorias','App\Http\Controllers\CategoryController')->middleware('auth');
Route::get('/categoria/{categoria}/perguntas','App\Http\Controllers\CategoryController@questions')->middleware('auth');


Route::get('/pergunta/{pergunta}/respostas','App\Http\Controllers\QuestionController@answers')->middleware('auth');
Route::get('/pergunta/{pergunta}/categorias','App\Http\Controllers\QuestionController@categories')->middleware('auth');

Route::resource('/campanhas','App\Http\Controllers\CampaignController')->middleware('auth');

Route::get('/responder-campanha/{campaign}','App\Http\Controllers\CampaignController@createCampaignAnswer')->middleware('auth');
Route::post('/responder-campanha','App\Http\Controllers\CampaignController@saveCampaignAnswer')->middleware('auth');
Route::get('/respondidas/{campaign}','App\Http\Controllers\CampaignController@answers')->middleware('auth');

Route::resource('/campanha-respostas','App\Http\Controllers\CampaignAnswerController')->middleware('auth');


//cruzar Respostas
Route::get('/cruzar-respostas','App\Http\Controllers\CruzeAnswerController@create')->middleware('auth');
Route::get('/cruzar-perguntas','App\Http\Controllers\CruzeQuestionController@create')->middleware('auth');

Auth::routes();

Route::get('/home','App\Http\Controllers\HomeController@index')->middleware('auth');

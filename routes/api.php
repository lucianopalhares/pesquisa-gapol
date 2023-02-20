<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

*/

Route::name('api.')->group(function() {

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login-api','App\Http\Controllers\Auth\LoginApiController@login');
Route::get('/login-api',function(){
  if(\Auth::user()){
    return response()->json(['status'=>true,'App\Http\Controllers\msg'=>'Usuário logado','App\Http\Controllers\data'=>\Auth::user()]);
  }else{
    return response()->json(['status'=>false,'App\Http\Controllers\msg'=>'Usuario nao logado']);
  }
})->name('login-api');


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


//cruzamento de Respostas
Route::get('/questions-cruze','App\Http\Controllers\CruzeAnswerController@questions');
Route::get('/answers-cruze/{question}','App\Http\Controllers\CruzeAnswerController@answers');
Route::post('/cruze-data','App\Http\Controllers\CruzeAnswerController@cruze');
//cruzamento de Perguntas
Route::get('/cruzar-perguntas-selecionadas','App\Http\Controllers\CruzeQuestionController@cruze');

});
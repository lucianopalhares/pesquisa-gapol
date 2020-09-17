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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login-api','Auth\LoginApiController@login');
Route::get('/login-api',function(){
  if(\Auth::user()){
    return response()->json(['status'=>true,'msg'=>'Usuário logado','data'=>\Auth::user()]);
  }else{
    return response()->json(['status'=>false,'msg'=>'Usuario nao logado']);
  }
})->name('login-api');


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


//cruzamento de Respostas
Route::get('/questions-cruze','CruzeAnswerController@questions');
Route::get('/answers-cruze/{question}','CruzeAnswerController@answers');
Route::post('/cruze-data','CruzeAnswerController@cruze');
//cruzamento de Perguntas
Route::get('/cruzar-perguntas-selecionadas','CruzeQuestionController@cruze');

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Category;

class CategoryController extends Controller
{
    protected $model;

    public function __construct(Category $model){
      $this->model = $model;
      //$this->payment_way = \App::make('App\PaymentWay');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('viewAny-category') ){

          $message = 'Acesso não Autorizado: LISTAR categorias';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        $items = $this->model::all();

        if($is_api) return response()->json($items);

        return view('categories.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( \Gate::denies('create-category') ){
            $message = 'Acesso não Autorizado: CADASTRAR categoria';

            return back()->withErrors($message);
        }
        return view('categories.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          if( \Gate::denies('create-category') ){

            $message = 'Acesso não Autorizado: CADASTRAR categoria';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
          }

          $rules = [
            'name' => ['required', 'string', 'max:255'],
            //'slug' => ['required', 'string', 'max:255', 'unique:categories'],
          ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {

            $model = new $this->model;

            $slug = str_slug($request->name);
            if($this->model::whereSlug($slug)->count()>0){
              $slug = str_slug($request->name.time());
            }

            $model->name = $request->name;
            $model->slug = $slug;
            $save = $model->save();

            $response = 'Categoria';

            $response .= ' Cadastrado(a) com Sucesso!';

            if ($is_api) {
                return response()->json(['status'=>true,'msg'=>$response]);
            }else{
                return back()->with('successMsg', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categoria)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('view-category') ){

          $message = 'Acesso não Autorizado: VISUALIZAR categoria';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $categoria;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            return view('categories.form',compact('item','show'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $categoria)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('update-category') ){

          $message = 'Acesso não Autorizado: EDITAR categoria';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $categoria;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }

            return view('categories.form',compact('item'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categoria)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('update-category') ){

          $message = 'Acesso não Autorizado: EDITAR categoria';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

          $rules = [
            'name' => ['required', 'string', 'max:255'],
            //'slug' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($request->id)],
          ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {
            $model = $categoria;

            $slug = str_slug($request->name);
            if($this->model::whereSlug($slug)->count()>0){
              $slug = str_slug($request->name.time());
            }

            $model->name = $request->name;
            $model->slug = $slug;
            $save = $model->save();

            $response = 'Categoria';

            $response .= ' Editado(a) com Sucesso!';

            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('successMsg', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $categoria)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('delete-category') ){

          $message = 'Acesso não Autorizado: EXCLUIR categoria';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $categoria;

            $item->delete();

            $response = 'Categoria';

            $response .= ' Deletado(a) com Sucesso!';

            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }

            return back()->with('successMsg',$response);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }
    }
    public function questions(Category $categoria)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-question',$categoria) ){

          $message = 'Acesso não Autorizado: LISTAR perguntas';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $categoria->questions;

            $category = $categoria;

            if($is_api) return response()->json($items);

            return view('questions.index',compact('items','category'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }
    }
}

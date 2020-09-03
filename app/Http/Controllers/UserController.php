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
use App\User;

class UserController extends Controller
{
    protected $model;
    protected $city;

    public function __construct(User $model){
      $this->model = $model;
      $this->city = \App::make('App\City');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }


        if( \Gate::denies('viewAny-user') ){

          $message = 'Acesso não Autorizado: LISTAR usuários';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        if(isset($request->status)){
          $items = $this->model::whereStatus($request->status)->get();
        }else{
          $items = $this->model::all();
        }


        if($is_api) return response()->json($items);

        return view('users.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( \Gate::denies('create-user') ){
            $message = 'Acesso não Autorizado: CADASTRAR usuário';

            return back()->withErrors($message);
        }
        $cities = $this->city::all();

        return view('users.form',compact('cities'));
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

        if( \Gate::denies('create-user') ){

          $message = 'Acesso não Autorizado: CADASTRAR usuário';

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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

            $model->name = $request->name;
            $model->email = $request->email;
            $model->password = Hash::make($request->password);
            $model->status = $request->status;
            $model->city_id = $request->city_id;
            $save = $model->save();

            $response = 'Usuário';

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
    public function show(User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('view-user') ){

          $message = 'Acesso não Autorizado: VISUALIZAR usuário';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $usuario;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            $cities = $this->city::all();

            return view('users.form',compact('item','show','cities'));

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
     * @param  int  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('update-user') ){

          $message = 'Acesso não Autorizado: EDITAR usuário';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $usuario;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }

            $cities = $this->city::all();

            return view('users.form',compact('item','cities'));

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
     * @param  int  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('update-user') ){

          $message = 'Acesso não Autorizado: EDITAR usuário';

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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
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
            $model = $usuario;

            $model->name = $request->name;
            $model->email = $request->email;
            if(strlen($request->password)>0){
              $model->password = Hash::make($request->password);
            }
            $model->status = $request->status;
            $model->city_id = $request->city_id;
            $save = $model->save();

            $response = 'Usuário';

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
    public function destroy(User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('delete-user') ){

          $message = 'Acesso não Autorizado: EXCLUIR usuário';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $usuario;

            $item->delete();

            $response = 'Usuário';

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
    public function status(User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('update-user') ){

          $message = 'Acesso não Autorizado: EDITAR usuário';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $model = $usuario;

            if($usuario->status=='Ativo'){
              $model->status = 'Inativo';
              $response = 'Usuário "'.$usuario->name.'" Desativado com Sucesso!';
            }else{
              $model->status = 'Ativo';
              $response = 'Usuário "'.$usuario->name.'" Ativado com Sucesso!';
            }
            $model->save();

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
    public function roles(User $usuario)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-role',$usuario) ){

          $message = 'Acesso não Autorizado: LISTAR cargos';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $usuario->roles;

            $user = $usuario;

            if($is_api) return response()->json($items);

            return view('roles.index',compact('items','user'));

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

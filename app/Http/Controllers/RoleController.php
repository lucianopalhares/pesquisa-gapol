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
use App\Role;

class RoleController extends Controller
{
    protected $model;
    protected $permission_role;
    protected $role;
    protected $permission;
    protected $role_user;
    protected $user;

    public function __construct(Role $model){
      $this->model = $model;
      $this->permission_role = \App::make('App\PermissionRole');
      $this->role_user = \App::make('App\RoleUser');
      $this->role = \App::make('App\Role');
      $this->permission = \App::make('App\Permission');
      $this->user = \App::make('App\User');
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

        if( \Gate::denies('viewAny-role') ){

          $message = 'Acesso não Autorizado: LISTAR cargos';

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

        return view('roles.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( \Gate::denies('create-role') ){
            $message = 'Acesso não Autorizado: CADASTRAR cargo';

            return back()->withErrors($message);
        }
        return view('roles.form');
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

          if( \Gate::denies('create-role') ){

            $message = 'Acesso não Autorizado: CADASTRAR cargo';

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
            'slug' => ['required', 'string', 'max:255', 'unique:roles'],
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
            $model->slug = $request->slug;
            $save = $model->save();

            $response = 'Cargo';

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
    public function show(Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('view-role') ){

          $message = 'Acesso não Autorizado: VISUALIZAR cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $cargo;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            return view('roles.form',compact('item','show'));

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
     * @param  int  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('update-role') ){

          $message = 'Acesso não Autorizado: EDITAR cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $cargo;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }

            return view('roles.form',compact('item'));

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
     * @param  int  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('update-role') ){

          $message = 'Acesso não Autorizado: EDITAR cargo';

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
            'slug' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($request->id)],
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
            $model = $cargo;

            $slug = str_slug($request->name);
            if($this->model::whereSlug($slug)->count()>0){
              $slug = str_slug($request->name.time());
            }

            $model->name = $request->name;
            $model->slug = $request->slug;
            $save = $model->save();

            $response = 'Cargo';

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
    public function destroy(Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('delete-role') ){

          $message = 'Acesso não Autorizado: EXCLUIR cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $cargo;

            $item->delete();

            $response = 'Cargo';

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
    public function permissions(Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-permission',$cargo) ){

          $message = 'Acesso não Autorizado: LISTAR permissões';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $cargo->permissions;

            $role = $cargo;

            if($is_api) return response()->json($items);

            return view('permissions.index',compact('items','role'));

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
    public function users(Role $cargo)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-user',$cargo) ){

          $message = 'Acesso não Autorizado: LISTAR usuários';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $cargo->users;

            $role = $cargo;

            if($is_api) return response()->json($items);

            return view('users.index',compact('items','role'));

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
    public function changePermissionRole(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          $rules = [
            'create_delete' => ['required', 'string', 'max:255'],
            'permission_id' => ['required', 'integer'],
            'role_id' => ['required', 'integer'],
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

        if($request->create_delete=='create' && \Gate::denies('create-permission_role')){

          $message = 'Acesso não Autorizado: CADASTRAR permissão no cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }
        if($request->create_delete=='delete' && \Gate::denies('delete-permission_role')){

          $message = 'Acesso não Autorizado: EXCLUIR permissão no cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            if($request->create_delete=='create'){

              $exists = $this->permission_role::whereRoleId($request->role_id)->wherePermissionId($request->permission_id)->count();

              if($exists){
                $message = 'Esta Permissão já foi adicionada neste Cargo!';

                if ($is_api) {
                  return response()->json(['status'=>false,'msg'=>$message]);
                }else{
                  return redirect()->back()
                            ->withErrors($message)
                            ->withInput();
                }
              }

              $model = new $this->permission_role;

              $model->role_id = $request->role_id;
              $model->permission_id = $request->permission_id;
              $save = $model->save();

              $response = 'Permissão adicionada no Cargo com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }elseif($request->create_delete=='delete'){

              $this->permission_role::whereRoleId($request->role_id)->wherePermissionId($request->permission_id)->delete();

              $response = 'Permissão excluida do Cargo com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }else{
            $message = 'Impossivel cadastrar ou excluir permissão do cargo!';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
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
    public function createPermissionRole()
    {
      if(\Gate::denies('create-permission_role')){

        $message = 'Acesso não Autorizado: CADASTRAR permissão no cargo';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }
      $roles = $this->role::all();
      $permissions = $this->permission::all();

      return view('permission_roles.form',compact('roles','permissions'));
    }
    public function changeRoleUser(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          $rules = [
            'create_delete' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'integer'],
            'role_id' => ['required', 'integer'],
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

        if($request->create_delete=='create' && \Gate::denies('create-role_user')){

          $message = 'Acesso não Autorizado: CADASTRAR usuário no cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }
        if($request->create_delete=='delete' && \Gate::denies('delete-role_user')){

          $message = 'Acesso não Autorizado: EXCLUIR usuário do cargo';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            if($request->create_delete=='create'){

              $exists = $this->role_user::whereRoleId($request->role_id)->whereUserId($request->user_id)->count();

              if($exists){
                $message = 'Este Usuário já foi adicionado neste Cargo!';

                if ($is_api) {
                  return response()->json(['status'=>false,'msg'=>$message]);
                }else{
                  return redirect()->back()
                            ->withErrors($message)
                            ->withInput();
                }
              }

              $model = new $this->role_user;

              $model->role_id = $request->role_id;
              $model->user_id = $request->user_id;
              $save = $model->save();

              $response = 'Usuário adicionado no Cargo com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }elseif($request->create_delete=='delete'){

              $this->role_user::whereRoleId($request->role_id)->whereUserId($request->user_id)->delete();

              $response = 'Usuário excluido do Cargo com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }else{
            $message = 'Impossivel cadastrar ou excluir usuário no cargo!';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
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
    public function createRoleUser()
    {
      if(\Gate::denies('create-role_user')){

        $message = 'Acesso não Autorizado: CADASTRAR usuário no cargo';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }
      $roles = $this->role::all();
      $users = $this->user::all();

      return view('role_users.form',compact('roles','users'));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     public function redirectTo(){

       return \Auth::user();
     }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
    public function login(Request $request){

        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = \Auth::user();

            return response()->json(['status'=>true,'msg'=>'Logado com Sucesso!','user'=>$user]);

        }else{
          return response()->json(['status'=>false,'msg'=>trans('auth.failed')]);
        }
    }
    protected function authenticated(Request $request, User $user)
    {
        return response()->json(['status'=>true,'msg'=>'Logado com Sucesso!','user'=>$user]);
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json(['status'=>false,'msg'=>trans('auth.failed')]);
    }
}

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

class CityController extends Controller
{
    protected $model;

    public function __construct(\App\Models\City $model){
      $this->model = $model;
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

        if( \Gate::denies('viewAny-city') ){

          $message = 'Acesso não Autorizado: LISTAR cidades';

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

        return view('cities.index',compact('items'));

    }

}

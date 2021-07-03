@extends('layouts.app')

@push('css')
  <link href="{{asset('/')}}css/select2.min.css" rel="stylesheet" />
  <style>
      .note-group-select-from-files {
        display: none;
      }
      .select2-container {
      width: 100% !important;
      padding: 0;
      }
  </style>
@endpush

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-key"></i> Cadastrar Usuário no Cargo</h1>
  <p class="mb-4">Formulário</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        @if(isset($item))
          @if(isset($show))
            Visualizar
          @else
            Editar
          @endif
        @else
          Cadastrar
        @endif
          Usuário no Cargo
      </h6>
    </div>
    <div class="card-body">


        {!! Form::open(['url' => 'salvar-vincular-usuario','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

            <input type="hidden" name="create_delete" value="create" />
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Usuário *</label>
                        <select required="required" class="form-control" name="user_id">
                          <option value=" ">Selecione</option>
                            @foreach($users as $user)
                              @if(!$user->hasAnyRoles('admin'))
                                <option value="{{$user->id}}" {{ old('user_id') == $user->id ? "selected='selected'" : (isset($item->user_id) && $item->user_id == $user->id ? "selected='selected'" : '') }}>
                                  {{$user->name}}
                                </option>
                              @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Cargo *</label>
                        <select required="required" class="form-control" name="role_id">
                          <option value=" ">Selecione</option>
                            @foreach($roles as $role)

                                <option value="{{$role->id}}" {{ old('role_id') == $role->id ? "selected='selected'" : (isset($item->role_id) && $item->role_id == $role->id ? "selected='selected'" : '') }}>
                                  {{$role->name}}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



            <a href="{{ url('cargos') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Ver Lista de Cargos</a>



            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>



        {{ Form::close() }}

    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){
      $('select').select2();
    });

  </script>
@endpush

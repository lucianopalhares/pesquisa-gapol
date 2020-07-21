@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-users"></i> Usuários</h1>
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
          Usuário
      </h6>
    </div>
    <div class="card-body">

      @if(isset($item))
        {!! Form::open(['url' => 'usuarios/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

      @else
        {!! Form::open(['url' => 'usuarios','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

      @endif

            @if(isset($item->id))
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">ID *</label>
                        <input disabled="disabled" type="text" class="form-control" value="{{ $item->id }}">
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{$item->id}}" name="id" />
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Nome *</label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="text" required="required" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:'') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Email *</label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="email" required="required" class="form-control" name="email" value="{{ old('email',isset($item->email)?$item->email:'') }}">
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group label-floating">
                        <label class="control-label">Senha * <small><i></i></small></label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="password" {{isset($item)?"":"required='required'"}} class="form-control" name="password" value="{{ old('password') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating">
                        <label class="control-label">Repetir a Senha * <small><i></i></small></label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="password" {{isset($item)?"":"required='required'"}} class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group label-floating">
                        <label class="control-label">Status *</label>
                        <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="status">
                              <option value="Inativo" {{ old('status') == 'Inativo' ? "selected='selected'" : isset($item->status) && $item->status == 'Inativo' ? "selected='selected'" : '' }}>
                                Inativo
                              </option>
                              <option value="Ativo" {{ old('status') == 'Ativo' ? "selected='selected'" : isset($item->status) && $item->status == 'Ativo' ? "selected='selected'" : '' }}>
                                  Ativo
                              </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                  <div class="form-group label-floating">
                      <label class="control-label">Cidade <small><i>(opcional)</i></small></label>
                      <select required="required" class="form-control" name="city_id">
                        <option value=" ">Selecione</option>
                          @foreach($cities as $city)

                              <option value="{{$city->id}}" {{ old('city_id') == $city->id ? "selected='selected'" : isset($item->city_id) && $item->city_id == $city->id ? "selected='selected'" : '' }}>
                                ({{$city->name}})
                              </option>

                          @endforeach
                      </select>
                  </div>
              </div>
          </div>


            <a href="{{ url('usuarios') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Voltar para Lista</a>

            @if(isset($item->id))
            <a href="{{url('usuarios/create')}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Cadastrar Novo(a)</a>
            @endif

            @if(!isset($show))
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @else
            <a href="{{url('usuarios/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
            @endif


        {{ Form::close() }}

    </div>
  </div>
@endsection

@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-key"></i> Permissões</h1>
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
          Permissão
      </h6>
    </div>
    <div class="card-body">

      @if(isset($item))
        {!! Form::open(['url' => 'permissoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

      @else
        {!! Form::open(['url' => 'permissoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

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
                        <label class="control-label">Slug *</label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="text" required="required" class="form-control" name="slug" value="{{ old('slug',isset($item->slug)?$item->slug:'') }}">
                    </div>
                </div>


            </div>



            <a href="{{ url('permissoes') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Voltar para Lista</a>

            @if(isset($item->id))
            <a href="{{url('permissoes/create')}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Cadastrar Novo(a)</a>
            @endif

            @if(!isset($show))
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @else
            <a href="{{url('permissoes/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
            @endif


        {{ Form::close() }}

    </div>
  </div>
@endsection

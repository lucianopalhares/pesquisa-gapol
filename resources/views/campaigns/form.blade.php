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
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-share-alt"></i> Diagnosticos</h1>
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
          Diagnostico
      </h6>
    </div>
    <div class="card-body">

      @if(isset($item))
        {!! Form::open(['url' => 'campanhas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

      @else
        {!! Form::open(['url' => 'campanhas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

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
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">Nome *</label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="text" required="required" class="form-control" name="name" value="{{ old('name',isset($item->name)?$item->name:'') }}">
                    </div>
                </div>
                <!--
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Slug *</label>
                        <input {{isset($show)?"disabled='disabled'":''}} type="text" required="required" class="form-control" name="slug" value="{{ old('slug',isset($item->slug)?$item->slug:'') }}">
                    </div>
                </div>
              -->

            </div>

            <div class="row">
              <div class="col-md-12">
                  <div class="form-group label-floating">
                      <label class="control-label">Cidade *</label>
                      <select required="required" class="form-control" name="city_id">
                        <option value=" ">Selecione</option>
                          @foreach($cities as $city)

                              <option value="{{$city->id}}" {{ old('city_id') == $city->id ? "selected='selected'" : isset($item->city_id) && $item->city_id == $city->id ? "selected='selected'" : '' }}>
                                {{$city->name}}/{{$city->state}}
                              </option>

                          @endforeach
                      </select>
                  </div>
              </div>
            </div>




            <div class="row">
              <div class="col-md-4">
                  <div class="form-group label-floating">
                      <label class="control-label">Inicio <small><i>(00/00/0000)</i></small></label>
                      <input type="text" class="form-control" name="start" id="start" value="{{ old('start',isset($item->start)?date("d/m/Y", strtotime($item->start)):'') }}">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group label-floating">
                      <label class="control-label">Fim <small><i>(00/00/0000)</i></small></label>
                      <input type="text" class="form-control" name="end" id="end" value="{{ old('end',isset($item->end)?date("d/m/Y", strtotime($item->end)):'') }}">
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group label-floating">
                      <label class="control-label">Status *</label>
                      <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="status">
                        <option value="Ativa por Data" {{ old('status') == 'Ativa por Data' ? "selected='selected'" : isset($item->status) && $item->status == 'Ativa por Data' ? "selected='selected'" : '' }}>
                            Ativa somente entre as datas Inicio/Fim
                        </option>
                        <option value="Inativa" {{ old('status') == 'Inativa' ? "selected='selected'" : isset($item->status) && $item->status == 'Inativa' ? "selected='selected'" : '' }}>
                              Inativa
                            </option>
                            <option value="Ativa" {{ old('status') == 'Ativa' ? "selected='selected'" : isset($item->status) && $item->status == 'Ativa' ? "selected='selected'" : '' }}>
                                Ativa
                            </option>
                      </select>
                  </div>
              </div>

            </div>


            <a href="{{ url('campanhas') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Voltar para Lista</a>

            @if(isset($item->id))
            <a href="{{url('campanhas/create')}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Cadastrar Novo(a)</a>
            @endif

            @if(!isset($show))
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @else
            <a href="{{url('campanhas/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
            @endif


        {{ Form::close() }}

    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/')}}js/jquery.inputmask.js"></script>
<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){
      $("#start").inputmask("99/99/9999");
      $("#end").inputmask("99/99/9999");
      $('select').select2();
    });

  </script>
@endpush

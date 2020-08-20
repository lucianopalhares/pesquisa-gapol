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
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-server"></i> Gráficos de Diagnóstico</h1>
  <p class="mb-4">Selecione para gerar o gráfico</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        Selecione o Diagnóstico
      </h6>
    </div>
    <div class="card-body">


        <form>

            {!! csrf_field() !!}

            <div class="row">
              <div class="col-md-12">
                  <div class="form-group label-floating">
                      <label class="control-label">Diagnóstico *</label>
                      <select required="required" class="form-control" name="campaign_id" id="campaign_id" onchange="changeFormAction()">
                        <option value=" ">Selecione</option>
                          @foreach($campaigns as $campaign)

                              <option value="{{$campaign->id}}" {{ old('campaign_id') == $campaign->id ? "selected='selected'" : '' }}>
                                {{$campaign->name}}
                              </option>

                          @endforeach
                      </select>
                  </div>
              </div>
            </div>




          <div id="verGraficoButton">
            <button type="button" class="btn btn-primary" onclick="verGrafico()"><i class="fa fa-share"></i> Ver Gráfico Pizza</button>

            <button type="button" class="btn btn-info" onclick="verGraficoBar()"><i class="fa fa-share"></i> Ver Gráfico De Barra</button>
          </div>


      </form>

    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    var url = null;

    $(document).ready(function(){
      $('select').select2();
      $('#verGraficoButton').hide();
    });

    function changeFormAction() {
      $('#verGraficoButton').hide();
      url = null;
      var campaign_id = document.getElementById("campaign_id").value;
      if(campaign_id>0){
        url = "/graficos-diagnostico" +"/"+ campaign_id;
        $('#verGraficoButton').show();
      }
    }

    function verGrafico() {
      if(url){
        this.document.location.href = url;
      }
    }
    function verGraficoBar() {
      if(url){
        this.document.location.href = url+"?barra=1";
      }
    }
  </script>
@endpush

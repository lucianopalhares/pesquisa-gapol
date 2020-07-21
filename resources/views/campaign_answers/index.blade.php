@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-server"></i> Respostas do Diagnostico: {{$campaign->name}}</h1>
  <p class="mb-4">Tabela com todas respostas</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data do Diagnostico: {{date("d/m/Y", strtotime($campaign->created_at))}}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Pergunta</th>
              <th>Resposta</th>
              <!--<th>Data</th>-->
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->question_description}}</td>
              <td>{{$item->answer_description}}</td>
              <!--<td>{{date("d/m/Y", strtotime($item->created_at))}}</td>-->
              <td>



                    @can('delete-campaign_answer')
                      <form id="delete-campaign-answer-{{ $item->id }}" action="{{ url('campanha-respostas/'.$item->id) }}" style="display: none;" method="POST">
                          @csrf
                          @method('delete')
                      </form>
                      <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo desvincular?')){
                          event.preventDefault();
                          document.getElementById('delete-campaign-answer-{{ $item->id }}').submit();
                      }else {
                          event.preventDefault();
                        }"><i class="fa fa-window-restore"></i> Excluir Resposta</button>
                    @endcan



              </td>
            </tr>
            @endforeach


          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

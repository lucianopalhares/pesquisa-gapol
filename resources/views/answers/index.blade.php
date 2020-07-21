@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-server"></i> Respostas {{isset($campaign)?' da Campanha: '.$campaign->name:''}} </h1>
  <p class="mb-4">Tabela com todas respostas</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">{{isset($question)?$question->description:'Tabela'}}</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Pergunta</th>
              <th>Descrição</th>
              <th>Status</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->id}}</td>
              <td>{{$item->question->description}}</td>
              <td>{{$item->description}}</td>
              <td>{{$item->status}}</td>
              <td>


                  @can('update-answer', $item)
                    <a href="{{ url('respostas/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('view-answer', $item)
                    <a href="{{ url('respostas/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                  @endcan
                  @can('delete-answer', $item)
                    <form id="delete-form-{{ $item->id }}" action="{{ url('respostas/'.$item->id) }}" style="display: none;" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo deletar?')){
                        event.preventDefault();
                        document.getElementById('delete-form-{{ $item->id }}').submit();
                    }else {
                        event.preventDefault();
                      }"><i class="fa fa-trash"></i></button>
                  @endcan


                  @if(isset($campaign))
                    @can('delete-campaign_answer')
                      <form id="delete-campaign-answer-{{ $item->id }}" action="{{ url('/responder-campanha') }}" style="display: none;" method="POST">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="create_delete" value="delete" />
                          <input type="hidden" name="campaign_id" value="{{$campaign->id}}" />
                          <input type="hidden" name="answer_id" value="{{$item->id}}" />
                      </form>
                      <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo desvincular?')){
                          event.preventDefault();
                          document.getElementById('delete-campaign-answer-{{ $item->id }}').submit();
                      }else {
                          event.preventDefault();
                        }"><i class="fa fa-window-restore"></i> Excluir Resposta</button>
                    @endcan
                  @endif


              </td>
            </tr>
            @endforeach


          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

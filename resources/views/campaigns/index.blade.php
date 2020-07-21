@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-share-alt"></i> Diagnosticos</h1>
  <p class="mb-4">Tabela com todos diagnosticos</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabela</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Cidade</th>
              <th>Status</th>
              <th>Periodo</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->id}}</td>
              <td>{{$item->name}} <small><i>({{$item->slug}})</i></small></td>
              <td>{{isset($item->city_id)?$item->city->name.'/'.$item->city->state:''}}</td>
              <td>{{$item->status}}</td>
              <td>
                {{strlen($item->start)>0?date("d/m/Y", strtotime($item->start)):''}}
                {{strlen($item->end)>0?date("d/m/Y", strtotime($item->end)):''}}
              </td>
              <td>


                  @can('update-campaign', $item)
                    <a href="{{ url('campanhas/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('view-campaign', $item)
                    <a href="{{ url('campanhas/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                  @endcan
                  @can('delete-campaign', $item)
                    <form id="delete-form-{{ $item->id }}" action="{{ url('campanhas/'.$item->id) }}" style="display: none;" method="POST">
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

                  @can('create-campaign_answer', $item)
                    @if(!$item->answers()->exists()or$item->answers->count()<\App\Question::count())
                    <a href="{{ url('responder-campanha/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-registered"></i> Responder</a>
                    @endif
                  @endcan

                  @can('viewAny-campaign_answer', $item)
                    @if($item->answers()->exists())
                      <a href="{{ url('respondidas/'.$item->id)  }}" class="btn btn-info btn-sm"><i class="fa fa-question"></i> Respostas</a>
                    @endif
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

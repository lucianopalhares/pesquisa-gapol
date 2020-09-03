@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-users"></i> Usuários {{isset($role)?' do Cargo: '.$role->name:''}}</h1>
  <p class="mb-4">Tabela com todos usuários</p>

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
              <th>Email</th>
              <th>Status</th>
              <th>Cadastro</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->id}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->email}}</td>
              <td>{{$item->status}}</td>
              <td>{{date("d/m/Y", strtotime($item->created_at))}}</td>
              <td>
                @if($item->hasAnyRoles('admin'))
                  Administrador
                  @if($item->id==1) Definitivo @endif
                @else

                  @can('update-user', $item)
                  <a href="{{ url('usuarios/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('view-user', $item)
                    <a href="{{ url('usuarios/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                  @endcan
                  @can('delete-user', $item)
                  <form id="delete-form-{{ $item->id }}" action="{{ url('usuarios/'.$item->id) }}" style="display: none;" method="POST">
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

                  @can('update-user', $item)
                    @if($item->status=='Ativo')
                      <a href="{{ url('usuario-status/'.$item->id)  }}" class="btn btn-warning btn-sm"><i class="fa fa-ban"></i> Desativar</a>
                    @else
                      <a href="{{ url('usuario-status/'.$item->id)  }}" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Ativar</a>
                    @endif
                  @endcan

                  @can('viewAny-role', $item)

                    <a href="{{ url('usuario/'.$item->id.'/cargos')  }}" class="btn btn-primary btn-sm"><i class="fa fa-blind"></i> Cargos</a>

                  @endcan



                  @endif



                  @if(isset($role)&&$item->id!=1)
                    @can('delete-role_user')
                      <form id="delete-role-user-{{ $item->id }}" action="{{ url('/salvar-vincular-usuario') }}" style="display: none;" method="POST">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="create_delete" value="delete" />
                          <input type="hidden" name="role_id" value="{{$role->id}}" />
                          <input type="hidden" name="user_id" value="{{$item->id}}" />
                      </form>
                      <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo desvincular?')){
                          event.preventDefault();
                          document.getElementById('delete-role-user-{{ $item->id }}').submit();
                      }else {
                          event.preventDefault();
                        }"><i class="fa fa-window-restore"></i> Desvincular</button>
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

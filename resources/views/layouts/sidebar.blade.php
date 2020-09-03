
                              <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

                                <!-- Sidebar - Brand -->
                                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/dashboard')}}">
                                  <!--<div class="sidebar-brand-icon rotate-n-15">
                                    <i class="fas fa-laugh-wink"></i>
                                  </div>-->
                                  <div class="sidebar-brand-text mx-3">
                                    <img width="110px" src="{{asset('/')}}img/logo2.png" style="margin-left: auto;margin-right: auto;display: block;" />

                                    <sup></sup></div>
                                </a>

                                <!-- Divider -->
                                <hr class="sidebar-divider my-0">

                                <!-- Nav Item - Dashboard -->
                                <li class="nav-item">
                                  <a class="nav-link" href="{{url('/dashboard')}}">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span>Inicio</span></a>
                                </li>
                                <hr class="sidebar-divider my-0">

                                <li class="nav-item">
                                  <a class="nav-link" href="{{url('/cruzar-perguntas')}}">
                                    <i class="fas fa-fw fa-random"></i>
                                    <span>Cruzar Perguntas</span></a>
                                </li>
                                <hr class="sidebar-divider my-0">

                                <li class="nav-item">
                                  <a class="nav-link" href="{{url('/cruzar-respostas')}}">
                                    <i class="fas fa-fw fa-text-height "></i>
                                    <span>Funil de Respostas</span></a>
                                </li>

                                <!-- Divider -->
                                <hr class="sidebar-divider">
                                <div class="sidebar-heading">
                                  Gráficos
                                </div>

                                <li class="nav-item">
                                  <a class="nav-link" href="{{url('/graficos')}}">
                                    <i class="fas fa-fw fa-tachometer-alt"></i>
                                    <span>Gŕaficos das Respostas</span></a>
                                </li>

                                <!-- Divider -->
                                <hr class="sidebar-divider">
                                <div class="sidebar-heading">
                                  DIAGNÓSTICOS
                                </div>

                                @canany(['viewAny-campaign', 'create-campaign'])

                                  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseCampaign" aria-expanded="true" aria-controls="collapseTwo">
                                      <i class="fas fa-fw fa-share-alt"></i>
                                      <span>Diagnosticos</span>
                                    </a>
                                    <div id="collapseCampaign" class="collapse {{ (request()->is('campanhas/*')) ? 'show' : '' }} {{ (request()->is('campanhas')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                      <div class="bg-white py-2 collapse-inner rounded">
                                        <!--<h6 class="collapse-header">Gerenciar</h6>-->
                                        @can('viewAny-campaign')
                                          <a class="collapse-item {{ request()->route()->getName()=='campanhas.index' ? 'active': '' }}" href="{{url('/campanhas')}}">Listar Todos</a>
                                        @endcan
                                        @can('create-campaign')
                                          <a class="collapse-item {{ Request::is('campanhas/create') ? 'active': '' }}" href="{{url('/campanhas/create')}}">Cadastrar</a>
                                        @endcan
                                      </div>
                                    </div>
                                  </li>

                                @endcanany




                                                            <!-- Divider -->
                                                            <hr class="sidebar-divider">
                                                            <div class="sidebar-heading">
                                                              PERGUNTAS E RESPOSTAS
                                                            </div>

                                                            @canany(['viewAny-question', 'create-question','create-category_question'])

                                                              <li class="nav-item">
                                                                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseQuestion" aria-expanded="true" aria-controls="collapseTwo">
                                                                  <i class="fas fa-fw fa-question"></i>
                                                                  <span>Perguntas</span>
                                                                </a>
                                                                <div id="collapseQuestion" class="collapse {{ (request()->is('perguntas/*')) ? 'show' : '' }} {{ (request()->is('perguntas')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                                                  <div class="bg-white py-2 collapse-inner rounded">
                                                                    <!--<h6 class="collapse-header">Gerenciar</h6>-->
                                                                    @can('viewAny-question')
                                                                      <a class="collapse-item {{ request()->route()->getName()=='perguntas.index' ? 'active': '' }}" href="{{url('/perguntas')}}">Listar Todos</a>
                                                                    @endcan
                                                                    @can('create-question')
                                                                      <a class="collapse-item {{ Request::is('perguntas/create') ? 'active': '' }}" href="{{url('/perguntas/create')}}">Cadastrar</a>
                                                                    @endcan
                                                                    @can('create-category_question')
                                                                      <a class="collapse-item {{ Request::is('vincular-categoria') ? 'active': '' }}" href="{{url('/vincular-categoria')}}">Vincular na Categoria</a>
                                                                    @endcan
                                                                  </div>
                                                                </div>
                                                              </li>

                                                            @endcanany

                                                            @canany(['viewAny-answer', 'create-answer'])

                                                              <li class="nav-item">
                                                                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseAnswer" aria-expanded="true" aria-controls="collapseTwo">
                                                                  <i class="fas fa-fw fa-server"></i>
                                                                  <span>Respostas</span>
                                                                </a>
                                                                <div id="collapseAnswer" class="collapse {{ (request()->is('respostas/*')) ? 'show' : '' }} {{ (request()->is('respostas')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                                                  <div class="bg-white py-2 collapse-inner rounded">
                                                                    <!--<h6 class="collapse-header">Gerenciar</h6>-->
                                                                    @can('viewAny-answer')
                                                                      <a class="collapse-item {{ request()->route()->getName()=='respostas.index' ? 'active': '' }}" href="{{url('/respostas')}}">Listar Todos</a>
                                                                    @endcan
                                                                    @can('create-answer')
                                                                      <a class="collapse-item {{ Request::is('respostas/create') ? 'active': '' }}" href="{{url('/respostas/create')}}">Cadastrar</a>
                                                                    @endcan
                                                                  </div>
                                                                </div>
                                                              </li>

                                                            @endcanany





                                <!-- Divider -->
                                <hr class="sidebar-divider">
                                <div class="sidebar-heading">
                                  ACESSO
                                </div>

                                @canany(['viewAny-user', 'create-user'])

                                  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true" aria-controls="collapseTwo">
                                      <i class="fas fa-fw fa-users"></i>
                                      <span>Usuários</span>
                                    </a>
                                    <div id="collapseUser" class="collapse {{ (request()->is('usuarios/*')) ? 'show' : '' }} {{ (request()->is('usuarios')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                      <div class="bg-white py-2 collapse-inner rounded">
                                        <!--<h6 class="collapse-header">Gerenciar</h6>-->
                                        @can('viewAny-user')
                                          <a class="collapse-item {{ request()->route()->getName()=='usuarios.index' ? 'active': '' }}" href="{{url('/usuarios')}}">Listar Todos</a>
                                        @endcan
                                        @can('create-user')
                                          <a class="collapse-item {{ Request::is('usuarios/create') ? 'active': '' }}" href="{{url('/usuarios/create')}}">Cadastrar</a>
                                        @endcan
                                      </div>
                                    </div>
                                  </li>

                                @endcanany



                                @canany(['viewAny-role', 'create-role'])

                                  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseRole" aria-expanded="true" aria-controls="collapseTwo">
                                      <i class="fas fa-fw fa-blind"></i>
                                      <span>Cargos</span>
                                    </a>
                                    <div id="collapseRole" class="collapse {{ (request()->is('cargos/*')) ? 'show' : '' }} {{ (request()->is('cargos')) ? 'show' : '' }} {{ (request()->is('vincular-permissao')) ? 'show' : '' }} {{ (request()->is('vincular-usuario')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                      <div class="bg-white py-2 collapse-inner rounded">
                                        @can('viewAny-role')
                                          <a class="collapse-item {{ request()->route()->getName()=='cargos.index' ? 'active': '' }}" href="{{url('/cargos')}}">Listar Todos</a>
                                        @endcan
                                        @can('create-role')
                                          <a class="collapse-item {{ Request::is('cargos/create') ? 'active': '' }}" href="{{url('/cargos/create')}}">Cadastrar</a>
                                        @endcan
                                        @can('create-permission_role')
                                          <a class="collapse-item {{ Request::is('vincular-permissao') ? 'active': '' }}" href="{{url('/vincular-permissao')}}">Vincular Permissão/Cargo</a>
                                        @endcan
                                        @can('create-role_user')
                                          <a class="collapse-item {{ Request::is('vincular-usuario') ? 'active': '' }}" href="{{url('/vincular-usuario')}}">Vincular Usuário</a>
                                        @endcan
                                      </div>
                                    </div>
                                  </li>

                                @endcanany

                                @canany(['viewAny-permission', 'create-permission'])

                                  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePermission" aria-expanded="true" aria-controls="collapseTwo">
                                      <i class="fas fa-fw fa-key"></i>
                                      <span>Permissões</span>
                                    </a>
                                    <div id="collapsePermission" class="collapse {{ (request()->is('permissoes/*')) ? 'show' : '' }} {{ (request()->is('permissoes')) ? 'show' : '' }} {{ (request()->is('vincular-permissao')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                      <div class="bg-white py-2 collapse-inner rounded">
                                        @can('viewAny-permission')
                                          <a class="collapse-item {{ request()->route()->getName()=='permissoes.index' ? 'active': '' }}" href="{{url('/permissoes')}}">Listar Todos</a>
                                        @endcan
                                        @can('create-permission')
                                          <a class="collapse-item {{ Request::is('permissoes/create') ? 'active': '' }}" href="{{url('/permissoes/create')}}">Cadastrar</a>
                                        @endcan
                                        @can('create-permission_role')
                                          <a class="collapse-item {{ Request::is('vincular-permissao') ? 'active': '' }}" href="{{url('/vincular-permissao')}}">Vincular Permissão/Cargo</a>
                                        @endcan

                                      </div>
                                    </div>
                                  </li>

                                @endcanany


                                @canany(['viewAny-city','viewAny-category', 'create-category'])
                                <hr class="sidebar-divider">
                                <div class="sidebar-heading">
                                  Outros
                                </div>
                                @endcanany

                                @canany(['viewAny-city'])
                                <li class="nav-item {{ (request()->is('cidades')) ? 'active' : '' }}">
                                  <a class="nav-link" href="{{url('/cidades')}}">
                                    <i class="fas fa-fw fa-map"></i>
                                    <span>Cidades</span></a>
                                </li>
                                @endcanany

                                @canany(['viewAny-category', 'create-category','create-category_question'])

                                  <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="true" aria-controls="collapseTwo">
                                      <i class="fas fa-fw fa-random"></i>
                                      <span>Categorias</span>
                                    </a>
                                    <div id="collapseCategory" class="collapse {{ (request()->is('categorias/*')) ? 'show' : '' }} {{ (request()->is('categorias')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                      <div class="bg-white py-2 collapse-inner rounded">
                                        <!--<h6 class="collapse-header">Gerenciar</h6>-->
                                        @can('viewAny-category')
                                          <a class="collapse-item {{ request()->route()->getName()=='categorias.index' ? 'active': '' }}" href="{{url('/categorias')}}">Listar Todos</a>
                                        @endcan
                                        @can('create-category')
                                          <a class="collapse-item {{ Request::is('categorias/create') ? 'active': '' }}" href="{{url('/categorias/create')}}">Cadastrar</a>
                                        @endcan
                                        @can('create-category_question')
                                          <a class="collapse-item {{ Request::is('vincular-categoria') ? 'active': '' }}" href="{{url('/vincular-categoria')}}">Vincular na Pergunta</a>
                                        @endcan
                                      </div>
                                    </div>
                                  </li>

                                @endcanany



                              </ul>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/') }}vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('/') }}css/admin.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{ asset('/') }}vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    @stack('css')

</head>
@guest



<body class="bg-gradient-success">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <!--
              <div class="col-lg-2 d-none d-lg-block bg-login-image">
              </div>-->
              <div class="col-lg-6">
                <img width="300px" src="{{asset('/')}}img/logo2.png" style="margin-top: 75px;margin-left: auto;margin-right: auto;display: block;" />
              </div>
              <div class="col-lg-6">
                <br />
                <div class="p-5">

                  @include('layouts.msg')

                  @if (\Request::is('login'))

                     @yield('content')
                  @endif


                  @if (\Request::is('register'))
                      @yield('content')
                  @endif


                  @if (\Route::current()->getName()=='password.request')
                      @yield('content')
                  @endif

                  @if (\Route::current()->getName()=='password.reset')
                      @yield('content')
                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>



@else
  <!--
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                          -->
                          <body id="page-top">

                            <!-- Page Wrapper -->
                            <div id="wrapper">

                              <!-- Sidebar -->

                              @include('layouts.sidebar')

                              <!-- End of Sidebar -->

                              <!-- Content Wrapper -->
                              <div id="content-wrapper" class="d-flex flex-column">

                                <!-- Main Content -->
                                <div id="content">

                                  <!-- Topbar -->
                                  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                                    <!-- Sidebar Toggle (Topbar) -->
                                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                      <i class="fa fa-bars"></i>
                                    </button>

                                    <!--
                                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                      <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                          <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                          </button>
                                        </div>
                                      </div>
                                    </form>
                                  -->

                                    <ul class="navbar-nav ml-auto">

                                      <!--
                                      <li class="nav-item dropdown no-arrow d-sm-none">
                                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <i class="fas fa-search fa-fw"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                          <form class="form-inline mr-auto w-100 navbar-search">
                                            <div class="input-group">
                                              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                              <div class="input-group-append">
                                                <button class="btn btn-primary" type="button">
                                                  <i class="fas fa-search fa-sm"></i>
                                                </button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </li>


                                      include('layouts.nav-item-alerts')


                                      include('layouts.nav-item-messages')
                                    -->

                                      <div class="topbar-divider d-none d-sm-block"></div>


                                      @include('layouts.nav-item-user')



                                    </ul>


                                  </nav>
                                  <!-- End of Topbar -->

                                  <!-- Begin Page Content -->
                                  <div class="container-fluid">

                                    @include('layouts.msg')

                                    @yield('content')

                                  </div>
                                  <!-- /.container-fluid -->

                                </div>
                                <!-- End of Main Content -->

                                <!-- Footer -->
                                <footer class="sticky-footer bg-white">
                                  <div class="container my-auto">
                                    <div class="copyright text-center my-auto">
                                      <span>Copyright &copy; {{ config('app.name', 'Laravel') }} 2020</span>
                                    </div>
                                  </div>
                                </footer>
                                <!-- End of Footer -->

                              </div>
                              <!-- End of Content Wrapper -->

                            </div>
                            <!-- End of Page Wrapper -->

                            <!-- Scroll to Top Button-->
                            <a class="scroll-to-top rounded" href="#page-top">
                              <i class="fas fa-angle-up"></i>
                            </a>

                            <!-- Logout Modal-->
                            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pronto para Sair?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">×</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">Clique em "Sair" se você deseja mesmo sair do sistema.</div>
                                  <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>

                                    <a class="btn btn-primary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                  </div>
                                </div>
                              </div>
                            </div>



@endguest



<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/') }}vendor/jquery/jquery.min.js"></script>
<script src="{{ asset('/') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/') }}vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/') }}js/admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('/') }}vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('/') }}vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('/') }}js/demo/datatables-demo.js"></script>

<!-- Page level plugins -->
<script src="{{ asset('/') }}vendor/chart.js/Chart.min.js"></script>


@stack('scripts')


</body>

</html>

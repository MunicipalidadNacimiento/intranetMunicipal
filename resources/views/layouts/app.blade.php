<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Intranet') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet"> 
    <!-- Styles -->
    <link href="{{ asset('assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">    
    <!-- Styles -->
    <style>

        . body {
            font-family: 'Quicksand';
            font-size: 1.1em;
        }
        .menu {
            font-size: 1.1em;        
        }
        .boton {
            font-size: 1em;        
        }
        .divScroll {
            overflow:scroll;
            height:570px;
        }
        .divScrollX {
            overflow:scroll;
            width: 100%;
        }
        .navGreen{
            background-color: #009732;
        }
        tfoot input {            
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
        }
        #allWindow {            
            padding: 10px;
            min-height: 100%;
            min-width: 100%;
        }

    </style>
</head>

<body class="body">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm navGreen">
            <div class="container">
                <a class="navbar-brand text-white font-weight-lighter" href="{{ url('/home') }}">
                    <img src="{{ asset('images/MarcaMunicipal_LetrasBlancas.png')}}" style="width: 200px;" class="mr-3">                    
                    Intranet Municipal
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">                        
                        @can('siscom.index')
                        <li class="nav-item">                            
                            <a href="{{ route('siscom.index') }}" class="nav-link text-white">
                                <i class="icofont-cart-alt"></i> SisCoM
                            </a>
                        </li>
                        @endcan
                        @can('farmacia.index')
                        <li class="nav-item">                            
                            <a href="{{ route('farmacia.index') }}" class="nav-link text-white">
                               <i class="icofont-heart-beat-alt"></i> Farmacia
                            </a>
                        </li>
                        @endcan
                        @can('rrpp.index')
                        <li class="nav-item">                            
                            <a href="{{ route('webadmin.index') }}" class="nav-link text-white">
                               <i class="icofont-newspaper"></i> Noticias
                            </a>
                        </li>
                        @endcan
                        @can('users.index')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="icofont-code-alt"></i> Administraci??n  
                            </a>
                            <div class="dropdown-menu">
                                @can('users.index')
                                <a class="dropdown-item text-secondary" href="{{ route('users.index') }}">
                                   <i class="icofont-users-alt-4"></i> Usuarios
                                </a>
                                @endcan
                                @can('dependencies.index')
                                <a class="dropdown-item text-secondary" href="{{ route('dependencies.index') }}">
                                   <i class="icofont-chart-flow-1"></i> Dependencias Municipales
                                </a>
                                @endcan
                                @can('permissions.index')
                                <a class="dropdown-item text-secondary" href="{{ route('permissions.index') }}">
                                    <i class="icofont-key"></i> Permisos
                                </a>
                                @endcan
                                @can('roles.index')
                                <a class="dropdown-item text-secondary" href="{{ route('roles.index') }}">
                                    <i class="icofont-atom"></i> Roles
                                </a>
                                @endcan
                                @can('contacts.index')
                                <a class="dropdown-item text-secondary" href="{{ route('contacts.index') }}">
                                    <i class="icofont-ui-call"></i> Contactos Municipales
                                </a>
                                @endcan
                            </div>
                        </li>
                        @endcan
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                     Bienvenid@, {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="far fa-arrow-alt-circle-left"></i>    {{ __('Cerrar Sesi??n') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')        
        </main>    
    </div>

    <!-- JQuery CSS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- JQuery DataTable -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <!-- JQuery DatePicker -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Boostrap Select -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    @stack('scripts')
</body>
</html>


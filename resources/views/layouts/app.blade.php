<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset(elixir('css/app.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>
<body>
<div id="alertConfirm"></div>
@if(session()->has('flash_message'))
    <div class="alert alert-{{ session('flash_status') }} infolert">
        {{ session('flash_message') }}
    </div>
@endif
    <div id="">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        ESL
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Imprest <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @if(hasPermission(App\Role::PERM_PROCESS_IMPREST))
                                        <li><a href="{{ route('imprest.create') }}">New Imprest</a></li>
                                    @endif
                                    @if(hasPermission(App\Role::PERM_PROCESS_SURRENDER_IMPREST))
                                        <li><a href="{{ route('surrender.create') }}">Surrender Imprest</a></li>
                                    @endif
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('imprest.unprocessed') }}">Unprocessed Imprests</a></li>
                                    <li><a href="{{ route('imprest.processed') }}">Processed Imprests</a></li>
                                    <li><a href="{{ route('imprest.surrendered') }}">Surrendered Imprests</a></li>

                                        @if(Auth::user()->role_id ==3 || Auth::user()->role_id ==0 )
                                    <li><a href="{{ route('imprest.cash-form') }}">Return Cash</a></li>
                                            @endif
                                </ul>
                            </li>

                                &nbsp;<li>
                          @if(hasPermission(App\Role::PERM_VIEW_USER))
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Administration <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="/user">Users</a></li>
                                        <li><a href="{{ url('/accountusers') }}">Finance Officer</a></li>
                                        <li><a href="{{ url('/useradmin') }}">Imprest Administrator</a></li>
                                    </ul>
                            @endif
                          </li>
                          @if(hasPermission(App\Role::PERM_VIEW_DEPARTMENT))
                              <li><a href="/department">Departments</a></li>
                          @endif

                          @if(Auth::user()->role_id ==3 || Auth::user()->role_id ==0 )
                          <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Petty Cash <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="/user"></a></li>
                                        @if(Auth::user()->role_id ==3)
                                        <li><a href="{{ url('/pettycash') }}">Reimbursement </a></li>
                                        @elseif(Auth::user()->role_id ==0 )
                                        <li><a href="{{ url('/pettycash') }}"> Receive </a></li>
                                        @endif
                                    </ul>
                            </li>
                            @endif
                        @endif
                    </ul>
                    <!-- Right Side Of Navbar -->

                    <ul class="nav navbar-nav navbar-right">
                     @if(Auth::check() && Auth::user()->role_id==3)

                      <!-- Auth::user()->role_id==2 || -->

                     <li>
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        Settings
                        <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="/user"></a></li>
                        <li><a href="{{ url('/limit') }}">Imprest Limit</a></li>
                         <li><a href="{{ url('accountsettings') }}"> Account Settings </a></li>
                        </ul></li>
                        @endif
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->

    @yield('footer')
    <!-- Scripts -->

      <script src="{{ asset(elixir('js/app.js')) }}"></script>
    <script type="text/javascript" src="{{asset('css/select2.js')}}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose:true,
        format: 'd-m-yyyy'
    });

        $(document).ready(function() {
            $('.select2,.project-p,.payment_type').select2();
            $('.datatables').DataTable();


        });

      function checkAmount(data){

      var amount = data.value;
        if(amount>=5000){
          $('#payment').show();
              alert('Please select the your prefered payment type');
        }else{
            $('#payment').hide();

        }
      }


    @if(Session::has('warning'))
    toastr.warning("{{Session::get('warning')}}")
        @endif


      </script>
      @yield('scripts')


</body>
</html>

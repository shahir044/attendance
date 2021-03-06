<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BGAttendance') }}</title>

    <!-- favicon for website -->
  <!--   <link rel="icon" type="image/png" href="{{ asset('images/favicon_img.png') }}"> -->
    
  <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    
        .first_col {
            width: 45%;
        }
        .custom_body{
            width: 100% auto;
        }
 
        .arrow {
             border: solid green;
             border-width: 0 3px 3px 0;
             display: inline-block;
             padding: 3px;
         }      
         .left {
             transform: rotate(135deg);
             -webkit-transform: rotate(135deg);
         }
         .goback_btn{
             background-color: white;
             border-color: white;
             padding-top: 15px;
             padding-bottom: 0px;
             margin: 0px;
         }
         /*#38c172*/ */
     </style>
</head>

<body class="custom_body">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
            style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <div class="first_col"><a href="#"><img src="{{ asset('images/Biman_Logo_English.png') }}" class="img-fluid" alt="logo"></a></div> 
          
            <div class="container">
                {{-- <a class="navbar-brand" href="{{ url('/attendance') }}">
                    {{ config('app.name', 'BG Attendance') }}
                </a> --}}

                <ul class="navbar-nav mr-auto">
                    
                    
                    
                   {{--  <a href="/search"  class="btn btn-outline-dark" style="margin: 10px"><b>Search<b></a> --}}
                    
                </ul>   

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>
                    

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="navbar-brand active">
                            <a style="color: aliceblue" class="nav-link" href="/attendance">Home<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="navbar-brand active">
                            <a style="color: aliceblue" class="nav-link" href="{{ url('/month')}}">Monthly Record<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="navbar-brand active">
                            <a style="color: aliceblue" class="nav-link" href="{{ url('/sumtwo')}}">Summary<span class="sr-only">(current)</span></a>
                        </li>
                        <li class="navbar-brand active">
                            <a style="color: aliceblue" class="nav-link" href="{{ url('/search')}}">Search<span class="sr-only">(current)</span></a>
                        </li>

                        <li class="navbar-brand active">
                            @if (Auth::guard('web')->user())
                            
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button class="btn btn-outline-dark" type="submit"> Logout</button>
                            </form>
                                
                            @endif
                        </li>
                        
                        {{--  <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a style="color: aliceblue" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a style="color: aliceblue" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a style="color: aliceblue" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        @endguest  --}}

                        
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    
    </div>
</body>

</html>

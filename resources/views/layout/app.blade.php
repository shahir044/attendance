<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Attendance') }}</title>
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">
    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <style>
        .card-container {
            padding: 10px;
            box-shadow: 5px 4px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;

        }

    </style>

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            /* margin: 10px; */

        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style>
    {{-- custom table --}}
    <style>
        .tab {
            margin: 100px auto;
            border-spacing: 0px;
            width: 680px;
            box-shadow: 5px 4px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #fff;
            transition: all 0.5s;

            .tab td {
                padding: 20px 15px;
            }

            thead {
                background: linear-gradient(45deg, #614ad3, #e42c64);
                border-radius: 10px 10px 0 0;

                tr {
                    border-radius: 10px 10px 0 0;
                }

                td {
                    color: #fff;
                    font-size: 20px;
                }

                td:first-of-type {
                    border-radius: 10px 0 0 0;
                }

                td:last-of-type {
                    border-radius: 0 10px 0 0;
                }
            }

            tbody {
                td {
                    border-top: 1px solid #f0f0f0;
                }

                tr:hover {
                    background: rgba(123, 153, 218, 0.1);
                }
            }
        }

        table.threeDMode {
            transform: rotateX(65deg) rotateZ(-35deg);
        }

        button {
            border: none;
            background: #000;
            color: #fff;
            padding: 10px 50px;
            font-family: "Red Hat Display", sans-serif;
            font-weight: 600;
            margin: 0 auto;
            display: block;
        }

    </style>

    <style>
        .customTable {
            margin: 50px auto;
            border-spacing: 0px;
            width: 680px;
            box-shadow: 5px 4px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            background: #f7f7f7;
            transition: all 0.5s;
            text-align: center;
        }

        .hero-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("https://xpressriyadh.com/wp-content/uploads/2021/01/Biman-Bangladesh-Airlines.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }

    </style>

</head>

<body>
    @include('inc.navbar')
    <div class=container>
        @yield('context')
    </div>

    <script>
        $('button').on('click', function() {
            $('table').toggleClass('threeDMode');
        });

    </script>
  

    @include('inc.footer')

</body>

</html>

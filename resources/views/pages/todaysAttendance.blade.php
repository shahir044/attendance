@extends('layout.app')


@section('context')


    <div class="content">
        <h1>Date: {{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}</h1>
        {{-- <h1>TEST: {{$reqDate}}</h1> --}}
        <h3>Total Present: {{ $total[0]->Total }}</h3>
        <form method="get" class="form-inline my-2 my-lg-0">
            <input type="date" value="$date" required name="selectedDate" class="form-control mr-sm-2"
                placeholder="Search Name" aria-label="Search">
            <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
    <table class="table table-striped table-hover customTable">
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Building Name</th>
                <th scope="col">Total Present</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td><a
                            href="/attendance/{{ $item->building_id }}/{{ $date }}"><b>{{ $item->building_name }}</b></a>
                    </td>
                    <td>{{ $item->Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
<!--

    <div class="loader-wrapper">
        <span class="loader">
            <span class="loader-inner"></span>
        </span>
    </div>

    <script>
        $(window).on('load',function(){
            $(".loader-wrapper").fadeOut(5000);
            $(".content").fadeIn(5000);
        });
    </script>


    <script>
        $(window).on('load', function() {
            $(".loader-wrapper").hide();
            });
        });
    </script>

    <script>
        $(function(){
            $(".preload").fadeOut(2000,function(){
                $(".content").fadeIn(1000);
            });
        });
    </script>
-->
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Data Successfully Loaded',
            showConfirmButton: false,
            timer: 1500
        })

    </script>




@endsection

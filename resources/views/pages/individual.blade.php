@extends('layout.app')

@section('context')
    {{-- <a href="/attendance/{{$id}}/{{$date}}" class="btn btn-primary" style="margin: 10px"> Go Back</a> --}}
    <div class="content">
        <h1>Date: </h1>
        <h3> Department</h3>
        <form action="" method="get" class="form-inline my-2 my-lg-0">

            <input type="search" required name="search" id="searchInput" onkeyup="searchByID()" class="form-control mr-sm-2"
                placeholder="Search Name" aria-label="Search">

        </form>
    </div>

    <table class="table table-striped table-hover customTable" id="AttendanceTable">

        {{-- <h3 style="text-align:center;"><b>Present Table<b></h3> --}}
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee ID</th>
                <th scope="col">Year</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    <td>{{ $item->employee_id }}</td>
                    <td>{{ $item->year }}</td>
                    <td>{{ $item->Total }}</td>
                    <td style="background-color:#50c572">Available</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <table class="table table-striped table-hover customTable" id="AttendanceTableAbsent">
        {{-- <h3 style="text-align:center;"><b>Absent Table<b></h3> --}}
        <thead style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Employee ID</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            {{-- @foreach ($absent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#c54c67">Unavailable from 06:30 am to 10:00 am</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
    <script>
        function searchByID() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("AttendanceTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
@endsection

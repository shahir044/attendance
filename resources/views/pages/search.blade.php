@extends('layout.app')

@section('context')
<a href="/search" class="btn btn-success" style="margin: 10px">Refresh</a>


    <div class="content" >
        
        <h1>Search Result</h1>
        <h3>Date: {{$date}}</h3>
        
        
    </div>
    
    <form action="/search" method="get" class="form-inline my-2 my-lg-0">
        <input type="date" value="$date" name="selectedDate"  class= "form-control mr-sm-2"  placeholder="Search Name" aria-label="Search">
        <input type="search" name="search" id="searchInput" onkeyup="searchByID()" class= "form-control mr-sm-2"  placeholder="Search Name" aria-label="Search">
        <button class="btn btn-dark my-2 mr-sm-5" type="submit">Search</button>
    </form>

    
    
    <table class="table table-striped table-hover customTable" id="AttendanceTable">
        <thead  style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Department Name</th>
                <th scope="col">Location</th>
                <th scope="col">ID</th>
                <th scope="col">In time</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->department }}</td>
                    <td>{{ $item->building_name }}</td>
                    <td>{{ $item->employee_id }}</td>
                    <td>{{ $item->in_time }}</td>
                    <td style="background-color:#50c572">Available</td>
                </tr>
            @endforeach
            
        </tbody>
    </table>

    <table class="table table-striped table-hover customTable" id="AttendanceAbsentTable">
        <thead  style="background: linear-gradient(45deg, #47cf73, #e42c64);">
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Department Name</th>
                <th scope="col">Location</th>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->department }}</td>
                    <td>Not Found</td>
                    <td>{{ $item->employee_id }}</td>
                    <td style="background-color:#c54c67">Unavailable from 06:30am to 10:30am</td>
                </tr>
            @endforeach
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

          table = document.getElementById("AttendanceAbsentTable");
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

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

    <table class="table table-striped table-hover customTable" id="AttendancePTable">
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

    <table class="table table-striped table-hover customTable" id="AttendanceATable">
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
            @foreach ($absent as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->department }}</td>
                    <td>Not Found</td>
                    <td>{{ $item->employee_id }}</td>
                    <td>Unavailable</td>
                    <td style="background-color:#c54c67">Unavailable from 06:30am to 10:30am</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function searchByID() {
          var input_name,filter_name, pr_table,ab_table, tr_name, td_name, td_designation,td_id, i, txtValue_name,txtValue_designation,txtValue_id;
          input_name = document.getElementById("searchInput");
          filter_name = input_name.value.toUpperCase();
          pr_table = document.getElementById("AttendancePTable");
          tr_name = pr_table.getElementsByTagName("tr");
          for (i = 0; i < tr_name.length; i++) {
            //for name, designation and id wise search in present table
            td_name = tr_name[i].getElementsByTagName("td")[0];
            td_designation = tr_name[i].getElementsByTagName("td")[1];
            td_id = tr_name[i].getElementsByTagName("td")[4];
            if (td_name || td_designation || td_id) {
                txtValue_name = td_name.textContent || td_name.innerText;
                txtValue_designation = td_designation.textContent || td_designation.innerText;
                txtValue_id = td_id.textContent || td_id.innerText;
              if ((txtValue_name.toUpperCase().indexOf(filter_name) > -1) || (txtValue_designation.toUpperCase().indexOf(filter_name) > -1) || (txtValue_id.toUpperCase().indexOf(filter_name) > -1)) {
                tr_name[i].style.display = "";
              } else {
                tr_name[i].style.display = "none";
              }
            }  
          }     
          //for absence
          ab_table = document.getElementById("AttendanceATable");
          tr_name = ab_table.getElementsByTagName("tr");
          for (i = 0; i < tr_name.length; i++) {
            //for name, designation and id wise search in present table
            td_name = tr_name[i].getElementsByTagName("td")[0];
            td_designation = tr_name[i].getElementsByTagName("td")[1];
            td_id = tr_name[i].getElementsByTagName("td")[4];
            if (td_name || td_designation || td_id) {
                txtValue_name = td_name.textContent || td_name.innerText;
                txtValue_designation = td_designation.textContent || td_designation.innerText;
                txtValue_id = td_id.textContent || td_id.innerText;
              if ((txtValue_name.toUpperCase().indexOf(filter_name) > -1) || (txtValue_designation.toUpperCase().indexOf(filter_name) > -1) || (txtValue_id.toUpperCase().indexOf(filter_name) > -1)) {
                tr_name[i].style.display = "";
              } else {
                tr_name[i].style.display = "none";
              }
            }  
          }      

        }
    </script>
@endsection

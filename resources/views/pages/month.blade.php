@extends('layout.app')

<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "attendance";

    $conn = mysqli_connect($host, $username, $password, $database);
?>
@section('context')

<style>
#searchInput {
  background-image: url({{url('images/search2.png')}});
  background-size: 10%;
  background-position: 5px 9px;
  background-repeat: no-repeat;
  width: 30%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>

<div class="content" style="width: 100%">
<div >
<?php
if(isset($_GET['month']) && isset($_GET['year'])){
  $month = $_GET['month'];
  $monthName = date('F', mktime(0, 0, 0, $month, 10));
  $year = $_GET['year'];
  
  $day_in = $year.'-'.$month.'-01';
  $day_out = date ("Y-m-t",strtotime($day_in));
  $today = date('Y-m-d'); 
}
else{
  $month = date('m');
  $monthName = date('F', mktime(0, 0, 0, $month, 10)); 
  $year = date('Y');

  $today = date('Y-m-d');    //today;
  $day_in = date('Y-m-01');   //first date of current month
  $day_out = date("Y-m-t", strtotime($today));    //last date of current month
}
echo '<h2>Monthly Attendance List: '. $monthName . '/' . $year . '</h2>';
?>
</div>

<div>
<form>
  <label for="month">Month:</label>
  <select id="month" name="month">
    <option value="01">January</option>
    <option value="02">February</option>
    <option value="03">March</option>
    <option value="04">April</option>
    <option value="05">May</option>
    <option value="06">June</option>
    <option value="07">July</option>
    <option value="08">August</option>
    <option value="09">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
  </select>
  <label for="year">Year:</label>
  <input type="number" id="year" name="year" min="2021" placeholder="Select Year" value="2021">
  <input type="submit">
</form>
</div>

<div>
<input type="text" id="searchInput" onkeyup="searchByID()" placeholder="Search Employee ID..." title="Type Employee ID">
</div>
</div>
<div style="overflow: auto; height: 500px; width: 100%;" >
<table class="table table-striped table-hover customTable" id="monthlyAttendanceTable" >
  <thead>
  <tr>
    <!-- <th>Name</th>
    <th>Designation</th>
    <th>Department</th> -->
    <th style="background-color: #a1716a">ID</th>
    <?php
    $new_day = $day_in;
    while($new_day <= $day_out){
      $weekDay = date('w', strtotime($new_day));
      $day_print = date("d", strtotime($new_day));
      $day_name = date('D', strtotime($new_day));
      
      if($weekDay == 5 || $weekDay == 6)
      {
        echo '<th style="background-color:#ED1C24">'. $day_print .'<br>'. $day_name . '</th>';
      }
      else{
        echo '<th style="background-color:#00803E">'. $day_print .'<br>'. $day_name . '</th>';
      }
      $start_day = strtotime("1 day", strtotime($new_day));
      $new_day = date("Y-m-d", $start_day);
    }
    ?>
    <th style="background-color: #a1716a"> Total Present</th>
  </tr>
  </thead>
  <?php
    $sql_1 = "SELECT distinct employee_id FROM attendances ORDER BY employee_id DESC";  
    $result_1 = mysqli_query($conn,$sql_1);
    if(mysqli_num_rows($result_1) > 0){
        while($row_1 = mysqli_fetch_array($result_1)){
            $total_present = 0;
            echo '<tr>
                <td>' . $row_1['employee_id']. '</td>';
                $employee = $row_1['employee_id'];
                $sql_2 = "SELECT date FROM attendances WHERE employee_id = $employee ORDER BY date ASC";
                $result_2 = mysqli_query($conn,$sql_2);
                $new_day = $day_in;
                while($row_2 = mysqli_fetch_array($result_2)){
                    $data_day = $row_2['date'];
                    if($data_day >= $day_in && $data_day <= $day_out){
                      $counter = 0; //check for a present date untill found
                      while($counter == 0){
                          if($data_day == $new_day){
                            $weekDay = date('w', strtotime($new_day));
                            echo '<td> &#10004;&#65039; </td>';
                            $start_day = strtotime("1 day", strtotime($new_day));
                            $new_day = date("Y-m-d", $start_day);
                            $counter = 1;
                            $total_present++;
                          }
                          else {
                              $start_day = strtotime("1 day", strtotime($new_day));
                              $new_day = date("Y-m-d", $start_day);
                              echo '<td> &#10060 </td>';
                          }
                      }
                    }
                }
                // If data is not found or for showing future days 
                if($today < $day_out){
                  while ($new_day <= $day_out ){
                    $start_day = strtotime("1 day", strtotime($new_day));
                    $new_day = date("Y-m-d", $start_day);
                    echo '<td> &#x2013 </td>';
                  }
                }
                else{
                  while ($new_day <= $day_out ){
                    $start_day = strtotime("1 day", strtotime($new_day));
                    $new_day = date("Y-m-d", $start_day);
                    echo '<td> &#10060 </td>';
                  }
                }
                //count present days
                echo '<td>'. $total_present . '</td>';
            echo '</tr>';
        }
    }
  ?>
</table>
</div>
<script>
function searchByID() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("monthlyAttendanceTable");
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
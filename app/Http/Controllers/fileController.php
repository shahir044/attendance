<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Attendance;
use App\Department;
use App\Employee;
use Carbon\Carbon;
use Cron\MonthField;
use PHPUnit\Util\Json;

class fileController extends Controller
{



    public function show($id, $date)
    {
        //$employee = Employee::where('comcardid','000052044');
        //dd($employee);
        //$date = Carbon::now()->format('Y-m-d');
        $data = DB::table('attendances')
            ->select('attendances.shop_id', 'employees.department', 'attendances.building_id', DB::raw('count(*) as Total'))
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->where('date', '=', $date)
            ->where('attendances.building_id', '=', $id)
            ->groupBy('attendances.building_id', 'attendances.shop_id', 'department')
            ->orderBy('Total', 'DESC')
            ->get();
        //return $data;



        $total = DB::table('attendances')
            ->select('building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'attendances.building_id', '=', 'buildings.building_id')
            ->where('date', '=', $date)
            ->where('attendances.building_id', '=', $id)
            ->groupBy('building_name')
            ->get();
        //return $total;


        $total_manpower = DB::table('employees')
            ->select('department', DB::raw('count(*) as Total'))
            ->groupBy('department')
            ->get();
        //return $total_manpower;

        /* $date=date('d-m-Y', strtotime($date)); */
        return view('pages.department', compact('data', 'total', 'date', 'total_manpower'));
    }

    public function showDepartmentDetails($id, $d_id, $selectedDate)
    {
        $date = $selectedDate;
        $data = DB::table('attendances')
            ->select('attendances.employee_id', 'employees.name', 'employees.designation', 'employees.department', 'attendances.in_time')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            /* ->join('departments', 'attendances.shop_id', '=', 'departments.shop_id') */
            ->where('attendances.date', '=', $date)
            ->where('attendances.building_id', '=', $id)
            ->where('attendances.shop_id', '=', $d_id)
            ->orderBy('attendances.employee_id', 'ASC')
            ->get();
        //return $data;

        $absent = DB::table('employees')
            ->select('employees.employee_id', 'employees.name', 'employees.designation', 'employees.department')
            ->where('employees.shop_id', '=', $d_id)
            ->whereNotIn('employees.employee_id', DB::table('attendances')
                ->select('attendances.employee_id')
                ->where('attendances.date', '=', $date)
                ->where('attendances.shop_id', '=', $d_id)
                ->where('attendances.building_id', '=', $id))
            ->get();
        //return $absent;

        $data_department = DB::table('attendances')
            ->select('attendances.shop_id', 'employees.department', 'attendances.building_id', DB::raw('count(*) as Total'))
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->where('date', '=', $date)
            ->where('attendances.building_id', '=', $id)
            ->where('employees.shop_id', '=', $d_id)
            ->groupBy('attendances.building_id', 'attendances.shop_id', 'department')
            ->orderBy('Total', 'DESC')
            ->get();
        //return $data_department;   

        $total_manpower = DB::table('employees')
            ->select('department', DB::raw('count(*) as Total'))
            ->where('shop_id', '=', $d_id)
            ->groupBy('department')
            ->get();
        //return $total_manpower;
        $date = date('d-m-Y', strtotime($date));
        return view('pages.employee', compact('data', 'id', 'date', 'absent', 'data_department', 'total_manpower'));
    }


    public function search(Request $request)
    {
        $search = $request->get('search');
        $date = $request->get('selectedDate');
        $datas = [];
        $absent = [];
        if (is_null($date)) {
            $date = Carbon::now()->format('Y-m-d');
            //return view('pages.search', compact('datas', 'absent', 'date'));
        }


        $datas = DB::table('attendances')
            ->select('attendances.employee_id', 'name', 'designation', 'department', 'building_name', 'attendances.in_time')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->join('buildings', 'attendances.building_id', '=', 'buildings.building_id')
            ->where('date', '=', $date)
            ->where('name', 'like', '%' . $search . '%')
            /* ->orWhere('designation', 'like', '%'.$search.'%') */
            ->orderBy('attendances.employee_id', 'DESC')

            ->distinct()
            ->get();
        //return $search;

        /* if ($datas->isEmpty()) { */
        $absent = DB::table('employees')
            ->select('employees.employee_id', 'employees.name', 'employees.designation', 'employees.department')
            ->whereNotIn(
                'employees.employee_id',
                DB::table('attendances')
                    ->select('attendances.employee_id')
                    ->where('date', '=', $date)
            )
            /* ->orWhere('designation', 'like', '%'.$search.'%') */
            /* ->orderBy('attendances.employee_id','DESC') */
            /* ->orderBy('employees.employee_id', 'DESC')
            ->distinct() */
            ->get();
        /* }  */
        $date = date('d-m-Y', strtotime($date));
        return view('pages.search', compact('datas', 'absent', 'date'));
    }

    public function attendance(Request $request)
    {
        ini_set('max_execution_time', 1800); 

        $reqDate = $request->get('selectedDate');
        if (is_null($reqDate)) {
            $reqDate = Carbon::now()->format('Y-m-d');
        } else {
            $reqDate = $reqDate;
        }
        date_default_timezone_set('Asia/Dhaka');
        $mytime = date('H:i:s');


        //return $mytime;
        //return $reqDate;
        //$data = Attendance::all();
        //session(['search_criteria' => $request->input()]);


        //$reqDate = request('selectedDate');

        $data = DB::table('attendances')
            ->select('date', 'buildings.building_id', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            ->where('date', '=', $reqDate)
            ->groupBy('buildings.building_id', 'building_name', 'date')
            ->orderBy('buildings.building_name', 'ASC')->get();


        $total = DB::table('attendances')
            ->select(DB::raw('count(*) as Total'))
            ->where('date', '=', $reqDate)
            ->get();

        if (count($data) == 0 || (count($data) > 0 && ($mytime > '06:00:00' && $mytime < '12:00:00'))) {
            //return $mytime;
        $store = DB::connection('oracle');
        $data_array = $store->select("SELECT compcardid, min(to_char(punchtime,'HH24:MI:SS')) As punchtime, loc_id FROM ATT_IN.tbl_raw_data where to_char(punchdate,'YYYY-MM-DD') = '$reqDate' AND (to_char(punchtime,'HH24:MI:SS')) BETWEEN '06:30:00' AND '12:00:00' GROUP BY compcardid,loc_id");
        //$data_array = $store->select("SELECT to_char(punchdate,'YYYY-MM-DD') As punchdate,compcardid, min(to_char(punchtime,'HH24:MI:SS')) As punchtime, loc_id FROM ATT_IN.tbl_raw_data where to_char(punchdate,'YYYY-MM-DD') BETWEEN '2021-02-01' AND '2021-02-28' AND (to_char(punchtime,'HH24:MI:SS')) BETWEEN '06:30:00' AND '10:30:00' GROUP BY punchdate,compcardid,loc_id ORDER BY punchdate");
        //$var_res = response($data);


        //$data = DB::table('attendances')->get();
        //return $data;

        //$rooms = json_decode($var_res,true);
        //var_dump($rooms);
        //$data = $store->select("SELECT * FROM ATT_IN.tbl_raw_data where to_char(punchdate,'DD-Mon-YY') = '30-May-21' ");

        $uniqueValue = array();

        for ($i = 0; $i < count($data_array); $i++) {
            $punchdate = $reqDate;
            //$punchdate = $data_array[$i]->punchdate;
            $compcardid = $data_array[$i]->compcardid;
            $punchtime = $data_array[$i]->punchtime;
            $loc_id = $data_array[$i]->loc_id;


            //return $punchtime;
            $building_id = DB::table('machines')
                ->where('machine_id', '=', $loc_id)
                ->value('building_id');

            $shop_id = DB::table('employees')
                ->where('employee_id', '=', $compcardid)
                ->value('shop_id');

            //echo $punchdate." ".$compcardid." ".$punchtime." ".$loc_id." ".$building_id." ".$shop_id;
            //echo "<br>";

            $attendance = DB::table('attendances')->insertOrIgnore([
                'date' => $punchdate,
                'in_time' => $punchtime,
                'employee_id' => $compcardid,
                'building_id' => $building_id,
                'shop_id' => $shop_id,
                'machine_id' => $loc_id
            ]);
        }

        $data = DB::table('attendances')
            ->select('date', 'buildings.building_id', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            ->where('date', '=', $reqDate)
            ->groupBy('buildings.building_id', 'building_name', 'date')
            ->orderBy('buildings.building_name', 'ASC')->get();


        $total = DB::table('attendances')
            ->select(DB::raw('count(*) as Total'))
            ->where('date', '=', $reqDate)
            ->get();

        $date = $reqDate;
        return view('pages.todaysAttendance', compact('data', 'total', 'date'));
        } else {
            $date = $reqDate;
            return view('pages.todaysAttendance', compact('data', 'total', 'date'));
        }

        /* 
        $employee = DB::table('ATT_IN.tbl_raw_data')
                    //->select('compcardid')
                    ->where('PUNCHDATE','=','2021-01-17 00:00:00')
                    //->where('compcardid','=','000052044')
                    //->where('loc_id','=','214')
                    ->orderByDesc('compcardid')
                    ->take(10)
                    ->get();
        //$employee = DB::raw('select *from ATT_IN.tbl_raw_data where compcardid='000052046';')
        
        //dd($employee);
        */

        /* $date=date('d-m-Y', strtotime($date)); */
    }

    public function summary()
    {
        $datas = DB::table('attendances')
            ->select('date', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            /* ->where('buildings.building_name','=','Balaka') */
            ->groupBy('building_name', 'date')->get();
        //return $datas;
        return view('pages.summary', compact('datas'));
    }

    public function sumTwo(Request $request)
    {

        $year_month = $request->get('selectedMonth');

        $year = Carbon::parse($year_month)->year;
        $month = Carbon::parse($year_month)->month;


        $datas = DB::table('attendances')
            ->select('date', 'buildings.building_name', DB::raw('count(*) as Total'), DB::raw('DAY(date) as dayDB'), DB::raw('DAYNAME(date) as dayName'))
            ->join('buildings', 'attendances.building_id', '=', 'buildings.building_id')
            /* ->where('buildings.building_name','=','Balaka') */
            ->whereMonth('date', '=', $month)
            ->groupBy('date', 'attendances.building_id', 'building_name')
            ->orderBy('date')
            ->get();
        //return $datas;

        $totalDate = DB::table('attendances')
            ->select('date')
            ->distinct('date')
            ->get();

        $buildings = DB::table('attendances')
            ->select('building_name')
            ->join('buildings', 'attendances.building_id', '=', 'buildings.building_id')
            ->groupBy('buildings.building_id', 'building_name', DB::raw('MONTH(date)'))
            ->orderBy('buildings.building_id')
            ->distinct('building_name')
            ->get();

        //return $buildings;

        //return $datas;
        $date = date('M-Y', strtotime($year_month));
        //return $date;
        if ($date == "Jan-1970") {
            $date = Carbon::now()->format('M-Y');
        }

        return view('pages.sum2', compact('datas', 'totalDate', 'buildings', 'date'));
    }



    public function test()
    {

        $data = array(
            'title' => 'Alhamdulillah',
            'services' => ['Hello', 'No', 'YES']
        );
        return view('pages.test')->with($data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function individual()
    {

        $myDate = DB::table('attendances')->value('date');

        $year = Carbon::createFromFormat('Y-d-m', $myDate)->format('Y');
        $month = Carbon::createFromFormat('Y-d-m', $myDate)->format('m');
        //return $month;
        $datas = DB::table('attendances')
            ->select('employee_id', DB::raw('YEAR(date) as year'), DB::raw('count(*) as Total'))

            ->groupBy('employee_id', 'year')->get();

        return view('pages.individual', compact('datas'));
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function someRouteMethod(Request $request)
    {
        return redirect()->with('search_criteria', session('search_criteria'))->to('/attendance');
    }

    public function month()
    {

        return view('pages.month');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */

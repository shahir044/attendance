<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Attendance;
use App\Department;
use Carbon\Carbon;


class fileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadFile()
    {
        // in this view browse and upload file screen will appear , get thats why

        return view('pages.file_upload');
    }

    public function fileUploaded(Request $request)
    {
        // in this view file uploaded already so post hobe

        $curr_date = Carbon::now()->format('Y-m-d');

        $this->validate(request(), [
            'file' => 'mimes:txt'
        ]);

        $file = $request->file('var_file');
        //dd($file->extension());

        if ($file->extension() == "txt") {

            $file = File::get($file->getRealPath());

            DB::table('attendances')->delete();

            $uniqueValue = array();


            foreach (explode("\n", $file) as $line) {

                if (empty($line)) {
                    continue;
                }

                $machineId = (int)substr($line, 0, 3);
                //$date = (int) substr($line,3,6);

                $day = substr($line, 3, 2);
                $month = substr($line, 5, 2);
                $year =  '20' . substr($line, 7, 2);
                $demodate = $year . $month . $day;
                $date = DateTime::createFromFormat('Ymd', $demodate)->format('Y-m-d');


                $hour = substr($line, 9, 2);
                $minute = substr($line, 11, 2);
                $second = substr($line, 13, 2);
                $inTime = $hour. $minute. $second;
                //$Time=Carbon::createFromTime($hour, $minute, $second, $inTime);
                $time= Carbon::createFromFormat('His',$inTime)->format('h:i:s');

                //return $time;

                $employeeId = (int)substr($line, 19, 5);

                $tempValue = $uniqueValue[$employeeId][$date] ?? null;

                if (is_null($tempValue) && ($inTime >= 63000 && $inTime <= 103000)) {
                    $uniqueValue[$employeeId][$date] = 1;

                    /*get builing_id using machine_id from machine table*/

                    $building_id = DB::table('machines')
                        ->where('machine_id', '=', $machineId)
                        ->value('building_id');

                    $shop_id = DB::table('employees')
                        ->where('employee_id', '=', $employeeId)
                        ->value('shop_id');

                    $data = DB::table('attendances')->insert([
                        'date' => $date,
                        'in_time' => $time,
                        'employee_id' => $employeeId,
                        'building_id' => $building_id,
                        'shop_id' => $shop_id,
                        'machine_id' => $machineId
                    ]);


                    /* DB::table('employee')->insert([
                    'date' => $date,
                    'employee_id' => $employeeId,
                    'building_id' => $building_id,
                    'shop_id' => $shop_id,
                    'machine_id' => $machineId */
                    //return DateTime::createFromFormat('Ymd',$date)->format('d-m-Y');
                    //return $shop_id;
                    //return $building_id;
                    //echo ($employeeId);
                    //echo "<br>";
                }
            }
        }else {
            return redirect('/')->with('failed', "TRY AGAIN");
        }

        //$data = Attendance::all();
        /*         $data = DB::table('attendances')
            ->select('date','buildings.building_id', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            ->where('date','=',$curr_date)
            ->groupBy('date','buildings.building_id', 'building_name')->get();

        $total = DB::table('attendances')
            ->select('date',DB::raw('count(*) as Total'))
            ->where('date','=',$curr_date)
            ->get();
*/
        return redirect('/')->with('success', "File Uploaded successfully");
    }

    public function summary()
    {
        $datas = DB::table('attendances')
            ->select('date', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            ->groupBy('building_name', 'date')->get();
        //return $datas;
        return view('pages.summary', compact('datas'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function show($id, $date)
    {
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

        return view('pages.department', compact('data', 'total', 'date'));
    }

    public function showDepartmentDetails($id, $d_id, $selectedDate)
    {
        $date = $selectedDate;
        $data = DB::table('attendances')
            ->select('attendances.employee_id', 'employees.name', 'employees.designation', 'employees.department','attendances.in_time')
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
                ->where('attendances.shop_id', '=', $d_id)
                ->where('attendances.building_id', '=', $id)
                ->where('attendances.date', '=', $date))
            ->get();
        //return $absent;

        return view('pages.employee', compact('data', 'id', 'date', 'absent'));
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
            ->select('attendances.employee_id', 'name', 'designation', 'department', 'building_name','attendances.in_time')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->join('buildings', 'attendances.building_id', '=', 'buildings.building_id')
            ->where('date', '=', $date)
            ->where('name', 'like', '%' . $search . '%')
            /* ->orWhere('designation', 'like', '%'.$search.'%') */
            ->orderBy('attendances.employee_id', 'DESC')

            ->distinct()
            ->get();
        //return $search;

        if ($datas->isEmpty()) { 
        $absent = DB::table('employees')
            ->select('employee_id', 'name', 'designation', 'department')
            ->where('name', 'like', '%' . $search . '%')
            /* ->orWhere('designation', 'like', '%'.$search.'%') */
            /* ->orderBy('attendances.employee_id','DESC') */
            ->orderBy('employees.employee_id', 'DESC')
            ->distinct()
            ->get();
        } 

        return view('pages.search', compact('datas', 'absent', 'date'));
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

    public function attendance(Request $request)
    {
        $reqDate = $request->get('selectedDate');
        if (is_null($reqDate)) {
            $date = Carbon::now()->format('Y-m-d');
        } else {
            $date = $reqDate;
        }
        //$data = Attendance::all();
        //session(['search_criteria' => $request->input()]);


        //$reqDate = request('selectedDate');

        $data = DB::table('attendances')
            ->select('date', 'buildings.building_id', 'buildings.building_name', DB::raw('count(*) as Total'))
            ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
            ->where('date', '=', $date)
            ->groupBy('buildings.building_id', 'building_name', 'date')
            ->orderBy('buildings.building_name', 'ASC')->get();


        $total = DB::table('attendances')
            ->select(DB::raw('count(*) as Total'))
            ->where('date', '=', $date)
            ->get();

        return view('pages.todaysAttendance', compact('data', 'total', 'date'));
    }

    public function someRouteMethod(Request $request)
    {
        return redirect()->with('search_criteria', session('search_criteria'))->to('/attendance');
    }

    public function month()
    {

        return view('pages.month');
    }
    
    public function individual()
    {

        $myDate = DB::table('attendances')->value('date');
        
        $year = Carbon::createFromFormat('Y-d-m', $myDate)->format('Y');
        $month = Carbon::createFromFormat('Y-d-m', $myDate)->format('m');
        //return $month;
        $datas = DB::table('attendances')
            ->select('employee_id',DB::raw('YEAR(date) as year'), DB::raw('count(*) as Total'))
            
            ->groupBy('employee_id','year')->get();
        
            return view('pages.individual', compact('datas'));
        
        
    }
}

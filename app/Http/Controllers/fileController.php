<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Unique;
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
        
        $file = $request->file('var_file');
        $file = File::get($file->getRealPath());

        //DB::table('attendances')->delete();

        $uniqueValue = array();
        

        foreach (explode("\n", $file) as $line) {
            $machineId = (int)substr($line, 0, 3);
            //$date = (int) substr($line,3,6);

            $day = substr($line, 3, 2);
            $month = substr($line, 5, 2);
            $year =  '20' . substr($line, 7, 2);
            $demodate = $year . $month . $day;
            $date = DateTime::createFromFormat('Ymd', $demodate)->format('Y-m-d');

            $inTime = (int)substr($line, 9, 6);
            $employeeId = (int)substr($line, 19, 5);

            $tempValue = $uniqueValue[$employeeId] ?? null;

            if (is_null($tempValue) && ($inTime >= 63000 && $inTime <= 103000)) {
                $uniqueValue[$employeeId] = 1;

                /*get builing_id using machine_id from machine table*/

                $building_id = DB::table('machines')
                    ->where('machine_id', '=', $machineId)
                    ->value('building_id');

                $shop_id = DB::table('employees')
                    ->where('employee_id', '=', $employeeId)
                    ->value('shop_id');

                $data = DB::table('attendances')->insert([
                    'date' => $date,
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
            ->groupBy('building_name','date')->get();
            //return $datas;
        return view('pages.summary',compact('datas'));
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
    public function show($id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $data = DB::table('attendances')
            ->select('attendances.shop_id', 'department_name', 'attendances.building_id', DB::raw('count(*) as Total'))
            ->rightjoin('departments', 'attendances.shop_id', '=', 'departments.shop_id')
            ->where('date','=',$date)
            ->where('attendances.building_id', '=', $id)
            ->groupBy('department_name', 'attendances.shop_id', 'attendances.building_id')
            ->get();

        $total = DB::table('attendances')
        ->select('building_name' ,DB::raw('count(*) as Total'))
        ->join('buildings','attendances.building_id','=','buildings.building_id')
        ->where('date','=',$date)
        ->where('attendances.building_id','=',$id)
        ->groupBy('building_name')
        ->get();
        
        return view('pages.department',compact('data','total'));
    }

    public function showDepartmentDetails($id, $d_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $data = DB::table('attendances')
            ->select('attendances.employee_id', 'name', 'designation','department_name')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->join('departments', 'attendances.shop_id', '=', 'departments.shop_id')
            ->where('date','=',$date)
            ->where('attendances.shop_id', '=', $d_id)
            ->get();

        $absent = DB::table('employees')
        ->select('employee_id','name', 'designation')
        ->where('employees.shop_id', '=', $d_id)
        ->whereNotIn('employee_id',DB::table('attendances')
        ->select('attendances.employee_id')
        ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
        ->join('departments', 'attendances.shop_id', '=', 'departments.shop_id')
        ->where('date','=',$date)
        ->where('attendances.shop_id', '=', $d_id))
        ->get();
        //return $absent;

        return view('pages.employee', compact('data','id','date','absent'));
    }


    public function search(Request $request)
    {
        $search = $request->get('search');
        $date = Carbon::now()->format('Y-m-d');

        $absent=[];
        
        

        $datas = DB::table('attendances')
            ->select('attendances.employee_id', 'name', 'designation','department_name')
            ->join('employees', 'attendances.employee_id', '=', 'employees.employee_id')
            ->join('departments', 'attendances.shop_id', '=', 'departments.shop_id')
            ->where('date','=',$date)
            ->where('name', 'like', '%'.$search.'%')
            ->orWhere('designation', 'like', '%'.$search.'%')
            ->distinct()
            ->get();
            //return $search;
            
            if($datas->isEmpty()){
                $absent = DB::table('employees')
                ->select('employee_id', 'name', 'designation','department_name')
                ->join('departments', 'employees.shop_id', '=', 'departments.shop_id')
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('designation', 'like', '%'.$search.'%')
                ->distinct()
                ->get();
            }

            return view('pages.search',compact('datas','absent','date'));
        
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

    public function attendance()
    {
         //$data = Attendance::all();
         $date = Carbon::now()->format('Y-m-d');
         $data = DB::table('attendances')
         ->select('date','buildings.building_id', 'buildings.building_name', DB::raw('count(*) as Total'))
         ->join('buildings', 'buildings.building_id', '=', 'attendances.building_id')
         ->where('date','=',$date)
         ->groupBy('date','buildings.building_id', 'building_name')->get();

     $total = DB::table('attendances')
         ->select(DB::raw('count(*) as Total'))
         ->where('date','=',$date)->get();
     
     return view('pages.todaysAttendance', compact('data','total','date'));
    }



}

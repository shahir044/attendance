<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Attendance;
use App\Department;
use Carbon\Carbon;
use Cron\MonthField;

class FileUploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
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

            //DB::table('attendances')->delete();

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
                $inTime = $hour . $minute . $second;
                //$Time=Carbon::createFromTime($hour, $minute, $second, $inTime);
                $time = Carbon::createFromFormat('His', $inTime)->format('h:i:s');

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

                    $data = DB::table('attendances')->insertorIgnore([
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
        } else {
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
        return redirect('/attendance')->with('success', "File Uploaded successfully");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
}

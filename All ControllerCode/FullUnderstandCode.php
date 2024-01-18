<?php

class ZipController extends Controller
{
//*
// 22222222222222222222222222222222222222222222222222222222222222222222222222
// app\Http\Controllers\TimesheetController.php
// } else {  only understand else part in this 
  // !old code 20-12-23
  public function timesheet_mylist()
  {
    if (auth()->user()->role_id == 13) {
      // die;
      $client = Client::select('id', 'client_name')->get();
      $getauth =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '0')
        ->orderby('id', 'desc')->first();

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');


      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();

      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      $time =  DB::table('timesheets')->get();
      foreach ($time as $value) {
        //dd(date('F', strtotime($value->date)));
        DB::table('timesheets')->where('id', $value->id)->update([
          'month'         =>     date('F', strtotime($value->date)),
        ]);
      }
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // dd($timesheetData);

      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', auth()->user()->teammember_id)
      //   ->where('timesheetusers.status', 1)
      //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // // dd($timesheetData);
      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        // shahid
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
    } else {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      // dd($dropdownYears);
      // 0 => 2024
      // 1 => 2023

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      // dd($dropdownMonths);
      // 0 => "October"
      // 1 => "December"
      // 2 => "November"
      // 3 => "January"
      // 4 => "February"

      $currentDate = now();
      // 2024-01-16 00:46:21.610590

      $month = $currentDate->format('F');
      // "January"
      $year = $currentDate->format('Y');
      // "2024"



      $getauths =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        ->orderby('id', 'desc')->first();
      if ($getauths != null) {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '1')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      } else {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        // dd($getauth);
      }

      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();

      $client = Client::select('id', 'client_name')->get();

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        //   ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      // dd($timesheetrequest);
      // +"validate": "2024-01-09"
      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact(
          'timesheetData',
          'getauth',
          'client',
          'partner',
          'timesheetrequest',
          'dropdownYears',
          'dropdownMonths',
          'month',
          'year',
        ));
      }
    }
  }
// 22222222222222222222222222222222222222222222222222222222222222222222222222
// app\Http\Controllers\TimesheetrequestController.php
public function timesheetsubmission(Request $request)
    {


        try {
            $usertimesheetfirstdate =  DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
            $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

            if ($usertimesheetfirstdate) {
                // Convert the retrieved date to a DateTime object
                $firstDate = new DateTime($usertimesheetfirstdate->date);
                // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

                // Find the day of the week for the first date (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                $dayOfWeek = $firstDate->format('w');
                // 6
                $daysToAdd = 0;
                if ($dayOfWeek !== '0') {
                    $daysToAdd = 7 - $dayOfWeek;
                    // 1
                } else {
                    $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                    return back()->with('success', $output);
                }

                if ($dayOfWeek > 0) {
                    $daysToSubtract = $dayOfWeek - 1;
                    //5

                } else {
                    $daysToSubtract = $dayOfWeek;
                }

                $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
                // "2023-11-19"
                $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                // "2023-11-13"

            }



            $get_six_Data = DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)
                ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                ->orderBy('date', 'ASC')
                ->get();

            $lastdate = $get_six_Data->max('date');


            $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

            foreach ($get_six_Data as $entry) {
                $date = new DateTime($entry->date);
                $retrievedDates[] = $date->format('Y-m-d');
            }
            //   0 => "2023-11-15"
            //   1 => "2023-11-16"
            //   2 => "2023-11-17"




            $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

            $firstDate = new DateTime($presentWeekMonday);
            // date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)
            $upcomingSundayDate = new DateTime($upcomingSunday);


            // Clone $firstDate so that it is not modified
            $currentDate = clone $firstDate;
            // date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)

            while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                $expectedDates[] = $currentDate->format('Y-m-d');

                // 0 => "2023-11-13"
                $currentDate->modify("+1 day");
                // date: 2023-11-14 00:00:00.0 Asia/Kolkata (+05:30)

            }
            // Check for missing dates
            $missingDates = array_diff($expectedDates, $retrievedDates);
            // 0 => "2023-11-13"
            // 1 => "2023-11-14"
            //  otherwise []


            if (!empty($missingDates)) {
                $missingDatesString = implode(', ', $missingDates);
                // "2023-11-13, 2023-11-14"


                $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                // "msg" => "Timesheet Submit Failed Missing dates: 2023-11-13, 2023-11-14"
                return back()->with('success', $output);
            } else {   //"All dates present"    //------------------- Suhail's code end---------------------

                foreach ($get_six_Data as $getsixdata) {
                    // dd('hi', $getsixdata);

                    // Convert the requested date to a Carbon instance
                    $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);
                    // date: 2023-11-13 12:47:54.0 Asia/Kolkata (+05:30)

                    if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

                        $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                        // date: 2023-11-06 00:00:00.0 Asia/Kolkata (+05:30)
                        // dd($previousMonday);
                        // Find the nearest next Saturday to the requested date
                        $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                        // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

                        // Format the dates in 'Y-m-d' format
                        $previousMondayFormatted = $getsixdata->date;
                        // "2023-11-13"
                        $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                        // "2023-11-18"
                        $nextSaturdayFormatted = $lastdate;
                        // "2023-11-18"


                        $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                        // "13-11-2023 to 18-11-2023"

                        // $co = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)
                        //     ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                        //     ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                        //     ->groupBy('partner')
                        //     ->get();
                        //! good
                        $co = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                            ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                            ->get();


                        // when one patner then 
                        //   +"partner": 887
                        //   +"total_hours": 48.0
                        //   +"row_count": 6

                        // when two patner then 
                        // 0 => {#3490 ▼
                        //     +"partner": 844
                        //     +"total_hours": 8.0
                        //     +"row_count": 1
                        //   }
                        //   1 => {#3487 ▼
                        //     +"partner": 887
                        //     +"total_hours": 40.0
                        //     +"row_count": 5
                        //   }

                        dd($co);
                        foreach ($co as $codata) {
                            DB::table('timesheetreport')->insert([
                                'teamid'       =>     auth()->user()->teammember_id,
                                'week'       =>     $week,
                                'totaldays'       =>     $codata->row_count,
                                'totaltime' =>  $codata->total_hours,
                                // 'partnerid'  => $codata->partner,
                                'startdate'  => $previousMondayFormatted,
                                'enddate'  => $nextSaturdayFormatted,
                                // 'created_at'                =>       date('y-m-d'),
                                'created_at'                =>      date('y-m-d H:i:s'),
                            ]);
                        }

                        // dd($co);
                    }
                    dd('ho', $getsixdata->id);


                    DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                    DB::table('timesheets')->where('id', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
            }


            $output = array('msg' => 'Timesheet Submit Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

// 2222222222222222222222222222222222222222222222222222222222222222
// applyleave controller update function 
if ($request->status == 1) {
  $team = DB::table('leaverequest')
    ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
    ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    ->where('leaverequest.id', $id)
    ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
    ->first();


if ($team->name == 'Exam Leave') {

  $from = Carbon::createFromFormat('Y-m-d', $team->from);
  //2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
  $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
  // 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
  $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
  // dd($camefromexam);
  // $nowrequestdays = $to->diffInDays($camefromexam) + 1;
  // remove days from database 
  $removedays = $to->diffInDays($camefromexam) + 1;
  // dd($removedays);
  // my total leave now after coming
  $nowtotalleave = $from->diffInDays($camefromexam);
  // 5 days
  // dd($nowtotalleave);
  // for serching from data base 
  $finddatafromleaverequest = $to->diffInDays($from) + 1;
  // dd($finddatafromleaverequest);
  // 9
  // dd($finddatafromleaverequest);

  // dd($requestdays);
  // $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
  //   ->where('enddate', '<=', $team->to)
  //   ->count();
  // //0
  // $totalrqstday = $nowrequestdays - $holidaycount;
  // 9
  // dd($holidaycount);
  // dd($totalrqstday);

  DB::table('leaveapprove')
    ->where('teammemberid', $team->createdby)
    ->where('totaldays', $finddatafromleaverequest)
    ->latest()
    ->update([
      'totaldays' => $nowtotalleave,
      'updated_at' => now(),
    ]);
  // dd($finddatafromleaverequest);

  // dd($team->from);
  // "2023-12-16"
  // dd($team->date);
  // "2023-12-20"
  // dd($team->to);
  // "2023-12-24"
  //! working one delete ek baar me
  // // $period = CarbonPeriod::create($team->date, $team->to);
  // $period = CarbonPeriod::create('2023-12-21', $team->to);
  // // dd($period);
  // $datess = [];
  // foreach ($period as $date) {
  //   $datess[] = $date->format('Y-m-d');
  //   // dd($datess);
  //   $deletedIds = DB::table('timesheets')
  //     ->where('created_by', $team->createdby)
  //     ->where('date', $datess)
  //     ->pluck('id');
  //   // dd($deletedIds);

  //   DB::table('timesheets')
  //     ->where('created_by', $team->createdby)
  //     ->where('date', $datess)
  //     ->delete();

  //   $a = DB::table('timesheetusers')
  //     ->whereIn('timesheetid', $deletedIds)
  //     ->delete();
  // }
  // dd($datess);
  // dd($deletedIds);

  $period = CarbonPeriod::create($team->date, $team->to);

  $datess = [];
  foreach ($period as $date) {
    $datess[] = $date->format('Y-m-d');

    $deletedIds = DB::table('timesheets')
      ->where('created_by', $team->createdby)
      ->whereIn('date', $datess)
      ->pluck('id');

    DB::table('timesheets')
      ->where('created_by', $team->createdby)
      ->whereIn('date', $datess)
      ->delete();

    $a = DB::table('timesheetusers')
      ->whereIn('timesheetid', $deletedIds)
      ->delete();
  }

  // dd($datess);


  // $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
  //   ->where('enddate', '<=', $team->to)->select('startdate')->get();

  // if (count($getholidays) != 0) {
  //   foreach ($getholidays as $date) {
  //     $hdatess[] = date('Y-m-d', strtotime($date->startdate));
  //   }
  // } else {
  //   $hdatess[] = 0;
  // }

  // dd($hdatess);
  $el_leave = $datess;
  // 0 => "2023-09-16"
  // 1 => "2023-09-17"
  // 2 => "2023-09-18"
  // $exam_leave_total = count(array_diff($datess, $hdatess));
  // 62


  // $lstatus = "EL/A";
  // $lstatus = "Null";
  // $lstatus = "";
  $lstatus = null;

  foreach ($el_leave as $cl_leave) {
    // date get one by one 

    $cl_leave_day = date('d', strtotime($cl_leave));
    // "16"



    $cl_leave_month = date('F', strtotime($cl_leave));

    // September
    // dd($cl_leave_month);
    // dd($cl_leave_day);
    // 16
    if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
      $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
    }
    // dd('hi1', $team->createdby);
    // 802
    $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
      ->where('month', $cl_leave_month)->first();
    // September
    // dd($attendances);
    //  dd($value->created_by);

    // dd('hi2', $attendances);
    // dd($cl_leave_day);
    // 16
    $column = '';
    switch ($cl_leave_day) {
      case '26':
        $column = 'twentysix';
        break;
      case '27':
        $column = 'twentyseven';
        break;
      case '28':
        $column = 'twentyeight';
        break;
      case '29':
        $column = 'twentynine';
        break;
      case '30':
        $column = 'thirty';
        break;
      case '31':
        $column = 'thirtyone';
        break;
      case '01':
        $column = 'one';
        break;
      case '02':
        $column = 'two';
        break;
      case '03':
        $column = 'three';
        break;
      case '04':
        $column = 'four';
        break;
      case '05':
        $column = 'five';
        break;
      case '06':
        $column = 'six';
        break;
      case '07':
        $column = 'seven';
        break;
      case '08':
        $column = 'eight';
        break;
      case '09':
        $column = 'nine';
        break;
      case '10':
        $column = 'ten';
        break;
      case '11':
        $column = 'eleven';
        break;
      case '12':
        $column = 'twelve';
        break;
      case '13':
        $column = 'thirteen';
        break;
      case '14':
        $column = 'fourteen';
        break;
      case '15':
        $column = 'fifteen';
        break;
      case '16':
        $column = 'sixteen';
        break;
      case '17':
        $column = 'seventeen';
        break;
      case '18':
        $column = 'eighteen';
        break;
      case '19':
        $column = 'ninghteen';
        break;
      case '20':
        $column = 'twenty';
        break;
      case '21':
        $column = 'twentyone';
        break;
      case '22':
        $column = 'twentytwo';
        break;
      case '23':
        $column = 'twentythree';
        break;
      case '24':
        $column = 'twentyfour';
        break;
      case '25':
        $column = 'twentyfive';
        break;
    }
    // dd('pa', $column);
    // sixteen
    // dd('pa', $lstatus);
    // EL/A
    if (!empty($column)) {
      // store EL/A sexteen to 25 tak 
      DB::table('attendances')
        ->where('employee_name', $team->createdby)
        ->where('month', $cl_leave_month)
        ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
        ->whereRaw("{$column} != 'LWP'")
        ->update([
          $column => $lstatus,
        ]);
    }
    // if (!empty($column)) {
    //   // store EL/A sexteen to 25 tak 
    //   DB::table('attendances')
    //     ->where('employee_name', $team->createdby)
    //     ->where('month', $cl_leave_month)
    //     ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
    //     ->whereRaw("{$column} != 'LWP'")
    //     ->delete();
    // }
  }
  // dd('hq');
}
}
dd('end hare ', $team->name);

}
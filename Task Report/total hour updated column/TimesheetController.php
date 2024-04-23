<?php

namespace App\Http\Controllers;

use App\Models\Teammember;
use App\Models\Timesheet;
use App\Models\Assignmentmapping;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignment;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DB;
use Excel;
use DateTime;

class TimesheetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function __construct()
  {
    // dd('hi');
    $this->middleware('auth');
  }

  // After click timesheet report tab
  public function mytimesheetlist(Request $request, $teamid)
  {


    // $nextweektimesheet = DB::table('timesheetreport')
    //   ->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-26 20:19:53'])
    //   ->whereNull('partnerid')
    //   ->select('id', 'teamid', 'startdate', 'enddate', 'totaltime', 'created_at')
    //   // ->latest()
    //   ->get();
    // // dd($nextweektimesheet);

    // foreach ($nextweektimesheet as $nextweektimesheets) {
    //   $week =  date('d-m-Y', strtotime($nextweektimesheets->startdate))  . ' to ' . date('d-m-Y', strtotime($nextweektimesheets->enddate));
    //   $co = DB::table('timesheetusers')
    //     ->where('createdby', $nextweektimesheets->teamid)
    //     ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
    //     ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //     ->groupBy('partner')
    //     ->get();

    //   foreach ($co as $codata) {
    //     DB::table('timesheetreport')->insert([
    //       'teamid'       =>     $nextweektimesheets->teamid,
    //       'week'       =>     $week,
    //       'totaldays'       =>     $codata->row_count,
    //       'totaltime' =>  $codata->total_hours,
    //       'partnerid'  => $codata->partner,
    //       'startdate'  => $nextweektimesheets->startdate,
    //       'enddate'  => $nextweektimesheets->enddate,
    //       'created_at'                =>      $nextweektimesheets->created_at,
    //     ]);
    //   }

    //   $deletedata = DB::table('timesheetreport')
    //     ->where('id', $nextweektimesheets->id)
    //     ->delete();
    // }











    // 333333333333333333333333333333333333333333333333333333333333333333333333333333333

    // dd($timesheetdata);

    // ->whereBetween('date', ['2024-03-11', '2024-03-16'])
    // ->where('createdby', 847)
    // ->get();
    // ->update(['status' => 0]);


    // 222222222222222222222222222222222222

    // $partners = [847, 765];
    // DB::table('timesheetreport')->insert([
    //   'teamid' => 847,
    //   'partnerid' => json_encode($partners), // Convert array to JSON string
    //   'created_at'                =>      date('y-m-d H:i:s'),
    // ]);

    // $timesheetreport = DB::table('timesheetreport')->latest()->first();
    // $partnerIds = json_decode($timesheetreport->partnerid, true);

    // dd($partnerIds);


    // $data = DB::table('timesheetreport')
    //   ->whereIn('partnerid', 9876)
    //   ->get();
    // dd($data);

    // $timesheetreport = DB::table('timesheetreport')->latest()->first();
    // $partnerIds = json_decode($timesheetreport->partnerid, true);

    // // dd($partnerIds); // Verify the partnerIds array

    // // Initialize an empty array to store the results
    // $data = [];

    // // Iterate over each partnerId and query the database
    // // foreach ($partnerIds as $partnerId) {
    // $result = DB::table('timesheetreport')
    //   ->whereJsonContains('partnerid', 844)
    //   ->get()->toArray();

    // dd($result);

    // //   array:2 [▼
    // //   0 => 9876
    // //   1 => 9987
    // // ]

    // // Start Hare 
    // $nextweektimesheet = DB::table('timesheetusers')
    //   ->where('createdby', 847)
    //   ->whereBetween('date', ['2024-03-11', '2024-03-16'])
    //   // ->get();
    //   ->update(['status' => 0]);


    // $nextweektimesheet = DB::table('timesheets')
    //   ->where('created_by', 847)
    //   ->whereBetween('date', ['2024-03-11', '2024-03-16'])
    //   // ->get();
    //   ->update(['status' => 0]);

    // $nextweektimesheet = DB::table('timesheetreport')
    //   ->where('teamid', 847)
    //   ->where('startdate', '2024-03-11')
    //   // ->get();
    //   ->delete();

    // dd('hi');


    // 222222222222222222222222222222222222

    // $assignments = DB::table('assignmentbudgetings')
    //   // ->whereBetween('created_at', ['2024-01-01 16:45:30', '2024-03-21 16:45:30'])
    //   ->whereBetween('created_at', ['2023-09-01 16:45:30', '2023-12-31 16:45:30'])
    //   ->where('status', 1)
    //   ->select('assignmentgenerate_id', 'client_id', 'assignment_id', 'created_at')
    //   ->orderBy('id', 'DESC')
    //   ->get();

    // $date = date('Y-m-d', strtotime($assignments[117]->created_at));

    // $updatedcode =  DB::table('timesheetusers')
    //   // ->whereBetween('date', [$date, '2024-03-22'])
    //   // ->whereBetween('date', [$date, '2024-02-07'])
    //   ->where('client_id', $assignments[117]->client_id)
    //   ->where('assignment_id', $assignments[117]->assignment_id)
    //   // ->where('partner', 842)
    //   // ->where('createdby', 856)
    //   // ->whereNotIn('createdby', [234, 453])
    //   ->get();
    // // ->update(['assignmentgenerate_id' => $assignments[117]->assignmentgenerate_id]);
    // // ->update(['assignmentgenerate_id' => 'hi']);

    // dd($assignments);
    // // dd($assignments);



    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();

      // dd($timesheetData);
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();

      // dd($timesheetData);
    }
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }

  // timesheet download after search.it is for own timesheet only for staff,manager,patner
  // public function searchingtimesheet(Request $request)
  // {
  //   // dd($request, 'hi1');
  //   // Get all input from form
  //   $startDate = $request->input('startdate', null);
  //   $endDate = $request->input('enddate', null);
  //   $teamId = $request->input('teamid', null);
  //   $teammemberId = $request->input('teammemberId', null);
  //   $year = $request->input('year', null);

  //   $teammembers = DB::table('teammembers')
  //     ->where('status', 1)
  //     ->whereIn('role_id', [14, 15, 13, 11])
  //     ->select('team_member', 'id', 'staffcode')
  //     ->orderBy('team_member', 'ASC')
  //     ->get();

  //   // For patner
  //   if (auth()->user()->role_id == 13) {
  //     if (($startDate != null && $endDate != null) || $request->year != null) {
  //       $timesheetData = DB::table('timesheetusers')
  //         ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //         // When startDate and endDate exist then run 'when' clouse
  //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
  //           // dd('1 one');
  //           return $query->where('timesheetusers.createdby', $teamId)
  //             ->where('timesheetusers.date', '>=', $startDate)
  //             ->where('timesheetusers.date', '<=', $endDate);
  //         })
  //         ->whereIn('timesheetusers.status', [1, 2, 3])
  //         ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //         ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //         ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //         ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
  //         ->orderBy('date', 'DESC')
  //         ->get();
  //       // dd($timesheetData);
  //       $request->flash();
  //       return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  //     }
  //   }
  //   // For staff and manager
  //   else {
  //     if (($startDate != null && $endDate != null) || $request->year != null) {
  //       $timesheetData = DB::table('timesheetusers')
  //         ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //         // When startDate and endDate exist then run 'when' clouse
  //         ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
  //           return $query->where('timesheetusers.createdby', $teamId)
  //             ->where('timesheetusers.date', '>=', $startDate)
  //             ->where('timesheetusers.date', '<=', $endDate);
  //         })
  //         ->whereIn('timesheetusers.status', [1, 2, 3])
  //         ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //         ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //         ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //         ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
  //         ->orderBy('date', 'DESC')
  //         ->get();

  //       $request->flash();
  //       return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  //     }
  //   }
  // }

  // Remove when clouse in this function 
  public function searchingtimesheet(Request $request)
  {
    // Get all input from form
    $startDate = $request->input('startdate', null);
    $endDate = $request->input('enddate', null);
    $teamId = $request->input('teamid', null);
    $teammemberId = $request->input('teammemberId', null);
    $year = $request->input('year', null);

    $teammembers = DB::table('teammembers')
      ->where('status', 1)
      ->whereIn('role_id', [14, 15, 13, 11])
      ->select('team_member', 'id', 'staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    // For patner
    if (auth()->user()->role_id == 13) {
      $query = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->orderBy('date', 'DESC');

      if ($startDate && $endDate && $teamId) {
        $query->where(function ($q) use ($startDate, $endDate, $teamId) {
          $q->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        });
      }

      $timesheetData = $query->get();
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
    // For staff and manager
    else {

      $query = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->orderBy('date', 'DESC');

      if ($startDate && $endDate && $teamId) {
        $query->where(function ($q) use ($startDate, $endDate, $teamId) {
          $q->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        });
      }
      $timesheetData = $query->get();
      // dd($timesheetData);

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }

  // timesheet download on admin and patner team
  // public function admintimesheetlist(Request $request)
  // {
  //   $teammembers = DB::table('teammembers')
  //     ->where('status', 1)
  //     ->whereIn('role_id', [14, 15, 13, 11])
  //     ->select('team_member', 'id', 'staffcode')
  //     ->orderBy('team_member', 'ASC')
  //     ->get();

  //   $clientsname = DB::table('clients')
  //     ->whereIn('status', [0, 1])
  //     ->select('id', 'client_name', 'client_code')
  //     ->orderBy('client_name', 'ASC')
  //     ->get();

  //   $assignmentsname = DB::table('assignments')
  //     ->where('status', 1)
  //     ->select('id', 'assignment_name')
  //     ->orderBy('assignment_name', 'ASC')
  //     ->get();

  //   // dd($assignmentsname);

  //   if (auth()->user()->role_id == 11) {

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       // ->where('timesheetusers.createdby', $teamid)
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //       ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //       ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
  //       ->orderBy('date', 'DESC')
  //       ->take(7)
  //       ->get();
  //   }
  //   // for patner team 
  //   else {
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->where('timesheetusers.partner', auth()->user()->teammember_id)
  //       ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //       ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //       ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
  //       ->orderBy('date', 'DESC')
  //       ->take(7)
  //       ->get();

  //     // dd($teammembers);
  //   }
  //   return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  // }

  // timesheet download on admin and patner team
  public function admintimesheetlist(Request $request)
  {
    $teammembers = DB::table('teammembers')
      ->where('status', 1)
      ->whereIn('role_id', [14, 15, 13, 11])
      ->select('team_member', 'id', 'staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    $clientsname = DB::table('clients')
      ->whereIn('status', [0, 1])
      ->select('id', 'client_name', 'client_code')
      ->orderBy('client_name', 'ASC')
      ->get();

    $assignmentsname = DB::table('timesheetusers')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereNotNull('assignmentbudgetings.assignmentname')
      ->select('timesheetusers.*', 'assignmentbudgetings.assignmentname')
      ->orderBy('assignmentname', 'Asc')
      ->distinct('assignmentname')
      ->get();

    if (auth()->user()->role_id == 11) {

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();
    }
    // for patner team 
    else {
      // die;
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();

      // dd($teammembers);
    }
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }


  // public function adminsearchtimesheet(Request $request)
  // {
  //   // dd($request, 'hi2');
  //   // Get all input from form
  //   $startDate = $request->input('startdate', null);
  //   $endDate = $request->input('enddate', null);
  //   $teamId = $request->input('teamid', null);
  //   $teammemberId = $request->input('teammemberId', null);
  //   $year = $request->input('year', null);
  //   $clientId = $request->input('clientId', null);
  //   $assignmentId = $request->input('assignmentId', null);

  //   $teammembers = DB::table('teammembers')
  //     ->where('status', 1)
  //     ->whereIn('role_id', [14, 15, 13, 11])
  //     ->select('team_member', 'id', 'staffcode')
  //     ->orderBy('team_member', 'ASC')
  //     ->get();

  //   $clientsname = DB::table('clients')
  //     ->whereIn('status', [0, 1])
  //     ->select('id', 'client_name', 'client_code')
  //     ->orderBy('client_name', 'ASC')
  //     ->get();

  //   $assignmentsname = DB::table('assignments')
  //     ->where('status', 1)
  //     ->select('id', 'assignment_name')
  //     ->orderBy('assignment_name', 'ASC')
  //     ->get();

  //   if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       // When startDate and endDate exist then run 'when' clause
  //       ->when($startDate && $endDate && $teammemberId && $year, function ($query) use ($startDate, $endDate, $teammemberId) {
  //         // dd('teammemberId');
  //         return $query->where('timesheetusers.createdby', $teammemberId)
  //           ->where('timesheetusers.date', '>=', $startDate)
  //           ->where('timesheetusers.date', '<=', $endDate);
  //       })
  //       ->when($startDate && $endDate && $clientId && $year, function ($query) use ($startDate, $endDate, $clientId) {
  //         // dd($clientId);
  //         return $query->where('timesheetusers.client_id', $clientId)
  //           ->where('timesheetusers.date', '>=', $startDate)
  //           ->where('timesheetusers.date', '<=', $endDate);
  //       })
  //       ->when($startDate && $endDate && $assignmentId && $year, function ($query) use ($startDate, $endDate, $assignmentId) {
  //         // dd('assignmentId');
  //         return $query->where('timesheetusers.assignment_id', $assignmentId)
  //           ->where('timesheetusers.date', '>=', $startDate)
  //           ->where('timesheetusers.date', '<=', $endDate);
  //       })
  //       ->when($startDate && $endDate && $year && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate, $year) {
  //         // dd('year');
  //         return $query->where('timesheetusers.date', '>=', $startDate)
  //           ->where('timesheetusers.date', '<=', $endDate);
  //       })
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //       ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //       ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
  //       ->orderBy('date', 'DESC')
  //       ->get();

  //     $request->flash();
  //     return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  //   }
  // }

  public function adminsearchtimesheet(Request $request)
  {
    // dd($request, 'hi2');
    // Get all input from form
    $startDate = $request->input('startdate', null);
    $endDate = $request->input('enddate', null);
    $teamId = $request->input('teamid', null);
    $teammemberId = $request->input('teammemberId', null);
    $year = $request->input('year', null);
    $clientId = $request->input('clientId', null);
    $assignmentId = $request->input('assignmentId', null);

    $teammembers = DB::table('teammembers')
      ->where('status', 1)
      ->whereIn('role_id', [14, 15, 13, 11])
      ->select('team_member', 'id', 'staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    $clientsname = DB::table('clients')
      ->whereIn('status', [0, 1])
      ->select('id', 'client_name', 'client_code')
      ->orderBy('client_name', 'ASC')
      ->get();

    $assignmentsname = DB::table('timesheetusers')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereNotNull('assignmentbudgetings.assignmentname')
      ->select('timesheetusers.*', 'assignmentbudgetings.assignmentname')
      ->orderBy('assignmentname', 'Asc')
      ->distinct('assignmentname')
      ->get();

    if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clause
        ->when($startDate && $endDate && $teammemberId && $year, function ($query) use ($startDate, $endDate, $teammemberId) {
          // dd('teammemberId');
          return $query->where('timesheetusers.createdby', $teammemberId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->when($startDate && $endDate && $clientId && $year, function ($query) use ($startDate, $endDate, $clientId) {
          // dd($clientId);
          return $query->where('timesheetusers.client_id', $clientId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->when($startDate && $endDate && $assignmentId && $year, function ($query) use ($startDate, $endDate, $assignmentId) {
          // dd('assignmentId');
          return $query->where('timesheetusers.assignmentgenerate_id', $assignmentId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->when($startDate && $endDate && $year && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate, $year) {
          // dd('year');
          return $query->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->orderBy('date', 'DESC')
        ->get();

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
    }
  }


  public function timesheetupdatesubmit(Request $request)
  {
    // dd($request);
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $conversion = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->where('timesheetusers.id', $request->id)
          ->select('teammembers.team_member', 'timesheetusers.*')->first();
        //  dd($conversion);
        return response()->json($conversion);
      }
    }
  }
  public function full_list()
  {

    $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
      ->where('teammembers.status', '1')->distinct()->get();
    //  dd($teammember);
    $month = DB::table('timesheets')
      ->select('timesheets.month')->distinct()->get();
    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($month);
    $timesheetData = DB::table('timesheets')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(30);
    // dd($timesheetData);
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }
  public function allteamsubmitted()
  {
    // die;
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.emailid', 'partners.team_member as partnername', 'teammembers.emailid')
      ->latest()->get();

    $permissiontimesheet = DB::table('timesheetreport')->first();

    // maping double date ************
    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'emailid' => $firstItem->emailid,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }

  public function timesheet_mylist()
  {
    if (auth()->user()->role_id == 13) {

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

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();
      $currentDate = now();
      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');
      // <<<
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname')->orderBy('date', 'ASC')
        ->paginate(14);

      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
    } else {
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $currentDate = now();
      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      $getauths =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        ->orderby('id', 'desc')->first();
      // dd($getauths);

      if ($getauths != null) {
        // get current date
        $currentDate = now();
        $currentDateformate = $currentDate->format('Y-m-d');
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          // stop future leave timesheet save wla 
          ->where('date', '<=', $currentDateformate)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
      } else {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      }

      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();


      $client = Client::select('id', 'client_name')->get();

      // <<<
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        //   ->where('timesheets.month', $month)
        //  ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname')->orderBy('date', 'ASC')
        ->paginate(14);


      $partner = Teammember::whereNotIn('id', [887, 663])->where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

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

  // public function timesheet_teamlist()
  // {
  //   // dd('hi');
  //   if (auth()->user()->role_id == 13) {
  //     // get all partner
  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();

  //     $get_datess = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   } else {

  //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
  //       ->orderBy('team_member', 'asc')->get();
  //     $get_datess = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest()->get();
  //   }

  //   $groupedData = $get_datess->groupBy(function ($item) {
  //     return $item->team_member . '|' . $item->week;
  //   })->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object)[
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //     ];
  //   });


  //   $get_date = collect($groupedData->values());


  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  // }

  public function timesheet_teamlist()
  {

    if (auth()->user()->role_id == 13) {
      // get all partner
      // dd('hi');
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.emailid', 'partners.team_member as partnername')
        ->latest()->get();

      // For permission
      $permissiontimesheet = DB::table('timesheetreport')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->first();
      // dd($get_datess);
    } else {

      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();
      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.emailid', 'partners.team_member as partnername')
        ->latest()->get();

      // For permission working 
      $permissiontimesheet = DB::table('timesheetreport')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->first();
    }

    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'emailid' => $firstItem->emailid,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());


    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner', 'permissiontimesheet'));
  }


  public function partnersubmitted()
  {
    // 844
    // dd(auth()->user());
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest()->get();

    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();
    // dd($permissiontimesheet);

    // maping week wise data 
    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }

  public function timesheet_submit(Request $request)
  {
    //dd($request);
    try {
      DB::table('timesheetusers')->where('id', $request->imsheetid)->update([
        'client_id' => $request->client_id,
        'assignment_id' => $request->assignment_id,
        'workitem' => $request->workitem,
        'totalhour' => $request->totalhour,
        'status'         =>     1,
        'updatedby'  => auth()->user()->teammember_id,
        'updated_at'              =>    date('y-m-d'),
      ]);

      $output = array('msg' => 'Submit Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function transformDate($value, $format = 'Y-m-d')
  {
    try {
      return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
      return \Carbon\Carbon::createFromFormat($format, $value);
    }
  }
  public function timesheetexcelStore(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //dd($dataa);
      foreach ($dataa[0] as $key => $value) {


        $currentday =
          \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['date'])->format('Y-m-d');
        // $currentday= date('Y-m-d', strtotime($value['date']));
        // dd($currentday);

        $mytime = Carbon::now();

        $currentdate = $mytime->toDateString();
        $hour = $value['hour'];





        if ($currentday > $currentdate) {
          $output = array('msg' => 'You Can Not Fill Timesheet For Future Date (' . date('d-m-Y', strtotime($currentday)) . ')');
          return redirect('timesheet')->with('statuss', $output);
        } elseif ($hour > 24) {
          $output = array('msg' => 'The time entered exceeds the maximum of 24 hours !');
          return back()->with('statuss', $output);
        } else {

          $leaves = DB::table('applyleaves')
            ->where('applyleaves.createdby', auth()->user()->teammember_id)
            ->where('status', '!=', 2)
            //->orWhere('status',0)
            ->select('applyleaves.from', 'applyleaves.to')
            ->get();
          // dd($leaves);
          if (count($leaves) != 0) {
            foreach ($leaves as $leave) {
              //Convert each data from table to Y-m-d format to compare
              $days = CarbonPeriod::create(
                date('Y-m-d', strtotime($leave->from)),
                date('Y-m-d', strtotime($leave->to))
              );

              foreach ($days as $day) {
                $leavess[] = $day->format('Y-m-d');
                // dd($leavess);



              }
            }
            //dd($leavess);


            //  date('Y-m-d', strtotime($intval($value['date'])));
            // dd($currentday);
            if ($leavess != null) {
              //dd('if');
              foreach ($leavess as $leave) {

                if ($leave == $currentday) {
                  // dd('if');
                  // $ifcount=$ifcount+1;
                  $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
                  return redirect('timesheet')->with('statuss', $output);
                } else {
                  //  dd($currentday);
                }
              }
            }
          }
          $clients   = DB::table('clients')->where('client_name', $value['clientname'])->pluck('id')->first();
          //dd($clients);
          if ($clients == null) {
            //dd($clients);
            $output = array('msg' => 'Client Name (' . $value['clientname'] . ') Not Match Please Check!!');
            return back()->with('statuss', $output);
          } else {
            //dd($clients);
            $assignments = DB::table('assignments')->where('assignment_name', $value['assignmentname'])->pluck('id')->first();
            if ($assignments == null) {
              $output = array('msg' => 'Assigment Name (' . $value['assignmentname'] . ') Not Found Please Check!!');
              return back()->with('statuss', $output);
            }
            $partner = DB::table('teammembers')->where('team_member', $value['partner'])->pluck('id')->first();
            if ($partner == null) {
              $output = array('msg' => 'Partner Name (' . $value['partner'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            if ($value['billablestatus'] != "Non Billable" && $value['billablestatus'] != "Billable") {
              $output = array('msg' => 'Billable status (' . $value['billablestatus'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            $timesheet = DB::table('timesheets')->where('created_by', auth()->user()->teammember_id)
              ->where('date', $value['date'])->pluck('id')->first();

            if ($timesheet == null) {

              $id = DB::table('timesheets')->insertGetId(
                [
                  'created_by' => auth()->user()->teammember_id,
                  'date'     =>     $this->transformDate($value['date']),
                  'created_at'          =>     date('Y-m-d H:i:s'),
                ]
              );
              $timesheets = DB::table('timesheets')->where('id', $id)->first();
              DB::table('timesheets')->where('id', $timesheets->id)->update([
                'date'     =>    date('Y-m-d', strtotime($timesheets->date)),
                'month'     =>    date('F', strtotime($timesheets->date)),
              ]);
            }



            DB::table('timesheetusers')->insert([
              'date'     =>       $this->transformDate($value['date']),
              'client_id'     =>     $clients,
              'workitem'     =>     $value['workitem'],
              'billable_status'     =>      $value['billablestatus'],
              'timesheetid'     =>     $id,

              'hour'     =>     $value['hour'],
              'totalhour' =>      $value['hour'],
              'assignment_id'     =>     $assignments,
              'partner'     =>     $partner,
              'createdby' => auth()->user()->teammember_id,
              'created_at'          =>     date('Y-m-d H:i:s'),
              'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            $totalhour = DB::table('timesheetusers')->select('date', DB::raw('COUNT(*) as `count`'))
              ->where('createdby', auth()->user()->teammember_id)
              ->groupBy('date')
              ->havingRaw('COUNT(*) > 1')

              ->get();
            foreach ($totalhour as $value) {
              $sum = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->sum('hour');

              DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->update([
                'totalhour'         =>   $sum,
              ]);

              //attendance reflection'

              $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
                ->where('month', 'June')->first();
              //  dd($value->created_by);

              // dd($attendances);
              if ($attendances ==  null) {
                $a = DB::table('attendances')->insert([
                  'employee_name'         =>     auth()->user()->teammember_id,
                  'month'         =>    'June',
                  'created_at'          =>     date('Y-m-d H:i:s'),
                  //   'exam_leave'      =>$value->date_total,
                ]);
                // dd($a);
              }

              //   dd($noofdaysaspertimesheet);
              $hdatess = date('Y-m-d', strtotime($value->date));

              // dd($hdatess);
              if ($hdatess == '2023-05-26') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentysix'         =>     $sum,
                  ]);
              }

              if ($hdatess == '2023-05-27') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyseven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-28') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyeight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-29') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentynine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-30') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-31') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirtyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-01') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'one'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-02') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'two'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-03') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'three'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-04') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'four'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-05') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'five'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-06') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'six'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-07') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-08') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-09') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'nine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-10') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ten'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-11') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eleven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-12') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twelve'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-13') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-14') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fourteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-15') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fifteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-16') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'sixteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-17') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seventeen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-18') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eighteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-19') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ninghteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-20') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twenty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-21') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-22') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentytwo'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-23') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentythree'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-24') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfour'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-25') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfive'         =>     $sum,
                  ]);
              }

              //end attendance




            }
          }
        }
      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function index()
  {
    if (auth()->user()->role_id == 11) {
      //			  $time =  DB::table('timesheets')->get();
      //foreach ($time as $value) {
      //dd(date('F', strtotime($value->date)));
      //   DB::table('timesheets')->where('id',$value->id)->where('month',null)->update([	
      //     'month'         =>     date('F', strtotime($value->date)),
      //       ]);
      //}
      //			   $time =  DB::table('timesheets')->where('month','November')
      //     ->orwhere('month','October')->get();
      //dd($time);
      //foreach ($time as $value) {
      //dd(date('Y-m-d', strtotime($value->date)));
      //DB::table('timesheets')->where('id',$value->id)->update([	
      //  'date'         =>     date('Y-m-d', strtotime($value->date)),
      //  ]);
      //}
      // $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
      //   ->where('teammembers.status', '1')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();
      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');

      // //dd($month);
      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.adminstatustime');
    } elseif (auth()->user()->role_id == 18) {

      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
        //   ->where('teammembers.status','1')
        ->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      //dd($month );

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // dd($timesheetData);
      return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif (auth()->user()->role_id == 13) {
      //die;
      // dd(auth()->user()->teammember_id);
      // 			  $time =  DB::table('timesheets')->get();
      // foreach ($time as $value) {
      //     //dd(date('F', strtotime($value->date)));
      //     DB::table('timesheets')->where('id',$value->id)->update([	
      //         'month'         =>     date('F', strtotime($value->date)),
      //          ]);
      // }
      // $teammember = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();

      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');


      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.statustime');
    } else {
      return view('backEnd.timesheet.staffworksheet');
    }
  }
  public function show(Request $request)
  {
    if ($request->method() === 'POST') {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');


      $month = $request->month;
      $year = $request->year;


      $getauth =  DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();

      //   dd($getauth);
      $client = Client::select('id', 'client_name')->get();
      $timesheetData =  $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', auth()->user()->teammember_id)
        ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheets.date) = ?', [$year])
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(100);
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauth  == null) {
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

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    if (auth()->user()->teammember_id == 23) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('teammembers.role_id', '15')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();


      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 13) {
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    }
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }

  // public function assignmentHourShow()
  // {



  // $totalHour = DB::table('timesheetusers')
  //   ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //   ->where(
  //     'timesheetusers.assignmentgenerate_id',
  //     'RCC100269',
  //   )
  //   ->where('timesheetusers.createdby', 847)
  //   ->select(DB::raw('SUM(totalhour) as total_hours'))
  //   ->first();
  // // dd($totalHour);

  // $update = DB::table('assignmentmappings')
  //   ->leftJoin(
  //     'assignmentteammappings',
  //     'assignmentteammappings.assignmentmapping_id',
  //     'assignmentmappings.id',
  //   )
  //   ->where(
  //     'assignmentmappings.assignmentgenerate_id',
  //     'RCC100269',
  //   )
  //   ->where('assignmentteammappings.teammember_id', 847)
  //   ->get();
  // // ->update(['teamhour' => $totalHour->total_hours]);
  // dd($update);

  // 222222222222222222222222222

  //   $teammemberDatas = DB::table('assignmentteammappings')
  //     ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     ->where('assignmentbudgetings.status', 1)
  //     ->whereNotIn('teammembers.team_member', ['NA', 'null'])
  //     // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
  //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
  //     // ->take(7)
  //     ->get();
  //   // dd($teammemberDatas);

  //   $patnerdata = DB::table('assignmentmappings')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', function ($join) {
  //       $join->on('teammembers.id', 'assignmentmappings.otherpartner')
  //         ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
  //     })
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     ->where('assignmentbudgetings.status', 1)
  //     ->whereNotIn('teammembers.team_member', ['NA'])
  //     // ->whereNotNull('teammembers.team_member')
  //     ->select(
  //       'assignmentmappings.id',
  //       'teammembers.id as teamid',
  //       'teammembers.team_member',
  //       'titles.title',
  //       'assignmentmappings.assignmentgenerate_id',
  //       'assignmentbudgetings.assignmentname'
  //     )
  //     // ->take(7)
  //     ->get();

  //   // dd($teammemberDatas);
  //   return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'patnerdata'));
  // }

  public function assignmentHourShow()
  {

    // // 222222222222222222222222222222222222
    // $totalhour = DB::table('timesheetusers')
    //   ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //   ->where(
    //     'timesheetusers.assignmentgenerate_id',
    //     'RCC100269',
    //   )
    //   ->where('timesheetusers.createdby', 844)
    //   ->select(DB::raw('SUM(totalhour) as total_hours'))
    //   ->first();

    // $update = DB::table('assignmentmappings')
    //   ->where(
    //     'assignmentgenerate_id',
    //     'RCC100269'
    //   )
    //   ->where('leadpartner', 844)
    //   // ->where('otherpartner', 844)
    //   // ->get();
    //   ->update(['leadpartnerhour' => $totalhour->total_hours]);
    // // ->update(['otherpartnerhour' => $totalHour->total_hours]);
    // dd($update);

    // // 222222222222222222222222222222222222
    // $totalhour = DB::table('timesheetusers')
    //   ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //   ->where(
    //     'timesheetusers.assignmentgenerate_id',
    //     'RCC100269',
    //   )
    //   ->where('timesheetusers.createdby', 840)
    //   ->select(DB::raw('SUM(totalhour) as total_hours'))
    //   ->first();

    // $update = DB::table('assignmentmappings')
    //   ->where(
    //     'assignmentgenerate_id',
    //     'RCC100269'
    //   )
    //   ->where('otherpartner', 840)
    //   // ->where('otherpartner', 844)
    //   // ->get();
    //   ->update(['otherpartnerhour' => $totalhour->total_hours]);
    // // ->update(['otherpartnerhour' => $totalHour->total_hours]);
    // dd($update);

    // // 222222222222222222222222222222222222

    $teammemberDatas = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('assignmentbudgetings.status', 1)
      ->whereNotIn('teammembers.team_member', ['NA', 'null'])
      // ->where('assignmentmappings.assignmentgenerate_id', 'GOO100433')
      ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour')
      // ->take(7)
      ->get();
    // dd($teammemberDatas);

    $patnerdata = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', function ($join) {
        $join->on('teammembers.id', 'assignmentmappings.otherpartner')
          ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
      })
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('assignmentbudgetings.status', 1)
      ->whereNotIn('teammembers.team_member', ['NA'])
      // ->whereNotNull('teammembers.team_member')
      ->select(
        'assignmentmappings.id',
        'teammembers.id as teamid',
        'teammembers.team_member',
        'titles.title',
        'assignmentmappings.assignmentgenerate_id',
        'assignmentbudgetings.assignmentname',
        'assignmentmappings.otherpartner',
        'assignmentmappings.leadpartner',
      )
      // ->take(7)
      ->get();

    // dd($teammemberDatas);
    return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'patnerdata'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  //! 01-03-24
  // public function create(Request $request)
  // {
  //   // dd(auth()->user()->teammember_id);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {

  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     // dd(auth()->user()->teammember_id);
  //     $clientss = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
  //       ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   if ($request->ajax()) {
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         // dd('hi 1');
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           // dd('hi 2');
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {
  //           // dd('hi 3');
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
  //             //  ->where('created_by', auth()->user()->id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //         //! sunny gupta assignment problem solved 
  //         // else {
  //         //   // dd('hi 3');
  //         //   foreach (DB::table('assignmentbudgetings')
  //         //     ->where('assignmentbudgetings.client_id', $request->cid)
  //         //     ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //         //     ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //         //     ->where(function ($query) {
  //         //       $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //         //         ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
  //         //     })
  //         //     ->where('assignmentbudgetings.status', 1)
  //         //     ->orderBy('assignment_name')->get() as $sub) {
  //         //     echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         //   }
  //         // }
  //       }
  //       // assreject
  //       else {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {
  //           //  i have add this code after kartic bindal problem 
  //           foreach (DB::table('assignmentbudgetings')
  //             ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //             //  ->where('assignmentteammappings.status', '!=', 0)
  //             // ->whereNull('assignmentteammappings.status')
  //             ->where(function ($query) {
  //               $query->whereNull('assignmentteammappings.status')
  //                 ->orWhere('assignmentteammappings.status', '=', 1);
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       }
  //     }

  //     if (isset($request->assignment)) {
  //       // dd($request->assignment);
  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }


  // timesheet create not updated code
  // public function create(Request $request)
  // {
  //   // dd(auth()->user()->teammember_id);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {

  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {

  //     // dd(auth()->user()->teammember_id);
  //     $clientss = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
  //       ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   if ($request->ajax()) {
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {

  //         echo "<option>Select Assignment</option>";
  //         // Default Assignment like off/holyday, unalloacted etc
  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           // dd('hi 2');
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {

  //           // dd('hi 3');

  //           // dd($request->datepickers);


  //           // $var = DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where('otpverifydate', '>=', $request->datepickers)
  //           //   ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')->get();

  //           // dd($var);

  //           // Permission for Closed assignment
  //           // $assignmentcloseddata2 = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
  //           // $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);

  //           // if ($assignmentcloseddata2 && $assignmentcloseddata2->otpverifydate) {
  //           //   $assignmentcloseddate2 = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata2->otpverifydate)->setTime(23, 59, 59);
  //           //   if ($assignmentcloseddata->status == 0 && $assignmentcloseddate2 <= $requestDate) {
  //           //     $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[$i] . " You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
  //           //     return redirect('timesheet/mylist')->with('statuss', $output);
  //           //   }
  //           // }




  //           // foreach (DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where(function ($query) use ($request) {
  //           //     $query->whereNull('otpverifydate')
  //           //       ->orWhere('otpverifydate', '>', $request->datepickers);
  //           //   })
  //           //   ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')->get() as $sub)


  //           // $var = DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where(function ($query) use ($request) {
  //           //     $query->whereNull('otpverifydate')
  //           //       ->orWhere('otpverifydate', '>', $request->datepickers);
  //           //   })
  //           //   ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')
  //           //   ->get();

  //           // dd($var);

  //           // $requestDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           // $var = DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where(function ($query) use ($requestDate) {
  //           //     $query->whereNull('otpverifydate')
  //           //       ->orWhere('otpverifydate', '<=', $requestDate->modify('+1 day'));
  //           //   })
  //           //   ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')
  //           //   ->get();

  //           // dd($var);


  //           // $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           // $var = DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where(function ($query) use ($selectedDate) {
  //           //     $query->whereNull('otpverifydate')
  //           //       //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //           //   })
  //           //   ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')
  //           //   ->get();

  //           // dd($var);





  //           // foreach (DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   //  ->where('created_by', auth()->user()->id)
  //           //   ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')->get() as $sub) {
  //           //   echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           // }

  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);
  //           foreach (DB::table('assignmentbudgetings')
  //             ->where('client_id', $request->cid)
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }


  //           // dd($sub);
  //         }
  //         //! sunny gupta assignment problem solved 
  //         // else {
  //         //   // dd('hi 3');
  //         //   foreach (DB::table('assignmentbudgetings')
  //         //     ->where('assignmentbudgetings.client_id', $request->cid)
  //         //     ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //         //     ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //         //     ->where(function ($query) {
  //         //       $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //         //         ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
  //         //     })
  //         //     ->where('assignmentbudgetings.status', 1)
  //         //     ->orderBy('assignment_name')->get() as $sub) {
  //         //     echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //         //   }
  //         // }
  //       }
  //       // open and closed assignment
  //       else {
  //         // pppppp
  //         // dd('hi 4');
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {


  //           // $var2 = DB::table('assignmentbudgetings')
  //           //   ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           //   ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           //   ->where('assignmentbudgetings.client_id', $request->cid)
  //           //   ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           //   //  ->where('assignmentteammappings.status', '!=', 0)
  //           //   // ->whereNull('assignmentteammappings.status')
  //           //   ->where(function ($query) {
  //           //     $query->whereNull('assignmentteammappings.status')
  //           //       ->orWhere('assignmentteammappings.status', '=', 1);
  //           //   })
  //           //   ->orderBy('assignment_name')->get();

  //           // dd($var2);

  //           // $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           // $var = DB::table('assignmentbudgetings')
  //           //   ->where('client_id', $request->cid)
  //           //   ->where(function ($query) use ($selectedDate) {
  //           //     $query->whereNull('otpverifydate')
  //           //       //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //           //   })
  //           //   ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //           //   ->orderBy('assignment_name')
  //           //   ->get();




  //           // dd($request);

  //           // $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);
  //           // // dd($selectedDate);
  //           // $var2 = DB::table('assignmentbudgetings')
  //           //   ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           //   ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           //   ->where('assignmentbudgetings.client_id', $request->cid)
  //           //   ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           //   //  ->where('assignmentteammappings.status', '!=', 0)
  //           //   // ->whereNull('assignmentteammappings.status')
  //           //   ->where(function ($query) {
  //           //     $query->whereNull('assignmentteammappings.status')
  //           //       ->orWhere('assignmentteammappings.status', '=', 1);
  //           //   })
  //           //   ->where(function ($query) use ($selectedDate) {
  //           //     $query->whereNull('otpverifydate')
  //           //       //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //           //       ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //           //   })
  //           //   ->orderBy('assignment_name')->get();

  //           // dd($var2);





  //           //  i have add this code after kartic bindal problem 
  //           // foreach (DB::table('assignmentbudgetings')
  //           //   ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //           //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //           //   ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //           //   ->where('assignmentbudgetings.client_id', $request->cid)
  //           //   ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //           //   //  ->where('assignmentteammappings.status', '!=', 0)
  //           //   // ->whereNull('assignmentteammappings.status')
  //           //   ->where(function ($query) {
  //           //     $query->whereNull('assignmentteammappings.status')
  //           //       ->orWhere('assignmentteammappings.status', '=', 1);
  //           //   })
  //           //   ->orderBy('assignment_name')->get() as $sub) {
  //           //   echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           // }


  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);
  //           foreach (DB::table('assignmentbudgetings')
  //             ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //             //  ->where('assignmentteammappings.status', '!=', 0)
  //             // ->whereNull('assignmentteammappings.status')
  //             ->where(function ($query) {
  //               $query->whereNull('assignmentteammappings.status')
  //                 ->orWhere('assignmentteammappings.status', '=', 1);
  //             })
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }

  //           // dd($var2);
  //         }
  //       }
  //     }

  //     if (isset($request->assignment)) {
  //       // dd($request->assignment);
  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }


  // live code this is updated
  // public function create(Request $request)
  // {
  //   // dd(auth()->user()->teammember_id);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     // dd(auth()->user()->teammember_id);
  //     $clientss = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
  //       ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   // dd($assignment);
  //   if ($request->ajax()) {
  //     // dd(auth()->user()->teammember_id);
  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {
  //           // dd('hi 3');

  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           foreach (DB::table('assignmentbudgetings')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->where(function ($query) {
  //               $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //                 ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
  //             })
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       } else {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {



  //           //  i have add this code after kartic bindal problem 
  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           foreach (DB::table('assignmentbudgetings')
  //             ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //             //  ->where('assignmentteammappings.status', '!=', 0)
  //             // ->whereNull('assignmentteammappings.status')
  //             ->where(function ($query) {
  //               $query->whereNull('assignmentteammappings.status')
  //                 ->orWhere('assignmentteammappings.status', '=', 1);
  //             })
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       }
  //     }

  //     if (isset($request->assignment)) {
  //       // dd($request->assignment);
  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }

  // live code this is updated
  public function create(Request $request)
  {

    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    if ($request->ajax()) {

      if (isset($request->timesheetdate)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

          $clientss = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            // ->whereNotNull('clients.client_name')
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          $clients = DB::table('clients')
            ->whereIn('id', [29, 32, 33, 34])
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          $client = $clientss->merge($clients);

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } else {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $clientss = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();
          // ->get();

          // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          $clients = DB::table('clients')
            ->whereIn('id', [29, 32, 33, 34])
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          $client = $clientss->merge($clients);

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        }
      }

      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            // dd('hi 3');

            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (DB::table('assignmentbudgetings')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        } else {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            //  i have add this code after kartic bindal problem 
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (DB::table('assignmentbudgetings')
              ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
              ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              //  ->where('assignmentteammappings.status', '!=', 0)
              // ->whereNull('assignmentteammappings.status')
              ->where(function ($query) {
                $query->whereNull('assignmentteammappings.status')
                  ->orWhere('assignmentteammappings.status', '=', 1);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  //   ->orWhere('otpverifydate', '>=', $selectedDate);
                  // // ->orWhere('otpverifydate', '>=', $selectedDate);
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->orderBy('assignment_name')->get() as $sub) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
      }

      if (isset($request->assignment)) {
        // dd($request->assignment);
        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
    }
  }


  // live code this is updated
  // public function create(Request $request)
  // {
  //   // dd(auth()->user()->teammember_id);
  //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  //   $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
  //   if (auth()->user()->role_id == 11) {
  //     $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
  //   } elseif (auth()->user()->role_id == 13) {
  //     $clientss = DB::table('assignmentmappings')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   } else {
  //     // dd(auth()->user()->teammember_id);
  //     $clientss = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
  //       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //       // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
  //       ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
  //       ->where('assignmentbudgetings.status', 1)
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code', 'assignmentbudgetings.*')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();
  //     // dd($clientss);
  //     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
  //     $clients = DB::table('clients')
  //       ->whereIn('id', [29, 32, 33, 34])
  //       ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //       ->orderBy('client_name', 'ASC')
  //       ->distinct()->get();

  //     $client = $clientss->merge($clients);
  //   }
  //   $assignment = Assignment::select('id', 'assignment_name')->get();
  //   // dd($assignment);
  //   if ($request->ajax()) {

  //     // if (isset($request->timesheetdate)) {
  //     //   dd('hi');
  //     // }

  //     if (isset($request->cid)) {
  //       if (auth()->user()->role_id == 13) {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {
  //           // dd('hi 3');

  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           foreach (DB::table('assignmentbudgetings')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->where(function ($query) {
  //               $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
  //                 ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
  //             })
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       } else {
  //         echo "<option>Select Assignment</option>";

  //         if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
  //           $clients = DB::table('clients')
  //             // ->whereIn('id', [29, 32, 33, 34])
  //             ->where('id', $request->cid)
  //             ->select('clients.client_name', 'clients.id', 'clients.client_code')
  //             ->orderBy('client_name', 'ASC')
  //             ->distinct()->get();
  //           // dd($clients);
  //           $id = $clients[0]->id;
  //           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         } else {



  //           //  i have add this code after kartic bindal problem 
  //           $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

  //           foreach (DB::table('assignmentbudgetings')
  //             ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
  //             ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
  //             ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
  //             ->where('assignmentbudgetings.client_id', $request->cid)
  //             ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
  //             //  ->where('assignmentteammappings.status', '!=', 0)
  //             // ->whereNull('assignmentteammappings.status')
  //             ->where(function ($query) {
  //               $query->whereNull('assignmentteammappings.status')
  //                 ->orWhere('assignmentteammappings.status', '=', 1);
  //             })
  //             ->where(function ($query) use ($selectedDate) {
  //               $query->whereNull('otpverifydate')
  //                 //   ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 // // ->orWhere('otpverifydate', '>=', $selectedDate);
  //                 ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
  //             })
  //             ->orderBy('assignment_name')->get() as $sub) {
  //             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
  //           }
  //         }
  //       }
  //     }

  //     if (isset($request->assignment)) {
  //       // dd($request->assignment);
  //       if (auth()->user()->role_id == 11) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } elseif (auth()->user()->role_id == 13) {
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('teammembers')
  //           ->where('id', auth()->user()->teammember_id)
  //           ->select('teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       } else {
  //         //die;
  //         echo "<option value=''>Select Partner</option>";
  //         foreach (DB::table('assignmentmappings')

  //           ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
  //           ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
  //           ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
  //           ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
  //           ->get() as $subs) {
  //           echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
  //         }
  //       }
  //     }
  //   } else {
  //     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
  //   }
  // }

  public function timesheetajax()
  {
    if ($request->ajax()) {
      //  dd($request);
      if (isset($request->cid)) {
        echo "<option>Select Assignment</option>";
        foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
          ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
          ->orderBy('assignment_name')->get() as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }
    }
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  //! 23-02-24
  public function store(Request $request)
  {

    // dd($request);

    try {

      $Newteammeber = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->first();

      $Newteammeberjoining_date = DB::table('teammembers')
        ->where('id', auth()->user()->teammember_id)
        ->select('joining_date')
        ->first();
      $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));

      // if user not created any timesheet in that case ,it means new teammeber 
      if ($Newteammeber == null) {
        // Get previuse sunday from joining date
        $joining_timestamp = strtotime($joining_date);
        $day_of_week = date('w', $joining_timestamp);
        $days_to_subtract = $day_of_week;
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
        // Get all dates beetween two dates 
        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);
        $period = CarbonPeriod::create($startDate, $endDate);
        // store all date in $result vairable
        $result = [];
        foreach ($period as $key => $date) {
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }
        // return $result;
        // dd('yes', $result);
        foreach ($result as $date) {
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>   date('F', strtotime($date)),
              'date'     =>    date('Y-m-d', strtotime($date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );

          DB::table('timesheetusers')->insert([
            'date'     =>   date('Y-m-d', strtotime($date)),
            'client_id'     =>     29,
            'workitem'     =>     'NA',
            'location'     =>     'NA',
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($date)),
            'hour'     =>     0,
            'totalhour' =>      0,
            'assignment_id'     =>     213,
            'partner'     =>     887,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }
      }


      $requestDate = Carbon::parse($request->date);
      $joiningDate = Carbon::parse($joining_date);

      if ($requestDate >= $joiningDate) {
        $data = $request->except(['_token', 'teammember_id', 'amount']);
        //	if ($request->date < '11-09-2023') {
        //dd('hi');
        // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
        //  return back()->with('success', $output);
        //   }

        //die;
        //? dd(date('w', strtotime($request->date))); // 4
        if (date('w', strtotime($request->date)) == 0) {
          $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
          $previousSaturdayFilled = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', $previousSaturday)
            ->where('status', 1)
            ->first();
          // dd('hi1', $previousSaturdayFilled);
          if ($previousSaturdayFilled != null) {
            $output = array('msg' => 'You already submitted for this week');
            return back()->with('success', $output);
          }
        }

        // check hour
        $hours = $request->input('totalhour');
        if (!is_numeric($hours) || $hours > 12) {
          $output = array('msg' => 'The total hours cannot be greater than 12');
          return back()->with('success', $output);
        }
        // dd(auth()->user()->teammember_id);
        //? dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"
        $previouschck = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', date('Y-m-d', strtotime($request->date)))
          ->where('status', 1)
          ->first();

        if ($previouschck != null) {
          //dd('hi');
          $output = array('msg' => 'You already submitted for this week');
          return back()->with('success', $output);
        }

        $previoussavechck = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', date('Y-m-d', strtotime($request->date)))
          ->where('status', 0)
          ->first();

        if ($previoussavechck != null) {
          //dd('hi');
          $output = array('msg' => 'You already submitted for this date');
          return back()->with('success', $output);
        }



        $currentDate = Carbon::now()->format('d-m-Y');
        //dd($currentHour);

        if ($currentDate == $request->date && Carbon::now()->hour < 18) {
          //   //dd('hi');
          $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
          return back()->with('success', $output);
        }

        $leaves = DB::table('applyleaves')
          ->where('applyleaves.createdby', auth()->user()->teammember_id)
          ->where('status', '!=', 2)
          ->select('applyleaves.from', 'applyleaves.to')
          ->get();
        // dd('hi 1', $leaves);
        foreach ($leaves as $leave) {
          //Convert each data from table to Y-m-d format to compare
          $days = CarbonPeriod::create(
            date('Y-m-d', strtotime($leave->from)),
            date('Y-m-d', strtotime($leave->to))
          );

          foreach ($days as $day) {
            $leavess[] = $day->format('Y-m-d');
          }
        }
        // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"
        $currentday = date('Y-m-d', strtotime($request->date));
        // dd('hi 2', $currentday);
        // $ifcount=0;
        //  $elsecount=0;

        if (count($leaves) != 0) {
          //dd('if');
          foreach ($leavess as $leave) {
            // echo"<pre>";
            //  print_r($leave);

            if ($leave == $currentday) {
              //dd('if');
              // $ifcount=$ifcount+1;
              $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
              return redirect('timesheet')->with('statuss', $output);
            }
          }
        }
        // insert data in timesheet from request and get id 
        $id = DB::table('timesheets')->insertGetId(
          [
            'created_by' => auth()->user()->teammember_id,
            'month'     =>    date('F', strtotime($request->date)),
            'date'     =>    date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
          ]
        );

        $count = count($request->assignment_id);
        // dd('hi 3', $count);
        for ($i = 0; $i < $count; $i++) {
          //dd($request->workitem[$i]);
          $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

          $a = DB::table('timesheetusers')->insert([
            'date'     =>     $request->date,
            'client_id'     =>     $request->client_id[$i],
            'assignmentgenerate_id'     =>     $request->assignment_id[$i],
            'workitem'     =>     $request->workitem[$i],
            'location'     =>     $request->location[$i],
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($request->date)),
            'hour'     =>     $request->hour[$i],
            'totalhour' =>      $request->totalhour,
            'assignment_id'     =>     $assignment->assignment_id,
            'partner'     =>     $request->partner[$i],
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }
      } else {
        // dd(auth()->user()->teammember_id);
        $output = array('msg' => 'You can not fill timesheet before :' . $joining_date);
        return redirect('timesheet')->with('success', $output);
      }







      //Attendance code

      $hdatess = date('Y-m-d', strtotime($request->date));
      $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
      $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
      $currentDate = new DateTime();
      $currentMonth = $currentDate->format('F');
      //dd($month);
      //   if ($currentDate->format('j') > 25) {
      //     $currentDate->modify('-1 month');
      //     $currentMonth = $currentDate->format('F');
      // }



      $dates = [
        '26' => 'twentysix',
        '27' => 'twentyseven',
        '28' => 'twentyeight',
        '29' => 'twentynine',
        '30' => 'thirty',
        '31' => 'thirtyone',
        '01' => 'one',
        '02' => 'two',
        '03' => 'three',
        '04' => 'four',
        '05' => 'five',
        '06' => 'six',
        '07' => 'seven',
        '08' => 'eight',
        '09' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'ninghteen',
        '20' => 'twenty',
        '21' => 'twentyone',
        '22' => 'twentytwo',
        '23' => 'twentythree',
        '24' => 'twentyfour',
        '25' => 'twentyfive',
      ];



      if ($month != $currentMonth && $day > 25) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }
      if ($month != $currentMonth && $day < 25) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $month = $dateTime->format('F');
      }
      if ($month == $currentMonth && $day > 25) {

        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }

      //dd($month);


      $column = $dates[$day];

      $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month)->first();

      if ($attendances ==  null) {
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $a = DB::table('attendances')->insert([
          'employee_name'         =>     auth()->user()->teammember_id,
          'month'         =>    $month,
          'dateofjoining' =>   $teammember->joining_date,
          'created_at'          =>     date('Y-m-d H:i:s'),
          //   'exam_leave'      =>$value->date_total,
        ]);
        //dd($a);
      }


      //   dd($noofdaysaspertimesheet);

      $updatedtotalhour = $request->totalhour;
      if ($attendances != null && property_exists($attendances, $column)) {
        if ($attendances->$column != "LWP") {
          $updatedtotalhour = $request->totalhour + $attendances->$column;
        }
      }
      DB::table('attendances')
        ->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month)
        ->update([$column => $updatedtotalhour]);


      //end attendance


      $output = array('msg' => 'Create Successfully');
      if (auth()->user()->role_id == 14 || auth()->user()->role_id == 13 || auth()->user()->role_id == 15) {
        return redirect('timesheet/mylist')->with('success', $output);
      } else {
        return redirect('timesheet')->with('success', $output);
      }
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  //! Understand code when assignment closed condition implement
  // public function store(Request $request)
  // {
  //   try {

  //     $Newteammeber = DB::table('timesheetusers')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->first();

  //     $Newteammeberjoining_date = DB::table('teammembers')
  //       ->where('id', auth()->user()->teammember_id)
  //       ->select('joining_date')
  //       ->first();
  //     $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));

  //     // if user not created any timesheet in that case ,it means new teammeber 
  //     if ($Newteammeber == null) {
  //       // Get previuse sunday from joining date
  //       $joining_timestamp = strtotime($joining_date);
  //       $day_of_week = date('w', $joining_timestamp);
  //       $days_to_subtract = $day_of_week;
  //       $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

  //       $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
  //       // Get all dates beetween two dates 
  //       $startDate = Carbon::parse($previous_sunday_date);
  //       $endDate = Carbon::parse($joining_date);
  //       $period = CarbonPeriod::create($startDate, $endDate);
  //       // store all date in $result vairable
  //       $result = [];
  //       foreach ($period as $key => $date) {
  //         if ($key !== 0 && $key !== count($period) - 1) {
  //           $result[] = $date->toDateString();
  //         }
  //       }
  //       // return $result;
  //       // dd('yes', $result);
  //       foreach ($result as $date) {
  //         $id = DB::table('timesheets')->insertGetId(
  //           [
  //             'created_by' => auth()->user()->teammember_id,
  //             'month'     =>   date('F', strtotime($date)),
  //             'date'     =>    date('Y-m-d', strtotime($date)),
  //             'created_at'          =>     date('Y-m-d H:i:s'),
  //           ]
  //         );
  //         DB::table('timesheetusers')->insert([
  //           'date'     =>   date('Y-m-d', strtotime($date)),
  //           'client_id'     =>     29,
  //           'workitem'     =>     'NA',
  //           'location'     =>     'NA',
  //           //   'billable_status'     =>     $request->billable_status[$i],
  //           'timesheetid'     =>     $id,
  //           'date'     =>     date('Y-m-d', strtotime($date)),
  //           'hour'     =>     0,
  //           'totalhour' =>      0,
  //           'assignment_id'     =>     213,
  //           'partner'     =>     887,
  //           'createdby' => auth()->user()->teammember_id,
  //           'created_at'          =>     date('Y-m-d H:i:s'),
  //           'updated_at'              =>    date('Y-m-d H:i:s'),
  //         ]);
  //       }
  //     }


  //     $requestDate = Carbon::parse($request->date);
  //     $joiningDate = Carbon::parse($joining_date);

  //     if ($requestDate >= $joiningDate) {
  //       $data = $request->except(['_token', 'teammember_id', 'amount']);

  //       if (date('w', strtotime($request->date)) == 0) {
  //         $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
  //         $previousSaturdayFilled = DB::table('timesheetusers')
  //           ->where('createdby', auth()->user()->teammember_id)
  //           ->where('date', $previousSaturday)
  //           ->where('status', 1)
  //           ->first();
  //         // dd('hi1', $previousSaturdayFilled);
  //         if ($previousSaturdayFilled != null) {
  //           $output = array('msg' => 'You already submitted for this week');
  //           return back()->with('success', $output);
  //         }
  //       }

  //       // check hour
  //       $hours = $request->input('totalhour');
  //       if (!is_numeric($hours) || $hours > 12) {
  //         $output = array('msg' => 'The total hours cannot be greater than 12');
  //         return back()->with('success', $output);
  //       }

  //       $previouschck = DB::table('timesheetusers')
  //         ->where('createdby', auth()->user()->teammember_id)
  //         ->where('date', date('Y-m-d', strtotime($request->date)))
  //         ->where('status', 1)
  //         ->first();

  //       if ($previouschck != null) {
  //         $output = array('msg' => 'You already submitted for this week');
  //         return back()->with('success', $output);
  //       }

  //       $previoussavechck = DB::table('timesheetusers')
  //         ->where('createdby', auth()->user()->teammember_id)
  //         ->where('date', date('Y-m-d', strtotime($request->date)))
  //         ->where('status', 0)
  //         ->first();

  //       if ($previoussavechck != null) {
  //         $output = array('msg' => 'You already submitted for this date');
  //         return back()->with('success', $output);
  //       }



  //       $currentDate = Carbon::now()->format('d-m-Y');
  //       //dd($currentHour);

  //       if ($currentDate == $request->date && Carbon::now()->hour < 18) {
  //         //   //dd('hi');
  //         $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
  //         return back()->with('success', $output);
  //       }

  //       $leaves = DB::table('applyleaves')
  //         ->where('applyleaves.createdby', auth()->user()->teammember_id)
  //         ->where('status', '!=', 2)
  //         ->select('applyleaves.from', 'applyleaves.to')
  //         ->get();
  //       // dd('hi 1', $leaves);
  //       foreach ($leaves as $leave) {
  //         //Convert each data from table to Y-m-d format to compare
  //         $days = CarbonPeriod::create(
  //           date('Y-m-d', strtotime($leave->from)),
  //           date('Y-m-d', strtotime($leave->to))
  //         );

  //         foreach ($days as $day) {
  //           $leavess[] = $day->format('Y-m-d');
  //         }
  //       }
  //       // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"
  //       $currentday = date('Y-m-d', strtotime($request->date));


  //       if (count($leaves) != 0) {
  //         //dd('if');
  //         foreach ($leavess as $leave) {


  //           if ($leave == $currentday) {

  //             $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
  //             return redirect('timesheet')->with('statuss', $output);
  //           }
  //         }
  //       }

  //       // Permission for Closed assignment
  //       // $assignmentcloseddata = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[0])->first();
  //       // $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);

  //       // if ($assignmentcloseddata && $assignmentcloseddata->otpverifydate) {
  //       //   $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);
  //       //   if ($assignmentcloseddata->status == 0 && $assignmentcloseddate <= $requestDate) {
  //       //     $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[0] . " You can not fill timesheet to Assignment name : " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[0]];
  //       //     return redirect('timesheet/mylist')->with('statuss', $output);
  //       //   }
  //       // }


  //       // insert data in timesheet from request and get id 
  //       $id = DB::table('timesheets')->insertGetId(
  //         [
  //           'created_by' => auth()->user()->teammember_id,
  //           'month'     =>    date('F', strtotime($request->date)),
  //           'date'     =>    date('Y-m-d', strtotime($request->date)),
  //           'created_at'          =>     date('Y-m-d H:i:s'),
  //         ]
  //       );

  //       $count = count($request->assignment_id);
  //       // dd('hi 3', $count);
  //       for ($i = 0; $i < $count; $i++) {

  //         $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

  //         // Permission for Closed assignment
  //         // $assignmentcloseddata2 = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
  //         // $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);

  //         // if ($assignmentcloseddata2 && $assignmentcloseddata2->otpverifydate) {
  //         //   $assignmentcloseddate2 = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata2->otpverifydate)->setTime(23, 59, 59);
  //         //   if ($assignmentcloseddata->status == 0 && $assignmentcloseddate2 <= $requestDate) {
  //         //     $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[$i] . " You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
  //         //     return redirect('timesheet/mylist')->with('statuss', $output);
  //         //   }
  //         // }


  //         $a = DB::table('timesheetusers')->insert([
  //           'date'     =>     $request->date,
  //           'client_id'     =>     $request->client_id[$i],
  //           'workitem'     =>     $request->workitem[$i],
  //           'location'     =>     $request->location[$i],
  //           //   'billable_status'     =>     $request->billable_status[$i],
  //           'timesheetid'     =>     $id,
  //           'date'     =>     date('Y-m-d', strtotime($request->date)),
  //           'hour'     =>     $request->hour[$i],
  //           'totalhour' =>      $request->totalhour,
  //           'assignment_id'     =>     $assignment->assignment_id,
  //           'partner'     =>     $request->partner[$i],
  //           'createdby' => auth()->user()->teammember_id,
  //           'created_at'          =>     date('Y-m-d H:i:s'),
  //           'updated_at'              =>    date('Y-m-d H:i:s'),
  //         ]);
  //       }
  //     } else {
  //       // dd(auth()->user()->teammember_id);
  //       $output = array('msg' => 'You can not fill timesheet before :' . $joining_date);
  //       return redirect('timesheet')->with('success', $output);
  //     }







  //     //Attendance code

  //     $hdatess = date('Y-m-d', strtotime($request->date));
  //     $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
  //     $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
  //     $currentDate = new DateTime();
  //     $currentMonth = $currentDate->format('F');




  //     $dates = [
  //       '26' => 'twentysix',
  //       '27' => 'twentyseven',
  //       '28' => 'twentyeight',
  //       '29' => 'twentynine',
  //       '30' => 'thirty',
  //       '31' => 'thirtyone',
  //       '01' => 'one',
  //       '02' => 'two',
  //       '03' => 'three',
  //       '04' => 'four',
  //       '05' => 'five',
  //       '06' => 'six',
  //       '07' => 'seven',
  //       '08' => 'eight',
  //       '09' => 'nine',
  //       '10' => 'ten',
  //       '11' => 'eleven',
  //       '12' => 'twelve',
  //       '13' => 'thirteen',
  //       '14' => 'fourteen',
  //       '15' => 'fifteen',
  //       '16' => 'sixteen',
  //       '17' => 'seventeen',
  //       '18' => 'eighteen',
  //       '19' => 'ninghteen',
  //       '20' => 'twenty',
  //       '21' => 'twentyone',
  //       '22' => 'twentytwo',
  //       '23' => 'twentythree',
  //       '24' => 'twentyfour',
  //       '25' => 'twentyfive',
  //     ];



  //     if ($month != $currentMonth && $day > 25) {
  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $dateTime->modify('+1 month');
  //       $month = $dateTime->format('F');
  //     }
  //     if ($month != $currentMonth && $day < 25) {
  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $month = $dateTime->format('F');
  //     }
  //     if ($month == $currentMonth && $day > 25) {

  //       $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
  //       $dateTime->modify('+1 month');
  //       $month = $dateTime->format('F');
  //     }

  //     //dd($month);


  //     $column = $dates[$day];

  //     $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
  //       ->where('month', $month)->first();

  //     if ($attendances ==  null) {
  //       $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

  //       $a = DB::table('attendances')->insert([
  //         'employee_name'         =>     auth()->user()->teammember_id,
  //         'month'         =>    $month,
  //         'dateofjoining' =>   $teammember->joining_date,
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //         //   'exam_leave'      =>$value->date_total,
  //       ]);
  //       //dd($a);
  //     }


  //     //   dd($noofdaysaspertimesheet);

  //     $updatedtotalhour = $request->totalhour;
  //     if ($attendances != null && property_exists($attendances, $column)) {
  //       if ($attendances->$column != "LWP") {
  //         $updatedtotalhour = $request->totalhour + $attendances->$column;
  //       }
  //     }
  //     DB::table('attendances')
  //       ->where('employee_name', auth()->user()->teammember_id)
  //       ->where('month', $month)
  //       ->update([$column => $updatedtotalhour]);


  //     //end attendance


  //     $output = array('msg' => 'Create Successfully');
  //     if (auth()->user()->role_id == 14 || auth()->user()->role_id == 13 || auth()->user()->role_id == 15) {
  //       return redirect('timesheet/mylist')->with('success', $output);
  //     } else {
  //       return redirect('timesheet')->with('success', $output);
  //     }
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     $output = array('msg' => $e->getMessage());
  //     return back()->withErrors($output)->withInput();
  //   }
  // }



  public function timesheetUpload(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //     dd($dataa);
      foreach ($dataa[0] as $key => $value) {
        //  $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();

        //    if($informationresource == null){
        $db['clientname'] = $request->clientname;
        $db['assignmentname'] = $request->assignmentname;
        $db['workitem'] = $request->workitem;
        //  $db['billable_status'] = $request->billable_status;
        $db['hour'] = $request->hour;
        //   dd($request->clientname);
        if ($request->clientname != NULL) {
          $client_id   = clients::where('client_name', $value['clientname'])->pluck('id')->first();
          //    dd($client_id);
          if ($assignmentname != NULL) {
            $assignment_id   = assignments::where('assignment_name', $value['assignmentname'])->pluck('id')->first();
          }
        }


        //  'createdby' => auth()->user()->teammember_id,
        //     Timesheet::Create($db);

        //       }

      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //dd($date);
    //$id=77;
    $client = Client::select('id', 'client_name')->get();
    $time = DB::table('timesheets')->where('id', $id)->first();
    $date = $time->date;
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $timesheet = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
      ->get();
    //   dd($timesheet);
    $count = count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
    //  dd( $count);
    // $totalhour=$timesheet->totalhour;

    $rcount = 5 - $count;




    return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
  }
  public function view($id)
  {
    //  dd($id);
    $timesheet = timesheet::where('id', $id)->first();
    return view('backEnd.timesheet.view', compact('id', 'timesheet'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $data = $request->except(['_token']);
      $count = count($request->assignment_id);
      // dd($count);
      $timesheet = DB::table('timesheets')->where('date', $request->date)->delete();

      for ($i = 0; $i < $count; $i++) {
        DB::table('timesheets')->insert([
          'client_id'     =>     $request->client_id[$i],
          'workitem'     =>     $request->workitem[$i],
          //    'billable_status'     =>     $request->billable_status[$i],
          'hour'     =>     $request->hour[$i],
          'assignment_id'     =>     $request->assignment_id[$i],
          'createdby' => auth()->user()->teammember_id,
          'updatedby' => auth()->user()->teammember_id,
          'date'      => $request->date,
          'totalhour' => $request->totalhour,
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
      }

      $output = array('msg' => 'Updated Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $getid =  DB::table('timesheetusers')->where('id', $id)->first();
      DB::table('timesheets')->where('id', $getid->timesheetid)->delete();
      DB::table('timesheetusers')->where('id', $id)->delete();
      $output = array('msg' => 'Deleted Successfully');
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function timesheetrequestStore(Request $request)
  {
    try {
      $data = $request->except(['_token']);
      // dd($data);

      $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->latest()
        ->select('created_at', 'status')
        ->first();
      // dd($latestrequest);

      if ($latestrequest != null && $latestrequest->status != 2) {
        $latestrequesthour = Carbon::parse($latestrequest->created_at);
        // dd($latestrequest->created_at);
        $currentDateTime = Carbon::now();
        // Check if the difference is more than 24 hours
        if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
          $id = DB::table('timesheetrequests')->insertGetId([
            'partner'     =>     $request->partner,
            'reason'     =>     $request->reason,
            'status'     =>     0,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // timesheet request mail to admin
          $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
          $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

          $data = array(
            'teammember' => $name ?? '',
            'email' => $teammembermail ?? '',
            'id' => $id ?? '',
          );
          Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            $msg->cc('itsupport_delhi@vsa.co.in');
            $msg->subject('Timesheet Submission Request');
          });
          // timesheet request mail to admin
          $output = array('msg' => 'Request Successfully');
          return back()->with('success', $output);
        } else {
          $output = array('msg' => 'You can submit new timesheet request after 24 hour from ' . date('h-m-s', strtotime($latestrequest->created_at)));
          return back()->with('statuss', $output);
        }
      } else {
        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     =>     $request->partner,
          'reason'     =>     $request->reason,
          'status'     =>     0,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);

        // timesheet request mail to admin
        $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

        $data = array(
          'teammember' => $name ?? '',
          'email' => $teammembermail ?? '',
          'id' => $id ?? '',
        );
        Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
          $msg->to($data['email']);
          $msg->cc('itsupport_delhi@vsa.co.in');
          $msg->subject('Timesheet Submission Request');
        });
        // timesheet request mail to admin
        $output = array('msg' => 'Request Successfully');
        return back()->with('success', $output);
      }
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetrequestlist()
  {
    $timesheetrequestlist = DB::table('timesheetrequests')
      ->leftjoin('timesheetusers', 'clients.client_id', 'timesheetrequests.id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
      ->leftjoin('teammembers as team', 'team.id', 'timesheetrequests.partner')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.createdby')
      ->where('timesheetrequests.createdby', auth()->user()->teammember_id)
      ->where('timesheetrequests.partner', auth()->user()->teammember_id)
      ->select('timesheetrequests.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    // dd($timesheetData);

    return view('backEnd.timesheet.timesheetrequest', compact('timesheetrequestlist'));
  }


  //Report

  public function Reportsection(Request $request)
  {

    $employeename = Teammember::where('role_id', '!=', 11)->where('status', 1)->with('title', 'role')->get();
    $client = Client::select('id', 'client_name')->get();
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $partner = Teammember::where('role_id', '=', 13)->where('status', 1)->with('title', 'role')->get();

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($assignment);
    if ($request->ajax()) {
      //   dd($request);
      if (isset($request->cid)) {
        $clientdata = explode(",", $request->cid);
        echo "<option value=''>Select Assignment</option>";
        foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
          ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->orderBy('assignment_name')->distinct()->get(['assignments.id', 'assignments.assignment_name']) as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }

      if (isset($request->clientid)) {
        $clientdata = explode(",", $request->clientid);
        echo "<option value=''>Select Employee</option>";
        foreach (DB::table('timesheetusers')->whereIn('client_id', $clientdata)
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->orderBy('team_member')->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $sub) {
          echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
        }
      }

      if (isset($request->ass_id)) {
        //dd($request->ass_id);;
        $ass_data = explode(",", $request->ass_id);
        //dd($ass_data);


        echo "<option value=''>Select Partner</option>";
        foreach (DB::table('teammembers')
          ->leftjoin('timesheetusers', 'timesheetusers.partner', 'teammembers.id')
          ->whereIn('timesheetusers.assignment_id', $ass_data)
          ->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $subs) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
        //   die;
      }
    } else {
      return view('backEnd.timesheet.reportsection', compact('employeename', 'client', 'assignment', 'partner', 'years'));
    }
  }
  // ! 16-02-24
  // public function filterDataAdmin(Request $request)
  // {
  //   // this is for patner submitted timesheet 
  //   if (auth()->user()->role_id == 13) {
  //     // dd($request);
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest();

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }
  //   }
  //   // this is for admin,manager and staff
  //   else {
  //     // dd(auth()->user()->role_id);
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->orderBy('timesheetreport.startdate', 'desc');

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }
  //   }

  //   $filteredDataaa = $query->get();

  //   // maping double date ************
  //   $groupedData = $filteredDataaa->groupBy(function ($item) {
  //     return $item->team_member . '|' . $item->week;
  //   })->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object)[
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //     ];
  //   });

  //   $filteredData = collect($groupedData->values());
  //   return response()->json($filteredData);
  // }

  // filter on submited timesheet 
  public function filterDataAdmin(Request $request)
  {
    $urlheader = $request->headers->get('referer');
    $url = parse_url($urlheader);
    $path = $url['path'];
    // dd($url);
    // this is for patner submitted timesheet 
    if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
      // dd('patner');
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for team submitted timesheet on patner
    elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
      // dd($request);
      // dd('team');
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->orderBy('timesheetreport.startdate', 'desc');

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for submitted timesheet on staff and manager 
    elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
      // dd($request);
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for team submitted timesheet on Admin
    else {
      // dd(auth()->user()->role_id);
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->orderBy('timesheetreport.startdate', 'desc');

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }

    $filteredDataaa = $query->get();

    // maping double date ************
    $groupedData = $filteredDataaa->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $filteredData = collect($groupedData->values());
    return response()->json($filteredData);
  }

  public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();


      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        // i have removed below line 
        // ->where('timesheetusers.partner', $request->partnerid)
        // ->where('timesheetusers.status', 1)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    } else {
      // edit timesheet
      // dd(auth()->user());
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        // i have removed below line 
        // ->where('timesheetusers.partner', $request->partnerid)
        // ->where('timesheetusers.status', 1)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }

  //* timesheet edit fubctionality
  public function timesheetEdit(Request $request, $id)
  {
    $timesheetedit = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
      ->get();

    // client of particular partner
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      $client = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    //   dd($assignment);
    // shahid assi
    if ($request->ajax()) {
      // dd(auth()->user()->id);
      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
            ->where('created_by', auth()->user()->id)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        } else {
          echo "<option>Select Assignment</option>";
          foreach (DB::table('assignmentbudgetings')
            ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
            ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            ->where('assignmentbudgetings.client_id', $request->cid)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->orderBy('assignment_name')->get() as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }
      }
      if (isset($request->assignment)) {

        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->select('teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (DB::table('assignmentmappings')

            ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
            ->get() as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
    }
  }
  public function timesheeteditstore(Request $request)
  {
    if (!is_numeric($request->assignment_id)) {
      $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
        ->select('assignment_id')
        ->get()
        ->toArray();
      $assignment_id = $assignment[0]['assignment_id'];
    } else {
      $assignment_id = $request->assignment_id;
    }
    try {
      DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
        'status'   =>   3,
        'client_id'   =>  $request->client_id,
        // 'assignment_id'   =>  $request->assignment_id,
        'assignment_id'   =>   $assignment_id,
        'partner'   =>  $request->partner,
        'workitem'   =>   $request->workitem,
        'createdby'   =>   $request->createdby,
        'location'   =>   $request->location,
        'hour'   =>   $request->hour,
      ]);

      if ($request->status == 2) {
        DB::table('timesheetupdatelogs')->insert([
          'timesheetusers_id'   =>  $request->timesheetusersid,
          'status'   =>   3,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
      $output = array('msg' => 'Updated Successfully');
      // return back()->with('statuss', $output);
      return redirect()->to('rejectedlist')->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function rejectedlist(Request $request)
  {

    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        // ->where('timesheetusers.status', 2)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    } else if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }

  // all rejected timesheet on patner for team
  public function rejectedlistteam(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    // return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
    return view('backEnd.timesheet.rejectedlistteam', compact('timesheetData'));
  }

  // after rejectedlistteam()

  public function rejectedtimesheetlog(Request $request)
  {
    if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }

  public function  timesheetreject($id)
  {

    try {
      DB::table('timesheetusers')->where('id', $id)->update([

        'status'   => 2,
        'rejectedby'   =>   auth()->user()->teammember_id,

      ]);
      // timesheet rejected mail
      $data = DB::table('teammembers')
        ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        ->where('timesheetusers.id', $id)
        ->first();
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.timesheetrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Timesheet rejected');
      });
      // timesheet rejected mail end hare


      $output = array('msg' => 'Rejected Successfully');
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }


  public function filtersection(Request $request)
  {
    //dd($request);
    if ($request->ajax()) {
      $clients = collect(is_array($request->clientid) ? $request->clientid : explode(',', $request->clientid))->filter();
      $employeeIds = collect(is_array($request->employeeid) ? $request->employeeid : explode(',', $request->employeeid))->filter();
      $assignmentIds = collect(is_array($request->assignmentid) ? $request->assignmentid : explode(',', $request->assignmentid))->filter();
      $partners = collect(is_array($request->partnerid) ? $request->partnerid : explode(',', $request->partnerid))->filter();
      //$dateRange = collect(is_array($request->daterange) ? $request->daterange : explode(' - ', $request->daterange))->filter();
      // $dateRange = collect(explode(' - ', $request->daterange))->filter();
      //[$startDate, $endDate] = $dateRange->map(fn ($date) => Carbon::parse($date));

      $date = explode(" - ", $request->daterange);
      // dd($date);
      $start = Carbon::parse($date[0]);
      $end = Carbon::parse($date[1]);

      $now = Carbon::now();
      $noww = Carbon::parse($now);
      //dd($start);
      if ($start == $end) {
        $daterange = null;
      } else {
        $daterange = 1;
      }
      /*
$financial_year = $request->yearly;


		
		
$quarter = $request->quarter; // Update with the desired quarter (q1, q2, q3, or q4)

$Qstart = '';
$Qend = '';
//dd($quarter);
if ($quarter == 'Q1') {
	
    $Qstart = $financial_year .'-05-01';
    $Qend = $financial_year .'-06-30';
} elseif ($quarter == 'Q2') {
	//dd('hi');
    $Qstart = $financial_year .'-07-01';
	//dd($Qstart);
    $Qend = $financial_year . '-09-30';
} elseif ($quarter == 'Q3') {
    $Qstart = $financial_year . '-10-01';
    $Qend = ($financial_year + 1) . '-01-01';
} elseif ($quarter == 'Q4') {
    $Qstart = ($financial_year + 1) . '-01-01';
    $Qend = $financial_year . '-03-31';
}
*/



      //	dd($Qstart);

      $query1 = $request->workitem;
      $query1 = str_replace(' ', '%', $query1);

      if ($request->month == 0) {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))
          //  ->when($financial_year !='2025', fn ($query) => $query->whereYear('date', $financial_year))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //		   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //   ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          ->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month != 0, fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as 				partnername')
          ->get();
      } else {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn ($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn ($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn ($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn ($query) => $query->whereIn('partner', $partners))

          //		->when($request->yearly !=2025, fn ($query) => $query->whereYear('timesheetusers.date', $request->yearly))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //			   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //	  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //     ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //    ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //    ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          // ->when($startDate && $endDate, fn ($query) => $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate))
          ->when($request->billableid, fn ($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month, fn ($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn ($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as partnername')
          ->get();
      }

      return response()->json($timesheetData);
    }
  }
}

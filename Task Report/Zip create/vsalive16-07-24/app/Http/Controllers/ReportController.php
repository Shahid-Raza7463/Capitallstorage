<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function assignment_report()
  {
    if (auth()->user()->role_id == 11) {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code'
        )
        ->get();
      $assignmentmappingcloseData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code'
        )
        ->get();
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    } elseif (auth()->user()->role_id == 13) {

      $assignmentmappingOpenleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.leadpartner',
        )
        ->get();

      $assignmentmappingOpenotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '1')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.otherpartner',

        )
        ->get();

      $assignmentmappingData = $assignmentmappingOpenotherpartner->merge($assignmentmappingOpenleadpartner);

      // dd($assignmentmappingData);
      $assignmentmappingClosedleadpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.leadpartner',
        )->get();

      $assignmentmappingClosedotherpartner =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentmappings.otherpartner',
        )->get();

      $assignmentmappingcloseData = $assignmentmappingClosedotherpartner->merge($assignmentmappingClosedleadpartner);
      // dd($assignmentmappingcloseData);
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    } else {
      $assignmentmappingData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', '1')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentteammappings.teamhour',
        )->get();



      $assignmentmappingcloseData =  DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
        ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->where('assignmentbudgetings.status', '0')
        //------------------- Shahid's code start---------------------
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->select(
          'assignmentmappings.*',
          'assignmentbudgetings.duedate',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.status',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'assignmentteammappings.teamhour',
        )->get();
      // dd($assignmentmappingcloseData);

      // dd($assignmentmappingData);
      return view('backEnd.report.assignmentreport', compact('assignmentmappingData', 'assignmentmappingcloseData'));
    }
  }
}

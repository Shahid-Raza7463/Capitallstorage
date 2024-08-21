<?php

class ZipController extends Controller
{
  public function store(Request $request) {
//*

// Start Hare 
// Start Hare 
//*
// Start Hare 
// Start Hare 
//* regarding filter
// Start Hare 
$teammemberDatas = DB::table('assignmentmappings')
->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
->leftjoin('titles', 'titles.id', 'teammembers.title_id')
->leftjoin('roles', 'roles.id', 'teammembers.role_id')
->where('assignmentmappings.assignmentgenerate_id', $id)
// filter null value hare 
->whereNotNull('assignmentteammappings.id')
->select('teammembers.*', 'roles.rolename', 'assignmentteammappings.type', 'titles.title', 'assignmentteammappings.id As assignmentteammappingsId', 'assignmentteammappings.status as assignmentteammappingsStatus', 'assignmentmappings.assignmentgenerate_id as assignmentgenerateid', 'assignmentteammappings.teamhour', 'assignmentmappings.leadpartner', 'assignmentteammappings.viewerteam')
->orderBy('assignmentteammappingsId', 'desc')
->get();
// Start Hare 
$teammemberDatas = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'assignmentteammappings.teammember_id')
    ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
    ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    ->where('assignmentmappings.assignmentgenerate_id', $id)
    ->select(
        'teammembers.*',
        'roles.rolename',
        'assignmentteammappings.type',
        'titles.title',
        'assignmentteammappings.id As assignmentteammappingsId',
        'assignmentteammappings.status as assignmentteammappingsStatus',
        'assignmentmappings.assignmentgenerate_id as assignmentgenerateid',
        'assignmentteammappings.teamhour',
        'assignmentmappings.leadpartner',
        'assignmentteammappings.viewerteam'
    )
    ->orderBy('assignmentteammappingsId', 'desc')
    ->get()
    ->filter(function ($item) {
        return $item->assignmentteammappingsId !== null;
    });


// Start Hare 
//* regarding title 
// Start Hare 

// Start Hare 
//*
// Start Hare 
$partner = Teammember::where('role_id', '=', 13)
->where('status', '=', 1)
->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
->with('title')
->orderBy('team_member', 'asc')
->get();
$pormotionandrejoiningdata = Teammember::leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
->where('teammembers.id', auth()->user()->teammember_id)
->select(
  'teammembers.team_member',
  'teammembers.staffcode',
  'teammembers.joining_date',
  'teamrolehistory.newstaff_code',
  'teamrolehistory.rejoiningdate',
  'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
)
->first();
// Start Hare 
//* regarding permotions 
// Start Hare 
elseif ($permotioncheck && auth()->user()->role_id == 13) {
  // $timesheetrequestsDatas = DB::table('timesheetrequests')
  //     ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
  //     ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
  //     ->where('timesheetrequests.status', 0)
  //     ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
  //     ->where(function ($query) {
  //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
  //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
  //     })
  //     ->select(
  //         'timesheetrequests.*',
  //         'clients.client_name',
  //         'assignments.assignment_name',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'createdby.team_member as createdbyauth',
  //         'createdby.staffcode as staffcodeid',
  //     )->get();

  // $timesheetrequestspermotion = DB::table('timesheetrequests')
  //     ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
  //     ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
  //     ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
  //     ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
  //     ->where('timesheetrequests.status', 0)
  //     ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
  //     ->where(function ($query) {
  //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
  //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
  //     })
  //     ->select(
  //         'timesheetrequests.*',
  //         'clients.client_name',
  //         'assignments.assignment_name',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'createdby.team_member as createdbyauth',
  //         'createdby_history.newstaff_code',
  //     )
  //     ->get();
  // dd($timesheetrequestsDatas);

  // Define the common parts of the query
   // Define the common parts of the query
   $commonQuery = DB::table('timesheetrequests')
   ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
   ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
   ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
   ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
   ->where('timesheetrequests.status', 0)
   ->where(function ($query) {
       $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
   })
   ->select(
       'timesheetrequests.*',
       'clients.client_name',
       'assignments.assignment_name',
       'teammembers.team_member',
       'teammembers.staffcode',
       'createdby.team_member as createdbyauth'
   );

// Get the timesheet requests before and after the promotion date
$timesheetrequestsDatas = (clone $commonQuery)
   ->whereDate('timesheetrequests.created_at', '<', $permotioncheck->created_at)
   ->addSelect('createdby.staffcode as staffcodeid')
   ->get();

$timesheetrequestspermotion = (clone $commonQuery)
   ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
   ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
   ->addSelect('createdby_history.newstaff_code')
   ->get();

return view('backEnd.timesheetrequest.index', [
   'timesheetrequestsDatas' => $timesheetrequestsDatas,
   'timesheetrequestspermotion' => $timesheetrequestspermotion,
]);
}
// Start Hare 
//*
// Start Hare 
if ($permotioncheck && auth()->user()->role_id == 13) {
  $baseQuery = DB::table('timesheetrequests')
      ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
      ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetrequests.partner')
      ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
      ->where('timesheetrequests.status', 0)
      ->where(function ($query) {
          $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
              ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
      })
      ->select(
          'timesheetrequests.*',
          'clients.client_name',
          'assignments.assignment_name',
          'teammembers.team_member',
          'teammembers.staffcode',
          'createdby.team_member as createdbyauth'
      );

  $timesheetrequestsDatas = (clone $baseQuery)->get();

  $timesheetrequestspermotion = (clone $baseQuery)
      ->leftJoin('teamrolehistory as createdby_history', 'createdby_history.teammember_id', '=', 'createdby.id')
      ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
      ->addSelect('createdby_history.newstaff_code')
      ->get();

  dd($timesheetrequestspermotion);
}

// Start Hare 
//* regarding echo
// Start Hare 
 // $timesheetrequestspermotion = DB::table('timesheetrequests')
            //     ->leftJoin('clients', 'clients.id', '=', 'timesheetrequests.client_id')
            //     ->leftJoin('assignments', 'assignments.id', '=', 'timesheetrequests.assignment_id')
            //     ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetrequests.partner')
            //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'partners.id')
            //     ->leftJoin('teammembers as createdby', 'createdby.id', '=', 'timesheetrequests.createdby')
            //     ->where('timesheetrequests.status', 0)
            //     ->whereDate('timesheetrequests.created_at', '>', '2024-07-17')
            // ->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
            //     ->where(function ($query) {
            //         $query->where('timesheetrequests.partner', auth()->user()->teammember_id)
            //             ->orWhere('timesheetrequests.createdby', auth()->user()->teammember_id);
            //     })
            //     ->select(
            //         'timesheetrequests.id as timesheet_request_id',
            //         'timesheetrequests.*',
            //         'clients.client_name',
            //         'assignments.assignment_name',
            //         'partners.id as partner_id',
            //         'partners.team_member',
            //         'partners.staffcode',
            //         'teamrolehistory.newstaff_code',
            //         'createdby.team_member as createdbyauth',
            //         'createdby.staffcode as staffcodeid'
            //     )
            //     ->get();

            // foreach ($timesheetrequestspermotion as $request) {
            //     echo 'Timesheet Request ID: ' . $request->timesheet_request_id . '<br>';
            //     echo 'New Staff Code: ' . $request->newstaff_code . '<br>';
            //     echo 'Partner ID: ' . $request->partner_id . '<br>';
            //     echo 'Created By Auth: ' . $request->createdbyauth . '<br>';
            //     echo '<br>';
            // }

            // dd($timesheetrequestspermotion);
// Start Hare 
//* resize image / regarding image
// Start Hare 
$assign = Teammember::where('role_id', 14)->latest()->get();
if ($request->hasFile('profilepic')) {
  $avatar = $request->file('profilepic');
  $filename = time() . rand(1, 100) . '.' . $avatar->getClientOriginalExtension();
  Image::make($avatar)->resize(800, 600)->save('backEnd/image/teammember/profilepic/' . $filename);
  $data['profilepic'] = $filename;
}

if ($request->hasFile('addressupload')) {
  $file = $request->file('addressupload');
  $destinationPath = 'backEnd/image/teammember/addressupload';
  $name = time() . $file->getClientOriginalName();
  $s = $file->move($destinationPath, $name);
  //  dd($s); die;
  $data['addressupload'] = $name;
}
// Start Hare 
//* regarding null value handle 
// Start Hare 
$latesttimesheetsubmitted = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->latest()
    ->first();

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted && $latesttimesheetsubmitted->enddate) {
    try {
        $latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);
    } catch (\Exception $e) {
        // Log the error if the date format is invalid
        Log::error('Invalid date format for enddate: ' . $latesttimesheetsubmitted->enddate);
    }
}

if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {
    // Your logic here for when the latest timesheet submission date is greater than the 'from' date
}

$latesttimesheetsubmitted = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->latest()
->first();

// $latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted) {
$latesttimesheetsubmittedformate = $latesttimesheetsubmitted->enddate
  ? Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate)
  : null;
}

// Check if the from date is in the past
if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {



$permotioncheck = null;
$datadate = $client_id->created_at
    ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $client_id->created_at)
    : null;
$permotiondate = null;

$latesttimesheetsubmitted = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->latest()
->first();

$latesttimesheetsubmittedformate = null;
if ($latesttimesheetsubmitted) {
$latesttimesheetsubmittedformate = Carbon::createFromFormat('Y-m-d', $latesttimesheetsubmitted->enddate);
}

// Check if the from date is in the past
if ($latesttimesheetsubmittedformate && $latesttimesheetsubmittedformate->greaterThan($from)) {
// Check if the from date is in the past
if ($softwarermaked->greaterThan($from)) {
  $output = ['msg' => 'You cannot apply leave before 11-09-2023'];
  return back()->with('statuss', $output);
}

$rejectedtimesheet = DB::table('timesheetusers')
  ->where('createdby', auth()->user()->teammember_id)
  ->where('status', 2)
  ->first();


$rejectedtimesheetformate = null;
if ($rejectedtimesheet) {
  $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
}

if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {

  $output = array('msg' => 'Create Successfully');
  return back()->with('success', $output);
} else {
  $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
  return back()->with('statuss', $output);
}
}
// Start Hare 
if (is_null($nextweektimesheet) && is_null($rejoiningchecktimesheet) && is_null($rejoiningDate)) {
  $output = array('msg' => "Fill the Week timesheet After this week: $formattedNextSaturday1");
  dd($output, 2);
  return back()->with('statuss', $output);
}
// Start Hare 
//* regarding middleware 
// Start Hare 
public function __construct()
{
    $this->middleware('auth')->except(['confirmationAccept', 'confirmationauthotp', 'confirmationConfirmhide', 'otpapstore', 'otpapstore_hide', 'indexview', 'confirmationConfirm', 'otpskipconfirmation', 'otpskipconfirmationhide']);
}
// Start Hare 
//* regarding validation / regarding file / regarding validate
// Start Hare 
$request->validate([
  'reason' => 'required',
  'file' => 'required|mimes:png,pdf,jpeg,jpg|max:5120',
  'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
]);

$request->validate([
  'reason' => 'required',
  'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
], [
  'file.max' => 'The file may not be greater than 5 MB.',
]);
// Start Hare 
//*regarding date formate 
// Start Hare 
date('d-M-Y', strtotime($udinData->udindate))
// 12-jul-2024

// Start Hare 
//* regarding skip condition 
// Start Hare 

$skipaftertrue = false;
$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');
// software created date 
$softwarermaked = Carbon::createFromFormat('Y-m-d', '2023-09-11');
  // Check if the from date is in the past
  if ($latesttimesheetsubmittedformate->greaterThan($from)) {

    // Check if the from date is in the past
    if ($softwarermaked->greaterThan($from)) {
      $output = ['msg' => 'You cannot apply leave before 11-09-2023'];
      return back()->with('statuss', $output);
    }

    $rejectedtimesheet = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->where('status', 2)
      ->first();


    $rejectedtimesheetformate = null;
    if ($rejectedtimesheet) {
      $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
    }

    if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {
      $skipaftertrue = true;
    } else {
      $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
      return back()->with('statuss', $output);
    }
  }
// Start Hare 
//* regarding greater than and less than/ regarding greter than
// Start Hare 
$latestrequest = DB::table('timesheetrequests')
->where('createdby', auth()->user()->teammember_id)
->select('created_at')
->first();

$latestrequesthour = Carbon::parse($latestrequest->created_at);
$currentDateTime = Carbon::now();
// Check if the difference is more than 24 hours
if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
$id = DB::table('timesheetrequests')->insertGetId([
  'partner'     => $request->partner,
  'reason'      => $request->reason,
  'status'      => 0,
  'createdby'   => auth()->user()->teammember_id,
  'created_at'  => now(),
  'updated_at'  => now(),
]);
}
// Start Hare 
if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}
// Start Hare 
$currentdate = date('Y-m-d');
@if ($currentdate < $timesheetrequest->validate){
  $ssssss='shahid';
}
// Start Hare 
//* regarding log 
// Start Hare 
Log::info('Request Data:', $request->all());
// Start Hare 

// Start Hare 
//*regarding zip file / regarding zip file download /regarding zip download
// Start Hare 
public function zipfile(Request $request, $assignmentfolder_id)
{
    if (auth()->user()->role_id == 11) {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = $generateid->assignmentfoldersname . '.zip';

        $zip = new ZipArchive;

        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($fileName as $file) {
            // $filePath = Storage::disk('s3')->url($generateid->assignmentgenerateid . '/' . $file->filesname);
            $filePath = storage_path('app/public/image/task/' . $file->filesname);

            $stream = fopen($filePath, 'r');

            if ($stream) {
                $zip->addFile($stream, $file->filesname);
                fclose($stream);
            } else {
                return '<h1>File Not Found</h1>';
            }
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ];

        // Delete the local zip file after sending
        return response()->stream(
            function () use ($zipFileName) {
                readfile($zipFileName);
                unlink($zipFileName);
            },
            200,
            $headers
        );
    } else {

        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
        //dd($fileName);

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($fileName as $file) {
                // Replace storage_path with S3 access method
                // $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);
                $filePath = storage_path('app/public/image/task/' . $file->filesname);

                if ($filePath) {
                    $zip->addFromString($file->filesname, $filePath);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }

            $zip->close();
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}

// Start Hare 
public function store(Request $request)
{
    //dd($request);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $realname = $file->getClientOriginalName();
                $name = time() . $realname;
                $path = $file->storeAs('public\image\task', $name);
                $files[] = [
                    'name' => $name,
                    'realname' => $realname,
                    'size' => round($file->getSize() / 1024, 2),

                ];
            }
        }
        foreach ($files as $filess) {
            // dd($files); die;
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' =>  $request->assignmentfolder_id,
                'createdby' =>  auth()->user()->teammember_id,
                'filesname' =>  $filess['name'],
                'realname' =>  $filess['realname'],
                'filesize' => $filess['size'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        //dd($data);
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
// Start Hare 
// resources\views\backEnd\assignmentfolderfile\index.blade.php
{{-- local --}}
{{-- public\storage\image\task\  yaha file ko copy karke rakhe --}}
<td>
    <a target="_blank"
        href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td>
{{-- <td>
    <a target="_blank"
        href="{{ asset('public\image\task' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td> --}}
{{-- <td><a target="blank"
        href="{{ Storage::disk('s3')->temporaryUrl($foldername->assignmentgenerateid . '/' . $assignmentfolderData->filesname, now()->addMinutes(30)) }}">
        {{ $assignmentfolderData->realname ?? '' }}</a></td> --}}
// Start Hare 
//* return responce
// Start Hare 
                // return response()->json([
                //     'success' => true,
                //     'status' => $status,
                //     'clientid' => $clientid,
                //     'debtorid' => $debtorid,
                //     'debtorconfirm' => $debtorconfirm
                // ]);
// Start Hare 
//* regarding crons / regarding cron / regarding mail using cron / regarding job 
// Start Hare 
// app\Console\command
// 1.Create command 

// app\Console\Kernel.php
// 2.register command in kernal file 

// app\Http\Controllers\HomeController.php
// 3.create function like 
public function timesheetnotfillstaffreminder()
{

  $exitCode = Artisan::call('command:timesheetnotfillstaffreminder')->daily();

  return  redirect('/');
}

// routes\web.php
// 4. create route like 
Route::get('/balanceconfirmationreminder', [HomeController::class, 'balanceconfirmationreminder']);
// end hare 

// Start Hare 
// Start Hare 
//* regarding array / insert data in array 
// Start Hare 
$result = [930, 797, 779, 777, 917, 910];
$data = [];
foreach ($result as $userId) {
  $sumhour = DB::table('timesheetusers')
    ->where('assignmentgenerate_id', 'WAV100526')
    ->where('createdby', $userId)
    ->sum('totalhour');

  $data[] = $sumhour;
}
dd($data);
//* regarding array
// Start Hare 
// Remove empty values in array
$mailarray = array_filter([$data['email'], $data['secondaryemail'] ?? '']);
if (!empty($mailarray)) {
    foreach ($mailarray as $email) {
        $msg->to($email);
    }
}
// Start Hare 

// array_filter()
$filtered = array_filter($array, function($value) {
    return $value > 5;
});

// collect()
$collection = collect($array);

// pluck()
$names = collect($users)->pluck('name');

// map()
$doubled = collect([1, 2, 3])->map(function ($item, $key) {
    return $item * 2;
});

// reduce()
$total = collect([1, 2, 3])->reduce(function ($carry, $item) {
    return $carry + $item;
}, 0);

// where()
$filtered = collect($users)->where('active', true);

// first()
$first = collect($users)->first();

// last()
$last = collect($users)->last();


// Start Hare 
// array_filter()
$filtered = array_filter($array, function($value) {
    return $value > 5;
});

// collect()
$collection = collect($array);

// pluck()
$names = collect($users)->pluck('name');

// map()
$doubled = collect([1, 2, 3])->map(function ($item, $key) {
    return $item * 2;
});

// reduce()
$total = collect([1, 2, 3])->reduce(function ($carry, $item) {
    return $carry + $item;
}, 0);

// where()
$filtered = collect($users)->where('active', true);

// first()
$first = collect($users)->first();

// last()
$last = collect($users)->last();

// sortBy()
$sorted = collect($users)->sortBy('name');

// keys()
$keys = collect(['name' => 'John', 'age' => 30])->keys();

// values()
$values = collect(['name' => 'John', 'age' => 30])->values();

// flatten()
$flattened = collect(['name' => 'John', 'languages' => ['PHP', 'JavaScript']])->flatten();

// merge()
$merged = collect(['name' => 'John'])->merge(['age' => 30]);

// unique()
$unique = collect([1, 2, 2, 3, 3, 4])->unique();

// reverse()
$reversed = collect([1, 2, 3])->reverse();

// shuffle()
$shuffled = collect([1, 2, 3, 4, 5])->shuffle();

// chunk()
$chunked = collect([1, 2, 3, 4, 5])->chunk(2);



// Start Hare 
//* regarding mail failed
// Start Hare 
// Start Hare 
try {
  Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request) {
      $msg->to($data['email']);
      $msg->subject($data['subject']);

      if ($request->teammember_id) {
          $msg->cc($data['teammembermail']);
      }

      // Add CC for additional emails from the input field
      // Add CC for additional emails from the input field
      if ($request->ccmail) {
          $assignEmails = explode(',', $request->ccmail);
          foreach ($assignEmails as $email) {
              $msg->cc(trim($email));
          }
      }
  });

  DB::table('debtors')
      ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
      ->where('id', $debtors->id)
      ->update([
          'mailstatus' => 1,
          'status' => 3,
          'updated_at' => now()
      ]);
} catch (Exception $e) {
  // Log the error or handle it as needed
  // For example, you can log the exception to laravel.log
  // or you can notify the administrator about the failure
  \Log::error('Mail sending failed: ' . $e->getMessage());

  // Update mailstatus to 0 in the database
  DB::table('debtors')
      ->where('assignmentgenerate_id', $debtors->assignmentgenerate_id)
      ->where('id', $debtors->id)
      ->update([
          'mailstatus' => 0,
          'updated_at' => now()
      ]);
}
// Start Hare 
//* regarding file upload
// Start Hare 
    $fileName = '';
    if ($request->hasFile('file')) {
        $file = $request->file('file');
                    // public\backEnd\image\confirmationfile
        $destinationPath = 'backEnd/image/confirmationfile';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
    }

    DB::table('debtorconfirmations')->insert([
        'debtor_id' => $request->debitid,
        'assignmentgenerate_id' => $request->assignmentgenerate_id,
        'remark' => null,
        'amount' => null,
        'file' => $fileName,
        'name' => $debtorconfirm->name,
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d'),
    ]);
// Start Hare 
if ($request->hasFile('report')) {
  $file = $request->file('report');
  $destinationPath = 'backEnd/image/report';
  $name = $file->getClientOriginalName();
  $s = $file->move($destinationPath, $name);
  $data['salaryincomefile'] = $name;
  $data['report'] = $name;
}
// Start Hare 
// app\Http\Controllers\AssignmentfolderfileController.php
public function store(Request $request)
{
    // dd(auth()->user()->teammember_id);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('public\image\task', $name);
                $files[] = $name;
            }
        }
        foreach ($files as $filess) {
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $filess,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        // dd($e);
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

public function store(Request $request)
{
    // storage\app\public\image\task\Screenshot_2.png
    // dd(auth()->user()->teammember_id);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('public\image\task', time() . $name);
                $files[] = $name;
            }
        }
        foreach ($files as $filess) {
            // dd($auth()->user()->teammember_id);
            // dd($files); die;
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $filess,
                'filenameunique' => time() . $filess,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        // dd($e);
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

// Start Hare 
//* regarding compare
// Start Hare 

                    // $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                    //     ->max('assignmentnumber');
                    // dd($assignmentnumb);

                    // $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                    //     ->latest('assignmentnumber')
                    //     ->value('assignmentnumber');

                    // Find the minimum and maximum assignment numbers within the table
                    $minAssignmentNumber = Assignmentbudgeting::min('assignmentnumber');
                    $maxAssignmentNumber = Assignmentbudgeting::max('assignmentnumber');

                    // Retrieve the highest assignment number within the dynamically determined range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [$minAssignmentNumber, $maxAssignmentNumber])
                        ->orderByDesc('assignmentnumber')
                        ->pluck('assignmentnumber')
                        ->first();

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::selectRaw('MAX(assignmentnumber) as max_assignmentnumber')
                        ->whereBetween('assignmentnumber', [100001, 100526])
                        ->value('max_assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = DB::table('assignmentbudgetings')
                        ->whereBetween('assignmentnumber', [100001, 100526])
                        ->max('assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                        ->orderByDesc('assignmentnumber')
                        ->pluck('assignmentnumber')
                        ->first();

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $assignmentnumb = Assignmentbudgeting::whereBetween('assignmentnumber', [100001, 100526])
                        ->latest('assignmentnumber')
                        ->value('assignmentnumber');

                    dd($assignmentnumb);

                    // Retrieve the highest assignment number within the range
                    $highestAssignmentNumber = Assignmentbudgeting::whereBetween('assignmentnumber', [101, 256])
                        ->max('assignmentnumber');

                    dd($highestAssignmentNumber);
// Start Hare 
//*
// Start Hare 
$affectedRows = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->where('startdate', $previousMondayFormatted)
    ->orderBy('id') // Assuming there's an 'id' column in your table for sorting
    ->limit(1) // Only update the first row
    ->update(['dayscount' => 1]);
// Start Hare 
//*
// Start Hare 
public function adminsearchtimesheet1(Request $request)
{
  if ($request->ajax()) {
    echo "<option value='0'>Select Assignment</option>";
    foreach (DB::table('assignmentbudgetings')
      ->where('assignmentbudgetings.client_id', $request->cid)
      ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
      ->orderBy('assignment_name')->get() as $sub) {
      echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . ' )' . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
    }
  }
}
// Start Hare 
//* regarding partner
// Start Hare 
$leadpartner = DB::table('assignmentmappings')
->join('teammembers as team', 'team.id', 'assignmentmappings.leadpartner')
->where('assignmentmappings.assignmentgenerate_id', $id)
->select('team.id', 'team.team_member', 'assignmentmappings.leadpartnerhour')
->get();


$otherpartner = DB::table('assignmentmappings')
->join('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
->where('assignmentmappings.assignmentgenerate_id', $id)
->select('team.id', 'team.team_member', 'assignmentmappings.otherpartnerhour')
->get();

$partner = $leadpartner->merge($otherpartner);
dd($partner);
// regarding ?? 
// <td>{{ $partnerData->leadpartnerhour ?? ($partnerData->otherpartnerhour ?? 0) }}
// Start Hare 
//*
// Start Hare 

$distinctteammember = $teammemberDatas->unique('team_member')->sortBy('team_member');
$distinctassignmentid = $teammemberDatas
    ->unique('assignmentgenerate_id')
    ->sortBy('assignmentgenerate_id');
$distinctAssignmentNames = $teammemberDatas
    ->unique('assignmentname')
    ->sortBy('assignmentname');
// Start Hare 
//* regarding collect
// Start Hare 
$teammemberDatas = collect($teammemberDatas);
// Start Hare 
//* regarding Authentication
// Start Hare 
use Illuminate\Support\Facades\Auth;
 
// Retrieve the currently authenticated user...
$user = Auth::user();
 
// Retrieve the currently authenticated user's ID...
$id = Auth::id();
$user = $request->user();
if (Auth::check()) {
  // The user is logged in...
}
Route::get('/flights', function () {
  // Only authenticated users may access this route...
})->middleware('auth');
protected function redirectTo(Request $request): string
{
    return route('login');
}
Route::get('/flights', function () {
  // Only authenticated users may access this route...
})->middleware('auth:admin');

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
  // Authentication was successful...
}
if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
  // The user is being remembered...
}
if (Auth::viaRemember()) {
  // ...
}
// Start Hare 
//*regarding request 
// Start Hare
$input = $request->all();
$input = $request->collect();
$request->collect('users')->each(function (string $user) {
  // ...
});
$request->merge(['totalhour' => 0]);
$request->mergeIfMissing(['votes' => 0]);
dd($request); 
$name = $request->input('location.1');
$name = $request->input('products.0.name');
 
$names = $request->input('products.*.name');
$input = $request->input();
$name = $request->query('name');
$name = $request->query('name', 'Helen');
$name = $request->input('user.name');
$name = $request->string('name')->trim();
$archived = $request->boolean('archived');
$birthday = $request->date('birthday');
$elapsed = $request->date('elapsed', '!H:i', 'Europe/Madrid');
$name = $request->name;
$input = $request->only(['username', 'password']);
 
$input = $request->only('username', 'password');
 
$input = $request->except(['credit_card']);
 
$input = $request->except('credit_card');
if ($request->has('name')) {
  // ...
}
if ($request->has(['name', 'email'])) {
  // ...
}
if ($request->hasAny(['name', 'email'])) {
  // ...
}
$request->whenHas('name', function (string $input) {
  // ...
});
$request->whenHas('name', function (string $input) {
  // The "name" value is present...
}, function () {
  // The "name" value is not present...
});
if ($request->filled('name')) {
  // ...
}
if ($request->anyFilled(['name', 'email'])) {
  // ...
}
$request->whenFilled('name', function (string $input) {
  // ...
});
$request->whenFilled('name', function (string $input) {
  // The "name" value is filled...
}, function () {
  // The "name" value is not filled...
});

if ($request->missing('name')) {
  // ...
}

$request->whenMissing('name', function (array $input) {
  // The "name" value is missing...
}, function () {
  // The "name" value is present...
});
// Start Hare 

//* regarding saturday 
// Start Hare 
public function holidaysselect(Request $request)
{
  if ($request->ajax()) {

    $selectedDate = date('Y-m-d', strtotime($request->datepickers));
    // Get the day of the week (0 for Sunday, 6 for Saturday)
    $dayOfWeek = date('w', strtotime($selectedDate));
    if ($dayOfWeek == 6) {
      // Get the day of the month
      $dayOfMonth = date('j', strtotime($selectedDate));
      // Calculate which Saturday of the month it is
      $saturdayNumber = ceil($dayOfMonth / 7);
      if ($saturdayNumber == 1.0) {
        $saturday = '1st Saturday';
      } elseif ($saturdayNumber == 2.0) {
        $saturday = '2nd Saturday';
      } elseif ($saturdayNumber == 3.0) {
        $saturday = '3rd Saturday';
      } elseif ($saturdayNumber == 4.0) {
        $saturday = '4th Saturday';
      } elseif ($saturdayNumber == 5.0) {
        $saturday = '5th Saturday';
      }
    }

    $holidayname = DB::table('holidays')->where('startdate', $selectedDate)->select('holidayname')->first();
    $selectassignment = DB::table('assignmentbudgetings')->where('client_id', $request->cid)
      ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
      ->orderBy('assignment_name')->first();
    $selectpartner = DB::table('assignmentmappings')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
      ->where('assignmentmappings.assignmentgenerate_id', $selectassignment->assignmentgenerate_id)
      ->select('teammembers.team_member', 'teammembers.id')
      ->first();

    return response()->json([
      'holidayName' => $holidayname->holidayname ?? 'null',
      'saturday' => $saturday ?? 'null',
      'assignmentid' => $selectassignment->id,
      'assignmentgenerate_id' => $selectassignment->assignmentgenerate_id,
      'assignmentname' => $selectassignment->assignmentname,
      'assignment_name' => $selectassignment->assignment_name,
      'team_member' => $selectpartner->team_member,
      'team_memberid' => $selectpartner->id,
    ]);
  }
}
// Start Hare 
//* regarding abort() / regarding abort function 
// Start Hare 
// 1. Abort with a 404 HTTP Response:
abort(404);

// 2. Abort with a Custom HTTP Response Code and Message:
abort(403, 'Unauthorized access');

// 3. Abort with a Custom HTTP Response Code and Message using a HTTP Response Object:
abort(response('Unauthorized access', 403));

// 4. Abort with a Custom HTTP Response Code and Message using a JSON Response:
abort(response()->json(['error' => 'Unauthorized access'], 403));

// 5. Abort with a Custom HTTP Response Code and Message using a View:
abort(response()->view('errors.403', [], 403));

// 6. Abort with a Custom HTTP Response Code and Message using a Blade View:
abort(view('errors.403'), 403);

// 7. Abort with a 403 HTTP Response and Redirect to a Route:
abort(redirect()->route('login'));

// 8. Abort with a 500 HTTP Response and Log an Error Message:
abort(500, 'An internal server error occurred')->log('Error message');

// Start Hare 
//* regarding request
// Start Hare 
$request = request();
 
$value = request('key', $default);
// Start Hare 
//* regarding log 
// Start Hare 
info('Some helpful information!');
info('User login attempt failed.', ['id' => $user->id]);
logger('Debug message');
logger('User has logged in.', ['id' => $user->id]);
logger()->error('You are not allowed here.');
// Start Hare 
//* regarding env file / regarding env 
// Start Hare 
$env = env('APP_ENV');
$env = env('APP_URL');
$env = env('MAIL_FROM_ADDRESS');
dd($env);
// Start Hare 
//* regarding blank value  
// Start Hare 
blank('');
blank('   ');
blank(null);
blank(collect());
 
// true
 
blank(0);
blank(true);
blank(false);
 
// false
// Start Hare 
//* regarding route 
// Start Hare 
    // #routes: array:7 [▼
    //   "GET" => array:798 [ …798]
    //   "HEAD" => array:798 [ …798]
    //   "DELETE" => array:98 [ …98]
    //   "POST" => array:357 [ …357]
    //   "PUT" => array:96 [ …96]
    //   "PATCH" => array:96 [ …96]
    //   "OPTIONS" => array:1 [ …1]
    // ]
// Start Hare 
//* Regarding mising data / Regarding missing data 
// Start Hare 
    // Get all existing assignment numbers

    $existingAssignmentNumbers = DB::table('assignmentbudgetings')->pluck('assignmentnumber')->toArray();
    // Define the range of possible assignment numbers
    $minAssignmentNumber = 100001;
    $maxAssignmentNumber = 100512;

    // Generate an array of all possible assignment numbers within the range
    $allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
    // Find the missing assignment numbers
    $missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $existingAssignmentNumbers);

    // Now $missingAssignmentNumbers contains all the missing assignment numbers
    dd($missingAssignmentNumbers);

//     array:6 [▼
//   8 => 100009
//   10 => 100011
//   11 => 100012
//   12 => 100013
//   90 => 100091
//   323 => 100324
// ]
// Start Hare 
//! ABC100120  remove alphabetic word and get 100120 
$existingAssignmentNumbers = DB::table('assignmentbudgetings')->pluck('assignmentgenerate_id')->toArray();
// $existingAssignmentNumbers = DB::table('assignmentmappings')->pluck('assignmentgenerate_id')->toArray();
// Define a function to extract digits from a string
function extractDigits($string)
{
  preg_match_all('/\d+/', $string, $matches);
  return implode('', $matches[0]);
}

// Extract digits from each assignment number and store them in a new array
$assignmentNumbersDigits = array_map(function ($assignmentNumber) {
  return extractDigits($assignmentNumber);
}, $existingAssignmentNumbers);
//!

$minAssignmentNumber = 100001;
$maxAssignmentNumber = 100512;

// Generate an array of all possible assignment numbers within the range
$allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
// Find the missing assignment numbers
$missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $assignmentNumbersDigits);
dd($missingAssignmentNumbers);
// Start Hare 

//* regarding value function
// Start Hare 
$gettotalteamhour = DB::table('assignmentmappings')
->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
->value('teamhour');

$gettotalteamhour = DB::table('assignmentmappings')
->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
->first()->teamhour;

// Start Hare 

//* regarding forcefully submit
// Start Hare 

if ($request->leavingdate != null) {
  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->orderBy('date', 'ASC')
      ->get();

  // Chunk the $timesheetsave data for one week
  $weeksData = $timesheetsave->chunk(6);

  foreach ($weeksData as $weekData) {
      foreach ($weekData as $timesheet) {
          $startdate = Carbon::parse($timesheet->date);
          $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

          $startdateformat = $startdate->format('Y-m-d');
          $nextSaturdayformat = $nextSaturday->format('Y-m-d');

          // $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));
          DB::table('timesheetusers')
              ->where('timesheetid', $timesheet->timesheetid)
              ->update([
                  'status' => 1,
                  'updated_at' => now(),
              ]);

          DB::table('timesheets')
              ->where('id', $timesheet->timesheetid)
              ->update([
                  'status' => 1,
                  'updated_at' => now(),
              ]);
      }

      // Insert data into the timesheetreport table for the current week
      $startdate = Carbon::parse($weekData->first()->date);
      $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

      $startdateformat = $startdate->format('Y-m-d');
      $nextSaturdayformat = $nextSaturday->format('Y-m-d');

      $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

      $co = DB::table('timesheetusers')
          ->where('createdby', $id)
          ->whereBetween('date', [$startdateformat, $nextSaturdayformat])
          ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
          ->groupBy('partner')
          ->get();
      // dd($co);

      foreach ($co as $codata) {
          DB::table('timesheetreport')->insert([
              'teamid'       =>     $id,
              'week'       =>     $week,
              'totaldays'       =>     $codata->row_count,
              'totaltime' =>  $codata->total_hours,
              'partnerid'  => $codata->partner,
              'startdate'  => $startdateformat,
              'enddate'  => $nextSaturdayformat,
              'created_at'                =>      date('y-m-d H:i:s'),
          ]);
      }
  }
}
if ($request->leavingdate != null) {
  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->orderBy('date', 'ASC')
      ->get();

  $currentWeek = [];
  foreach ($timesheetsave as $timesheet) {
      $startdate = Carbon::parse($timesheet->date);
      $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

      $currentWeek[] = $timesheet;

      // If the current date reaches Saturday or the end of data, process the current week
      if ($startdate->isSaturday() || $timesheet === $timesheetsave->last()) {
          $weekStart = $currentWeek[0]->date;
          $weekEnd = $currentWeek[count($currentWeek) - 1]->date;

          // Update statuses for timesheetusers and timesheets for the current week
          foreach ($currentWeek as $weekTimesheet) {
              DB::table('timesheetusers')
                  ->where('timesheetid', $weekTimesheet->timesheetid)
                  ->update([
                      'status' => 1,
                      'updated_at' => now(),
                  ]);

              DB::table('timesheets')
                  ->where('id', $weekTimesheet->timesheetid)
                  ->update([
                      'status' => 1,
                      'updated_at' => now(),
                  ]);
          }

          // Insert data into the timesheetreport table for the current week
          $co = DB::table('timesheetusers')
              ->where('createdby', $id)
              ->whereBetween('date', [$weekStart, $weekEnd])
              ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
              ->groupBy('partner')
              ->get();

          $week = date('d-m-Y', strtotime($weekStart)) . ' to ' . date('d-m-Y', strtotime($weekEnd));

          foreach ($co as $codata) {
              DB::table('timesheetreport')->insert([
                  'teamid' => 444,
                  'week' => $week,
                  'totaldays' => $codata->row_count,
                  'totaltime' => $codata->total_hours,
                  'partnerid' => $codata->partner,
                  'startdate' => $weekStart,
                  'enddate' => $weekEnd,
                  'created_at' => now(),
              ]);
          }

          // Reset the current week array for the next week
          $currentWeek = [];
      }
  }
}

// temrary
if ($request->leavingdate != null) {
  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->orderBy('date', 'ASC')
      ->get();

  // Chunk the $timesheetsave collection into arrays containing data for one week
  $weeksData = $timesheetsave->chunk(6); // Assuming each week has 6 data points

  foreach ($weeksData as $weekData) {
      foreach ($weekData as $timesheet) {
          $startdate = Carbon::parse($timesheet->date);
          $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

          $startdateformat = $startdate->format('Y-m-d');
          $nextSaturdayformat = $nextSaturday->format('Y-m-d');

          $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

          // Reset total counts for each week
          $totalDays = 0;
          $totalHours = 0;

          // Calculate total days and hours for the current week
          foreach ($weekData as $weekTimesheet) {
              $totalDays++;
              $totalHours += $weekTimesheet->hour;
          }

          // Insert data into the timesheetreport table for the current week
          DB::table('timesheetreport')->insert([
              'teamid'       =>     222,
              'week'       =>     $week,
              'totaldays'       =>     $totalDays,
              'totaltime' =>  $totalHours,
              'partnerid'  => $timesheet->partner,
              'startdate'  => $startdateformat,
              'enddate'  => $nextSaturdayformat,
              'created_at'                =>      now(),
          ]);

          // Update status for timesheetusers and timesheets for the current week
          DB::table('timesheetusers')
              ->where('timesheetid', $timesheet->timesheetid)
              ->update([
                  'status' => 1,
                  'updated_at' => now(),
              ]);

          DB::table('timesheets')
              ->where('id', $timesheet->timesheetid)
              ->update([
                  'status' => 1,
                  'updated_at' => now(),
              ]);
      }
      DB::table('timesheetreport')->insert([
          'teamid'       =>     222,
          'created_at'                =>      now(),
      ]);
  }
}

if ($request->leavingdate != null) {
  $leavingdate = Carbon::parse($request->leavingdate);
  $previousSunday = $leavingdate->copy()->previous(Carbon::MONDAY);
  $nextSunday = $leavingdate->copy()->next(Carbon::SUNDAY);
  $nextSturday = $leavingdate->copy()->next(Carbon::SATURDAY);

  $previousSundayformate = $previousSunday->format('Y-m-d');
  $nextSundayformate = $nextSunday->format('Y-m-d');
  $nextSturdayformate = $nextSturday->format('Y-m-d');

  $timesheetsave = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->where('status', 0)
      ->whereBetween('date', [$previousSundayformate, $nextSundayformate])
      ->orderBy('date', 'ASC')
      ->get();

  $retrievedDates = [];
  foreach ($timesheetsave as $entry) {
      $date = new DateTime($entry->date);
      $retrievedDates[] = $date->format('Y-m-d');
  }

  $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday
  while ($previousSunday->format('Y-m-d') < $nextSunday->format('Y-m-d')) {  //excluding sunday
      $expectedDates[] = $previousSunday->format('Y-m-d');
      // Increase 1 date 
      $previousSunday->modify("+1 day");
  }

  $missingDates = array_diff($expectedDates, $retrievedDates);
  if (!empty($missingDates)) {
      foreach ($timesheetsave as $getsixdata) {
          $week =  date('d-m-Y', strtotime($previousSundayformate))  . ' to ' . date('d-m-Y', strtotime($nextSturdayformate));

          $co = DB::table('timesheetusers')
              ->where('createdby', $id)
              ->whereBetween('date', [$previousSundayformate, $nextSturdayformate])
              ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
              ->groupBy('partner')
              ->get();

          foreach ($co as $codata) {
              DB::table('timesheetreport')->insert([
                  'teamid'       =>     $id,
                  'week'       =>     $week,
                  'totaldays'       =>     $codata->row_count,
                  'totaltime' =>  $codata->total_hours,
                  'partnerid'  => $codata->partner,
                  'startdate'  => $previousSundayformate,
                  'enddate'  => $nextSturdayformate,
                  'created_at'                =>      date('y-m-d H:i:s'),
              ]);
          }
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
  dd($retrievedDates);
}

   // 22222222222222222222222222222222222222222

        // // Start Hare 
        // $nextweektimesheet1 = DB::table('timesheetusers')
        //     ->where('createdby', 847)
        //     ->whereBetween('date', ['2024-02-26', '2024-03-16'])
        //     // ->get();
        //     ->update(['status' => 0]);


        // $nextweektimesheet2 = DB::table('timesheets')
        //     ->where('created_by', 847)
        //     ->whereBetween('date', ['2024-02-26', '2024-03-16'])
        //     // ->get();
        //     ->update(['status' => 0]);

        // $nextweektimesheet = DB::table('timesheetreport')
        //     ->where('teamid', 847)
        //     ->whereDate('created_at', '2024-04-09')
        //     // ->get();
        //     ->delete();

        // dd($nextweektimesheet1);

// Start Hare 
//* regarding increament and decreament
// Start Hare 
foreach ($weeksData as $weekData) {

  // Reset total counts for each week
  $totalDays = 0;
  $totalHours = 0;

  foreach ($weekData as $timesheet) {
      $startdate = Carbon::parse($timesheet->date);
      $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

      $startdateformat = $startdate->format('Y-m-d');
      $nextSaturdayformat = $nextSaturday->format('Y-m-d');

      $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

      $totalDays++;
      $totalHours += $timesheet->hour;

      // Update status for timesheetusers and timesheets for the current week
      DB::table('timesheetusers')
          ->where('timesheetid', $timesheet->timesheetid)
          ->update([
              'status' => 1,
              'updated_at' => now(),
          ]);

      DB::table('timesheets')
          ->where('id', $timesheet->timesheetid)
          ->update([
              'status' => 1,
              'updated_at' => now(),
          ]);
  }

  // Insert data into the timesheetreport table for the current week
  $startdate = Carbon::parse($weekData->first()->date);
  $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);

  $startdateformat = $startdate->format('Y-m-d');
  $nextSaturdayformat = $nextSaturday->format('Y-m-d');

  $week = date('d-m-Y', strtotime($startdateformat)) . ' to ' . date('d-m-Y', strtotime($nextSaturdayformat));

  $co = DB::table('timesheetusers')
      ->where('createdby', $id)
      ->whereBetween('date', [$startdateformat, $nextSaturdayformat])
      ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
      ->groupBy('partner')
      ->get();
  // dd($co);

  foreach ($co as $codata) {
      DB::table('timesheetreport')->insert([
          'teamid'       =>     $id,
          'week'       =>     $week,
          'totaldays'       =>     $codata->row_count,
          'totaltime' =>  $codata->total_hours,
          'partnerid'  => $codata->partner,
          'startdate'  => $startdateformat,
          'enddate'  => $nextSaturdayformat,
          'created_at'                =>      date('y-m-d H:i:s'),
      ]);
  }
}
// Start Hare 
//* regarding off function / regarding excell download / regarding double download  
// Start Hare 
// Start Hare 
  // Function to handle employee change
  function handleEmployeeChange() {
    var endperiod1 = $('#endperiod1').val();
    var startperiod1 = $('#startperiod1').val();
    var employee1 = $('#employee1').val();
    var leave1 = $('#leave1').val();
    var status1 = $('#status1').val();
    var end1 = $('#end1').val();
    var start1 = $('#start1').val();
    $('#clickExcell').hide();

    $.ajax({
        type: 'GET',
        url: '/filtering-applyleve',
        data: {
            end: end1,
            start: start1,
            startperiod: startperiod1,
            endperiod: endperiod1,
            status: status1,
            employee: employee1,
            leave: leave1
        },
        success: function(data) {
            renderTableRows(data);
            $('.paging_simple_numbers').remove();
            $('.dataTables_info').remove();
            // Remove previus attachment on download button 
            $('#clickExcell').off('click');
            if (data.length > 0) {
                $('#clickExcell').on('click', function() {
                    exportToExcel(data);
                });
            }
            $('#clickExcell').show();
        }
    });
}
//* regarding convert / regarding int value 
// Start Hare 
$statusdata = intval($request->input('status'));
      $sql = $query->toSql(); // Convert the query to SQL
      dd($sql); // Dump and die to see the generated SQL
// Start Hare 
//* regarding select box error 
// Start Hare 
dd($request);
$requestData = $request->all();

// Check if "Please Select One" is submitted for teammember_id or type
if (in_array('Please Select One', $requestData['teammember_id']) || in_array('Please Select One', $requestData['type'])) {
    dd($request);
    return redirect()->back()->withErrors('Please select valid options for team member and type.');
}

// <div class="row row-sm">
// <div class="col-6">
//     <div class="form-group">
//         <label class="font-weight-600">Name *</label>
//         <select required class="language form-control" id="key" name="teammember_id[]">

//             <option value="">Please Select One</option>
//             @foreach ($teammember as $teammemberData)
//                 <option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
//                     {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
//                     {{ $teammemberData->staffcode }} )</option>
//             @endforeach
//         </select>
//     </div>
// </div>
// <div class="col-5">
//     <div class="form-group">
//         <label class="font-weight-600">Type *</label>
//         <select required class="form-control key" id="key" name="type[]">

//             <option value="">Please Select One</option>
//             <option value="0">Team Leader</option>
//             <option value="2">Staff</option>
//         </select>
//     </div>
// </div>

// <div class="col-1">
//     <div class="form-group" style="margin-top: 36px;">
//         <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
//                 src="{{ url('backEnd/image/add-icon.png') }}" /></a>
//     </div>
// </div>
// </div>

// Start Hare 
//* regarding is()
// Start Hare 
// 1. Check if a Variable Matches a Value:
$value = 'example';
if ($value->is('example')) {
    // Do something if $value is 'example'
}

// 2. Check if a Route Matches a Name:
if (Route::currentRouteName()->is('home')) {
    // Do something if current route is named 'home'
}

// 3. Check if a Route Matches a Pattern:
if (Request::is('admin/*')) {
    // Do something if current URL matches 'admin/*' pattern
}

// 4. Check if a Request Matches a Method:
if (Request::isMethod('post')) {
    // Do something if current request method is POST
}

// 5. Check if a Collection Matches a Condition:
$collection = collect([1, 2, 3, 4, 5]);
if ($collection->isNotEmpty() && $collection->is(function ($item) {
    return $item > 3;
})) {
    // Do something if collection is not empty and all items are greater than 3
}

// 6. Check if a String Matches a Pattern:
$string = 'Hello, World!';
if (Str::of($string)->is('*World*')) {
    // Do something if $string contains 'World'
}

// Start Hare 
//* regarding Carbon / egarding days / regarding date 2 / regarding CarbonPeriod / regarding CarbonPeriod / regarding CarbonPeriod / regarding sutarday 
// Start Hare 
<?php

use Carbon\Carbon;
use Illuminate\Http\Request;


$date1->equalTo($date2);
$date1->notEqualTo($date2);
$date1->greaterThan($date2);
$date1->greaterThanOrEqualTo($date2);
$date1->lessThan($date2);
$date1->lessThanOrEqualTo($date2);
$date->between($start, $end);
$date->isToday();
$date->isTomorrow();
$date->isYesterday();
$date->isFuture();
$date->isPast();
$date->isWeekend();
$date->isWeekday();
$date->isSameDay($from)

if ($latesttimesheetsubmittedformate && ($latesttimesheetsubmittedformate->greaterThan($from) || $latesttimesheetsubmittedformate->equalTo($from))) {}
// <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
// {{ date('H:i A', strtotime($udinData->created)) }}</td>
// <td>{{ $udinData->udindate ? date('d-m-Y', strtotime($udinData->udindate)) : 'NA' }}</td>
    $from = Carbon::createFromFormat('Y-m-d', $request->from);
    $to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

    // Check if dates are equal and the day is Sunday
    if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
        $output = ['msg' => 'You cannot apply leave for Sunday'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the future
    if ($from->isFuture()) {
        $output = ['msg' => 'The start date cannot be in the future'];
        return back()->with('statuss', $output);
    }

    // Check if the end date is in the past
    if ($to->isPast()) {
        $output = ['msg' => 'The end date cannot be in the past'];
        return back()->with('statuss', $output);
    }

    // Check if the date range includes a weekend
    if ($from->between($from->copy()->next(Carbon::SATURDAY), $from->copy()->next(Carbon::SUNDAY))) {
        $output = ['msg' => 'The leave period includes a weekend'];
        return back()->with('statuss', $output);
    }

    // Check if dates are not equal
    if ($from->notEqualTo($to)) {
        $output = ['msg' => 'The start and end dates are not the same'];
        return back()->with('statuss', $output);
    }

    // Additional date comparisons

    // Check if the start date is greater than the end date
    if ($from->greaterThan($to)) {
        $output = ['msg' => 'The start date cannot be greater than the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is less than the end date
    if ($from->lessThan($to)) {
        $output = ['msg' => 'The start date is less than the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is greater than or equal to the end date
    if ($from->greaterThanOrEqualTo($to)) {
        $output = ['msg' => 'The start date is greater than or equal to the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is less than or equal to the end date
    if ($from->lessThanOrEqualTo($to)) {
        $output = ['msg' => 'The start date is less than or equal to the end date'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is today
    if ($from->isToday()) {
        $output = ['msg' => 'The start date is today'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is tomorrow
    if ($from->isTomorrow()) {
        $output = ['msg' => 'The start date is tomorrow'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is yesterday
    if ($from->isYesterday()) {
        $output = ['msg' => 'The start date is yesterday'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the future
    if ($from->isFuture()) {
        $output = ['msg' => 'The start date is in the future'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is in the past
    if ($from->isPast()) {
        $output = ['msg' => 'The start date is in the past'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is a weekend
    if ($from->isWeekend()) {
        $output = ['msg' => 'The start date is a weekend'];
        return back()->with('statuss', $output);
    }

    // Check if the start date is a weekday
    if ($from->isWeekday()) {
        $output = ['msg' => 'The start date is a weekday'];
        return back()->with('statuss', $output);
    }

    if ($autosubmitdate->isSameDay($todaydate)) {
      dd('hi date');
  }

    // Default message if no conditions are met
    $output = ['msg' => 'Dates are valid'];
    return back()->with('statuss', $output);


// Start Hare 

$selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

if ($selectedDate1->format('l') == 'Saturday') {
    $dayOfMonth = $selectedDate1->format('j');
    $saturdayNumber = ceil($dayOfMonth / 7);

    // Define the client IDs for each Saturday number
    $clientIdsBySaturday = [
        1 => [29, 32, 34],
        2 => [29, 32, 33, 34],
        3 => [29, 32, 34],
        4 => [29, 32, 33, 34],
        5 => [29, 32, 34]
    ];

    // Default to the second role's client IDs
    $clientIds = $clientIdsBySaturday[$saturdayNumber] ?? [];

    // If the user role is 13 and it's the 2nd or 4th Saturday, include extra clients
    if (auth()->user()->role_id != 13) {
        $clientIds = [29, 32, 33, 34];
    }

    $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

    $client = $clientss->merge($clients);
// Start Hare 
  $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {

            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            if ($saturdayNumber == 1.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 2.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 3.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 4.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 33, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            } elseif ($saturdayNumber == 5.0) {
              $clients = DB::table('clients')
                ->whereIn('id', [29, 32, 34])
                ->select('clients.client_name', 'clients.id', 'clients.client_code')
                ->orderBy('client_name', 'ASC')
                ->distinct()->get();
            }
          } else {
            $clients = DB::table('clients')
              ->whereIn('id', [29, 32, 34])
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
          }

// Start Hare 
          $dayOfWeek = $selectedDate1->format('w');
          if ($selectedDate1->format('l') == 'Saturday') {

            $dayOfMonth = $selectedDate1->format('j');
            // Calculate which Saturday of the month it is
            $saturdayNumber = ceil($dayOfMonth / 7);
            if ($saturdayNumber == 1.0) {
              $clientIds = [29, 32, 34];
            } elseif ($saturdayNumber == 2.0) {
              $clientIds = [29, 32, 33, 34];
            } elseif ($saturdayNumber == 3.0) {
              $clientIds = [29, 32, 34];
            } elseif ($saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } elseif ($saturdayNumber == 5.0) {
              $clientIds = [29, 32, 34];
            }
          } else {
            $clientIds = [29, 32, 34];
          }

          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);
// Start Hare 
// Start Hare 
$selectedDate = \DateTime::createFromFormat('d-m-Y', '25-06-2024');

$clientIds = ($selectedDate->format('l') == 'Friday') ? [29, 32, 33, 34] : [29, 32, 34];
$clients = DB::table('clients')
    ->whereIn('id', $clientIds)
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()
    ->get();

dd($clients); // Dump the clients data for debugging

// Start Hare 
$selectedDate = \DateTime::createFromFormat('d-m-Y', '25-06-2024');

if ($selectedDate->format('l') == 'Friday') {
  $clients = DB::table('clients')
    ->whereIn('id', [29, 32, 33, 34])
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()->get();
} else {
  $clients = DB::table('clients')
    ->whereIn('id', [29, 32, 34])
    ->select('clients.client_name', 'clients.id', 'clients.client_code')
    ->orderBy('client_name', 'ASC')
    ->distinct()->get();
}
dd($clients);
// dd($selectedDate->format('l'));
// Tuesday
// Start Hare regarding same date / regarding equal date  
$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}

// 1. Create a Carbon Instance with Current Date and Time:
$now = Carbon::now();
$now = new \DateTime();

$currentdate = Carbon::now()->startOfDay();
$currentDate = Carbon::now()->format('d-m-Y');

// 2. Create a Carbon Instance with Specific Date and Time:
$date = Carbon::create(2022, 4, 15, 13, 30, 0);

// 3. Format a Carbon Instance:
$formattedDate = $date->format('Y-m-d H:i:s');

// 4. Add Days to a Carbon Instance:
$futureDate = $date->addDays(7);

// 5. Subtract Days from a Carbon Instance:
$pastDate = $date->subDays(7);

// 6. Get Difference in Days between Two Carbon Instances:
$difference = $date1->diffInDays($date2);

// 7. Check if a Date is Before Another Date:
if ($date1->lt($date2)) {
    // $date1 is before $date2
}

// 8. Check if a Date is After Another Date:
if ($date1->gt($date2)) {
    // $date1 is after $date2
}

// 9. Get Day of the Week of a Date:
$dayOfWeek = $date->dayOfWeek;

// 10. Get Month of a Date:
$month = $date->month;

// 11. Check if a Date is Today:
if ($date->isToday()) {
    // $date is today
}

// 12. Check if a Date is in the Future:
if ($date->isFuture()) {
    // $date is in the future
}


// check time / regarding time 
 if (now()->format('H:i') === '18:00') {
}
// regarding CarbonPeriod
// 1. Create a Period for a Range of Dates:
  $period = CarbonPeriod::create('2022-01-01', '2022-01-10');

  // 2. Create a Period with Interval:
  $period = CarbonPeriod::create('2022-01-01', '1 day', '2022-01-10');
  
  // 3. Iterate Over a Period:
  foreach ($period as $date) {
      echo $date->format('Y-m-d') . "\n";
  }
  
  // 4. Check if a Date is Within the Period:
  $date = Carbon::parse('2022-01-05');
  if ($period->contains($date)) {
      echo "Date is within the period\n";
  }
  
  // 5. Filter Period by Closure:
  $filteredPeriod = $period->filter(function ($date) {
      return $date->dayOfWeek !== Carbon::SUNDAY;
  });
  
  // 6. Get Number of Days in the Period:
  $numberOfDays = $period->count();
  
  // 7. Get Start and End Dates of the Period:
  $startDate = $period->getStartDate();
  $endDate = $period->getEndDate();
  
  // 8. Get All Dates in the Period as an Array:
  $datesArray = $period->toArray();
  
  // 9. Get Period as JSON:
  $periodJson = json_encode($period);
  

  // regarding DateTime
  // 1. Get Current Date and Time:
$currentDateTime = new DateTime();

// 2. Create a DateTime Object from a Specific Date:
$specificDate = new DateTime('2022-04-15');

// 3. Create a DateTime Object from a Specific Date and Time:
$specificDateTime = new DateTime('2022-04-15 13:30:00');

// 4. Format a DateTime Object:
$formattedDateTime = $specificDateTime->format('Y-m-d H:i:s');

// 5. Add Days to a DateTime Object:
$specificDateTime->modify('+7 days');

// 6. Subtract Days from a DateTime Object:
$specificDateTime->modify('-7 days');

// 7. Get Difference in Days Between Two DateTime Objects:
$difference = $specificDateTime1->diff($specificDateTime2)->days;

// 8. Check if a DateTime is Before Another DateTime:
if ($specificDateTime1 < $specificDateTime2) {
    // $specificDateTime1 is before $specificDateTime2
}

// 9. Check if a DateTime is After Another DateTime:
if ($specificDateTime1 > $specificDateTime2) {
    // $specificDateTime1 is after $specificDateTime2
}

// 10. Get Timestamp of a DateTime Object:
$timestamp = $specificDateTime->getTimestamp();


$from = Carbon::createFromFormat('Y-m-d', $request->from);
$to = Carbon::createFromFormat('Y-m-d', $request->to ?? '');

// Check if dates are equal and the day is Sunday
if ($from->equalTo($to) && $from->dayOfWeek === Carbon::SUNDAY) {
  $output = ['msg' => 'You cannot apply leave for Sunday'];
  return back()->with('statuss', $output);
}

// Check if the start date is in the future
if ($from->isFuture()) {
  $output = ['msg' => 'The start date cannot be in the future'];
  return back()->with('statuss', $output);
}

// Check if the end date is in the past
if ($to->isPast()) {
  $output = ['msg' => 'The end date cannot be in the past'];
  return back()->with('statuss', $output);
}

// Check if the date range includes a weekend
if ($from->between($from->copy()->next(Carbon::SATURDAY), $from->copy()->next(Carbon::SUNDAY))) {
  $output = ['msg' => 'The leave period includes a weekend'];
  return back()->with('statuss', $output);
}

// Check if dates are not equal
if ($from->notEqualTo($to)) {
  $output = ['msg' => 'The start and end dates are not the same'];
  return back()->with('statuss', $output);
}


// Start Hare 
//* regarding distinct / regarding get
// Start Hare 
// 1. Select Distinct Values of a Column:
DB::table('table_name')->distinct()->get('column_name');

// 2. Select Distinct Values of Multiple Columns:
DB::table('table_name')->distinct()->get(['column1', 'column2']);

// 3. Select Distinct Values Using Relationship:
DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->distinct()->get('users.name');

// 4. Select Distinct Values with Conditions:
DB::table('table_name')->where('column_name', 'value')->distinct()->get('column_name');

// 5. Select Distinct Values Using Subquery:
DB::table('posts')->whereIn('user_id', function ($query) {
    $query->from('users')->select('id')->distinct();
})->get();

// Start Hare 
//* regarding orderby
// Start Hare 
// 1. Order By Single Column Ascending:
DB::table('table_name')->orderBy('column_name')->get();

// 2. Order By Single Column Descending:
DB::table('table_name')->orderBy('column_name', 'desc')->get();

// 3. Order By Multiple Columns:
DB::table('table_name')->orderBy('column1', 'asc')->orderBy('column2', 'desc')->get();

// 4. Order By Raw Expression:
DB::table('table_name')->orderByRaw('FIELD(column_name, "value1", "value2", "value3")')->get();

// 5. Order By Relationship Column:
DB::table('posts')->join('users', 'posts.user_id', '=', 'users.id')->orderBy('users.name')->get();

// 6. Order By Null Values:
DB::table('table_name')->orderBy('column_name')->orderBy('column_name2', 'desc')->nullsFirst()->get();

// 7. Order By Using Subquery:
DB::table('posts')->orderBySub(function ($query) {
    $query->select('created_at')->from('comments')->whereColumn('comments.post_id', 'posts.id')->orderBy('created_at', 'desc')->limit(1);
})->get();

// Start Hare 
//* regarding select query  
// Start Hare 
// 1. Select All Columns:
DB::table('table_name')->select('*')->get();

// 2. Select Specific Columns:
DB::table('table_name')->select('column1', 'column2')->get();

// 3. Select With Aliases:
DB::table('table_name')->select('column1 as alias1', 'column2 as alias2')->get();

// 4. Select With Aggregate Functions:
DB::table('table_name')->select(DB::raw('COUNT(*) as count'))->get();

// 5. Select With Joins:
DB::table('table1')->select('table1.column1', 'table2.column2')->join('table2', 'table1.id', '=', 'table2.table1_id')->get();

// 6. Select Distinct Values:
DB::table('table_name')->select('column1')->distinct()->get();

// 7. Select With Conditions:
DB::table('table_name')->select('column1')->where('column2', '=', 'value')->get();

// 8. Select With Order By:
DB::table('table_name')->select('column1')->orderBy('column2', 'asc')->get();

// 9. Select With Limit and Offset:
DB::table('table_name')->select('column1')->offset(5)->limit(10)->get();

// 10. Select With Raw SQL:
DB::table('table_name')->select(DB::raw('COUNT(*) as count'))->get();

// Start Hare 
//* regarding return / regarding redirect
// Start Hare 

// 1. Redirect to a Route by Name:
return redirect()->route('route.name');

// 2. Redirect with Flash Data:
return redirect()->route('route.name')->with('key', 'value');

// 3. Redirect with Flash Data Using Arrays:
return redirect()->route('route.name')->with(['key1' => 'value1', 'key2' => 'value2']);

// 4. Redirect with Flash Data Using Chained Methods:
return redirect()->route('route.name')->with('key', 'value')->with('anotherKey', 'anotherValue');

// 5. Redirect with Validation Errors:
return redirect()->back()->withErrors($validator);

// 6. Redirect with Custom Status Code:
return redirect()->route('route.name')->status(404);

// 7. Redirect to External URL:
return redirect()->away('http://example.com');

// 8. Redirect to Named Route with Parameters:
return redirect()->route('route.name', ['param1' => 'value1', 'param2' => 'value2']);

use Illuminate\Support\Facades\Redirect;
return Redirect::route('users.show', ['user' => 1], 302)->withHeaders(['X-Framework' => 'Laravel']);

// Start Hare 
//* regarding insert query and upadte query
// Start Hare 

// ---------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ---------------------------------------------------------------------------------------------------------------------------
// |  1. insert(array $values)                                      | Inserts a record into the table with the given values.          |
// |  2. insertGetId(array $values)                                 | Inserts a record into the table and returns its ID.             |
// |  3. insertOrIgnore(array $values)                              | Inserts a record into the table, ignoring duplicates.           |
// |  4. insertUsing(array $columns, \Closure $query)               | Inserts records into the table using a subquery.                |
// |  5. insertGetIdOrIgnore(array $values)                         | Inserts a record into the table and returns its ID, ignoring duplicates.|
// |  6. update(array $values)                                      | Updates records in the table with the given values.             |
// |  7. updateOrInsert(array $attributes, array $values = [])      | Updates or inserts a record into the table based on the given attributes.|
// |  8. updateOrInsert(array $attributes, array $values = [], array $search = [])| Updates or inserts a record into the table based on the given attributes and search criteria.|
// ---------------------------------------------------------------------------------------------------------------------------

// 1. insert(array $values)
DB::table('users')->insert([
    ['name' => 'John', 'email' => 'john@example.com'],
    ['name' => 'Jane', 'email' => 'jane@example.com']
]);

// 2. insertGetId(array $values)
$id = DB::table('users')->insertGetId([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 3. insertOrIgnore(array $values)
DB::table('users')->insertOrIgnore([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 4. insertUsing(array $columns, \Closure $query)
DB::table('users')->insertUsing(['name', 'email'], function ($query) {
    $query->select('full_name', 'email')->from('other_users');
});

// 5. insertGetIdOrIgnore(array $values)
$id = DB::table('users')->insertGetIdOrIgnore([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// 6. update(array $values)
DB::table('users')
    ->where('id', 1)
    ->update(['name' => 'Updated Name']);

// 7. updateOrInsert(array $attributes, array $values = [])
DB::table('users')
    ->updateOrInsert(['email' => 'john@example.com'], ['name' => 'John']);

// 8. updateOrInsert(array $attributes, array $values = [], array $search = [])
DB::table('users')
    ->updateOrInsert(['email' => 'john@example.com'], ['name' => 'John'], ['name' => 'Jane']);

// Start Hare 
//* regarding mail 
// Start Hare 
// Start Hare 
// Start Hare 
$mailarray = [$data['email'], $data['secondaryemail']];
foreach ($mailarray as $email) {
    Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request, $email) {
        $msg->to($email);
        $msg->subject($data['subject']);
        if ($request->teammember_id) {
            $msg->cc($data['teammembermail']);
        }
        // Add CC for additional emails from the input field
        if ($request->ccmail) {
            $assignEmails = explode(',', $request->ccmail);
            foreach ($assignEmails as $email) {
                $msg->cc(trim($email));
            }
        }
    });
}
// Start Hare 
Mail::send('emails.assignmentdebtorform', $data, function ($msg) use ($data, $request) {
  $mailarray = array_filter([$data['email'], $data['secondaryemail'] ?? '']);
  if (!empty($mailarray)) {
      foreach ($mailarray as $email) {
          $msg->to($email);
      }
  }
  $msg->subject($data['subject']);
  if ($request->teammember_id) {
      $msg->cc($data['teammembermail']);
  }

  // Add CC for additional emails from the input field
  if ($request->ccmail) {
      $assignEmails = explode(',', $request->ccmail);
      foreach ($assignEmails as $email) {
          $msg->cc(trim($email));
      }
  }
});
// Start Hare 
// Start Hare 
Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  $msg->to($data['email']);
  $msg->cc('itsupport_delhi@vsa.co.in');
  $msg->subject('Timesheet Submission Request');
});
// Start Hare 
// if ($timesheetRequest->status == 0) {
//   $data = array(
//       'teammember' => $name ?? '',
//       'email' => $teammembermail ?? '',
//       'id' => $timesheetRequest->id ?? '',
//       'client_id' => $client_name ?? '',
//       'reason'     =>     $timesheetRequest->reason ?? '',
//   );
//   $url = URL::to('/timesheetrequestlist') ?? '';
//   $title = "timesheetrequestreminder";
//   $template = $this->getTemplateData($title);
//   // dd($template);  
//   $to = ($data['email']);
//   $cc = ($template['cc']);
//   $this->sendTicketEmail($to, $cc, $title, $data, $url);
// }
//* regarding sql
// Start Hare 
$query = DB::table('timesheetrequests')
->where('createdby', auth()->user()->teammember_id)
//->where('status', 1)
->latest()
->toSql();
//* regarding array access / regarding access
// Start Hare 
dd($assignments[0]->assignmentgenerate_id);
dd($assignments[0]->client_id);
dd($assignments[0]->assignment_id);
dd($assignments[0]->created_at);
dd($request->id);
// Start Hare 
$startdate = $weekData->first()->date;
$startdate = $weekData->last()->date;

$startdate = Carbon::parse($weekData->first()->date);
$startdate = Carbon::parse($weekData->last()->date);
$dataToProcess = $weekData->slice(1, -1);
// example
foreach ($weekData as $timesheet) {
  $startdate = Carbon::parse($timesheet->date);
  $nextSaturday = $startdate->copy()->next(Carbon::SATURDAY);
}
$startdate = Carbon::parse($weekData->first()->date);
// Start Hare 

//*regarding implode function 

 // $data = array(
                //     'assignmentid' =>  $assignmentgenerate,
                //     'clientname' =>  $clientname->client_name,
                //     'clientcode' =>  $clientname->client_code,
                //     'assignmentname' =>  $request->assignmentname,
                //     'assignment_name' =>  $assignment_name,
                //     'emailid' =>  $teammember->emailid,
                //     'otherpatner' =>  $teamemailotherpartner,
                //     'assignmentpartner' =>  $teamemailpartner,
                //     'teamleader' => $teamleader->map(function ($leader) {
                //         return $leader->team_member . ' (' . $leader->staffcode . ')';
                //     })->implode(', '),
                // );
                // dd($data);
//* regarding week days name / days name / regarding months name 
// Monday
// Tuesday
// Wednesday
// Thursday
// Friday
// Saturday
// Sunday

// January
// February
// March	
// April
// May	
// June
// July	
// August
// September	
// October
// November	
// December

//* regarding count function 
if (!empty($missingDates)) {
  $count1 = count($missingDates);
  $missingDatesexist =  DB::table('timesheetusers')
      // ->where('status', '0')
      ->whereIn('date', $missingDates)
      ->where('createdby', 847)
      ->orderBy('date', 'ASC')
      ->get();
  $count2 = $missingDatesexist->count();
  dd($count1, $count2);
}
//* regarding model
$createdby = Timesheetuser::distinct()->pluck('createdby')->toArray();

//* regarding command / regarding command

// make comand using comand 
// 1.php artisan make:command SubmittedExamleaveTimesheet

// show command list 
// 3.php artisan schedule:list

// show command list 
// 2.php artisan list

// test command in terminal 
// 4.php artisan command:submittedexamleaveTimesheet

//1. go to command file 
//2. go to kernel file and register command 
//3. go to web.php file and create route 
//4. go to  controller and define function 

class SubmittedExamleaveTimesheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:submittedexamleaveTimesheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Insert Successfully';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd('HI');
        // return 0;
    }
}


public function submittedexamleaveTimesheet()
{

  $exitCode = Artisan::call('command:submittedexamleaveTimesheet')->daily();

  return  redirect('/');
}





//*regarding ajax
//* regarding ajax / table heading replace 
// start hare 
  // start hare 
  // start hare 
  // start hare 
  // start hare 
  //? start hare 

  <script>
  $(function() {
      $('#client').on('change', function() {
          var cid = $(this).val();
          //   alert(cid);
          $.ajax({
              type: "get",
              url: "{{ url('timesheetreject/edit') }}",
              data: "cid=" + cid,
              success: function(res) {
                  $('#assignment').html(res);
              },
              error: function() {},
          });
      });
      $('#assignment').on('change', function() {
          var assignment = $(this).val();
          // alert(category_id);
          $.ajax({
              type: "get",
              // url: "{{ url('timesheet/create') }}",
              url: "{{ url('timesheetreject/edit') }}",
              data: "assignment=" + assignment,
              success: function(res) {
                  $('#partner').html(res);
              },
              error: function() {},
          });
      });
  });
</script>

  Route::get('/timesheetreject/edit/{id?}', [TimesheetController::class, 'timesheetEdit']);
  public function timesheetEdit(Request $request, $id = null)
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
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $clients = DB::table('clients')
        ->whereIn('id', [29, 32, 33, 34])
        ->select('clients.client_name', 'clients.id')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $client = $clientss->merge($clients);
    } else {
      $client = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->select('clients.client_name', 'clients.id')
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
  // start hare 
// app\Http\Controllers\TimesheetController.php    function create(Request $request)
// in same function me ajax call karna hai to 
  $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
  if ($request->ajax()) {
    if (isset($request->timesheetdate)) {
      echo "<option>Select client</option>";

      $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->whereNotIn('teammembers.team_member', ['NA'])
        ->where(function ($query) use ($selectedDate) {
          $query->whereNull('otpverifydate')
            ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        // ->distinct()->get();
        ->get();

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
    return view('backEnd.timesheet.create', compact('partner'));
  }
  // start hare 
  if ($request->ajax()) {
    $validatedData = $request->validate([
        'field' => 'required',
    ]);

    // Additional validation logic for AJAX requests
}
  // start hare 
  if ($request->ajax()) {
    return response()->json(['message' => 'This is an AJAX response']);
}



//* regarding old data / regarding flash 
$request->flash();
$request->flashOnly(['username', 'email']);
return redirect('form')->withInput();
 
return redirect()->route('user.create')->withInput();
 
return redirect('form')->withInput(
    $request->except('password')
);
$username = $request->old('username');
// <input type="text" name="username" value="{{ old('username') }}">
$value = $request->cookie('name');
$request->flashExcept('password');
$request->flash()->forget(['year', 'start_date', 'end_date']);
$request->session()->forget('_old_input');

$value = old('value');
 
$value = old('value', 'default');

{{ old('name', $user->name) }}
 
// Is equivalent to...
 
{{ old('name', $user) }}
return optional($user->address)->street;
 
{!! old('name', optional($user)->name) !!}
return optional(User::find($id), function (User $user) {
  return $user->name;
});
}
$file = $request->file('photo');
 
$file = $request->photo;

if ($request->hasFile('photo')) {
  // ...
}

if ($request->file('photo')->isValid()) {
  // ...
}

$path = $request->photo->path();
 
$extension = $request->photo->extension();
$path = $request->photo->store('images');
 
$path = $request->photo->store('images', 's3');
$path = $request->photo->storeAs('images', 'filename.jpg');
 
$path = $request->photo->storeAs('images', 'filename.jpg', 's3');
//* unique validation 

$request->validate([
  // 'client_id' => "required",
  'client_id' => 'required|unique:assignmentbudgetings,client_id',
  'assignment_id' => "required",
  'teammember_id.*' => "required",
  'assignmentname' => "required",
  'type.*' => "required"
]);

//* regarding date All condition 
// Start hare
// Start hare

// Start hare
foreach ($debtorsdatas as $debtorsdata) {

  // date compare with time 
  // $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at)->addDays(5);
  $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at);
  $currentdate = Carbon::now()->startOfDay();
  if ($nextfivedays == $currentdate) {
      dd('hi');
  }
  dd($nextfivedays);
  // date compare without time 
  $nextfivedays = Carbon::createFromFormat('Y-m-d H:i:s', $debtorsdata->updated_at);
  $currentdate = Carbon::now()->startOfDay();

  if ($nextfivedays->isSameDay($currentdate)) {
      dd('hi');
  }
}

// start hare
$todaydate = '2024-03-09';
$date = Carbon::createFromFormat('Y-m-d', $todaydate);
dd($date);

// start hare
if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {
  // if error is Not enough data available to satisfy format
}

// start hare
$autosubmitdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(9);
// $autosubmitdate = Carbon::createFromFormat('Y-m-d', '2024-02-26' ?? '')->addDays(11);
$todaydate = Carbon::now('Asia/Kolkata');

if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}

// start hare
$date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
$autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
$todaydate = Carbon::now('Asia/Kolkata');

if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}

// start hare
$autosubmitdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(9);
// $autosubmitdate = Carbon::createFromFormat('Y-m-d', '2024-02-26' ?? '')->addDays(11);
$todaydate = Carbon::now('Asia/Kolkata');
if ($autosubmitdate->isSameDay($todaydate)) {
    dd('hi date');
}
// Start hare
public function store(Request $request)
{
  // app\Http\Controllers\TimesheetController.php

      // Permission for Closed assignment
      $assignmentcloseddata = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[0])->first();
      $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);

      if ($assignmentcloseddata && $assignmentcloseddata->otpverifydate) {
        $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);
        if ($assignmentcloseddata->status == 0 && $assignmentcloseddate <= $requestDate) {
          $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[0] . " You can not fill timesheet to Assignment name : " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[0]];
          return redirect('timesheet/mylist')->with('statuss', $output);
        }
      }

      // dd('hi 3', $count);
      for ($i = 0; $i < $count; $i++) {

        $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

        // Permission for Closed assignment
        $assignmentcloseddata2 = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
        $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);
 
        if ($assignmentcloseddata2 && $assignmentcloseddata2->otpverifydate) {
          $assignmentcloseddate2 = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata2->otpverifydate)->setTime(23, 59, 59);
          if ($assignmentcloseddata->status == 0 && $assignmentcloseddate2 <= $requestDate) {
            $output = ['msg' => "This Assignment has closed : " . $request->assignment_id[$i] . " You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
            return redirect('timesheet/mylist')->with('statuss', $output);
          }
        }
      }
    } 
}

// Start hare  this is date testing / regarding testing
$selectedDate = \DateTime::createFromFormat('d-m-Y', '05-03-2024');
dd($selectedDate);


// Start hare  compare two difrent date formate like otpverifydate= 2024-02-20 12:38:56   $request->datepickers = 2024-02-20
$requestDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

$var = DB::table('assignmentbudgetings')
  ->where('client_id', $request->cid)
  ->where(function ($query) use ($requestDate) {
    $query->whereNull('otpverifydate')
          // // ->orWhere('otpverifydate', '<=', $requestDate->modify('+1 day'));
          // ->orWhere('otpverifydate', '>=', $requestDate->modify('-1 day'));
      ->orWhere('otpverifydate', '>', $requestDate);
  })
  ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  ->orderBy('assignment_name')
  ->get();

dd($var);

// Start hare  increase 1 date and decrease 1 date from date 
$requestDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

$var = DB::table('assignmentbudgetings')
  ->where('client_id', $request->cid)
  ->where(function ($query) use ($requestDate) {
    $query->whereNull('otpverifydate')
      // ->orWhere('otpverifydate', '<=', $requestDate->modify('+1 day'));
      ->orWhere('otpverifydate', '>=', $requestDate->modify('-1 day'));
  })
  ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
  ->orderBy('assignment_name')
  ->get();


// Start hare
$period = CarbonPeriod::create($team->from, $team->to);
dd($period);
$datess = [];
foreach ($period as $date) {
  $datess[] = $date->format('Y-m-d');

  DB::table('timesheets')->where('date', $date->format('Y-m-d'))
    ->where('created_by', $team->createdby)->delete();
  DB::table('timesheetusers')->where('createdby', $team->createdby)
    ->where('date', $date->format('Y-m-d'))->delete();
}

// Start hare
$defaulttimesheetshowdate = DB::table('timesheetusers')
->where('timesheetusers.createdby', $teamid)
->whereIn('timesheetusers.status', [1, 2, 3])
->orderBy('date', 'DESC')
->first();
if ($defaulttimesheetshowdate) {
$to = $defaulttimesheetshowdate->date;
$fromformate = Carbon::createFromFormat('Y-m-d', $to);
// Subtract 6 days
$from = $fromformate->subDays(6)->toDateString();
}


//* regarding dd 
dd('hi2', $request);
dd($checkopenorclosed->status, $assignmentcloseddate, $requestDate);

$updatedcamedate = $camefromexam->copy()->format('Y-m-d');
dd('hi2', $updatedcamedate);
dd($value);
dd($value1, $value2, $value3, ...);

dd([
  'data' => $pormotionandrejoiningdata,
  'joining_date' => $joining_date,
  'rejoining_date' => $rejoining_date
]);
// knowlege base modification  
//* regarding otp
public function assignmentotpstore(Request $request)
{
  dd($request);
  $request->validate([
    'otp' => 'required'
  ]);

  try {
    $data = $request->except(['_token']);

    $otp = DB::table('assignmentbudgetings')
      ->where('otp', $request->otp)
      ->where('assignmentgenerate_id', $request->assignmentgenerateid)->first();
    if ($otp) {

      DB::table('assignmentbudgetings')
        ->where('assignmentgenerate_id', $request->assignmentgenerateid)->update([
          'status' => '0',
          'closedby'  => auth()->user()->teammember_id,
          'otpverifydate' => date('Y-m-d H:i:s')
        ]);
      $output = array('msg' => 'assignment closed successfully');
      return back()->with('success', $output);
    } else {
      $output = array('msg' => 'otp did not match! Please enter valid otp');
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
//*  regarding function / function call 

// Start hare
public function store(Request $request)
{

    // dd($id);
    if ($request->teammember_id != '0') {
        $count = count($request->teammember_id);
        // dd($request->assignment_id);
        $clientname = Client::where('id', $request->client_id)->select('client_name')->first();

        $assignmentpartner = Teammember::where('id', $request->leadpartner)->select('team_member')->first();

        // $teamleader =    DB::table('assignmentmappings')
        //     ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
        //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        //     ->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerate)
        //     ->where('assignmentteammappings.type', '0')
        //     ->select('teammembers.team_member')
        //     ->get();

        $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
        // dd($teamemail);

        foreach ($teamemail as $teammember) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teammember->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }

        $teamemailpartner = DB::table('teammembers')->where('id', $request->leadpartner)->select('emailid')->first();
        // dd($teamemailpartner);
        if ($request->leadpartner !=  null) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teamemailpartner->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }
        $teamemailotherpartner = DB::table('teammembers')->where('id', $request->otherpartner)->select('emailid')->first();
        if ($request->otherpartner !=  null) {
            $data = array(
                'assignmentid' =>  $assignmentgenerate,
                'clientname' =>  $clientname->client_name,
                'assignmentname' =>  $request->assignmentname,
                'assignment_name' =>  $assignment_name,
                'emailid' =>  $teamemailotherpartner->emailid,
                'assignmentpartner' =>  $assignmentpartner->team_member,
                // 'teamleader' =>  $teamleader,

            );

            // Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            //     $msg->to($data['emailid']);
            //     $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
            // });
            $this->sendAssignmentEmail($data);
        }
    }

}

public function sendAssignmentEmail($data)
{
    Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
        $msg->to($data['emailid']);
        $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
    });
}

// Start hare
public function pendingmail($id)
{
    try {
        $debtor = Debtor::findOrFail($id);

        $mailData = Template::where('type', $debtor->type)->firstOrFail();
        $description = $this->replacePlaceholders($mailData->description, $debtor);

        $data = [
            'name' => $debtor->name,
            'email' => $debtor->email,
            'year' => $debtor->year,
            'date' => $debtor->date,
            'amount' => $debtor->amount,
            'clientid' => $debtor->assignmentgenerate_id,
            'debtorid' => $debtor->id,
            'description' => $description,
            'yes' => 1,
            'no' => 0
        ];

        $this->sendEmail($data);

        return back()->with('success', 'Mail sent successfully');
    } catch (\Exception $e) {
        Log::error("Error sending email: " . $e->getMessage());
        return back()->withErrors(['msg' => 'Failed to send email'])->withInput();
    }
}

private function replacePlaceholders($description, $debtor)
{
    $placeholders = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    $values = [$debtor->name, $debtor->amount, $debtor->year, $debtor->date, $debtor->address];

    return str_replace($placeholders, $values, $description);
}

private function sendEmail($data)
{
    Mail::send('emails.debtorform', $data, function ($message) use ($data) {
        $message->to($data['email'])->subject('Regarding Pending Confirmation');
    });
}
// Start hare
public function pendingmail($id)
{
    // dd($id);
    try {
        $usermail = DB::table('debtors')->where('id', $id)->first();

        // Get mail for Debitor
        if ($usermail->type == 1) {
            // dd('debitor');
            $this->sendEmail($usermail);
        }
        // Get mail for crediter
        elseif ($usermail->type == 2) {
            // dd('crediter');
            $this->sendEmail($usermail);
        }
        // Get mail for bank
        else {
            // dd('bank');
            $this->sendEmail($usermail);
        }
        dd('hi4');
        $output = array('msg' => 'Mail Send Successfully');
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

public function sendEmail($usermail)
{
    $maildata = DB::table('templates')->where('type', $usermail->type)->first();

    $des = $maildata->description;
    $healthy = ["[name]", "[amount]", "[year]", "[date]", "[address]"];
    $yummy   = ["$usermail->name", "$usermail->amount", "$usermail->year", "$usermail->date", "$usermail->address"];
    $description = str_replace($healthy, $yummy, $des);


    $data = array(
        'name' =>  $usermail->name,
        'email' =>  $usermail->email,
        'year' =>  $usermail->year,
        'date' =>  $usermail->date,
        'amount' =>  $usermail->amount,
        'clientid' => $usermail->assignmentgenerate_id,
        'debtorid' => $usermail->id,
        'description' => $description,
        'yes' => 1,
        'no' => 0
    );
    Mail::send('emails.debtorform', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        $msg->subject('Regarding Pending Confirmation');
    });
}
// Start hare



//* regarding url / regarding route /  regarding path
public function filterDataAdmin(Request $request)
{
  $urlheader = $request->headers->get('referer');
  $url = parse_url($urlheader);
  $path = $url['path'];
  // dd($url);
  // this is for patner submitted timesheet 
  if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
    // dd($url);
  }
  // this is for team submitted timesheet on patner
  elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
      // dd($url);
  }
  // this is for submitted timesheet on staff and manager 
  elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
    
  }
  // this is for team submitted timesheet on Admin
  else {
    
  }
}
// Start hare
use Illuminate\Support\Facades\URL;
echo URL::current();
// Start hare
$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));
// Start hare
// Store the current URL in the session
session(['previous_url' => url()->current()]);
// Later, when you need to retrieve the previous URL path
$previousUrl = session('previous_url', '/');
$uri = parse_url($previousUrl, PHP_URL_PATH);
dd($uri);
// Start hare
$uri = request()->headers->get('referer');
$path = parse_url($uri, PHP_URL_PATH);
dd($path);

$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));

if ($uri == '/assignmentlist') {
  $output = array('msg' => 'staff is already in team');
  return back()->with('success', $output);
} else {
  $output = array('msg' => 'staff is already in team');
  return back()->with('success', $output);
}

// Start hare
$previous = url()->previous();
$fulluri = parse_url($previous, PHP_URL_PATH);
$uri = substr($fulluri, 0, strrpos($fulluri, '/'));
dd($uri);
// Start hare
$current = url()->current();
$full = url()->full();
$previous = url()->previous();
$uri = $request->path();
// "mytimesheetlist/844"
$url = $request->url();
// Start hare
// "http://127.0.0.1:8000/mytimesheetlist/844"

$urlWithQueryString = $request->fullUrl();
    $request->fullUrlWithQuery(['type' => 'phone']);
    $request->fullUrlWithoutQuery(['type']);
$request->fullUrlWithoutQuery(['/mytimesheetlist/844']);

// "http://127.0.0.1:8000/mytimesheetlist/844"
$host = $request->getHost();
// "127.0.0.1"
$schemeAndHttpHost = $request->getSchemeAndHttpHost();
// "http://127.0.0.1:8000"
$method = $request->method();
 
if ($request->isMethod('post')) {
    // ...
}
if ($request->is('admin/*')) {
  // ...
}
if ($request->routeIs('admin.*')) {
  // ...
}
// create new url 
$url = url('user/profile');
// "http://127.0.0.1:8000/user/profile"
$url = url('user/profile', [1]);
    // "http://127.0.0.1:8000/user/profile/1"
$url = secure_url('user/profile');
$url = secure_url('user/profile', [1]);
$url = secure_asset('img/photo.jpg');
$url = asset('img/photo.jpg');

dd($previous);

$url = $request->url();
dd($url);

$referer = $request->headers->get('referer');
$parsedReferer = parse_url($referer);
$path = $parsedReferer['path'];

dd($path);
$name = $request->input('name', 'Sally');
$name = $request->input('products.0.name');
 
$names = $request->input('products.*.name');
$host = $request->getHost();
// "127.0.0.1"
$schemeAndHttpHost = $request->getSchemeAndHttpHost();
// "http://127.0.0.1:8000"

$ipAddress = $request->ip();
$ipAddresses = $request->ips();
$contentTypes = $request->getAcceptableContentTypes();
$input = $request->collect();
// $request->host();
// $request->httpHost();
// $request->schemeAndHttpHost();
dd($input);
  // "http://127.0.0.1:8000/timesheet/teamlist"
  //   /timesheet/teamlist

//* find err0r / regarding error 
// error is trailing data 
          // try {
          //   $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
          //   dd($camefromexam);
          // } catch (\Exception $e) {
          //   dd('Error parsing date: ' . $e->getMessage());
          // }

          // try {
          //   $camefromexam = Carbon::createFromFormat('Y-m-d H:i:s', $team->date);
          //   dd($camefromexam);
          // } catch (\Exception $e) {
          //   dd('Error parsing date: ' . $e->getMessage());
          // }

          

//* regarding email / regarding otp /
// app\Http\Controllers\AssignmentController.php
public function assignmentotp(Request $request)
{

  // die;
  if ($request->ajax()) {
    if (isset($request->id)) {
      // $assignment = DB::table('assignmentmappings')
      //   ->where('assignmentgenerate_id', $request->id)
      //   ->first();

      $assignment = DB::table('assignmentmappings')
        ->where('assignmentmappings.assignmentgenerate_id', $request->id)
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->select('assignmentmappings.*', 'assignmentbudgetings.assignmentname', 'clients.client_name')
        ->first();

      $assignmentteammember = DB::table('assignmentteammappings')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
        ->where('assignmentmapping_id', $assignment->id)
        ->select('teammembers.team_member')
        ->get();

      // dd($assignmentteammember);


      $teammembers = DB::table('teammembers')
        ->where('id', auth()->user()->teammember_id)
        ->first();

      $otp = sprintf("%06d", mt_rand(1, 999999));

      DB::table('assignmentbudgetings')
        ->where('assignmentgenerate_id', $assignment->assignmentgenerate_id)->update([
          'otp'  => $otp,
        ]);
      $data = array(
        'asassignmentsignmentid' => $assignment->assignmentgenerate_id,
        'assignmentname' => $assignment->assignmentname,
        'client_name' => $assignment->client_name,
        'email' => $teammembers->emailid,
        'otp' => $otp,
        'name' => $teammembers->team_member,
        'assignmentteammember' => $assignmentteammember,
      );

      // dd($data);

      Mail::send('emails.assignmentclosed', $data, function ($msg) use ($data, $assignment) {
        $msg->to($data['email']);
        $msg->subject('Assignment Closed by OTP' . ' || ' . $assignment->assignmentgenerate_id);
      });

      return response()->json($assignment);
    }
  }
}


//* regarding store image/ regarding image store 
        // this code download any folder from public folder 
        public function zipfile(Request $request, $assignmentfolder_id) {
          // dd($assignmentfolder_id);

          // $userId = auth()->user()->id;
          $articlefiles = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();

          $zipFileName = 'mannat.zip';
          $zip = new ZipArchive;

          if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
              foreach($articlefiles as $file) {
                  $filePath = public_path('backEnd/image/articlefiles/'.$file -> filesname);
                  if (File:: exists($filePath)) {
                      $zip -> addFile($filePath, $file -> filesname);
                  }
              }
              $zip -> close();
          }

          return response() -> download($zipFileName) -> deleteFileAfterSend(true);
      }

      // this code download any folder from storage folder 
      public function zipfile(Request $request, $assignmentfolder_id) {
          // dd($assignmentfolder_id);

          // $userId = auth()->user()->id;
          $fileName = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();

          $zipFileName = 'mannat.zip';
          $zip = new ZipArchive;

          if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
              foreach($fileName as $file) {
                  // file path
                  $filePath = storage_path('image/task/'.$file -> filesname);
                  if (File:: exists($filePath)) {
                      $zip -> addFile($filePath, $file -> filesname);
                  }
              }
              $zip -> close();
          }
          // public\backEnd\image\articlefiles
          //  storage\image\task
          return response() -> download($zipFileName) -> deleteFileAfterSend(true);
      }

//*
$latesttimesheetreport = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->max('enddate');
    // ->max('date');

dd($latesttimesheetreport);

$latesttimesheetreport = DB::table('timesheetreport')
->where('teamid', auth()->user()->teammember_id)
->orderBy('enddate', 'desc') // Order by 'enddate' in descending order
->first(); // Retrieve the first row

dd($latesttimesheetreport);

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereIn('status', [0, 1])
->where('date', $formattedNextSaturday)
->first();

dd($nextweektimesheet);

//* regarding join 
// Start hare

// ------------------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ------------------------------------------------------------------------------------------------------------------------------------
// |  1. join('table', 'first', '=', 'second')                       | Inner join with the specified table on the given conditions.     |
// |  2. joinWhere('table', 'first', '=', 'second')                  | Inner join with the specified table and where conditions.        |
// |  3. joinSub($query, 'alias', 'first', '=', 'second')            | Inner join with a subquery and where conditions.                 |
// |  4. leftJoin('table', 'first', '=', 'second')                   | Left join with the specified table on the given conditions.      |
// |  5. leftJoinWhere('table', 'first', '=', 'second')              | Left join with the specified table and where conditions.         |
// |  6. leftJoinSub($query, 'alias', 'first', '=', 'second')        | Left join with a subquery and where conditions.                  |
// |  7. rightJoin('table', 'first', '=', 'second')                  | Right join with the specified table on the given conditions.     |
// |  8. rightJoinWhere('table', 'first', '=', 'second')             | Right join with the specified table and where conditions.        |
// |  9. rightJoinSub($query, 'alias', 'first', '=', 'second')       | Right join with a subquery and where conditions.                 |
// | 10. crossJoin('table')                                          | Cross join with the specified table.                             |
// | 11. joinWhereRaw('sql', bindings)                               | Inner join with raw WHERE clause.                                |
// | 12. leftJoinWhereRaw('sql', bindings)                           | Left join with raw WHERE clause.                                 |
// | 13. rightJoinWhereRaw('sql', bindings)                          | Right join with raw WHERE clause.                                |
// | 14. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Join with a subquery and specified type (inner, left, right).    |
// | 15. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Left join with a subquery and specified type (inner, left, right).|
// | 16. joinSub($query, 'alias', 'first', '=', 'second', 'type')   | Right join with a subquery and specified type (inner, left, right).|
// ------------------------------------------------------------------------------------------------------------------------------------

// start hare 
// join: Inner join with the specified table on the given conditions.
$query = DB::table('users')
    ->join('posts', 'users.id', '=', 'posts.user_id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// joinWhere: Inner join with the specified table and where conditions.
$query = DB::table('orders')
    ->joinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// joinSub: Inner join with a subquery and where conditions.
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->joinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// leftJoin: Left join with the specified table on the given conditions.

$query = DB::table('users')
    ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// leftJoinWhere: Left join with the specified table and where conditions.

$query = DB::table('orders')
    ->leftJoinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// leftJoinSub: Left join with a subquery and where conditions.

$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->leftJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// rightJoin: Right join with the specified table on the given conditions. (Similar to leftJoin, but reversed)

$query = DB::table('posts')
    ->rightJoin('users', 'posts.user_id', '=', 'users.id')
    ->select('users.*', 'posts.title', 'posts.content')
    ->get();

// Start Hare 
// rightJoinWhere: Right join with the specified table and where conditions. (Similar to leftJoinWhere, but reversed)

$query = DB::table('orders')
    ->rightJoinWhere('customers', 'orders.customer_id', '=', 'customers.id')
    ->where('orders.status', '=', 'pending')
    ->get();

// Start Hare 
// rightJoinSub: Right join with a subquery and where conditions. (Similar to leftJoinSub, but reversed)

$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->rightJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare
// crossJoin: Cross join with the specified table.

$query = DB::table('users')
    ->crossJoin('roles')
    ->get();

// Start Hare 
// joinWhereRaw: Inner join with raw WHERE clause.

$query = DB::table('users')
    ->joinWhereRaw('posts', 'posts.user_id = users.id AND posts.published = ?', ['yes'])
    ->get();

// Start Hare 
// leftJoinWhereRaw: Left join with raw WHERE clause.
$query = DB::table('users')
    ->leftJoinWhereRaw('posts', 'posts.user_id = users.id AND posts.published = ?', ['yes'])
    ->get();

// Start Hare 
// rightJoinWhereRaw: Right join with raw WHERE clause.
$query = DB::table('posts')
    ->rightJoinWhereRaw('users', 'posts.user_id = users.id AND users.active = ?', ['yes'])
    ->get();

// Start Hare 
// joinSub: Join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->joinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// leftJoinSub: Left join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->leftJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 
// rightJoinSub: Right join with a subquery and specified type (inner, left, right).
$subquery = DB::table('posts')
    ->select('user_id', DB::raw('count(*) as post_count'))
    ->groupBy('user_id');

$query = DB::table('users')
    ->rightJoinSub($subquery, 'post_count', 'users.id', '=', 'post_count.user_id')
    ->get();

// Start Hare 




//* regarding where clouse / 

// ------------------------------------------------------------------------------------------------------------------------------------
// |                            Query                                 |                           Description                            |
// ------------------------------------------------------------------------------------------------------------------------------------
// |  1. where('column', '=', 'value')                               | Adds a basic WHERE clause to the query.                         |
// |  2. orWhere('column', '=', 'value')                             | Adds an OR condition to the WHERE clause.                       |
// |  3. whereBetween('column', [value1, value2])                    | Adds a WHERE BETWEEN clause to the query.                       |
// |  4. whereNotBetween('column', [value1, value2])                 | Adds a WHERE NOT BETWEEN clause to the query.                   |
// |  5. whereIn('column', [value1, value2, ...])                    | Adds a WHERE IN clause to the query.                            |
// |  6. whereNotIn('column', [value1, value2, ...])                 | Adds a WHERE NOT IN clause to the query.                        |
// |  7. whereNull('column')                                        | Adds a WHERE NULL clause to the query.                          |
// |  8. whereNotNull('column')                                     | Adds a WHERE NOT NULL clause to the query.                      |
// |  9. whereColumn('column1', '=', 'column2')                     | Adds a comparison of two columns to the WHERE clause.           |
// |  10. whereDate('column', '=', 'date')                           | Adds a WHERE clause comparing a column's value to a date.       |
// |  11. whereDay('column', '=', 'day')                             | Adds a WHERE clause comparing a column's day part to a value.   |
// |  12. whereMonth('column', '=', 'month')                         | Adds a WHERE clause comparing a column's month part to a value. |
// |  13. whereYear('column', '=', 'year')                           | Adds a WHERE clause comparing a column's year part to a value.  |
// |  14. whereTime('column', '=', 'time')                           | Adds a WHERE clause comparing a column's time part to a value.  |
// |  15. whereJsonContains('column', 'value')                       | Adds a WHERE JSON_CONTAINS clause to the query.                 |
// |  16. whereJsonDoesntContain('column', 'value')                  | Adds a WHERE JSON_CONTAINS clause with negation to the query.   |
// |  17. whereJsonLength('column', 'operator', 'value')             | Adds a WHERE JSON_LENGTH clause to the query.                   |
// |  18. whereRaw('SQL statement')                                  | Adds a raw WHERE clause to the query.                           |
// ------------------------------------------------------------------------------------------------------------------------------------
        $teammemberall = Teammember::where('role_id', '=', 15)->orwhere('role_id', '=', 14)->where('status', '=', 1)->with('title', 'role')->get();
        $teammemberall = Teammember::whereIn('role_id', [15, 14])
            ->where('status', 1)
            ->with('title', 'role')
            ->get();
->distinct('partner')
->distinct()
  // start hare 
  ->where(function ($query) {
    $query->where('age', '>', 25)
          ->orWhere('city', 'New York');
})
->whereDate('timesheetrequests.created_at', '>', $permotioncheck->created_at)
  ->whereBetween('date', [$date, '2024-03-22'])
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
   ->whereBetween('date', ['2024-03-11', '2024-03-16'])
  ->whereNotIn('createdby', [234, 453])
  ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
     ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
  ->whereBetween('created_at', ['2023-09-01 16:45:30', '2023-12-31 16:45:30'])
  ->whereIn('timesheetusers.status', [1, 2, 3])
  ->whereNotNull('clients.client_name')
  ->whereNull('partnerid')
  // start hare 
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
->distinct()
->distinct()->get();
  // start hare 
  ->whereBetween('date', ['2024-03-11', '2024-03-16'])


  // start hare 
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
  // start hare 
$clientss = DB::table('assignmentteammappings')
->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
// i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])

->select('clients.client_name', 'clients.id', 'clients.client_code', 'assignmentbudgetings.*')
->orderBy('client_name', 'ASC')
->distinct()->get();
dd($clientss);
  // start hare 

$data = DB::table('assignmentbudgetings')
->where('assignmentbudgetings.client_id', 123)
->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
->where(function ($query) {
  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
})
->where('assignmentbudgetings.status', 1)
// ->orderBy('assignment_name')->get();
->select('assignmentbudgetings.*')
->get();

dd($data);


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
->orderBy('assignment_name')->get() as $sub) {
echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
}

  // start hare 
//* regarding job / job implementation 

// function in controller 
public function zipfolderdownload(Request $request, $assignmentgenerateid)
{
    ZipFolderDownloadJob::dispatch($assignmentgenerateid);

    // return redirect('teammember')->with('status', $output);
    // $output = array('msg' => 'Download has been initiated please wait some time ');
    // return back()->with('success', $output);
}

// job file 
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class ZipFolderDownloadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assignmentgenerateid;

    public function __construct($assignmentgenerateid)
    {
        $this->assignmentgenerateid = $assignmentgenerateid;
    }

    public function handle()
    {

        $assignmentgenerateid = $this->assignmentgenerateid;


        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        // Set Downloaded folder name 
        $parentZipFileName = $assignmentgenerateid . '.zip';
        $parentZip = new ZipArchive;

        // Open parent zip
        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                // Open Child zip
                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    if ($foldername->filesname != null) {
                        // Replace server path here 
                        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    }

                    if (file_exists($filePath)) {
                        // Add file in folder 
                        $zip->addFile($filePath, $foldername->filesname);
                    }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                }
            }

            $parentZip->close();
        }

        // Dispatch another job to delete the temporary files after download
        DeleteTemporaryFilesJob::dispatch($parentZipFileName);
        // return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
}
// after download delete then use or otherwise not 
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;

class DeleteTemporaryFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        // Delete the temporary files
        File::delete($this->filePath);
    }
}



//* regarding fetch data using take() 

$timesheetData = DB::table('timesheetusers')
->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
->where('timesheetusers.createdby', $teamid)
->whereIn('timesheetusers.status', [1, 2, 3])
->select('timesheetusers.*', 'teammembers.team_member')
// ->orderBy('date', 'DESC')->get();
->orderBy('date', 'DESC')
->take(7)
->get();
    // Default show 7 days data 
    $defaulttimesheetshowdate = DB::table('timesheetusers')
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->orderBy('date', 'DESC')
      ->first();
    if ($defaulttimesheetshowdate) {
      $to = $defaulttimesheetshowdate->date;
      $fromformate = Carbon::createFromFormat('Y-m-d', $to);
      // Subtract 6 days
      $from = $fromformate->subDays(6)->toDateString();
    }

    $timesheetData = DB::table('timesheetusers')
    ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    ->where('timesheetusers.createdby', $teamid)
    ->where('timesheetusers.date', '<=', $to)
    ->where('timesheetusers.date', '>=', $from)
    ->whereIn('timesheetusers.status', [1, 2, 3])
    ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('date', 'DESC')->get();
    // Default show 7 days data end hare 
//* number / decimal value / regarding decimal

round($file->getSize() / 1024, 2)
$totalFileSizeMB = round($totalFileSizeKB / 1024, 2);
//* zip download 
public function zipfolderdownload(Request $request, $assignmentgenerateid)
    {
        // Get All folder data and folder name 
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        // Set Downloaded folder name 
        $parentZipFileName = $assignmentgenerateid . '.zip';
        $parentZip = new ZipArchive;

        // Open parent zip
        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                // Open Child zip
                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    // Replace server path hare 
                    // $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    if ($foldername->filesname != null) {
                        $filePath = storage_path('app/public/image/task/' . $foldername->filesname);
                    }
                    // else {
                    //     $filePath = storage_path('app/public/image/task/' . "Screenshoasast_7.png");
                    // }

                    if (file_exists($filePath)) {
                        // Add file in folder 
                        $zip->addFile($filePath, $foldername->filesname);
                    }
                    // else {
                    //     return '<h1>File Not Found</h1>';
                    // }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                }
            }

            $parentZip->close();
        }
        // dd($parentZipFileName);
        // Download the parent zip file
        return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
//* regarding file store / store file size / regarding database / regarding table 
public function store(Request $request)
{
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $name = $file->getClientOriginalName();
                // store data here storage\app\public\image\task
                $path = $file->storeAs('public\image\task', $name);
                $files[] = [
                    'name' => $name,
                    // Get the file size in bytes
                    'size' => $file->getSize(),
                    // Get the file size in kb aur blade per kb mb and gb me convert kar le 
                    // 'size' => round($file->getSize() / 1024, 2),
                ];
            }
        }
        // dd($files);

        foreach ($files as $file) {
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $file['name'],
                'filesize' => $file['size'], // Save the file size to the database
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $output = array('msg' => 'Submit Successfully');
        return back()->with('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
}

$permissiontimesheet = DB::table('timesheetreport')->first();

if ($permissiontimesheet) {
    // Access properties of $permissiontimesheet here
    // Example: $permissiontimesheet->columnName
} else {
    // Handle case where no record was found
}
//* zip download on assignment folder all 
 // public function zipfolderdownload(Request $request, $assignmentgenerateid)
    // {
    //     $assignmentfoldername = DB::table('assignmentfolders')
    //         ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
    //         ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
    //         ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
    //         ->get();

    //     $zipFileNames = [];

    //     foreach ($assignmentfoldername as $foldername) {
    //         $zipFileName = $foldername->assignmentfoldersname . '.zip';
    //         $zipFileNames[] = $zipFileName;

    //         $zip = new ZipArchive;
    //         if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
    //             // Replace storage_path with the appropriate file path
    //             $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

    //             if (file_exists($filePath)) {
    //                 $zip->addFile($filePath, $foldername->filesname);
    //             } else {
    //                 return '<h1>File Not Found</h1>';
    //             }

    //             $zip->close();
    //         }
    //     }
    //     // dd($zipFileNames);
    //     // Download all zip files
    //     foreach ($zipFileNames as $zipFileName) {
    //         return response()->download($zipFileName)->deleteFileAfterSend(true);
    //     }
    // }

    public function zipfolderdownload(Request $request, $assignmentgenerateid)
    {
        $assignmentfoldername = DB::table('assignmentfolders')
            ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
            ->where('assignmentfolders.assignmentgenerateid', $assignmentgenerateid)
            ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
            ->get();

        $parentZipFileName = 'report_name.zip';
        $parentZip = new ZipArchive;

        if ($parentZip->open($parentZipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($assignmentfoldername as $foldername) {
                $folderZipFileName = $foldername->assignmentfoldersname . '.zip';
                $zip = new ZipArchive;

                if ($zip->open($folderZipFileName, ZipArchive::CREATE) === TRUE) {
                    // Replace storage_path with the appropriate file path
                    $filePath = storage_path('app/public/image/task/' . $foldername->filesname);

                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, $foldername->filesname);
                    } else {
                        return '<h1>File Not Found</h1>';
                    }

                    $zip->close();
                    $parentZip->addFile($folderZipFileName, $foldername->assignmentfoldersname . '/' . $foldername->filesname);
                    // No need to delete individual folder zip here
                }
            }

            $parentZip->close();
        }

        // Download the parent zip file
        return response()->download($parentZipFileName)->deleteFileAfterSend(true);
    }
//* count data 
$totalFiles = count($zipFileNames);
//* check array data / testing foreeach / regarding foreach
$zipfoldername1 = [];
foreach ($assignmentfoldername as $foldername) {
    $zipfoldername = $foldername->assignmentfoldersname . '.zip';
    // Add each zip folder name to the array
    $zipfoldername1[] = $zipfoldername;
}
dd($zipfoldername1);

// output
array:2 [▼
  0 => "Shahid f.zip"
  1 => "rahul.zip"
]


//* online excell editing
https://www.microsoft365.com/launch/excel?auth=1
//* regarding next week / regarding preious week / regarding week
 // -----------------------------Shahid coding start------------------------------------------
            // Get latest submited timesheet end date from timesheetreport table
            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();
            // dd($latesttimesheetreport);

            $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);
            // find next sturday 
            $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
            $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
            $formattedNextSaturday = $nextSaturday->format('Y-m-d');
            $formattedNextSaturday1 = $timesheetreportenddate->format('d-m-Y');

            // find next week timesheet filled or not 
            $nextweektimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->where('status', '0')
                ->where('date', $formattedNextSaturday)
                ->first();
            // dd($nextweektimesheet);

            // if not filled next week timesheet then 
            if ($nextweektimesheet == null) {
                $output = array('msg' => "Fill the Week timesheet After this week : $formattedNextSaturday1");
                return back()->with('statuss', $output);
            }
            // -----------------------------Shahid coding end------------------------------------------
           
//* function only for testing / testing function / regarding testing

    //! for testing only 
    public function timesheetsubmission(Request $request)
    {
        try {
            // Get latest timesheet end date from timesheetreport table
            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();
            // dd($latesttimesheetreport);

            $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);
            $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
            // dd($nextSaturday);
            $formattedNextSaturday = $nextSaturday->format('Y-m-d');
            $formattedNextSaturday1 = $nextSaturday->format('d-m-Y');


            $nextweektimesheet = DB::table('timesheetusers')
                ->where('createdby', auth()->user()->teammember_id)
                ->where('status', '0')
                ->where('date', $formattedNextSaturday)
                ->first();
            // dd($nextweektimesheet);

            if ($nextweektimesheet == null) {
                $output = array('msg' => "Fill the timesheet After this week : $formattedNextSaturday1");
                return back()->with('success', $output);
            }
            // dd($latesttimesheetreport);
            // -------------------------Shahid coding end hare -----------------------------
            else {

                $output = array('msg' => 'Timesheet Submit Successfully');
                return back()->with('success', $output);
            }

            // Check previous week timesheet 

        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }


//* regarding year / year wise filter
$approvedleavesvalue = DB::table('applyleaves')
->where('createdby', auth()->user()->teammember_id)
->where('status', 1)
->whereYear('from', 2024)
->get();

dd($approvedleavesvalue);
$currentDate = now();
$month = $currentDate->format('F');
$year = $currentDate->format('Y');
$timesheetData = DB::table('timesheetusers')
->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
->where('timesheetusers.createdby', auth()->user()->teammember_id)
->where('timesheetusers.status', 0)
//   ->where('timesheets.month', $month)
->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();
//  dd($timesheetData);
//* redirection in javascript
if (!shouldContinue) {
  // Redirect to a specific URL when the user clicks Cancel
  window.location.href = "{{ url('/teammember') }}";
  return;
  }
//* filtering functionality / regarding filter / filter functionality

// convert when clouse to good code 
  // Apply leave filter
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);
    }

    // For admin
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if ($startdate && $enddate) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($startperioddata && $endperioddata) {
      $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }
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
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
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
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC');

    if ($startDate && $endDate && $teamId) {
      $query->where(function ($q) use ($startDate, $endDate, $teamId) {
        $q->where('timesheetusers.createdby', $teamId)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      });
    }
    $timesheetData = $query->get();

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }
}


// timesheet filtering function blade code yes
public function searchingtimesheet(Request $request)
{
  // Get all input from form
  $startDate = $request->input('startdate', null);
  $endDate = $request->input('enddate', null);
  $teamId = $request->input('teamid', null);
  $year = $request->input('year', null);

  // this is for patner
  if (auth()->user()->role_id == 13) {

    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        // When year exist then run 'when' clouse
        ->when($year, function ($query) use ($year, $teamId) {
          // convert startyear (2023) in full date like 01-01-2023
          $startYear = Carbon::createFromFormat('Y', $year)->startOfYear();
          // convert endYear (2023) in full date like 31-12-2023
          $endYear = Carbon::createFromFormat('Y', $year)->endOfYear();
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startYear)
            ->where('timesheetusers.date', '<=', $endYear);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')
        ->orderBy('date', 'DESC')
        ->get();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  // this is for staff and manager
  else {
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        // When year exist then run 'when' clouse
        ->when($year, function ($query) use ($year, $teamId) {
          // convert startyear (2023) in full date like 01-01-2023
          $startYear = Carbon::createFromFormat('Y', $year)->startOfYear();
          // convert endYear (2023) in full date like 31-12-2023
          $endYear = Carbon::createFromFormat('Y', $year)->endOfYear();
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startYear)
            ->where('timesheetusers.date', '<=', $endYear);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member')
        ->orderBy('date', 'DESC')
        ->get();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  return '<h3>Please Choose Searching Data</h3>';
}

public function searchingtimesheet(Request $request)
{
  // dd($request, 'hi1');
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
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          // dd('1 one');
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->get();
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
  // For staff and manager
  else {
    if (($startDate != null && $endDate != null) || $request->year != null) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // When startDate and endDate exist then run 'when' clouse
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate, $teamId) {
          return $query->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        })
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->get();

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }
}

public function adminsearchtimesheet(Request $request)
{
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

  $assignmentsname = DB::table('assignments')
    ->where('status', 1)
    ->select('id', 'assignment_name')
    ->orderBy('assignment_name', 'ASC')
    ->get();

  if (auth()->user()->role_id == 11) {
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
        return $query->where('timesheetusers.assignment_id', $assignmentId)
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
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC')
      ->get();

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }
  // for patner team timesheet 
  else {
    $timesheetData = DB::table('timesheetusers')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      // When startDate and endDate exist then run 'when' clause
      ->when($startDate && $endDate && $teammemberId && $year, function ($query) use ($startDate, $endDate, $teammemberId) {
        return $query->where('timesheetusers.createdby', $teammemberId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $clientId && $year, function ($query) use ($startDate, $endDate, $clientId) {
        // dd($clientId);
        return $query->where('timesheetusers.client_id', $clientId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $assignmentId && $year, function ($query) use ($startDate, $endDate, $assignmentId) {
        // dd('assignmentId');
        return $query->where('timesheetusers.assignment_id', $assignmentId)
          ->where('timesheetusers.partner', auth()->user()->teammember_id)
          ->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate);
      })
      ->when($startDate && $endDate && $year && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate, $year) {
        return $query->where('timesheetusers.date', '>=', $startDate)
          ->where('timesheetusers.date', '<=', $endDate)
          ->where('timesheetusers.partner', auth()->user()->teammember_id);
      })
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
      ->orderBy('date', 'DESC')
      ->get();
    // dd($timesheetData);
    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }
}
// end hare

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
// end hare
public function filterDataAdmin(Request $request)
{
  $teamname = $request->input('employee');
  $leavetype = $request->input('leave');
  $startdate = $request->input('start');
  $enddate = $request->input('end');
  $statusdata = $request->input('status');
  $startperioddata = $request->input('startperiod');
  $endperioddata = $request->input('endperiod');

  $query = DB::table('applyleaves')
    ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
    ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
    ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
    ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

  if (auth()->user()->role_id == 13) {
    $query->where('applyleaves.approver', auth()->user()->teammember_id);

    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if (!$teamname && !$leavetype && $statusdata === null) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($teamname && $leavetype) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $statusdata !== null) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.status', $statusdata);
    }

    if ($statusdata !== null && $leavetype !== null) {
      $query->where('applyleaves.status', $statusdata)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status', $statusdata)
        ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status', $statusdata)
        ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }
  } else {
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($teamname && $leavetype) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype);
    }

    if ($teamname && $leavetype && $statusdata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata);
    }

    if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata)
        ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
      $query->where('applyleaves.createdby', $teamname)
        ->where('applyleaves.leavetype', $leavetype)
        ->where('applyleaves.status',  $statusdata)
        ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }
  }

  $filteredData = $query->get();

  return response()->json($filteredData);
}
// end hare
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);

      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }

      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      if ($statusdata !== null) {
        $query->where('applyleaves.status', $statusdata);
      }

      if (!$teamname && !$leavetype && $statusdata === null) {
        $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($teamname && $leavetype) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.status', $statusdata);
      }

      if ($statusdata !== null && $leavetype !== null) {
        $query->where('applyleaves.status', $statusdata)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }
    } else {

      if ($teamname) {
        $query->where('applyleaves.createdby', $teamname);
      }
      // dd($request);

      if ($teamname && $leavetype) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype);
      }

      if ($teamname && $leavetype && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata);
      }

      if ($teamname && $leavetype && $statusdata && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $leavetype && $statusdata && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.leavetype', $leavetype)
          ->where('applyleaves.status',  $statusdata)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($statusdata !== null) {
        $query->where('applyleaves.status', $statusdata);
      }

      if ($teamname && $statusdata !== null) {
        $query->where('applyleaves.createdby', $teamname)
          ->where('applyleaves.status', $statusdata);
      }

      if ($leavetype) {
        $query->where('applyleaves.leavetype', $leavetype);
      }

      // According startdate
      if ($startdate && $enddate) {
        $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }

      if ($teamname && $startdate && $enddate) {
        $query->where('applyleaves.createdby', $teamname)
          ->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
      }


      // According startperioddata

      if ($startperioddata && $endperioddata) {
        $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($teamname && $startperioddata && $endperioddata) {
        $query->where('applyleaves.createdby', $teamname)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($leavetype && $startperioddata && $endperioddata) {
        $query->where('applyleaves.leavetype', $leavetype)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }

      if ($statusdata !== null && $startperioddata && $endperioddata) {
        $query->where('applyleaves.status', $statusdata)
          ->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
      }



      // end 
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }

// end hare good for all condition 
  // Apply leave filter
  public function filterDataAdmin(Request $request)
  {
    $teamname = $request->input('employee');
    $leavetype = $request->input('leave');
    $startdate = $request->input('start');
    $enddate = $request->input('end');
    $statusdata = $request->input('status');
    $startperioddata = $request->input('startperiod');
    $endperioddata = $request->input('endperiod');

    $query = DB::table('applyleaves')
      ->leftJoin('leavetypes', 'leavetypes.id', '=', 'applyleaves.leavetype')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'applyleaves.createdby')
      ->leftJoin('teammembers as approvername', 'approvername.id', '=', 'applyleaves.approver')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

    if (auth()->user()->role_id == 13) {
      $query->where('applyleaves.approver', auth()->user()->teammember_id);
    }

    // For admin
    if ($teamname) {
      $query->where('applyleaves.createdby', $teamname);
    }

    if ($leavetype) {
      $query->where('applyleaves.leavetype', $leavetype);
    }

    if ($statusdata !== null) {
      $query->where('applyleaves.status', $statusdata);
    }

    if ($startdate && $enddate) {
      $query->whereBetween('applyleaves.created_at', [$startdate, $enddate]);
    }

    if ($startperioddata && $endperioddata) {
      $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
    }

    $filteredData = $query->get();

    return response()->json($filteredData);
  }

// end hare

//* filter functionality on date / filter created_at column 

<div class="col-3">
<div class="form-group">
    <label class="font-weight-600">Start Date and Time</label>
    <input type="datetime-local" class="form-control" id="start1" name="start">
</div>
</div>

<div class="col-3">
<div class="form-group">
    <label class="font-weight-600">End Date</label>
    <input type="datetime-local" class="form-control" id="end1" name="end">
</div>
</div>


$startdate = $request->input('start');
$startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
$endtdate = $request->input('end');
$endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));


//* array to object convert
public function timesheet_teamlist()
  {
    if (auth()->user()->role_id == 13) {
      // get all partner
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $get_date = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    } else {
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();
      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
    }

    // dd($get_datess);


    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();
//* array to object convert
      return [
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



    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();
//* array to object convert
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


    // dd($get_date);

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  }
//* previus days find 
$getsixdata->date
// 2023-11-13
if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

  $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
  // date: 2023-11-06 00:00:00.0 Asia/Kolkata (+05:30)
  // dd($previousMonday);
  // Find the nearest next Saturday to the requested date
  $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
  // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)
  dd($nextSaturday);
//* date as a string
if (!empty($missingDates)) {
  $missingDatesString = implode(', ', $missingDates);
  // "2023-11-13, 2023-11-14" like 
  // "2024-03-11, 2024-03-12, 2024-03-13"
  dd($missingDatesString);

  $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
  return back()->with('success', $output);
}
//* add one date in date /add on date 
$currentDate = clone $firstDate;
// date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)

while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    $expectedDates[] = $currentDate->format('Y-m-d');

    // 0 => "2023-11-13"
    $currentDate->modify("+1 day");
    // date: 2023-11-14 00:00:00.0 Asia/Kolkata (+05:30)
    dd($currentDate);
}

//* get last date of timesheet

$get_six_Data = DB::table('timesheets')
->where('status', '0')
->where('created_by', auth()->user()->teammember_id)
->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
->orderBy('date', 'ASC')
->get();

$lastdate = $get_six_Data->max('date');
//* all data for users

dd(auth()->user());
//*

//------------------- Shahid's code start---------------------
//*

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
//* insert null value in database 

$lstatus = null;
//* delete data between two dates from database 
app\Http\Controllers\ApplyleaveController.php

$to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
// 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
$from = Carbon::createFromFormat('Y-m-d', $team->from);
//2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
$camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
// dd($from);
$nowrequestdays = $from->diffInDays($camefromexam) + 1;
// 5 days

$finddatafromleaverequest = $to->diffInDays($from) + 1;


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

dd($datess);
//* error get patch ya any route related use it / regarding route 

Route::any('/examleaverequestapprove/{id}', [ApplyleaveController::class, 'examleaverequest'])->name('examleaveapprove');
// with id and without id 
Route::get('/timesheetreject/edit/{id?}', [TimesheetController::class, 'timesheetEdit']);


//* holidays count
// app\Http\Controllers\ApplyleaveController.php in update function 

$holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
->where('enddate', '<=', $team->to)
->count();
dd($holidaycount);
//* regarding redirect / regarding message /success message / regarding output / regarding return / regarding url
if ($checkrole->role_id != $request->designationtype) {

  $role = '';
  if ($checkrole->role_id == 11) {
      $role = "super admin";
  } elseif ($checkrole->role_id == 12) {
      $role = "admin";
  } elseif ($checkrole->role_id == 13) {
      $role = "partner";
  } elseif ($checkrole->role_id == 14) {
      $role = "manager";
  } elseif ($checkrole->role_id == 15) {
      $role = "staff";
  }
  $output = array('msg' => 'You have already on this post ' . $role . '.');
  return redirect('teammember')->with('success', $output);
}

$output = array('msg' => "Created Successfully <strong>Client Name:</strong> $clientname->client_name <strong>Assignment:</strong> $assignment_name <strong>Assignment Name:</strong> $request->assignmentname <strong>Assignment Id:</strong> $assignmentgenerate ");
return redirect('assignmentbudgeting')->with('success', $output);

// @if (session()->has('success'))
// <div class="alert alert-success">
//     @if (is_array(session()->get('success')))
//         @foreach (session()->get('success') as $message)
//             <p>{!! $message !!}</p>
//         @endforeach
//     @else
//         <p>{{ session()->get('success') }}</p>
//     @endif
// </div>
// @endif
$output = array('msg' => 'You are already on this post "' . $role . '".');
$output = ['msg' => "You can not fill timesheet to: Assignment name " . $assignmentcloseddata->assignmentname . " Assignment id: " . $request->assignment_id[$i]];
$output = ['msg' => "You can not fill timesheet to: " . $request->assignment_id[$i]];
$output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
$output = array('msg' => "Timesheet Submit Successfully till $previousMondayFormatted to $nextSaturdayFormatted ");
$output = array('msg' => "Fill the timesheet Previous Week: $formattedPreviousSaturday");
$output = array('msg' => 'Please Approve Latest Timesheet Request');
$output = array('msg' => 'You Have already filled timesheet for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
return redirect('timesheetrequest/view/' . $id)->with('statuss', $output);

// for rejected message 
$output = array('msg' => 'Rejected Successfully');
return back()->with('statuss', $output);

// for success message 
$output = array('msg' => 'You have already submitted a request');
return back()->with('success', $output);

// return back()->with('statuss', $output);
return redirect()->to('rejectedlist')->with('statuss', $output);
// return redirect('teammember')->with('status', $output);
$output = array('msg' => 'Download has been initiated please wait some time ');
return back()->with('success', $output);

//* update one column in table for all // update table / regarding update / regarding table 
use Illuminate\Support\Facades\DB;

//? sum total hour / regarding row / row count 
$co = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
->get();


$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2024-01-13'])
// ->get();
->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheets')
->where('created_by', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2024-01-13'])
// ->get();
->update(['status' => 0]);
// // dd($nextweektimesheet);

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', auth()->user()->teammember_id)
->whereBetween('date', ['2023-12-25', '2023-12-31'])
->delete();

DB::table('assignmentteammappings')
->update(['status' => 0]);

dd('hi');




//* Ternary operator vs Null coalescing operator in PHP
// Ternary Operator

// Ternary operator is the conditional operator which helps to cut the number of lines in the coding while performing comparisons and conditionals. It is an alternative method of using if else and nested if else statements. The order of execution is from left to right. It is absolutely the best case time saving option. It does produces an e-notice while encountering a void value with its conditionals. 

// Syntax:

// (Condition) ? (Statement1) : (Statement2);
// Example
// PHP program to check number is even
// or odd using ternary operator
 
// Assign number to variable
$num = 21;
 
// Check condition and display result
print ($num % 2 == 0) ? "Even Number" : "Odd Number";


// Null coalescing operator

// The Null coalescing operator is used to check whether the given variable is null or not and returns the non-null value from the pair of customized values. Null Coalescing operator is mainly used to avoid the object function to return a NULL value rather returning a default optimized value. It is used to avoid exception and compiler error as it does not produce E-Notice at the time of execution. The order of execution is from right to left. While execution, the right side operand which is not null would be the return value, if null the left operand would be the return value. It facilitates better readability of the source code. 

// Syntax:

// (Condition) ? (Statement1) ? (Statement2);

// PHP program to use Null 
// Coalescing Operator
 
// Assign value to variable
$num = 10;
 
// Use Null Coalescing Operator 
// and display result
print ($num) ?? "NULL";
Output:
10

//*
    //BAN100157Nitin Singhal
    //* inactive and active / rejected / submitted  / mail send / send mail
    public function  assignmentreject($id, $status,$teamid)
    {
        // dd($teamid);
      try {

       if($status==1){
        DB::table('assignmentteammappings')->where('id', $id)->update([
            'status'   => 1,
          ]);
       }
        else{
            DB::table('assignmentteammappings')->where('id', $id)->update([
                'status'   => 0,
              ]); 

              // timesheet rejected mail
        $data = DB::table('teammembers')
        ->where('teammembers.id', $teamid)
        ->first();
      //   dd($data);
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.assignmentrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Assignment rejected');
      });
      // timesheet rejected mail end hare

        }
        
  
  
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
    // find date beetween two dates/ all dates find  

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
          $a = DB::table('timesheetusers')->insert([
            'date'        => date('Y-m-d', strtotime($date)),
            'createdby'   => auth()->user()->teammember_id,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
          ]);
        }
      }
    //* regarding Ascending / regarding Descending / regarding order /regarding ordering 

    $getauthh =  DB::table('timesheetusers')
    ->where('createdby', auth()->user()->teammember_id)
    ->orderBy('id', 'asc')->paginate(10);
    ->orderby('id', 'desc')->first();
    //* compare date in controller 

    $requestDate = Carbon::parse($request->date);
    $joiningDate = Carbon::parse($joining_date);

    if ($requestDate >= $joiningDate) {
    }
    //* how to  get all date beteen two dates in laravel/ two dates get beetweeen
    elseif ($Newteammeber->id != null) {
        $Newteammeberjoining_date = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->select('joining_date')
          ->first();

        $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));
        $joining_timestamp = strtotime($joining_date);

        // Calculate the day of the week for the joining date (0 for Sunday, 1 for Monday, and so on)
        $day_of_week = date('w', $joining_timestamp);

        // Calculate the number of days to subtract to reach the previous Sunday
        $days_to_subtract = $day_of_week;

        // Calculate the timestamp of the previous Sunday
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        // Format the previous Sunday date in the desired format
        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);

        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);

        // Create a date period
        $period = CarbonPeriod::create($startDate, $endDate);

        $result = [];

        // Iterate over the period and store each date in the result array
        foreach ($period as $key => $date) {
          // Skip the first and last iterations
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }

        // Return the result array
        return $result;
      }

    // 11111111111111111
      use Carbon\Carbon;
      use Carbon\CarbonPeriod;
      
      $startDate = Carbon::parse('2023-01-01');
      $endDate = Carbon::parse('2023-01-10');
      
      // Create a date period
      $period = CarbonPeriod::create($startDate, $endDate);
      
      // Iterate over the period and get each date
      foreach ($period as $date) {
          echo $date->toDateString() . "\n";
      }
      
    //* insert months in database 
          // insert data in timesheet from request and get id only
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>    date('F', strtotime($request->date)),
              'date'     =>    date('Y-m-d', strtotime($request->date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );

    //*  week days in numbric/ regarding months / weeks days / regarding date and time  /regarding date / regarding time

//* in blade file 
$joining_date = $pormotionandrejoiningdata->joining_date ?
Carbon::parse($pormotionandrejoiningdata->joining_date)->format('d-m-Y') : null;

 //     <small class="text-muted">
//         {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
//          {{-- 14 jan output --}}
//      </small>
    
    // dd(date('w', strtotime($request->date))); // 4

        $period = CarbonPeriod::create($team->from, $team->to);
        
        //  dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"

        // $currentDate = Carbon::now()->format('d-m-Y');// "30-11-2023"

        // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"

        //   dd(date('F', strtotime($request->date)));// "November"

             // dd(date('Y-m-d H:i:s')); // "2023-11-30 15:26:18"

        // 'month'     =>    date('F', strtotime($request->date)),//November

        date('F d,Y', strtotime($holidayDatas->startdate)); //January 14,2023
// Get hour
          dd(date('H', strtotime($latestrequest->created_at))); //11

          dd($latestrequesthour->diffInHours($currentDateTime));

          DB::table('leaverequest')->insert([
            'applyleaveid' => $request->applyleaveid,
            'createdby' => $request->createdby,
            'approver' => $request->approver,
            'status' => $request->status,
            'reason' => $request->reason,
            'date' => date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // count days 
    // Convert the requested date to a Carbon instance
          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
            // date: 2023-11-16 15:42:44.0 Asia/Kolkata (+05:30)
            // dd($to);
                // Convert the requested date to a Carbon instance
            $from = Carbon::createFromFormat('Y-m-d', $team->from);

            // date: 2023-09-16 15:43:42.0 Asia/Kolkata (+05:30)
            // dd($from);
            $requestdays = $to->diffInDays($from) + 1;
            // 62 days
          // count days  end

          // current date 
          'otpverifydate' => date('Y-m-d H:i:s')
          $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);

       // current date 
          $assignmentcloseddata = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();
          $requestDate = \DateTime::createFromFormat('d-m-Y', $request->date);
          $assignmentcloseddate = \DateTime::createFromFormat('Y-m-d H:i:s', $assignmentcloseddata->otpverifydate)->setTime(23, 59, 59);

          if ($assignmentcloseddata->status == 0 && $assignmentcloseddate <= $requestDate) {
            $output = ['msg' => 'Hi shahid.'];
            return redirect('timesheet/mylist')->with('success', $output);
          }



       // now() function 
    //    12
        dd(now()->month); 
        // 2023
        dd(date('Y-m-d')); 
        // 2023-12-01
        dd(now()->year); 
        // 1 
        dd(now()->day); 
        // 17
        dd(now()->hour); 
        // 13;
        dd(now()->minute); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Current year (e.g., 2023)
        $year = now()->year;     
        // Current month (e.g., 12)
        $month = now()->month;   
        // Current day of the month (e.g., 1)
        $day = now()->day;       
        // Current hour (e.g., 15)
        $hour = now()->hour;     
        // Current minute (e.g., 30)
        $minute = now()->minute; 
        // Add 7 days to the current date
        $futureDate = now()->addDays(7);   
        // Subtract 2 hours from the current date and time
         $pastDate = now()->subHours(2);    
         // Check if the current date and time is in the future
         $isFuture = now()->isFuture();     
         // Check if the current date and time is in the past
         $isPast = now()->isPast();         
         // Convert the current date and time to a different timezone
         $userTimeZone = now()->setTimezone('America/New_York'); 
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
       'created_at' => date('Y-m-d H:i:s'),
       // 2024-01-16 00:46:21.610590
 
       $month = $currentDate->format('F');
       // "January"
       $year = $currentDate->format('Y');
       // "2024"
       $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);
       dd($lastdate);

       $currentDate = clone $firstDate;
      //  find day previous week 
       $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

      //  find next day 
       $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
       dd($nextSaturday, 'hi88');

       
      //  today date
       $todaydate = Carbon::now('Asia/Kolkata');
       dd($todaydate);

      //  find weeek
       $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

       $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

      //* date() function 
      // Formats the current date and time as a string
      $currentDateTime = date('Y-m-d H:i:s'); 
      // Formats a specific date
      $formattedDate = date('Y-m-d', strtotime('2023-12-01')); 
      // Convert a string to a Unix timestamp
      $timestamp = strtotime('2023-12-01'); 
      // Format the Unix timestamp
      $formattedDate = date('Y-m-d', $timestamp); 
      // December 29th
     date('F jS', strtotime($notificationData->created_at))
     $output = array('msg' => 'You Have already filled timesheet for the Day (' . date('d-m-Y', strtotime($leaveDate)) . ')');
      
      // Current year
       $year = date('Y');     
       // Current month
       $month = date('m');    
       // Current day of the month
       $day = date('d');      
       // Current hour (24-hour format)
       $hour = date('H');     
       // Current minute
       $minute = date('i');   
       // Current second
       $second = date('s');   
       // Current day of the week (full text, e.g., "Monday")
       $dayOfWeek = date('l');
       // Custom date and time format (e.g., "December 1, 2023, 3:30 pm")
       $customFormat = date('F j, Y, g:i a'); 
      //  10:55 am
      $msg = 'You can submit new timesheet request after 24 hour from ' . date('h:i:s A', strtotime($latestrequest->created_at));
       $customFormat = date('g:i a', strtotime($timesheetrequestsData->created_at)); 

       date('d-m-Y', strtotime($timesheetrequestsData->created_at))
      //  12-10-2023
      // get only date
      $cl_leave_day = date('d', strtotime($cl_leave));
      // 12
       date('h-m-s', strtotime($timesheetrequestsData->created_at)) 
      //  11:12:53
      // 10 days only in table then
      // December 20,2023 - December 20,2023
      <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
      {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
      
// 18-12-23 then / basically add date in date
      $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);
// it will give result 24-12-23

             // Convert the retrieved date to a DateTime object
             $firstDate = new DateTime($usertimesheetfirstdate->date);
             // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

             // Find the day of the week for the first date (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
             $dayOfWeek = $firstDate->format('w');



    // Sunday=1
    // Monday=2
    // Tuesday=3
    // Wednesday=4
    // Thursday=5
    // Friday=6
    // Saturday=7
    // Sunday=8

    if(
        (now()->isSunday() && now()->hour >= 18) ||
            now()->isMonday() ||
            now()->isTuesday() ||
            now()->isWednesday() ||
            now()->isThursday() ||
            now()->isFriday() ||
            (now()->isSaturday() && now()->hour <= 18)){

            }


     //* format() function 
     // Formats the current date and time as a string
     $formattedDateTime = now()->format('Y-m-d H:i:s'); 
     // Formats a specific date
     $formattedDate = Carbon\Carbon::parse('2023-12-01')->format('Y-m-d'); 
     $user = User::find(1);
     // Formats a date property of a model
     $formattedBirthdate = $user->birthdate->format('F j, Y'); 
     {{-- Blade View --}}
     {{ $user->created_at->format('M d, Y') }}
     $formattedDate = $user->created_at->format('d/m/Y');
     // "2 days ago"
     $relativeTime = now()->subDays(2)->diffForHumans(); 
     // Custom date and time format
     $customFormat = now()->format('F j, Y \a\t g:i A'); 
     // Spanish locale
     $formattedDate = now()->locale('es')->isoFormat('dddd, MMMM D, YYYY'); 
//* find last week / in_array
if ($savetimesheet) {
  $savetimesheetdate = Carbon::parse($savetimesheet->date);
  $previousSaturday = $savetimesheetdate->copy()->previous(Carbon::SATURDAY);
  dd($previousSaturday);
} else {
  // Handle the case where $savetimesheet is null or no records match the conditions
}
//* find last week / in_array
    // find previus sunday 
    $previewsunday = now()->subWeeks(1)->endOfWeek();
    $previewsundayformate = $previewsunday->format('d-m-Y');

    // find previus saturday
    $previewsaturday = now()->subWeeks(1)->endOfWeek();
    // Subtract one day from sunday
    $previewsaturdaydate = $previewsaturday->subDay();
    $previewsaturdaydateformate = $previewsaturdaydate->format('d-m-Y');

    foreach ($teammembers as $teammembermail) {
        // both date store in an array 
        $validDates = [$previewsundayformate, $previewsaturdaydateformate];
        if (!in_array($teammembermail->last_submission_date, $validDates)) {
            $data = array(
                'subject' => "Reminder || Timesheet not filled Last Week",
                'name' =>   $teammembermail->team_member,
                'email' =>   $teammembermail->emailid,
            );
            Mail::send('emails.timesheetnotfilledstafflastweekremidner', $data, function ($msg) use ($data) {
                $msg->to($data['email']);
                $msg->subject($data['subject']);
            });
        }
    }






     //* auth() function 

     if (auth()->check()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Returns the currently authenticated user or null if not authenticated
    $user = auth()->user(); 
    if (auth()->user()->isAdmin()) {
        // User is an admin
    }
    
    if (auth()->user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    // Manually Authenticate a User:
    $user = User::find(1);
    // Manually log in a user
     auth()->login($user); 
    //  Log Out the Currently Authenticated User:
    // Log out the currently authenticated user
     auth()->logout(); 

     if (auth()->guest()) {
        // User is a guest (not authenticated)
    }
    // Check if a User is Authenticated via a Guard:
    if (auth('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Returns the ID of the currently authenticated user or null if not authenticated
    $userId = auth()->id(); 

    if (auth()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Check if a User is Remembered:
    if (auth()->viaRemember()) {
        // User is authenticated via "remember me" cookie
    }
    // Returns the user's authentication identifier
    $identifier = auth()->id(); 
    // Returns the authentication provider instance
    $provider = auth()->getProvider(); 
    // Returns the "remember me" token
    $rememberToken = auth()->user()->getRememberToken(); 
    // Log in a user by ID
    auth()->loginUsingId(1); 
    // Log the user out of all other devices
    auth()->user()->logoutOtherDevices('password'); 
    // Returns the name of the default guard
    $guardName = auth()->getDefaultDriver(); 
    // Returns the currently authenticated user or null if not authenticated
    $user = user(); 
    if (user()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Get the user's ID
    $userId = user()->id;      
     // Get the user's name
    $userName = user()->name;  
    // Get the user's email
     $userEmail = user()->email; 
     if (user()->isAdmin()) {
        // User is an admin
    }
    
    if (user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    $user = User::find(1);
    // Manually set the authenticated user
     user($user); 
     // Log out the currently authenticated user
     user()->logout(); 
     // Returns the user's authentication identifier
     $identifier = user()->getAuthIdentifier(); 
     // Returns the user's authentication provider name
     $provider = user()->getAuthIdentifierName(); 
     if (user()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    
//* compare houre / hour compare 
    $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->select('created_at')
        ->first();

      $latestrequesthour = Carbon::parse($latestrequest->created_at);
      $currentDateTime = Carbon::now();
      // Check if the difference is more than 24 hours
      if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     => $request->partner,
          'reason'      => $request->reason,
          'status'      => 0,
          'createdby'   => auth()->user()->teammember_id,
          'created_at'  => now(),
          'updated_at'  => now(),
        ]);
      }
    



   //*  dd with mesaage/ check dd output 
    // dd('hi', $previoussavechck);

    //* ager ek table ke id ko dusre table ke kisi id se compare karna ho to / id pass /pass data in another table 


    $excludedIds = DB::table('timesheetusers')->select('createdby')->distinct()->get()->pluck('createdby')->toArray();
    $teammemberOnlySave = DB::table('teammembers')
        ->leftJoin('timesheets', 'timesheets.created_by', 'teammembers.id')
        ->where('teammembers.status', 1)
        ->whereIn('timesheets.created_by', $excludedIds)
        ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->havingRaw('COUNT(DISTINCT timesheets.id) = COUNT(CASE WHEN timesheets.status = 0 THEN 1 ELSE NULL END)')
        ->get();


    dd($teammemberOnlySave);
    //* today time insert in database /time/ current time in database 'created_at' => now(),
    public function timesheeteditstore(Request $request)
    {
      try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
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

    //* filter on mail days wise

    if ('Friday' == date('l', time()) || 'Saturday' == date('l', time())) {
    }
    //* last week reminder /mail / notification on mail

    // public function handle()
    // {
    //     $teammember =  DB::table('teammembers')
    //         ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.created_at', '<', now()->subWeek())
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
    //     dd($teammember);
    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' =>   $teammember,
    //     );
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = DB::table('timesheetusers')
    //             // get all date of this user
    //             ->where('createdby', $user->id)
    //             ->where('date', '<', now()->subWeeks(1))
    //             ->where(function ($query) {
    //                 $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //                     ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //             })
    //             // ->distinct('date')
    //             ->max('date');

    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }

    //     // dd($teammember);

    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember,
    //     );

    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

//! god code 
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         // $lastSubmissionDate = DB::table('timesheetusers')
    //         //     // get all date of this user
    //         //     ->where('createdby', $user->id)
    //         //     ->where('date', '<', now()->subWeeks(1))
    //         //     ->where('status', '!=', 0)
    //         //     ->where(function ($query) {
    //         //         $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //         //             ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //         //     })
    //         //     // ->distinct('date')
    //         //     ->max('date');
        
    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    public function handle()
    {
        $teammember = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            // ->where('timesheetusers.date', '<', now()->subWeeks(1))
             ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek()) 
            ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();

        // Get the last submission date for each user only sunday and suterday
        foreach ($teammember as $user) {
            $lastSubmissionDate = DB::table('timesheetusers')
                // get all date of this user
                ->where('createdby', $user->id)
                ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
                // ->where('date', '<', now()->subWeeks(1))
                ->where('status', '!=', 0)
                ->where(function ($query) {
                    $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                })
                // ->distinct('date')
                ->max('date');
        
            // Format the date as 'd-m-y'
            // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
            $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

            $user->last_submission_date = $lastSubmissionDate;
        }
        // dd($teammember);
        // Create an array for the Excel export (excluding 'id')
        $excelData = $teammember->filter(function ($user) {
            return !empty($user->last_submission_date);
        })->map(function ($user) {
            return [
                'team_member' => $user->team_member,
                'emailid' => $user->emailid,
                'last_submission_date' => $user->last_submission_date,
            ];
        })->toArray();

        $export = new TimesheetLastWeekExport(collect($excelData));
        $excelFileName = 'Timesheet_last_week.xlsx';
        Excel::store($export, $excelFileName);

        // Modify the data for the email (excluding 'id')
        $emailData = array(
            'subject' => "Timesheet Not filled Last Week",
            'teammember' => $teammember->map(function ($user) {
                return (object) [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                    'last_submission_date' => $user->last_submission_date,
                ];
            }),
        );

        // dd($teammember);

        // Attach the Excel file to the email
        Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
            $msg->to('itsupport_delhi@vsa.co.in');
            $msg->cc('Admin_delhi@vsa.co.in');
            // Attach the Excel file to the email
            $msg->attach(storage_path('app/' . $excelFileName), [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            $msg->subject($emailData['subject']);
        });
    }
    // 222222222222222222
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
        
    //     // Get the last submission date for each user
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = $user->max('date');
            
    //         // Format the date as 'd-m-y'
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
        
    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
        
    //     // Rest of your code...
        
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    
    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '>=', now()->subWeeks(1)->startOfWeek()) // Adjusted start date
    //                 ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())   // Adjusted end date
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id', DB::raw('MAX(timesheetusers.date) as last_submission_date'))
    //         ->groupBy('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->get();
    
    //     // Format the date as 'd-m-y'
    //     $teammembers->transform(function ($user) {
    //         $user->last_submission_date = $user->last_submission_date ? Carbon::parse($user->last_submission_date)->format('d-m-Y') : '';
    //         return $user;
    //     });
    
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammembers->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();
    
    //     // Create and store the Excel file
    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);
    
    //     // Modify the data for the email (excluding 'id')
    //     $emailData = [
    //         'subject' => "Timesheet Not Filled Last Week",
    //         'teammembers' => $teammembers->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     ];
    
    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    

}
    //* success message from controller

    try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
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
    //* auth user

      dd(auth()->user()->teammember_id);
    //* store data in database / s3 problem /path store 
    public function store(Request $request)
    {
        // dd(auth()->user()->teammember_id);
        $request->validate([
            'particular' => 'required',
            'file' => 'required',
        ]);

        try {
            $data = $request->except(['_token']);
            $files = [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public\image\task', $name);
                    $files[] = $name;
                }
            }
            foreach ($files as $filess) {
                // dd($auth()->user()->teammember_id);
                // dd($files); die;
                $s = DB::table('assignmentfolderfiles')->insert([
                    'particular' => $request->particular,
                    'assignmentgenerateid' => $request->assignmentgenerateid,
                    'assignmentfolder_id' =>  $request->assignmentfolder_id,
                    'createdby' =>  auth()->user()->teammember_id,
                    'filesname' => $filess,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', ['message' => $output, 'success' => true]);
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }



    //* Download image on click 
    // !runnig code download image
    public function downloadAll(Request $request)
    {

        $articlefiles = DB::table('assignmentfolderfiles')->where('createdby', auth()->user()->id)->first();

        return response()->download(('backEnd/image/articlefiles/' . $articlefiles->filesname));
    }
    //* Download image on click
    
    //* regarding update in table / insert data in timesheet table  / all update 
    // Start Hare 

    $date = '08-03-2024';
    $id = DB::table('timesheets')->insertGetId(
        [
            'created_by' => 847,
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
        'timesheetid'     =>     $id,
        'date'     =>     date('Y-m-d', strtotime($date)),
        'hour'     =>     0,
        'totalhour' =>      0,
        'assignment_id'     =>     213,
        'partner'     =>     887,
        'createdby' => 847,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
    ]);
    dd('inserted');





  // Start Hare 

  // regarding exam leave apply
    // Start Hare 
    $nextweektimesheet = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->whereBetween('date', ['2024-03-12', '2024-03-29'])
      ->delete();
    // ->get();
    // ->update(['status' => 0]);


    $nextweektimesheet = DB::table('timesheets')
      ->where('created_by', auth()->user()->teammember_id)
      ->whereBetween('date', ['2024-03-12', '2024-03-29'])
      ->delete();
    // ->get();
    // ->update(['status' => 0]);

    $nextweektimesheet = DB::table('timesheetreport')
      ->where('teamid', auth()->user()->teammember_id)
      ->whereBetween('startdate', ['2024-03-12', '2024-03-29'])
      // ->get();
      ->delete();


    dd('hi');

       // $leaves = DB::table('applyleaves')
    //   ->where('applyleaves.createdby', auth()->user()->teammember_id)
    //   ->whereBetween('from', ['2024-03-12', '2024-03-29'])
    //   // ->get();
    //   ->delete();

    // 896
  // Start Hare 
  $nextweektimesheet = DB::table('timesheetusers')
  ->where('createdby', 791)
  ->whereBetween('date', ['2024-04-15', '2024-04-21'])
  // ->delete();
  // ->get();
  ->update(['status' => 0]);


$nextweektimesheet = DB::table('timesheets')
  ->where('created_by', 791)
  ->whereBetween('date', ['2024-04-15', '2024-04-21'])
  // ->delete();
  // ->get();
  ->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheetreport')
  ->where('teamid', 791)
  ->whereBetween('startdate', ['2024-04-15', '2024-04-21'])
  // ->get();
  ->delete();

dd('hi');
  // Start Hare 
  $nextweektimesheet = DB::table('timesheetusers')
  ->where('createdby', auth()->user()->teammember_id)
  ->whereBetween('date', ['2024-03-12', '2024-03-29'])
  ->get();
// ->update(['status' => 0]);


$nextweektimesheet = DB::table('timesheets')
  ->where('created_by', auth()->user()->teammember_id)
  ->whereBetween('date', ['2024-03-11', '2024-03-20'])
  ->get();
// ->update(['status' => 0]);

$nextweektimesheet = DB::table('timesheetreport')
  ->where('teamid', auth()->user()->teammember_id)
  ->whereBetween('startdate', ['2024-03-11', '2024-03-20'])
  ->get();
// ->delete();
dd($nextweektimesheet);
dd('hi');

DB::table('assignmentteammappings')
->update(['status' => 0]);

dd('hi');


//* Start Hare  timesheet delete / timesheet update / regarding timesheet / insert in timesheet 

$nextweektimesheet1 = DB::table('timesheetusers')
->where('createdby', 847)
->whereBetween('date', ['2024-06-17', '2024-06-22'])
// ->get();
->update(['status' => 0]);


$nextweektimesheet2 = DB::table('timesheets')
->where('created_by', 847)
->whereBetween('date', ['2024-06-17', '2024-06-22'])
// ->get();
->update(['status' => 0]);

$nextweektimesheet3 = DB::table('timesheetreport')
->where('teamid', 847)
->where('startdate', '2024-06-17')
// ->get();
->delete();

dd($nextweektimesheet3);

// 22222222222222222222222222222222222222]

$nextweektimesheet1 = DB::table('timesheetusers')
->where('createdby', 847)
->whereBetween('date', ['2024-06-16', '2024-07-24'])
// ->get();
->delete();


$nextweektimesheet2 = DB::table('timesheets')
->where('created_by', 847)
->whereBetween('date', ['2024-06-16', '2024-07-24'])
// ->get();
->delete();

// $nextweektimesheet3 = DB::table('timesheetreport')
//     ->where('teamid', 847)
//     ->where('startdate', '2024-06-17')
//     // ->get();
//     ->delete();


dd('hi');
// 22222222222222222222222222222222222222

// start hare 
// one week data i have practicaly checked
$result = ['2024-05-20', '2024-05-21', '2024-05-22', '2024-05-23', '2024-05-24', '2024-05-25', '2024-05-26'];
// dd($result);
foreach ($result as $date) {
    $id = DB::table('timesheets')->insertGetId(
        [
            'created_by' => auth()->user()->teammember_id,
            'date'     =>    date('Y-m-d', strtotime($date)),
            'month'     =>   date('F', strtotime($date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
        ]
    );
    DB::table('timesheetusers')->insert([
        'timesheetid'     =>     $id,
        'client_id'     =>     29,
        'partner'     =>     887,
        'totalhour' =>      0,
        'assignment_id'     =>     213,
        'date'     =>   date('Y-m-d', strtotime($date)),
        'workitem'     =>     'NA',
        'location'     =>     'NA',
        'date'     =>     date('Y-m-d', strtotime($date)),
        'hour'     =>     0,
        'createdby' => auth()->user()->teammember_id,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
    ]);
}
dd('hi');
// start hare 
// Start Hare 
// Start Hare 
// Start Hare 
// Start Hare 



//* Start Hare update assignmentgenerate_id in timesheet users table using condition 

 // total 135

 $assignments = DB::table('assignmentbudgetings')
 // ->whereBetween('created_at', ['2024-01-01 16:45:30', '2024-03-21 16:45:30'])
 ->whereBetween('created_at', ['2023-09-01 16:45:30', '2023-12-31 16:45:30'])
 ->where('status', 1)
 ->select('assignmentgenerate_id', 'client_id', 'assignment_id', 'created_at')
 ->orderBy('id', 'DESC')
 ->get();

// dd($assignments);

$date = date('Y-m-d', strtotime($assignments[121]->created_at));

$updatedcode =  DB::table('timesheetusers')
 // ->whereBetween('date', [$date, '2024-03-23'])
 // ->whereBetween('date', [$date, '2024-01-06'])
 ->where('client_id', $assignments[121]->client_id)
 ->where('assignment_id', $assignments[121]->assignment_id)
 // ->where('partner', 842)
 // ->where('createdby', 852)
 // ->whereNotIn('createdby', [234, 453])
 // ->get();
 ->update(['assignmentgenerate_id' => $assignments[121]->assignmentgenerate_id]);
// ->update(['assignmentgenerate_id' => 'hi']);

dd($updatedcode);

// dd($assignments);



// Start Hare update assignmentgenerate_id in timesheet users table using condition 
 // dd($teamid);

 $assignments = DB::table('assignmentbudgetings')
 ->whereBetween('created_at', ['2024-01-01 16:45:30', '2024-03-21 16:45:30'])
 ->select('assignmentgenerate_id', 'client_id', 'assignment_id', 'created_at')
 ->orderBy('id', 'DESC')
 ->get();

$date = date('Y-m-d', strtotime($assignments[117]->created_at));

$updatedcode =  DB::table('timesheetusers')
 // ->whereBetween('date', [$date, '2024-03-22'])
 // ->whereBetween('date', [$date, '2024-02-07'])
 ->where('client_id', $assignments[117]->client_id)
 ->where('assignment_id', $assignments[117]->assignment_id)
 // ->where('partner', 842)
 // ->where('createdby', 856)
 // ->whereNotIn('createdby', [234, 453])
 // ->get();
 ->update(['assignmentgenerate_id' => $assignments[117]->assignmentgenerate_id]);
// ->update(['assignmentgenerate_id' => 'hi']);

dd($updatedcode);
// dd($assignments);

// dd($assignments[0]->assignmentgenerate_id);
// dd($assignments[0]->client_id);
// dd($assignments[0]->assignment_id);
// dd($assignments[0]->created_at);


// Start Hare update assignmentgenerate_id in timesheet users table for single user

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
dd($nextweektimesheets->totaltime);
dd($nextweektimesheets->enddate);
dd($nextweektimesheets->startdate);
dd($nextweektimesheets->teamid);

$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', ['2024-03-04', '2024-03-09'])
  ->where('createdby', 847)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}
// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);

$updateddata = DB::table('timesheetreport')
  ->where('teamid', 847)
  ->where('startdate', '2024-03-04')
  ->where('enddate', '2024-03-09')
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

dd($updateddata);
}
// Start Hare update for single user

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->where('createdby', $nextweektimesheets->teamid)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}


// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);


$updateddata = DB::table('timesheetreport')
  ->where('teamid', 847)
  ->where('startdate', '2024-03-04')
  ->where('enddate', '2024-03-09')
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

dd($updateddata);
}

//* regarding multiple user it is good code 
// Start Hare 
$filename = DB::table('assignmentfolderfiles')
->select('filesname', 'id')
->get();

foreach ($filename as $filenames) {
$users = DB::table('assignmentfolderfiles')
  ->where('id', $filenames->id)
  ->update(['filenameunique' => $filenames->filesname]);
}
// Start Hare
$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100046])
->select('id', 'client_code')
->get();
$assignmentnumb = "10375";
foreach ($filename as $filenames) {
$assignmentnumbers = $assignmentnumb + 1;
$updateddata = DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumbers]);
}
// Start Hare
$currentYear = date('Y');
$approvedleavesvalue = DB::table('applyleaves')
  ->where('createdby', auth()->user()->teammember_id)
  ->where('status', 1)
  ->whereYear('from',  $currentYear)
  ->get();

$leaveDurations = [];
foreach ($approvedleavesvalue as $approvedleavesvalues) {
  $to = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->to ?? '');
  $from = Carbon::createFromFormat('Y-m-d', $approvedleavesvalues->from);

  $diff_in_days = $to->diffInDays($from) + 1;

  $holidaycount = DB::table('holidays')
    ->where('startdate', '>=', $approvedleavesvalues->from)
    ->where('enddate', '<=', $approvedleavesvalues->to)
    ->count();

  $leaveDurationcount = $diff_in_days - $holidaycount;
  $leaveDurations[] = $leaveDurationcount;
}

$totalLeaveDuration = array_sum($leaveDurations);
dd($totalLeaveDuration);
// Start Hare

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
// dd($nextweektimesheets, 'foreech');
$timesheetdata = DB::table('timesheetusers')
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->where('createdby', $nextweektimesheets->teamid)
  // ->select('createdby', 'partner')
  ->select('partner')
  ->distinct()
  ->get()->toArray();


$zipfoldername1 = [];
foreach ($timesheetdata as $timesheetdatas) {
  $zipfoldername1[] = $timesheetdatas->partner;
}
// dd($zipfoldername1);

// DB::table('timesheetreport')->insert([
//   'teamid' => 847,
//   'partnerid' => json_encode($partners), // Convert array to JSON string
//   'created_at'                =>      date('y-m-d H:i:s'),
// ]);

$updateddata = DB::table('timesheetreport')
  ->where('teamid', $nextweektimesheets->teamid)
  ->where('startdate', $nextweektimesheets->startdate)
  ->where('enddate', $nextweektimesheets->enddate)
  // ->get();
  ->update(['partnerid' => $zipfoldername1]);

// dd($updateddata);
}

// Start Hare 
$teams = DB::table('teammembers')
->where('status', 0)
->get();

foreach ($teams as $team) {
$users = DB::table('users')
    ->where('teammember_id', $team->id)
    // ->where('status', 0)
    ->get();
dd($team);
}
// Start Hare 

$nextweektimesheet = DB::table('timesheetreport')
->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
// ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
->whereNull('partnerid')
->select('id', 'teamid', 'startdate', 'enddate', 'totaltime')
->latest()
->get();
// ->count();
// dd($nextweektimesheet, 'hi');

foreach ($nextweektimesheet as $nextweektimesheets) {
// 44444444444444444444444444444444444444444444444444444444444
// dd($nextweektimesheets, 'hi');

$week =  date('d-m-Y', strtotime($nextweektimesheets->startdate))  . ' to ' . date('d-m-Y', strtotime($nextweektimesheets->enddate));

$co = DB::table('timesheetusers')
  // ->where('createdby', auth()->user()->teammember_id)
  ->where('createdby', $nextweektimesheets->teamid)
  // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
  ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
  ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
  ->groupBy('partner')
  ->get();

foreach ($co as $codata) {
  DB::table('timesheetreport')->insert([
    'teamid'       =>     $nextweektimesheets->teamid,
    'week'       =>     $week,
    'totaldays'       =>     $codata->row_count,
    'totaltime' =>  $codata->total_hours,
    'partnerid'  => $codata->partner,
    'startdate'  => $nextweektimesheets->startdate,
    'enddate'  => $nextweektimesheets->enddate,
    // 'created_at'                =>       date('y-m-d'),
    'created_at'                =>      date('y-m-d H:i:s'),
  ]);
}

$deletedata = DB::table('timesheetreport')
  ->where('id', $nextweektimesheets->id)
  // ->get();
  ->delete();


// final updated code 

$nextweektimesheet = DB::table('timesheetreport')
      ->whereBetween('created_at', ['2023-12-21 20:14:34', '2024-03-25 20:19:53'])
      // ->whereBetween('startdate', ['2023-12-11', '2024-03-25'])
      ->whereNull('partnerid')
      ->select('id', 'teamid', 'startdate', 'enddate', 'totaltime', 'created_at')
      // ->latest()
      ->get();
    // ->count();
    // dd($nextweektimesheet, 'hi');

    foreach ($nextweektimesheet as $nextweektimesheets) {
      // 44444444444444444444444444444444444444444444444444444444444


      $week =  date('d-m-Y', strtotime($nextweektimesheets->startdate))  . ' to ' . date('d-m-Y', strtotime($nextweektimesheets->enddate));

      $co = DB::table('timesheetusers')
        // ->where('createdby', auth()->user()->teammember_id)
        // ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
        ->where('createdby', $nextweektimesheets->teamid)
        ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
        ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
        ->groupBy('partner')
        ->get();

      foreach ($co as $codata) {
        DB::table('timesheetreport')->insert([
          'teamid'       =>     $nextweektimesheets->teamid,
          'week'       =>     $week,
          'totaldays'       =>     $codata->row_count,
          'totaltime' =>  $codata->total_hours,
          'partnerid'  => $codata->partner,
          'startdate'  => $nextweektimesheets->startdate,
          'enddate'  => $nextweektimesheets->enddate,
          // 'created_at'                =>       date('y-m-d'),
          'created_at'                =>      $nextweektimesheets->created_at,
        ]);
      }


      $deletedata = DB::table('timesheetreport')
        ->where('id', $nextweektimesheets->id)
        // ->get();
        ->delete();

      // dd($co);

      // 444444444444444444444444444444444444444444444444444444444444444444





      // // dd($nextweektimesheets, 'foreech');
      // $timesheetdata = DB::table('timesheetusers')
      //   ->whereBetween('date', [$nextweektimesheets->startdate, $nextweektimesheets->enddate])
      //   ->where('createdby', $nextweektimesheets->teamid)
      //   // ->select('createdby', 'partner')
      //   ->select('partner')
      //   ->distinct()
      //   ->get()->toArray();


      // $zipfoldername1 = [];
      // foreach ($timesheetdata as $timesheetdatas) {
      //   $zipfoldername1[] = $timesheetdatas->partner;
      // }
      // // dd($zipfoldername1);

      // // DB::table('timesheetreport')->insert([
      // //   'teamid' => 847,
      // //   'partnerid' => json_encode($partners), // Convert array to JSON string
      // //   'created_at'                =>      date('y-m-d H:i:s'),
      // // ]);

      // $updateddata = DB::table('timesheetreport')
      //   ->where('teamid', $nextweektimesheets->teamid)
      //   ->where('startdate', $nextweektimesheets->startdate)
      //   ->where('enddate', $nextweektimesheets->enddate)
      //   // ->get();
      //   ->update(['partnerid' => $zipfoldername1]);

      // // dd($updateddata);
    }
      //  22222222222222222222222222222222
//* regarding update 
// Start Hare 
    $update = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->first();

  if ($update) {
    $result = $update->teamhour + $request->hour[$i];
    DB::table('assignmentmappings')
      ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
      ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
      ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
      ->update(['teamhour' => DB::raw($result)]);
  }

  dd($result);
  // Start Hare 
// Start hare regarding timesheet check

$nextweektimesheet = DB::table('timesheetusers')
->where('createdby', 912)
->whereBetween('date', ['2024-01-08', '2024-01-13'])
->get();

dd($nextweektimesheet);
// Start hare
$team = DB::table('teammembers')
->where('status', 1)
->whereNotNull('leavingdate')
// ->get();
->update(['leavingdate' => NULL]);
dd($team);



// Start hare regarding client code update 
$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100046])
->select('id', 'client_code')
->get();

$assignmentnumb = "10375";
foreach ($filename as $filenames) {
$assignmentnumbers = $assignmentnumb + 1;
$updateddata = DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumbers]);
}
dd('hi');

$filename = DB::table('clients')
->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100047])
->select('id', 'client_code')
->get();
$assignmentnumb = 10375;
foreach ($filename as $filenames) {
$assignmentnumb += 1;
DB::table('clients')
  ->where('id', $filenames->id)
  ->update(['client_code' => $assignmentnumb]);
}
dd('hi');

// Start hare
$result = [930, 797, 779, 777, 917, 910];
foreach ($result as $userId) {
  $sumhour = DB::table('timesheetusers')
    ->where('assignmentgenerate_id', 'WAV100526')
    ->where('createdby', $userId)
    ->sum('totalhour');

  DB::table('assignmentteammappings')
    ->where('assignmentmapping_id', 541)
    ->where('teammember_id', $userId)
    ->update(['teamhour' => $sumhour]);
}


$leadpartnersum = DB::table('timesheetusers')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('createdby', 836)
  ->sum('totalhour');


DB::table('assignmentmappings')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('leadpartner', 836)
  ->update(['leadpartnerhour' => $leadpartnersum]);

$otherpartnersum = DB::table('timesheetusers')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('createdby', 838)
  ->sum('totalhour');

DB::table('assignmentmappings')
  ->where('assignmentgenerate_id', 'WAV100526')
  ->where('otherpartner', 838)
  ->update(['otherpartnerhour' => $otherpartnersum]);

dd('hi');
// Start hare
    // $filename = DB::table('clients')
    //   ->whereBetween(DB::raw('CAST(client_code AS UNSIGNED)'), [100001, 100047])
    //   ->select('id', 'client_code')
    //   ->get();
    // $assignmentnumb = 10375;
    // foreach ($filename as $filenames) {
    //   $assignmentnumb += 1;
    //   DB::table('clients')
    //     ->where('id', $filenames->id)
    //     ->update(['client_code' => $assignmentnumb]);
    // }
    // dd('hi');
// Start hare
  //  22222222222222222222222222222222
}
            // ----------------------------- 29 sep 2023 joining date------------------------------------------


            // -----------------------------Shahid coding start------------------------------------------

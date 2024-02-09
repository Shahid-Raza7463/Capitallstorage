<?php

class ZipController extends Controller
{
//*
//*
//*
//*
//* 


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
//* regarding where clouse / 
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
//* regarding date 
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


//* filter functionality 2

  // it is implemented submitte timesheet tab on admin and patner 
  public function filterDataAdmin(Request $request)
  {

    // for patner 
    if (auth()->user()->role_id == 13) {

      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');

      // submitted teamtimesheet tab on patner then use this below query 

      // $query = DB::table('timesheetreport')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      //   ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      //   ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
      //   ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      //   ->latest();

      // submitted timesheet tab on patner 
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
    // for Admin 
    else {
      // dd($request);

      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
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
    // dd($filteredData);
    return response()->json($filteredData);
  }

//* filter functionality 1

 // applyleave filter implemented
 public function filterDataAdmin(Request $request)
 {
   if (auth()->user()->role_id == 13) {
     // apply leave filter on patner 
     $teamname = $request->input('employee');
     $leavetype = $request->input('leave');
     // if ($startdate != null || $endtdate != null) {
     $startdate = $request->input('start');
     $startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
     $endtdate = $request->input('end');
     $endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));
     // }
     $statusdata = $request->input('status');

     $query  = DB::table('applyleaves')
       ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
       ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
       ->leftjoin('teammembers as approvername', 'approvername.id', 'applyleaves.approver')
       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
       ->where('applyleaves.approver', auth()->user()->teammember_id)
       ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');


     // According employee
     if ($teamname) {
       $query->where('applyleaves.createdby', $teamname);
     }
     // According leave type
     if ($leavetype) {
       $query->where('applyleaves.leavetype', $leavetype);
     }

     // According Status 
     if ($statusdata != null) {
       if ($statusdata == 0) {
         $query->where('applyleaves.status', 0);
       } elseif ($statusdata == 1) {
         $query->where('applyleaves.status', 1);
       } elseif ($statusdata == 2) {
         $query->where('applyleaves.status', 2);
       }
     }

     // According strat date and end date 
     if ($teamname == null && $leavetype == null && $statusdata == null) {
       $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1]);
     }
     // According stratdate and enddate and employee
     if ($startdate != null && $endtdate != null && $teamname != null) {
       $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1])
         ->where('applyleaves.createdby', $teamname);
     }

     // According employee and leave type
     if ($teamname && $leavetype) {
       $query->where(function ($q) use ($teamname, $leavetype) {
         $q->where('applyleaves.createdby', $teamname)
           ->where('applyleaves.leavetype', $leavetype);
       });
     }
     // According Status and teamname
     if ($statusdata != null && $teamname != null) {
       if ($statusdata == 0 && $teamname != null) {
         $query->where('applyleaves.status', 0)
           ->where('applyleaves.createdby', $teamname);
       } elseif ($statusdata == 1 && $teamname != null) {
         $query->where('applyleaves.status', 1)
           ->where('applyleaves.createdby', $teamname);
       } elseif ($statusdata == 2 && $teamname != null) {
         $query->where('applyleaves.status', 2)
           ->where('applyleaves.createdby', $teamname);
       }
     }

     // According Status and leave type 
     if ($statusdata != null && $leavetype != null) {
       if ($statusdata == 0 && $leavetype != null) {
         $query->where('applyleaves.status', 0)
           ->where('applyleaves.leavetype', $leavetype);
       } elseif ($statusdata == 1 && $leavetype != null) {
         $query->where('applyleaves.status', 1)
           ->where('applyleaves.leavetype', $leavetype);
       } elseif ($statusdata == 2 && $leavetype != null) {
         $query->where('applyleaves.status', 2)
           ->where('applyleaves.leavetype', $leavetype);
       }
     }
   } else {
     // apply leave filter on admin 
     $teamname = $request->input('employee');
     // dd($teamname);
     $leavetype = $request->input('leave');
     // if ($startdate != null || $endtdate != null) {
     $startdate = $request->input('start');
     $startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
     $endtdate = $request->input('end');
     $endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));
     // }
     $statusdata = $request->input('status');

     $startperioddata = $request->input('startperiod');
     $endperioddata = $request->input('endperiod');

     $query  = DB::table('applyleaves')
       ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
       ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
       ->leftjoin('teammembers as approvername', 'approvername.id', 'applyleaves.approver')
       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
       ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');


     // According leave periode 
     if ($startperioddata && $endperioddata) {
       // $query->where('applyleaves.from', $startperioddata);
       // $query->whereBetween('applyleaves.from', [$startperioddata, $endperioddata]);
       $query->where('applyleaves.from', '>=', $startperioddata)
         ->where('applyleaves.to', '<=', $endperioddata);
     }

     // According employee
     if ($teamname) {
       $query->where('applyleaves.createdby', $teamname);
     }
     // According leave type
     if ($leavetype) {
       $query->where('applyleaves.leavetype', $leavetype);
     }

     // According Status 
     if ($statusdata != null) {
       if ($statusdata == 0) {
         $query->where('applyleaves.status', 0);
       } elseif ($statusdata == 1) {
         $query->where('applyleaves.status', 1);
       } elseif ($statusdata == 2) {
         $query->where('applyleaves.status', 2);
       }
     }

     // According strat date and end date 
     if ($teamname == null && $leavetype == null && $statusdata == null && $startperioddata == null && $endperioddata == null) {
       $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1]);
     }
     // According stratdate and enddate and employee
     if ($startdate != null && $endtdate != null && $teamname != null) {
       $query->whereBetween('applyleaves.created_at', [$startdate1, $endtdate1])
         ->where('applyleaves.createdby', $teamname);
     }

     // According employee and leave type
     if ($teamname && $leavetype) {
       $query->where(function ($q) use ($teamname, $leavetype) {
         $q->where('applyleaves.createdby', $teamname)
           ->where('applyleaves.leavetype', $leavetype);
       });
     }
     // According Status and teamname
     if ($statusdata != null && $teamname != null) {
       if ($statusdata == 0 && $teamname != null) {
         $query->where('applyleaves.status', 0)
           ->where('applyleaves.createdby', $teamname);
       } elseif ($statusdata == 1 && $teamname != null) {
         $query->where('applyleaves.status', 1)
           ->where('applyleaves.createdby', $teamname);
       } elseif ($statusdata == 2 && $teamname != null) {
         $query->where('applyleaves.status', 2)
           ->where('applyleaves.createdby', $teamname);
       }
     }

     // According Status and leave type 
     if ($statusdata != null && $leavetype != null) {
       if ($statusdata == 0 && $leavetype != null) {
         $query->where('applyleaves.status', 0)
           ->where('applyleaves.leavetype', $leavetype);
       } elseif ($statusdata == 1 && $leavetype != null) {
         $query->where('applyleaves.status', 1)
           ->where('applyleaves.leavetype', $leavetype);
       } elseif ($statusdata == 2 && $leavetype != null) {
         $query->where('applyleaves.status', 2)
           ->where('applyleaves.leavetype', $leavetype);
       }
     }
   }
   $filteredData = $query->get();
   // if holyday days occure error in future then find holiday according blade file and merge data with $filteredData 
   return response()->json($filteredData);
 }

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
  // "2023-11-13, 2023-11-14"
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

//* holidays count
// app\Http\Controllers\ApplyleaveController.php in update function 

$holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
->where('enddate', '<=', $team->to)
->count();
dd($holidaycount);
//* regarding redirect / regarding message /success message 

$output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));
$output = array('msg' => "Timesheet Submit Successfully till $previousMondayFormatted to $nextSaturdayFormatted ");
$output = array('msg' => "Fill the timesheet Previous Week: $formattedPreviousSaturday");
$output = array('msg' => 'Please Approve Latest Timesheet Request');
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
    //*order by  desc / DESC/ASC/ Ascending  order / Descending 

    $getauthh =  DB::table('timesheetusers')
    ->where('createdby', auth()->user()->teammember_id)
    ->orderBy('id', 'ASC')->paginate(10);
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

    //*  week days in numbric/ regarding months / weeks days / regarding date and time  /regarding date 

//* in blade file 

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


       // now() function 
    //    12
        dd(now()->month); 
        // 2023
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
       // 2024-01-16 00:46:21.610590
 
       $month = $currentDate->format('F');
       // "January"
       $year = $currentDate->format('Y');
       // "2024"


      //* date() function 
      // Formats the current date and time as a string
      $currentDateTime = date('Y-m-d H:i:s'); 
      // Formats a specific date
      $formattedDate = date('Y-m-d', strtotime('2023-12-01')); 
      // Convert a string to a Unix timestamp
      $timestamp = strtotime('2023-12-01'); 
      // Format the Unix timestamp
      $formattedDate = date('Y-m-d', $timestamp); 
      
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
}
            // ----------------------------- 29 sep 2023 joining date------------------------------------------


            // -----------------------------Shahid coding start------------------------------------------

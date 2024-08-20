<?php

namespace App\Http\Controllers;

use App\Models\Assignmentfolderfile;
use Illuminate\Http\Request;
use DB;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Storage;
use App\Jobs\CreateAllzip;
use Illuminate\Support\Facades\Log;
class AssignmentfolderfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 public function __construct()
    {
        $this->middleware('auth');
    }
	 // All asignment folder download in the zip formate 
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
                    if ($foldername->filesname != null) {
                        // Replace server path hare 
                        $filePath = Storage::disk('s3')->get($assignmentgenerateid . '/' . $foldername->filesname);
                    }
		  if ($filePath) {
            $zip->addFromString($foldername->filesname, $filePath);
        } else {
            return '<h1>File Not Found</h1>';
        }
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
	
		// zip download 
       public function zipfile(Request $request, $assignmentfolder_id)
{
    if (auth()->user()->role_id == 11) {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($fileName as $file) {
                $filePath = Storage::disk('s3')->temporaryUrl(
                    $generateid->assignmentgenerateid . '/' . $file->filesname, now()->addMinutes(10)
                );

                $fileContents = file_get_contents($filePath);

                if ($fileContents !== false) {
                    $zip->addFromString($file->filesname, $fileContents);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }
            $zip->close();

            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
            ];

            return response()->stream(
                function () use ($zipFileName) {
                    readfile($zipFileName);
                    unlink($zipFileName);
                },
                200,
                $headers
            );
        } else {
            return '<h1>Failed to create zip file</h1>';
        }
    } else {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive;

        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            foreach ($fileName as $file) {
                $filePath = Storage::disk('s3')->temporaryUrl(
                    $generateid->assignmentgenerateid . '/' . $file->filesname, now()->addMinutes(10)
                );

                $fileContents = file_get_contents($filePath);

                if ($fileContents !== false) {
                    $zip->addFromString($file->filesname, $fileContents);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }
            $zip->close();

            return response()->download($zipFileName)->deleteFileAfterSend(true);
        } else {
            return '<h1>Failed to create zip file</h1>';
        }
    }
}

	
	
	// new download all zip file code 
	  public function assignmentfoldercreate(Request $request, $assignmentgenerateid)
    {
        // dd('rrr');
        return view('backEnd.assignmentfolder.zipcreatedwaiting', compact('assignmentgenerateid'));
    }
	
 public function createdzipdownload(Request $request, $assignmentgenerateid)
     {
        // zip file is stored
        $zipFilePath =  storage_path('app/public/image/task/') . $assignmentgenerateid . '.zip';
      
        // Check if the zip file exists
        if (file_exists($zipFilePath)) {
            // Set the appropriate headers for a downloadable file
            $headers = [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . $assignmentgenerateid . '.zip"',
            ];

            // Return the response for download and delete the file after sending
            return response()->download($zipFilePath, $assignmentgenerateid . '.zip', $headers)->deleteFileAfterSend(true);
        } else {
            // If the zip file does not exist, return a response indicating the file is not found
            // return response()->json(['error' => 'File not found'], 404);
            $message = 'You have already downloaded zip file';
            return view('backEnd.assignmentfolder.zipcreatedwaiting', compact('message', 'assignmentgenerateid'));
        }
    }
	
	  public function createzipfolder(Request $request)
    {
    	$assignmentfoldername = DB::table('assignmentfolders')
    ->leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
    ->where('assignmentfolders.assignmentgenerateid', $request->assignmentgenerateid)
    ->select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
    ->get();
// dd($assignmentfoldername);
    $data = array(
        'assignmentfoldername' => $assignmentfoldername ??'',
        'assignmentgenerateid'   =>$request->assignmentgenerateid,
      );

       CreateAllzip::dispatch($data)->onQueue('CreateZip');
    }
	
	
    public function index_list($id)
    {
	//	dd($id);
        $foldername = DB::table('assignmentfolders')->where('id',$id)->first();
		 $financial =  DB::table('assignmentbudgetings')->leftjoin('financialstatementclassifications','financialstatementclassifications.assignment_id','assignmentbudgetings.assignment_id')
       ->where('assignmentbudgetings.assignmentgenerate_id', $foldername->assignmentgenerateid)
       ->select('financialstatementclassifications.id','financialstatementclassifications.financial_name')
   ->get();
          $assignmentfolderfile = DB::table('assignmentfolderfiles')
        ->leftjoin('teammembers','teammembers.id','assignmentfolderfiles.createdby')
        ->where('assignmentfolderfiles.assignmentfolder_id',$id)
			->where('assignmentfolderfiles.status',1)
            ->select('assignmentfolderfiles.*','teammembers.team_member','teammembers.staffcode')->latest()->get();
		   $assignmentbudgeting = DB::table('assignmentbudgetings')
			   ->where('assignmentgenerate_id',$foldername->assignmentgenerateid)->first();
		
        return view('backEnd.assignmentfolderfile.index',compact('assignmentbudgeting','assignmentfolderfile','id','foldername','financial'));
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
	//dd($request);
        $request->validate([
            'particular' => 'required',
             'file' => 'required',
        ]);

        try {
            $data=$request->except(['_token']);
            $files = [];
            if($request->hasFile('file'))
            {
                foreach ($request->file('file') as $file) {
				 $realname = $file->getClientOriginalName();
					 $name = time().$realname;
                //    $destinationPath = storage_path('app/backEnd/image/clientfile');
                 //   $name = $file->getClientOriginalName();
                 //  $s = $file->move($destinationPath, $name);
                         //  dd($s); die;
					  $path = $file->storeAs($request->assignmentgenerateid,$name,'s3');
                         $files[] = [
                        'name' => $name,
						'realname' => $realname,
                        // Get the file size in bytes
                        // 'size' => $file->getSize(),
                        // Get the file size in kb aur blade per kb mb and gb me convert kar le 
                        'size' => round($file->getSize() / 1024, 2),

                    ];
                 
                }
            }
            foreach($files as $filess )
            {
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function show(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignmentfolderfile $assignmentfolderfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignmentfolderfile  $assignmentfolderfile
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
  {
    //  dd($id);
    try {
   DB::table('assignmentfolderfiles')->where('id',$id)->update([	

        'status'   =>   0,

      ]);
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
}

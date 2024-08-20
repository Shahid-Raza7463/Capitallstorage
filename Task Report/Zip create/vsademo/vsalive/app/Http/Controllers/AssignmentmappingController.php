<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignmentmapping;
use App\Models\Assignmentbudgeting;
use App\Models\Assignmentteammapping;
use App\Models\Assignment;
use App\Models\Teammember;
use App\Models\Client;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
class AssignmentmappingController extends Controller
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
       public function index()
       {
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12 || auth()->user()->role_id == 18) {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                //  ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                // ->where('clients.status',1)
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')->distinct()->get();
            //   dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        } elseif (auth()->user()->role_id == 13) {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->where(function ($query) {
                    $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                        ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                })
                ->where('assignmentbudgetings.status', 1)
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                ->distinct()->get();
            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        } elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                // ->where('clients.status', 0)
				->whereNotIn('clients.id', [33,32,34,29])
                ->where('assignmentbudgetings.status', 1)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        }
        else {
            $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

                ->select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
				->whereNotIn('clients.id', [33,32,34,29])
                ->where('clients.status', 1)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)->distinct()->get();

            return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
        }
    }
    public function clientassignmentList($id)
    {
		if(auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 99){
			  $assignmentmappingData = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
            ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
         ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
         ->where('clients.id',$id)
          ->select('assignmentmappings.year')->distinct()->get();
           // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist',compact('assignmentmappingData','id'));
           
		}
      elseif(auth()->user()->role_id == 11 || auth()->user()->role_id == 12){
            $assignmentmappingData = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
            ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
         ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
         ->where('clients.id',$id)
          ->select('assignmentmappings.year')->distinct()->get();
           // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist',compact('assignmentmappingData','id'));
           
        }
        elseif(auth()->user()->role_id == 13){
  //  $authid =Client::where('leadpartner', auth()->user()->teammember_id)->select('leadpartner')->pluck('leadpartner')->first();
     //     dd($authid);
            $assignmentmappingData = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
            ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
          //  ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
            ->select('assignmentmappings.year')
          ->where('clients.id', $id)
            ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                      ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->distinct()->get();
     // dd($assignmentmappingData);
            return view('backEnd.assignmentmapping.assignmentlist',compact('assignmentmappingData','id'));
           
        }
        else {
          $assignmentmappingData = DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings','assignmentbudgetings.assignmentgenerate_id','assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients','clients.id','assignmentbudgetings.client_id')
                ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')
          ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                ->select('assignmentmappings.year')
                ->where('clients.id',$id)->where('assignmentteammappings.teammember_id',auth()->user()->teammember_id)->distinct()->get();
            //  dd($assignmentmappingData);
                return view('backEnd.assignmentmapping.assignmentlist',compact('assignmentmappingData','id'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function yearWise(Request $request)
      {
       if (auth()->user()->role_id == 11) {
            $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
                ->orderBy('team_member', 'asc')->get();

            $clientid = $request->clientid;
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignmentbudgetings.assignmentname',
                    'assignments.assignment_name',
                    'clients.client_name'
                )->distinct()->get();
            return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid', 'partner'));
        }  elseif (auth()->user()->role_id == 13) {
            $clientid = $request->clientid;
            $assigned =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignments.assignment_name',
                    'clients.client_name',
                    'assignmentbudgetings.assignmentname'
                )->distinct()->get();

            $otherassigned =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignments.assignment_name',
                    'clients.client_name',
                    'assignmentbudgetings.assignmentname'
                )->distinct()->get();
            return view('backEnd.assignmentmapping.yearwisepartnerlist', compact('assigned', 'otherassigned', 'clientid'));
        } else {
            // assrejected
            $clientid = $request->clientid;
            $assignmentmappingData =  DB::table('assignmentmappings')
                ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->where('clients.id', $request->clientid)
                ->where('assignmentmappings.year', $request->year)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                ->where('assignmentteammappings.status', 1)
                ->select(
                    'assignmentmappings.*',
                    'assignmentbudgetings.duedate',
                    'assignmentbudgetings.assignmentname',
                    'assignments.assignment_name',
                    'clients.client_name'
                )->distinct()->get();
            // assrejected
            return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
        }
    }

    public function create(Request $request)
   {


        $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
            ->orderBy('team_member', 'asc')->get();
        $teammember = Teammember::where('status', '1')->whereIn('role_id', [14, 15])->with('title', 'role')
            ->orderBy('team_member', 'asc')->get();
        //dd($teammember);
        if ($request->ajax()) {


            if (isset($request->category_id)) {
                echo "<option>Please Select One</option>";

                $assignments = Assignment::leftJoin('assignmentbudgetings', function ($join) {
                    $join->on('assignments.id', '=', 'assignmentbudgetings.assignment_id');
                })->leftJoin('assignmentmappings', function ($join) {
                    $join->on('assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id');
                })
                    ->where('assignmentbudgetings.client_id', $request->category_id)
                    // get data only that is not matches assignmentmappings.assignmentgenerate_id from assignmentbudgetings table
                    ->whereNull('assignmentmappings.assignmentgenerate_id')
                    ->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate', 'assignmentbudgetings.assignmentname')
                    ->get();

                foreach ($assignments as $sub) {
                    echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '( ' . $sub->assignmentgenerate_id . ' )' . '( ' . $sub->assignmentname . ' )' . "</option>";
                }
            }
        } else {
            if (auth()->user()->role_id == 11 || auth()->user()->role_id == 12) {
                $client = Client::where('status', 1)->latest()->get();

                $assignment = Assignment::where('status', '1')
                    ->whereNotIn('id',  [214, 215])->orderBy('assignment_name')->get();

                $clientss = Client::activeClient()->orderBy('client_name')->orWhere('clients.leadpartner', auth()->user()->teammember_id)->orWhere('clients.createdbyadmin_id', auth()->user()->id)->orWhere('clients.updatedbyadmin_id', auth()->user()->id)->select('clients.*')->get();

                return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner', 'assignment', 'clientss'));
            } else {
                $client = DB::table('assignmentbudgetings')
                    ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    ->Where('assignmentbudgetings.created_by', auth()->user()->id)
                    ->select('clients.client_name', 'clients.id')
                    ->distinct()->get();


                $assignment = Assignment::where('status', '1')
                    ->whereNotIn('id',  [214, 215])->orderBy('assignment_name')->get();

                $clientss = Client::activeClient()->orderBy('client_name')->orWhere('clients.leadpartner', auth()->user()->teammember_id)->orWhere('clients.createdbyadmin_id', auth()->user()->id)->orWhere('clients.updatedbyadmin_id', auth()->user()->id)->select('clients.*')->get();

                //	DB::table('clients')->
                //  orWhere('clients.leadpartner',auth()->user()->teammember_id)->
                //  orWhere('clients.createdbyadmin_id',auth()->user()->id)->
                //	 orWhere('clients.updatedbyadmin_id',auth()->user()->id)->
                //   select('clients.client_name','clients.id')->get();

                return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner', 'assignment', 'clientss'));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
    {
        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",
            'teammember_id.*' => "required",
            'assignmentname' => "required",
            'type.*' => "required"
        ]);
        // Assignment budgeting start 
        $client_id = $request->input('client_id', null);
        $assignment_id = $request->input('assignment_id', null);
        $assignmentname = $request->input('assignmentname', null);

        if ($client_id != null && $assignment_id != null  && $assignmentname != null) {

            $data = $request->except(['_token', 'periodstart', 'periodend', 'roleassignment', 'esthours', 'stdcost', 'estcost', 'fees', 'leadpartner', 'otherpartner', 'teammember_id', 'type']);
            $data['created_by'] = auth()->user()->id;
            $clientcode = DB::table('clients')->where('id', $request->client_id)->first();
            $assignmentgenerateid = strtoupper(substr($clientcode->client_name, 0, 3));


            $assign = Assignmentbudgeting::latest()->get();

            if ($assign->isEmpty()) {
                $assignmentnumbers = '100001';
            } else {
                $assignmentgenerateall = DB::table('assignmentmappings')->pluck('assignmentgenerate_id')->toArray();

                function extractDigits($string)
                {
                    preg_match_all('/\d+/', $string, $matches);
                    return implode('', $matches[0]);
                }
                $assignmentNumbersDigits = array_map(function ($assignmentgenerate_id) {
                    return extractDigits($assignmentgenerate_id);
                }, $assignmentgenerateall);

                $minAssignmentNumber = 100001;
                $maxAssignmentNumber = 100529;

                $allPossibleAssignmentNumbers = range($minAssignmentNumber, $maxAssignmentNumber);
                $missingAssignmentNumbers = array_diff($allPossibleAssignmentNumbers, $assignmentNumbersDigits);
                unset($missingAssignmentNumbers[260]);


                // if (!empty($missingAssignmentNumbers)) {
                if (!empty($missingAssignmentNumbers)) {
                    $keys = array_keys($missingAssignmentNumbers);
                    $assignmentnumbers = $missingAssignmentNumbers[$keys[0]];
                } else {
                    // $assignmentnumb = Assignmentbudgeting::latest()->first()->assignmentnumber;
                    // dd($assignmentnumb);

                    $assignmentnumb = Assignmentbudgeting::max('assignmentnumber');

                    if ($assignmentnumb ==  null) {
                        $assignmentnumbers = '100001';
                    } else {
                        $assignmentnumbers = $assignmentnumb + 1;

                        $previouschck = DB::table('assignmentbudgetings')
                            ->where('assignmentnumber', $assignmentnumbers)
                            ->first();

                        if ($previouschck != null) {
                            $output = array('msg' => 'You already created assignment.');
                            return back()->with('success', $output);
                        }
                    }
                }
            }
            // dd($assignmentnumbers);
            $assignmentgenerate = $assignmentgenerateid . $assignmentnumbers;

            if (!empty($missingAssignmentNumbers)) {
                $previouschck = DB::table('assignmentmappings')
                    ->where('assignmentgenerate_id', $assignmentgenerate)
                    ->first();

                if ($previouschck != null) {
                    $output = array('msg' => 'You have already created assignment.');
                    return back()->with('success', $output);
                }
            }

            // Storage::disk('s3')->makeDirectory($assignmentgenerate);
            $data['assignmentgenerate_id'] = $assignmentgenerate;
            $data['assignmentnumber'] = $assignmentnumbers;



            DB::table('assignmentbudgetings')->insert([
                'client_id' => $data['client_id'],
                'assignment_id' => $data['assignment_id'],
                'assignmentname' => $data['assignmentname'],
                'duedate' => $data['duedate'],
                'created_by' => $data['created_by'],
                'assignmentgenerate_id' => $data['assignmentgenerate_id'],
                'assignmentnumber' => $data['assignmentnumber'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        // Assignment budgeting end


        $assignment_name = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();

        $request->except(['_token']);

        $id = DB::table('assignmentmappings')->insertGetId([
            'assignmentgenerate_id'         =>     $assignmentgenerate,
            'periodstart'         =>     $request->periodstart,
            'periodend'         =>     $request->periodend,
            'year'         =>     Carbon::parse($request->periodend)->year,
            'roleassignment'                =>      $request->roleassignment,
            'assignment_id'         =>     $request->assignment_id,
            'esthours'            =>       $request->esthours,
            'leadpartner'            =>       $request->leadpartner,
            'otherpartner'            =>       $request->otherpartner,
            'stdcost'            =>       $request->stdcost,
            'estcost'            =>       $request->estcost,
            'filecreationdate'                =>       date('y-m-d'),
            'modifieddate'              =>    date('y-m-d'),
            'auditcompletiondate'                =>       date('y-m-d'),
            'documentationdate'              =>    date('y-m-d'),
            'created_at'                =>       date('y-m-d'),
            'updated_at'              =>    date('y-m-d'),
        ]);

        if ($request->teammember_id != '0') {
            $count = count($request->teammember_id);

            // dd($count); die;
            for ($i = 0; $i < $count; $i++) {
                DB::table('assignmentteammappings')->insert([
                    'assignmentmapping_id'       =>     $id,
                    'type'       =>     $request->type[$i],
                    'teammember_id'       =>     $request->teammember_id[$i],
                    'created_at'                =>       date('y-m-d'),
                    'updated_at'              =>    date('y-m-d'),
                ]);
            }

            $clientname = Client::where('id', $request->client_id)->select('client_name', 'client_code')->first();
            $teamemailpartner = DB::table('teammembers')->where('id', $request->leadpartner)->select('emailid', 'team_member', 'staffcode')->first();
            $teamemailotherpartner = DB::table('teammembers')->where('id', $request->otherpartner)->select('emailid', 'team_member', 'staffcode')->first();

            $teamleader =    DB::table('assignmentteammappings')
                ->where('assignmentmapping_id', $id)
                ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
                ->select('teammembers.team_member', 'teammembers.staffcode')
                ->get();

            $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
            // Mail for employee
            foreach ($teamemail as $teammember) {
                $data = array(
                    'assignmentid' =>  $assignmentgenerate,
                    'clientname' =>  $clientname->client_name,
                    'clientcode' =>  $clientname->client_code,
                    'assignmentname' =>  $request->assignmentname,
                    'assignment_name' =>  $assignment_name,
                    'emailid' =>  $teammember->emailid,
                    'otherpatner' =>  $teamemailotherpartner,
                    'assignmentpartner' =>  $teamemailpartner,
                    'teamleader' =>  $teamleader,

                );

                $this->sendAssignmentEmail($data);
            }

            // Mail for leadpartner
            if ($request->leadpartner !=  null) {
                $data = array(
                    'assignmentid' =>  $assignmentgenerate,
                    'clientname' =>  $clientname->client_name,
                    'clientcode' =>  $clientname->client_code,
                    'assignmentname' =>  $request->assignmentname,
                    'assignment_name' =>  $assignment_name,
                    'emailid' =>  $teamemailpartner->emailid,
                    'otherpatner' =>  $teamemailotherpartner,
                    'assignmentpartner' =>  $teamemailpartner,
                    'teamleader' =>  $teamleader,

                );

                $this->sendAssignmentEmail($data);
            }

            // Mail for otherpartner
            if ($request->otherpartner !=  null) {
                $data = array(
                    'assignmentid' =>  $assignmentgenerate,
                    'clientname' =>  $clientname->client_name,
                    'clientcode' =>  $clientname->client_code,
                    'assignmentname' =>  $request->assignmentname,
                    'assignment_name' =>  $assignment_name,
                    'emailid' =>  $teamemailotherpartner->emailid,
                    'otherpatner' =>  $teamemailotherpartner,
                    'assignmentpartner' =>  $teamemailpartner,
                    'teamleader' =>  $teamleader,

                );

                $this->sendAssignmentEmail($data);
            }
        }
        // please match hare in old code me null aa raha hai kiya 
        $actionName = class_basename($request->route()->getActionname());
        $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
        $id = auth()->user()->teammember_id;
        DB::table('activitylogs')->insert([
            'user_id' => $id,
            'ip_address' => $request->ip(),
            'activitytitle' => $pagename,
            'description' => 'New Assignment Mapping Added' . ' ' . '( ' . $assignment_name . ' )',
            'created_at' => date('y-m-d'),
            'updated_at' => date('y-m-d')
        ]);
        // Assignment assignmentmappings end
        $output = array('msg' => "Created Successfully <strong>Client Name:</strong> $clientname->client_name <strong>Assignment:</strong> $assignment_name <strong>Assignment Name:</strong> $request->assignmentname <strong>Assignment Id:</strong> $assignmentgenerate ");
        return redirect('assignmentbudgeting')->with('success', $output);
    }

	
	function sendAssignmentEmail($data)
    {
        Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
            $msg->to($data['emailid']);
            $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
      public function assignmentmappingEdit($id)
    {
        $assignmentmapping = Assignmentmapping::where('id', $id)->first();
       // dd($assignmentmapping);
        return view('backEnd.assignmentmapping.edit',compact('id','assignmentmapping'));
    }
    public function show(Assignmentmapping $assignmentmapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignmentmapping $assignmentmapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
    {
        try {
            $data=$request->except(['_token']);
            Assignmentmapping::find($id)->update($data);
               $assignmentname =  DB::table('assignmentmappings')
            ->leftjoin('assignments','assignments.id','assignmentmappings.assignment_id')->
            where('assignmentmappings.id',$id)->select('assignment_name')
            ->pluck('assignment_name')->first();
           // dd($assignmentname);
                    $actionName = class_basename($request->route()->getActionname());
                    $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
                        $id = auth()->user()->teammember_id;
                      DB::table('activitylogs')->insert([
                            'user_id' => $id, 
                            'ip_address' => $request->ip(), 
                            'activitytitle' => $pagename, 
                            'description' => ' Assignment Mapping Edit'.' '.'( '. $assignmentname. ' )', 
                            'created_at' => date('y-m-d'),       
                            'updated_at' => date('y-m-d')       
                        ]);
            $output = array('msg' => 'Updated Successfully');
            return redirect('assignmentmapping')->with('success', $output);
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
     * @param  \App\Models\Assignmentmapping  $assignmentmapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignmentmapping $assignmentmapping)
    {
        //
    }
}

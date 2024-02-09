2222222222222222222222222222222222222222222222222222222222

$permissiontimesheet = DB::table('timesheetreport')
->where('timesheetreport.teamid', auth()->user()->teammember_id)
->first();
// dd($permissiontimesheet);
22222222222222




    < div class="col-3" >
        <div class="form-group">
            <label class="font-weight-600">Team Name</label>
            <select class="language form-control" id="category7" name="teamname">
                <option value="">Please Select One</option>
                @php

                $displayedValues = [];

                @endphp
                @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->emailid, $displayedValues))
                <option value="{{ $jobDatas->teamid }}">
                    {{ $jobDatas-> team_member}}
                </option>
                @php
                                                  $displayedValues[] = $jobDatas->emailid;
                @endphp
                @endif
                @endforeach
            </select>
        </div>
                          </ >




    222222222222222222222222
this is for zip folder only inside parent zip file

public function createzipfolder(Request $request) {
    // Get All folder data and folder name 
    $assignmentfoldername = DB:: table('assignmentfolders')
        -> leftJoin('assignmentfolderfiles', 'assignmentfolderfiles.assignmentfolder_id', 'assignmentfolders.id')
        -> where('assignmentfolders.assignmentgenerateid', $request -> assignmentgenerateid)
        -> select('assignmentfolders.*', 'assignmentfolderfiles.filesname')
        -> get();

    // Set Downloaded folder name 
    $parentZipFileName = $request -> assignmentgenerateid. '.zip';
    // replace here s3 path for store zip file
    $parentZipFilePath = storage_path('app/public/image/task/').$parentZipFileName;
    $parentZip = new ZipArchive;

    // Open parent zip
    if ($parentZip -> open($parentZipFilePath, ZipArchive:: CREATE) === TRUE) {
        foreach($assignmentfoldername as $foldername) {
            if ($foldername -> filesname != null) {
                // Replace server path here 
                $filePath = storage_path('app/public/image/task/'.$foldername -> filesname);

                if (file_exists($filePath)) {
                    // Add file to the parent zip
                    $parentZip -> addFile($filePath, $foldername -> assignmentfoldersname. '/'.$foldername -> filesname);
                } else {
                    // Handle the case when the file does not exist
                    // You can log an error or take appropriate action
                }
            } else {
                // If there are no files, add an empty folder to maintain the structure
                $parentZip -> addEmptyDir($foldername -> assignmentfoldersname);
            }
        }

        $parentZip -> close();
    }

    return response() -> json($parentZipFileName);
}

222222222222222222222
final working codebefore second


@extends ('backEnd.layouts.layout')

@section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li style="margin-left: 13px;">
                    <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
                </li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment Folder</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        @component('backEnd.components.alert')
        @endcomponent

        <div class="row">
            {{-- Display loading message --}}
            <div id="loadingMessage" style="display:none;">
                Creating your zip file. Please wait...
            </div>
            <div id="createdzipfile" style="display:none;">
            </div>
            <div>
                <a href="{{ route('createdzip', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                    class="btn btn-secondary" style="color:white; display:none;" id="downloadzip">Download
                    your file</a>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Create Zip Folder button click event
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

            // Show loading message
            $('#loadingMessage').show();

            $.ajax({
                type: 'GET',
                url: '/assignmentzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function(data) {
                    // Hide loading message when the request is complete
                    $('#loadingMessage').hide();
                    // Display created zip file name
                    $('#createdzipfile').text('Created Zip File: ' + data).show();
                    $('#downloadzip').show();

                    // Handle the success response here
                    // alert(data);
                },
                error: function(error) {
                    // Hide loading message in case of an error
                    $('#loadingMessage').hide();

                    // Handle any errors here
                    console.error(error);
                }
            });
        });
    });
</script>















2222222222222222222222222222222222222222



@extends ('backEnd.layouts.layout')

@section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li style="margin-left: 13px;">
                    <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
                    {{-- <input type="tesx" id="assignmentid" value="{{ $assignmentgenerateid }}"> --}}
                </li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment Folder</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        @component('backEnd.components.alert')
        @endcomponent

        <div class="row">
            {{-- @php
                dd($assignmentgenerateid);
            @endphp --}}
            {{-- <h1>{{ $assignmentgenerateid }}</h1> --}}
        </div>
    </div >
    @endsection

    < script src = "https://code.jquery.com/jquery-3.6.0.min.js" ></ >
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

{ { -- ! created aip file using ajax  --} }
{
    {
        -- < script >
            $(document).ready(function () {
                // Create Zip Folder button click event
                $('#downloadButton').click(function (e) {
                    e.preventDefault();
                    var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';
                    // alert(assignmentgenerateid1);

                    $.ajax({
                        type: 'GET',
                        url: '/assignmentzipfolder',
                        data: {
                            assignmentgenerateid: assignmentgenerateid1,
                        },
                        success: function (data) {
                            alert(data)
                            // parentZipFileName
                        },
                        error: function (error) {
                            // Handle any errors here
                        }
                    });
                });
            });
</script > --}
}

<script>
    $(document).ready(function() {
        // Create Zip Folder button click event
        $('#downloadButton').click(function (e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';
            // alert(assignmentgenerateid1);

            $.ajax({
                type: 'GET',
                url: '/assignmentzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function (data) {

                },
                error: function (error) {
                    // Handle any errors here
                }
            });
        });
    });
</script>










2222222222222222222222222222222222222222222222222
{
    {
        -- < li style = "margin-left: 13px;" >
            <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                class="btn btn-secondary" style="color:white;" id="downloadButton">Create Zip Folder</a>
</li > --}
}


TAT100017
TAT100400
TAT100099
2222222222

{ { --filtering functionality-- } }

<div class="row row-sm">
    {{-- < div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Team Name</label>
        <select class="language form-control" id="category7" name="teamname">
            <option value="">Please Select One</option>
            @php

            $displayedValues = [];
            @endphp
            @foreach ($get_date as $jobDatas)
                    @if (!in_array($jobDatas->team_member, $displayedValues))
            <option value="{{ $jobDatas->teamid }}">
                {{ $jobDatas-> team_member}}
            </option>
            @php
                            $displayedValues[] = $jobDatas->team_member;
            @endphp
            @endif
            @endforeach
        </select>
    </div>
</> --}}


    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Start Date</label>
            <input type="date" class="form-control" id="start" name="start">

        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">End Date</label>
            <input type="date" class="form-control" name="end" id="end">
        </div>
    </div>
{
    {
        -- < div class="col-3" >
            <div class="form-group">
                <label class="font-weight-600">Total Hour</label>
                <select class="language form-control" id="category4" name="totalhours">
                    <option value="">Please Select One</option>
                    @php
                    $displayedValues = [];
                    @endphp
                    @foreach ($get_date as $jobData)
                    @if (!in_array($jobData->totaltime, $displayedValues))
                    <option value="{{ $jobData->totaltime }}">
                        {{ $jobData-> totaltime}}
                    </option>
                    @php
                            $displayedValues[] = $jobData->totaltime;
                    @endphp
                    @endif
                    @endforeach
                </select>
            </div>
    </div > --}
}
</div >










    2222222222222222222222222

public function weeklylist(Request $request) {
    // dd($request);
    if (auth() -> user() -> role_id == 13) {

        $date = DB:: table('timesheetreport') -> where('id', $request -> id) -> first();


        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', $request -> teamid)
            // i have removed below line 
            // ->where('timesheetusers.partner', $request->partnerid)
            // ->where('timesheetusers.status', 1)
            -> whereIn('timesheetusers.status', [1, 2, 3])
            -> where('timesheetusers.date', '>=', $date -> startdate)
            -> where('timesheetusers.date', '<=', $date -> enddate)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    } else {
        // edit timesheet
        // dd(auth()->user());
        $date = DB:: table('timesheetreport') -> where('id', $request -> id) -> first();

        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', $request -> teamid)
            // i have removed below line 
            // ->where('timesheetusers.partner', $request->partnerid)
            // ->where('timesheetusers.status', 1)
            -> whereIn('timesheetusers.status', [1, 2, 3])
            -> where('timesheetusers.date', '>=', $date -> startdate)
            -> where('timesheetusers.date', '<=', $date -> enddate)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
}

2222222222222222222222222

{
    {
        -- @if ($assignmentfolder)
            <li style="margin-left: 13px;">
                <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentfolder[0]->assignmentgenerateid]) }}"
                    class="btn btn-secondary" style="color:white;">Download Folder</a>
            </li>
        @endif--}
}
{
    {
        -- @forelse($assignmentfolder as $folder)
            < li style = "margin-left: 13px;" >
                <a href="{{ route('zipfolder', ['assignmentgenerateid' => $folder->assignmentgenerateid]) }}"
                    class="btn btn-secondary" style="color:white;">Download Folder</a>
    </li >
            @empty

            < p > No folders available.</p >
                @endforelse--
    }
}
@if ($assignmentfolder -> isNotEmpty())
    <li style="margin-left: 13px;">
        <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentfolder[0]->assignmentgenerateid]) }}"
            class="btn btn-secondary" style="color:white;">Download Folder</a>
    </li>
@endif







222222222222222222222222222
if ($foldername -> assignmentfoldersname != null && $foldername -> filesname != null) {
    $parentZip -> addFile($folderZipFileName, $foldername -> assignmentfoldersname. '/'.$foldername -> filesname);
} else {
    $parentZip -> close();
}


if ($foldername -> assignmentfoldersname != null) {
    $parentZip -> addFile($folderZipFileName, $foldername -> assignmentfoldersname. '/'.$foldername -> filesname);
} else {
    $parentZip -> close();
}







22222222222222
dd($zipFileNames);
// Download all zip files
foreach($zipFileNames as $zipFileName) {
    return response() -> download($zipFileName) -> deleteFileAfterSend(true);
}
// $downloadedFiles = [];
// foreach ($zipFileNames as $zipFileName) {
//     $data1 = response()->download($zipFileName)->deleteFileAfterSend(true);
//     $downloadedFiles[] = $data1;
// }
// dd($downloadedFiles);




222222222222222222
public function zipfile(Request $request, $assignmentfolder_id) {
    $generateid = DB:: table('assignmentfolders') -> where('id', $assignmentfolder_id) -> first();
    $fileName = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();
    //dd($fileName);

    $zipFileName = $generateid -> assignmentfoldersname. '.zip';
    $zip = new ZipArchive;

    if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
        foreach($fileName as $file) {
            // Replace storage_path with S3 access method
            // $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);
            $filePath = storage_path('app/public/image/task/'.$file -> filesname);

            if ($filePath) {
                $zip -> addFromString($file -> filesname, $filePath);
            } else {
                return '<h1>File Not Found</h1>';
            }
        }

        $zip -> close();
    }

    return response() -> download($zipFileName) -> deleteFileAfterSend(true);
}
app\Http\Controllers\AssignmentfolderfileController.php


public function store(Request $request) {
    // dd(auth()->user()->teammember_id);
    $request -> validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request -> except(['_token']);
        $files = [];

        if ($request -> hasFile('file')) {
            foreach($request -> file('file') as $file) {
                $name = $file -> getClientOriginalName();
                $path = $file -> storeAs('public\image\task', $name);
                $files[] = $name;
            }
        }
        foreach($files as $filess) {
            // dd($auth()->user()->teammember_id);
            // dd($files); die;
            $s = DB:: table('assignmentfolderfiles') -> insert([
                'particular' => $request -> particular,
                'assignmentgenerateid' => $request -> assignmentgenerateid,
                'assignmentfolder_id' => $request -> assignmentfolder_id,
                'createdby' => auth() -> user() -> teammember_id,
                'filesname' => $filess,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $output = array('msg' => 'Submit Successfully');
        return back() ->with ('success', ['message' => $output, 'success' => true]);
    } catch (Exception $e) {
        // dd($e);
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}



222222222222222222222222222222222222222
$savetimesheet = DB:: table('timesheetusers')
    -> where('createdby', auth() -> user() -> teammember_id)
    -> where('status', '0')
    -> orderBy('id', 'desc')
    -> first();

if ($savetimesheet) {
    $savetimesheetdate = Carbon:: parse($savetimesheet -> date);
    $previousSaturday = $savetimesheetdate -> copy() -> previous(Carbon:: SATURDAY);
    // dd($previousSaturday);
} else {
    // Handle the case where $savetimesheet is null or no records match the conditions
}

$getauth = DB:: table('timesheetreport')
    -> where('teamid', auth() -> user() -> teammember_id)
    // ->where('enddate', '2023-12-30')
    -> where('enddate', $previousSaturday)
    -> first();
dd($previousSaturday);
222222222222222222222222
1990-05 - 18
resources\views\backEnd\applyleave\teamapplication.blade.php
// Function to handle start date change
function handleStartChange() {
    var start1 = $('#start1').val();
    var end1 = $('#end1').val();
    var status1 = $('#status1').val();
    var employee1 = $('#employee1').val();
    var leave1 = $('#leave1').val();

    $.ajax({
        type: 'GET',
        url: '/filtering-applyleve',
        data: {
            end: end1,
            start: start1,
            status: status1,
            employee: employee1,
            leave: leave1
        },
        success: function (data) {
            renderTableRows(data);
            $('.paging_simple_numbers').remove();
            $('.dataTables_info').remove();
        }
    });
}


< button style="display: none;" > Save</ >
// Function to generate and download Excel file
//  function exportToExcel() {
//      // Exclude unwanted columns (created_at and type)
//      const filteredData = data.map(item => {
//          // Create a copy of the item to avoid modifying the original data
//          const newItem = {
//              Employee: item.team_member,
//              Date_of_Request: item.created_at,
//              status: item.status,
//              Leave_Type: item.name,
//              from: item.from,
//              to: item.to,
//              Approver: item.approvernames,
//              Reason_for_Leave: item.reasonleave
//              // Add other columns as needed, excluding created_at and type
//          };
//          return newItem;
//      });

//      const ws = XLSX.utils.json_to_sheet(filteredData);
//      const wb = XLSX.utils.book_new();
//      XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
//      const excelBuffer = XLSX.write(wb, {
//          bookType: "xlsx",
//          type: "array"
//      });
//      const dataBlob = new Blob([excelBuffer], {
//          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
//      });
//      saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
//  }
222222222222222222222222
//** status wise
$('#status1').change(function () {
    var status1 = $(this).val();
    var employee1 = $('#employee1').val();
    var leave1 = $('#leave1').val();
    $.ajax({
        type: 'GET',
        url: '/filtering-applyleve',
        data: {
            status: status1,
            employee: employee1,
            leave: leave1
        },
        success: function (data) {
            // Replace the table body with the filtered data
            //  $('table tbody').html("");
            $('table thead, table tbody').html("");
            // Clear the table body
            if (data.length === 0) {
                // If no data is found, display a "No data found" message
                $('table tbody').append(
                    '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                );
            } else {

                // Add existing table heading
                $('table thead').append(
                    '<tr>' +
                    '<th style="display: none;">id</th>' +
                    '<th>Employee</th>' +
                    '<th>Date of Requestaaaaa</th>' +
                    '<th>Status</th>' +
                    '<th>Leave Type</th>' +
                    '<th>Leave Period</th>' +
                    '<th>Days</th>' +
                    '<th>Approver</th>' +
                    '<th>Reason for Leave</th>' +
                    '</tr>'
                );

                $.each(data, function (index, item) {

                    // Create the URL dynamically
                    var url = '/applyleave/' + item.id;

                    var createdAt = new Date(item.created_at)
                        .toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    var fromDate = new Date(item.from)
                        .toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    var toDate = new Date(item.to)
                        .toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });

                    var holidays = Math.floor((new Date(item.to) -
                        new Date(item.from)) / (24 * 60 * 60 *
                            1000)) + 1;

                    // Add the rows to the table
                    $('table tbody').append('<tr>' +
                        '<td><a href="' + url + '">' + item
                            .team_member +
                        '</a></td>' +
                        '<td>' + createdAt + '</td>' +
                        '<td>' + getStatusBadge(item.status) + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + fromDate + ' to ' + toDate +
                        '</td>' +
                        '<td>' + holidays + '</td>' +
                        '<td>' + item.approvernames + '</td>' +
                        '<td style="width: 7rem;text-wrap: wrap;">' +
                        item.reasonleave + '</td>' +
                        '</tr>');
                });



                // Function to handle the status badge
                function getStatusBadge(status) {
                    if (status == 0) {
                        return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                    } else if (status == 1) {
                        return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                    } else if (status == 2) {
                        return '<span class="badge badge-danger">Rejected</span>';
                    } else {
                        return '';
                    }
                }

                //   remove pagination after filter
                $('.paging_simple_numbers').remove();
                $('.dataTables_info').remove();

                //  // Change id aatribute dynamically in ajax
                //  $('#examplee').attr('id', 'examplee1111111');
                $('#examplee').removeAttr('id').attr('id', 'examplee');


            }
        }
    });
});

22222222222
$('table thead, table tbody').html("");


// Add existing table heading
$('table thead').append(
    '<tr>' +
    '<th style="display: none;">id</th>' +
    '<th>Employee</th>' +
    '<th>Date of Requestaaaaa</th>' +
    '<th>Status</th>' +
    '<th>Leave Type</th>' +
    '<th>Leave Period</th>' +
    '<th>Days</th>' +
    '<th>Approver</th>' +
    '<th>Reason for Leave</th>' +
    '</tr>'
);
222222222222
{#3603
    + "id": 652
        + "client_id": 226
            + "assignment_id": 210
                + "assignmentgenerate_id": "GLO100118"
                    + "assignmentnumber": 100118
                        + "assignmentname": "Statutory Audit 2022-23"
                            + "otp": "221242"
                                + "otpverifydate": "2023-10-27 15:07:28"
                                    + "closedby": 844
                                        + "billingfrequency": null
                                            + "duedate": "2023-09-30"
                                                + "billdate": null
                                                    + "billlingamount": null
                                                        + "finalreportdate": null
                                                            + "draftreportdate": null
                                                                + "moneyreceiveddate": null
                                                                    + "status": 0
                                                                        + "appointment_letter": null
                                                                            + "created_by": 634
                                                                                + "created_at": "2023-10-04 00:00:00"
                                                                                    + "updated_at": "2023-10-04 00:00:00"
                                                                                        + "leadpartner": 844
                                                                                            + "otherpartner": 840
                                                                                                + "periodend": "2023-03-31"
                                                                                                    + "periodstart": "2022-04-01"
                                                                                                        + "year": "2023"
                                                                                                            + "location": null
                                                                                                                + "fees": null
                                                                                                                    + "gst": null
                                                                                                                        + "roleassignment": 1
                                                                                                                            + "esthours": "0"
                                                                                                                                + "stdcost": "0"
                                                                                                                                    + "estcost": "0"
                                                                                                                                        + "filecreationdate": "23-10-04"
                                                                                                                                            + "modifieddate": "23-10-04"
                                                                                                                                                + "auditcompletiondate": "23-10-04"
                                                                                                                                                    + "documentationdate": "23-10-04"
                                                                                                                                                        + "assignment_name": "Statutory Audit-Small Company"
                                                                                                                                                            + "assignmentmapping_id": 136
                                                                                                                                                                + "teammember_id": 847
                                                                                                                                                                    + "type": "2"
                                                                                                                                                                        + "fromdate": null
                                                                                                                                                                            + "todate": null
}


if ($startdate1 && $endtdate1) {
    $query -> whereBetween('applyleaves.created_at', [$startdate1, $endtdate1]);
    // $query->where('applyleaves.created_at', $startdate1);
}
$startdate = $request -> input('start');
$startdate1 = date('Y-m-d H:i:s', strtotime($startdate));
$endtdate = $request -> input('end');
$endtdate1 = date('Y-m-d H:i:s', strtotime($endtdate));

22222222222222222222222222222222222222222222222222222222222
$statusdata = $request -> input('status');

// if ($statusdata) {
//   $query->where('applyleaves.status', $statusdata);
// }
if ($statusdata) {
    $query = DB:: table('applyleaves')
        -> where('applyleaves.status', $statusdata);
    // ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    // ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    // ->leftjoin('teammembers as approvername', 'approvername.id', 'applyleaves.approver')
    // ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    // ->select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'approvername.team_member as approvernames');

}
22222222222222222222

    <? php

namespace App\Http\Controllers;


use App\Models\Teammember;
use App\Models\Timesheet;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignment;
use App\Models\Assignmentmapping;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DB;
use Excel;
use DateTime;


class TimesheetController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this -> middleware('auth');
    }
    public function timesheetupdatesubmit(Request $request) {
        // dd($request);
        if ($request -> ajax()) {
            if (isset($request -> id)) {
                //   dd($request->id);
                $conversion = DB:: table('timesheetusers')
                    -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                    -> where('timesheetusers.id', $request -> id)
                    -> select('teammembers.team_member', 'timesheetusers.*') -> first();
                //  dd($conversion);
                return response() -> json($conversion);
            }
        }
    }
    public function full_list() {
        $time = DB:: table('timesheets') -> get();
        foreach($time as $value) {
            //    dd(date('F', strtotime($value->date)));
            DB:: table('timesheets') -> where('id', $value -> id) -> where('month', null) -> update([
                'month'         => date('F', strtotime($value -> date)),
            ]);
        }
        $time = DB:: table('timesheets') -> where('month', 'November')
            -> orwhere('month', 'October') -> get();
        // dd($time);
        foreach($time as $value) {
            //  dd(date('Y-m-d', strtotime($value->date)));
            DB:: table('timesheets') -> where('id', $value -> id) -> update([
                'date'         => date('Y-m-d', strtotime($value -> date)),
            ]);
        }
        $teammember = DB:: table('teammembers') -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
            -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
            -> where('teammembers.status', '1') -> distinct() -> get();
        //  dd($teammember);
        $month = DB:: table('timesheets')
            -> select('timesheets.month') -> distinct() -> get();
        $result = DB:: table('timesheetusers') -> select(DB:: raw('YEAR(date) as year'))
            -> distinct() -> orderBy('year', 'DESC') -> limit(5) -> get();
        $years = $result -> pluck('year');

        //dd($month);
        $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> select('timesheets.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> paginate(80);
        // dd($timesheetData);
        return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
    }
    //! old code 
    // // patner zxzx
    // public function allteamsubmitted()
    // {

    //   $get_date = DB::table('timesheetreport')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //     // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //     ->latest()->get();

    //   dd($get_date);
    //   // adminfil
    //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
    // }

    // !old code 20-12-23
    // public function allteamsubmitted()
    // {

    //   $get_date = DB::table('timesheetreport')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //     // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //     ->latest()->get();

    //   // dd($get_date);
    //   // adminfil
    //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
    // }
    // patner zxzx
    public function allteamsubmitted() {

        $get_datess = DB:: table('timesheetreport')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
            -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
            // ->where('timesheetreport.teamid', auth()->user()->teammember_id)
            -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
            -> latest() -> get();


        // maping double date ************
        $groupedData = $get_datess -> groupBy(function ($item) {
            return $item -> team_member. '|'.$item -> week;
        }) -> map(function ($group) {
            $firstItem = $group -> first();

            return (object)[
                'id' => $firstItem -> id,
                    'teamid' => $firstItem -> teamid,
                        'week' => $firstItem -> week,
                            'totaldays' => $group -> sum('totaldays'),
                                'totaltime' => $group -> sum('totaltime'),
                                    'startdate' => $firstItem -> startdate,
                                        'enddate' => $firstItem -> enddate,
                                            'partnername' => $firstItem -> partnername,
                                                'created_at' => $firstItem -> created_at,
                                                    'team_member' => $firstItem -> team_member,
                                                        'partnerid' => $firstItem -> partnerid,
      ];
        });

        $get_date = collect($groupedData -> values());

        return view('backEnd.timesheet.myteamindex', compact('get_date'));
    }


    // public function timesheet_mylist()
    // {
    //   if (auth()->user()->role_id == 13) {
    //     // die;
    //     $client = Client::select('id', 'client_name')->get();
    //     $getauth =  DB::table('timesheetusers')
    //       ->where('createdby', auth()->user()->teammember_id)
    //       ->where('status', '0')
    //       ->orderby('id', 'desc')->first();

    //     $dropdownYears = DB::table('timesheets')
    //       ->where('created_by', auth()->user()->teammember_id)
    //       ->select(DB::raw('YEAR(date) as year'))
    //       ->distinct()->orderBy('year', 'DESC')->pluck('year');
    //     $dropdownYears = DB::table('timesheets')
    //       ->where('created_by', auth()->user()->teammember_id)
    //       ->select(DB::raw('YEAR(date) as year'))
    //       ->distinct()->orderBy('year', 'DESC')->pluck('year');


    //     $dropdownMonths = DB::table('timesheets')
    //       ->where('created_by', auth()->user()->teammember_id)
    //       ->distinct()
    //       ->pluck('month');

    //     $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();

    //     $currentDate = now();


    //     $month = $currentDate->format('F');
    //     $year = $currentDate->format('Y');

    //     $time =  DB::table('timesheets')->get();
    //     foreach ($time as $value) {
    //       //dd(date('F', strtotime($value->date)));
    //       DB::table('timesheets')->where('id', $value->id)->update([
    //         'month'         =>     date('F', strtotime($value->date)),
    //       ]);
    //     }
    //     $teammember = DB::table('timesheets')
    //       ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
    //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //       ->where('timesheetusers.partner', auth()->user()->teammember_id)
    //       ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
    //     //  dd($teammember);
    //     $month = DB::table('timesheets')
    //       ->select('timesheets.month')->distinct()->get();

    //     $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
    //       ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    //     $years = $result->pluck('year');

    //     $timesheetData = DB::table('timesheetusers')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
    //       ->where('timesheetusers.status', 0)
    //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    //     // dd($timesheetData);

    //     // $timesheetData = DB::table('timesheetusers')
    //     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //     //   ->where('timesheetusers.createdby', auth()->user()->teammember_id)
    //     //   ->where('timesheetusers.status', 1)
    //     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    //     // // dd($timesheetData);
    //     $getauthh =  DB::table('timesheetusers')
    //       ->where('createdby', auth()->user()->teammember_id)
    //       ->orderby('id', 'desc')->first();
    //     $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

    //     if ($getauthh  == null) {
    //       return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
    //     } else {
    //       // shahid
    //       return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
    //     }
    //   } else {

    //     $dropdownYears = DB::table('timesheets')
    //       ->where('created_by', auth()->user()->teammember_id)
    //       ->select(DB::raw('YEAR(date) as year'))
    //       ->distinct()->orderBy('year', 'DESC')->pluck('year');

    //     $dropdownMonths = DB::table('timesheets')
    //       ->where('created_by', auth()->user()->teammember_id)
    //       ->distinct()
    //       ->pluck('month');

    //     $currentDate = now();


    //     $month = $currentDate->format('F');
    //     $year = $currentDate->format('Y');

    //     $getauths =  DB::table('timesheetusers')
    //       ->where('createdby', auth()->user()->teammember_id)
    //       ->where('status', '1')
    //       ->orderby('id', 'desc')->first();
    //     if ($getauths != null) {
    //       $getauth =  DB::table('timesheetusers')
    //         ->where('createdby', auth()->user()->teammember_id)
    //         ->where('status', '1')
    //         ->orderby('id', 'desc')->first();
    //       //dd($getauth);
    //     } else {

    //       $getauth =  DB::table('timesheetusers')
    //         ->where('createdby', auth()->user()->teammember_id)
    //         ->where('status', '0')
    //         ->orderby('id', 'desc')->first();
    //       //dd($getauth);
    //     }

    //     $getauthh =  DB::table('timesheetusers')
    //       ->where('createdby', auth()->user()->teammember_id)
    //       ->orderby('id', 'desc')->first();


    //     $client = Client::select('id', 'client_name')->get();
    //     $timesheetData = DB::table('timesheetusers')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
    //       ->where('timesheetusers.status', 0)
    //       //   ->where('timesheets.month', $month)
    //       ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
    //       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();
    //     //  dd($timesheetData);
    //     $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();
    //     $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

    //     if ($getauthh  == null) {
    //       return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
    //     } else {
    //       return view('backEnd.timesheet.index', compact(
    //         'timesheetData',
    //         'getauth',
    //         'client',
    //         'partner',
    //         'timesheetrequest',
    //         'dropdownYears',
    //         'dropdownMonths',
    //         'month',
    //         'year',
    //       ));
    //     }
    //   }
    // }

    public function timesheet_mylist() {
        if (auth() -> user() -> role_id == 13) {
            // die;
            $client = Client:: select('id', 'client_name') -> get();
            $getauth = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> where('status', '0')
                -> orderby('id', 'desc') -> first();

            $dropdownYears = DB:: table('timesheets')
                -> where('created_by', auth() -> user() -> teammember_id)
                -> select(DB:: raw('YEAR(date) as year'))
                -> distinct() -> orderBy('year', 'DESC') -> pluck('year');
            $dropdownYears = DB:: table('timesheets')
                -> where('created_by', auth() -> user() -> teammember_id)
                -> select(DB:: raw('YEAR(date) as year'))
                -> distinct() -> orderBy('year', 'DESC') -> pluck('year');


            $dropdownMonths = DB:: table('timesheets')
                -> where('created_by', auth() -> user() -> teammember_id)
                -> distinct()
                -> pluck('month');

            $partner = Teammember:: where('role_id', '=', 11) -> where('status', '=', 1) ->with ('title') -> get();

            $currentDate = now();


            $month = $currentDate -> format('F');
            $year = $currentDate -> format('Y');

            //	  $time =  DB::table('timesheets')->get();
            // foreach ($time as $value) {
            //dd(date('F', strtotime($value->date)));
            //      DB::table('timesheets')->where('id',$value->id)->update([	
            //          'month'         =>     date('F', strtotime($value->date)),
            //           ]);
            // }
            $teammember = DB:: table('timesheets')
                -> leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
                -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
                -> where('timesheetusers.partner', auth() -> user() -> teammember_id)
                -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename') -> distinct() -> get();
            //  dd($teammember);
            $month = DB:: table('timesheets')
                -> select('timesheets.month') -> distinct() -> get();

            $result = DB:: table('timesheetusers') -> select(DB:: raw('YEAR(date) as year'))
                -> distinct() -> orderBy('year', 'DESC') -> limit(5) -> get();
            $years = $result -> pluck('year');

            $timesheetData = DB:: table('timesheetusers')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                -> where('timesheetusers.createdby', auth() -> user() -> teammember_id)
                -> where('timesheetusers.status', 0)
                -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> paginate(200);
            // dd($timesheetData);
            $getauthh = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> orderby('id', 'desc') -> first();
            $timesheetrequest = DB:: table('timesheetrequests') -> where('createdby', auth() -> user() -> teammember_id) -> orderBy('id', 'DESC') -> first();

            if ($getauthh == null) {
                return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
            } else {
                return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
            }
        } else {

            $dropdownYears = DB:: table('timesheets')
                -> where('created_by', auth() -> user() -> teammember_id)
                -> select(DB:: raw('YEAR(date) as year'))
                -> distinct() -> orderBy('year', 'DESC') -> pluck('year');

            $dropdownMonths = DB:: table('timesheets')
                -> where('created_by', auth() -> user() -> teammember_id)
                -> distinct()
                -> pluck('month');

            $currentDate = now();


            $month = $currentDate -> format('F');
            $year = $currentDate -> format('Y');

            $getauths = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> where('status', '1')
                -> orderby('id', 'desc') -> first();
            if ($getauths != null) {
                $getauth = DB:: table('timesheetusers')
                    -> where('createdby', auth() -> user() -> teammember_id)
                    -> where('status', '0')
                    -> orderby('id', 'desc') -> first();
                //dd($getauth);
            } else {

                $getauth = DB:: table('timesheetusers')
                    -> where('createdby', auth() -> user() -> teammember_id)
                    -> where('status', '0')
                    -> orderby('id', 'desc') -> first();
                //dd($getauth);
            }

            $getauthh = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> orderby('id', 'desc') -> first();


            $client = Client:: select('id', 'client_name') -> get();
            $timesheetData = DB:: table('timesheetusers')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                -> where('timesheetusers.createdby', auth() -> user() -> teammember_id)
                -> where('timesheetusers.status', 0)
                //   ->where('timesheets.month', $month)
                -> whereRaw('YEAR(timesheetusers.date) = ?', [$year])
                -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> get();
            //  dd($timesheetData);
            $partner = Teammember:: where('role_id', '=', 11) -> where('status', '=', 1) ->with ('title') -> get();
            $timesheetrequest = DB:: table('timesheetrequests') -> where('createdby', auth() -> user() -> teammember_id) -> orderBy('id', 'DESC') -> first();

            if ($getauthh == null) {
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
    // !old code 20-12-23
    // public function timesheet_teamlist()
    // {
    //   if (auth()->user()->role_id == 13) {
    //     // get all partner
    //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    //       ->orderBy('team_member', 'asc')->get();

    //     $get_date = DB::table('timesheetreport')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
    //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //       ->latest()->get();
    //   } else {
    //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    //       ->orderBy('team_member', 'asc')->get();
    //     $get_date = DB::table('timesheetreport')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //       ->latest()->get();
    //   }

    //   dd($get_date);
    //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
    // }
    // public function timesheet_teamlist()
    // {
    //   if (auth()->user()->role_id == 13) {
    //     // get all partner
    //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    //       ->orderBy('team_member', 'asc')->get();

    //     $get_date = DB::table('timesheetreport')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
    //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //       ->latest()->get();
    //   } else {
    //     $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    //       ->orderBy('team_member', 'asc')->get();
    //     $get_date = DB::table('timesheetreport')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //       ->latest()->get();
    //   }

    //   // dd($get_date);
    //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
    // }
    //! 27-12-23
    // public function timesheet_teamlist()
    // {
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

    // before searching data 
    public function timesheet_teamlist() {
        // for patner
        if (auth() -> user() -> role_id == 13) {

            // get all partner
            $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title')
            -> orderBy('team_member', 'asc') -> get();

            $get_datess = DB:: table('timesheetreport')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
                -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
                -> where('timesheetreport.partnerid', auth() -> user() -> teammember_id)
                -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
                -> latest() -> get();
            // dd($get_datess);
        }
        // for staff and manager 
        else {
            $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title')
            -> orderBy('team_member', 'asc') -> get();
            $get_datess = DB:: table('timesheetreport')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
                -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
                -> where('timesheetreport.teamid', auth() -> user() -> teammember_id)
                -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
                -> latest() -> get();
            // dd($get_datess);
        }

        $groupedData = $get_datess -> groupBy(function ($item) {
            return $item -> team_member. '|'.$item -> week;
        }) -> map(function ($group) {
            $firstItem = $group -> first();

            return (object)[
                'id' => $firstItem -> id,
                    'teamid' => $firstItem -> teamid,
                        'week' => $firstItem -> week,
                            'totaldays' => $group -> sum('totaldays'),
                                'totaltime' => $group -> sum('totaltime'),
                                    'startdate' => $firstItem -> startdate,
                                        'enddate' => $firstItem -> enddate,
                                            'partnername' => $firstItem -> partnername,
                                                'created_at' => $firstItem -> created_at,
                                                    'team_member' => $firstItem -> team_member,
                                                        'partnerid' => $firstItem -> partnerid,
      ];
        });

        $get_date = collect($groupedData -> values());

        return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
    }

    //! old code
    // public function partnersubmitted()
    // {
    //   // get all partner
    //   $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
    //     ->orderBy('team_member', 'asc')->get();
    //   // dd($partner);
    //   $get_date = DB::table('timesheetreport')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //     ->latest()->get();
    //   dd($get_date);
    //   // shahid
    //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
    // }
    //! old code 
    // patner zxzx
    // public function partnersubmitted()
    // {
    //   // dd(auth()->user());
    //   $get_date = DB::table('timesheetreport')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
    //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
    //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
    //     ->latest()->get();
    //   dd($get_date);

    //   return view('backEnd.timesheet.myteamindex', compact('get_date'));
    // }
    // patner zxzx
    public function partnersubmitted() {
        // 844
        // dd(auth()->user());
        $get_datess = DB:: table('timesheetreport')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
            -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
            -> where('timesheetreport.teamid', auth() -> user() -> teammember_id)
            -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
            -> latest() -> get();
        // dd($get_date);


        // maping week wise data 
        $groupedData = $get_datess -> groupBy('week') -> map(function ($group) {
            $firstItem = $group -> first();

            return (object)[
                'id' => $firstItem -> id,
                    'teamid' => $firstItem -> teamid,
                        'week' => $firstItem -> week,
                            'totaldays' => $group -> sum('totaldays'),
                                'totaltime' => $group -> sum('totaltime'),
                                    'startdate' => $firstItem -> startdate,
                                        'enddate' => $firstItem -> enddate,
                                            'partnername' => $firstItem -> partnername,
                                                'created_at' => $firstItem -> created_at,
                                                    'team_member' => $firstItem -> team_member,
                                                        'partnerid' => $firstItem -> partnerid,
      ];
        });

        $get_date = collect($groupedData -> values());

        return view('backEnd.timesheet.myteamindex', compact('get_date'));
    }
    //! running code done 22-12-23

    // public function filterDataAdmin(Request $request)
    // {
    //   // dd($request);
    //   if (auth()->user()->role_id == 13) {
    //     //shahidfil
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
    //   } else {

    //     $teamname = $request->input('teamname');
    //     $start = $request->input('start');
    //     $end = $request->input('end');
    //     $totalhours = $request->input('totalhours');
    //     $partnerId = $request->input('partnersearch');


    //     $query = DB::table('timesheetreport')
    //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
    //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
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
    //   $filteredData = $query->get();

    //   return response()->json($filteredData);
    // }
    // ! 27-12-23
    public function filterDataAdmin(Request $request) {
        if (auth() -> user() -> role_id == 13) {

            $teamname = $request -> input('teamname');
            $start = $request -> input('start');
            $end = $request -> input('end');
            $totalhours = $request -> input('totalhours');
            $partnerId = $request -> input('partnersearch');


            $query = DB:: table('timesheetreport')
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
                -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
                -> where('timesheetreport.teamid', auth() -> user() -> teammember_id)
                -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
                -> latest();

            // $query = DB::table('timesheetreport')
            //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
            //   ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
            //   ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
            //   ->latest();

            // teamname with othser field to  filter
            if ($teamname) {
                $query -> where('timesheetreport.teamid', $teamname);
            }

            if ($teamname && $totalhours) {
                $query -> where(function ($q) use($teamname, $totalhours) {
                    $q-> where('timesheetreport.teamid', $teamname)
                    -> where('timesheetreport.totaltime', $totalhours);
            });
        }
        if ($teamname && $partnerId) {
            $query -> where(function ($q) use($teamname, $partnerId) {
                $q-> where('timesheetreport.teamid', $teamname)
                -> where('timesheetreport.partnerid', $partnerId);
        });
    }

    // patner or othse one data
    if($partnerId) {
        $query -> where('timesheetreport.partnerid', $partnerId);
    }

    if($partnerId && $totalhours) {
    $query -> where(function ($q) use($partnerId, $totalhours) {
        $q-> where('timesheetreport.partnerid', $partnerId)
        -> where('timesheetreport.totaltime', $totalhours);
});
      }

// total hour wise  wise or othser data
if ($totalhours) {
    $query -> where('timesheetreport.totaltime', $totalhours);
}
//! end date 
if ($start && $end) {
    $query -> where(function ($query) use($start, $end) {
        $query-> whereBetween('timesheetreport.startdate', [$start, $end])
        -> orWhereBetween('timesheetreport.enddate', [$start, $end])
        -> orWhere(function ($query) use($start, $end) {
            $query-> where('timesheetreport.startdate', '<=', $start)
            -> where('timesheetreport.enddate', '>=', $end);
});
        });
      }
    }
    // for Admin
    else {
    // dd($request);

    $teamname = $request -> input('teamname');
    $start = $request -> input('start');
    $end = $request -> input('end');
    $totalhours = $request -> input('totalhours');
    $partnerId = $request -> input('partnersearch');


    $query = DB:: table('timesheetreport')
        -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        -> latest();

    // teamname with othser field to  filter
    if ($teamname) {
        $query -> where('timesheetreport.teamid', $teamname);
    }

    if ($teamname && $totalhours) {
        $query -> where(function ($q) use($teamname, $totalhours) {
            $q-> where('timesheetreport.teamid', $teamname)
            -> where('timesheetreport.totaltime', $totalhours);
    });
}
if ($teamname && $partnerId) {
    $query -> where(function ($q) use($teamname, $partnerId) {
        $q-> where('timesheetreport.teamid', $teamname)
        -> where('timesheetreport.partnerid', $partnerId);
});
      }

// patner or othse one data
if ($partnerId) {
    $query -> where('timesheetreport.partnerid', $partnerId);
}

if ($partnerId && $totalhours) {
    $query -> where(function ($q) use($partnerId, $totalhours) {
        $q-> where('timesheetreport.partnerid', $partnerId)
        -> where('timesheetreport.totaltime', $totalhours);
});
      }

// total hour wise  wise or othser data
if ($totalhours) {
    $query -> where('timesheetreport.totaltime', $totalhours);
}
//! end date 
if ($start && $end) {
    $query -> where(function ($query) use($start, $end) {
        $query-> whereBetween('timesheetreport.startdate', [$start, $end])
        -> orWhereBetween('timesheetreport.enddate', [$start, $end])
        -> orWhere(function ($query) use($start, $end) {
            $query-> where('timesheetreport.startdate', '<=', $start)
            -> where('timesheetreport.enddate', '>=', $end);
});
        });
      }
    }
$filteredDataaa = $query -> get();

// maping double date ************
$groupedData = $filteredDataaa -> groupBy(function ($item) {
    return $item -> team_member. '|'.$item -> week;
}) -> map(function ($group) {
    $firstItem = $group -> first();

    return (object)[
        'id' => $firstItem -> id,
            'teamid' => $firstItem -> teamid,
                'week' => $firstItem -> week,
                    'totaldays' => $group -> sum('totaldays'),
                        'totaltime' => $group -> sum('totaltime'),
                            'startdate' => $firstItem -> startdate,
                                'enddate' => $firstItem -> enddate,
                                    'partnername' => $firstItem -> partnername,
                                        'created_at' => $firstItem -> created_at,
                                            'team_member' => $firstItem -> team_member,
                                                'partnerid' => $firstItem -> partnerid,
      ];
});


$filteredData = collect($groupedData -> values());
return response() -> json($filteredData);
  }



//! old code 
// public function weeklylist(Request $request)
// {
//   if (auth()->user()->role_id == 13) {

//     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
//     // dd($date);
//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', $request->teamid)
//       ->where('timesheetusers.partner', $request->partnerid)
//       ->where('timesheetusers.status', 1)
//       ->where('timesheetusers.date', '>=', $date->startdate)
//       //->where('timesheetusers.date', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
//     // dd($timesheetData);
//   } else {
//     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
//     // dd($date);
//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', $request->teamid)
//       ->where('timesheetusers.partner', $request->partnerid)
//       ->where('timesheetusers.status', 1)
//       ->where('timesheetusers.date', '>=', $date->startdate)
//       ->where('timesheetusers.date', '<=', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
//   }
//   // dd($timesheetData);
//   return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
// }

// public function weeklylist(Request $request)
// {
//   dd($request);
//   if (auth()->user()->role_id == 13) {

//     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
//     // dd($date);
//     // $timesheetData = DB::table('timesheetusers')
//     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//     //   ->where('timesheetusers.createdby', $request->teamid)
//     //   ->where('timesheetusers.partner', $request->partnerid)
//     //   ->where('timesheetusers.status', 1)
//     //   ->where('timesheetusers.date', '>=', $date->startdate)
//     //   //->where('timesheetusers.date', $date->enddate)
//     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
//     // // dd($timesheetData);
//     // $timesheetData = DB::table('timesheetusers')
//     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//     //   ->where('timesheetusers.createdby', $request->teamid)
//     //   ->where('timesheetusers.partner', $request->partnerid)
//     //   //   ->where('timesheetusers.status', 1)
//     //   ->whereIn('timesheetusers.status', [1, 2, 3])
//     //   ->where('timesheetusers.date', '>=', $date->startdate)
//     //   //-      ->where('timesheetusers.date', '<=', $date->enddate)
//     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
//     // // dd($timesheetData);

//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', $request->teamid)
//       ->where('timesheetusers.partner', $request->partnerid)
//       // ->where('timesheetusers.status', 1)
//       ->whereIn('timesheetusers.status', [1, 2, 3])
//       ->where('timesheetusers.date', '>=', $date->startdate)
//       ->where('timesheetusers.date', '<=', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
//   } else {
//     // edit timesheet
//     // dd(auth()->user());
//     $date = DB::table('timesheetreport')->where('id', $request->id)->first();
//     // dd($date);
//     // $timesheetData = DB::table('timesheetusers')
//     //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//     //   ->where('timesheetusers.createdby', $request->teamid)
//     //   ->where('timesheetusers.partner', $request->partnerid)
//     //   ->where('timesheetusers.status', 1)
//     //   ->where('timesheetusers.date', '>=', $date->startdate)
//     //   ->where('timesheetusers.date', '<=', $date->enddate)
//     //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', $request->teamid)
//       ->where('timesheetusers.partner', $request->partnerid)
//       // ->where('timesheetusers.status', 1)
//       ->whereIn('timesheetusers.status', [1, 2, 3])
//       ->where('timesheetusers.date', '>=', $date->startdate)
//       ->where('timesheetusers.date', '<=', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
//   }
//   // dd($timesheetData);
//   return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
// }

// patner zxzx
public function weeklylist(Request $request) {
    // dd($request);
    if (auth() -> user() -> role_id == 13) {

        $date = DB:: table('timesheetreport') -> where('id', $request -> id) -> first();
        // dd($date);
        // $timesheetData = DB::table('timesheetusers')
        //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        //   ->where('timesheetusers.createdby', $request->teamid)
        //   ->where('timesheetusers.partner', $request->partnerid)
        //   ->where('timesheetusers.status', 1)
        //   ->where('timesheetusers.date', '>=', $date->startdate)
        //   //->where('timesheetusers.date', $date->enddate)
        //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
        // // dd($timesheetData);
        // $timesheetData = DB::table('timesheetusers')
        //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        //   ->where('timesheetusers.createdby', $request->teamid)
        //   ->where('timesheetusers.partner', $request->partnerid)
        //   //   ->where('timesheetusers.status', 1)
        //   ->whereIn('timesheetusers.status', [1, 2, 3])
        //   ->where('timesheetusers.date', '>=', $date->startdate)
        //   //-      ->where('timesheetusers.date', '<=', $date->enddate)
        //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
        // // dd($timesheetData);

        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', $request -> teamid)
            // i have removed below line 
            // ->where('timesheetusers.partner', $request->partnerid)
            // ->where('timesheetusers.status', 1)
            -> whereIn('timesheetusers.status', [1, 2, 3])
            -> where('timesheetusers.date', '>=', $date -> startdate)
            -> where('timesheetusers.date', '<=', $date -> enddate)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    } else {
        // edit timesheet
        // dd(auth()->user());
        $date = DB:: table('timesheetreport') -> where('id', $request -> id) -> first();
        // dd($date);
        // $timesheetData = DB::table('timesheetusers')
        //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        //   ->where('timesheetusers.createdby', $request->teamid)
        //   ->where('timesheetusers.partner', $request->partnerid)
        //   ->where('timesheetusers.status', 1)
        //   ->where('timesheetusers.date', '>=', $date->startdate)
        //   ->where('timesheetusers.date', '<=', $date->enddate)
        //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', $request -> teamid)
            // i have removed below line 
            // ->where('timesheetusers.partner', $request->partnerid)
            // ->where('timesheetusers.status', 1)
            -> whereIn('timesheetusers.status', [1, 2, 3])
            -> where('timesheetusers.date', '>=', $date -> startdate)
            -> where('timesheetusers.date', '<=', $date -> enddate)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
}








//* admin and partner is done 
// public function rejectedlist(Request $request)
// {
//   // dd(auth()->user());
//   if (auth()->user()->role_id == 13) {
//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', auth()->user()->teammember_id)
//       ->where('timesheetusers.status', 2)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->paginate(10);
//     // dd($timesheetData);
//   } else {

//     $timesheetData = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       // ->where('timesheetusers.createdby', $request->teamid)
//       // ->where('timesheetusers.partner', $request->partnerid)
//       ->where('timesheetusers.status', 2)
//       // ->whereIn('timesheetusers.status', [1, 2])
//       // ->where('timesheetusers.date', '>=', $date->startdate)
//       // ->where('timesheetusers.date', '<=', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
//   }
//   // dd($timesheetData);
//   return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
// }


//! running code done 
// public function filterweeklylist(Request $request)
// {

//   if (auth()->user()->role_id == 13) {
//     //shahidfil
//     $clientname = $request->input('clientname');
//     $assignmentname = $request->input('assignmentname');


//     $query = DB::table('timesheetreport')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
//       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
//       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
//       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
//       ->latest();

//     // teamname with othser field to  filter
//     if ($clientname) {
//       $query->where('timesheetreport.teamid', $clientname);
//     }

//     if ($clientname && $assignmentname) {
//       $query->where(function ($q) use ($clientname, $assignmentname) {
//         $q->where('timesheetreport.teamid', $clientname)
//           ->where('timesheetreport.totaltime', $assignmentname);
//       });
//     }

//     // patner or othse one data
//     if ($assignmentname) {
//       $query->where('timesheetreport.partnerid', $assignmentname);
//     }
//   } else {
//     // admin dashboard
//     $clientname = $request->input('clientname');
//     $assignmentname = $request->input('assignmentname');

//     $date = DB::table('timesheetreport')->where('id', $request->id)->first();

//     $query = DB::table('timesheetusers')
//       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//       ->where('timesheetusers.createdby', $request->teamid)
//       ->where('timesheetusers.partner', $request->partnerid)
//       ->where('timesheetusers.status', 1)
//       ->where('timesheetusers.date', '>=', $date->startdate)
//       ->where('timesheetusers.date', '<=', $date->enddate)
//       ->select('timesheetusers.*', 'teammembers.team_member');

//     // teamname with othser field to  filter
//     if ($clientname) {
//       $query->where('timesheetreport.teamid', $clientname);
//     }

//     if ($clientname && $assignmentname) {
//       $query->where(function ($q) use ($clientname, $assignmentname) {
//         $q->where('timesheetreport.teamid', $clientname)
//           ->where('timesheetreport.totaltime', $assignmentname);
//       });
//     }

//     // patner or othse one data
//     if ($assignmentname) {
//       $query->where('timesheetreport.partnerid', $assignmentname);
//     }

//   }
//   $filteredData = $query->get();

//   return response()->json($filteredData);
// }


public function filterweeklylist(Request $request) {
    // admin dashboard
    $clientid = $request -> input('clientname');
    $assignmentid = $request -> input('assignmentname');

    $date = DB:: table('timesheetreport') -> where('id', $request -> id) -> first();

    $query = DB:: table('timesheetusers')
        -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        -> leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        -> leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        -> leftjoin('teammembers as partnername', 'partnername.id', 'timesheetusers.partner')
        -> where('timesheetusers.createdby', $request -> teamid)
        -> where('timesheetusers.partner', $request -> partnerid)
        -> where('timesheetusers.status', 1)
        -> where('timesheetusers.date', '>=', $date -> startdate)
        -> where('timesheetusers.date', '<=', $date -> enddate)
        -> select('timesheetusers.*', 'teammembers.team_member', 'clients.client_name', 'assignments.assignment_name', 'partnername.team_member as partnername_name');

    if ($clientid) {
        $query -> where('timesheetusers.client_id', $clientid);
    }

    if ($clientid && $assignmentid) {
        $query -> where(function ($q) use($clientid, $assignmentid) {
            $q-> where('timesheetusers.client_id', $clientid)
            -> where('assignments.id', $assignmentid);
    });
}

if ($assignmentid) {
    $query -> where('assignments.id', $assignmentid);
}

$filteredData = $query -> get();
return response() -> json($filteredData);
  }


public function timesheet_submit(Request $request) {
    //dd($request);
    try {
        DB:: table('timesheetusers') -> where('id', $request -> imsheetid) -> update([
            'client_id' => $request -> client_id,
            'assignment_id' => $request -> assignment_id,
            'workitem' => $request -> workitem,
            'totalhour' => $request -> totalhour,
            'status'         => 1,
            'updatedby'  => auth() -> user() -> teammember_id,
            'updated_at'              => date('y-m-d'),
        ]);

        $output = array('msg' => 'Submit Successfully');
        return back() ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}
public function transformDate($value, $format = 'Y-m-d') {
    try {
        return \Carbon\Carbon:: instance(\PhpOffice\PhpSpreadsheet\Shared\Date:: excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
        return \Carbon\Carbon:: createFromFormat($format, $value);
    }
}
public function timesheetexcelStore(Request $request) {
    $request -> validate([
        'file' => 'required'
    ]);

    try {
        $file = $request -> file;
        //  dd($file);
        $data = $request -> except(['_token']);
        $dataa = Excel:: toArray(new Timesheetimport, $file);
        //dd($dataa);
        foreach($dataa[0] as $key => $value) {


            $currentday =
            \PhpOffice\PhpSpreadsheet\Shared\Date:: excelToDateTimeObject($value['date']) -> format('Y-m-d');
            // $currentday= date('Y-m-d', strtotime($value['date']));
            // dd($currentday);

            $mytime = Carbon:: now();

            $currentdate = $mytime -> toDateString();
            $hour = $value['hour'];





            if ($currentday > $currentdate) {
                $output = array('msg' => 'You Can Not Fill Timesheet For Future Date ('.date('d-m-Y', strtotime($currentday)). ')');
                return redirect('timesheet') ->with ('statuss', $output);
            } elseif($hour > 24) {
                $output = array('msg' => 'The time entered exceeds the maximum of 24 hours !');
                return back() ->with ('statuss', $output);
            } else {

                $leaves = DB:: table('applyleaves')
                    -> where('applyleaves.createdby', auth() -> user() -> teammember_id)
                    -> where('status', '!=', 2)
                    //->orWhere('status',0)
                    -> select('applyleaves.from', 'applyleaves.to')
                    -> get();
                // dd($leaves);
                if (count($leaves) != 0) {
                    foreach($leaves as $leave) {
                        //Convert each data from table to Y-m-d format to compare
                        $days = CarbonPeriod:: create(
                            date('Y-m-d', strtotime($leave -> from)),
                            date('Y-m-d', strtotime($leave -> to))
                        );

                        foreach($days as $day) {
                            $leavess[] = $day -> format('Y-m-d');
                            // dd($leavess);



                        }
                    }
                    //dd($leavess);


                    //  date('Y-m-d', strtotime($intval($value['date'])));
                    // dd($currentday);
                    if ($leavess != null) {
                        //dd('if');
                        foreach($leavess as $leave) {

                            if ($leave == $currentday) {
                                // dd('if');
                                // $ifcount=$ifcount+1;
                                $output = array('msg' => 'You Have Leave for the Day ('.date('d-m-Y', strtotime($leave)). ')');
                                return redirect('timesheet') ->with ('statuss', $output);
                            } else {
                                //  dd($currentday);
                            }
                        }
                    }
                }
                $clients = DB:: table('clients') -> where('client_name', $value['clientname']) -> pluck('id') -> first();
                //dd($clients);
                if ($clients == null) {
                    //dd($clients);
                    $output = array('msg' => 'Client Name ('.$value['clientname']. ') Not Match Please Check!!');
                    return back() ->with ('statuss', $output);
                } else {
                    //dd($clients);
                    $assignments = DB:: table('assignments') -> where('assignment_name', $value['assignmentname']) -> pluck('id') -> first();
                    if ($assignments == null) {
                        $output = array('msg' => 'Assigment Name ('.$value['assignmentname']. ') Not Found Please Check!!');
                        return back() ->with ('statuss', $output);
                    }
                    $partner = DB:: table('teammembers') -> where('team_member', $value['partner']) -> pluck('id') -> first();
                    if ($partner == null) {
                        $output = array('msg' => 'Partner Name ('.$value['partner']. ') Not Match Please Check!!');
                        return back() ->with ('statuss', $output);
                    }
                    if ($value['billablestatus'] != "Non Billable" && $value['billablestatus'] != "Billable") {
                        $output = array('msg' => 'Billable status ('.$value['billablestatus']. ') Not Match Please Check!!');
                        return back() ->with ('statuss', $output);
                    }
                    $timesheet = DB:: table('timesheets') -> where('created_by', auth() -> user() -> teammember_id)
                        -> where('date', $value['date']) -> pluck('id') -> first();

                    if ($timesheet == null) {

                        $id = DB:: table('timesheets') -> insertGetId(
                            [
                                'created_by' => auth() -> user() -> teammember_id,
                                'date'     => $this -> transformDate($value['date']),
                                'created_at'          => date('Y-m-d H:i:s'),
                            ]
                        );
                        $timesheets = DB:: table('timesheets') -> where('id', $id) -> first();
                        DB:: table('timesheets') -> where('id', $timesheets -> id) -> update([
                            'date'     => date('Y-m-d', strtotime($timesheets -> date)),
                            'month'     => date('F', strtotime($timesheets -> date)),
                        ]);
                    }



                    DB:: table('timesheetusers') -> insert([
                        'date'     => $this -> transformDate($value['date']),
                        'client_id'     => $clients,
                        'workitem'     => $value['workitem'],
                        'billable_status'     => $value['billablestatus'],
                        'timesheetid'     => $id,

                        'hour'     => $value['hour'],
                        'totalhour' => $value['hour'],
                        'assignment_id'     => $assignments,
                        'partner'     => $partner,
                        'createdby' => auth() -> user() -> teammember_id,
                        'created_at'          => date('Y-m-d H:i:s'),
                        'updated_at'              => date('Y-m-d H:i:s'),
                    ]);
                    $totalhour = DB:: table('timesheetusers') -> select('date', DB:: raw('COUNT(*) as `count`'))
                        -> where('createdby', auth() -> user() -> teammember_id)
                        -> groupBy('date')
                        -> havingRaw('COUNT(*) > 1')

                        -> get();
                    foreach($totalhour as $value) {
                        $sum = DB:: table('timesheetusers') -> where('createdby', auth() -> user() -> teammember_id) -> where('date', $value -> date) -> sum('hour');

                        DB:: table('timesheetusers') -> where('createdby', auth() -> user() -> teammember_id) -> where('date', $value -> date) -> update([
                            'totalhour'         => $sum,
                        ]);

                        //attendance reflection'

                        $attendances = DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)
                            -> where('month', 'June') -> first();
                        //  dd($value->created_by);

                        // dd($attendances);
                        if ($attendances == null) {
                            $a = DB:: table('attendances') -> insert([
                                'employee_name'         => auth() -> user() -> teammember_id,
                                'month'         => 'June',
                                'created_at'          => date('Y-m-d H:i:s'),
                                //   'exam_leave'      =>$value->date_total,
                            ]);
                            // dd($a);
                        }

                        //   dd($noofdaysaspertimesheet);
                        $hdatess = date('Y-m-d', strtotime($value -> date));

                        // dd($hdatess);
                        if ($hdatess == '2023-05-26') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentysix'         => $sum,
                                ]);
                        }

                        if ($hdatess == '2023-05-27') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentyseven'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-05-28') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentyeight'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-05-29') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentynine'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-05-30') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'thirty'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-05-31') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'thirtyone'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-01') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'one'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-02') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'two'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-03') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'three'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-04') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'four'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-05') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'five'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-06') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'six'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-07') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'seven'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-08') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'eight'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-09') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'nine'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-10') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'ten'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-11') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'eleven'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-12') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twelve'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-13') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'thirteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-14') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'fourteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-15') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'fifteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-16') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'sixteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-17') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'seventeen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-18') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'eighteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-19') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'ninghteen'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-20') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twenty'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-21') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentyone'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-22') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentytwo'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-23') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentythree'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-24') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentyfour'         => $sum,
                                ]);
                        }
                        if ($hdatess == '2023-06-25') {
                            DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)

                                -> where('month', 'June') -> update([
                                    'twentyfive'         => $sum,
                                ]);
                        }

                        //end attendance




                    }
                }
            }
        }
        //dd($dataa);
        $output = array('msg' => 'Excel file upload Successfully');
        return back() ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}
public function index() {
    if (auth() -> user() -> role_id == 11) {
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
    } elseif(auth() -> user() -> role_id == 18) {

        $teammember = DB:: table('teammembers') -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
            -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
            //   ->where('teammembers.status','1')
            -> distinct() -> get();
        //  dd($teammember);
        $month = DB:: table('timesheets')
            -> select('timesheets.month') -> distinct() -> get();

        $result = DB:: table('timesheetusers') -> select(DB:: raw('YEAR(date) as year'))
            -> distinct() -> orderBy('year', 'DESC') -> limit(5) -> get();
        $years = $result -> pluck('year');

        //dd($month );

        $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> select('timesheets.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> paginate(80);
        // dd($timesheetData);
        return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif(auth() -> user() -> role_id == 13) {
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
public function show(Request $request) {
    if ($request -> method() === 'POST') {

        $dropdownYears = DB:: table('timesheets')
            -> where('created_by', auth() -> user() -> teammember_id)
            -> select(DB:: raw('YEAR(date) as year'))
            -> distinct() -> orderBy('year', 'DESC') -> pluck('year');

        $dropdownMonths = DB:: table('timesheets')
            -> where('created_by', auth() -> user() -> teammember_id)
            -> distinct()
            -> pluck('month');


        $month = $request -> month;
        $year = $request -> year;


        $getauth = DB:: table('timesheets')
            -> where('created_by', auth() -> user() -> teammember_id)
            -> orderby('id', 'desc') -> first();

        //   dd($getauth);
        $client = Client:: select('id', 'client_name') -> get();
        $timesheetData = $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> where('timesheets.created_by', auth() -> user() -> teammember_id)
            -> where('timesheets.month', $month)
            -> whereRaw('YEAR(timesheets.date) = ?', [$year])
            -> select('timesheets.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> paginate(100);
        $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title') -> get();
        $timesheetrequest = DB:: table('timesheetrequests') -> where('createdby', auth() -> user() -> teammember_id) -> orderBy('id', 'DESC') -> first();

        if ($getauth == null) {
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

    $result = DB:: table('timesheetusers') -> select(DB:: raw('YEAR(date) as year'))
        -> distinct() -> orderBy('year', 'DESC') -> limit(5) -> get();
    $years = $result -> pluck('year');

    if (auth() -> user() -> teammember_id == 23) {
        $teammember = DB:: table('teammembers') -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
            -> where('teammembers.role_id', '15')
            -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename') -> distinct() -> get();
        //  dd($teammember);
        $month = DB:: table('timesheets')
            -> select('timesheets.month') -> distinct() -> get();


        $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> where('timesheets.created_by', $request -> teammember) -> where('timesheets.month', $request -> month)
            -> whereYear('timesheets.date', '=', $request -> year)
            -> select('timesheets.*', 'teammembers.team_member') -> get();
    } elseif(auth() -> user() -> role_id == 11 || auth() -> user() -> role_id == 18) {
        $teammember = DB:: table('teammembers') -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
            -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename') -> distinct() -> get();
        //  dd($teammember);
        $month = DB:: table('timesheets')
            -> select('timesheets.month') -> distinct() -> get();

        $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> where('timesheets.created_by', $request -> teammember) -> where('timesheets.month', $request -> month)
            -> whereYear('timesheets.date', '=', $request -> year)
            -> select('timesheets.*', 'teammembers.team_member') -> get();
    } elseif(auth() -> user() -> role_id == 13) {
        $teammember = DB:: table('timesheets')
            -> leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
            -> where('timesheetusers.partner', auth() -> user() -> teammember_id)
            -> select('teammembers.id', 'teammembers.team_member', 'roles.rolename') -> distinct() -> get();
        //  dd($teammember);
        $month = DB:: table('timesheets')
            -> select('timesheets.month') -> distinct() -> get();

        $timesheetData = DB:: table('timesheets')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
            -> where('timesheets.created_by', $request -> teammember) -> where('timesheets.month', $request -> month)
            -> whereYear('timesheets.date', '=', $request -> year)
            -> select('timesheets.*', 'teammembers.team_member') -> get();
    }
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
}


/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */

//! old code 
// public function create(Request $request)
// {
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

//     $clients = DB::table('clients')
//       ->whereIn('id', [29, 32, 33, 34])
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();

//     $client = $clientss->merge($clients);
//   } else {
//     $client = DB::table('assignmentteammappings')
//       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();
//   }
//   $assignment = Assignment::select('id', 'assignment_name')->get();
//   //   dd($assignment);
//   if ($request->ajax()) {
//     // dd(auth()->user());

//     // if (auth()->user()->role_id == 13) {
//     //   echo "<option>Select Assignment</option>";
//     //   foreach (DB::table('assignmentbudgetings')
//     //     ->where('client_id', $request->cid)
//     //      ->distinct('assignments.id')
//     //     ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//     //     ->select('assignmentbudgetings.assignmentgenerate_id', 'assignment_name', 'assignmentgenerate_id')
//     //     ->get() as $sub) {
//     //     echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//     //   }
//     // } 




//     if (isset($request->cid)) {
//       if (auth()->user()->role_id == 13) {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
//           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       } else {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')
//           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
//           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
//           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
//           ->where('assignmentbudgetings.client_id', $request->cid)
//           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       }
//     }
//     if (isset($request->assignment)) {

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

//       //        dd($request->assignment);

//       //  dd($request->assignment);


//     }
//   } else {
//     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
//   }
// }

//! old code 1
// public function create(Request $request)
// {
//   // dd($request);
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

//     $clients = DB::table('clients')
//       ->whereIn('id', [29, 32, 33, 34])
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();

//     $client = $clientss->merge($clients);
//   } else {
//     $client = DB::table('assignmentteammappings')
//       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();
//   }
//   $assignment = Assignment::select('id', 'assignment_name')->get();
//   //   dd($assignment);
//   // shahid assi
//   if ($request->ajax()) {
//     // dd(auth()->user()->id);
//     if (isset($request->cid)) {
//       if (auth()->user()->role_id == 13) {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
//           ->where('created_by', auth()->user()->id)
//           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       } else {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')
//           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
//           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
//           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
//           ->where('assignmentbudgetings.client_id', $request->cid)
//           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       }
//     }
//     if (isset($request->assignment)) {

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

//! old code 2
// public function create(Request $request)
// {
//   // dd($request);
//   // rejected timesheet details
//   $timesheetedit = DB::table('timesheetusers')
//     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
//     ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
//     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//     ->where('timesheetusers.timesheetid', 105419)
//     ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
//     ->get();
//   // 105890
//   // dd($timesheetedit);
//   // client of particular partner
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

//     $clients = DB::table('clients')
//       ->whereIn('id', [29, 32, 33, 34])
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();

//     $client = $clientss->merge($clients);
//   } else {
//     $client = DB::table('assignmentteammappings')
//       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();
//   }
//   $assignment = Assignment::select('id', 'assignment_name')->get();
//   //   dd($assignment);
//   // shahid assi
//   if ($request->ajax()) {
//     // dd(auth()->user()->id);
//     if (isset($request->cid)) {
//       if (auth()->user()->role_id == 13) {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
//           ->where('created_by', auth()->user()->id)
//           ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       } else {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')
//           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
//           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
//           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
//           ->where('assignmentbudgetings.client_id', $request->cid)
//           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//         }
//       }
//     }
//     if (isset($request->assignment)) {

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
//     return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
//   }
// }
//! old code 21-12-23
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
//     $client = DB::table('assignmentteammappings')
//       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();
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
//             ->select('clients.client_name', 'clients.id')
//             ->orderBy('client_name', 'ASC')
//             ->distinct()->get();
//           // dd($clients);
//           $id = $clients[0]->id;
//           foreach (DB::table('assignmentbudgetings')->where('client_id', $id)
//             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//             ->orderBy('assignment_name')->get() as $sub) {
//             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//           }
//         } else {
//           foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
//             ->where('created_by', auth()->user()->id)
//             ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
//             ->orderBy('assignment_name')->get() as $sub) {
//             echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
//           }
//         }
//       }
//       // assreject
//       else {
//         echo "<option>Select Assignment</option>";
//         foreach (DB::table('assignmentbudgetings')
//           ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
//           ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
//           ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
//           ->where('assignmentbudgetings.client_id', $request->cid)
//           ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//           //  ->where('assignmentteammappings.status', '!=', 0)
//           // ->whereNull('assignmentteammappings.status')
//           ->where(function ($query) {
//             $query->whereNull('assignmentteammappings.status')
//               ->orWhere('assignmentteammappings.status', '=', 1);
//           })
//           ->orderBy('assignment_name')->get() as $sub) {
//           echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
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

//! new code 21-12-23
public function create(Request $request) {
    // upadte create function and status in assignmentteammappings
    // dd(auth()->user()->teammember_id);
    $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title') -> get();
    $teammember = Teammember:: where('role_id', '!=', 11) ->with ('title', 'role') -> get();
    if (auth() -> user() -> role_id == 11) {
        $client = Client:: where('status', 1) -> select('id', 'client_name') -> orderBy('client_name', 'ASC') -> get();
    } elseif(auth() -> user() -> role_id == 13) {
        $clientss = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> where('assignmentmappings.leadpartner', auth() -> user() -> teammember_id)
            -> orwhere('assignmentmappings.otherpartner', auth() -> user() -> teammember_id)
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();
        // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        $clients = DB:: table('clients')
            -> whereIn('id', [29, 32, 33, 34])
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();

        $client = $clientss -> merge($clients);
    } else {
        // dd(auth()->user()->teammember_id);
        $clientss = DB:: table('assignmentteammappings')
            -> leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> orwhere('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
            // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
            -> whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();

        // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
        $clients = DB:: table('clients')
            -> whereIn('id', [29, 32, 33, 34])
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();

        $client = $clientss -> merge($clients);
    }
    $assignment = Assignment:: select('id', 'assignment_name') -> get();
    // dd($assignment);
    if ($request -> ajax()) {
        // dd(auth()->user()->teammember_id);
        if (isset($request -> cid)) {
            if (auth() -> user() -> role_id == 13) {
          echo "<option>Select Assignment</option>";

                if ($request -> cid == 29 || $request -> cid == 32 || $request -> cid == 33 || $request -> cid == 34) {
                    $clients = DB:: table('clients')
                        // ->whereIn('id', [29, 32, 33, 34])
                        -> where('id', $request -> cid)
                        -> select('clients.client_name', 'clients.id')
                        -> orderBy('client_name', 'ASC')
                        -> distinct() -> get();
                    // dd($clients);
                    $id = $clients[0] -> id;
                    foreach(DB:: table('assignmentbudgetings') -> where('client_id', $id)
                        -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                        -> orderBy('assignment_name') -> get() as $sub) {
              echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                    }
                } else {
                    foreach(DB:: table('assignmentbudgetings') -> where('client_id', $request -> cid)
                        -> where('created_by', auth() -> user() -> id)
                        -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                        -> orderBy('assignment_name') -> get() as $sub) {
              echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                    }
                }
            }
            // assreject
            else {
          echo "<option>Select Assignment</option>";

                if ($request -> cid == 29 || $request -> cid == 32 || $request -> cid == 33 || $request -> cid == 34) {
                    $clients = DB:: table('clients')
                        // ->whereIn('id', [29, 32, 33, 34])
                        -> where('id', $request -> cid)
                        -> select('clients.client_name', 'clients.id')
                        -> orderBy('client_name', 'ASC')
                        -> distinct() -> get();
                    // dd($clients);
                    $id = $clients[0] -> id;
                    foreach(DB:: table('assignmentbudgetings') -> where('client_id', $id)
                        -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                        -> orderBy('assignment_name') -> get() as $sub) {
              echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                    }
                } else {
                    //!old code
                    // foreach (DB::table('assignmentbudgetings')->where('client_id', $request->cid)
                    //   ->where('created_by', auth()->user()->id)
                    //   ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                    //   ->orderBy('assignment_name')->get() as $sub) {
                    //   echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
                    // }

                    //  i have add this code after kartic bindal problem 
                    foreach(DB:: table('assignmentbudgetings')
                        -> join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                        -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                        -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                        -> where('assignmentbudgetings.client_id', $request -> cid)
                        -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)

                        -> where(function ($query) {
                            $query -> whereNull('assignmentteammappings.status')
                                -> orWhere('assignmentteammappings.status', '=', 0);
                        })
                        -> orderBy('assignment_name') -> get() as $sub) {
              echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                    }
                }

                // echo "<option>Select Assignment</option>";
                // foreach (DB::table('assignmentbudgetings')
                //   ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                //   ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                //   ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                //   ->where('assignmentbudgetings.client_id', $request->cid)
                //   ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                //   //  ->where('assignmentteammappings.status', '!=', 0)
                //   // ->whereNull('assignmentteammappings.status')
                //   ->where(function ($query) {
                //     $query->whereNull('assignmentteammappings.status')
                //       ->orWhere('assignmentteammappings.status', '=', 1);
                //   })
                //   ->orderBy('assignment_name')->get() as $sub) {
                //   echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";


                //* i have removed above line 21-12-23 ko so may be occure any problem in future regarding inactive / active teammember from assignment          
                //* basically i have fixed hare sahil gupta (staff) ko off holiday nahi aa raha tha timesheet create me  if any problem in future then run old code 21-12-23
                //* end hare 


            }
        }

        if (isset($request -> assignment)) {
            // dd($request->assignment);
            if (auth() -> user() -> role_id == 11) {
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('assignmentmappings')

                    -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                    -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                    -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                    -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            } elseif(auth() -> user() -> role_id == 13) {
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('teammembers')
                    -> where('id', auth() -> user() -> teammember_id)
                    -> select('teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            } else {
          //die;
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('assignmentmappings')

                    -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                    -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                    -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                    -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            }
        }
    } else {
        return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
    }
}

//* timesheet edit fubctionality
// public function timesheetEdit(Request $request, $id)
// {

//   $timesheetedit = DB::table('timesheetusers')
//     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
//     ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
//     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
//     ->where('timesheetusers.timesheetid', $id)
//     ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
//     ->get();
//   // 105890
//   // dd($timesheetedit);
//   // client of particular partner
//   if (auth()->user()->role_id == 13) {
//     $clientss = DB::table('assignmentmappings')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
//       ->orwhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()
//       ->get();
//     // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
//     $clients = DB::table('clients')
//       ->whereIn('id', [29, 32, 33, 34])
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()
//       ->get();

//     $client = $clientss->merge($clients);
//   } else {
//     $client = DB::table('assignmentteammappings')
//       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
//       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
//       ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
//       ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
//       ->select('clients.client_name', 'clients.id')
//       ->orderBy('client_name', 'ASC')
//       ->distinct()->get();
//   }


//   // return view('backEnd.timesheet.correction', compact('timesheetedit', 'client', 'assignment'));
//   return view('backEnd.timesheet.correction', compact('timesheetedit', 'client'));
// }

//* timesheet edit fubctionality
public function timesheetEdit(Request $request, $id) {
    $timesheetedit = DB:: table('timesheetusers')
        -> leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        -> leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // ->where('timesheetusers.timesheetid', 105419)
        -> where('timesheetusers.timesheetid', $id)
        -> select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
        -> get();
    // 105890
    // dd($timesheetedit);
    // client of particular partner
    $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title') -> get();
    $teammember = Teammember:: where('role_id', '!=', 11) ->with ('title', 'role') -> get();
    if (auth() -> user() -> role_id == 11) {
        $client = Client:: where('status', 1) -> select('id', 'client_name') -> orderBy('client_name', 'ASC') -> get();
    } elseif(auth() -> user() -> role_id == 13) {
        $clientss = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> where('assignmentmappings.leadpartner', auth() -> user() -> teammember_id)
            -> orwhere('assignmentmappings.otherpartner', auth() -> user() -> teammember_id)
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();

        $clients = DB:: table('clients')
            -> whereIn('id', [29, 32, 33, 34])
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();

        $client = $clientss -> merge($clients);
    } else {
        $client = DB:: table('assignmentteammappings')
            -> leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> orwhere('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
            -> select('clients.client_name', 'clients.id')
            -> orderBy('client_name', 'ASC')
            -> distinct() -> get();
    }
    $assignment = Assignment:: select('id', 'assignment_name') -> get();
    //   dd($assignment);
    // shahid assi
    if ($request -> ajax()) {
        // dd(auth()->user()->id);
        if (isset($request -> cid)) {
            if (auth() -> user() -> role_id == 13) {
          echo "<option>Select Assignment</option>";
                foreach(DB:: table('assignmentbudgetings') -> where('client_id', $request -> cid)
                    -> where('created_by', auth() -> user() -> id)
                    -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                    -> orderBy('assignment_name') -> get() as $sub) {
            echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                }
            } else {
          echo "<option>Select Assignment</option>";
                foreach(DB:: table('assignmentbudgetings')
                    -> join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                    -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                    -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                    -> where('assignmentbudgetings.client_id', $request -> cid)
                    -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
                    -> orderBy('assignment_name') -> get() as $sub) {
            echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                }
            }
        }
        if (isset($request -> assignment)) {

            if (auth() -> user() -> role_id == 11) {
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('assignmentmappings')

                    -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                    -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                    -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                    -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            } elseif(auth() -> user() -> role_id == 13) {
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('teammembers')
                    -> where('id', auth() -> user() -> teammember_id)
                    -> select('teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            } else {
          //die;
          echo "<option value=''>Select Partner</option>";
                foreach(DB:: table('assignmentmappings')

                    -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                    -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                    -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                    -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                    -> get() as $subs) {
            echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                }
            }
        }
    } else {
        return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
    }
}

//* timesheet edit fubctionality
public function timesheeteditstore(Request $request) {
    // dd($request);
    if (!is_numeric($request -> assignment_id)) {
        $assignment = Assignmentmapping:: where('assignmentgenerate_id', $request -> assignment_id)
            -> select('assignment_id')
            -> get()
            -> toArray();
        $assignment_id = $assignment[0]['assignment_id'];
    } else {
        $assignment_id = $request -> assignment_id;
    }
    try {
        DB:: table('timesheetusers') -> where('id', $request -> timesheetusersid) -> update([
            'status'   => 3,
            'client_id'   => $request -> client_id,
            // 'assignment_id'   =>  $request->assignment_id,
            'assignment_id'   => $assignment_id,
            'partner'   => $request -> partner,
            'workitem'   => $request -> workitem,
            'createdby'   => $request -> createdby,
            'location'   => $request -> location,
            'hour'   => $request -> hour,
        ]);

        if ($request -> status == 2) {
            DB:: table('timesheetupdatelogs') -> insert([
                'timesheetusers_id'   => $request -> timesheetusersid,
                'status'   => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $output = array('msg' => 'Updated Successfully');
        // return back()->with('statuss', $output);
        return redirect() -> to('rejectedlist') ->with ('statuss', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
    //$id=77;
    // $client = Client::select('id', 'client_name')->get();
    // $time = DB::table('timesheets')->where('id', $id)->first();
    // $date = $time->date;
    // $assignment = Assignment::select('id', 'assignment_name')->get();
    // $timesheet = DB::table('timesheetusers')
    //   ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
    //   ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
    //   ->where('timesheetusers.timesheetid', $id)
    //   ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
    //   ->get();
    // //   dd($timesheet);
    // $count = count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
    // //  dd( $count);
    // // $totalhour=$timesheet->totalhour;

    // $rcount = 5 - $count;

    // return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
}

public function rejectedlist(Request $request) {
    // dd($request);
    // dd(auth()->user());
    if (auth() -> user() -> role_id == 13) {
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', auth() -> user() -> teammember_id)
            // ->where('timesheetusers.status', 2)
            -> whereIn('timesheetusers.status', [2, 3])
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> paginate(10);
        // dd($timesheetData);
    } else if (auth() -> user() -> role_id == 11) {
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            // ->where('timesheetusers.createdby', $request->teamid)
            // ->where('timesheetusers.partner', $request->partnerid)
            -> whereIn('timesheetusers.status', [2, 3])
            -> where('timesheetusers.rejectedby', auth() -> user() -> teammember_id)
            // ->whereIn('timesheetusers.status', [1, 2])
            // ->where('timesheetusers.date', '>=', $date->startdate)
            // ->where('timesheetusers.date', '<=', $date->enddate)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    } else {
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> where('timesheetusers.createdby', auth() -> user() -> teammember_id)
            -> whereIn('timesheetusers.status', [2, 3])
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> paginate(10);
        // dd($timesheetData);
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
}
// all rejected timesheet on patner for team
public function rejectedlistteam(Request $request) {
    // dd($request);
    if (auth() -> user() -> role_id == 13) {
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            // ->where('timesheetusers.status', 2)
            -> whereIn('timesheetusers.status', [2, 3])
            -> where('timesheetusers.rejectedby', auth() -> user() -> teammember_id)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    }
    // return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
    return view('backEnd.timesheet.rejectedlistteam', compact('timesheetData'));
}
public function rejectedtimesheetlog(Request $request) {
    if (auth() -> user() -> role_id == 11) {
        $timesheetData = DB:: table('timesheetusers')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            -> whereIn('timesheetusers.status', [2, 3])
            -> where('timesheetusers.rejectedby', auth() -> user() -> teammember_id)
            -> select('timesheetusers.*', 'teammembers.team_member') -> orderBy('id', 'ASC') -> get();
    }
    // elseif (auth()->user()->role_id == 13) {
    //   $timesheetData = DB::table('timesheetusers')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
    //     ->whereIn('timesheetusers.status', [2, 3])
    //     ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
    //     ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    // }
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
}

public function timesheetreject($id) {
    // dd($id);
    try {
        DB:: table('timesheetusers') -> where('id', $id) -> update([

            'status'   => 2,
            'rejectedby'   => auth() -> user() -> teammember_id,

        ]);
        // timesheet rejected mail
        $data = DB:: table('teammembers')
            -> leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            -> where('timesheetusers.id', $id)
            -> first();
        $emailData = [
            'emailid' => $data -> emailid,
            'teammember_name' => $data -> team_member,
        ];

        Mail:: send('emails.timesheetrejected', $emailData, function ($msg) use($emailData) {
            $msg-> to([$emailData['emailid']]);
        $msg -> subject('Timesheet rejected');
    });
    // timesheet rejected mail end hare


    $output = array('msg' => 'Rejected Successfully');
    return back() ->with ('statuss', $output);
} catch (Exception $e) {
    DB:: rollBack();
    Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
    report($e);
    $output = array('msg' => $e -> getMessage());
    return back() -> withErrors($output) -> withInput();
}
  }

public function timesheetajax() {
    if ($request -> ajax()) {
        //  dd($request);
        if (isset($request -> cid)) {
        echo "<option>Select Assignment</option>";
            foreach(DB:: table('assignmentbudgetings') -> where('client_id', $request -> cid)
                -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                -> orderBy('assignment_name') -> get() as $sub) {
          echo "<option value='".$sub -> id. "'>".$sub -> assignment_name. "</option>";
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

//! old code
// public function store(Request $request)
// {

//   // dd(auth()->user()->teammember_id);

//   try {

//     $data = $request->except(['_token', 'teammember_id', 'amount']);

//     //	if ($request->date < '11-09-2023') {
//     //dd('hi');
//     // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
//     //  return back()->with('success', $output);
//     //   }

//     //die;
//     //? dd(date('w', strtotime($request->date))); // 4
//     if (date('w', strtotime($request->date)) == 0) {
//       $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
//       $previousSaturdayFilled = DB::table('timesheetusers')
//         ->where('createdby', auth()->user()->teammember_id)
//         ->where('date', $previousSaturday)
//         ->where('status', 1)
//         ->first();
//       // dd('hi1', $previousSaturdayFilled);
//       if ($previousSaturdayFilled != null) {
//         $output = array('msg' => 'You already submitted for this week');
//         return back()->with('success', $output);
//       }
//     }

//     $hours = $request->input('totalhour');
//     if (!is_numeric($hours) || $hours > 12) {
//       $output = array('msg' => 'The total hours cannot be greater than 12');
//       return back()->with('success', $output);
//     }


//     $previouschck = DB::table('timesheetusers')
//       ->where('createdby', auth()->user()->teammember_id)
//       ->where('date', date('Y-m-d', strtotime($request->date)))
//       ->where('status', 1)
//       ->first();

//     dd('hi2', $previouschck);
//     if ($previouschck != null) {
//       //dd('hi');
//       $output = array('msg' => 'You already submitted for this week');
//       return back()->with('success', $output);
//     }

//     $previoussavechck = DB::table('timesheetusers')
//       ->where('createdby', auth()->user()->teammember_id)
//       ->where('date', date('Y-m-d', strtotime($request->date)))
//       ->where('status', 0)
//       ->first();

//     dd('hi3', $previoussavechck);
//     if ($previoussavechck != null) {
//       //dd('hi');
//       $output = array('msg' => 'You already submitted for this date');
//       return back()->with('success', $output);
//     }



//     $currentDate = Carbon::now()->format('d-m-Y');
//     //dd($currentHour);
//     // if ($currentDate == $request->date && Carbon::now()->hour < 18) {
//     //   //dd('hi');
//     //   $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
//     //   return back()->with('success', $output);
//     // }

//     $leaves = DB::table('applyleaves')
//       ->where('applyleaves.createdby', auth()->user()->teammember_id)
//       ->where('status', '!=', 2)
//       ->select('applyleaves.from', 'applyleaves.to')
//       ->get();

//     foreach ($leaves as $leave) {
//       //Convert each data from table to Y-m-d format to compare
//       $days = CarbonPeriod::create(
//         date('Y-m-d', strtotime($leave->from)),
//         date('Y-m-d', strtotime($leave->to))
//       );

//       foreach ($days as $day) {
//         $leavess[] = $day->format('Y-m-d');
//       }
//     }
//     $currentday = date('Y-m-d', strtotime($request->date));
//     // $ifcount=0;
//     //  $elsecount=0;

//     if (count($leaves) != 0) {
//       //dd('if');
//       foreach ($leavess as $leave) {
//         // echo"<pre>";
//         //  print_r($leave);

//         if ($leave == $currentday) {
//           //dd('if');
//           // $ifcount=$ifcount+1;
//           $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
//           return redirect('timesheet')->with('statuss', $output);
//         }
//       }
//     }
//     $id = DB::table('timesheets')->insertGetId(
//       [
//         'created_by' => auth()->user()->teammember_id,
//         'month'     =>    date('F', strtotime($request->date)),
//         'date'     =>    date('Y-m-d', strtotime($request->date)),
//         'created_at'          =>     date('Y-m-d H:i:s'),
//       ]
//     );
//     // dd('else');
//     $count = count($request->assignment_id);
//     // dd($count);
//     for ($i = 0; $i < $count; $i++) {
//       //dd($request->workitem[$i]);
//       $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

//       $a = DB::table('timesheetusers')->insert([
//         'date'     =>     $request->date,
//         'client_id'     =>     $request->client_id[$i],
//         'workitem'     =>     $request->workitem[$i],
//         'location'     =>     $request->location[$i],
//         //   'billable_status'     =>     $request->billable_status[$i],
//         'timesheetid'     =>     $id,
//         'date'     =>     date('Y-m-d', strtotime($request->date)),
//         'hour'     =>     $request->hour[$i],
//         'totalhour' =>      $request->totalhour,
//         'assignment_id'     =>     $assignment->assignment_id,
//         'partner'     =>     $request->partner[$i],
//         'createdby' => auth()->user()->teammember_id,
//         'created_at'          =>     date('Y-m-d H:i:s'),
//         'updated_at'              =>    date('Y-m-d H:i:s'),
//       ]);
//     }


//     //Attendance code

//     $hdatess = date('Y-m-d', strtotime($request->date));
//     $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
//     $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
//     $currentDate = new DateTime();
//     $currentMonth = $currentDate->format('F');
//     //dd($month);
//     //   if ($currentDate->format('j') > 25) {
//     //     $currentDate->modify('-1 month');
//     //     $currentMonth = $currentDate->format('F');
//     // }



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
//     return redirect('timesheet')->with('success', $output);
//   } catch (Exception $e) {
//     DB::rollBack();
//     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
//     report($e);
//     $output = array('msg' => $e->getMessage());
//     return back()->withErrors($output)->withInput();
//   }
// }
//! working on new joining teammember
public function store(Request $request) {
    try {
        $Newteammeber = DB:: table('timesheetusers')
            -> where('createdby', auth() -> user() -> teammember_id)
            -> first();

        $Newteammeberjoining_date = DB:: table('teammembers')
            -> where('id', auth() -> user() -> teammember_id)
            -> select('joining_date')
            -> first();
        $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date -> joining_date));

        // if user not created any timesheet in that case ,it means new teammeber 
        if ($Newteammeber == null) {
            // Get previuse sunday from joining date
            $joining_timestamp = strtotime($joining_date);
            $day_of_week = date('w', $joining_timestamp);
            $days_to_subtract = $day_of_week;
            $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

            $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
            // Get all dates beetween two dates 
            $startDate = Carbon:: parse($previous_sunday_date);
            $endDate = Carbon:: parse($joining_date);
            $period = CarbonPeriod:: create($startDate, $endDate);
            // store all date in $result vairable
            $result = [];
            foreach($period as $key => $date) {
                if ($key !== 0 && $key !== count($period) - 1) {
                    $result[] = $date -> toDateString();
                }
            }
            // return $result;
            // dd('yes', $result);
            foreach($result as $date) {
                // $a = DB::table('timesheetusers')->insert([
                //   'date'        => date('Y-m-d', strtotime($date)),
                //   'createdby'   => auth()->user()->teammember_id,
                //   'created_at'  => date('Y-m-d H:i:s'),
                //   'updated_at'  => date('Y-m-d H:i:s'),
                // ]);

                $id = DB:: table('timesheets') -> insertGetId(
                    [
                        'created_by' => auth() -> user() -> teammember_id,
                        'month'     => date('F', strtotime($date)),
                        'date'     => date('Y-m-d', strtotime($date)),
                        'created_at'          => date('Y-m-d H:i:s'),
                    ]
                );
                DB:: table('timesheetusers') -> insert([
                    'date'     => date('Y-m-d', strtotime($date)),
                    'client_id'     => 29,
                    'workitem'     => 'NA',
                    'location'     => 'NA',
                    //   'billable_status'     =>     $request->billable_status[$i],
                    'timesheetid'     => $id,
                    'date'     => date('Y-m-d', strtotime($date)),
                    'hour'     => 0,
                    'totalhour' => 0,
                    'assignment_id'     => 213,
                    'partner'     => 887,
                    'createdby' => auth() -> user() -> teammember_id,
                    'created_at'          => date('Y-m-d H:i:s'),
                    'updated_at'              => date('Y-m-d H:i:s'),
                ]);
            }
        }


        $requestDate = Carbon:: parse($request -> date);
        $joiningDate = Carbon:: parse($joining_date);

        if ($requestDate >= $joiningDate) {
            $data = $request -> except(['_token', 'teammember_id', 'amount']);
            //	if ($request->date < '11-09-2023') {
            //dd('hi');
            // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
            //  return back()->with('success', $output);
            //   }

            //die;
            //? dd(date('w', strtotime($request->date))); // 4
            if (date('w', strtotime($request -> date)) == 0) {
                $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request -> date)));
                $previousSaturdayFilled = DB:: table('timesheetusers')
                    -> where('createdby', auth() -> user() -> teammember_id)
                    -> where('date', $previousSaturday)
                    -> where('status', 1)
                    -> first();
                // dd('hi1', $previousSaturdayFilled);
                if ($previousSaturdayFilled != null) {
                    $output = array('msg' => 'You already submitted for this week');
                    return back() ->with ('success', $output);
                }
            }

            // check hour
            $hours = $request -> input('totalhour');
            if (!is_numeric($hours) || $hours > 12) {
                $output = array('msg' => 'The total hours cannot be greater than 12');
                return back() ->with ('success', $output);
            }
            // dd(auth()->user()->teammember_id);
            //? dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"
            $previouschck = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> where('date', date('Y-m-d', strtotime($request -> date)))
                -> where('status', 1)
                -> first();

            if ($previouschck != null) {
                //dd('hi');
                $output = array('msg' => 'You already submitted for this week');
                return back() ->with ('success', $output);
            }

            $previoussavechck = DB:: table('timesheetusers')
                -> where('createdby', auth() -> user() -> teammember_id)
                -> where('date', date('Y-m-d', strtotime($request -> date)))
                -> where('status', 0)
                -> first();

            if ($previoussavechck != null) {
                //dd('hi');
                $output = array('msg' => 'You already submitted for this date');
                return back() ->with ('success', $output);
            }



            $currentDate = Carbon:: now() -> format('d-m-Y');
            //dd($currentHour);

            // if ($currentDate == $request->date && Carbon::now()->hour < 18) {
            //   //dd('hi');
            //   $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
            //   return back()->with('success', $output);
            // }

            $leaves = DB:: table('applyleaves')
                -> where('applyleaves.createdby', auth() -> user() -> teammember_id)
                -> where('status', '!=', 2)
                -> select('applyleaves.from', 'applyleaves.to')
                -> get();
            // dd('hi 1', $leaves);
            foreach($leaves as $leave) {
                //Convert each data from table to Y-m-d format to compare
                $days = CarbonPeriod:: create(
                    date('Y-m-d', strtotime($leave -> from)),
                    date('Y-m-d', strtotime($leave -> to))
                );

                foreach($days as $day) {
                    $leavess[] = $day -> format('Y-m-d');
                }
            }
            // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"
            $currentday = date('Y-m-d', strtotime($request -> date));
            // dd('hi 2', $currentday);
            // $ifcount=0;
            //  $elsecount=0;

            if (count($leaves) != 0) {
                //dd('if');
                foreach($leavess as $leave) {
                    // echo"<pre>";
                    //  print_r($leave);

                    if ($leave == $currentday) {
                        //dd('if');
                        // $ifcount=$ifcount+1;
                        $output = array('msg' => 'You Have Leave for the Day ('.date('d-m-Y', strtotime($leave)). ')');
                        return redirect('timesheet') ->with ('statuss', $output);
                    }
                }
            }
            // insert data in timesheet from request and get id 
            $id = DB:: table('timesheets') -> insertGetId(
                [
                    'created_by' => auth() -> user() -> teammember_id,
                    'month'     => date('F', strtotime($request -> date)),
                    'date'     => date('Y-m-d', strtotime($request -> date)),
                    'created_at'          => date('Y-m-d H:i:s'),
                ]
            );

            $count = count($request -> assignment_id);
            // dd('hi 3', $count);
            for ($i = 0; $i < $count; $i++) {
                //dd($request->workitem[$i]);
                $assignment = DB:: table('assignmentmappings') -> where('assignmentgenerate_id', $request -> assignment_id[$i]) -> first();

                $a = DB:: table('timesheetusers') -> insert([
                    'date'     => $request -> date,
                    'client_id'     => $request -> client_id[$i],
                    'workitem'     => $request -> workitem[$i],
                    'location'     => $request -> location[$i],
                    //   'billable_status'     =>     $request->billable_status[$i],
                    'timesheetid'     => $id,
                    'date'     => date('Y-m-d', strtotime($request -> date)),
                    'hour'     => $request -> hour[$i],
                    'totalhour' => $request -> totalhour,
                    'assignment_id'     => $assignment -> assignment_id,
                    'partner'     => $request -> partner[$i],
                    'createdby' => auth() -> user() -> teammember_id,
                    'created_at'          => date('Y-m-d H:i:s'),
                    'updated_at'              => date('Y-m-d H:i:s'),
                ]);
            }
        } else {
            // dd(auth()->user()->teammember_id);
            $output = array('msg' => 'You can not fill timesheet before :'.$joining_date);
            return redirect('timesheet') ->with ('success', $output);
        }







        //Attendance code

        $hdatess = date('Y-m-d', strtotime($request -> date));
        $day = DateTime:: createFromFormat('Y-m-d', $hdatess) -> format('d');      //
        $month = DateTime:: createFromFormat('Y-m-d', $hdatess) -> format('F');   //
        $currentDate = new DateTime();
        $currentMonth = $currentDate -> format('F');
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
            $dateTime = DateTime:: createFromFormat('Y-m-d', $hdatess);
            $dateTime -> modify('+1 month');
            $month = $dateTime -> format('F');
        }
        if ($month != $currentMonth && $day < 25) {
            $dateTime = DateTime:: createFromFormat('Y-m-d', $hdatess);
            $month = $dateTime -> format('F');
        }
        if ($month == $currentMonth && $day > 25) {

            $dateTime = DateTime:: createFromFormat('Y-m-d', $hdatess);
            $dateTime -> modify('+1 month');
            $month = $dateTime -> format('F');
        }

        //dd($month);


        $column = $dates[$day];

        $attendances = DB:: table('attendances') -> where('employee_name', auth() -> user() -> teammember_id)
            -> where('month', $month) -> first();

        if ($attendances == null) {
            $teammember = DB:: table('teammembers') -> where('id', auth() -> user() -> teammember_id) -> first();

            $a = DB:: table('attendances') -> insert([
                'employee_name'         => auth() -> user() -> teammember_id,
                'month'         => $month,
                'dateofjoining' => $teammember -> joining_date,
                'created_at'          => date('Y-m-d H:i:s'),
                //   'exam_leave'      =>$value->date_total,
            ]);
            //dd($a);
        }


        //   dd($noofdaysaspertimesheet);

        $updatedtotalhour = $request -> totalhour;
        if ($attendances != null && property_exists($attendances, $column)) {
            if ($attendances -> $column != "LWP") {
                $updatedtotalhour = $request -> totalhour + $attendances -> $column;
            }
        }
        DB:: table('attendances')
            -> where('employee_name', auth() -> user() -> teammember_id)
            -> where('month', $month)
            -> update([$column => $updatedtotalhour]);


        //end attendance


        $output = array('msg' => 'Create Successfully');
        return redirect('timesheet') ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}

public function timesheetUpload(Request $request) {
    $request -> validate([
        'file' => 'required'
    ]);

    try {
        $file = $request -> file;
        //  dd($file);
        $data = $request -> except(['_token']);
        $dataa = Excel:: toArray(new Timesheetimport, $file);
        //     dd($dataa);
        foreach($dataa[0] as $key => $value) {
            //  $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();

            //    if($informationresource == null){
            $db['clientname'] = $request -> clientname;
            $db['assignmentname'] = $request -> assignmentname;
            $db['workitem'] = $request -> workitem;
            //  $db['billable_status'] = $request->billable_status;
            $db['hour'] = $request -> hour;
            //   dd($request->clientname);
            if ($request -> clientname != NULL) {
                $client_id = clients:: where('client_name', $value['clientname']) -> pluck('id') -> first();
                //    dd($client_id);
                if ($assignmentname != NULL) {
                    $assignment_id = assignments:: where('assignment_name', $value['assignmentname']) -> pluck('id') -> first();
                }
            }


            //  'createdby' => auth()->user()->teammember_id,
            //     Timesheet::Create($db);

            //       }

        }
        //dd($dataa);
        $output = array('msg' => 'Excel file upload Successfully');
        return back() ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
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

public function edit($id) {
    //dd($date);
    //$id=77;
    $client = Client:: select('id', 'client_name') -> get();
    $time = DB:: table('timesheets') -> where('id', $id) -> first();
    $date = $time -> date;
    $assignment = Assignment:: select('id', 'assignment_name') -> get();
    $timesheet = DB:: table('timesheetusers')
        -> leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        -> leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        -> where('timesheetusers.timesheetid', $id)
        -> select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
        -> get();
    //   dd($timesheet);
    $count = count($timesheet = DB:: table('timesheetusers') -> where('timesheetusers.date', $date) -> get());
    //  dd( $count);
    // $totalhour=$timesheet->totalhour;

    $rcount = 5 - $count;

    return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
}
public function view($id) {
    //  dd($id);
    $timesheet = timesheet:: where('id', $id) -> first();
    return view('backEnd.timesheet.view', compact('id', 'timesheet'));
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Outstationconveyance  $outstationconveyance
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id) {
    try {
        $data = $request -> except(['_token']);
        $count = count($request -> assignment_id);
        // dd($count);
        $timesheet = DB:: table('timesheets') -> where('date', $request -> date) -> delete ();

        for ($i = 0; $i < $count; $i++) {
            DB:: table('timesheets') -> insert([
                'client_id'     => $request -> client_id[$i],
                'workitem'     => $request -> workitem[$i],
                //    'billable_status'     =>     $request->billable_status[$i],
                'hour'     => $request -> hour[$i],
                'assignment_id'     => $request -> assignment_id[$i],
                'createdby' => auth() -> user() -> teammember_id,
                'updatedby' => auth() -> user() -> teammember_id,
                'date'      => $request -> date,
                'totalhour' => $request -> totalhour,
                'created_at'          => date('y-m-d'),
                'updated_at'              => date('y-m-d'),
            ]);
        }

        $output = array('msg' => 'Updated Successfully');
        return back() ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\Outstationconveyance  $outstationconveyance
 * @return \Illuminate\Http\Response
 */
public function destroy($id) {
    // dd($id);
    try {
        $getid = DB:: table('timesheetusers') -> where('id', $id) -> first();
        // dd($getid);
        DB:: table('timesheets') -> where('id', $getid -> timesheetid) -> delete ();
        DB:: table('timesheetusers') -> where('id', $id) -> delete ();
        $output = array('msg' => 'Deleted Successfully');
        return back() ->with ('statuss', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}
//! old code before timesheet multiple request
// public function timesheetrequestStore(Request $request)
// {
//   try {
//     $data = $request->except(['_token']);
//     // dd($data);

//     $id = DB::table('timesheetrequests')->insertGetId([
//       'partner'     =>     $request->partner,
//       'reason'     =>     $request->reason,
//       'status'     =>     0,
//       'createdby' => auth()->user()->teammember_id,
//       'created_at'          =>     date('Y-m-d H:i:s'),
//       'updated_at'              =>    date('Y-m-d H:i:s'),
//     ]);
//     // dd($id); 74

//     //     $travel = Assetprocurement::where('id', $id)->first();
//     // timesheet request mail to admin
//     $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
//     $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

//     $data = array(
//       'teammember' => $name ?? '',
//       'email' => $teammembermail ?? '',
//       'id' => $id ?? '',
//     );
//     Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
//       $msg->to($data['email']);
//       $msg->subject('Timesheet Submission Request');
//     });
//     // timesheet request mail to admin
//     $output = array('msg' => 'Request Successfully');
//     return back()->with('success', $output);
//   } catch (Exception $e) {
//     DB::rollBack();
//     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
//     report($e);
//     $output = array('msg' => $e->getMessage());
//     return back()->withErrors($output)->withInput();
//   }
// }

// // Store timesheet request. timereq
// public function timesheetrequestStore(Request $request)
// {
//   try {
//     $data = $request->except(['_token']);
//     // dd($data);

//     $latestrequest = DB::table('timesheetrequests')
//       ->where('createdby', auth()->user()->teammember_id)
//       ->latest()
//       ->select('created_at')
//       ->first();
//     // dd($latestrequest);
//     $latestrequesthour = Carbon::parse($latestrequest->created_at);
//     $currentDateTime = Carbon::now();
//     // Check if the difference is more than 24 hours
//     if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
//       $id = DB::table('timesheetrequests')->insertGetId([
//         'partner'     =>     $request->partner,
//         'reason'     =>     $request->reason,
//         'status'     =>     0,
//         'createdby' => auth()->user()->teammember_id,
//         'created_at'          =>     date('Y-m-d H:i:s'),
//         'updated_at'              =>    date('Y-m-d H:i:s'),
//       ]);

//       // timesheet request mail to admin
//       $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
//       $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

//       $data = array(
//         'teammember' => $name ?? '',
//         'email' => $teammembermail ?? '',
//         'id' => $id ?? '',
//       );
//       Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
//         $msg->to($data['email']);
//         $msg->subject('Timesheet Submission Request');
//       });
//       // timesheet request mail to admin
//       $output = array('msg' => 'Request Successfully');
//       return back()->with('success', $output);
//     } else {
//       $output = array('msg' => 'You can submit new timesheet request after 24 hour');
//       return back()->with('statuss', $output);
//     }
//   } catch (Exception $e) {
//     DB::rollBack();
//     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
//     report($e);
//     $output = array('msg' => $e->getMessage());
//     return back()->withErrors($output)->withInput();
//   }
// }

// Store timesheet request. timereq 2
public function timesheetrequestStore(Request $request) {
    try {
        $data = $request -> except(['_token']);
        // dd($data);

        $latestrequest = DB:: table('timesheetrequests')
            -> where('createdby', auth() -> user() -> teammember_id)
            -> latest()
            -> select('created_at', 'status')
            -> first();
        // dd($latestrequest);

        if ($latestrequest != null && $latestrequest -> status != 2) {
            $latestrequesthour = Carbon:: parse($latestrequest -> created_at);
            // dd($latestrequest->created_at);
            $currentDateTime = Carbon:: now();
            // Check if the difference is more than 24 hours
            if ($latestrequesthour -> diffInHours($currentDateTime) > 24) {
                $id = DB:: table('timesheetrequests') -> insertGetId([
                    'partner'     => $request -> partner,
                    'reason'     => $request -> reason,
                    'status'     => 0,
                    'createdby' => auth() -> user() -> teammember_id,
                    'created_at'          => date('Y-m-d H:i:s'),
                    'updated_at'              => date('Y-m-d H:i:s'),
                ]);

                // timesheet request mail to admin
                $teammembermail = Teammember:: where('id', $request -> partner) -> pluck('emailid') -> first();
                $name = Teammember:: where('id', auth() -> user() -> teammember_id) -> pluck('team_member') -> first();

                $data = array(
                    'teammember' => $name ?? '',
                    'email' => $teammembermail ?? '',
                    'id' => $id ?? '',
                );
                Mail:: send('emails.timesheetrequestform', $data, function ($msg) use($data) {
                    $msg-> to($data['email']);
                $msg -> subject('Timesheet Submission Request');
            });
            // timesheet request mail to admin
            $output = array('msg' => 'Request Successfully');
            return back() ->with ('success', $output);
        } else {
            $output = array('msg' => 'You can submit new timesheet request after 24 hour from '.date('h-m-s', strtotime($latestrequest -> created_at)));
            return back() ->with ('statuss', $output);
        }
    } else {
        $id = DB:: table('timesheetrequests') -> insertGetId([
            'partner'     => $request -> partner,
            'reason'     => $request -> reason,
            'status'     => 0,
            'createdby' => auth() -> user() -> teammember_id,
            'created_at'          => date('Y-m-d H:i:s'),
            'updated_at'              => date('Y-m-d H:i:s'),
        ]);

        // timesheet request mail to admin
        $teammembermail = Teammember:: where('id', $request -> partner) -> pluck('emailid') -> first();
        $name = Teammember:: where('id', auth() -> user() -> teammember_id) -> pluck('team_member') -> first();

        $data = array(
            'teammember' => $name ?? '',
            'email' => $teammembermail ?? '',
            'id' => $id ?? '',
        );
        Mail:: send('emails.timesheetrequestform', $data, function ($msg) use($data) {
            $msg-> to($data['email']);
        $msg -> subject('Timesheet Submission Request');
    });
    // timesheet request mail to admin
    $output = array('msg' => 'Request Successfully');
    return back() ->with ('success', $output);
}
    } catch (Exception $e) {
    DB:: rollBack();
    Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
    report($e);
    $output = array('msg' => $e -> getMessage());
    return back() -> withErrors($output) -> withInput();
}
  }

public function timesheetrequestlist() {
    $timesheetrequestlist = DB:: table('timesheetrequests')
        -> leftjoin('timesheetusers', 'clients.client_id', 'timesheetrequests.id')
        -> leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
        -> leftjoin('teammembers as team', 'team.id', 'timesheetrequests.partner')
        -> leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.createdby')
        -> where('timesheetrequests.createdby', auth() -> user() -> teammember_id)
        -> where('timesheetrequests.partner', auth() -> user() -> teammember_id)
        -> select('timesheetrequests.*', 'teammembers.team_member') -> orderBy('id', 'DESC') -> paginate(200);
    // dd($timesheetData);

    return view('backEnd.timesheet.timesheetrequest', compact('timesheetrequestlist'));
}


//Report

public function Reportsection(Request $request) {

    $employeename = Teammember:: where('role_id', '!=', 11) -> where('status', 1) ->with ('title', 'role') -> get();
    $client = Client:: select('id', 'client_name') -> get();
    $assignment = Assignment:: select('id', 'assignment_name') -> get();
    $partner = Teammember:: where('role_id', '=', 13) -> where('status', 1) ->with ('title', 'role') -> get();

    $result = DB:: table('timesheetusers') -> select(DB:: raw('YEAR(date) as year'))
        -> distinct() -> orderBy('year', 'DESC') -> limit(5) -> get();
    $years = $result -> pluck('year');

    //dd($assignment);
    if ($request -> ajax()) {
        //   dd($request);
        if (isset($request -> cid)) {
            $clientdata = explode(",", $request -> cid);
        echo "<option value=''>Select Assignment</option>";
            foreach(DB:: table('timesheetusers') -> whereIn('client_id', $clientdata)
                -> leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                -> orderBy('assignment_name') -> distinct() -> get(['assignments.id', 'assignments.assignment_name']) as $sub) {
          echo "<option value='".$sub -> id. "'>".$sub -> assignment_name. "</option>";
            }
        }

        if (isset($request -> clientid)) {
            $clientdata = explode(",", $request -> clientid);
        echo "<option value=''>Select Employee</option>";
            foreach(DB:: table('timesheetusers') -> whereIn('client_id', $clientdata)
                -> leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                -> orderBy('team_member') -> distinct() -> get(['teammembers.id', 'teammembers.team_member']) as $sub) {
          echo "<option value='".$sub -> id. "'>".$sub -> team_member. "</option>";
            }
        }

        if (isset($request -> ass_id)) {
            //dd($request->ass_id);;
            $ass_data = explode(",", $request -> ass_id);
        //dd($ass_data);


        echo "<option value=''>Select Partner</option>";
            foreach(DB:: table('teammembers')
                -> leftjoin('timesheetusers', 'timesheetusers.partner', 'teammembers.id')
                -> whereIn('timesheetusers.assignment_id', $ass_data)
                -> distinct() -> get(['teammembers.id', 'teammembers.team_member']) as $subs) {
          echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
            }
            //   die;
        }
    } else {
        return view('backEnd.timesheet.reportsection', compact('employeename', 'client', 'assignment', 'partner', 'years'));
    }
}

public function filtersection(Request $request) {
    //dd($request);
    if ($request -> ajax()) {
        $clients = collect(is_array($request -> clientid) ? $request -> clientid : explode(',', $request -> clientid)) -> filter();
        $employeeIds = collect(is_array($request -> employeeid) ? $request -> employeeid : explode(',', $request -> employeeid)) -> filter();
        $assignmentIds = collect(is_array($request -> assignmentid) ? $request -> assignmentid : explode(',', $request -> assignmentid)) -> filter();
        $partners = collect(is_array($request -> partnerid) ? $request -> partnerid : explode(',', $request -> partnerid)) -> filter();
        //$dateRange = collect(is_array($request->daterange) ? $request->daterange : explode(' - ', $request->daterange))->filter();
        // $dateRange = collect(explode(' - ', $request->daterange))->filter();
        //[$startDate, $endDate] = $dateRange->map(fn ($date) => Carbon::parse($date));

        $date = explode(" - ", $request -> daterange);
        // dd($date);
        $start = Carbon:: parse($date[0]);
        $end = Carbon:: parse($date[1]);

        $now = Carbon:: now();
        $noww = Carbon:: parse($now);
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

        $query1 = $request -> workitem;
        $query1 = str_replace(' ', '%', $query1);

        if ($request -> month == 0) {
            $timesheetData = Timesheetusers:: join('clients', 'clients.id', 'timesheetusers.client_id')
                -> leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                -> leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
                -> leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->with (['client', 'assignment', 'createdBy', 'partner'])
            -> when($clients -> isNotEmpty(), fn($query) => $query -> whereIn('client_id', $clients))
                -> when($employeeIds -> isNotEmpty(), fn($query) => $query -> whereIn('timesheetusers.createdby', $employeeIds))
                -> when($assignmentIds -> isNotEmpty(), fn($query) => $query -> whereIn('assignment_id', $assignmentIds))
                -> when($partners -> isNotEmpty(), fn($query) => $query -> whereIn('partner', $partners))
                //  ->when($financial_year !='2025', fn ($query) => $query->whereYear('date', $financial_year))

                -> when($daterange == 1, function ($query) use($start, $end) {
                    $query-> whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
                    -> whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
                    -> orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
                    -> whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
        })
        //		   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
        //  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
        //->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
        //   ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
        //  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
        //	})

        -> when($request -> billableid, fn($query) => $query -> where('billable_status', $request -> billableid))
            -> when($request -> month != 0, fn($query) => $query -> whereMonth('timesheetusers.date', $request -> month))
            -> when($query1, fn($query) => $query -> where('workitem', 'like', "%$query1%"))
            -> where('teammembers.status', '!=', 0)
            -> select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as 				partnername')
            -> get();
    } else {
        $timesheetData = Timesheetusers:: join('clients', 'clients.id', 'timesheetusers.client_id')
            -> leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
            -> leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
            -> leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            ->with (['client', 'assignment', 'createdBy', 'partner'])
        -> when($clients -> isNotEmpty(), fn($query) => $query -> whereIn('client_id', $clients))
            -> when($employeeIds -> isNotEmpty(), fn($query) => $query -> whereIn('timesheetusers.createdby', $employeeIds))
            -> when($assignmentIds -> isNotEmpty(), fn($query) => $query -> whereIn('assignment_id', $assignmentIds))
            -> when($partners -> isNotEmpty(), fn($query) => $query -> whereIn('partner', $partners))

            //		->when($request->yearly !=2025, fn ($query) => $query->whereYear('timesheetusers.date', $request->yearly))

            -> when($daterange == 1, function ($query) use($start, $end) {
                $query-> whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
                -> whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
                -> orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
                -> whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
    })
    //			   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
    //	  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
    //     ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
    //    ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
    //    ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
    //	})

    // ->when($startDate && $endDate, fn ($query) => $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate))
    -> when($request -> billableid, fn($query) => $query -> where('billable_status', $request -> billableid))
        -> when($request -> month, fn($query) => $query -> whereMonth('timesheetusers.date', $request -> month))
        -> when($query1, fn($query) => $query -> where('workitem', 'like', "%$query1%"))
        -> where('teammembers.status', '!=', 0)
        -> select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as partnername')
        -> get();
}

return response() -> json($timesheetData);
    }
  }
}














22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
22222222222222222222222222222222222222222222222222222222222
vijay kumar

public function timesheetsubmission(Request $request) {
    // dd($request);
    try {
        $usertimesheetfirstdate = DB:: table('timesheets')
            -> where('status', '0')
            -> where('created_by', auth() -> user() -> teammember_id) -> orderBy('date', 'ASC') -> first();
        $lastdate = Carbon:: createFromFormat('Y-m-d', $usertimesheetfirstdate -> date ?? '') -> addDays(6);

        if ($usertimesheetfirstdate) {
            $firstDate = new DateTime($usertimesheetfirstdate -> date);
            $dayOfWeek = $firstDate -> format('w');
            $daysToAdd = 0;

            if ($dayOfWeek !== '0') {
                $daysToAdd = 7 - $dayOfWeek;
            } else {
                $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                return back() ->with ('success', $output);
            }

            if ($dayOfWeek > 0) {
                $daysToSubtract = $dayOfWeek - 1;
            } else {
                $daysToSubtract = $dayOfWeek;
            }

            $upcomingSunday = (new DateTime($firstDate -> format('Y-m-d'))) -> modify("+$daysToAdd days") -> format('Y-m-d');

            $presentWeekMonday = (new DateTime($firstDate -> format('Y-m-d'))) -> modify("-$daysToSubtract days") -> format('Y-m-d');
        }


        $get_six_Data = DB:: table('timesheets')
            -> where('status', '0')
            -> where('created_by', auth() -> user() -> teammember_id)
            -> whereBetween('date', [$firstDate -> format('Y-m-d'), $upcomingSunday])
            -> orderBy('date', 'ASC')
            -> get();

        $lastdate = $get_six_Data -> max('date');
        // dd($get_six_Data);

        $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

        foreach($get_six_Data as $entry) {
            $date = new DateTime($entry -> date);
            $retrievedDates[] = $date -> format('Y-m-d');
        }

        $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

        $firstDate = new DateTime($presentWeekMonday);

        $upcomingSundayDate = new DateTime($upcomingSunday);


        // Clone $firstDate so that it is not modified
        $currentDate = clone $firstDate;

        while ($currentDate -> format('Y-m-d') < $upcomingSundayDate -> format('Y-m-d')) {  //excluding sunday
            $expectedDates[] = $currentDate -> format('Y-m-d');


            $currentDate -> modify("+1 day");
        }

        $missingDates = array_diff($expectedDates, $retrievedDates);

        // dd($retrievedDates);
        // 0 => "2021-06-07"
        // 1 => "2021-06-08"
        // 2 => "2021-06-09"
        // 3 => "2021-06-10"
        // 4 => "2021-06-11"


        // dd($missingDates);
        // 5 => "2021-06-12"
        // dd($expectedDates);

        // 0 => "2021-06-07"
        // 1 => "2021-06-08"
        // 2 => "2021-06-09"
        // 3 => "2021-06-10"
        // 4 => "2021-06-11"
        // 5 => "2021-06-12"
        if (!empty($missingDates)) {
            $missingDatesString = implode(', ', $missingDates);
            // "2023-11-13, 2023-11-14"

            $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
            return back() ->with ('success', $output);
        } else {

            foreach($get_six_Data as $getsixdata) {
                // dd('hi', $getsixdata);

                // Convert the requested date to a Carbon instance
                $requestedDate = Carbon:: createFromFormat('Y-m-d', $getsixdata -> date);


                if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata -> date)))) == 'Monday') {

                    $previousMonday = $requestedDate -> copy() -> previous(Carbon:: MONDAY);

                    // Find the nearest next Saturday to the requested date
                    $nextSaturday = $requestedDate -> copy() -> next(Carbon:: SATURDAY);

                    // Format the dates in 'Y-m-d' format
                    $previousMondayFormatted = $getsixdata -> date;
                    $nextSaturdayFormatted = $nextSaturday -> format('Y-m-d');
                    $nextSaturdayFormatted = $lastdate;


                    $week = date('d-m-Y', strtotime($previousMondayFormatted)). ' to '.date('d-m-Y', strtotime($nextSaturdayFormatted));

                    //------------------- Shahid's code start---------------------
                    $co = DB:: table('timesheetusers')
                        -> where('createdby', auth() -> user() -> teammember_id)
                        -> whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                        -> select(DB:: raw('SUM(hour) as total_hours'), DB:: raw('COUNT(DISTINCT timesheetid) as row_count'))
                        -> get();


                    // dd($co);
                    foreach($co as $codata) {
                        DB:: table('timesheetreport') -> insert([
                            'teamid'       => auth() -> user() -> teammember_id,
                            'week'       => $week,
                            'totaldays'       => $codata -> row_count,
                            'totaltime' => $codata -> total_hours,
                            // 'partnerid'  => $codata->partner,
                            'startdate'  => $previousMondayFormatted,
                            'enddate'  => $nextSaturdayFormatted,
                            // 'created_at'                =>       date('y-m-d'),
                            'created_at'                => date('y-m-d H:i:s'),
                        ]);
                    }

                    // dd($co);
                }



                DB:: table('timesheetusers') -> where('timesheetid', $getsixdata -> id) -> update([
                    'status'         => 1,
                    'updated_at'              => date('y-m-d'),
                ]);
                DB:: table('timesheets') -> where('id', $getsixdata -> id) -> update([
                    'status'         => 1,
                    'updated_at'              => date('y-m-d'),
                ]);
            }
        }


        $output = array('msg' => 'Timesheet Submit Successfully');
        return back() ->with ('success', $output);
    } catch (Exception $e) {
        DB:: rollBack();
        Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
        report($e);
        $output = array('msg' => $e -> getMessage());
        return back() -> withErrors($output) -> withInput();
    }
}

22222222222222222222222222222222222222222222222222222222222



public function timesheet_teamlist() {
    if (auth() -> user() -> role_id == 13) {
        // get all partner
        $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title')
        -> orderBy('team_member', 'asc') -> get();

        $get_date = DB:: table('timesheetreport')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
            -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
            -> where('timesheetreport.partnerid', auth() -> user() -> teammember_id)
            -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
            -> latest() -> get();
    } else {
        $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title')
        -> orderBy('team_member', 'asc') -> get();
        $get_date = DB:: table('timesheetreport')
            -> leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
            -> leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
            -> where('timesheetreport.teamid', auth() -> user() -> teammember_id)
            -> select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
            -> latest() -> get();
    }

    // dd($get_datess);


    // $groupedData = $get_datess->groupBy('week')->map(function ($group) {
    //   $firstItem = $group->first();

    //   return [
    //     'id' => $firstItem->id,
    //     'teamid' => $firstItem->teamid,
    //     'week' => $firstItem->week,
    //     'totaldays' => $group->sum('totaldays'),
    //     'totaltime' => $group->sum('totaltime'),
    //     'startdate' => $firstItem->startdate,
    //     'enddate' => $firstItem->enddate,
    //     'partnername' => $firstItem->partnername,
    //     'created_at' => $firstItem->created_at,
    //     'team_member' => $firstItem->team_member,
    //     'partnerid' => $firstItem->partnerid,
    //   ];
    // });

    // $get_date = collect($groupedData->values());

    // $groupedData = $get_datess->groupBy('week')->map(function ($group) {
    //   $firstItem = $group->first();

    //   return (object)[
    //     'id' => $firstItem->id,
    //     'teamid' => $firstItem->teamid,
    //     'week' => $firstItem->week,
    //     'totaldays' => $group->sum('totaldays'),
    //     'totaltime' => $group->sum('totaltime'),
    //     'startdate' => $firstItem->startdate,
    //     'enddate' => $firstItem->enddate,
    //     'partnername' => $firstItem->partnername,
    //     'created_at' => $firstItem->created_at,
    //     'team_member' => $firstItem->team_member,
    //     'partnerid' => $firstItem->partnerid,
    //   ];
    // });

    // $get_date = collect($groupedData->values());


    // dd($get_date);

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
}








222222222222222222222222222

{
    {
        -- @foreach($get_date as $jobDatas)
            < tr >
        <td><a
                href="{{ url(
                    '/weeklylist?' .
                        'id=' .
                        $jobDatas['id'] .
                        '&&' .
                        'teamid=' .
                        $jobDatas['teamid'] .
                        '&&' .
                        'partnerid=' .
                        $jobDatas['partnerid'] .
                        '&&' .
                        'startdate=' .
                        $jobDatas['startdate'] .
                        '&&' .
                        'enddate=' .
                        $jobDatas['enddate'],
                ) }}">{{ $jobDatas['team_member'] }}</a>
        </td>
        <td>{{ $jobDatas['week'] }}</td>
        <td>{{ $jobDatas['totaldays'] }}</td>
        <td>{{ $jobDatas['totaltime'] }}</td>

    </tr >
            @endforeach--
    }
}
22222222222222222222222222222222222222222222222222222222222










{#2757 ▼
    +"id": 132
        + "leavetype": "11"
            + "type": null
                + "examtype": null
                    + "otherexam": null
                        + "from": "2023-12-16"
                            + "to": "2023-12-24"
                                + "report": ""
                                    + "reasonleave": "Exam leave"
                                        + "approver": 878
                                            + "createdby": 844
                                                + "status": 0
                                                    + "updatedby": null
                                                        + "created_at": "2023-12-15 13:16:37"
                                                            + "updated_at": "2023-12-15 13:16:37"
                                                                + "emailid": "sunnygupta@vsa.co.in"
                                                                    + "team_member": "Sunny Gupta"
                                                                        + "rolename": "Partner"
                                                                            + "name": "Exam Leave"
                                                                                + "holiday": 18
                                                                                    + "examrequestId": 3
                                                                                        + "date": "2023-12-20"
}
array: 5[▼
0 => "2023-12-21"
1 => "2023-12-22"
2 => "2023-12-23"
3 => "2023-12-24"
  ]








2222222222222222222222222
app\Http\Controllers\TimesheetrequestController.php
'enddate'  => $nextSaturdayFormatted,
    2222222222222222222222
PAT100323 PAT100324

exampleleaveshow
$role_id = auth() -> user() -> teammember_id;
$teamapplyleaveDatas = DB:: table('applyleaves')
    -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    -> leftjoin('roles', 'roles.id', 'teammembers.role_id')

    -> select('applyleaves.*', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name') -> get();
// dd($applyleaveDatas);
return view('backEnd.applyleave.teamapplication', compact(
    'teammember',
    'countCasualafmnth',
    'teammonthcount',
    'totalcountCasual',
    'teamapplyleaveDatas',
    'birthday',
    'countbirthday',
    'Casual',
    'Sick',
    'countSick',
    'countCasual',
    'role_id',
    'clInAttendance',
    'slInAttendance',

));
222222222222222222222222222222222222222222222222222222222
    / timesheetrequest / store
dd($currentDateTime);
// $latestrequesthour =  date('H', strtotime($latestrequest->created_at));
// dd($latestrequesthour);
$currenthour = date('H');
// dd($currenthour);
222222222222222222222222222222222222222222222222222222222
app\Http\Controllers\AssignmentController.php

    < td >
    @if ($teammemberData -> assignmentteammappingsStatus == 2)
    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/1/' . $teammemberData->id) }}"
        onclick="return confirm('Are you sure you want to Active this teammember?');">
        <button class="btn btn-danger" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal">Inactive</button>
    </a>
@elseif($teammemberData -> assignmentteammappingsStatus == 0 || $teammemberData -> assignmentteammappingsStatus == 1)
<a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/2/' . $teammemberData->id) }}"
    onclick="return confirm('Are you sure you want to Inactive this teammember?');">
    <button class="btn btn-primary" data-toggle="modal"
        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
        data-target="#requestModal">Active</button>
</a>
@endif
                                                        </td >
    222222222222222222222222222222222222222222222222222222222
ass rejected
public function yearWise(Request $request) {
    if (auth() -> user() -> role_id == 11) {
        $clientid = $request -> clientid;
        $assignmentmappingData = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            -> where('clients.id', $request -> clientid)
            -> where('assignmentmappings.year', $request -> year)
            -> select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'clients.client_name'
            ) -> distinct() -> get();
        return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    } elseif(auth() -> user() -> role_id == 13) {
        $clientid = $request -> clientid;
        $assigned = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            -> where('clients.id', $request -> clientid)
            -> where('assignmentmappings.year', $request -> year)
            -> where('assignmentmappings.leadpartner', auth() -> user() -> teammember_id)
            -> select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.assignmentname'
            ) -> distinct() -> get();

        $otherassigned = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            -> where('clients.id', $request -> clientid)
            -> where('assignmentmappings.year', $request -> year)
            -> where('assignmentmappings.otherpartner', auth() -> user() -> teammember_id)
            -> select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignments.assignment_name',
                'clients.client_name',
                'assignmentbudgetings.assignmentname'
            ) -> distinct() -> get();
        return view('backEnd.assignmentmapping.yearwisepartnerlist', compact('assigned', 'otherassigned', 'clientid'));
    } else {
        // assrejected
        $clientid = $request -> clientid;
        $assignmentmappingData = DB:: table('assignmentmappings')
            -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
            -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
            -> where('clients.id', $request -> clientid)
            -> where('assignmentmappings.year', $request -> year)
            -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
            // assignment block task 
            -> where('assignmentteammappings.status', 1)
            -> orWhereNull('assignmentteammappings.status')
            // ->whereIn('assignmentteammappings.status', ['null', 1])
            -> select(
                'assignmentmappings.*',
                'assignmentbudgetings.duedate',
                'assignmentbudgetings.assignmentname',
                'assignments.assignment_name',
                'assignmentteammappings.status as assignmentteammappingsstatus',
                'clients.client_name'
            ) -> distinct() -> get();
        // assrejected
        // dd($assignmentmappingData);
        return view('backEnd.assignmentmapping.yearwise', compact('assignmentmappingData', 'clientid'));
    }
}














2222222222222222222222222222222222222222222222222222222222222222222



@if ($teammemberData -> assignmentteammappingsStatus == null || $teammemberData -> assignmentteammappingsStatus == 1)
    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/0/' . $teammemberData->id) }}"
        onclick="return confirm('Are you sure you want to Inactive this teammember?');">
        <button class="btn btn-primary" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal">Active</button>
    </a>
@elseif($teammemberData -> assignmentteammappingsStatus == 0)
{
    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/1/' . $teammemberData->id) }}"
        onclick="return confirm('Are you sure you want to Active this teammember?');">
        <button class="btn btn-danger" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal">Inactive</button>
    </a>
}
@endif
{
    {
        --                 
    < li class="nav-item dropdown notification" >
        <a class="nav-link dropdown-toggle badge-dot" href="#" data-toggle="dropdown">
            <i class="typcn typcn-bell"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <h6 class="notification-title">Notifications</h6>
            <p class="notification-text">You have {{ count($clientnotification) }} unread notification</p>
            <div class="notification-list">
                @foreach ($clientnotification as $clientnotificationdata)
                    <div class="media new"
                        style="color: {{ $clientnotificationdata->read_at ? 'black' : 'red' }}">
                        <a href="{{ url('notification/' . $clientnotificationdata->id) }}">
                            <div class="media-body">
                                <h6>{{ $clientnotificationdata->title }}</h6>
                                <span>{{ date('F d', strtotime($clientnotificationdata->created_at)) }}
                                    {{ date('h:ia', strtotime($clientnotificationdata->created_at)) }}</span>
                            </div>
                        </a>
                    </div>
                    <!--/.media -->
                @endforeach
            </div>
            <!--/.notification -->
            <div class="dropdown-footer"><a href="{{ url('notification') }}">View All Notification</a></div>
        </div>
        <!--/.dropdown-menu -->
    </li >
    < !--/.dropdown--> --}}





        $requestdata = Timesheetrequest:: where('id', $id) -> get() -> toArray();
        $createdbyid = $requestdata[0]['createdby'];
        // dd($createdbyid);
        // $allrestrequest = Timesheetrequest::where('createdby', $createdbyid)->where('status', 0)->get();
        $allrestrequest = DB:: table('timesheetrequests') -> where('createdby', $createdbyid) -> where('status', 0) -> get();
        dd($allrestrequest);



        @if (
            (now() -> isSunday() && now() -> hour >= 18) ||
            now() -> isMonday() ||
            now() -> isTuesday() ||
            now() -> isWednesday() ||
            now() -> isThursday() ||
            now() -> isFriday() ||
            (now() -> isSaturday() && now() -> hour <= 18))
            @if ($timesheetcount >= 6)
            <li class="breadcrumb-item"><a
                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
            </li>
        @endif
        @endif
        // if ($Newteammeber == null) {
        //   $Newteammeberjoining_date = DB::table('teammembers')
        //     ->where('id', auth()->user()->teammember_id)
        //     ->select('joining_date')
        //     ->first();
        //   $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));

        //   $joining_date = $joining_date; // Replace this with your actual joining date

        //   // Convert the joining date to a timestamp
        //   $joining_timestamp = strtotime($joining_date);

        //   // Calculate the day of the week for the joining date (0 for Sunday, 1 for Monday, and so on)
        //   $day_of_week = date('w', $joining_timestamp);

        //   // Calculate the number of days to subtract to reach the previous Sunday
        //   $days_to_subtract = $day_of_week;

        //   // Calculate the timestamp of the previous Sunday
        //   $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        //   // Format the previous Sunday date in the desired format
        //   $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);

        //   // Output the result
        //   dd($previous_sunday_date);
        // }

        $teammemberNeverFilled = DB:: table('teammembers')
            -> leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            -> whereNull('timesheetusers.createdby')
            -> where('teammembers.status', 1)
            // ->whereIn('teammembers.status', [1, 0])
            -> whereIn('teammembers.role_id', [14, 15, 13])
            -> select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
            -> get();


        dd($teammemberNeverFilled);




 // This code for saved  but not submitted timesheets
        // $teammemberOnlySave = DB::table('teammembers')
        //     ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        //     ->whereBetween('timesheetusers.date', [now()->subWeeks(2), now()->subWeeks(1)])
        //     ->where('timesheetusers.status', 0)
        //     ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        //     ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        //     ->havingRaw('SUM(timesheetusers.status = 0) >= 7')
        //     ->get();

        // dd($teammemberOnlySave);
        // $teammemberOnlySave = DB::table('teammembers')
        //     ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        //     ->whereBetween('timesheetusers.date', [now()->subWeeks(2), now()->subWeeks(1)])
        //     ->where('timesheetusers.status', 0)
        //     ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        //     ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        //     ->havingRaw('SUM(IF(timesheetusers.status = 0, 1, 0)) >= 7')
        //     ->get();

        // dd($teammemberOnlySave);

task name timesheet rejected 
rejectedby column add in timesheetusers
timesheetupdatelogs table create



        2222222222222


task name dublicate client assignment
i have checked all roll 
replace index function in
            app\Http\Controllers\AssignmentmappingController.php

        public function index() {
            if (auth() -> user() -> role_id == 11 || auth() -> user() -> role_id == 12 || auth() -> user() -> role_id == 18) {
                $assignmentmappingData = DB:: table('assignmentmappings')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    //  ->leftjoin('assignmentteammappings','assignmentteammappings.assignmentmapping_id','assignmentmappings.id')
                    // ->where('clients.status',1)
                    -> select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code') -> distinct() -> get();
                //   dd($assignmentmappingData);
                return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
            } elseif(auth() -> user() -> role_id == 13) {
                $assignmentmappingData = DB:: table('assignmentmappings')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    -> where(function ($query) {
                        $query -> where('assignmentmappings.leadpartner', auth() -> user() -> teammember_id)
                            -> orWhere('assignmentmappings.otherpartner', auth() -> user() -> teammember_id);
                    })
                    -> where('assignmentbudgetings.status', 1)
                    -> select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                    -> distinct() -> get();
                return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
            } elseif(auth() -> user() -> role_id == 14 || auth() -> user() -> role_id == 15) {
                $assignmentmappingData = DB:: table('assignmentmappings')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                    -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                    -> select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                    // ->where('clients.status', 0)
                    -> where('assignmentbudgetings.status', 1)
                    -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id) -> distinct() -> get();

                return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
            }
        else {
                $assignmentmappingData = DB:: table('assignmentmappings')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')

                    -> select('assignmentbudgetings.client_id', 'clients.client_name', 'clients.client_code')
                    -> where('clients.status', 1)
                    -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id) -> distinct() -> get();

                return view('backEnd.assignmentmapping.index', compact('assignmentmappingData'));
            }
        }

        222222222222222222222222222

replace this code in
            app\Http\Controllers\AssignmentmappingController.php






        app\Http\Controllers\TimesheetController.php
        //! running code 2
        public function create(Request $request) {
            // dd(auth()->user()->teammember_id);
            $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title') -> get();
            $teammember = Teammember:: where('role_id', '!=', 11) ->with ('title', 'role') -> get();
            if (auth() -> user() -> role_id == 11) {
                $client = Client:: where('status', 1) -> select('id', 'client_name') -> orderBy('client_name', 'ASC') -> get();
            } elseif(auth() -> user() -> role_id == 13) {
                $clientss = DB:: table('assignmentmappings')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    -> where('assignmentmappings.leadpartner', auth() -> user() -> teammember_id)
                    -> orwhere('assignmentmappings.otherpartner', auth() -> user() -> teammember_id)
                    -> select('clients.client_name', 'clients.id')
                    -> orderBy('client_name', 'ASC')
                    -> distinct() -> get();
                // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
                $clients = DB:: table('clients')
                    -> whereIn('id', [29, 32, 33, 34])
                    -> select('clients.client_name', 'clients.id')
                    -> orderBy('client_name', 'ASC')
                    -> distinct() -> get();

                $client = $clientss -> merge($clients);
            } else {
                $client = DB:: table('assignmentteammappings')
                    -> leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
                    -> leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
                    -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                    -> orwhere('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
                    -> select('clients.client_name', 'clients.id')
                    -> orderBy('client_name', 'ASC')
                    -> distinct() -> get();
            }
            $assignment = Assignment:: select('id', 'assignment_name') -> get();
            // dd($assignment);
            if ($request -> ajax()) {
                // dd(auth()->user()->teammember_id);
                if (isset($request -> cid)) {
                    if (auth() -> user() -> role_id == 13) {
        echo "<option>Select Assignment</option>";

                        if ($request -> cid == 29 || $request -> cid == 32 || $request -> cid == 33 || $request -> cid == 34) {
                            $clients = DB:: table('clients')
                                // ->whereIn('id', [29, 32, 33, 34])
                                -> where('id', $request -> cid)
                                -> select('clients.client_name', 'clients.id')
                                -> orderBy('client_name', 'ASC')
                                -> distinct() -> get();
                            // dd($clients);
                            $id = $clients[0] -> id;
                            foreach(DB:: table('assignmentbudgetings') -> where('client_id', $id)
                                -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                -> orderBy('assignment_name') -> get() as $sub) {
            echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                            }
                        } else {
                            foreach(DB:: table('assignmentbudgetings') -> where('client_id', $request -> cid)
                                -> where('created_by', auth() -> user() -> id)
                                -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                -> orderBy('assignment_name') -> get() as $sub) {
            echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                            }
                        }
                    } else {
        echo "<option>Select Assignment</option>";
                        foreach(DB:: table('assignmentbudgetings')
                            -> join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                            -> leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                            -> leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                            -> where('assignmentbudgetings.client_id', $request -> cid)
                            -> where('assignmentteammappings.teammember_id', auth() -> user() -> teammember_id)
                            -> orderBy('assignment_name') -> get() as $sub) {
          echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                        }
                    }
                }

                if (isset($request -> assignment)) {

                    if (auth() -> user() -> role_id == 11) {
        echo "<option value=''>Select Partner</option>";
                        foreach(DB:: table('assignmentmappings')

                            -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                            -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                            -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                            -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                            -> get() as $subs) {
          echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                        }
                    } elseif(auth() -> user() -> role_id == 13) {
        echo "<option value=''>Select Partner</option>";
                        foreach(DB:: table('teammembers')
                            -> where('id', auth() -> user() -> teammember_id)
                            -> select('teammembers.id', 'teammembers.team_member')
                            -> get() as $subs) {
          echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                        }
                    } else {
        //die;
        echo "<option value=''>Select Partner</option>";
                        foreach(DB:: table('assignmentmappings')

                            -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                            -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                            -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                            -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                            -> get() as $subs) {
          echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                        }
                    }
                }

                // 22222222222

                // 22222222222
            } else {
                return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
            }
        }






        app\Http\Controllers\AssignmentmappingController.php

        public function create(Request $request) {

            $partner = Teammember:: where('role_id', '=', 13) -> where('status', '=', 1) ->with ('title')
            -> orderBy('team_member', 'asc') -> get();
            $teammember = Teammember:: where('status', '1') -> whereIn('role_id', [14, 15]) ->with ('title', 'role')
            -> orderBy('team_member', 'asc') -> get();
            //dd($teammember);
            if ($request -> ajax()) {

                // if (isset($request->category_id)) {
                //     // dd($request->category_id);
                //     echo "<option>Please Select One</option>";
                //     foreach (Assignment::leftJoin('assignmentbudgetings', function ($join) {
                //         $join->on('assignments.id', 'assignmentbudgetings.assignment_id');
                //     })->where('assignmentbudgetings.client_id', $request->category_id)
                //         ->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate', 'assignmentbudgetings.assignmentname')->get() as $sub) {

                //         echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '( ' . $sub->assignmentgenerate_id . ' )' . '( ' . $sub->assignmentname . ' )' . "</option>";
                //     }
                //     // assignmentgenerate_id
                // }
                $assignment = Assignment:: select('id', 'assignment_name') -> get();
                if (isset($request -> category_id)) {
                    // echo "<option>Please Select One</option>";
                    if (auth() -> user() -> role_id == 13) {
                echo "<option>Select Assignment</option>";

                        if ($request -> category_id == 29 || $request -> category_id == 32 || $request -> category_id == 33 || $request -> category_id == 34) {
                            $clients = DB:: table('clients')
                                // ->whereIn('id', [29, 32, 33, 34])
                                -> where('id', $request -> category_id)
                                -> select('clients.client_name', 'clients.id')
                                -> orderBy('client_name', 'ASC')
                                -> distinct() -> get();
                            // dd($clients);
                            $id = $clients[0] -> id;
                            foreach(DB:: table('assignmentbudgetings') -> where('client_id', $id)
                                -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                -> orderBy('assignment_name') -> get() as $sub) {
                        echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                            }
                        } else {
                            foreach(DB:: table('assignmentbudgetings') -> where('client_id', $request -> category_id)
                                -> where('created_by', auth() -> user() -> id)
                                -> leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                                -> orderBy('assignment_name') -> get() as $sub) {
                        echo "<option value='".$sub -> assignmentgenerate_id. "'>".$sub -> assignment_name. '( '.$sub -> assignmentgenerate_id. ' )'. "</option>";
                            }
                        }
                    }

                    // if (isset($request->assignment)) {
                    //     if (auth()->user()->role_id == 13) {
                    //         echo "<option value=''>Select Partner</option>";
                    //         foreach (DB::table('teammembers')
                    //             ->where('id', auth()->user()->teammember_id)
                    //             ->select('teammembers.id', 'teammembers.team_member')
                    //             ->get() as $subs) {
                    //             echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
                    //         }
                    //     }
                    // }
                    if (isset($request -> assignment)) {

                        if (auth() -> user() -> role_id == 11) {
                    echo "<option value=''>Select Partner</option>";
                            foreach(DB:: table('assignmentmappings')

                                -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                                -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                                -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                                -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                                -> get() as $subs) {
                        echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                            }
                        } elseif(auth() -> user() -> role_id == 13) {
                    echo "<option value=''>Select Partner</option>";
                            foreach(DB:: table('teammembers')
                                -> where('id', auth() -> user() -> teammember_id)
                                -> select('teammembers.id', 'teammembers.team_member')
                                -> get() as $subs) {
                        echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                            }
                        } else {
                    //die;
                    echo "<option value=''>Select Partner</option>";
                            foreach(DB:: table('assignmentmappings')

                                -> leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                                -> leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
                                -> where('assignmentmappings.assignmentgenerate_id', $request -> assignment)
                                -> select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
                                -> get() as $subs) {
                        echo "<option value='".$subs -> id. "'>".$subs -> team_member. "</option>";
                            }
                        }
                    }
                    // dd($request->category_id);
                    // $assignments = Assignment::leftJoin('assignmentbudgetings', function ($join) {
                    //     $join->on('assignments.id', '=', 'assignmentbudgetings.assignment_id');
                    // })->leftJoin('assignmentmappings', function ($join) {
                    //     $join->on('assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id');
                    // })
                    //     ->where('assignmentbudgetings.client_id', $request->category_id)
                    //     // get data only that is not matches assignmentmappings.assignmentgenerate_id from assignmentbudgetings table
                    //     ->whereNull('assignmentmappings.assignmentgenerate_id')
                    //     ->select('assignments.*', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.duedate', 'assignmentbudgetings.assignmentname')
                    //     ->get();

                    // foreach ($assignments as $sub) {
                    //     echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '( ' . $sub->assignmentgenerate_id . ' )' . '( ' . $sub->assignmentname . ' )' . "</option>";
                    // }
                }
            } else {
                if (auth() -> user() -> role_id == 11 || auth() -> user() -> role_id == 12) {
                    $client = Client:: where('status', 1) -> latest() -> get();
                    return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'partner'));
                } else {
                    $client = DB:: table('assignmentbudgetings')
                        -> leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
                        -> Where('assignmentbudgetings.created_by', auth() -> user() -> id)
                        -> select('clients.client_name', 'clients.id')
                        -> distinct() -> get();

                    //	DB::table('clients')->
                    //  orWhere('clients.leadpartner',auth()->user()->teammember_id)->
                    //  orWhere('clients.createdbyadmin_id',auth()->user()->id)->
                    //	 orWhere('clients.updatedbyadmin_id',auth()->user()->id)->
                    //   select('clients.client_name','clients.id')->get();

                    return view('backEnd.assignmentmapping.create', compact('client', 'teammember', 'assignment', 'partner'));
                }
            }
        }
















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

        22222222222222222222222222222222222222

        Route:: get('/zip', [ZipController:: class, 'download']);
        // Route::get('/hi', [AssignmentfolderfileController::class, 'zipfile'])->name('hi');
        // Route::get('/hi', [FileController::class, 'zipfile'])->name('hi');
        Route:: get('/hi/{assignmentfolder_id}', [FileController:: class, 'zipfile']) -> name('hi');
        Route:: get('/get-file-content/{fileName}', [FileController:: class, 'getFileContent']);


        public function store(Request $request) {
            // dd(auth()->user()->teammember_id);
            $request -> validate([
                'particular' => 'required',
                'file' => 'required',
            ]);

            try {
                $data = $request -> except(['_token']);
                $files = [];

                if ($request -> hasFile('file')) {
                    foreach($request -> file('file') as $file) {
                        $name = $file -> getClientOriginalName();
                        $path = $file -> storeAs('public\image\task', $name);
                        $files[] = $name;
                    }
                }
                foreach($files as $filess) {
                    // dd($auth()->user()->teammember_id);
                    // dd($files); die;
                    $s = DB:: table('assignmentfolderfiles') -> insert([
                        'particular' => $request -> particular,
                        'assignmentgenerateid' => $request -> assignmentgenerateid,
                        'assignmentfolder_id' => $request -> assignmentfolder_id,
                        'createdby' => auth() -> user() -> teammember_id,
                        'filesname' => $filess,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                $output = array('msg' => 'Submit Successfully');
                return back() ->with ('success', ['message' => $output, 'success' => true]);
            } catch (Exception $e) {
                // dd($e);
                DB:: rollBack();
                Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
                report($e);
                $output = array('msg' => $e -> getMessage());
                return back() -> withErrors($output) -> withInput();
            }
        }


        222222222222222222

            < div class="table-responsive" >
                <table id="examplee" class="table display table-bordered table-striped table-hover basic">
                    {{-- < div >
                        <a href="{{ route('hi') }}" class="btn btn-primary">Download Zip</a>
                        </div> --}
}
                        <div>
                            @if (isset($assignmentfolderfile[0]->assignmentfolder_id))
                                <a href="{{ route('hi', ['assignmentfolder_id' => $assignmentfolderfile[0]->assignmentfolder_id]) }}"
                                    class="btn btn-primary">Download Zip</a>
                            @endif
                        </div>
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>File</th>
                                <th>Created By</th>
                                <th>Date</th>
                                @if ($assignmentbudgeting->status == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                dd($assignmentfolderfile[0]->assignmentfolder_id);
                            @endphp --}}
                            @foreach ($assignmentfolderfile as $assignmentfolderData)
                                <tr>
                                    {{-- @php
                                        dd($assignmentfolderData->assignmentfolder_id);
                                    @endphp --}}

                                    <td>{{ $assignmentfolderData->particular }}</td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
                                            {{ $assignmentfolderData->filesname ?? '' }}
                                        </a>
                                    </td>
                                    <td>{{ $assignmentfolderData->team_member }} ( {{ $assignmentfolderData->staffcode }}
                                        )</td>
                                    <td>{{ date('F d,Y', strtotime($assignmentfolderData->created_at)) }}
                                        {{ date('h:i A', strtotime($assignmentfolderData->created_at)) }} </td>
                                    @if ($assignmentbudgeting->status == 1)
                                        <td> <a href="{{ url('/bulkfile/delete/' . $assignmentfolderData->id) }}"
                                                onclick="return confirm('Are you sure you want to delete this item?');"
                                                class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table >
                </div >


    22222222222222222222

public function zipfile(Request $request, $assignmentfolder_id) {
    // dd($assignmentfolder_id);

    // $userId = auth()->user()->id;
    $fileName = DB:: table('assignmentfolderfiles') -> where('assignmentfolder_id', $assignmentfolder_id) -> get();

    $zipFileName = 'mannat.zip';
    $zip = new ZipArchive;

    if ($zip -> open($zipFileName, ZipArchive:: CREATE) === TRUE) {
        foreach($fileName as $file) {
            // file path
            $filePath = storage_path('app/public/image/task/'.$file -> filesname);
            if (File:: exists($filePath)) {
                $zip -> addFile($filePath, $file -> filesname);
            }
        }
        $zip -> close();
    }
    return response() -> download($zipFileName) -> deleteFileAfterSend(true);
}


2222222222222222

extension = zip
btn btn - secondary
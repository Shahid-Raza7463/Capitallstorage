{{-- *   --}}
{{-- *   --}}
{{-- * filtering functionality   --}}


{{-- filtering functionality --}}

{{-- ! runnig for patner --}}
{{-- <div class="row row-sm">
                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">All Partner</label>
                                  <select class="language form-control" id="category1" name="partnersearch">
                                      <option value="">Please Select One</option>
                                      @foreach ($partner as $teammemberData)
                                          <option value="{{ $teammemberData->id }}">
                                              {{ $teammemberData->team_member }}
                                          </option>
                                      @endforeach
                                  </select>

                              </div>
                          </div>

                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">Start Date</label>
                                  <input type="date" class="form-control" id="start" name="start">

                              </div>
                          </div>
                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">End Date</label>
                                  <input type="date" class="form-control" name="end" id="end">
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Timesheet Filled Day</label>
                                  <select class="language form-control" id="category3" name="totaldays">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->totaldays, $displayedValues))
                                              <option value="{{ $jobDatas->totaldays }}">
                                                  {{ $jobDatas->totaldays }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->totaldays;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="col-3">
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
                                                  {{ $jobData->totaltime }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobData->totaltime;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                      </div> --}}
<div class="row row-sm">
    <div class="col-3">
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
                            {{ $jobDatas->team_member }}
                        </option>
                        @php
                            $displayedValues[] = $jobDatas->team_member;
                        @endphp
                    @endif
                @endforeach
            </select>
        </div>
    </div>


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
    {{-- <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Total Timesheet Filled Day</label>
                                <select class="language form-control" id="category3" name="totaldays">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($get_date as $jobDatas)
                                        @if (!in_array($jobDatas->totaldays, $displayedValues))
                                            <option value="{{ $jobDatas->totaldays }}">
                                                {{ $jobDatas->totaldays }}
                                            </option>
                                            @php
                                                $displayedValues[] = $jobDatas->totaldays;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

    <div class="col-3">
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
                            {{ $jobData->totaltime }}
                        </option>
                        @php
                            $displayedValues[] = $jobData->totaltime;
                        @endphp
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    {{-- <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner</label>
                                <select class="language form-control" id="category1" name="partnersearch">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($get_date as $jobDatas)
                                        @if (!in_array($jobDatas->partnername, $displayedValues))
                                            <option value="{{ $jobDatas->partnerid }}">
                                                {{ $jobDatas->partnername }}
                                            </option>
                                            @php
                                                $displayedValues[] = $jobDatas->partnername;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select> --}}

    {{-- <select class="language form-control" id="category1" name="partnersearch">
                                  <option value="">Please Select One</option>
                                  @foreach ($partner as $teammemberData)
                                      <option value="{{ $teammemberData->id }}">
                                          {{ $teammemberData->team_member }}
                                      </option>
                                  @endforeach
                              </select> --}}
    {{-- 
                            </div>
                        </div> --}}
</div>
{{-- * condition on foreach loop / outside of foreach loop / notification / message   --}}

@php
    $hasUnreadNotification = false;
    foreach ($clientnotification as $clientnotificationdata) {
        if ($clientnotificationdata->readstatus == 0) {
            $hasUnreadNotification = true;
            break;
        }
    }
@endphp

<li class="nav-item dropdown notification">
    <a class="nav-link dropdown-toggle {{ $hasUnreadNotification ? 'badge-dot' : '' }}" href="#"
        data-toggle="dropdown">
        <i class="typcn typcn-bell"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <h6 class="notification-title">Notifications</h6>
        <p class="notification-text">You have {{ count($clientnotification) }} unread notification</p>
        <div class="notification-list">
            @foreach ($clientnotification as $clientnotificationdata)
                <div class="media new">
                    <a href="{{ url('notification/' . $clientnotificationdata->id) }}"
                        style="color: {{ $clientnotificationdata->readstatus == 1 ? 'Black' : 'red' }}">
                    </a>
                </div>
                <!--/.media -->
            @endforeach

</li>


{{-- * table heading hide / action hide / any column hide according condition    --}}

<thead>
    <tr>
        <th>Date of Request</th>
        <th>Employee</th>
        <th>Leave Type</th>
        <th>Approver</th>
        <th>Reason for Leave</th>
        <th> Leave Period</th>
        <th>Days</th>
        <th>Status</th>
        @foreach ($myapplyleaveDatas as $applyleaveDatas)
            @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
                <th>Action</th>
            @endif
        @endforeach
    </tr>
</thead>
@foreach ($myapplyleaveDatas as $applyleaveDatas)
    <td>
        @if ($applyleaveDatas->status == 0)
            <span class="badge badge-pill badge-warning">Created</span>
        @elseif($applyleaveDatas->status == 1)
            <span class="badge badge-success">Approved</span>
        @elseif($applyleaveDatas->status == 2)
            <span class="badge badge-danger">Rejected</span>
        @endif
    </td>
    <td>
        @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
            <button class="btn btn-danger" data-toggle="modal"
                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                data-target="#requestModal{{ $applyleaveDatas->id }}">Request</button>
        @endif
    </td>
@endforeach



{{-- * excell and pdf download / table asc and desc order   --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 30,
            dom: 'Bfrtip',
            "order": [
                [1, "asc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{-- hide excell button ya othser button --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            "dom": 'Bfrtip',
            "order": [
                [1, "desc"]
            ],

            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>
{{-- * first element   --}}
<td>
    @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
        <button class="btn btn-danger" data-toggle="modal"
            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
            data-target="#requestModal{{ $applyleaveDatas->id }}">Request</button>
    @endif
</td>
{{-- * 2 column in one row  --}}

<tr>
    <td><b>Leave : </b></td>
    <td>{{ $applyleave->name }}</td>
    <td><b>Raised By :</b></td>
    <td>{{ $applyleave->team_member }}</td>
</tr>
{{-- * persentage display   --}}

<td>

    @php
        $totalFields = 26; // 30 column
        $filledFields = 0;

        $filledFields += !empty($teammemberData->id) ? 1 : 0;
        $filledFields += !empty($teammemberData->team_member) ? 1 : 0;
        $filledFields += !empty($teammemberData->profilepic) ? 1 : 0;
        $filledFields += !empty($teammemberData->staffcode) ? 1 : 0;
        $filledFields += !empty($teammemberData->role->rolename) ? 1 : 0;
        $filledFields += !empty($teammemberData->designation) ? 1 : 0;
        $filledFields += !empty($teammemberData->mobile_no) ? 1 : 0;
        $filledFields += !empty($teammemberData->dateofbirth) ? 1 : 0;
        $filledFields += !empty($teammemberData->joining_date) ? 1 : 0;
        $filledFields += !empty($teammemberData->department) ? 1 : 0;
        $filledFields += !empty($teammemberData->emailid) ? 1 : 0;
        $filledFields += !empty($teammemberData->personalemail) ? 1 : 0;
        $filledFields += !empty($teammemberData->communicationaddress) ? 1 : 0;
        $filledFields += !empty($teammemberData->permanentaddress) ? 1 : 0;
        $filledFields += !empty($teammemberData->adharcardnumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->aadharupload) ? 1 : 0;
        $filledFields += !empty($teammemberData->pancardno) ? 1 : 0;
        $filledFields += !empty($teammemberData->panupload) ? 1 : 0;
        $filledFields += !empty($teammemberData->emergencycontactnumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->nameofbank) ? 1 : 0;
        $filledFields += !empty($teammemberData->bankaccountnumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->ifsccode) ? 1 : 0;
        $filledFields += !empty($teammemberData->mothername) ? 1 : 0;
        $filledFields += !empty($teammemberData->mothernumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->cancelcheque) ? 1 : 0;
        $filledFields += !empty($teammemberData->fathername) ? 1 : 0;
        $filledFields += !empty($teammemberData->fathernumber) ? 1 : 0;

        $profileCompletionPercentage = ($filledFields / $totalFields) * 100;
        $formattedProfileCompletion = number_format($profileCompletionPercentage, 2);
    @endphp
    @if ($formattedProfileCompletion == 100)
        <span class="badge badge-pill badge-success"
            style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
    @else
        <span class="badge badge-pill badge-danger"
            style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
    @endif
</td>
{{-- * badge  --}}
<td>
    @if ($timesheetrequestsData->status == 0)
        <span class="badge badge-pill badge-warning">Created</span>
    @elseif($timesheetrequestsData->status == 1)
        <span class="badge badge-pill badge-success">Approved</span>
    @else
        <span class="badge badge-pill badge-danger">Rejected</span>
    @endif
</td>
{{-- * direct mail    --}}

<td><a href="mailto:{{ $teammemberData->emailid }}">{{ $teammemberData->emailid ?? '' }}</a>
</td>
{{-- * get data from database   --}}

<td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleave->approver)->first()->team_member ?? '' }}
</td>
{{-- * holiday routes   --}}
{{-- Route::resource('/holiday', HolidayController::class);
 
above route related it and this anchor tag hit edit function in resource route
<a href="{{ route('holiday.edit', $holidayDatas->id) }}">{{ $holidayDatas->holidayname }}</a> --}}


{{--
Route::get('/holidays', [HolidayController::class, 'holidays']);
Route::get('holiday/delete/{id}', [HolidayController::class, 'destroy']); --}}
<tbody>
    @foreach ($holidayDatas as $holidayDatas)
        <tr>
            <td style="display: none;">{{ $holidayDatas->id }}</td>
            <td>
                @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                    <a href="{{ route('holiday.edit', $holidayDatas->id) }}">
                        {{ $holidayDatas->holidayname }}</a>
                @else
                    {{ $holidayDatas->holidayname }}
                @endif
            </td>
            <td>{{ date('F d,Y', strtotime($holidayDatas->startdate)) }}</td>

            @if (Auth::user()->role_id == 18)
                <td> <a href="{{ url('holiday/delete', $holidayDatas->id) }}" class="btn btn-info-soft btn-sm"><i
                            class="fa fa-trash"></i></a>
                </td>
            @endif

        </tr>
    @endforeach
</tbody>



{{-- * button in select box/ select box button /   --}}
<ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
    <li class="breadcrumb-item">
        <div class="btn-group mb-2 mr-1">
            <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Choose Year
            </button>
            <div class="dropdown-menu">
                <a style="color: #37A000" class="dropdown-item"
                    href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
                <a style="color: #37A000" class="dropdown-item"
                    href="{{ url('/holidays?' . 'year=' . '2022') }}">2022</a>


            </div>
        </div>
    </li>
    {{-- For hr  --}}
    @if (Auth::user()->role_id == 18)
        <li class="breadcrumb-item"><a href="{{ url('holiday/create') }}">Add Holidays</a></li>
        <li class="breadcrumb-item active">+</li>
    @endif
</ol>

{{-- * check days ant time  --}}

@if (
    (now()->isSunday() && now()->hour >= 18) ||
        now()->isMonday() ||
        now()->isTuesday() ||
        now()->isWednesday() ||
        now()->isThursday() ||
        now()->isFriday() ||
        (now()->isSaturday() && now()->hour <= 18))
@endif
{{-- *   --}}

{{-- * dd with mesaage/ check dd output    --}}
dd('hi', $previoussavechck);
{{-- *  success message display --}}

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

{{-- * model rule / $fillable  --}}
model
protected $table = "assignmentteammappings";
protected $fillable = [
'status',
];

{{-- * mailtrap config  --}}

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=2250e92771fcb7
MAIL_PASSWORD=ac27bd097eacaa
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=kgsomani@gmail.com
MAIL_FROM_NAME="${APP_NAME}"


{{-- * name route / route name --}}
Route::resource('form', RegisterController::class)->names([
'index' => 'addUser.index',
'create' => 'addUser.create',
'store' => 'addUser.store',
'show' => 'addUser.show',
'edit' => 'addUser.edit',
'update' => 'addUser.update',
'destroy' => 'addUser.destroy',
]);

{{-- * modal box / model box  --}}

<div class="row">
    <div class="col">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    {{-- modal-body --}}
                    <div class="modal-body">

                        <div>
                            <label for="">Name</label>
                            <input type="text" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- * remove dublication / reapet data / dublicate data --}}

1.use ->distinct()->get();
2. below code
<div class="col-3">
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
                        {{ $jobData->totaltime }}
                    </option>
                    @php
                        $displayedValues[] = $jobData->totaltime;
                    @endphp
                @endif
            @endforeach
        </select>
    </div>
</div>







{{-- * redirect anywhere / go another route  --}}

// return back()->with('statuss', $output);
return redirect()->to('rejectedlist')->with('statuss', $output);

{{-- * <!-- image open through link / storage image --> --}}
// !runnig code download image
// public function downloadAll(Request $request)
// {

// $articlefiles = DB::table('assignmentfolderfiles')->where('createdby', auth()->user()->id)->first();

// return response()->download(('backEnd/image/articlefiles/' . $articlefiles->filesname));
// }


{{-- * <!-- image open through link / storage image --> --}}
zip download in laravel
{{-- public function download()
    {
        $zip = new ZipArchive();
        $file_name = 'shahid.zip';

        if ($zip->open(storage_path($file_name), ZipArchive::CREATE) == true) {
            // Adjust the path to your storage folder
            $files = File::files(storage_path('app\public\image\task'));
            if (count($files) > 0) {
                foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
                return response()->download(storage_path($file_name));
            }
        }
    } --}}



{{-- * <!-- image open through link / storage image --> --}}
<div class="table-responsive">
    <table id="examplee" class="table display table-bordered table-striped table-hover basic">
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
            @foreach ($assignmentfolderfile as $assignmentfolderData)
                <tr>

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
    </table>
</div>
{{-- * <!-- Modal for success message --> --}}
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display success message here -->
                <p id="successMessage"></p>
            </div>
        </div>
    </div>
</div>

<!-- Display success message for user -->
@if (session('message'))
    <script>
        // Set the success message to the modal content
        document.getElementById('successMessage').innerText = "{{ session('message') }}";

        // Show the modal
        $('#successModal').modal('show');
    </script>
@endif


{{-- * <!-- Modal for success message --> --}}
@if (Auth::user()->role_id == 13 ||
        $assignmentbudgetingDatas->type == 0 ||
        $assignmentbudgetingDatas->status == 1 ||
        ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
    <div class="row">

        {{-- sucess message --}}
        <div id="successModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                <h5 class="modal-title">Success Message</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> --}}
                    <div class="modal-body">
                        <p id="successMessage"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                <div class="card-body">

                    <div class="card-head">
                        <b>UDIN List</b>
                        @if (
                            (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                            <a data-toggle="modal" data-target="#exampleModal12" style="float:right;width:20px;"><img
                                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                        @endif
                    </div>
                    <hr>
                    <div class="table-responsive example">
                        <table class="table display table-bordered table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th>UDIN</th>
                                    <th>Partner</th>
                                    <th>Created by</th>
                                    <th>Created Date</th>
                                    @if (
                                        (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                            (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($udinDatas as $udinData)
                                    <tr>
                                        <td>{{ $udinData->udin }}</td>
                                        <td>{{ App\Models\Teammember::where('id', $udinData->partner)->select('team_member')->pluck('team_member')->first() }}
                                        </td>
                                        <td>{{ $udinData->team_member }} ( {{ $udinData->rolename ?? '' }}
                                            )</td>
                                        <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
                                            {{ date('H:i A', strtotime($udinData->created)) }}</td>

                                        @if (
                                            (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                            <td>
                                                <form
                                                    action="{{ route('uidindata.delete', ['id' => $udinData->udin]) }}"
                                                    method="post" class="form1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="deleteButton btn btn-sm btn-danger mx-2"
                                                        style="height: 21px; width: 3rem; font-size: 8px;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!--Success message on Deleted -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Display success message for user
        @if (session('message'))
            // Use JavaScript to display the success message in the modal
            $('#successMessage').text("{{ session('message') }}");
            $('#successModal').modal('show');
        @endif
    });
</script>
<!--Success message on Deleted end-->

{{-- ###################################################################### --}}
{{-- * get data from database in blade file --}}
<div class="row">
    @foreach ($assignmentfolder as $assignmentfolderData)
        {{-- three dot like .... --}}
        <div class="col-md-6 col-lg-3">
            @if ($assignmentfolderpermission->status == 1)
                @if ($assignmentfolderData->createdby == Auth::user()->teammember_id || Auth::user()->role_id == 13)
                    <ul class="navbar-nav flex-row align-items-center ml-auto">
                        <li class="nav-item dropdown user-menus">
                            <a class="foldertoggle" style=" color:white" href="#" data-toggle="dropdown">
                                <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                                <i class="ti-more-alt"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a style="margin-left: 10px;color:#7a7a7a;" id="editCompany" data-toggle="modal"
                                    data-id="{{ $assignmentfolderData->id }}" data-target="#modaldemo1"
                                    class="dropdown-item">Edit Name</a>

                                @if (DB::table('assignmentfolderfiles')->where('assignmentfolderfiles.assignmentfolder_id', $assignmentfolderData->id)->where('status', '1')->count() == 0)
                                    <a style="margin-left: 10px;color:#7a7a7a;"
                                        onclick="return confirm('Are you sure you want to delete this folder?');"
                                        href="{{ url('assignmentfolderdelete', $assignmentfolderData->id) }}"
                                        class="dropdown-item">Delete</a>
                                @endif
                            </div>
                            <!--/.dropdown-menu -->
                        </li>
                    </ul>
                @endif
            @endif
            <a href="{{ url('assignmentfolderfiles', $assignmentfolderData->id) }}">

                <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center"
                    style="background: @if ($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                    <div class="header-pretitle fs-11 font-weight-bold text-uppercase"
                        style="color: white;font-size: 11px!important;">
                        {{ strlen($assignmentfolderData->assignmentfoldersname) > 26 ? substr($assignmentfolderData->assignmentfoldersname, 0, 26) : $assignmentfolderData->assignmentfoldersname }}
                    </div>

                    <div class="fs-32 text-monospace">
                        {{ DB::table('assignmentfolderfiles')->where('assignmentfolderfiles.assignmentfolder_id', $assignmentfolderData->id)->where('status', '1')->count() }}
                    </div>
                    <small>Data</small>

                </div>
            </a>
        </div>
    @endforeach
</div>
{{-- ###################################################################### --}}

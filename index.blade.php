@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                <a href="{{ url('leave/teamapplication/') }}" style="float: right;" class="btn btn-success ml-2">Team
                    Application</a>
            @endif
            <a href="{{ url('applyleave/create/') }}" style="float: right;" class="btn btn-success ml-2">Apply Leave</a>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>From now on you will start your activities.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">

    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">My Application</a>
                    </li>

                    @if (Auth::user()->role_id == 13)
                        <li class="nav-item">
                            <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                                aria-controls="pills-user" aria-selected="false">Team Application</a>
                        </li>
                    @endif
                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">

                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                {{-- <table class="table display table-bordered table-striped table-hover basic"> --}}

                                <table id="examplee" class="table display table-bordered table-striped table-hover">
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
                                    <tbody>
                                        {{-- @php
                                            dd($myapplyleaveDatas);
                                        @endphp --}}
                                        @foreach ($myapplyleaveDatas as $applyleaveDatas)
                                            {{-- @php
                                                dd($applyleaveDatas->leavetype);
                                            @endphp --}}
                                            <tr>
                                                <td>{{ date('F d,Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
                                                <td> <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                                        {{ $applyleaveDatas->team_member ?? '' }}</a></td>
                                                <td>

                                                    {{ $applyleaveDatas->name ?? '' }}<br>
                                                    @if ($applyleaveDatas->type == '0')
                                                        <b>Type :</b> <span>Birthday</span><br>
                                                        <span><b>Birthday Date :
                                                            </b>{{ date(
                                                                'F d,Y',
                                                                strtotime(
                                                                    App\Models\Teammember::select('dateofbirth')->where('id', $applyleaveDatas->createdby)->first()->dateofbirth,
                                                                ),
                                                            ) ?? '' }}</span>
                                                    @elseif($applyleaveDatas->type == '1')
                                                        <span>Religious Festival</span>
                                                    @endif
                                                    @if ($applyleaveDatas->examtype == '0')
                                                        <b>Exam Type :</b> <span>PCC</span>
                                                    @elseif($applyleaveDatas->examtype == '1')
                                                        <b>Exam Type :</b> <span>CA Final</span>
                                                    @elseif($applyleaveDatas->examtype == '2')
                                                        <b>Exam Type :</b> <span>B.Com</span>
                                                    @endif
                                                    @if ($applyleaveDatas->examtype == '3')
                                                        <b>Other :</b> <span>{{ $applyleaveDatas->otherexam ?? '' }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                                </td>

                                                <td>{{ $applyleaveDatas->reasonleave ?? '' }} </td>

                                                <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                                    {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
                                                @php
                                                    $to = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->to ?? '');
                                                    $from = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->from);
                                                    $diff_in_days = $to->diffInDays($from) + 1;
                                                    $holidaycount = DB::table('holidays')
                                                        ->where('startdate', '>=', $applyleaveDatas->from)
                                                        ->where('enddate', '<=', $applyleaveDatas->to)
                                                        ->count();
                                                @endphp
                                                <td>{{ $diff_in_days - $holidaycount ?? '' }}</td>


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

                                            </tr>
                                            {{-- leaverequest form --}}
                                            @if ($applyleaveDatas->leavetype == 11)
                                                <div class="modal fade" id="requestModal{{ $applyleaveDatas->id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <form method="post" action="{{ route('applyleaverequest') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    {{-- @php
                                                                    dd($applyleaveDatas);
                                                                @endphp --}}
                                                                    <h5 class="modal-title" id="requestModalLabel">Enter
                                                                        Request Details</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if ($errors->any())
                                                                        <div class="">
                                                                            <ul>
                                                                                @foreach ($errors->all() as $error)
                                                                                    <li class="text-danger">
                                                                                        {{ $error }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    {{-- <form method="post"
                                                                    action="{{ url('/applyleaverequest') }}"
                                                                    enctype="multipart/form-data"> --}}

                                                                    <input type="hidden" name="applyleaveid"
                                                                        value="{{ $applyleaveDatas->id }}"
                                                                        class="form-control" placeholder="">
                                                                    <input type="hidden" name="createdby"
                                                                        value="{{ $applyleaveDatas->createdby }}"
                                                                        class="form-control" placeholder="">
                                                                    <input type="hidden" name="approver"
                                                                        value="{{ $applyleaveDatas->approver }}"
                                                                        class="form-control" placeholder="">
                                                                    <input type="hidden" name="status"
                                                                        value="{{ $applyleaveDatas->status }}"
                                                                        class="form-control" placeholder="">

                                                                    <!-- Input fields for request details here -->
                                                                    <label for="">Reason:*</label>

                                                                    <input type="text" name="reason"
                                                                        class="form-control" placeholder="Enter Reason"
                                                                        required>
                                                                    <label for="">Select Date:*</label>
                                                                    <input type="date" name="date"
                                                                        class="form-control yearValidate" maxlength="10"
                                                                        required>
                                                                    {{-- validation for year --}}
                                                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            $('.yearValidate').on('change', function() {
                                                                                var leaveDate = $('.yearValidate');
                                                                                var leaveDateValue = $('.yearValidate').val();
                                                                                console.log(leaveDateValue);
                                                                                var leaveDateGet = new Date(leaveDateValue);
                                                                                var leaveyear = leaveDateGet.getFullYear();
                                                                                // console.log(startyear);
                                                                                var leaveyearLength = leaveyear.toString().length;
                                                                                if (leaveyearLength > 4) {
                                                                                    alert('Enter four digits for the year');
                                                                                    leaveDate.val('');
                                                                                }
                                                                            });
                                                                        });
                                                                    </script>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    <br>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">

                        <div class="table-responsive">
                            <table class="table display table-bordered table-striped table-hover basic">
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


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                        <tr>
                                            <td>{{ date('F d,Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
                                            <td> <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                                    {{ $applyleaveDatas->team_member ?? '' }}</a></td>
                                            <td>

                                                {{ $applyleaveDatas->name ?? '' }}<br>
                                                @if ($applyleaveDatas->type == '0')
                                                    <b>Type :</b> <span>Birthday</span><br>
                                                    <span><b>Birthday Date :
                                                        </b>{{ date(
                                                            'F d,Y',
                                                            strtotime(
                                                                App\Models\Teammember::select('dateofbirth')->where('id', $applyleaveDatas->createdby)->first()->dateofbirth,
                                                            ),
                                                        ) ?? '' }}</span>
                                                @elseif($applyleaveDatas->type == '1')
                                                    <span>Religious Festival</span>
                                                @endif
                                                @if ($applyleaveDatas->examtype == '0')
                                                    <b>Exam Type :</b> <span>PCC</span>
                                                @elseif($applyleaveDatas->examtype == '1')
                                                    <b>Exam Type :</b> <span>CA Final</span>
                                                @elseif($applyleaveDatas->examtype == '2')
                                                    <b>Exam Type :</b> <span>B.Com</span>
                                                @endif
                                                @if ($applyleaveDatas->examtype == '3')
                                                    <b>Other :</b> <span>{{ $applyleaveDatas->otherexam ?? '' }}</span>
                                                @endif
                                            </td>
                                            <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                            </td>

                                            <td>{{ $applyleaveDatas->reasonleave ?? '' }} </td>

                                            <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                                {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
                                            @php
                                                $to = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->to ?? '');
                                                $from = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->from);
                                                $diff_in_days = $to->diffInDays($from) + 1;
                                                $holidaycount = DB::table('holidays')
                                                    ->where('startdate', '>=', $applyleaveDatas->from)
                                                    ->where('enddate', '<=', $applyleaveDatas->to)
                                                    ->count();
                                            @endphp
                                            <td>{{ $diff_in_days - $holidaycount ?? '' }}</td>
                                            <td>
                                                @if ($applyleaveDatas->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($applyleaveDatas->status == 1)
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($applyleaveDatas->status == 2)
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--/.body content-->
@endsection


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

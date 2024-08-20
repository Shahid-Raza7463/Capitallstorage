@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">

            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Open Leave List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <div class="table-responsive">

                    {{-- <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Employee</th>
                                <th>Date of Request</th>
                                <th>Status</th>
                                <th>Leave Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Approver</th>
                                <th>Reason for Leave</th>
                                <th>Approved</th>
                                <th>Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                <tr>
                                    <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                                    <td> <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                            {{ $applyleaveDatas->team_member ?? '' }}</a>
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
                                    <td class="columnSize">
                                        @if ($applyleaveDatas->status == 0)
                                            <span class="badge badge-pill badge-warning"><span
                                                    style="display: none;">A</span>Created</span>
                                        @elseif($applyleaveDatas->status == 1)
                                            <span class="badge badge-success"><span
                                                    style="display: none;">B</span>Approved</span>
                                        @elseif($applyleaveDatas->status == 2)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>

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
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                        {{ date('d-m-Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
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
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                    </td>
                                    <td>
                                        <div style="font-size: 15px; width: 7rem;text-wrap: wrap;">
                                            {{ $applyleaveDatas->reasonleave ?? '' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($applyleaveDatas->status == 0)
                                            <form method="post"
                                                action="{{ route('applyleave.update', $applyleaveDatas->id) }}"
                                                enctype="multipart/form-data" style="text-align: center;">
                                                @method('PATCH')
                                                @csrf
                                                <input type="text" hidden id="example-date-input" name="status"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                                <button type="submit" class="btn btn-success"
                                                    style="border-radius: 7px; font-size: 10px; padding: 5px;">
                                                    Approve</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($applyleaveDatas->status == 0)
                                            <button data-toggle="modal" data-target="#exampleModal12{{ $loop->index }}"
                                                class="btn btn-danger"
                                                style="border-radius: 7px; font-size: 10px; padding: 5px; margin-bottom: 16px;">
                                                Reject</button>
                                        @endif
                                    </td>

                                    <!-- model box / pop up box  -->
                                    <div class="modal fade" id="exampleModal12{{ $loop->index }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#37A000">
                                                    <h5 style="color: white" class="modal-title font-weight-600"
                                                        id="exampleModalLabel1">Reason For
                                                        Rejection</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post"
                                                    action="{{ url('applyleave/update', $applyleaveDatas->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row row-sm">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                                                    <input hidden type="text" id="example-date-input"
                                                                        name="status" value="2" class="form-control"
                                                                        placeholder="Enter Reason">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" style="float: right"
                                                            class="btn btn-success">Save </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach


                        </tbody>
                    </table> --}}

                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Employee</th>
                                <th>Staff Code</th>
                                <th>Date of Request</th>
                                <th>Status</th>
                                <th>Leave Type</th>
                                <th>Leave Period</th>
                                <th>Days</th>
                                <th>Approver</th>
                                <th>Reason for Leave</th>
                                <th>Approved</th>
                                <th>Reject</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                <tr>
                                    @php
                                        $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $applyleaveDatas->createdby)
                                            ->first();

                                        $datadate = Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i:s',
                                            $applyleaveDatas->created_at,
                                        );

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }

                                    @endphp
                                    <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                                    <td> <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                            {{ $applyleaveDatas->team_member ?? '' }}</a>
                                    </td>
                                    {{-- <td>{{ $applyleaveDatas->staffcode ?? '' }}</td> --}}
                                    @if ($permotioncheck && $datadate->greaterThan($permotiondate))
                                        <td>{{ $permotioncheck->newstaff_code }}</td>
                                    @else
                                        <td>{{ $applyleaveDatas->staffcode }}</td>
                                    @endif
                                    <td>{{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td>
                                    <td class="columnSize">
                                        @if ($applyleaveDatas->status == 0)
                                            <span class="badge badge-pill badge-warning"><span
                                                    style="display: none;">A</span>Created</span>
                                        @elseif($applyleaveDatas->status == 1)
                                            <span class="badge badge-success"><span
                                                    style="display: none;">B</span>Approved</span>
                                        @elseif($applyleaveDatas->status == 2)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>

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
                                    </td>
                                    <td>{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                        {{ date('d-m-Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
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
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleaveDatas->approver)->first()->team_member ?? '' }}
                                        ({{ App\Models\Teammember::select('team_member', 'staffcode')->where('id', $applyleaveDatas->approver)->first()->staffcode ?? '' }})
                                    </td>
                                    <td>
                                        <div style="font-size: 15px; width: 7rem;text-wrap: wrap;">
                                            {{ $applyleaveDatas->reasonleave ?? '' }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($applyleaveDatas->status == 0)
                                            <form method="post"
                                                action="{{ route('applyleave.update', $applyleaveDatas->id) }}"
                                                enctype="multipart/form-data" style="text-align: center;">
                                                @method('PATCH')
                                                @csrf
                                                <input type="text" hidden id="example-date-input" name="status"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                                <button type="submit" class="btn btn-success"
                                                    style="border-radius: 7px; font-size: 10px; padding: 5px;">
                                                    Approve</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($applyleaveDatas->status == 0)
                                            <button data-toggle="modal" data-target="#exampleModal12{{ $loop->index }}"
                                                class="btn btn-danger"
                                                style="border-radius: 7px; font-size: 10px; padding: 5px; margin-bottom: 16px;">
                                                Reject</button>
                                        @endif
                                    </td>

                                    <!-- model box / pop up box  -->
                                    <div class="modal fade" id="exampleModal12{{ $loop->index }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#37A000">
                                                    <h5 style="color: white" class="modal-title font-weight-600"
                                                        id="exampleModalLabel1">Reason For
                                                        Rejection</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post"
                                                    action="{{ url('applyleave/update', $applyleaveDatas->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row row-sm">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                                                    <input hidden type="text" id="example-date-input"
                                                                        name="status" value="2" class="form-control"
                                                                        placeholder="Enter Reason">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" style="float: right"
                                                            class="btn btn-success">Save </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
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
            "order": [
                //   [2, "desc"]
            ],
            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8],
                orderable: false
            }],
            buttons: []
        });
    });
</script>

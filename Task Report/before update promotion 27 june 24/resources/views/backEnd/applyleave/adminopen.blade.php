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

                    <table id="examplee" class="table display table-bordered table-striped table-hover">
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

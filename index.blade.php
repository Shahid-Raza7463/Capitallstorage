<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Permotion and Rejoining</h1>
                    <small>Permotion and Rejoining</small>
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
                @if (session()->has('statuss'))
                    <div class="alert alert-danger" style="display: ruby-text;">
                        <i class="fas fa-exclamation-triangle"></i>
                        @if (is_array(session()->get('statuss')))
                            @foreach (session()->get('statuss') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        @else
                            <p>{{ session()->get('statuss') }}</p>
                        @endif
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success" style="display: ruby-text;">
                        <i class="fas fa-check-circle"></i>
                        @if (is_array(session()->get('success')))
                            @foreach (session()->get('success') as $message)
                                <p>{!! $message !!}</p>
                            @endforeach
                        @else
                            <p>{{ session()->get('success') }}</p>
                        @endif
                    </div>
                @endif

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Promotion Details</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                            aria-controls="pills-user" aria-selected="false">Rejoining Details</a>
                    </li>
                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive">
                            {{-- <table id="myTimesheetTable" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Created By</th>
                                        <th class="textfixed">Staff Code</th>
                                        <th>Approver</th>
                                        <th class="textfixed">Approver Code</th>
                                        <th>Reason</th>
                                        <th>Attachment</th>
                                        <th class="textfixed">Reason for Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mytimesheetrequest as $timesheetrequestsData)
                                        <tr>
                                            @php
                                                $permotioncheck = DB::table('teamrolehistory')
                                                    ->where('teammember_id', auth()->user()->teammember_id)
                                                    ->first();

                                                $datadate = $timesheetrequestsData->created_at
                                                    ? Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $timesheetrequestsData->created_at,
                                                    )
                                                    : null;

                                                $permotiondate = null;
                                                if ($permotioncheck) {
                                                    $permotiondate = Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $permotioncheck->created_at,
                                                    );
                                                }
                                            @endphp
                                            <td>
                                                @if ($timesheetrequestsData->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsData->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="textfixed"> <span style="display: none;">
                                                    {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}</span>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
                                            </td>
                                            <td class="textfixed">
                                                {{ date('g:i A', strtotime($timesheetrequestsData->created_at)) }}
                                            </td>
                                            <td class="textfixed"><a
                                                    href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                                    {{ $timesheetrequestsData->createdbyauth }}</a></td>
                                            @if ($permotiondate && $datadate && $datadate->greaterThan($permotiondate))
                                                <td>{{ $permotioncheck->newstaff_code }}</td>
                                            @else
                                                <td>{{ $timesheetrequestsData->staffcodeid }}</td>
                                            @endif
                                            <td>{{ $timesheetrequestsData->team_member }}
                                            </td>
                                            <td>
                                                {{ $timesheetrequestsData->staffcode }}
                                            </td>
                                           
                                            <td class="textfixed">
                                                @if (strlen($timesheetrequestsData->reason) > 25)
                                                    <span id="reasonleave-{{ $timesheetrequestsData->id }}"
                                                        class="reasonleave-truncated"
                                                        title="{{ $timesheetrequestsData->reason }}">
                                                        {{ substr($timesheetrequestsData->reason, 0, 25) }}.....
                                                        <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                            title="Show full text"
                                                            onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                                                            Detail</span>
                                                    </span>
                                                @else
                                                    {{ $timesheetrequestsData->reason ?? '' }}
                                                @endif
                                            </td>
                                            <td class="textfixed">
                                                @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
                                                    <a href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}"
                                                        target="_blank">
                                                        {{ $timesheetrequestsData->attachment ?? 'NA' }}
                                                    </a>
                                                @else
                                                    {{ 'NA' }}
                                                @endif
                                            </td>

                                            <td class="textfixed">
                                                @if (strlen($timesheetrequestsData->remark) > 25)
                                                    <span id="reasonleave-{{ $timesheetrequestsData->id }}"
                                                        class="reasonleave-truncated"
                                                        title="{{ $timesheetrequestsData->remark }}">
                                                        {{ substr($timesheetrequestsData->remark, 0, 25) }}.....
                                                        <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                            title="Show full text"
                                                            onclick="showFullText('{{ $timesheetrequestsData->remark }}')">View
                                                            Detail</span>
                                                    </span>
                                                @else
                                                    {{ $timesheetrequestsData->remark ?? 'NA' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="table-responsive">
                            {{-- <table id="teamTimesheetTable" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Created By</th>
                                        <th class="textfixed">Staff Code</th>
                                        <th>Approver</th>
                                        <th class="textfixed">Approver Code</th>
                                        <th>Reason</th>
                                        <th>Attachment</th>
                                        <th class="textfixed">Reason for Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teamtimesheetrequest as $timesheetrequestsData)
                                        <tr>
                                            <td>
                                                @if ($timesheetrequestsData->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsData->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="textfixed"> <span style="display: none;">
                                                    {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}</span>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
                                            </td>
                                            <td class="textfixed">
                                                {{ date('g:i A', strtotime($timesheetrequestsData->created_at)) }}</td>
                                            <td class="textfixed"><a
                                                    href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                                    {{ $timesheetrequestsData->createdbyauth }}</a></td>
                                            <td>{{ $timesheetrequestsData->staffcodeid }}</td>
                                            <td class="textfixed">{{ $timesheetrequestsData->team_member }}

                                            </td>
                                            <td>
                                                {{ $timesheetrequestsData->staffcode }}
                                            </td>

                                            <td class="textfixed">
                                                @if (strlen($timesheetrequestsData->reason) > 25)
                                                    <span id="reasonleave-{{ $timesheetrequestsData->id }}"
                                                        class="reasonleave-truncated"
                                                        title="{{ $timesheetrequestsData->reason }}">
                                                        {{ substr($timesheetrequestsData->reason, 0, 25) }}.....
                                                        <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                            title="Show full text"
                                                            onclick="showFullText('{{ $timesheetrequestsData->reason }}')">View
                                                            Detail</span>
                                                    </span>
                                                @else
                                                    {{ $timesheetrequestsData->reason ?? '' }}
                                                @endif
                                            </td>
                                            <td class="textfixed">
                                                @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
                                                    <a href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}"
                                                        target="_blank">
                                                        {{ $timesheetrequestsData->attachment ?? 'NA' }}
                                                    </a>
                                                @else
                                                    {{ 'NA' }}
                                                @endif
                                            </td>

                                            <td class="textfixed">
                                                @if (strlen($timesheetrequestsData->remark) > 25)
                                                    <span id="reasonleave-{{ $timesheetrequestsData->id }}"
                                                        class="reasonleave-truncated"
                                                        title="{{ $timesheetrequestsData->remark }}">
                                                        {{ substr($timesheetrequestsData->remark, 0, 25) }}.....
                                                        <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                            title="Show full text"
                                                            onclick="showFullText('{{ $timesheetrequestsData->remark }}')">View
                                                            Detail</span>
                                                    </span>
                                                @else
                                                    {{ $timesheetrequestsData->remark ?? 'NA' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
{{-- <style>
    .dt-buttons {
        margin-bottom: -34px;
    }

    #teamTimesheetTable {
        width: 100% !important;

    }
</style> --}}

<script>
    $(document).ready(function() {
        $('#myTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6, 7, 8, 9],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'My timesheet Request',
                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 7 || column === 9) {
                                    var fullText = $(node).find('span').attr('title') || $(node)
                                        .text().trim();
                                    return fullText;
                                }
                                return data;
                            }
                        }
                    },
                },
                'colvis'
            ]
        });

        $('#teamTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6, 7, 8, 9],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Team timesheet Request',

                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 7 || column === 9) {
                                    var fullText = $(node).find('span').attr('title') || $(node)
                                        .text().trim();
                                    return fullText;
                                }
                                return column;
                            }
                        }
                    },

                },
                'colvis'
            ]
        });
    });
</script>

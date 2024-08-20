@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Team Workbook List</small>
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
                   
          <table class="table display table-bordered table-striped table-hover basic">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Client Name</th>
                                <th>Assignment Name</th>
                                <th>Work Item</th>
                                <th>Location</th>
                                <th>Partner</th>
                                <th>Hour</th>
                                <th>Status</th>
                                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheetData as $timesheetDatas)
                                <tr>
                                    <td style="display: none;">{{ $timesheetDatas->id }}</td>
                                    <td> {{ $timesheetDatas->team_member ?? '' }} </td>
                                    <td> <span style="display: none;">
                                            {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                    </td>
                                    <td>
                                        @if ($timesheetDatas->date != null)
                                            {{ date('l', strtotime($timesheetDatas->date)) }}
                                        @endif
                                    </td>
                                    <td>{{ $timesheetDatas->client_name ?? '' }} </td>
                                    <td>
                                        {{ $timesheetDatas->assignment_name ?? '' }}
                                        @if ($timesheetDatas->assignmentname != null)
                                            ({{ $timesheetDatas->assignmentname ?? '' }})
                                        @endif
                                    </td>
                                    <td> {{ $timesheetDatas->workitem ?? '' }}</td>
                                    <td>{{ $timesheetDatas->location ?? '' }} </td>
                                    <td> {{ $timesheetDatas->patnername ?? '' }} </td>
                                    <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                    <td>
                                        @if ($timesheetDatas->status == 0)
                                            <span class="badge badge-pill badge-warning">Saved</span>
                                        @elseif ($timesheetDatas->status == 1 || $timesheetDatas->status == 3)
                                            <span class="badge badge-pill badge-danger">Submit</span>
                                        @else
                                            <span class="badge badge-pill badge-secondary">Rejected</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetDatas->createdby)
                                        <td>
                                            @if ($timesheetDatas->status == 2)
                                                <a href="  {{ url('/timesheet/reject/' . $timesheetDatas->id) }}"
                                                    onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                        data-target="#requestModal" disabled>Reject</button>
                                                </a>
                                            @else
                                                <a href="  {{ url('/timesheet/reject/' . $timesheetDatas->id) }}"
                                                    onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                        data-target="#requestModal">Reject</button>
                                                </a>
                                            @endif
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
    <!--/.body content-->
@endsection

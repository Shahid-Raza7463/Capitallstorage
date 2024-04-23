<!DOCTYPE html>
<html lang="en">

<body>
    admin
    Sunny
    "117460" 29

    "122367" 25 bh

    //   @php
    //       $var = DB::table('holidays')->where('id', 1)->get();
    //       dd($var);

    //   @endphp
    patner
    "122367" 25 bha

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
            {{-- @php
                dd($timesheetData);
            @endphp --}}
            @foreach ($timesheetData as $timesheetDatas)
                <tr>
                    {{-- @php
                        dd($timesheetDatas);
                    @endphp --}}
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>
                    <td> {{ $timesheetDatas->team_member ?? '' }} </td>

                    {{-- <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td> --}}
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
                    {{-- <td> {{ $assignmentnamebyuser->assignmentname ?? '' }}</td> --}}
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

    $timesheetData[0]->createdby

    0 => {#2780 ▼
        +"id": 117460
        +"timesheetid": 116521
        +"client_id": 134
        +"assignmentgenerate_id": null
        +"partner": 887
        +"totalhour": "8"
        +"assignment_id": 215
        +"project_id": null
        +"date": "2024-02-29"
        +"job_id": null
        +"workitem": "Personal Trip"
        +"location": ""
        +"billable_status": null
        +"description": null
        +"status": 1
        +"hour": "8"
        +"createdby": 844
        +"rejectedby": null
        +"updatedby": null
        +"created_at": "2024-02-19 11:33:25"
        +"updated_at": "2024-03-04 00:00:00"
        +"team_member": "Sunny Gupta"
      }


      +request: Symfony\Component\HttpFoundation\InputBag {#45 ▼
    #parameters: array:9 [▼
      "_token" => "VDZ1whfgS4CUC6BxLu8SPseCXQXqD6xFDU3ph21v"
      "date" => "20-04-2024"
      "client_id" => array:2 [▼
        0 => "33"
        1 => null
      ]
      "assignment_id" => array:1 [▼
        0 => "OFF100004"
      ]
      "partner" => array:1 [▼
        0 => "844"
      ]
      "workitem" => array:2 [▼
        0 => "N/A"
        1 => null
      ]
      "location" => array:2 [▼
        0 => "N/A"
        1 => null
      ]
      "hour" => array:2 [▼
        0 => "0"
        1 => "0"
      ]
      "totalhour" => "0"
    ]
  }



   #parameters: array:9 [▼
   "_token" => "VDZ1whfgS4CUC6BxLu8SPseCXQXqD6xFDU3ph21v"
      "date" => "20-04-2024"
      "client_id" => array:2 [▼
        0 => "33"
        1 => null
      ]
      "assignment_id" => array:1 [▼
        0 => "OFF100004"
      ]
      "partner" => array:1 [▼
        0 => "887"
      ]
      "workitem" => array:2 [▼
        0 => "HOLI"
        1 => null
      ]
      "location" => array:2 [▼
        0 => "N/A"
        1 => null
      ]
      "hour" => array:2 [▼
        0 => "0"
        1 => "0"
      ]
      "totalhour" => "0"
    ]
  }

      $client_id[0]->createdby

      #items: array:1 [▼
      0 => {#2815 ▼
        +"client_name": "Leave"
        +"hour": "8"
        +"location": ""
        +"id": 117460
        +"timesheetid": 116521
        +"client_id": 134
        +"assignmentgenerate_id": null
        +"partner": 887
        +"totalhour": "8"
        +"assignment_id": 215
        +"project_id": null
        +"date": "2024-02-29"
        +"job_id": null
        +"workitem": "Personal Trip"
        +"billable_status": null
        +"description": null
        +"status": 1
        +"createdby": 844
        +"rejectedby": null
        +"updatedby": null
        +"created_at": "2024-02-19 11:33:25"
        +"updated_at": "2024-03-04 00:00:00"
        +"assignment_name": "Casual Leave"
        +"team_member": "NA"
      }




    leaverequest
    leaveapprove
    attendances
    applyleaves
    {{-- *   --}}
    {{-- *   --}}
    {#2778 ▼
  +"id": 523
  +"leavetype": "9"
  +"type": null
  +"examtype": null
  +"otherexam": null
  +"from": "2024-04-18"
  +"to": "2024-04-24"
  +"report": ""
  +"reasonleave": "Personal Work"
  +"remark": null
  +"approver": 840
  +"createdby": 848
  +"status": 1
  +"updatedby": 878
  +"created_at": "2024-03-11 17:06:06"
  +"updated_at": "2024-04-18 15:54:59"
  +"emailid": "deepakk@vsa.co.in"
  +"team_member": "Deepak Kumar"
  +"rolename": "Manager"
  +"name": "Casual Leave"
  +"holiday": 18
  +"examrequestId": 3
  +"date": "2024-04-18"
}
    {{-- *   --}}
    mytimesheetlist
    weeklylist


    ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
    ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
    columnDefs: [{
    targets: [1, 2, 4, 5, 6, 7, 8],
    orderable: false
    }],

    // function getStatusBadge(status) {
    // if (status === 0) {
    // return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
    // } else if (status === 1) {
    // return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
    // } else if (status === 2) {
    // return '<span class="badge badge-danger">Rejected</span>';
    // } else {
    // return '';
    // }
    // }
    {{-- *   --}}

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

                <th> Hour</th>
                <th>Status</th>

                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
{{-- +"createdby": 844 --}}
                    <th>Action</th>
@endif
            </tr>
        </thead>
        <tbody>

            @foreach ($timesheetData as $timesheetDatas)
<tr>
                    @php
                        $timeid = DB::table('timesheetusers')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->first();

                        $client_id = DB::table('timesheetusers')
                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->select(
                                'clients.client_name',
                                'timesheetusers.hour',
                                'timesheetusers.location',
                                'timesheetusers.*',
                                'assignments.assignment_name',
                                'billable_status',
                                'workitem',
                                'teammembers.team_member',
                                'timesheetusers.timesheetid',
                            )
                            ->get();
                        // dd($client_id);

                        $total = DB::table('timesheetusers')

                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->sum('hour');

                        $dates = date('l', strtotime($timesheetDatas->date));
                    @endphp
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                    <td>
                        {{ $timesheetDatas->team_member ?? '' }} </td>
                    <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                    <td>
                        @if ($timesheetDatas->date != null)
{{ $dates ?? '' }}
@endif
                    </td>

                    <span style="font-size: 13px;">


                        <td>

                            @foreach ($client_id as $item)
{{ $item->client_name ?? '' }} @if ($item->client_name != 0)
,
@endif
@endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
{{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
,
@endif
@endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
{{ $item->workitem ?? '' }}@if ($item->workitem != null)
,
@endif
@endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
{{ $item->location ?? '' }}@if ($item->location != null)
,
@endif
@endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
{{ $item->team_member ?? '' }} @if ($item->team_member != null)
,
@endif
@endforeach
                        </td>







                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                        <td>
                            @foreach ($client_id as $item)
@if ($item->status == 0)
<span class="badge badge-pill badge-warning">saved</span>
@elseif ($item->status == 1 || $item->status == 3)
<span class="badge badge-pill badge-danger">submit</span>
@else
<span class="badge badge-pill badge-secondary">Rejected</span>
@endif
@endforeach
                        </td>
                        {{-- @php
                            dd($client_id);
                        @endphp --}}
                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
<td>
                                @foreach ($client_id as $item)
@if ($item->status == 2)
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal" disabled>Reject</button>
                                        </a>
@else
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal">Reject</button>
                                        </a>
@endif
@endforeach
                            </td>
@endif

                </tr>
@endforeach
        </tbody>
    </table>



















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
                {{-- <th>Hour</th> --}}
                <th> Hour</th>
                <th>Status</th>

                @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
<th>Action</th>
@endif
            </tr>
        </thead>
        <tbody>

            @foreach ($timesheetData as $timesheetDatas)
<tr>
                    @php
                        $timeid = DB::table('timesheetusers')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->first();

                        $client_id = DB::table('timesheetusers')
                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->select(
                                'clients.client_name',
                                'timesheetusers.hour',
                                'timesheetusers.location',
                                'timesheetusers.*',
                                'assignments.assignment_name',
                                'billable_status',
                                'workitem',
                                'teammembers.team_member',
                                'timesheetusers.timesheetid',
                            )
                            ->get();
                        // dd($client_id);

                        $total = DB::table('timesheetusers')

                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                            ->sum('hour');

                        $dates = date('l', strtotime($timesheetDatas->date));
                    @endphp
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                    <td>
                        {{ $timesheetDatas->team_member ?? '' }} </td>
                    <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                    <td>
                        @if ($timesheetDatas->date != null)
{{ $dates ?? '' }}
@endif
                    </td>

                    <span style="font-size: 13px;">


                        <td>

                            @foreach ($client_id as $item)
{{ $item->client_name ?? '' }} @if ($item->client_name != 0)
,
@endif
@endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
{{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
,
@endif
@endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
{{ $item->workitem ?? '' }}@if ($item->workitem != null)
,
@endif
@endforeach
                        </td>

                        <td>
                            @foreach ($client_id as $item)
{{ $item->location ?? '' }}@if ($item->location != null)
,
@endif
@endforeach
                        </td>
                        <td>
                            @foreach ($client_id as $item)
{{ $item->team_member ?? '' }} @if ($item->team_member != null)
,
@endif
@endforeach
                        </td>
                        {{-- <td>
               @foreach ($client_id as $item)
                   {{ $item->hour ??''}}  @if ($item->hour != null),@endif
                   @endforeach
               </td> --}}






                        <td>{{ $timesheetDatas->hour ?? '' }}</td>
                        <td>
                            @foreach ($client_id as $item)
@if ($item->status == 0)
<span class="badge badge-pill badge-warning">saved</span>
@elseif ($item->status == 1 || $item->status == 3)
<span class="badge badge-pill badge-danger">submit</span>
@else
<span class="badge badge-pill badge-secondary">Rejected</span>
@endif
@endforeach
                        </td>

                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
<td>
                                @foreach ($client_id as $item)
@if ($item->status == 2)
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal" disabled>Reject</button>
                                        </a>
@else
<a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                            onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                data-target="#requestModal">Reject</button>
                                        </a>
@endif
@endforeach
                            </td>
@endif

                </tr>
@endforeach
        </tbody>
    </table>


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
                {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                    <th>Action</th>
                @endif --}}
            </tr>
        </thead>
        <tbody>
            {{-- @php
                dd($timesheetData);
            @endphp --}}
            @foreach ($timesheetData as $timesheetDatas)
<tr>
                    <td style="display: none;">{{ $timesheetDatas->id }}</td>
                    <td> {{ $timesheetDatas->team_member ?? '' }} </td>

                    {{-- <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td> --}}
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
                    {{-- <td> {{ $assignmentnamebyuser->assignmentname ?? '' }}</td> --}}
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
                    {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                        <td>
                            @foreach ($client_id as $item)
                                @if ($item->status == 2)
                                    <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                        onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                        <button class="btn btn-danger" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal" disabled>Reject</button>
                                    </a>
                                @else
                                    <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                        onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                        <button class="btn btn-danger" data-toggle="modal"
                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                            data-target="#requestModal">Reject</button>
                                    </a>
                                @endif
                            @endforeach
                        </td>
                    @endif --}}
                </tr>
@endforeach
        </tbody>
    </table>





    @php
        $userId = auth()->user()->teammember_id;
        $checkread = DB::table('notificationreadorunread')
            ->where('notifications_id', $notificationData->id)
            ->where('readedby', $userId)
            ->first();

    @endphp

    <a href="{{ url('notification/' . $notificationData->id) }}"
        style="color: {{ isset($checkread) && $checkread->status == 1 ? 'black' : 'red' }}">
        <h6>{{ $notificationData->title }}</h6>
    </a>
    <a href="{{ url('notification/' . $notificationData->id) }}">
        <h6>{{ $notificationData->title }}</h6>
        {{-- style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}" --}}
    </a>
    {{--  Start Hare --}}
    // Fetching the current team hour
    $gettotalteamhour = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->value('teamhour');

    // Calculating the new total team hour
    $finalresult = $gettotalteamhour + $request->hour[$i];

    // Updating the team hour
    $totalteamhourupdate = DB::table('assignmentmappings')
    ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
    ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id[$i])
    ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
    ->update(['teamhour' => $finalresult]);

    dd($gettotalteamhour);
    {{--  Start Hare --}}
    {{-- *   --}}
    @foreach ($teammemberDatas as $teammemberData)
<tr>
            {{-- @php
            $totalhour = DB::table('timesheetusers')
                ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->where(
                    'timesheetusers.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('timesheetusers.createdby', $teammemberData->teamid)
                ->select(DB::raw('SUM(totalhour) as total_hours'))
                ->first();

            $update = DB::table('assignmentmappings')
                ->leftJoin(
                    'assignmentteammappings',
                    'assignmentteammappings.assignmentmapping_id',
                    'assignmentmappings.id',
                )
                ->where('assignmentteammappings.teammember_id', $teammemberData->teamid)
                ->update(['teamhour' => $totalhour->total_hours ?? 0]);
        @endphp --}}

            {{-- @php
            $totalHour = DB::table('timesheetusers')
                ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                ->where(
                    'timesheetusers.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('timesheetusers.createdby', $teammemberData->teamid)
                ->select(DB::raw('SUM(totalhour) as total_hours'))
                ->first();

            $update = DB::table('assignmentmappings')
                ->leftJoin(
                    'assignmentteammappings',
                    'assignmentteammappings.assignmentmapping_id',
                    'assignmentmappings.id',
                )
                ->where(
                    'assignmentmappings.assignmentgenerate_id',
                    $teammemberData->assignmentgenerate_id,
                )
                ->where('assignmentteammappings.teammember_id', $teammemberData->teamid)
                // ->get();
                ->update(['teamhour' => $totalHour->total_hours]);
            // dd($update);
        @endphp --}}


            <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}</td>
            <td>{{ $teammemberData->assignmentgenerate_id }}</td>
            <td>{{ $teammemberData->assignmentname }}</td>
            <td>{{ $teammemberData->teamhour ?? 0 }}</td>
            {{-- <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
        </tr>
@endforeach
    {{--  Start Hare --}}
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                // Get current Date
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                $diff_in_days = $to->diffInDays($from);
                $getmondaydate = DB::table('timesheetday')->first();

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();
                //! no uses
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);
                //! no uses
            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (now()->isSunday() ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                now()->isSaturday())
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
@endif
@endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
@endif
@endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
for last week
@endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
@endif
@endif

                {{-- @if ($timesheetcount >= 7)
                    @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @else
                    @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif --}}
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    {{-- *   --}}
    {{-- @if ($timesheetcount >= 7)
                        @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @else
                        @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @endif --}}
    {{--  Start Hare --}}
    {{-- *   --}}
    {{-- ! old code Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                // Get current Date
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                $diff_in_days = $to->diffInDays($from);
                $getmondaydate = DB::table('timesheetday')->first();

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();
                //! no uses
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);
                //! no uses
            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (now()->isSunday() ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                now()->isSaturday())
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
@endif
@endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
@endif
@endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
for last week
@endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
@endif
@endif

                {{-- @if ($timesheetcount >= 7)
                    @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @else
                    @if ((now()->isSunday() && now()->hour >= 18) || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || (now()->isSaturday() && now()->hour <= 18))
                        <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
                    @endif
                @endif --}}
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    @if (now()->isSunday() ||
            now()->isMonday() ||
            now()->isTuesday() ||
            now()->isWednesday() ||
            now()->isThursday() ||
            now()->isFriday() ||
            now()->isSaturday())
{{-- @if ($timesheetcount >= 6) --}}
        @if ($timesheetcountss >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
            </li>
@endif
        {{-- @endif --}}
@endif
    {{-- *   --}}
    {{-- !  Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                $currentDate = date('Y-m-d');
                $getDate = $getauth == null ? date('Y-m-d') : $getauth->date;

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getDate ?? '');
                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentDate);
                $diffInDays = $to->diffInDays($from);

                $getMondayDate = DB::table('timesheetday')->first();

                $timesheetCount = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getMondayDate->date)
                    ->count();

                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getMondayDate->date ?? '');
                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentDate);
                $diffInDaysForMonday = $too->diffInDays($froms);
            @endphp

            @if ($diffInDays > 14)
                @if ($timesheetRequest == null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a></li>
@else
@if ($currentDate < $timesheetRequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a></li>
                        @if ($timesheetCount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a></li>
@endif
@elseif ($currentDate > $timesheetRequest->validate && $timesheetRequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a></li>
@else
@if ($timesheetRequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a></li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet
                                    Request</a></li>
@endif
@endif
@endif
@elseif ($diffInDays > 15 && $diffInDays < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetCount < 7)
for last weekqqq
@endif
                    </a>
                </li>
                @if ($timesheetCount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                            onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                            href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a></li>
@endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                // $timesheetcount = DB::table('timesheets')
                //     ->where('status', '0')

                //     ->where('created_by', auth()->user()->teammember_id)
                //     ->where('date', '<', $getmondaydate->date)
                //     ->count();

                $timesheetcountss = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->count();

                // dd($timesheetcountss);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @php
                    dd('hi1');
                @endphp
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
@endif
@endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
@endif
@endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
for last weekqqq
@endif
                    </a>
                </li>

                @if (now()->isSunday() ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        now()->isSaturday())
{{-- @if ($timesheetcount >= 6) --}}
                    @if ($timesheetcountss >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
@endif
                    {{-- @endif --}}
@endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    {{-- ! old code   Start Hare --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')

                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();

                //  dd($timesheetcount);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
@endif
@endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
@endif
@endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
for last weekqqq
@endif
                    </a>
                </li>

                @if (
                    (now()->isSunday() && now()->hour >= 18) ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        (now()->isSaturday() && now()->hour <= 18))
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
@endif
@endif
            @endif
        </ol>
    </nav>
    {{-- *   --}}
    <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
        {{-- <form method="post" class="row" action="{{ url('timesheet/search') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-4">
                <label for="year">Year:</label>
                <select class="form-control" id="year" name="year">
                    @foreach ($dropdownYears as $dropdownYear)
                        <option value="{{ $dropdownYear }}" {{ $year == $dropdownYear ? 'selected' : '' }}>
                            {{ $dropdownYear }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div class="form-group col-md-4">
                <label for="month">Month:</label>
                <select class="form-control" id="month" name="month">
                    @foreach ($dropdownMonths as $dropdownMonth)
                        <option value="{{ $dropdownMonth }}" {{ $month == $dropdownMonth ? 'selected' : '' }}>
                            {{ $dropdownMonth }}
                        </option>
                    @endforeach
                </select>
                
                
            </div>
            <div class="form-group col-md-4" style="margin: auto;">
                <button type="submit" class="btn btn-primary form-controll">Submit</button>
            </div>
        </form> --}}

        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @php
                //  dd($getauth->date);
                $currentdate = date('Y-m-d');
                if ($getauth == null) {
                    $getdate = date('Y-m-d');
                } else {
                    $getdate = $getauth->date;
                }

                $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');

                $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_days = $to->diffInDays($from);
                //dd($diff_in_days);

                $getmondaydate = DB::table('timesheetday')->first();

                //   $usertimesheetfirstdate =  DB::table('timesheets')
                //                                ->where('status','0')
                //                                ->where('created_by',auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                //                         // dd($usertimesheetfirstdate->date);
                //                            $lastdate = Carbon\Carbon::createFromFormat('Y-m-d',$usertimesheetfirstdate->date ??'')->addDays(6);
                //dd(date('Y-m-d', strtotime($lastdate)));

                $timesheetcount = DB::table('timesheets')
                    ->where('status', '0')

                    ->where('created_by', auth()->user()->teammember_id)
                    ->where('date', '<', $getmondaydate->date)
                    ->count();

                //  dd($timesheetcount);
                //from monday check count

                //    dd($getmondaydate); die;
                $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');

                $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                $diff_in_daysformonday = $too->diffInDays($froms);

                //dd($diff_in_daysformonday);

            @endphp
            @if ($diff_in_days > 14)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                            Request</a> </li>
@else
@if ($currentdate < $timesheetrequest->validate)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                href="{{ url('timesheet/create') }}">Add Timesheet</a>
                        </li>
                        @if (
                            (now()->isSunday() && now()->hour >= 18) ||
                                now()->isMonday() ||
                                now()->isTuesday() ||
                                now()->isWednesday() ||
                                now()->isThursday() ||
                                now()->isFriday() ||
                                (now()->isSaturday() && now()->hour <= 18))
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                </li>
@endif
@endif
@elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                Timesheet
                                Request</a> </li>
@else
@if ($timesheetrequest->status == 0)
<li class="breadcrumb-item"><a>Requested Done</a>
                            </li>
@else
<li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet Request</a> </li>
@endif
@endif
                @endif
@elseif(15 < 16)
<li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                        href="{{ url('timesheet/create') }}">Add
                        Timesheet @if ($timesheetcount < 7)
for last week
@endif
                    </a>
                </li>

                @if (
                    (now()->isSunday() && now()->hour >= 18) ||
                        now()->isMonday() ||
                        now()->isTuesday() ||
                        now()->isWednesday() ||
                        now()->isThursday() ||
                        now()->isFriday() ||
                        (now()->isSaturday() && now()->hour <= 18))
@if ($timesheetcount >= 6)
<li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                        </li>
@endif
@endif
            @endif
        </ol>
    </nav>
    {{--  Start Hare --}}
    fir se alert box ke cancel button per aa raha hai
    {{-- *   --}}

    Illuminate\Support\Collection {#2785 ▼
        #items: array:18 [▼
          0 => {#2784 ▼
            +"id": 119659
            +"timesheetid": 118628
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-26"
            +"job_id": null
            +"workitem": "Cheked details of Salary"
            +"location": "GSTN Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 14:47:07"
            +"updated_at": "2024-03-08 00:00:00"
          }
          1 => {#2782 ▼
            +"id": 119660
            +"timesheetid": 118629
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-27"
            +"job_id": null
            +"workitem": "Cheked details of salary"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 14:49:55"
            +"updated_at": "2024-03-08 00:00:00"
          }
          2 => {#2781 ▼
            +"id": 119682
            +"timesheetid": 118649
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-28"
            +"job_id": null
            +"workitem": "cheked details of Statutory Dues"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:06:44"
            +"updated_at": "2024-03-08 00:00:00"
          }
          3 => {#2779 ▼
            +"id": 119683
            +"timesheetid": 118650
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-02-29"
            +"job_id": null
            +"workitem": "Cheked Details of Revenue Recognition"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:07:28"
            +"updated_at": "2024-03-08 00:00:00"
          }
          4 => {#2778 ▼
            +"id": 119684
            +"timesheetid": 118651
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-01"
            +"job_id": null
            +"workitem": "Cheked details of Revenue"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:08:04"
            +"updated_at": "2024-03-08 00:00:00"
          }
          5 => {#2777 ▼
            +"id": 119685
            +"timesheetid": 118652
            +"client_id": 190
            +"assignmentgenerate_id": null
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-02"
            +"job_id": null
            +"workitem": "Cheked details of Revenue"
            +"location": "FICSI Office"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-08 18:08:38"
            +"updated_at": "2024-03-08 00:00:00"
          }
          6 => {#2776 ▼
            +"id": 120189
            +"timesheetid": 119146
            +"client_id": 190
            +"assignmentgenerate_id": "FOO100471"
            +"partner": 840
            +"totalhour": "8"
            +"assignment_id": 220
            +"project_id": null
            +"date": "2024-03-04"
            +"job_id": null
            +"workitem": "Cheked details of Revenue and travelling for Kolkatta"
            +"location": "Working from home"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:02:13"
            +"updated_at": "2024-03-14 00:00:00"
          }
          7 => {#2775 ▼
            +"id": 120190
            +"timesheetid": 119147
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-05"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:02:45"
            +"updated_at": "2024-03-14 00:00:00"
          }
          8 => {#2774 ▼
            +"id": 120194
            +"timesheetid": 119149
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-06"
            +"job_id": null
            +"workitem": "Cheked detilas of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:03:18"
            +"updated_at": "2024-03-14 00:00:00"
          }
          9 => {#2773 ▼
            +"id": 120198
            +"timesheetid": 119152
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-07"
            +"job_id": null
            +"workitem": "Cheked Details od Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:04:38"
            +"updated_at": "2024-03-14 00:00:00"
          }
          10 => {#2772 ▼
            +"id": 120202
            +"timesheetid": 119155
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-08"
            +"job_id": null
            +"workitem": "Cheked Detials of land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:05:16"
            +"updated_at": "2024-03-14 00:00:00"
          }
          11 => {#2771 ▼
            +"id": 120203
            +"timesheetid": 119156
            +"client_id": 33
            +"assignmentgenerate_id": "OFF100004"
            +"partner": 887
            +"totalhour": "0"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-09"
            +"job_id": null
            +"workitem": "NA"
            +"location": "NA"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "0"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-14 13:05:58"
            +"updated_at": "2024-03-14 00:00:00"
          }
          12 => {#2770 ▼
            +"id": 120525
            +"timesheetid": 119473
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-11"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:00:47"
            +"updated_at": "2024-03-19 00:00:00"
          }
          13 => {#2769 ▼
            +"id": 120526
            +"timesheetid": 119474
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-12"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:01:20"
            +"updated_at": "2024-03-19 00:00:00"
          }
          14 => {#2768 ▼
            +"id": 120527
            +"timesheetid": 119475
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-13"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:02:04"
            +"updated_at": "2024-03-19 00:00:00"
          }
          15 => {#2767 ▼
            +"id": 120528
            +"timesheetid": 119476
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-14"
            +"job_id": null
            +"workitem": "cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:02:47"
            +"updated_at": "2024-03-19 00:00:00"
          }
          16 => {#2796 ▼
            +"id": 120529
            +"timesheetid": 119477
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-15"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "RCCPL Kolkatta"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:03:39"
            +"updated_at": "2024-03-19 00:00:00"
          }
          17 => {#2797 ▼
            +"id": 120530
            +"timesheetid": 119478
            +"client_id": 48
            +"assignmentgenerate_id": "RCC100269"
            +"partner": 844
            +"totalhour": "8"
            +"assignment_id": 213
            +"project_id": null
            +"date": "2024-03-16"
            +"job_id": null
            +"workitem": "Cheked details of Land"
            +"location": "Working from home"
            +"billable_status": null
            +"description": null
            +"status": 0
            +"hour": "8"
            +"createdby": 847
            +"rejectedby": null
            +"updatedby": null
            +"created_at": "2024-03-19 11:04:34"
            +"updated_at": "2024-03-19 00:00:00"
          }
        ]
        #escapeWhenCastingToString: false
      }

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Status</th>
                <th>Start Request Date</th>
                {{-- <th>End Request Date</th>
                <th>Start Leave Period</th>
                <th>End Leave Period</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr style=" background-color: white;">
                <td>
                    <div class="form-group">
                        <select class="language form-control" id="employee1" name="employee">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->emailid, $displayedValues))
<option value="{{ $applyleaveDatas->createdby }}">
                                        {{ $applyleaveDatas->team_member }}
                                        ({{ $applyleaveDatas->emailid }})
</option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->emailid;
                                    @endphp
@endif
@endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <select class="language form-control" id="leave1" name="leave">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->name, $displayedValues))
<option value="{{ $applyleaveDatas->leavetype }}">
                                        {{ $applyleaveDatas->name }}
                                    </option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->name;
                                    @endphp
@endif
@endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group ">
                        <select class="language form-control" id="status1" name="status">
                            <option value="">Please Select One</option>
                            @php
                                $displayedValues = [];
                            @endphp
                            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
@if (!in_array($applyleaveDatas->status, $displayedValues))
<option value="{{ $applyleaveDatas->status }}">
                                        @if ($applyleaveDatas->status == 0)
Created
@elseif($applyleaveDatas->status == 1)
Approved
@else
Rejected
@endif
                                    </option>
                                    @php
                                        $displayedValues[] = $applyleaveDatas->status;
                                    @endphp
@endif
@endforeach
                        </select>
                        <button id="clickExcell" style="display: none; float:right;position: relative; top: -42px;"
                            class="btn btn-success">Download</button>
                    </div>
                </td>




                <td>
                    <div class="form-group">
                        <input type="date" class="form-control startclass" id="start1" name="start">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>









    <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Name *</label>
                <select required class="language form-control" id="key" name="teammember_id[]">

                    <option value="">Please Select One</option>
                    @foreach ($teammember as $teammemberData)
<option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                            {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
                            {{ $teammemberData->staffcode }} )</option>
@endforeach
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Type *</label>
                <select required class="form-control key" id="key" name="type[]">

                    <option value="">Please Select One</option>
                    <option value="0">Team Leader</option>
                    <option value="2">Staff</option>
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 60; //Input fields increment limitation
            var addButton = $('.add_buttonn'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML =
                '<div class="row row-sm "><div class="col-6"><div class="form-group"><label class="font-weight-600">Name</label><select required class="language form-control" name="teammember_id[]" id="key"><option value="">Please Select One</option>@foreach ($teammember as $teammemberData)<option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>  {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) ( {{ $teammemberData->staffcode }} )</option>@endforeach</select></div></div><div class="col-5"><div class="form-group"><label class="font-weight-600">Type</label><select required class="form-control key" name="type[]" id="key"><option value="">Please Select One</option><option value="0">Team Leader</option><option value="2">Staff</option></select></div></div><a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}" /></a></div></div>'; //New input field html 
            var x = 1; //Initial field counter is 1

            // Initialize Select2 for existing select boxes
            $('.language').select2();

            // Once add button is clicked
            $(addButton).click(function() {
                // Check maximum number of input fields
                if (x < maxField) {
                    x++; // Increment field counter
                    $(wrapper).append(fieldHTML); // Add field html
                    // Initialize Select2 for the newly added select box
                    $(wrapper).find('.language').select2();
                }
            });

            // Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); // Remove field html
                x--; // Decrement field counter
            });
        });
    </script>
    {{--  Start Hare --}}
    {{-- *   --}}


    <div style="display: flex">
        <div class="panel-header text-center" style=" margin-right: 22px;">
            <a style="color: white" class="btn btn-success" id="editCompany" data-id="{{ $debtorid }}"
                data-status="1" data-toggle="modal" data-target="#exampleModal1">
                Accept </a>
        </div>

        <div class="panel-header text-center">
            <a style="color: white" class="btn btn-danger" id="editCompany2" data-id="{{ $debtorid }}"
                data-status="0" data-toggle="modal" data-target="#exampleModal12">
                Refuse
            </a>
        </div>
    </div>

    <script>
        $(function() {
            // Function to handle click on "Accept" button
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var acceptButton = $(this); // Reference to the clicked "Accept" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        acceptButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal1').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Function to handle click on "Refuse" button
            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var refuseButton = $(this); // Reference to the clicked "Refuse" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        refuseButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal12').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>
    {{--  Start Hare --}}

    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>






    {{-- *   --}}
    [12:52 PM] sukhbahadur
    <a style="color: white" class="btn btn-success" id="editCompany" data-id="{{ $debtorid }}" data-toggle="modal"
        data-target="#exampleModal1" onclick="return confirm('Are you sure ?');">
        Accept </a>



    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('otpap/store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Enter
                            Verification OTP</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
<li style="color:red;">{{ $e }}</li>
@endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <div class="col-sm-12">
                                <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",

                    url: "{{ url('confirmationauthotp') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // alert(res);
                        debugger;
                        $("#id").val(response.id);


                    },
                    error: function() {

                    },
                });
            });
        });
    </script>



    {{--  Start Hare --}}

    <td>
        @if (Auth::user()->teammember_id == 157)
@if ($timesheetrequestsData->status == 0)
<span class="badge badge-pill badge-warning">Created</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
<span class="badge badge-pill badge-warning">Approved by partner</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
<span class="badge badge-pill badge-success">Approved</span>
@elseif($timesheetrequestsData->status == 2)
<span class="badge badge-pill badge-danger">Rejected</span>
@else
<span class="badge badge-pill badge-primary">Hold</span>
@endif
@else
@if ($timesheetrequestsData->status == 0)
<span class="badge badge-pill badge-warning">Created</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
<span class="badge badge-pill badge-warning">Pending for final
                    approval</span>
@elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
<span class="badge badge-pill badge-success">Approved</span>
@elseif($timesheetrequestsData->status == 2)
<span class="badge badge-pill badge-danger">Rejected</span>
@else
<span class="badge badge-pill badge-primary">Hold</span>
@endif
@endif

        @if (Auth::user()->teammember_id == $timesheetrequestsData->createdby)
@if ($timesheetrequestsData->status < 2 && $timesheetrequestsData->validate == null)
<a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
                    data-target="#exampleModal112" title="Send Reminder">
                    <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
                </a>
@endif
@endif
    </td>


    <a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
        data-target="#exampleModal112" title="Send Reminder">
        <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
    </a>


    {{-- request reminder modal --}}
    <div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background: #218838;">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Request
                        Reminder
                        list</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
<li style="color:red;">{{ $e }}</li>
@endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="reminderTable" class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Reminder Count</th>
                                    <th>Last Reminder Date</th>
                                </tr>
                            </thead>
                            <tbody id="timesheetTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-success sendReminderBtn"> Send Reminder</a>
                </div>

            </div>
        </div>
    </div>

    {{-- *   --}}
    {{--  Start Hare --}}
    {!! $description ?? '' !!}

    <p><br /> <br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br />
        We
        confirm that the in our books of account, the outstanding balance as on 30.09.2022 is
        <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span> <br />
    </p>
    <h1 style="text-align: center;"><strong><a
                href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}"><span
                    style="color: #000000; background-color: #99cc00;">Accept&nbsp;</span> &nbsp; &nbsp; <span
                    style="background-color: #ff6600; color: #000000;">&nbsp;&nbsp;</span></a><span
                style="color: #000000; background-color: #ff6600;"><a
                    style="color: #000000; background-color: #ff6600;"
                    href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $no) }}">Refuse
                </a>&nbsp;</span></strong></h1>
    <p>&nbsp;</p>
    <br>
    <hr>
    <p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
    <p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended
            for
            a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
            distribution, transmission, copying or disclosure of this information in any way or in any manner is
            strictly
            prohibited. You should delete this message and inform the sender. </em></p>
    <p>&nbsp;</p>

    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
        href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}

    {{-- *   --}}
    {{--  Start Hare --}}
    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}
</body>

</html>

<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-6 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-6 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Client List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                <br>
                @component('backEnd.components.alert')
                @endcomponent
                <div class="table-responsive">

                    {{-- <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assignment Id</th>
                                <th>Assignment</th>
                                <th>Total Hour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teammemberDatas as $teammemberData)
                                <tr>
                                    @php
                                        $totalhour = DB::table('timesheetusers')
                                            ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                                            ->where(
                                                'timesheetusers.assignmentgenerate_id',
                                                $teammemberData->assignmentgenerate_id,
                                            )
                                            ->where('timesheetusers.createdby', $teammemberData->teamid)
                                            ->select(DB::raw('SUM(totalhour) as total_hours'))
                                            ->first();
                                    @endphp

                                    <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}</td>
                                    <td>{{ $teammemberData->assignmentgenerate_id }}</td>
                                    <td>{{ $teammemberData->assignmentname }}</td>
                                    <td>{{ $totalhour->total_hours ?? 0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Assignment Id</th>
                                <th>Assignment</th>
                                <th>Total Hour</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($teammemberDatas as $teammemberData)
                                <tr> --}}
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


                            {{-- <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}</td>
                                    <td>{{ $teammemberData->assignmentgenerate_id }}</td>
                                    <td>{{ $teammemberData->assignmentname }}</td>
                                    <td>{{ $teammemberData->teamhour ?? 0 }}</td> --}}
                            {{-- <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
                            {{-- </tr>
                            @endforeach --}}


                            @foreach ($patnerdata as $teammemberData)
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
                                @endphp --}}


                                    {{-- @php
                                        dd($teammemberData);
                                        // dd($teammemberData->teamid);
                                        // dd($teammemberData->otherpartner);
                                        // dd($teammemberData->leadpartner);
                                        // dd($teammemberData->teamid == $teammemberData->otherpartner);

                                        if ($teammemberData->teamid == $teammemberData->otherpartner) {
                                        }
                                        if ($teammemberData->teamid == $teammemberData->leadpartner) {
                                        }
                                    @endphp --}}


                                    @php
                                        $totalhour = DB::table('timesheetusers')
                                            ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                                            ->where(
                                                'timesheetusers.assignmentgenerate_id',
                                                $teammemberData->assignmentgenerate_id,
                                            )
                                            ->where('timesheetusers.createdby', $teammemberData->teamid)
                                            ->select(DB::raw('SUM(totalhour) as total_hours'))
                                            ->first();

                                        if ($teammemberData->teamid == $teammemberData->otherpartner) {
                                            $update = DB::table('assignmentmappings')
                                                ->where('assignmentgenerate_id', $teammemberData->assignmentgenerate_id)
                                                ->where('otherpartner', $teammemberData->teamid)
                                                ->update(['otherpartnerhour' => $totalhour->total_hours]);
                                        }
                                        if ($teammemberData->teamid == $teammemberData->leadpartner) {
                                            $update = DB::table('assignmentmappings')
                                                ->where('assignmentgenerate_id', $teammemberData->assignmentgenerate_id)
                                                ->where('leadpartner', $teammemberData->teamid)
                                                ->update(['leadpartnerhour' => $totalhour->total_hours]);
                                        }
                                    @endphp



                                    {{-- <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}</td>
                                    <td>{{ $teammemberData->assignmentgenerate_id }}</td>
                                    <td>{{ $teammemberData->assignmentname }}</td>
                                    <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
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
                    filename: 'All Client List',
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

<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('clientassignmentlist/' . $clientid) }}">Back</a></li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->

    <!--/.body content-->
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <div class="table-responsive">
                    {{-- <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Assignment Id</th>
                                <th>Assignment</th>
                                <th>Client</th>
                                <th>Deadline</th>
                                <th>Period Start</th>
                                <th>Period End</th>
                                <th>Assigned Partner</th>
                                <th>Other Partner</th>
                                <th>Team Leader</th>
                                <th>Teammember</th>
                                @if (auth()->user()->role_id != 15)
                                    <th>Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                <tr>
                                    <td> <a
                                            href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}</a>
                                    </td>
                                    <td>
                                        {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                            ({{ $assignmentmappingDatas->assignmentname }})
                                        @endif
                                    </td>
                                    <td> {{ $assignmentmappingDatas->client_name }}</td>
                                    <td>
                                        @if ($assignmentmappingDatas->duedate != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->periodstart != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodstart)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->periodend != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                        @endif
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->leadpartner)->first()->team_member ?? '' }}
                                    </td>
                                    <td>
                                        @if ($assignmentmappingDatas->otherpartner != null)
                                            {{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->otherpartner)->first()->team_member ?? '' }}
                                        @else
                                            @if (auth()->user()->role_id == 11)
                                                <div class="card-head">
                                                    <a data-toggle="modal" data-target="#exampleModal1{{ $loop->index }}"
                                                        class="btn btn-info-soft btn-sm"><i class="fa fa-plus"></i></a>
                                                </div>
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>
                                    @if (auth()->user()->role_id != 15)
                                        <td>
                                            <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                        </td>
                                    @endif
                                </tr>
                                @if (auth()->user()->role_id == 11)
                                    <div class="modal fade" id="exampleModal1{{ $loop->index }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success">
                                                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add
                                                        Other Partner</h5>
                                                    <div>
                                                        <ul>
                                                            @foreach ($errors->all() as $e)
                                                                <li style="color:red;">{{ $e }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="detailsForm" method="post"
                                                    action="{{ url('otherpatner/update') }}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="modal-body">
                                                        <div class="details-form-field form-group row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-weight-600">Other Partner </label>
                                                                    <select class="language form-control"
                                                                        id="exampleFormControlSelect1" name="otherpatnerid">
                                                                        <option value="">Please Select One</option>
                                                                        @foreach ($partner as $teammemberData)
                                                                            <option value="{{ $teammemberData->id }}">
                                                                                {{ $teammemberData->team_member }} (
                                                                                {{ $teammemberData->staffcode }} )
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="assignmentgenerate_id"
                                                                        value="{{ $assignmentmappingDatas->assignmentgenerate_id }}"
                                                                        class=" form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table> --}}

                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="textfixed">Assignment Id</th>
                                <th class="textfixed">Assignment</th>
                                <th class="textfixed">Client</th>
                                <th class="textfixed">Client Code</th>
                                <th class="textfixed">Deadline</th>
                                <th class="textfixed">Period Start</th>
                                <th class="textfixed">Period End</th>
                                <th class="textfixed">Assigned Partner</th>
                                <th class="textfixed">Other Partner</th>
                                <th class="textfixed">Team Leader</th>
                                <th class="textfixed">Teammember</th>
                                @if (auth()->user()->role_id != 15)
                                    <th class="textfixed">Edit</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                <tr>
                                    <td> <a
                                            href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}</a>
                                    </td>
                                    <td>
                                        {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                            ({{ $assignmentmappingDatas->assignmentname }})
                                        @endif
                                    </td>
                                    <td> {{ $assignmentmappingDatas->client_name }}</td>
                                    <td> {{ $assignmentmappingDatas->client_code }}</td>
                                    <td class="textfixed">
                                        @if ($assignmentmappingDatas->duedate != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                        @endif
                                    </td>
                                    <td class="textfixed">
                                        @if ($assignmentmappingDatas->periodstart != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodstart)) }}
                                        @endif
                                    </td>
                                    <td class="textfixed">
                                        @if ($assignmentmappingDatas->periodend != null)
                                            {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                        @endif
                                    </td>
                                    {{-- <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->leadpartner)->first()->team_member ?? '' }}
                                        ({{ App\Models\Teammember::select('team_member', 'staffcode')->where('id', $assignmentmappingDatas->leadpartner)->first()->staffcode ?? '' }})
                                    </td>
                                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingDatas->otherpartner)->first()->team_member ?? '' }}
                                        ({{ App\Models\Teammember::select('team_member', 'staffcode')->where('id', $assignmentmappingDatas->otherpartner)->first()->staffcode ?? '' }})
                                    </td> --}}
                                    @php

                                        $leadpartner = DB::table('teammembers')
                                            ->leftJoin(
                                                'teamrolehistory',
                                                'teamrolehistory.teammember_id',
                                                '=',
                                                'teammembers.id',
                                            )
                                            ->where('teammembers.id', $assignmentmappingDatas->leadpartner)
                                            ->select(
                                                'teammembers.team_member',
                                                'teammembers.staffcode',
                                                'teamrolehistory.newstaff_code',
                                            )
                                            ->first();

                                        $otherPartner = DB::table('teammembers')
                                            ->leftJoin(
                                                'teamrolehistory',
                                                'teamrolehistory.teammember_id',
                                                '=',
                                                'teammembers.id',
                                            )
                                            ->where('teammembers.id', $assignmentmappingDatas->otherpartner)
                                            ->select(
                                                'teammembers.team_member',
                                                'teammembers.staffcode',
                                                'teamrolehistory.newstaff_code',
                                            )
                                            ->first();

                                    @endphp

                                    <td>
                                        {{ $leadpartner->team_member ?? '' }}
                                        @if ($leadpartner && $leadpartner->team_member)
                                            (
                                            {{ $leadpartner->newstaff_code ?? ($leadpartner->staffcode ?? '') }})
                                        @endif
                                    </td>
                                    <td>
                                        {{ $otherPartner->team_member ?? '' }}
                                        @if ($otherPartner && $otherPartner->team_member)
                                            (
                                            {{ $otherPartner->newstaff_code ?? ($otherPartner->staffcode ?? '') }})
                                        @endif
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}({{ $sub->staffcode }})">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}({{ $sub->staffcode }})">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                            @if ($sub->profilepic == null)
                                                <a class="avatar avatar-xs" data-toggle="tooltip"
                                                    title="{{ $sub->team_member }}({{ $sub->staffcode }})">
                                                    <img src="{{ url('backEnd/image/dummy.png') }}"
                                                        class="avatar-img rounded-circle" alt="...">
                                                @else
                                                    <a class="avatar avatar-xs" data-toggle="tooltip"
                                                        title="{{ $sub->team_member }}({{ $sub->staffcode }})">
                                                        <img src="{{ asset('backEnd/image/teammember/profilepic/' . $sub->profilepic) }}"
                                                            class="avatar-img rounded-circle" alt="...">
                                            @endif
                                        @endforeach
                                    </td>
                                    @if (auth()->user()->role_id != 15)
                                        <td>
                                            <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
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
                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                @else
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                @endif
                orderable: false
            }],
            buttons: []
        });
    });
</script>

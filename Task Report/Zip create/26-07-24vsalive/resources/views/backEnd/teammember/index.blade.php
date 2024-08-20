<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        @if (Auth::user()->role_id != 18)
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item">
                        <div class="btn-group mb-2 mr-1">
                            <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                @if (Request::query('status') == '1')
                                    Active
                                @elseif (Request::query('status') == '0')
                                    Inactive
                                @else
                                    All
                                @endif
                            </button>
                            <div class="dropdown-menu">
                                <a style="color: #37A000" class="dropdown-item"
                                    href="{{ url('/teamstatus?' . 'status=' . '1') }}">Active</a>
                                <a style="color: #37A000" class="dropdown-item"
                                    href="{{ url('/teamstatus?' . 'status=' . '0') }}">Inactive</a>
                                <a style="color: #37A000" class="dropdown-item" href="{{ url('/teammember') }}">All</a>
                            </div>
                        </div>
                    </li>
                    <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm"
                            href="{{ url('teammember/create') }}">Add Teammember</a></li>

                </ol>
            </nav>
        @endif
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="{{ url('home') }}">
                        <h1 class="font-weight-bold" style="color:black;">Home</h1>
                    </a>
                    <small>Team List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            @component('backEnd.components.alert')
            @endcomponent
            <div class="card-body">
                <div class="table-responsive">
                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Profile Completed</th>
                                <th>TItle</th>
                                <th>Team Member Name</th>
                                <th>Team Profile Image</th>
                                <th>Staff Code</th>
                                <th>Team Role</th>
                                <th>Designation</th>
                                <th>Mobile No</th>
                                <th>Date Of Birth</th>
                                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                    <th>Category</th>
                                    <th>Cost Hourly</th>
                                @endif
                                <th>Joining Date</th>
                                <th>Leaving Date</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Personal Email</th>
                                @if (Auth::user()->role_id == 18)
                                    <th>Appointment Letter</th>
                                    <th>User Status</th>
                                @endif
                                <th>Status</th>

                                <th>Communication Address</th>
                                <th>Permanent Address</th>
                                <th>Address Upload</th>
                                <th>Adharcard Number</th>
                                <th>Adharcard Document</th>
                                <th>Pancard No</th>
                                <th>Pancard Document</th>
                                <th>Emergencycontact Number</th>
                                <th>Name Of Bank</th>
                                <th>Bank Account Number</th>
                                <th>Ifsc Code</th>
                                <th>Cancel Cheque</th>
                                <th>Mother Name</th>
                                <th>Mother Number</th>
                                <th>Father Name</th>
                                <th>Father Number</th>

                                <!--  <th>Deactivate</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teammemberDatas as $teammemberData)
                                <tr>
                                    <td style="display: none;">{{ $teammemberData->id }}</td>
                                    <td class="text-center">
                                        @php
                                            $totalFields = 23;
                                            $filledFields = 0;

                                            $filledFields += !empty($teammemberData->id) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->team_member) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->staffcode) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->emailid) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->personalemail) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->mobile_no) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->dateofbirth) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->adharcardnumber) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->aadharupload) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->pancardno) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->panupload) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->profilepic) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->mothername) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->mothernumber) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->fathername) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->fathernumber) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->joining_date) ? 1 : 0;
                                            // $filledFields += !empty($teammemberData->leavingdate) ? 1 : 0;
                                            // $filledFields += !empty($teammemberData->addressupload) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->permanentaddress) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->communicationaddress) ? 1 : 0;
                                            // $filledFields += !empty($teammemberDataificationData->qualification) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->nameasperbank) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->nameofbank) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->bankaccountnumber) ? 1 : 0;
                                            $filledFields += !empty($teammemberData->cancelcheque) ? 1 : 0;

                                            $profileCompletionPercentage = ($filledFields / $totalFields) * 100;
                                            $formattedProfileCompletion = number_format(
                                                $profileCompletionPercentage,
                                                2,
                                            );
                                        @endphp
                                        @if ($formattedProfileCompletion == 100)
                                            <span class="badge badge-pill badge-success"
                                                style="width: 55px;
                                                height: 20px;
                                                font-size: 12px;">{{ $formattedProfileCompletion }}%</span>
                                        @else
                                            <span class="badge badge-pill badge-danger"
                                                style=" width: 55px;
                                                height: 20px;
                                                font-size: 12px;">{{ $formattedProfileCompletion }}%</span>
                                        @endif
                                    </td>
                                    <td>{{ App\Models\Title::select('title')->where('id', $teammemberData->title_id)->first()->title ?? '' }}
                                    </td>
                                    <td>
                                        @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                            <a href="{{ route('teammember.edit', $teammemberData->id) }}">
                                        @endif
                                        {{ $teammemberData->team_member }}
                                        @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($teammemberData->profilepic != null)
                                            <a target="blank" href="{{ $teammemberData->profilepic }}"
                                                class="avatar avatar-xs" data-toggle="tooltip"
                                                title="{{ $teammemberData->team_member }}">
                                                <img src="{{ $teammemberData->profilepic }}"
                                                    class="avatar-img rounded-circle" alt="...">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
                                        @if ($teammemberData->newstaff_code)
                                            ({{ $teammemberData->staffcode }})
                                        @endif
                                    </td>
                                    <td>{{ $teammemberData->role->rolename ?? '' }}</td>
                                    <td>{{ $teammemberData->designation ?? '' }}</td>

                                    <td>{{ $teammemberData->mobile_no }}</td>
                                    @if ($teammemberData->dateofbirth == null)
                                        <td></td>
                                    @else
                                        <td>{{ date('d-m-Y', strtotime($teammemberData->dateofbirth)) }}
                                    @endif
                                    @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                                        <td>{{ $teammemberData->category ?? '' }}</td>
                                        <td>{{ $teammemberData->cost_hour ?? '' }}</td>
                                    @endif
                                    @if ($teammemberData->joining_date == null)
                                        <td></td>
                                    @else
                                        <td>{{ date('d-m-Y', strtotime($teammemberData->joining_date)) }}
                                    @endif
                                    @if ($teammemberData->leavingdate == null)
                                        <td></td>
                                    @else
                                        <td>{{ date('F d,Y', strtotime($teammemberData->leavingdate)) }}</td>
                                    @endif
                                    <td>{{ $teammemberData->department ?? '' }}</td>
                                    <td><a
                                            href="mailto:{{ $teammemberData->emailid }}">{{ $teammemberData->emailid ?? '' }}</a>
                                    </td>
                                    <td><a
                                            href="mailto:{{ $teammemberData->personalemail }}">{{ $teammemberData->personalemail ?? '' }}</a>
                                    </td>
                                    @if (Auth::user()->role_id == 18)
                                        <td><a
                                                href="{{ asset('backEnd/image/appointmentletter/' . $teammemberData->appointment_letter) }}">{{ $teammemberData->appointment_letter ?? '' }}</a>
                                        </td>
                                        <td>
                                            @if ($teammemberData->status == 0)
                                                <span class="badge badge-danger">In Active</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                    @endif

                                    <td>


                                        @if ($teammemberData->status == 0)
                                            <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/1/' . $teammemberData->id) }}"
                                                onclick="return confirm('Are you sure you want to Active this teammember?');">
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                    data-target="#requestModal">Inactive</button>
                                            </a>
                                        @else
                                            <a href="{{ url('/changeteamStatus/' . $teammemberData->status . '/0/' . $teammemberData->id) }}"
                                                onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                                                <button class="btn btn-primary" data-toggle="modal"
                                                    style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                    data-target="#requestModal">Active</button>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $teammemberData->communicationaddress ?? '' }}</td>
                                    <td>{{ $teammemberData->permanentaddress ?? '' }}</td>
                                    <td>
                                        @if ($teammemberData->addressupload != null)
                                            <a
                                                href="{{ $teammemberData->addressupload }}">{{ $teammemberData->addressupload ?? '' }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $teammemberData->adharcardnumber ?? '' }}</td>
                                    <td>
                                        @if ($teammemberData->aadharupload != null)
                                            <a
                                                href="{{ url('backEnd/image/teammember/aadharupload/', $teammemberData->aadharupload) }}">{{ $teammemberData->aadharupload ?? '' }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $teammemberData->pancardno ?? '' }}</td>
                                    <td>
                                        @if ($teammemberData->panupload != null)
                                            <a
                                                href="{{ $teammemberData->panupload ?? '' }}">{{ $teammemberData->panupload ?? '' }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $teammemberData->emergencycontactnumber ?? '' }}</td>
                                    <td>{{ $teammemberData->nameofbank ?? '' }}</td>
                                    <td>{{ $teammemberData->bankaccountnumber ?? '' }}</td>
                                    <td>{{ $teammemberData->ifsccode ?? '' }}</td>
                                    <td><a
                                            href="{{ asset('backEnd/image/teammember/cancelcheque/' . $teammemberData->cancelcheque) }}">{{ $teammemberData->cancelcheque ?? '' }}</a>
                                    </td>
                                    <td>{{ $teammemberData->mothername ?? '' }}</td>
                                    <td>{{ $teammemberData->mothernumber ?? '' }}</td>
                                    <td>{{ $teammemberData->fathername ?? '' }}</td>
                                    <td>{{ $teammemberData->fathernumber ?? '' }}</td>

                                    <!--   <td> <form action="{{ route('teammember.destroy', $teammemberData->id) }}" method="POST">
                                                                                                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                                                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                                                                                                      <a  onclick="return confirm('Are you sure you want to deactivate this item?');" class="btn btn-danger-soft btn-sm"><i
                                                                                                                                                    class="fa fa-user-times"></i></a>
                                                                                                                                                </form></td>-->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!--/.body content-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ url('/changeteamStatus') }}",
                    data: {
                        'status': status,
                        'user_id': user_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>
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
        var status = @json(Request::query('status'));

        var filename = 'All Team Member List';
        if (status == '1') {
            filename = 'Active Team Members';
        } else if (status == '0') {
            filename = 'Inactive Team Members';
        }

        $('#examplee').DataTable({
            "pageLength": 130,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
                    20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33
                ],
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: filename,
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

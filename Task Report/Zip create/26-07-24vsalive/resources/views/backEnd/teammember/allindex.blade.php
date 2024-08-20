@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
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
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Team Member Name</th>
                                <th>Team Role</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teammemberDatas as $teammemberData)
                                <tr>
                                    <td>
                                        {{ $teammemberData->team_member }} (
                                        {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }} )
                                    </td>
                                    <td>{{ $teammemberData->role->rolename ?? '' }}</td>

                                    <td>{{ $teammemberData->mobile_no }}</td>

                                    <td><a
                                            href="mailto:{{ $teammemberData->emailid }}">{{ $teammemberData->emailid ?? '' }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!--/.body content-->
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                // 'l' for the length menu
                dom: 'lBfrtip',

                columnDefs: [{
                    targets: [1, 2, 3],
                    orderable: false
                }],
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Active Team Report',
                        filename: 'Team List',
                    },
                    'colvis'
                ]
            @else
                columnDefs: [{
                    targets: [1, 2, 3],
                    orderable: false
                }],
                buttons: []
            @endif
        });
    });
</script>

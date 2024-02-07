 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


 <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
 @extends('backEnd.layouts.layout') @section('backEnd_content')
     <style>
         .select2-container {
             width: 48% !important;
         }
     </style>
     <!--Content Header (Page header)-->
     <div class="content-header row align-items-center m-0">
         {{-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
             @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                 @if (Request::is('teamapplication/store'))
                     <a href="{{ url('applyleave') }}" style="float: right" class="btn btn-success ml-2">Back</a>
                 @endif
                 @if (Request::is('applyleave'))
                     <a href="{{ url('applyleave/create/') }}" style="float: right;" class="btn btn-success ml-2">Apply
                         Leave</a>
                 @endif
             @endif
             <form method="post" action="{{ url('teamapplication/store') }}" enctype="multipart/form-data">
                 @csrf
                 <button type="submit" style="float: right;" class="btn btn-success" style="float:right"> Submit</button>
                 <select class="language form-control" id="exampleFormControlSelect1" name="member"
                     @if (Request::is('applyleave/*/edit')) > <option disabled style="display:block">Please Select One
                 </option>

                 @foreach ($teammember as $teammemberData)
                 <option value="{{ $teammemberData->id }}"
                     {{ $applyleave->Approver == $teammemberData->id ?? '' ? 'selected="selected"' : '' }}>
                     {{ $teammemberData->team_member }}( {{ $teammemberData->role->rolename }} )</option>
                 @endforeach


                 @else
                 <option></option>
                 <option value="">Please Select One</option>
                 @foreach ($teammember as $teammemberData)
                 <option value="{{ $teammemberData->id }}">
                     <a href="{{ url('teamapplication/' . $teammemberData->id) }}"> {{ $teammemberData->team_member }} </a></option>

                 @endforeach @endif
                     </select>
             </form>

         </nav> --}}
         <div class="col-sm-8 header-title p-0">
             <div class="media">
                 <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                 <div class="media-body">
                     <h1 class="font-weight-bold">Home</h1>
                     <small>Exam leave revert</small>
                 </div>
             </div>
         </div>
     </div>
     <div class="body-content">



     </div>
     <!--/.Content Header (Page header)-->
     <div class="body-content">
         <div class="card mb-4">
             <div class="card-header" style="background:#37A000">
                 <div class="d-flex justify-content-between align-items-center">
                     <div>
                         <h6 class="fs-17 font-weight-600 mb-0">
                             <span style="color:white;">Exam Leave Revert</span>
                         </h6>
                     </div>
                 </div>
             </div>
             <div class="card-body">
                 @component('backEnd.components.alert')
                 @endcomponent
                 <div class="table-responsive">
                     <table id="examplee" class="table display table-bordered table-striped table-hover">
                         <thead>
                             <tr>
                                 <th style="display: none;">id</th>
                                 <th>Employee</th>
                                 <th>Status</th>
                                 <th>Leave Type</th>
                                 <th>Date</th>
                                 <th>Approver</th>
                                 <th>Reason</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                                 <tr>
                                     <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                                     {{-- <td>{{ $timesheetrequestsData->createdbyauth }}</td> --}}
                                     @if (auth()->user()->role_id == 11)
                                         <td>
                                             {{-- <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}"> --}}
                                             <a href="{{ url('examleaverequest', $timesheetrequestsData->id) }}">
                                                 {{ $timesheetrequestsData->createdbyauth ?? '' }}</a>
                                         </td>
                                     @else
                                         <td>{{ $timesheetrequestsData->createdbyauth }}</td>
                                     @endif
                                     <td>
                                         @if ($timesheetrequestsData->status == 0)
                                             <span class="badge badge-pill badge-warning">Created</span>
                                         @elseif($timesheetrequestsData->status == 1)
                                             <span class="badge badge-pill badge-success">Approved</span>
                                         @else
                                             <span class="badge badge-pill badge-danger">Rejected</span>
                                         @endif
                                     </td>
                                     <td>{{ $timesheetrequestsData->name }}</td>

                                     <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>

                                     <td>{{ $timesheetrequestsData->team_member }}</td>
                                     <td>{{ $timesheetrequestsData->reason }}</td>
                                     {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
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
             "pageLength": 100,
             "order": [
                 [0, "desc"]
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

 <!--Third party Styles(used by this page)-->
 {{-- <link href="{{ url('backEnd/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet"> --}}
 @extends('backEnd.layouts.layout') @section('backEnd_content')
     <!--Content Header (Page header)-->
     <div class="content-header row align-items-center m-0">
         <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
             <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                 <li class="breadcrumb-item"><a href="{{ url('step/create') }}">Add Checklist</a></li>
                 <li class="breadcrumb-item active">+</li>
             </ol>
         </nav>
         <div class="col-sm-8 header-title p-0">
             <div class="media">
                 <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                 <div class="media-body">
                     <h1 class="font-weight-bold">Home</h1>
                     <small>Check List</small>
                 </div>
             </div>
         </div>
     </div>
     <!--/.Content Header (Page header)-->
     <div class="body-content">
         <div class="card mb-4">
             <div class="card-body">
                 <div class="card-head">
                     <b>Assignment name : {{ $assignmentname->assignment_name }}</b>
                     @if (empty($dlt))
                         <a style="float: right"
                             onclick="return confirm('Are you sure you want to delete this assignment checklist?');"
                             href="{{ url('/deleteassignmentchecklist/' . $assignmentname->id) }}"
                             class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>
                     @endif
                 </div>
                 <hr>
                 <div class="table-responsive">
                     <table id="examplee" class="table display table-bordered table-striped table-hover">
                         <thead>
                             <tr>
                                 <th>Financial Name</th>
                                 <th>Subclassfication Name</th>
                                 <th>Step Name</th>
                                 <th>Audit Procedure</th>
                                 {{-- <th>Edit</th>
                            <th>Deactivate</th> --}}
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($stepDatas as $stepData)
                                 <tr>
                                     <td>{{ $stepData->financial_name }}</td>
                                     <td>{{ $stepData->subclassficationname }}</td>
                                     <td>{{ $stepData->stepname }}</td>
                                     <td>
                                         {{ $stepData->auditprocedure }}
                                         {{-- <div class="">
                                <table >
                                   
                                    <tbody >
                                        @foreach (App\Models\Auditquestion::where('steplist_id', $stepData->id)->where('subclassfied_id', $stepData->subclassfied_id)->get() as $sub => $value)
                                  <tr>
                                    <td>
                                        {{ $sub+1}}
                                      </td>
                                      <td>
                                        {{ $value->auditprocedure}}
                                      </td>
                                  </tr>
                                  @endforeach
                                    </tbody>
                                </table>
                            
                            </div> --}}


                                     </td>
                                     {{-- <td>  <a href="{{route('step.edit', $stepData->id)}}" class="btn btn-primary">Edit</a></td>
                             <td> <form 
                                action="{{ route('step.destroy', $stepData->id) }}" 
                                 method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button  onclick="return confirm('Are you sure you want to deactivate this item?');" class="btn btn-info">Deactivate</button>
                            --}}
                                     </form>
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

 <script>
     $(document).ready(function() {
         $('#examplee').DataTable({
             dom: 'Bfrtip',
             "order": [
                 [0, "asc"]
             ],

             columnDefs: [{
                 targets: [1, 2, 3],
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
                     filename: 'Checklist',
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     filename: 'Checklist',
                     exportOptions: {
                         columns: [0, 1, 2, 3]
                     }
                 },
                 'colvis'
             ]
         });
     });
 </script>

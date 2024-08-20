<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')

<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
    
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('vendor/create')}}">Add Vendor</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>

    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Vendor
                    List</small>
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
               <table id="examplee" class="display nowrap">
                    <thead>
                        <tr>
							  <th style="display: none;">id</th>
                             <th>Status</th>
                             <th>Created Date</th>
							 <th>NEFT/Cheque Date</th>
                             <th>Paid Date</th>
                             <th>NEFT/Cheque Details</th>
                             <th>Created By</th>
                             <th>Approver</th>
                             <th>Vendor Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Item Name</th>
                            <th>Amount</th>
                            <th>Bill</th>
                            <th>Benificiary Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th>Type</th>
                       
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendorlist as $vendorlistDatas)
                        <tr>
							  <td style="display: none;">{{$vendorlistDatas->id }}</td>
                            <td>@if(Auth::user()->role_id == 17)
                                @if($vendorlistDatas->status == 1)
                                <a id="editCompany" data-toggle="modal" data-id="{{ $vendorlistDatas->id }}"
                                    data-target="#modaldemo1">
                                @endif
                                @endif
									@if($vendorlistDatas->status==0)
                                <span class="badge badge-pill badge-warning">Created</span>
                                @elseif($vendorlistDatas->status==1)
                                <span class="badge badge-pill badge-success">Approved</span>
                             
                                @elseif($vendorlistDatas->status==2)
                                <span class="badge badge-pill badge-info">Submit</span>
                               
                                @elseif($vendorlistDatas->status==4)
                                <span class="badge badge-pill badge-secondary">Paid</span>
                                @elseif($vendorlistDatas->status==3)

                                <span class="badge badge-pill badge-danger">Reject</span>

                                @endif
									  @if(Auth::user()->role_id == 17)
                                @if($vendorlistDatas->status > 1)
                                </a>
                                @endif
                                @endif
                            </td>
                            <td>{{ date('F d,Y', strtotime($vendorlistDatas->created_at)) }}</td> 
							<td>@if($vendorlistDatas->paymentdate != null){{ date('F d,Y', strtotime($vendorlistDatas->paymentdate)) }}@endif</td> 
                            <td>@if($vendorlistDatas->paiddate != null){{ date('F d,Y', strtotime($vendorlistDatas->paiddate)) }}@endif</td> 
                            <td>{{ $vendorlistDatas->payment }}</td> 
                            <td>{{ $vendorlistDatas->team_member }}</td> 
                            <td>{{ $vendorlistDatas->approver }}</td> 
                            <td>
                               <a href="{{ url('vendor/'.$vendorlistDatas->id)}}">{{ $vendorlistDatas->vendorname }}</a> 
                            </td> 
                            <td>{{ $vendorlistDatas->email }}</td> 
                            <td>{{ $vendorlistDatas->phoneno }}</td> 
                            <td>{{ $vendorlistDatas->itemname }}</td> 
                            <td>{{ $vendorlistDatas->amount }}</td> 
                            <td>
                                <a href="{{url('backEnd/image/vendor/'.$vendorlistDatas->bill)}}">{{ $vendorlistDatas->bill ??''}}</a></td> 
                            <td>{{ $vendorlistDatas->benficiaryname }}</td> 
                            <td>{{ $vendorlistDatas->bankname }}</td> 
                            <td>{{ $vendorlistDatas->accountnumber }}</td> 
                            <td>{{ $vendorlistDatas->ifsccode }}</td> 
                            <td>@if($vendorlistDatas->type==1)
                                <span class="badge badge-pill badge-warning">Temporary</span>
                            @elseif($vendorlistDatas->type==2)
                                <span class="badge badge-pill badge-secondary">Regular</span>

                                @endif
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
<div class="modal fade bd-example-modal-sm"  id="modaldemo1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background: #37A000">
                <h5  style="color: white"class="modal-title font-weight-600" id="exampleModalLabel1">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" method="post" action="{{ url('vendorupdate')}}"
            enctype="multipart/form-data">
                        @csrf     
            <div class="modal-body">
                <select name="status" required id="exampleFormControlSelect11" class="form-control">
                
                   
                    <option value="">Please Select One</option>
                    <option value="4">Paid</option>
               
                </select>
                <input class="form-control" hidden  value="" name="vendorid" id="id" type="text">
				 <br>
                <div class="form-group" >
                    
                      <input type="text" required name="payment" class="form-control"
                      placeholder="Enter NEFT/CHEQUE/">
                </div>
                <div class="form-group" >
                    
                      <input type="date" required name="paymentdate" class="form-control"
                      placeholder="Enter NEFT/CHEQUE/ Date">
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
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
    //        debugger;
            var id = $(this).data('id');
     debugger;
            $.ajax({
                type: "GET",

                url: "{{ url('vendorfetch') }}",
                data: "id=" + id,
                success : function(response){
           // alert(res);
           debugger;
           $("#id").val(response.id);

            
        },
                error: function () {

                },
            });
        });
    });

</script>
@endsection
ndsection
     <script src="https://code.jquery.com/jquery-3.5.1.js"></script>                               
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>                               
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>                               
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>    
<script>$(document).ready(function() {
    $('#examplee').DataTable( {
		"pageLength": 30,
        dom: 'Bfrtip',
        "order": [[ 0, "desc" ]],
        
        buttons: [
            
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
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
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            'colvis'      
    ]  
    } );
} );</script>                                

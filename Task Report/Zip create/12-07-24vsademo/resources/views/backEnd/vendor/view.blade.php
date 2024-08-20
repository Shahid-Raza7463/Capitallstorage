@extends('backEnd.layouts.layout') @section('backEnd_content')
<style>
	.table-bordered td, .table-bordered th {
    word-break: break-all;
}
	</style>
<!--Content Header (Page header)-->
<div class="content-header row align-items-center m-0">
  
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
     
    </nav>
 
    <div class="col-sm-8 header-title p-0">
        <div class="media">
            <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
            <div class="media-body">
                <h1 class="font-weight-bold">Home</h1>
                <small>Vendor
                    Details</small>
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

            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                <div class="card-body">

                    <fieldset class="form-group">

                        <table class="table display table-bordered table-striped table-hover">

                            <tbody>

                                <tr>
                                    <td><b>Vendor Name : </b></td>
                                    <td>{{ $vendor->vendorname ??''}}</td>
                                    <td><b>Email</b></td>
                                    <td>{{ $vendor->email ??''}}</td>
                                    <td><b>Phone : </b></td>
                                    <td>{{$vendor->phoneno ??''}}</td>
                                </tr>
                                <tr>
                                    <td><b>Beneficiary Name : </b></td>
                                    <td>{{$vendor->benficiaryname ??''}}</td>
                                    <td><b>Bank Name : </b></td>
                                    <td>{{ $vendor->bankname ??'' ??''}}
                                    </td>
                                    <td><b>Account Number : </b></td>
                                    <td>{{ $vendor->accountnumber ??'' ??''}}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>IFSC Code : </b></td>
                                    <td>{{$vendor->ifsccode ??''}}</td>
                                    <td><b>Type : </b></td>
                                    <td>@if($vendor->type==1)
                                        <span class="badge badge-pill badge-warning">Temporary</span>
                                    @elseif($vendor->type==2)
                                        <span class="badge badge-pill badge-secondary">Regular</span>
        
                                        @endif
                                    </td>
                                    <td><b>Item Name : </b></td>
                                    <td>{{ $vendor->itemname ??'' ??''}}
                                    </td>

                                </tr>

                                <tr>
                                    <td><b>Bill No : </b></td>
                                    <td><a href="{{url('backEnd/image/vendor/'.$vendor->bill)}}">{{ $vendor->bill ??''}}</a></td>
                               
                                    <td><b>Status : </b></td>
                                    <td>@if($vendor->status==0)
                                        <span class="badge badge-pill badge-warning">Created</span>
                                        @elseif($vendor->status==1)
                                        <span class="badge badge-pill badge-success">Approved</span>
                                     
                                        @elseif($vendor->status==2)
                                        <span class="badge badge-pill badge-info">Submit</span>
                                       
                                        @elseif($vendor->status==4)
                                        <span class="badge badge-pill badge-secondary">Paid</span>
                                        @elseif($vendor->status==3)

                                <span class="badge badge-pill badge-danger">Reject</span>
        
                                        @endif
                                    </td>
                                    <td><b>Date : </b></td>
                                    <td>{{ date('F d,Y', strtotime($vendor->created_at)) }}
                                    </td>

                                </tr>
                                <tr>
                                    <td><b>Created By : </b></td>
                                    <td>{{$vendor->team_member ??''}}</td>
                                    <td><b>Approver : </b></td>
                                    <td>{{$vendor->approvers ??''}}</td>
                                   <td></td>
                                   <td></td>

                                </tr>
								<tr>
                                    <td><b>Created Date : </b></td>
                                    <td>@if($vendor->created_at != null){{ date('F d,Y', strtotime($vendor->created_at)) }}
                            @endif</td>
                                    <td><b>NEFT/Cheque Date</b></td>
                                    <td>@if($vendor->paymentdate != null){{ date('F d,Y', strtotime($vendor->paymentdate)) }}@endif</td>
                                    <td><b>Paid Date : </b></td>
                                    <td>@if($vendor->paiddate != null){{ date('F d,Y', strtotime($vendor->paiddate)) }}@endif</td>
                                </tr>
								<tr>
                                    <td><b>Approved Date : </b></td>
                                    <td>@if($vendor->approvedate != null){{ date('F d,Y', strtotime($vendor->approvedate)) }}
                            @endif</td>
								</tr>
                                @if(Request::is('vendor/*'))
                                @if($vendor->approver == Auth::user()->teammember_id)

                                <tr>
                                    @if($vendor->status =='0')
                                    <td><b>Action :</b></td>
                                    <td>
                                        <div class="row">

                                            <form method="post"
                                                action="{{ route('vendor.update', $vendor->id)}}"
                                                enctype="multipart/form-data">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-success"> Approve</button>
                                                <input type="text" hidden id="example-date-input" name="status"
                                                    value="1" class="form-control" placeholder="Enter Location">
                                            </form>
                                          
                                                <button style="margin-left:11px;height: 35px;" data-toggle="modal"    data-target="#exampleModal12"  class="btn btn-danger">
                                                    Reject</button>
                                             
                                          
                                            @endif
                                        </div>
                                    </td>
                                   
                                </tr>


                                @endif
                                @endif
                            </tbody>

                        </table>


                    </fieldset>
                  
                </div>

            </div>


        </div>
    </div>

</div>
@endsection

 <!-- Small modal -->
 <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
 aria-hidden="true">
 <div class="modal-dialog" role="document">
     <div class="modal-content">
           <div class="modal-header" style="background:#37A000">
               <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">Reason For Rejection</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form method="post"   action="{{ route('vendor.update', $vendor->id)}}"  enctype="multipart/form-data">
               @method('PATCH') 
               @csrf   
           <div class="modal-body">
               <div class="row row-sm">
                   <div class="col-12">
                       <div class="form-group">
                           <textarea rows="6" name="remark" class="form-control"
                               placeholder=""></textarea>
                               <input hidden type="text" id="example-date-input" name="status"
                               value="3" class="form-control"
                               placeholder="Enter Location">
                       </div>
                   </div>
                   </div>
                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
               <button type="submit" style="float: right" class="btn btn-success">Save </button>
           </div>
           </form>
       </div>
   </div>
</div>
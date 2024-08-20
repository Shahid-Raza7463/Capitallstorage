  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <div class="content-header row align-items-center m-0">
          <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
              <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('template') }}">Template List</a></li>
                  <li class="breadcrumb-item active">+</li>
              </ol>
          </nav>
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                  <div class="media-body">
                      <a href="{{ url('home') }}">
                          <h1 class="font-weight-bold" style="color:black;">Home</h1>
                      </a>
                      <small>Confirmation List</small>
                  </div>
              </div>
          </div>
      </div>
      <div class="body-content">
          <div class="card mb-4">
              @component('backEnd.components.alert')
              @endcomponent
              <div class="card-header" style="background: #37A000">

                  <div class="d-flex justify-content-between align-items-center">

                      <div>
                          <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">
                              {{ $clientList->assignmentname ?? '' }}</h6>
                      </div>

                  </div>
              </div>
              <div class="card-body">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item">
                          <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                              role="tab" aria-controls="pills-home" aria-selected="true">Debtor</a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                              aria-controls="pills-contact" aria-selected="false">Creditor</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                              aria-controls="pills-user" aria-selected="false">Bank</a>
                      </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                          aria-labelledby="pills-home-tab">
                          <div class="table-responsive">
                              <br>
                              <div class="card-head" style="width:930px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg" class="btn btn-info-soft btn-sm">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="float:right;margin-top: -17px;">Add <a data-toggle="modal"
                                          data-target="#exampleModal1" class="btn btn-info-soft btn-sm"><i
                                              class="fa fa-plus"></i></a></b>
                              </div>
                              <hr>
                              <table class="table display table-bordered table-striped table-hover basic">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>amount</th>
                                          <th>year</th>
                                          <th>Date</th>
                                          <th>Address</th>
                                          <th>Email</th>
                                          <th>Email Status</th>
                                          <th>Status</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($clientdebit as $clientdebitdata)
                                          <tr>
                                              <td>{{ $clientdebitdata->name }}</td>
                                              <td>{{ $clientdebitdata->amount }}</td>
                                              <td>{{ $clientdebitdata->year }}</td>
                                              @if ($clientdebitdata->date != null)
                                                  <td>{{ date('F d,Y', strtotime($clientdebitdata->date)) }}</td>
                                              @else
                                                  <td></td>
                                              @endif
                                              <td>{{ $clientdebitdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientdebitdata->email }}">{{ $clientdebitdata->email }}</a>
                                              </td>
                                              <td>
                                                  @if ($clientdebitdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientdebitdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              {{-- <td>
                                                  @if ($clientdebitdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientdebitdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientdebitdata->status == 3)
                                                      <a href="{{ url('pending/mail', $clientdebitdata->id) }}"
                                                          onclick="return confirm('Are you sure you want to send notification?');">
                                                          <span class="badge badge-pill badge-info">Pend</span></a>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif
                                                  <a id="editCompanyyyy" data-toggle="modal"
                                                      data-id="{{ $clientdebitdata->id }}" data-target="#exampleModal112"
                                                      title="Send Reminder">
                                                      <span class="typcn typcn-bell"
                                                          style="font-size: large;color: green;"></span>
                                                  </a>
                                              </td> --}}
                                              <td>
                                                  @if ($clientdebitdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientdebitdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientdebitdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif

                                                  {{-- bellicon --}}
                                                  @if ($clientdebitdata->status == 3)
                                                      <a class="editCompanyyyy" data-toggle="modal"
                                                          data-id="{{ $clientdebitdata->id }}"
                                                          data-target="#exampleModal1121{{ $loop->index }}"
                                                          title="Send Reminder">
                                                          <span class="typcn typcn-bell"
                                                              style="font-size: large;color: green;"></span>
                                                      </a>
                                                  @endif
                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1121{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
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
                                                                  <a href="{{ url('pending/mail', $clientdebitdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>{{ $clientdebitdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientdebitdata->debtorconfirm->amount ?? '' }}</td>
                                              <td> <a target="blank"
                                                      href="{{ optional($clientdebitdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientdebitdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientdebitdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>

                      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                          <div class="table-responsive">
                              <br>
                              <div class="card-head" style="width:930px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg" class="btn btn-info-soft btn-sm">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="float:right;margin-top: -17px;">Add <a data-toggle="modal"
                                          data-target="#exampleModal1" class="btn btn-info-soft btn-sm"><i
                                              class="fa fa-plus"></i></a></b>
                              </div>
                              <hr>
                              <table id="example" class="table display table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>amount</th>
                                          <th>year</th>
                                          <th>Date</th>
                                          <th>Address</th>
                                          <th>Email</th>
                                          <th>Email Status</th>
                                          <th>Status</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($clientcredit as $clientcreditdata)
                                          <tr>
                                              <td>{{ $clientcreditdata->name }}</td>
                                              <td>{{ $clientcreditdata->amount }}</td>
                                              <td>{{ $clientcreditdata->year }}</td>
                                              @if ($clientcreditdata->date != null)
                                                  <td>{{ date('F d,Y', strtotime($clientcreditdata->date)) }}</td>
                                              @else
                                                  <td></td>
                                              @endif
                                              <td>{{ $clientcreditdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientcreditdata->email }}">{{ $clientcreditdata->email }}</a>
                                              </td>
                                              <td>
                                                  @if ($clientcreditdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientcreditdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientcreditdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientcreditdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientcreditdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif


                                                  {{-- bellicon --}}
                                                  @if ($clientcreditdata->status == 3)
                                                      <a class="editCompanyyyy" data-toggle="modal"
                                                          data-id="{{ $clientcreditdata->id }}"
                                                          data-target="#exampleModal1122{{ $loop->index }}"
                                                          title="Send Reminder">
                                                          <span class="typcn typcn-bell"
                                                              style="font-size: large;color: green;"></span>
                                                      </a>
                                                  @endif

                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1122{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
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
                                                                  <a href="{{ url('pending/mail', $clientcreditdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>{{ $clientcreditdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientcreditdata->debtorconfirm->amount ?? '' }}</td>


                                              <td> <a target="blank"
                                                      href="{{ optional($clientcreditdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientcreditdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientcreditdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                          <div class="table-responsive">
                              <br>
                              <div class="card-head" style="width:930px;height: 10px;">
                                  <b style="float:left;margin-top: -17px;"> <a data-toggle="modal"
                                          data-target=".exampleModal155-modal-lg" class="btn btn-info-soft btn-sm">Send <i
                                              class="fas fa-envelope"></i></a></b>

                                  <b style="float:right;margin-top: -17px;">Add <a data-toggle="modal"
                                          data-target="#exampleModal1" class="btn btn-info-soft btn-sm"><i
                                              class="fa fa-plus"></i></a></b>
                              </div>
                              <hr>
                              <table class="table display table-bordered table-striped table-hover basic">
                                  <thead>
                                      <tr>
                                          <th>Name</th>
                                          <th>amount</th>
                                          <th>year</th>
                                          <th>Address</th>
                                          <th>Email</th>
                                          <th>Email Status</th>
                                          <th>Status</th>
                                          <th>Remark</th>
                                          <th>Amount</th>
                                          <th>Attachment</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                      @foreach ($clientbank as $clientbankdata)
                                          {{-- @php
                                              dd($clientbankdata->id);
                                          @endphp --}}
                                          <tr>
                                              <td>{{ $clientbankdata->name }}</td>
                                              <td>{{ $clientbankdata->amount }}</td>
                                              <td>{{ $clientbankdata->year }}</td>
                                              <td>{{ $clientbankdata->address }}</td>
                                              <td><a
                                                      href="mail:={{ $clientbankdata->email }}">{{ $clientbankdata->email }}</a>
                                              </td>
                                              <td>
                                                  @if ($clientbankdata->mailstatus == 1)
                                                      <span>Sent</span>
                                                  @elseif($clientbankdata->mailstatus == 2)
                                                      <span>Failed</span>
                                                  @else
                                                      <span>Not Sent</span>
                                                  @endif
                                              </td>
                                              <td>
                                                  @if ($clientbankdata->status == 0)
                                                      <span class="badge badge-pill badge-danger">Not Confirmed</span>
                                                  @elseif($clientbankdata->status == 2)
                                                      <span class="badge badge-pill badge-Warning">Draft</span>
                                                  @elseif($clientbankdata->status == 3)
                                                      <span class="badge badge-pill badge-info">Pending</span>
                                                  @else
                                                      <span class="badge badge-pill badge-success">Confirmed</span>
                                                  @endif

                                                  {{-- bellicon --}}
                                                  @if ($clientbankdata->status == 3)
                                                      <a class="editCompanyyyy" data-toggle="modal"
                                                          data-id="{{ $clientbankdata->id }}"
                                                          data-target="#exampleModal1123{{ $loop->index }}"
                                                          title="Send Reminder">
                                                          <span class="typcn typcn-bell"
                                                              style="font-size: large;color: green;"></span>
                                                      </a>
                                                  @endif

                                                  {{-- asa request reminder modal --}}
                                                  <div class="modal fade" id="exampleModal1123{{ $loop->index }}"
                                                      tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
                                                      aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <div class="modal-header" style="background: #218838;">
                                                                  <h5 style="color:white;"
                                                                      class="modal-title font-weight-600"
                                                                      id="exampleModalLabel4">Send
                                                                      Reminder
                                                                      list</h5>
                                                                  <div>
                                                                      <ul>
                                                                          @foreach ($errors->all() as $e)
                                                                              <li style="color:red;">{{ $e }}
                                                                              </li>
                                                                          @endforeach
                                                                      </ul>
                                                                  </div>
                                                                  <button type="button" class="close"
                                                                      data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                              </div>
                                                              <div class="modal-body">
                                                                  <div class="table-responsive">
                                                                      <table id="reminderTable"
                                                                          class="table display table-bordered table-striped table-hover">
                                                                          <thead>
                                                                              <tr style="background-color: #b6acae;">
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
                                                                  <a href="{{ url('pending/mail', $clientbankdata->id) }}"
                                                                      class="btn btn-success sendReminderBtn"
                                                                      onclick="return confirm('Are you sure you want to send notification?');">
                                                                      Send
                                                                      Notification</a>
                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>


                                              </td>
                                              <td>{{ $clientbankdata->debtorconfirm->remark ?? '' }}</td>
                                              <td>{{ $clientbankdata->debtorconfirm->amount ?? '' }}</td>


                                              <td> <a target="blank"
                                                      href="{{ optional($clientbankdata->debtorconfirm)->file
                                                          ? url('/backEnd/image/confirmationfile/' . $clientbankdata->debtorconfirm->file)
                                                          : '' }}">
                                                      {{ optional($clientbankdata->debtorconfirm)->file ?? '' }}
                                                  </a></td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </div>

      <div class="modal modal-success fade exampleModal155-modal-lg" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel3" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('confirmation/mail') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header">
                          <h5 class="modal-title font-weight-600" aria-labelledby="exampleModalLabel3">Send Mail</h5>
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

                          <div class="row row-sm">
                              {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                              <div class="col-sm-8">
                                  <label class="font-weight-600">Subject <span class="tx-danger">*</span></label>
                                  <input placeholder=" Enter Subject" class="form-control" name="subject"
                                      type="text">
                                  <input hidden class="form-control" value="1" name="type" type="text">
                              </div>
                              <div class="col-sm-4">
                                  <label class="font-weight-600">Confirmation Type <span
                                          class="tx-danger">*</span></label>
                                  <select name="type" id="template" class="form-control">
                                      <!--placeholder-->
                                      <option value="">Please Select Type</option>
                                      <option value="1">Debtor</option>
                                      <option value="2">Creditor</option>
                                      <option value="3">Bank</option>
                                  </select>
                                  <input id="name" hidden class="form-control" name="clientid" type="text"
                                      value="{{ $clientList->assignmentgenerate_id }}">
                              </div>

                          </div>
                          <br>

                          <div class="row row-sm">
                              {{-- <div class="col-sm-6">
                        <input id="contactemail" placeholder=" Enter From Email" class="form-control" name="fromemail"
                            type="text">
                      
                    </div> --}}
                              <div class="col-sm-12">
                                  <label class="font-weight-600">Select CC Mail</label>
                                  <select class="form-control basic-multiple" multiple="multiple" name="teammember_id[]">

                                      <option>Please Select Cc Mail</option>
                                      @foreach ($teammember as $teammemberData)
                                          <option value="{{ $teammemberData->id }}"
                                              @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                                              {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} )
                                          </option>
                                      @endforeach
                                  </select>

                              </div>
                          </div>
                          <br>
                          <div class="row row-sm">
                              <div class="col-sm-12">
                                  <label class="font-weight-600">Description <span class="tx-danger">*</span></label>
                                  <textarea rows="6" name="description" class="centered form-control" id="summernote"
                                      placeholder="Enter Description"></textarea>
                                  <span>please merge dynamic field [name],[amount],[year],[date],[address]</span>
                              </div>

                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-info" onclick="saveForm()">Save Draft</button>
                          <button type="button" class="btn btn-primary" onclick="saveForm2()">Save</button>
                          <button type="submit" class="btn btn-success"
                              onclick="return confirm('Are you sure?');">Send</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <form id="detailsForm" method="post" action="{{ url('debtor/excel') }}"
                      enctype="multipart/form-data">
                      @csrf
                      <div class="modal-header" style="background: #37A000">
                          <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel
                          </h5>
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
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">Type:</label>
                              <div class="col-sm-9">
                                  <select name="type" id="exampleFormControlSelect1" class="form-control">
                                      <!--placeholder-->
                                      <option value="">Please Select One</option>
                                      <option value="1">Debtor</option>
                                      <option value="2">Creditor</option>
                                      <option value="3">Bank</option>
                                  </select>
                              </div>

                          </div>
                          <div class="details-form-field form-group row">
                              <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                              <div class="col-sm-9">
                                  <input id="name" class="form-control" name="file" type="file">
                                  <input id="name" hidden class="form-control" name="clientid" type="text"
                                      value="{{ $clientList->assignmentgenerate_id }}">
                              </div>

                          </div>

                          <div class="details-form-field form-group row">
                              <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                              <div class="col-sm-9">
                                  <a href="{{ url('backEnd/debtors.xlsx') }}" class="btn btn-success btn">Download<i
                                          class="fas fa-file-excel" style="margin-left: 3px;font-size: 20px;"></i></a>

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
              $('#template').on('change', function() {
                  var template_id = $(this).val();

                  $.ajax({
                      type: "GET",
                      url: "{{ url('confirmationtem') }}",
                      data: "template_id=" + template_id,
                      success: function(response) {
                          var desc = response.description;

                          // Check if "desc" exists in the response and is not empty before setting
                          if (desc && desc.trim() !== "") {
                              $('#summernote').summernote('code',
                                  desc); // Update Summernote content
                          }
                      },
                      error: function() {

                      },
                  });
                  $('#subcentre_id').html('');
              });
          });
      </script>

      {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
      <script>
          $(document).ready(function() {
              $('.editCompanyyyy').click(function(e) {
                  // Prevent default anchor behavior
                  e.preventDefault();
                  // Get the data-id attribute value
                  var id = $(this).data('id');
                  //   alert(id);
                  $.ajax({
                      type: 'GET',
                      url: '/balanceconfirmationreminderlist',
                      data: {
                          id: id,
                      },
                      success: function(response) {

                          var balanceconfirmationreminderlist = response
                              .balanceconfirmationreminderlist;

                          $('#reminderTable tbody').empty();
                          $.each(balanceconfirmationreminderlist, function(index, reminder) {
                              // Append a new row to the table
                              $('#reminderTable tbody').append('<tr>' +
                                  '<td>' + reminder.remindercount + '</td>' +
                                  '<td>' + reminder.reminderdatecount + '</td>' +
                                  '</tr>');
                          });
                      },
                      error: function(error) {
                          console.error('Error fetching data:', error);
                      }
                  });
              });
          });
      </script>
      <script>
          function saveForm() {
              document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
          }

          function saveForm2() {
              var type = $('#template').val();
              //   var clientid = $("[name='clientid']").val();
              if (type == '') {
                  alert('Please Select Confirmation Type');
              } else {
                  var url = "{{ url('/mailsave') }}";
                  // Append type and clientid to the URL
                  //   url += "?type=" + type + "&clientid=" + clientid;
                  url += "?type=" + type;
                  window.location.href = url;

              }
          }
      </script>
  @endsection

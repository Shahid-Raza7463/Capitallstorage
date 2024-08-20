  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

 <style>
      tr td:first-child a.ui-state-default {
          /* background-color: rgb(234, 0, 0) !important; */
          background-image: linear-gradient(to right, #34b4e5, rgba(255, 0, 0, 1));
          color: white !important;
      }

      tr th:first-child span {
          color: rgb(249, 5, 5) !important;
      }
  </style>

  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <div class="body-content">
          <div class="row">
              <div class="col-md-12 col-lg-12">
                  <div class="card mb-4">
                      <form method="post" action="{{ route('timesheet.store') }}" enctype="multipart/form-data"
                          id="timesheet-form">
                          @csrf
                          <div class="card-header" style="background:#37A000">
                              <div class="d-flex justify-content-between align-items-center">
                                  <div class="col-md-6">
                                      <h6 style="color: white" class="fs-17 font-weight-600 mb-0">Add Timesheet</h6>
                                  </div>
                                  <div class="col-md-1">
                                  </div>
                                  <div class="col-md-5">
                                      <p style="float: right;color: white"><b>Select Date : </b> <input type="text"
                                              id="datepickers" name="date" value="{{ date('d-m-Y') }}" readonly></p>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body">

                              @component('backEnd.components.alert')
                              @endcomponent
                              {{-- <div style="text-align: center;"> <span style="color:red;">Please fill timesheet from
                                      11/09/2023, Monday Onwards</span></div>
                              <hr>
                              <br> --}}
                              @include('backEnd.timesheet.form')


                              <hr class="my-4">

                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      <!--/.body content-->
  @endsection
  {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      //   $(document).ready(function() {
      $("#timesheet-form").submit(function(e) {
          // Check if the "Client Name" dropdown is selected
          if ($("#client1").val() != "Select Client" && $("#client1").val() != "") {
              // If a client is selected, make the following fields required
              $("#assignment1").prop("required", true);
              $("#partner1").prop("required", true);
              $("#assignment2").prop("required", true);
          }
      });
      //   });
  </script> --}}


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
      $(document).ready(function() {
          // Function to handle change event for client select
       
          function handleClientChange(clientId) {
              $('#' + clientId).on('change', function() {
                  var cid = $(this).val();
                  var datepickers = $('#datepickers').val();
                  var clientNumber = parseInt(clientId.replace('client', ''));

                  if (cid == 33) {
                      $.ajax({
                          type: "get",
                          url: "{{ url('holidaysselect') }}",
                          data: {
                              cid: cid,
                              datepickers: datepickers
                          },
                          success: function(response) {
                              var location = 'N/A';
                              var time = 0;
                              var holidayName = response.holidayName;
                              var saturday = response.saturday;
                              if (holidayName == 'null') {
                                  var workitem = saturday;
                              } else if (saturday == 'null') {
                                  var workitem = holidayName;
                              } else {
                                  var workitem = holidayName;
                              }

                              if (!isNaN(clientNumber)) {
                                  var assignmentSelect = $('.assignmentvalue' + clientNumber);
                                  assignmentSelect.empty();
                                  assignmentSelect.append($('<option>', {
                                      value: response.assignmentgenerate_id,
                                      text: response.assignment_name + ' (' +
                                          response
                                          .assignmentname + '/' + response
                                          .assignmentgenerate_id + ')'
                                  }));

                                  var assignmentSelect = $('.partnervalue' + clientNumber);
                                  assignmentSelect.empty();
                                  assignmentSelect.append($('<option>', {
                                      value: response.team_memberid,
                                      text: response.team_member
                                  }));

                                  $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                      'readonly', true);
                                  $('.locationvalue' + clientNumber).val(location).prop(
                                      'readonly', true);
                                  $('#totalhours').val(time);
                                  $('#hour' + (clientNumber + 1)).prop('readonly', true);
                              } else {

                                  var assignmentSelect = $('.assignmentvalue');
                                  assignmentSelect.empty();
                                  assignmentSelect.append($('<option>', {
                                      value: response.assignmentgenerate_id,
                                      text: response.assignment_name + ' (' +
                                          response
                                          .assignmentname + '/' + response
                                          .assignmentgenerate_id + ')'
                                  }));

                                  var assignmentSelect = $('.partnervalue');
                                  assignmentSelect.empty();
                                  assignmentSelect.append($('<option>', {
                                      value: response.team_memberid,
                                      text: response.team_member
                                  }));


                                  $('.workitemnvalue').val(workitem).prop('readonly', true);
                                  $('.locationvalue').val(location).prop('readonly', true);
                                  $('#totalhours').val(time);
                                  $("#hour1").prop("readonly", true);
                              }
                          },
                          error: function() {
                              // Handle error if AJAX request fails
                          }
                      });
                  } else {
                      $.ajax({
                          type: "get",
                          url: "{{ url('timesheet/create') }}",
                          data: {
                              cid: cid,
                              datepickers: datepickers
                          },
                          success: function(res) {
                              // clear previous data 
                              if (!isNaN(clientNumber)) {
                                  $('.assignmentvalue' + clientNumber).empty();
                                  $('.partnervalue' + clientNumber).empty();
                                  $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                                      false);
                                  $('.locationvalue' + clientNumber).val('').prop('readonly',
                                      false);
                                  $("#hour" + (clientNumber + 1)).prop("readonly", false);

                              } else {
                                  $('.assignmentvalue').empty();
                                  $('.partnervalue').empty();
                                  $('.workitemnvalue').val('').prop('readonly', false);
                                  $('.locationvalue').val('').prop('readonly', false);
                                  $("#hour1").prop("readonly", false);
                              }

                              $('#' + clientId.replace('client', 'assignment')).html(res);

                          },
                          error: function() {
                              // Handle error if AJAX request fails
                          },
                      });
                  }
              });
          }


          // Function to handle change event for assignment select
          function handleAssignmentChange(assignmentId) {
              $('#' + assignmentId).on('change', function() {
                  var assignment = $(this).val();

                  $.ajax({
                      type: "get",
                      url: "{{ url('timesheet/create') }}",
                      data: "assignment=" + assignment,
                      success: function(res) {
                          $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                      },
                      error: function() {},
                  });
              });
          }

          // Dynamically add client fields
          var maxField = 4;
          var addButton = $('.add_button');
          var wrapper = $('.field_wrapper');
          var x = 1;
          var h = 2;

          $(addButton).click(function() {
              if (x < maxField) {
                  x++;
                  h++;
                  var fieldHTML = `<div class="row row-sm">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name</label>
                    <select class="language form-control refresh" name="client_id[]" id="client${x}">
                        <option value="">Select Client</option>
                        @foreach ($client as $clientData)
                            <option value="{{ $clientData->id }}">
                                {{ $clientData->client_name }} ({{ $clientData->client_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name</label>
                    <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner</label>
                    <select class="language form-control refreshoption" id="partner${x}" name="partner[]">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item</label>
                    <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh workitemnvalue${x}" rows="2"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location</label>
                    <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh locationvalue${x}">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour</label>
                    <input type="text" class="form-control refresh" id="hour${h}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                    <span style="font-size: 10px;margin-left: 10px;"></span>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                </div>
            </div>
        </div>`;

                  $(wrapper).append(fieldHTML);

                  var clientId = 'client' + x;
                  var assignmentId = 'assignment' + x;

                  handleClientChange(clientId);
                  handleAssignmentChange(assignmentId);
              }
          });

          handleClientChange('client');
          handleClientChange('client1');
          handleAssignmentChange('assignment');
          handleAssignmentChange('assignment1');

          //Once remove button is clicked
          $(wrapper).on('click', '.remove_button', function(e) {
              e.preventDefault();
              $(this).closest('.row-sm').remove();
              x--;
          });
      });

      function calculateTotal() {
          var totalSum = 0;
          $('input[name^="hour"]').each(function() {
              totalSum += parseInt($(this).val()) || 0;
          });

          document.getElementById("totalhours").value = totalSum;
      }
  </script>
 

  {{-- select box validation for timesheet create --}}
  <script>
      $(function() {

          $('#partner1').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem1').prop('required', true);
              $('.location1').prop('required', true);
              $('.hour1').prop('required', true);
          });

          $('#partner2').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem2').prop('required', true);
              $('.location2').prop('required', true);
              $('.hour2').prop('required', true);
          });
          $('#partner3').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem3').prop('required', true);
              $('.location3').prop('required', true);
              $('.hour3').prop('required', true);
          });
          $('#partner4').on('change', function() {
              var patnervaluenew = $(this).val();
              $('.workItem4').prop('required', true);
              $('.location4').prop('required', true);
              $('.hour4').prop('required', true);
          });
          // select client 1
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue = $('#client1').val();
              var assmentvalue = $('#assignment1').val();
              var partnervalue = $('#partner1').val();

              if (clientvalue != "" || clientvalue != "Select Client") {
                  if (assmentvalue == "Select Assignment" || assmentvalue == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment1').focus();
                  } else if (partnervalue == "Select Partner" || partnervalue == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner1').focus();
                  }
                  //    else if (partnervalue == "Select Partner" && assmentvalue == "Select Assignment") {
                  //       alert("Please select a partnervalue");
                  //       e.preventDefault();
                  //       $('#assignment1').focus();
                  //   }
              }
          });

          // select client 2
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue2 = $('#client2').val();
              var assmentvalue2 = $('#assignment2').val();
              var partnervalue2 = $('#partner2').val();

              if (clientvalue2 != "" || clientvalue2 != "Select Client") {
                  if (assmentvalue2 == "Select Assignment" || assmentvalue2 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment2').focus();
                  } else if (partnervalue2 == "Select Partner" || partnervalue2 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner2').focus();
                  }
              }
          });
          // select client 3
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue3 = $('#client3').val();
              var assmentvalue3 = $('#assignment3').val();
              var partnervalue3 = $('#partner3').val();
              4
              if (clientvalue3 != "" || clientvalue3 != "Select Client") {
                  if (assmentvalue3 == "Select Assignment" || assmentvalue3 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment3').focus();
                  } else if (partnervalue3 == "Select Partner" || partnervalue3 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner3').focus();
                  }
              }
          });
          // select client 4
          $('#timesheet-form').on('submit', function(e) {
              var clientvalue4 = $('#client4').val();
              var assmentvalue4 = $('#assignment4').val();
              var partnervalue4 = $('#partner4').val();

              if (clientvalue4 != "" || clientvalue4 != "Select Client") {
                  if (assmentvalue4 == "Select Assignment" || assmentvalue4 == "") {
                      alert("Please select a assignment");
                      e.preventDefault();
                      $('#assignment4').focus();
                  } else if (partnervalue4 == "Select Partner" || partnervalue4 == "") {
                      alert("Please select a partner");
                      e.preventDefault();
                      $('#partner4').focus();
                  }
              }
          });
          // end select client 4
      });
  </script>

 


  <script>
      $(function() {
          $('input[name="daterange"]').daterangepicker({
              opens: 'left'
          }, function(start, end, label) {
              console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                  .format('YYYY-MM-DD'));
          });
      });
  </script>

  {{-- Refresh page --}}
 <script>
      $(function() {
          $('#datepickers').on('change', function() {
              var timesheetdate = $(this).val();
              //   var datepickers = $('#datepickers').val();

              var refreshpage = $('.refresh');
              refreshpage.val('').prop("readonly", false);
              $('.refreshoption option').remove();
              //   $("#hour1,#hour2,#hour3,#hour4,#hour5").prop("readonly", false);
              $("#hour1,#hour2,#hour3,#hour4,#hour5").val(0);

              //   alert(datepickers);
              $.ajax({
                  type: "get",
                  url: "{{ url('timesheet/create') }}",
                  data: {
                      timesheetdate: timesheetdate
                  },
                  success: function(res) {
                      $('#client').html(res);
                      $('#client1').html(res);
                      $('#client2').html(res);
                      $('#client3').html(res);
                      $('#client4').html(res);
                  },
                  error: function() {},
              });
          });
      });
  </script>
  <script>
      $(function() {
          var startDate = new Date();
          $("#datepickers").datepicker({
              maxDate: startDate,
              dateFormat: 'dd-mm-yy'
          });
      });
  </script>

  <!--Page Active Scripts(used by this page)-->
  <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
  <!--Page Scripts(used by all page)-->
  <script src="{{ url('backEnd/dist/js/sidebar.js') }}"></script>

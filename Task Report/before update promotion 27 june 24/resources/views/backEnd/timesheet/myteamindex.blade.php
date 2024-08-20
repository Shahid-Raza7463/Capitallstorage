  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

  @extends('backEnd.layouts.layout') @section('backEnd_content')
      <!--Content Header (Page header)-->
      <div class="content-header row align-items-center m-0">
                   <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
              @if (Auth::user()->role_id == 11)
                  <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                      <li>
                          <a class="btn btn-info" href="{{ url('/timesheetdownload') }}">Timesheet All</a>
                      </li>
                  </ol>
              @endif
          </nav>
          <div class="col-sm-8 header-title p-0">
              <div class="media">
                  <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                  <div class="media-body">
                      <h1 class="font-weight-bold">Home</h1>
                      <small>Team Workbook List</small>
                  </div>
              </div>
          </div>
      </div>
      <!--/.Content Header (Page header)-->
      <div class="body-content">
          <div class="card mb-4">
              {{-- @php
                  dd($get_date);
              @endphp --}}



              <div class="card-body">
                  @component('backEnd.components.alert')
                  @endcomponent
                    <div class="table-responsive">
                      {{-- filtering functionality --}}
                      <div class="row row-sm">
                         

  @if (Auth::user()->role_id == 11 || (Auth::user()->role_id == 13 && Request::is('timesheet/teamlist')))
                              <div class="col-4">
                                  <div class="form-group">
                                      <label class="font-weight-600">Team Name</label>
                                      <select class="language form-control" id="category7" name="teamname">
                                          <option value="">Please Select One</option>
                                          @php

                                              $displayedValues = [];

                                          @endphp
                                          @foreach ($get_date as $jobDatas)
                                              @if (!in_array($jobDatas->staffcode, $displayedValues))
                                                  <option value="{{ $jobDatas->teamid }}">
                                                      {{ $jobDatas->team_member }}({{ $jobDatas->staffcode }})
                                                  </option>
                                                  @php
                                                      $displayedValues[] = $jobDatas->staffcode;
                                                  @endphp
                                              @endif
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          @endif


                          <div class="col-4">
                              <div class="form-group">
                                  <label class="font-weight-600">Start Date</label>
                                  <input type="date" class="form-control" id="start" name="start">

                              </div>
                          </div>
                          <div class="col-4">
                              <div class="form-group">
                                  <label class="font-weight-600">End Date</label>
                                  <input type="date" class="form-control" name="end" id="end">
                              </div>
                          </div>
                          {{-- <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Hour</label>
                                  <select class="language form-control" id="category4" name="totalhours">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobData)
                                          @if (!in_array($jobData->totaltime, $displayedValues))
                                              <option value="{{ $jobData->totaltime }}">
                                                  {{ $jobData->totaltime }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobData->totaltime;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div> --}}
                      </div>

                      <table id="examplee" class="table display table-bordered table-striped table-hover">
                          <thead>
                              <tr>
                                  <th style="width: 94.6562px;">Team Name</th>
                                  <th>Period Date ( Monday To Saturday )</th>
                                  <th>Submitted Date</th>
                                  <th>Total Timesheet Filled Day</th>
                                  <th>Total Hour</th>
                                  {{-- <th>Partner</th> --}}
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($get_date as $jobDatas)
                                  <tr>
                                      <td><a
                                              href="{{ url(
                                                  '/weeklylist?' .
                                                      'id=' .
                                                      $jobDatas->id .
                                                      '&&' .
                                                      'teamid=' .
                                                      $jobDatas->teamid .
                                                      '&&' .
                                                      'partnerid=' .
                                                      $jobDatas->partnerid .
                                                      '&&' .
                                                      'startdate=' .
                                                      $jobDatas->startdate .
                                                      '&&' .
                                                      'enddate=' .
                                                      $jobDatas->enddate,
                                              ) }}">{{ $jobDatas->team_member }}</a>
                                      </td>
                                      <td><span
                                              style="display: none;">{{ $jobDatas->created_at }}</span>{{ $jobDatas->week }}
                                      </td>
                                      <td> <span
                                              style="display: none;">{{ $jobDatas->created_at }}</span>{{ date('d-m-Y', strtotime($jobDatas->created_at)) }}
                                          {{ date('h:i A', strtotime($jobDatas->created_at)) }}</td>
                                      {{-- <td>{{ $jobDatas->totaldays }}</td> --}}
                                      @if (Auth::user()->role_id == 11)
                                          @if (isset($jobDatas->dayscount) && $jobDatas->dayscount != 0)
                                              <td>{{ $jobDatas->dayscount }}</td>
                                          @else
                                              <td>{{ $jobDatas->totaldays }}</td>
                                          @endif
                                      @else
                                          <td>{{ $jobDatas->totaldays }}</td>
                                      @endif
                                      <td>{{ $jobDatas->totaltime }}</td>
                                      {{-- <td>{{ $jobDatas->partnername }}</td> --}}
                              @endforeach
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>

      </div>
      <!--/.body content-->
  @endsection

  {{-- filter on timesheet submitted --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

  {{-- ! runnig code --}}

   <script>
      $(document).ready(function() {
          // Define a function for handling filter changes
          function handleFilterChange() {
              var search1 = $('#category1').val();
              var search4 = $('#category4').val();
              var search7 = $('#category7').val();
              var search8 = $('#start').val();
              var search9 = $('#end').val();
              //   if (search8 && !search9) {
              //       alert('please select end date');
              //   }

              $.ajax({
                  type: 'GET',
                  url: '/filter-dataadmin',
                  data: {
                      partnersearch: search1,
                      totalhours: search4,
                      teamname: search7,
                      start: search8,
                      end: search9
                  },
                  success: function(data) {
                      $('table tbody').html(""); // Clear the table body

                      if (data.length === 0) {
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>');
                      } else {
                          $.each(data, function(index, item) {
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              var formattedDate = moment(item.created_at).format(
                                  'DD-MM-YYYY');
                              var formattedTime = moment(item.created_at).format('hh:mm A');

                              @if (Auth::user()->role_id == 11)
                                  // Add the rows to the table
                                  $('table tbody').append('<tr>' +
                                      '<td><a href="' + url + '">' + item
                                      .team_member +
                                      '</a></td>' +
                                      '<td>' + item.week + '</td>' +
                                      '<td>' + formattedDate + ' ' +
                                      formattedTime +
                                      '</td>' +
                                      '<td>' + (item.dayscount != 0 ? item
                                          .dayscount :
                                          item.totaldays) + '</td>' +
                                      '<td>' + item.totaltime + '</td>' +
                                      '</tr>');
                              @else
                                  // Add the rows to the table
                                  $('table tbody').append('<tr>' +
                                      '<td><a href="' + url + '">' + item
                                      .team_member +
                                      '</a></td>' +
                                      '<td>' + item.week + '</td>' +
                                      '<td>' + formattedDate + ' ' +
                                      formattedTime +
                                      '</td>' +
                                      '<td>' + item.totaldays + '</td>' +
                                      '<td>' + item.totaltime + '</td>' +
                                      '</tr>');
                              @endif
                          });

                          $('.paging_simple_numbers').remove();
                          $('.dataTables_info').remove();
                      }
                  }
              });
          }

          // Handle change events for all filters
          $('#category1, #category4, #category7').change(handleFilterChange);
          //   $('#start, #end').change(handleFilterChange);
          $('#end').change(handleFilterChange);
      });
  </script>


  {{-- validation for comparision date and block year for 4 disit --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          var startDateInput = $('#start');
          var endDateInput = $('#end');

          function compareDates() {
              var startDate = new Date(startDateInput.val());
              var endDate = new Date(endDateInput.val());

              if (startDate > endDate) {
                  alert('End date should be greater than or equal to the Start date');
                  endDateInput.val(''); // Clear the end date input
              }
          }

          startDateInput.on('input', compareDates);
          endDateInput.on('blur', compareDates);
      });
  </script>

  {{-- validation for block 4 digit to  year --}}
  <script>
      $(document).ready(function() {
          $('#start').on('change', function() {
              var startclear = $(this);
              var startDateInput1 = startclear.val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearLength = startyear.toString().length;
              if (yearLength > 4) {
                  alert('Enter four digits for the year');
                  startclear.val('');
              }
          });
          $('#end').on('change', function() {
              var endclearvalue = $(this);
              var endDateInput1 = endclearvalue.val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var endyearLength = endyear.toString().length;
              if (endyearLength > 4) {
                  alert('Enter four digits for the year');
                  endclear.val('');
              }
          });
      });
  </script>
  <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              "order": [
                  //   [2, "desc"]
              ],
              searching: false,
              columnDefs: [{
                  targets: [0, 3, 4],
                  orderable: false
              }],
              buttons: []
          });
      });
  </script> 
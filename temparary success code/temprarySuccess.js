//* 
//* 

//** leave period start date wise
// $('#startperiod1').change(function() {
//     var startperiod1 = $(this).val();
//     var endperiod1 = $('#endperiod1').val();
//     // var end1 = $('#end1').val();
//     // var status1 = $('#status1').val();
//     // var employee1 = $('#employee1').val();
//     // var leave1 = $('#leave1').val();
//     // alert(startperiod1);
//     $.ajax({
//         type: 'GET',
//         url: '/filtering-applyleve',
//         data: {
//             startperiod: startperiod1,
//             endperiod: endperiod1,
//             // end: end1,
//             // start: start1,
//             // status: status1,
//             // employee: employee1,
//             // leave: leave1
//         },
//         success: function(data) {
//             // Replace the table body with the filtered data
//             $('table tbody').html("");
//             // Clear the table body
//             if (data.length === 0) {
//                 // If no data is found, display a "No data found" message
//                 $('table tbody').append(
//                     '<tr><td colspan="8" class="text-center">No data found</td></tr>'
//                 );
//             } else {
//                 $.each(data, function(index, item) {

//                     // Create the URL dynamically
//                     var url = '/applyleave/' + item.id;

//                     var createdAt = new Date(item.created_at)
//                         .toLocaleDateString('en-GB', {
//                             day: '2-digit',
//                             month: '2-digit',
//                             year: 'numeric'
//                         });
//                     var fromDate = new Date(item.from)
//                         .toLocaleDateString('en-GB', {
//                             day: '2-digit',
//                             month: '2-digit',
//                             year: 'numeric'
//                         });
//                     var toDate = new Date(item.to)
//                         .toLocaleDateString('en-GB', {
//                             day: '2-digit',
//                             month: '2-digit',
//                             year: 'numeric'
//                         });

//                     var holidays = Math.floor((new Date(item.to) -
//                         new Date(item.from)) / (24 * 60 * 60 *
//                         1000)) + 1;

//                     // Add the rows to the table
//                     $('table tbody').append('<tr>' +
//                         '<td><a href="' + url + '">' + item
//                         .team_member +
//                         '</a></td>' +
//                         '<td>' + item.name + '</td>' +
//                         '<td>' + item.approvernames + '</td>' +
//                         '<td>' + item.reasonleave + '</td>' +
//                         '<td>' + fromDate + ' to ' + toDate +
//                         '</td>' +
//                         '<td>' + holidays + '</td>' +
//                         '<td>' + createdAt + '</td>' +
//                         '<td>' + getStatusBadge(item.status) + '</td>' +
//                         '</tr>');
//                 });

//                 // Function to handle the status badge
//                 function getStatusBadge(status) {
//                     if (status == 0) {
//                         return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
//                     } else if (status == 1) {
//                         return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
//                     } else if (status == 2) {
//                         return '<span class="badge badge-danger">Rejected</span>';
//                     } else {
//                         return '';
//                     }
//                 }

//                 //   remove pagination after filter
//                 $('.paging_simple_numbers').remove();
//                 $('.dataTables_info').remove();
//             }
//         }
//     });
// }); 
//! old code status wise
//  $('#status1').change(function() {
//      var status1 = $(this).val();
//      var employee1 = $('#employee1').val();
//      var leave1 = $('#leave1').val();
//      $.ajax({
//          type: 'GET',
//          url: '/filtering-applyleve',
//          data: {
//              status: status1,
//              employee: employee1,
//              leave: leave1
//          },
//          success: function(data) {
//              // Replace the table body with the filtered data
//              $('table tbody').html("");
//              // Clear the table body
//              if (data.length === 0) {
//                  // If no data is found, display a "No data found" message
//                  $('table tbody').append(
//                      '<tr><td colspan="8" class="text-center">No data found</td></tr>'
//                  );
//              } else {
//                  $.each(data, function(index, item) {

//                      // Create the URL dynamically
//                      var url = '/applyleave/' + item.id;

//                      var createdAt = new Date(item.created_at)
//                          .toLocaleDateString('en-GB', {
//                              day: '2-digit',
//                              month: '2-digit',
//                              year: 'numeric'
//                          });
//                      var fromDate = new Date(item.from)
//                          .toLocaleDateString('en-GB', {
//                              day: '2-digit',
//                              month: '2-digit',
//                              year: 'numeric'
//                          });
//                      var toDate = new Date(item.to)
//                          .toLocaleDateString('en-GB', {
//                              day: '2-digit',
//                              month: '2-digit',
//                              year: 'numeric'
//                          });

//                      var holidays = Math.floor((new Date(item.to) -
//                          new Date(item.from)) / (24 * 60 * 60 *
//                          1000)) + 1;

//                      // Add the rows to the table
//                      $('table tbody').append('<tr>' +
//                          '<td><a href="' + url + '">' + item
//                          .team_member +
//                          '</a></td>' +
//                          '<td>' + createdAt + '</td>' +
//                          '<td>' + getStatusBadge(item.status) + '</td>' +
//                          '<td>' + item.name + '</td>' +
//                          '<td>' + fromDate + ' to ' + toDate +
//                          '</td>' +
//                          '<td>' + holidays + '</td>' +
//                          '<td>' + item.approvernames + '</td>' +
//                          '<td style="width: 7rem;text-wrap: wrap;">' +
//                          item.reasonleave + '</td>' +
//                          '</tr>');
//                  });



//                  // Function to handle the status badge
//                  function getStatusBadge(status) {
//                      if (status == 0) {
//                          return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
//                      } else if (status == 1) {
//                          return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
//                      } else if (status == 2) {
//                          return '<span class="badge badge-danger">Rejected</span>';
//                      } else {
//                          return '';
//                      }
//                  }

//                  //   remove pagination after filter
//                  $('.paging_simple_numbers').remove();
//                  $('.dataTables_info').remove();
//              }
//          }
//      });
//  });


//   //** status wise
//   $('#status1').change(function() {
//       var status1 = $(this).val();
//       var employee1 = $('#employee1').val();
//       var leave1 = $('#leave1').val();
//       $.ajax({

//           type: 'GET',
//           url: '/filtering-applyleve',
//           data: {
//               status: status1,
//               employee: employee1,
//               leave: leave1
//           },
//           success: function(data) {
//               // Replace the table body with the filtered data
//               $('table tbody').html("");
//               // Clear the table body
//               if (data.length === 0) {
//                   // If no data is found, display a "No data found" message
//                   $('table tbody').append(
//                       '<tr><td colspan="8" class="text-center">No data found</td></tr>'
//                   );
//               } else {
//                   $.each(data, function(index, item) {

//                       // Create the URL dynamically
//                       var url = '/applyleave/' + item.id;

//                       var createdAt = new Date(item.created_at)
//                           .toLocaleDateString('en-GB', {
//                               day: '2-digit',
//                               month: '2-digit',
//                               year: 'numeric'
//                           });
//                       var fromDate = new Date(item.from)
//                           .toLocaleDateString('en-GB', {
//                               day: '2-digit',
//                               month: '2-digit',
//                               year: 'numeric'
//                           });
//                       var toDate = new Date(item.to)
//                           .toLocaleDateString('en-GB', {
//                               day: '2-digit',
//                               month: '2-digit',
//                               year: 'numeric'
//                           });

//                       var holidays = Math.floor((new Date(item.to) -
//                           new Date(item.from)) / (24 * 60 * 60 *
//                           1000)) + 1;

//                       // Add the rows to the table
//                       $('table tbody').append('<tr>' +
//                           '<td><a href="' + url + '">' + item
//                           .team_member +
//                           '</a></td>' +
//                           '<td>' + createdAt + '</td>' +
//                           '<td>' + getStatusBadge(item.status) + '</td>' +
//                           '<td>' + item.name + '</td>' +
//                           '<td>' + fromDate + ' to ' + toDate +
//                           '</td>' +
//                           '<td>' + holidays + '</td>' +
//                           '<td>' + item.approvernames + '</td>' +
//                           '<td style="width: 7rem;text-wrap: wrap;">' +
//                           item.reasonleave + '</td>' +
//                           '</tr>');
//                   });



//                   // Function to handle the status badge
//                   function getStatusBadge(status) {
//                       if (status == 0) {
//                           return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
//                       } else if (status == 1) {
//                           return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
//                       } else if (status == 2) {
//                           return '<span class="badge badge-danger">Rejected</span>';
//                       } else {
//                           return '';
//                       }
//                   }

//                   //   remove pagination after filter
//                   $('.paging_simple_numbers').remove();
//                   $('.dataTables_info').remove();

//                   // Check if data is available
//                   if (data.length > 0) {
//                       // Function to generate and download Excel file
//                       function exportToExcel() {
//                           const ws = XLSX.utils.json_to_sheet(data);
//                           const wb = XLSX.utils.book_new();
//                           XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
//                           const excelBuffer = XLSX.write(wb, {
//                               bookType: "xlsx",
//                               type: "array"
//                           });
//                           const dataBlob = new Blob([excelBuffer], {
//                               type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
//                           });
//                           saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
//                       }

//                       // Call the function to export to Excel
//                       exportToExcel();
//                   }
//               }
//           }
//       });
//   });


//*  // exam leave request 2
// exam leave request related only after that above update fncn remove commentout 
public function examleaverequest(Request $request, $id) {
  filterDataAdmin
  allteamsubmitted
  // dd($request);
  // dd($id);

  // maping double date ************
  $groupedData = $get_datess -> groupBy(function ($item) {
    return $item -> team_member. '|'.$item -> week;
  }) -> map(function ($group) {
    $firstItem = $group -> first();

    return (object)[
      'id' => $firstItem -> id,
        'teamid' => $firstItem -> teamid,
          'week' => $firstItem -> week,
            'totaldays' => $group -> sum('totaldays'),
              'totaltime' => $group -> sum('totaltime'),
                'startdate' => $firstItem -> startdate,
                  'enddate' => $firstItem -> enddate,
                    'partnername' => $firstItem -> partnername,
                      'created_at' => $firstItem -> created_at,
                        'team_member' => $firstItem -> team_member,
                          'partnerid' => $firstItem -> partnerid,
  ];
  });

  $get_date = collect($groupedData -> values());


  try {

    if ($request -> status == 1) {
      $team = DB:: table('leaverequest')
        -> leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
        -> where('leaverequest.id', $id)
        -> select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
        -> first();


      // examrequestId
      if ($team -> name == 'Exam Leave') {

        $from = Carbon:: createFromFormat('Y-m-d', $team -> from);
        //2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
        $to = Carbon:: createFromFormat('Y-m-d', $team -> to ?? '');
        // 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
        $camefromexam = Carbon:: createFromFormat('Y-m-d', $team -> date);
        // dd($camefromexam);
        // $nowrequestdays = $to->diffInDays($camefromexam) + 1;
        // remove days from database 
        $removedays = $to -> diffInDays($camefromexam) + 1;
        // dd($removedays);
        // my total leave now after coming
        $nowtotalleave = $from -> diffInDays($camefromexam);
        // 5 days
        // dd($nowtotalleave);
        // for serching from data base 
        $finddatafromleaverequest = $to -> diffInDays($from) + 1;
        // dd($finddatafromleaverequest);
        // 9
        // dd($finddatafromleaverequest);

        // dd($requestdays);
        // $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)
        //   ->count();
        // //0
        // $totalrqstday = $nowrequestdays - $holidaycount;
        // 9
        // dd($holidaycount);
        // dd($totalrqstday);

        DB:: table('leaverequest')
          -> where('id', $team -> examrequestId)
          -> update([
            'status' => 1,
          ]);

        DB:: table('leaveapprove')
          -> where('teammemberid', $team -> createdby)
          -> where('totaldays', $finddatafromleaverequest)
          -> latest()
          -> update([
            'totaldays' => $nowtotalleave,
            'updated_at' => now(),
          ]);
        // dd($finddatafromleaverequest);

        // dd($team->from);
        // "2023-12-16"
        // dd($team->date);
        // "2023-12-20"
        // dd($team->to);
        // "2023-12-24"
        //! working one delete ek baar me
        // // $period = CarbonPeriod::create($team->date, $team->to);
        // $period = CarbonPeriod::create('2023-12-21', $team->to);
        // // dd($period);
        // $datess = [];
        // foreach ($period as $date) {
        //   $datess[] = $date->format('Y-m-d');
        //   // dd($datess);
        //   $deletedIds = DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->pluck('id');
        //   // dd($deletedIds);

        //   DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->delete();

        //   $a = DB::table('timesheetusers')
        //     ->whereIn('timesheetid', $deletedIds)
        //     ->delete();
        // }
        // dd($datess);
        // dd($deletedIds);

        $period = CarbonPeriod:: create($team -> date, $team -> to);

        $datess = [];
        foreach($period as $date) {
          $datess[] = $date -> format('Y-m-d');

          $deletedIds = DB:: table('timesheets')
            -> where('created_by', $team -> createdby)
            -> whereIn('date', $datess)
            -> pluck('id');

          DB:: table('timesheets')
            -> where('created_by', $team -> createdby)
            -> whereIn('date', $datess)
            -> delete ();

          $a = DB:: table('timesheetusers')
            -> whereIn('timesheetid', $deletedIds)
            -> delete ();
        }

        // dd($datess);


        // $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)->select('startdate')->get();

        // if (count($getholidays) != 0) {
        //   foreach ($getholidays as $date) {
        //     $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        //   }
        // } else {
        //   $hdatess[] = 0;
        // }

        // dd($hdatess);
        $el_leave = $datess;
        // 0 => "2023-09-16"
        // 1 => "2023-09-17"
        // 2 => "2023-09-18"
        // $exam_leave_total = count(array_diff($datess, $hdatess));
        // 62


        // $lstatus = "EL/A";
        // $lstatus = "Null";
        // $lstatus = "";
        $lstatus = null;

        foreach($el_leave as $cl_leave) {
          // date get one by one 

          $cl_leave_day = date('d', strtotime($cl_leave));
          // "16"



          $cl_leave_month = date('F', strtotime($cl_leave));

          // September
          // dd($cl_leave_month);
          // dd($cl_leave_day);
          // 16
          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave. ' +1 month'));
          }
          // dd('hi1', $team->createdby);
          // 802
          $attendances = DB:: table('attendances') -> where('employee_name', $team -> createdby)
            -> where('month', $cl_leave_month) -> first();
          // September
          // dd($attendances);
          //  dd($value->created_by);

          // dd('hi2', $attendances);
          // dd($cl_leave_day);
          // 16
          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }
          // dd('pa', $column);
          // sixteen
          // dd('pa', $lstatus);
          // EL/A
          if (!empty($column)) {
            // store EL/A sexteen to 25 tak 
            DB:: table('attendances')
              -> where('employee_name', $team -> createdby)
              -> where('month', $cl_leave_month)
              -> whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              -> whereRaw("{$column} != 'LWP'")
              -> update([
                $column => $lstatus,
              ]);
          }
          // if (!empty($column)) {
          //   // store EL/A sexteen to 25 tak 
          //   DB::table('attendances')
          //     ->where('employee_name', $team->createdby)
          //     ->where('month', $cl_leave_month)
          //     ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
          //     ->whereRaw("{$column} != 'LWP'")
          //     ->delete();
          // }
        }
      }
      $applyleaveteam = DB:: table('leaverequest')
        -> leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
        -> where('leaverequest.id', $id)
        -> select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
        -> get();

      if ($applyleaveteam != null) {
        foreach($applyleaveteam as $applyleaveteammail) {
          $data = array(
            'emailid' => $applyleaveteammail -> emailid,
            'team_member' => $team -> team_member,
            'from' => $team -> from,
            'to' => $team -> to,
          );

          Mail:: send('emails.applyleaveteam', $data, function ($msg) use($data) {
            $msg-> to($data['emailid']);
          $msg -> subject('VSA Leave Approved');
        });
      }
    }
    $data = array(
      'emailid' => $team -> emailid,
      'id' => $id,
      'from' => $team -> from,
      'to' => $team -> to,
    );

    Mail:: send('emails.duringexamleavestatus', $data, function ($msg) use($data) {
      $msg-> to($data['emailid']);
    $msg -> subject('VSA Exam Leave request Approved');
  });
}


if ($request -> status == 2) {
  $team = DB:: table('leaverequest')
    -> leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
    -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
    -> where('leaverequest.id', $id)
    -> select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
    -> first();

  DB:: table('leaverequest')
    -> where('id', $team -> examrequestId)
    -> update([
      'status' => 2,
    ]);

  $data = array(
    'emailid' => $team -> emailid,
    'id' => $id,
    'from' => $team -> from,
    'to' => $team -> to,
  );

  Mail:: send('emails.duringexamleavereject', $data, function ($msg) use($data) {
    $msg-> to($data['emailid']);
  // $msg->cc('priyankasharma@kgsomani.com');
  $msg -> subject('VSA Exam Leave Request Reject');
});
    }

$output = array('msg' => 'Updated Successfully');
return redirect('examleaverequestlist') ->with ('success', $output);
  } catch (Exception $e) {
  DB:: rollBack();
  Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
  report($e);
  $output = array('msg' => $e -> getMessage());
  return back() -> withErrors($output) -> withInput();
}
}
//*  // exam leave request 2


// exam leave request related only after that above update fncn remove commentout 
public function examleaverequest(Request $request, $id) {

  // dd($request);
  // dd($id);
  try {

    if ($request -> status == 1) {
      $team = DB:: table('leaverequest')
        -> leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
        -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
        -> where('leaverequest.id', $id)
        -> select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
        -> first();

      if ($team -> name == 'Exam Leave') {

        $from = Carbon:: createFromFormat('Y-m-d', $team -> from);
        //2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
        $to = Carbon:: createFromFormat('Y-m-d', $team -> to ?? '');
        // 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
        $camefromexam = Carbon:: createFromFormat('Y-m-d', $team -> date);
        // dd($camefromexam);
        // $nowrequestdays = $to->diffInDays($camefromexam) + 1;
        // remove days from database 
        $removedays = $to -> diffInDays($camefromexam) + 1;
        // dd($removedays);
        // my total leave now after coming
        $nowtotalleave = $from -> diffInDays($camefromexam);
        // 5 days
        // dd($nowtotalleave);
        // for serching from data base 
        $finddatafromleaverequest = $to -> diffInDays($from) + 1;
        // dd($finddatafromleaverequest);
        // 9
        // dd($finddatafromleaverequest);

        // dd($requestdays);
        // $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)
        //   ->count();
        // //0
        // $totalrqstday = $nowrequestdays - $holidaycount;
        // 9
        // dd($holidaycount);
        // dd($totalrqstday);

        DB:: table('leaveapprove')
          -> where('teammemberid', $team -> createdby)
          -> where('totaldays', $finddatafromleaverequest)
          -> latest()
          -> update([
            'totaldays' => $nowtotalleave,
            'updated_at' => now(),
          ]);
        // dd($finddatafromleaverequest);

        // dd($team->from);
        // "2023-12-16"
        // dd($team->date);
        // "2023-12-20"
        // dd($team->to);
        // "2023-12-24"
        //! working one delete ek baar me
        // // $period = CarbonPeriod::create($team->date, $team->to);
        // $period = CarbonPeriod::create('2023-12-21', $team->to);
        // // dd($period);
        // $datess = [];
        // foreach ($period as $date) {
        //   $datess[] = $date->format('Y-m-d');
        //   // dd($datess);
        //   $deletedIds = DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->pluck('id');
        //   // dd($deletedIds);

        //   DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->delete();

        //   $a = DB::table('timesheetusers')
        //     ->whereIn('timesheetid', $deletedIds)
        //     ->delete();
        // }
        // dd($datess);
        // dd($deletedIds);

        $period = CarbonPeriod:: create($team -> date, $team -> to);

        $datess = [];
        foreach($period as $date) {
          $datess[] = $date -> format('Y-m-d');

          $deletedIds = DB:: table('timesheets')
            -> where('created_by', $team -> createdby)
            -> whereIn('date', $datess)
            -> pluck('id');

          DB:: table('timesheets')
            -> where('created_by', $team -> createdby)
            -> whereIn('date', $datess)
            -> delete ();

          $a = DB:: table('timesheetusers')
            -> whereIn('timesheetid', $deletedIds)
            -> delete ();
        }

        // dd($datess);


        // $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)->select('startdate')->get();

        // if (count($getholidays) != 0) {
        //   foreach ($getholidays as $date) {
        //     $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        //   }
        // } else {
        //   $hdatess[] = 0;
        // }

        // dd($hdatess);
        $el_leave = $datess;
        // 0 => "2023-09-16"
        // 1 => "2023-09-17"
        // 2 => "2023-09-18"
        // $exam_leave_total = count(array_diff($datess, $hdatess));
        // 62


        // $lstatus = "EL/A";
        // $lstatus = "Null";
        // $lstatus = "";
        $lstatus = null;

        foreach($el_leave as $cl_leave) {
          // date get one by one 

          $cl_leave_day = date('d', strtotime($cl_leave));
          // "16"



          $cl_leave_month = date('F', strtotime($cl_leave));

          // September
          // dd($cl_leave_month);
          // dd($cl_leave_day);
          // 16
          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave. ' +1 month'));
          }
          // dd('hi1', $team->createdby);
          // 802
          $attendances = DB:: table('attendances') -> where('employee_name', $team -> createdby)
            -> where('month', $cl_leave_month) -> first();
          // September
          // dd($attendances);
          //  dd($value->created_by);

          // dd('hi2', $attendances);
          // dd($cl_leave_day);
          // 16
          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }
          // dd('pa', $column);
          // sixteen
          // dd('pa', $lstatus);
          // EL/A
          if (!empty($column)) {
            // store EL/A sexteen to 25 tak 
            DB:: table('attendances')
              -> where('employee_name', $team -> createdby)
              -> where('month', $cl_leave_month)
              -> whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              -> whereRaw("{$column} != 'LWP'")
              -> update([
                $column => $lstatus,
              ]);
          }
          // if (!empty($column)) {
          //   // store EL/A sexteen to 25 tak 
          //   DB::table('attendances')
          //     ->where('employee_name', $team->createdby)
          //     ->where('month', $cl_leave_month)
          //     ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
          //     ->whereRaw("{$column} != 'LWP'")
          //     ->delete();
          // }
        }
        // dd('hq');
      }
      dd('end hare ', $team -> name);

      // if ($team->name == 'Exam Leave') {
      //   dd($team->name);
      //   $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
      //   // date: 2023-11-16 15:42:44.0 Asia/Kolkata (+05:30)
      //   // dd($to);
      //   $from = Carbon::createFromFormat('Y-m-d', $team->from);

      //   // date: 2023-09-16 15:43:42.0 Asia/Kolkata (+05:30)
      //   // dd($from);
      //   $requestdays = $to->diffInDays($from) + 1;
      //   // 62
      //   // dd($requestdays);
      //   $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
      //     ->where('enddate', '<=', $team->to)
      //     ->count();
      //   $totalrqstday = $requestdays - $holidaycount;
      //   //    dd($totalrqstday); die;

      //   DB::table('leaveapprove')->insert([
      //     'teammemberid'     =>     $team->createdby,
      //     'leavetype'     =>     $team->leavetype,
      //     'totaldays'     =>     $totalrqstday,
      //     'year'     =>     '2023',
      //     'created_at'          =>     date('y-m-d'),
      //     'updated_at'              =>    date('y-m-d'),
      //   ]);
      //   $period = CarbonPeriod::create($team->from, $team->to);

      //   // store all dates like 
      //   // 0 => "2023-09-16"
      //   // 1 => "2023-09-17"
      //   // 2 => "2023-09-18"
      //   $datess = [];
      //   foreach ($period as $date) {
      //     $datess[] = $date->format('Y-m-d');
      //     // 2023-09-16
      //     // dd($datess);
      //     // 62 data inserted
      //     $ids = DB::table('timesheets')->insertGetId(
      //       [
      //         'created_by' => $team->createdby,
      //         'month'     =>     date('F', strtotime($date->format('Y-m-d'))),
      //         'date'     =>    $date->format('Y-m-d'),
      //         'created_at'          =>     date('Y-m-d H:i:s'),
      //       ]
      //     );
      //     // 62 data inserted
      //     $a = DB::table('timesheetusers')->insert([
      //       'date'     =>    $date->format('Y-m-d'),
      //       'client_id'     =>    134,
      //       'workitem'     =>     $team->reasonleave,
      //       'location'     =>     '',
      //       //   'billable_status'     =>     $request->billable_status[$i],
      //       'timesheetid'     =>     $ids,
      //       'date'     =>    $date->format('Y-m-d'),
      //       'hour'     =>     8,
      //       'totalhour' =>      8,
      //       'assignment_id'     =>     214,
      //       'partner'     =>     887,
      //       'createdby' => $team->createdby,
      //       'created_at'          =>     date('Y-m-d H:i:s'),
      //       'updated_at'              =>    date('Y-m-d H:i:s'),
      //     ]);
      //   }
      //   // dd($datess);


      //   $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
      //     ->where('enddate', '<=', $team->to)->select('startdate')->get();

      //   if (count($getholidays) != 0) {
      //     foreach ($getholidays as $date) {
      //       $hdatess[] = date('Y-m-d', strtotime($date->startdate));
      //     }
      //   } else {
      //     $hdatess[] = 0;
      //   }

      //   // dd($hdatess);
      //   $el_leave = array_diff($datess, $hdatess);

      //   // 0 => "2023-09-16"
      //   // 1 => "2023-09-17"
      //   // 2 => "2023-09-18"
      //   $exam_leave_total = count(array_diff($datess, $hdatess));
      //   // 62


      //   $lstatus = "EL/A";



      //   foreach ($el_leave as $cl_leave) {
      //     // date get one by one 
      //     $cl_leave_day = date('d', strtotime($cl_leave));
      //     // "16"


      //     $cl_leave_month = date('F', strtotime($cl_leave));
      //     // September
      //     // dd($cl_leave_month);
      //     // dd($cl_leave_day);
      //     // 16
      //     if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
      //       $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
      //     }
      //     // dd('hi1', $team->createdby);
      //     // 802
      //     $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
      //       ->where('month', $cl_leave_month)->first();
      //     // September
      //     //  dd($value->created_by);

      //     // dd('hi2', $attendances);
      //     // dd($cl_leave_day);
      //     // 16
      //     $column = '';
      //     switch ($cl_leave_day) {
      //       case '26':
      //         $column = 'twentysix';
      //         break;
      //       case '27':
      //         $column = 'twentyseven';
      //         break;
      //       case '28':
      //         $column = 'twentyeight';
      //         break;
      //       case '29':
      //         $column = 'twentynine';
      //         break;
      //       case '30':
      //         $column = 'thirty';
      //         break;
      //       case '31':
      //         $column = 'thirtyone';
      //         break;
      //       case '01':
      //         $column = 'one';
      //         break;
      //       case '02':
      //         $column = 'two';
      //         break;
      //       case '03':
      //         $column = 'three';
      //         break;
      //       case '04':
      //         $column = 'four';
      //         break;
      //       case '05':
      //         $column = 'five';
      //         break;
      //       case '06':
      //         $column = 'six';
      //         break;
      //       case '07':
      //         $column = 'seven';
      //         break;
      //       case '08':
      //         $column = 'eight';
      //         break;
      //       case '09':
      //         $column = 'nine';
      //         break;
      //       case '10':
      //         $column = 'ten';
      //         break;
      //       case '11':
      //         $column = 'eleven';
      //         break;
      //       case '12':
      //         $column = 'twelve';
      //         break;
      //       case '13':
      //         $column = 'thirteen';
      //         break;
      //       case '14':
      //         $column = 'fourteen';
      //         break;
      //       case '15':
      //         $column = 'fifteen';
      //         break;
      //       case '16':
      //         $column = 'sixteen';
      //         break;
      //       case '17':
      //         $column = 'seventeen';
      //         break;
      //       case '18':
      //         $column = 'eighteen';
      //         break;
      //       case '19':
      //         $column = 'ninghteen';
      //         break;
      //       case '20':
      //         $column = 'twenty';
      //         break;
      //       case '21':
      //         $column = 'twentyone';
      //         break;
      //       case '22':
      //         $column = 'twentytwo';
      //         break;
      //       case '23':
      //         $column = 'twentythree';
      //         break;
      //       case '24':
      //         $column = 'twentyfour';
      //         break;
      //       case '25':
      //         $column = 'twentyfive';
      //         break;
      //     }
      //     // dd('pa', $column);
      //     // sixteen
      //     // dd('pa', $lstatus);
      //     // EL/A
      //     if (!empty($column)) {
      //       // store EL/A sexteen to 25 tak 
      //       DB::table('attendances')
      //         ->where('employee_name', $team->createdby)
      //         ->where('month', $cl_leave_month)
      //         ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
      //         ->whereRaw("{$column} != 'LWP'")
      //         ->update([
      //           $column => $lstatus,
      //         ]);
      //     }
      //   }
      //   // dd('hq');
      // }


      if ($team -> name == 'Sick Leave') {
        $to = Carbon:: createFromFormat('Y-m-d', $team -> to ?? '');
        $from = Carbon:: createFromFormat('Y-m-d', $team -> from);

        $requestdays = $to -> diffInDays($from) + 1;
        // dd($requestdays);
        $holidaycount = DB:: table('holidays') -> where('startdate', '>=', $team -> from)
          -> where('enddate', '<=', $team -> to)
          -> count();
        // dd($holidaycount);
        $totalrqstday = $requestdays - $holidaycount;
        // dd($totalrqstday); die;

        DB:: table('leaveapprove') -> insert([
          'teammemberid'     => $team -> createdby,
          'leavetype'     => $team -> leavetype,
          'totaldays'     => $totalrqstday,
          'year'     => '2023',
          'created_at'          => date('y-m-d'),
          'updated_at'              => date('y-m-d'),
        ]);




        $period = CarbonPeriod:: create($team -> from, $team -> to);
        $datess = [];
        foreach($period as $date) {
          $datess[] = $date -> format('Y-m-d');
        }


        $getholidays = DB:: table('holidays') -> where('startdate', '>=', $team -> from)
          -> where('enddate', '<=', $team -> to) -> select('startdate') -> get();

        if (count($getholidays) != 0) {
          foreach($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date -> startdate));
          }
        } else {
          $hdatess[] = 0;
        }
        $sl_leave = array_diff($datess, $hdatess);

        //  dd( $cl_leave );
        $sl_leave_total = count(array_diff($datess, $hdatess));

        $lstatus = "SL/A";




        $noofdaysaspertimesheet = DB:: table('timesheets')
          -> where('created_by', auth() -> user() -> teammember_id)
          -> where('date', '>=', '2023-04-26')
          -> where('date', '<=', '2023-05-25')
          -> select('timesheets.*')
          -> first();
        // dd($noofdaysaspertimesheet );

        foreach($sl_leave as $cl_leave) {




          $cl_leave_day = date('d', strtotime($cl_leave));
          $cl_leave_month = date('F', strtotime($cl_leave));

          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave. ' +1 month'));
          }


          $attendances = DB:: table('attendances') -> where('employee_name', $team -> createdby)
            -> where('month', $cl_leave_month) -> first();

          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }

          if (!empty($column)) {

            DB:: table('attendances')
              -> where('employee_name', $team -> createdby)
              -> where('month', $cl_leave_month)
              -> whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              -> whereRaw("{$column} != 'LWP'")
              -> update([
                $column => $lstatus,
              ]);
          }
        }
      }
      // dd($id);
      $applyleaveteam = DB:: table('leaveteams')
        -> leftjoin('teammembers', 'teammembers.id', 'leaveteams.teammember_id')
        -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
        -> where('leaveteams.leave_id', $id)
        -> select('teammembers.emailid') -> get();
      //   dd($applyleaveteam);
      if ($applyleaveteam != null) {
        foreach($applyleaveteam as $applyleaveteammail) {
          $data = array(
            'emailid' => $applyleaveteammail -> emailid,
            'team_member' => $team -> team_member,
            'from' => $team -> from,
            'to' => $team -> to,
          );

          Mail:: send('emails.applyleaveteam', $data, function ($msg) use($data) {
            $msg-> to($data['emailid']);
          $msg -> subject('VSA Leave Approved');
        });
      }
    }
    $data = array(
      'emailid' => $team -> emailid,
      'id' => $id,
      'from' => $team -> from,
      'to' => $team -> to,
    );

    Mail:: send('emails.applyleavestatus', $data, function ($msg) use($data) {
      $msg-> to($data['emailid']);
    // $msg->cc('priyankasharma@kgsomani.com');
    $msg -> subject('VSA Leave Approved');
  });
}
if ($request -> status == 2) {
  $team = DB:: table('applyleaves')
    -> leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    -> leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    -> leftjoin('roles', 'roles.id', 'teammembers.role_id')
    -> where('applyleaves.id', $id)
    -> select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name') -> first();
  $data = array(
    'emailid' => $team -> emailid,
    'id' => $id,
    'from' => $team -> from,
    'to' => $team -> to,
  );

  Mail:: send('emails.applyleavereject', $data, function ($msg) use($data) {
    $msg-> to($data['emailid']);
  // $msg->cc('priyankasharma@kgsomani.com');
  $msg -> subject('VSA Leave Reject');
});



$period = CarbonPeriod:: create($team -> from, $team -> to);
$datess = [];
foreach($period as $date) {
  $datess[] = $date -> format('Y-m-d');

  DB:: table('timesheets') -> where('date', $date -> format('Y-m-d'))
    -> where('created_by', $team -> createdby) -> delete ();
  DB:: table('timesheetusers') -> where('createdby', $team -> createdby)
    -> where('date', $date -> format('Y-m-d')) -> delete ();
}


$getholidays = DB:: table('holidays') -> where('startdate', '>=', $team -> from)
  -> where('enddate', '<=', $team -> to) -> select('startdate') -> get();

if (count($getholidays) != 0) {
  foreach($getholidays as $date) {
    $hdatess[] = date('Y-m-d', strtotime($date -> startdate));
  }
} else {
  $hdatess[] = 0;
}
$leave = array_diff($datess, $hdatess);

//  dd( $cl_leave );
$leave_total = count(array_diff($datess, $hdatess));

$lstatus = NULL;






foreach($leave as $cl_leave) {

  $cl_leave_day = date('d', strtotime($cl_leave));
  $cl_leave_month = date('F', strtotime($cl_leave));

  if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
    $cl_leave_month = date('F', strtotime($cl_leave. ' +1 month'));
  }


  $attendances = DB:: table('attendances') -> where('employee_name', $team -> createdby)
    -> where('month', $cl_leave_month) -> first();

  $column = '';
  switch ($cl_leave_day) {
    case '26':
      $column = 'twentysix';
      break;
    case '27':
      $column = 'twentyseven';
      break;
    case '28':
      $column = 'twentyeight';
      break;
    case '29':
      $column = 'twentynine';
      break;
    case '30':
      $column = 'thirty';
      break;
    case '31':
      $column = 'thirtyone';
      break;
    case '01':
      $column = 'one';
      break;
    case '02':
      $column = 'two';
      break;
    case '03':
      $column = 'three';
      break;
    case '04':
      $column = 'four';
      break;
    case '05':
      $column = 'five';
      break;
    case '06':
      $column = 'six';
      break;
    case '07':
      $column = 'seven';
      break;
    case '08':
      $column = 'eight';
      break;
    case '09':
      $column = 'nine';
      break;
    case '10':
      $column = 'ten';
      break;
    case '11':
      $column = 'eleven';
      break;
    case '12':
      $column = 'twelve';
      break;
    case '13':
      $column = 'thirteen';
      break;
    case '14':
      $column = 'fourteen';
      break;
    case '15':
      $column = 'fifteen';
      break;
    case '16':
      $column = 'sixteen';
      break;
    case '17':
      $column = 'seventeen';
      break;
    case '18':
      $column = 'eighteen';
      break;
    case '19':
      $column = 'ninghteen';
      break;
    case '20':
      $column = 'twenty';
      break;
    case '21':
      $column = 'twentyone';
      break;
    case '22':
      $column = 'twentytwo';
      break;
    case '23':
      $column = 'twentythree';
      break;
    case '24':
      $column = 'twentyfour';
      break;
    case '25':
      $column = 'twentyfive';
      break;
  }

  if (!empty($column)) {
    $columnValue = DB:: table('attendances')
      -> where('employee_name', $team -> createdby)
      -> where('month', $cl_leave_month)
      -> whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
      -> value($column);

    if ($columnValue == "SL/C" || $columnValue == "SL/A") {
      DB:: table('attendances')
        -> where('employee_name', $team -> createdby)
        -> where('month', $cl_leave_month)
        -> decrement('sick_leave');
    }

    if ($columnValue == "EL/C" || $columnValue == "EL/A") {
      DB:: table('attendances')
        -> where('employee_name', $team -> createdby)
        -> where('month', $cl_leave_month)
        -> decrement('exam_leave');
    }
    if ($columnValue == "BL/C" || $columnValue == "BL/A") {
      DB:: table('attendances')
        -> where('employee_name', $team -> createdby)
        -> where('month', $cl_leave_month)
        -> decrement('birthday_religious');
    }
    if ($columnValue == "LWP") {
      DB:: table('attendances')
        -> where('employee_name', $team -> createdby)
        -> where('month', $cl_leave_month)
        -> decrement('LWP');
    }
    DB:: table('attendances')
      -> where('employee_name', $team -> createdby)
      -> where('month', $cl_leave_month)
      -> whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
      -> update([
        $column => $lstatus
      ]);
  }
}
      }
$data = $request -> except(['_token', 'teammember_id']);
$data['updatedby'] = auth() -> user() -> teammember_id;
Applyleave:: find($id) -> update($data);
$output = array('msg' => 'Updated Successfully');
return redirect('applyleave') ->with ('success', $output);
    } catch (Exception $e) {
  DB:: rollBack();
  Log:: emergency("File:".$e -> getFile(). "Line:".$e -> getLine(). "Message:".$e -> getMessage());
  report($e);
  $output = array('msg' => $e -> getMessage());
  return back() -> withErrors($output) -> withInput();
}
  }

















app\Http\Controllers\AssignmentController.php


public function assignmentotp(Request $request) {
  //  dd($request->id); die;
  if ($request -> ajax()) {
    if (isset($request -> id)) {
      $assignment = DB:: table('assignmentmappings')
        -> where('assignmentgenerate_id', $request -> id)
        -> first();

      $teammembers = DB:: table('teammembers')
        -> where('id', auth() -> user() -> teammember_id)
        -> first();

      $otp = sprintf("%06d", mt_rand(1, 999999));

      DB:: table('assignmentbudgetings')
        -> where('assignmentgenerate_id', $assignment -> assignmentgenerate_id) -> update([
          'otp'  => $otp,
        ]);

      $data = array(
        'asassignmentsignmentid' => $assignment -> assignmentgenerate_id,
        'email' => $teammembers -> emailid,
        'otp' => $otp,
        'name' => $teammembers -> team_member,
      );

      Mail:: send('emails.assignmentclosed', $data, function ($msg) use($data, $assignment) {
        $msg-> to($data['email']);
      $msg -> subject('Assignment Closed by OTP'. ' || '.$assignment -> assignmentgenerate_id);
    });

    return response() -> json($assignment);
  }
}
}


//* runing code for worksheet enable 
$Newteammeber = DB:: table('timesheetusers')
  -> where('createdby', auth() -> user() -> teammember_id)
  -> first();
// dd($Newteammeber);
// if user not created any timesheet in that case 
// if ($Newteammeber == null) {
//   $Newteammeberjoining_date = DB::table('teammembers')
//     ->where('id', auth()->user()->teammember_id)
//     ->select('joining_date')
//     ->first();
//   $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));
// }
// if ($Newteammeber == null) {
//   $Newteammeberjoining_date = DB::table('teammembers')
//     ->where('id', auth()->user()->teammember_id)
//     ->select('joining_date')
//     ->first();
//   $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));
//   dd($joining_date);
//   // 29-11-2023

// }

if ($Newteammeber == null) {
  // dd('team', $Newteammeber);
  $Newteammeberjoining_date = DB:: table('teammembers')
    -> where('id', auth() -> user() -> teammember_id)
    -> select('joining_date')
    -> first();
  $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date -> joining_date));
  // Get previuse sunday from joining date
  $joining_timestamp = strtotime($joining_date);
  $day_of_week = date('w', $joining_timestamp);
  $days_to_subtract = $day_of_week;
  $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);
  $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
  // Get all dates beetween two dates 
  $startDate = Carbon:: parse($previous_sunday_date);
  $endDate = Carbon:: parse($joining_date);
  $period = CarbonPeriod:: create($startDate, $endDate);
  // store all date in $result vairable
  $result = [];
  foreach($period as $key => $date) {
    if ($key !== 0 && $key !== count($period) - 1) {
      $result[] = $date -> toDateString();
    }
  }
  // return $result;
  // dd('yes', $result);
  // Insert records for each date in $result array
  foreach($result as $date) {
    $a = DB:: table('timesheetusers') -> insert([
      'date'        => date('Y-m-d', strtotime($date)),
      'createdby'   => auth() -> user() -> teammember_id,
      'created_at'  => date('Y-m-d H:i:s'),
      'updated_at'  => date('Y-m-d H:i:s'),
    ]);
  }
}
// // if user created any timesheet in that case 
elseif($Newteammeber -> id != null) {
  // dd('teamyes', $Newteammeber);
  $Newteammeberjoining_date = DB:: table('teammembers')
    -> where('id', auth() -> user() -> teammember_id)
    -> select('joining_date')
    -> first();
  $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date -> joining_date));
  // Get previuse sunday from joining date
  $joining_timestamp = strtotime($joining_date);
  $day_of_week = date('w', $joining_timestamp);
  $days_to_subtract = $day_of_week;
  $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);
  $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
  // Get all dates beetween two dates 
  $startDate = Carbon:: parse($previous_sunday_date);
  $endDate = Carbon:: parse($joining_date);
  $period = CarbonPeriod:: create($startDate, $endDate);
  // store all date in $result vairable
  $result = [];
  foreach($period as $key => $date) {
    if ($key !== 0 && $key !== count($period) - 1) {
      $result[] = $date -> toDateString();
    }
  }
  // return $result;
  // dd('yes', $result);
  // Insert records for each date in $result array
  foreach($result as $date) {
    $a = DB:: table('timesheetusers') -> insert([
      'date'        => date('Y-m-d', strtotime($date)),
      'createdby'   => auth() -> user() -> teammember_id,
      'created_at'  => date('Y-m-d H:i:s'),
      'updated_at'  => date('Y-m-d H:i:s'),
    ]);
  }
}
<!DOCTYPE html>
<html lang="en">

<body>

    {{-- *   --}}
    fir se alert box ke cancel button per aa raha hai 
    {{--  Start Hare --}}
    {{-- *   --}}
    {{--  Start Hare --}}
    {{-- *   --}}


    <div style="display: flex">
        <div class="panel-header text-center" style=" margin-right: 22px;">
            <a style="color: white" class="btn btn-success" id="editCompany"
                data-id="{{ $debtorid }}" data-status="1" data-toggle="modal"
                data-target="#exampleModal1">
                Accept </a>
        </div>

        <div class="panel-header text-center">
            <a style="color: white" class="btn btn-danger" id="editCompany2"
                data-id="{{ $debtorid }}" data-status="0" data-toggle="modal"
                data-target="#exampleModal12">
                Refuse
            </a>
        </div>
    </div>

    <script>
        $(function() {
            // Function to handle click on "Accept" button
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var acceptButton = $(this); // Reference to the clicked "Accept" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        acceptButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal1').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Function to handle click on "Refuse" button
            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                var refuseButton = $(this); // Reference to the clicked "Refuse" button
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                        // Remove data-toggle attribute to prevent modal from opening again
                        refuseButton.removeAttr('data-toggle');
                        // Open the modal manually
                        $('#exampleModal12').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>
    {{--  Start Hare --}}

    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            $('body').on('click', '#editCompany2', function(event) {
                if (!confirm('Are you sure?')) {
                    event.preventDefault();
                    return;
                }
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        $("#otpmessage1").text(response.otpsuccessmessage1);
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
                // Set data-toggle attribute to "modal" before opening modal
                $(this).attr('data-toggle', 'modal');
            });

            // Prevent modal from opening or hiding when clicking cancel button
            $('body').on('click', '[data-dismiss="modal"]', function(event) {
                event.stopPropagation();
            });
        });
    </script>






    {{-- *   --}}
    [12:52 PM] sukhbahadur
    <a style="color: white" class="btn btn-success" id="editCompany" data-id="{{ $debtorid }}" data-toggle="modal"
        data-target="#exampleModal1" onclick="return confirm('Are you sure ?');">
        Accept </a>



        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('otpap/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Enter
                        Verification OTP</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                            <li style="color:red;">{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
 
                    <div class="details-form-field form-group row">
                        <div class="col-sm-12">
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
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
    $(function () {
        $('body').on('click', '#editCompany', function (event) {
            //        debugger;
            var id = $(this).data('id');
            debugger;
            $.ajax({
                type: "GET",
 
                url: "{{ url('confirmationauthotp') }}",
                data: "id=" + id,
                success: function (response) {
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



    {{--  Start Hare --}}

    <td>
        @if (Auth::user()->teammember_id == 157)
            @if ($timesheetrequestsData->status == 0)
                <span class="badge badge-pill badge-warning">Created</span>
            @elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
                <span class="badge badge-pill badge-warning">Approved by partner</span>
            @elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
                <span class="badge badge-pill badge-success">Approved</span>
            @elseif($timesheetrequestsData->status == 2)
                <span class="badge badge-pill badge-danger">Rejected</span>
            @else
                <span class="badge badge-pill badge-primary">Hold</span>
            @endif
        @else
            @if ($timesheetrequestsData->status == 0)
                <span class="badge badge-pill badge-warning">Created</span>
            @elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate == null)
                <span class="badge badge-pill badge-warning">Pending for final
                    approval</span>
            @elseif($timesheetrequestsData->status == 1 && $timesheetrequestsData->validate != null)
                <span class="badge badge-pill badge-success">Approved</span>
            @elseif($timesheetrequestsData->status == 2)
                <span class="badge badge-pill badge-danger">Rejected</span>
            @else
                <span class="badge badge-pill badge-primary">Hold</span>
            @endif
        @endif

        @if (Auth::user()->teammember_id == $timesheetrequestsData->createdby)
            @if ($timesheetrequestsData->status < 2 && $timesheetrequestsData->validate == null)
                <a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
                    data-target="#exampleModal112" title="Send Reminder">
                    <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
                </a>
            @endif
        @endif
    </td>


    <a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}" data-target="#exampleModal112"
        title="Send Reminder">
        <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
    </a>


    {{-- request reminder modal --}}
    <div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background: #218838;">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Request
                        Reminder
                        list</h5>
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
                    <div class="table-responsive">
                        <table id="reminderTable" class="table display table-bordered table-striped table-hover">
                            <thead>
                                <tr>
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
                    <a class="btn btn-success sendReminderBtn"> Send Reminder</a>
                </div>

            </div>
        </div>
    </div>

    {{-- *   --}}
    {{--  Start Hare --}}
    {!! $description ?? '' !!}

    <p><br /> <br /> <br /> <span style="text-decoration: underline;"><strong>Confirmation</strong></span><br /> <br />
        We
        confirm that the in our books of account, the outstanding balance as on 30.09.2022 is
        <span style="color: #ff6600;">Rs {{ $amount ?? '' }}</span> <br />
    </p>
    <h1 style="text-align: center;"><strong><a
                href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}"><span
                    style="color: #000000; background-color: #99cc00;">Accept&nbsp;</span> &nbsp; &nbsp; <span
                    style="background-color: #ff6600; color: #000000;">&nbsp;&nbsp;</span></a><span
                style="color: #000000; background-color: #ff6600;"><a style="color: #000000; background-color: #ff6600;"
                    href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $no) }}">Refuse
                </a>&nbsp;</span></strong></h1>
    <p>&nbsp;</p>
    <br>
    <hr>
    <p style="text-align: center;">Powered By <span style="color: green">CapITall</span></p>
    <p><em>NOTICE: Information, including attachments if any, contained through this email is confidential and intended
            for
            a specific individual and purpose, and is protected by law. If you are not the intended recipient any use,
            distribution, transmission, copying or disclosure of this information in any way or in any manner is
            strictly
            prohibited. You should delete this message and inform the sender. </em></p>
    <p>&nbsp;</p>

    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
        href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}

    {{-- *   --}}
    {{--  Start Hare --}}
    <p>We received your request to reset your password shahid.<br>
        {{-- To continue, please click <a href="{{ url('confirmationAccept') }}">here</a></p> --}}
        {{-- To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}">here</a> --}}
        To continue, please click <a
            href="{{ url('/confirmationAccept?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'yes=' . $yes . '&&' . 'no=' . $no) }}">here</a>
    </p>
    {{-- {{ url('authreset/newpassword/' . $url) }} --}}
</body>

</html>

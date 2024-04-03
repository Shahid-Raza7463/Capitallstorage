<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>K.G.Somani</title>

    <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
</head>

<body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh"
        style="background-image:url('backEnd/image/unnamed.jpg');">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">
                <div class="register-logo text-center mb-4">
                </div>
                <div class="panel">
                    @if ($errors->any())
                        {{-- <div class="alert alert-danger"> --}}
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                        {{-- </div> --}}
                    @endif
                    @if (session('success_message'))
                        <p class="text-danger">{{ session('success_message') }}</p>
                    @endif
                    <div style="display: flex">
                        <div class="panel-header text-center" style=" margin-right: 22px;">
                            <a href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}"
                                onclick="return confirm('Are you sure ?');">
                                <button type="submit" style="background: #218838"
                                    class="btn btn-success btn-block">Accept</button>
                            </a>
                        </div>
                        <div class="panel-header text-center" style=" margin-right: 22px;">
                            <a style="color: white" class="btn btn-success" id="editCompany"
                                data-id="{{ $debtorid }}" data-toggle="modal" data-target="#exampleModal1"
                                onclick="return confirm('Are you sure ?');">
                                Accept </a>
                        </div>



                        <div class="panel-header text-center">
                            <a href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $no) }}"
                                onclick="return confirm('Are you sure ?');">
                                <button type="submit" style="background: #d3400a"
                                    class="btn btn-success btn-block">Refuse</button>
                            </a>
                        </div>
                    </div>

                    {{-- model box --}}
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel4" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {{-- <form id="detailsForm" method="post" action="{{ url('confirmationotp') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header" style="background: #37A000">
                                        <h5 style="color:white;" class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Enter
                                            Verification OTP</h5>
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
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="otp" class="form-control"
                                                    placeholder="Enter OTP">

                                                <input type="text" id="debitid" name="debitid"
                                                    class="form-control">
                                                <input type="text" id="assignmentgenerate_id"
                                                    name="assignmentgenerate_id" class="form-control">
                                                <input type="text" id="type" name="type"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success" id="sendbutton">Save</button>
                                    </div>
                                </form> --}}
                                <form id="detailsForm" method="post" action="{{ url('confirmationotp') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header" style="background: #37A000">
                                        <h5 style="color:white;" class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Enter Verification OTP</h5>
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
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="otp" class="form-control"
                                                    placeholder="Enter OTP">
                                                <input type="text" id="debitid" name="debitid"
                                                    class="form-control">
                                                <input type="text" id="assignmentgenerate_id"
                                                    name="assignmentgenerate_id" class="form-control">
                                                <input type="text" id="type" name="type"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" id="sendbutton">Save</button>
                                    </div>
                                </form>

                                {{-- <form id="detailsForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header" style="background: #37A000">
                                        <h5 style="color:white;" class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Enter Verification OTP</h5>
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
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="text-danger" id="otpwarningmessage"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="otp" class="form-control"
                                                    placeholder="Enter OTP">
                                                <input type="text" id="debitid" name="debitid"
                                                    class="form-control">
                                                <input type="text" id="assignmentgenerate_id"
                                                    name="assignmentgenerate_id" class="form-control">
                                                <input type="text" id="type" name="type"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" id="sendbutton">Save</button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!--/.main content-->

    <!-- js bar start-->
    @include('backEnd.layouts.includes.js')
    <!-- js bar end -->




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                alert(id);
                // debugger;
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // console.log('data is:', error);
                        // console.log(response);
                        // debugger;
                        // $("#mailotp").val(response);
                        // $("#otpmessage").val(response);
                        // $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script>


    {{-- <script>
        $(function() {
            $('body').on('click', '#sendbutton', function(event) {
                //        debugger;
                var id = $(this).data('id');
                alert(id);
                // debugger;
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // console.log('data is:', error);
                        // console.log(response);
                        // debugger;
                        // $("#mailotp").val(response);
                        // $("#otpmessage").val(response);
                        // $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script> --}}


    {{-- <script>
        $(document).ready(function() {
            $('#sendbutton').click(function() {
                var formData = new FormData($('#detailsForm')[0]);
                alert(formData);
                $.ajax({
                    type: 'POST',
                    url: $('#detailsForm').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('#sendbutton').click(function() {
                var formData = {
                    otp: $('input[name="otp"]').val(),
                    debitid: $('#debitid').val(),
                    assignmentgenerate_id: $('#assignmentgenerate_id').val(),
                    type: $('#type').val()
                };


                $.ajax({
                    type: 'POST',
                    url: "{{ url('confirmationotp') }}",
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}


    {{-- <script>
        $(document).ready(function() {
            $('#sendbutton').click(function() {
                var formData = {
                    _token: '{{ csrf_token() }}',
                    otp: $('input[name="otp"]').val(),
                    debitid: $('#debitid').val(),
                    assignmentgenerate_id: $('#assignmentgenerate_id').val(),
                    type: $('#type').val()
                };

                $.ajax({
                    type: 'POST',
                    url: "{{ url('confirmationotp') }}",
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        // console.log(response.otpwarningmessage);
                        // $('#otpmessage').empty();
                        $('#otpmessage').closest('div').empty();
                        $("#otpwarningmessage").text(response.otpwarningmessage);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
</body>

</html>

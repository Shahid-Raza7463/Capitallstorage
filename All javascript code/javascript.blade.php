{{-- * --}}
{{-- * --}}
{{-- * --}}
{{-- * please wait / regarding second --}}
{{-- @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li style="margin-left: 13px;">
                    <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
                </li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment Folder</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        @component('backEnd.components.alert')
        @endcomponent

        <div class="row">
            <div id="loadingMessage" style="display:none;">
                Creating your zip file. Please wait... <span id="countdown">120</span> seconds remaining.
            </div>
            <div id="createdzipfile" style="display:none;">
            </div>
        </div>
        <div class="row">
            <div>
                <a href="{{ route('createdzip', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                    class="btn btn-secondary" style="color:white; display:none;" id="downloadzip">Download
                    your file</a>
            </div>
        </div>
    </div>
@endsection --}}
{{-- <script>
    $(document).ready(function() {
        // Create Zip Folder button click event
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';
            $('#loadingMessage').show();
            // var countdown = 20; // Initial countdown value

            // // Show loading message
            // $('#loadingMessage').show();

            // // Function to update countdown
            // function updateCountdown() {
            //     $('#countdown').text(countdown);
            //     countdown--;

            //     // If countdown reaches 0, stop updating and hide loading message
            //     if (countdown < 0) {
            //         clearInterval(countdownInterval);
            //         $('#loadingMessage').hide();
            //     }
            // }

            // // Start updating countdown every second
            // var countdownInterval = setInterval(updateCountdown, 1000);

            $.ajax({
                type: 'GET',
                url: '/assignmentzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function(data) {
                    // Hide loading message when the request is complete
                    $('#loadingMessage').hide();
                    // Display created zip file name
                    $('#createdzipfile').text('Created Zip File: ' + data).show();
                    $('#downloadzip').show();

                    // Handle the success response here
                    // alert(data);
                },
                error: function(error) {
                    // Hide loading message in case of an error
                    $('#loadingMessage').hide();

                    // Handle any errors here
                    console.error(error);
                }
            });
        });
    });
</script> --}}
{{-- * regarding jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Download button click event
        $('#downloadzip').click(function() {
            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            // You can also hide the button if needed
            // $(this).hide();
        });
    });
</script>
{{-- *regarding ajax --}}
<nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
    <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
        <li style="margin-left: 13px;">
            <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
        </li>
    </ol>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script>
    $(document).ready(function() {
        // Create Zip Folder button click event
        $('#downloadButton').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // var assignmentgenerateid = {{ $assignmentgenerateid }};
            // console.log(assignmentgenerateid);
            alert('hi');
            $.ajax({
                type: 'GET',
                url: '/assignmentzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid,
                },
                success: function(data) {
                    // Handle the success response here
                },
                error: function(error) {
                    // Handle any errors here
                }
            });
        });
    });
</script>

{{-- * --}}
{{-- validation on date --}}
<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $(this);
            var leaveDateValue = leaveDate.val();

            // Use a regular expression to match a four-digit year
            var yearPattern = /^\d{4}$/;

            if (!yearPattern.test(leaveDateValue)) {
                alert('Please enter a valid four-digit year');
                leaveDate.val('');
            }
        });
    });
</script>


{{-- multiple date ho ager ek hi page me tab --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $(this);
            var leaveDateValue = leaveDate.val();
            var leaveDateGet = new Date(leaveDateValue);
            var leaveyear = leaveDateGet.getFullYear();
            // console.log(startyear);
            var leaveyearLength = leaveyear.toString().length;
            if (leaveyearLength > 4) {
                alert('Enter four digits for the year');
                leaveDate.val('');
            }
        });
    });
</script>



{{-- validation for comparision date and block year for 4 disit --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startDate');
        var endDateInput = $('#endDate');

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
        $('#startDate').on('change', function() {
            var startclear = $('#startDate');
            var startDateInput1 = $('#startDate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
        });
        $('#endDate').on('change', function() {
            var endclear = $('#endDate');
            var endDateInput1 = $('#endDate').val();
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
        $('#startdate').on('change', function() {
            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
            //   validation for year match
            var yearvalue = $('#year').val();
            if (yearvalue != startyear) {
                alert('Enter Start Date According Year');
                startclear.val('');
            }
        });
        $('#enddate').on('change', function() {
            var endclear = $('#enddate');
            var endDateInput1 = $('#enddate').val();
            var endtDate = new Date(endDateInput1);
            var endyear = endtDate.getFullYear();
            var endyearLength = endyear.toString().length;
            if (endyearLength > 4) {
                alert('Enter four digits for the year');
                endclear.val('');
            }
            //   validation for year match
            var yearvalue = $('#year').val();
            if (yearvalue != endyear) {
                alert('Enter End Date According Year');
                endclear.val('');
            }
        });
    });
</script>


<script>
    if ($teamname && $start || $end) {
        $query - > where(function($q) use($teamname, $start, $end) {
            $q - > where('timesheetreport.teamid', $teamname) -
                >
                whereBetween('timesheetreport.startdate', [$start, $end]) -
                >
                orWhereBetween('timesheetreport.enddate', [$start, $end]) -
                >
                orWhere(function($query) use($start, $end) {
                    $query - > where('timesheetreport.startdate', '<=', $start) -
                        >
                        where('timesheetreport.enddate', '>=', $end);
                });
        });
    }
</script>

<script>
    //   remove pagination after filter
    $('.paging_simple_numbers').remove();
    $('.dataTables_info').remove();
</script>

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

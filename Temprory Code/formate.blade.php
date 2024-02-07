<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            @if ($diff_in_days > 20)
                @if ($timesheetrequest == null)
                    <li class="breadcrumb-item">
                        <a data-toggle="modal" data-target="#exampleModal21">Add Timesheet Request</a>
                    @else
                        @if ($currentdate < $timesheetrequest->validate)
                    <li class="breadcrumb-item">
                        {{-- <a href="{{ url('timesheet/create') }}">Add Timesheet</a> --}}
                        <a data-toggle="modal" data-target="#exampleModal21">Add Timesheet Request</a>
                    </li>
                    @if (
                        (now()->isSunday() && now()->hour >= 18) ||
                            now()->isMonday() ||
                            now()->isTuesday() ||
                            now()->isWednesday() ||
                            now()->isThursday() ||
                            now()->isFriday() ||
                            (now()->isSaturday() && now()->hour <= 18))
                        @if ($timesheetcount >= 6)
                            <li class="breadcrumb-item"><a
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @endif
                    <li class="breadcrumb-item active">+</li> -->
                @else
                    <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Requested Done</a>
                    </li>
                @endif
            @endif
        @elseif(15 < 16)
            <li class="breadcrumb-item"><a href="{{ url('timesheet/create') }}">Add Timesheet @if ($timesheetcount < 7)
                        for last week
                    @endif </a></li>

            @if (
                (now()->isSunday() && now()->hour >= 18) ||
                    now()->isMonday() ||
                    now()->isTuesday() ||
                    now()->isWednesday() ||
                    now()->isThursday() ||
                    now()->isFriday() ||
                    (now()->isSaturday() && now()->hour <= 18))
                @if ($timesheetcount >= 6)
                    <li class="breadcrumb-item"><a
                            onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                            href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                    </li>
                @endif
            @endif




            <!-- <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal1">Upload File</a></li>
                                                                                                                                                                                <li class="breadcrumb-item active">+</li> -->
            @endif

        </ol>
    </nav>
</body>

</html>

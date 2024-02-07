{{-- ss --}}


<td class="text-center">

    @php
        // $totalFields = 26; // 30 column
        // $filledFields = 0;

        // $filledFields += !empty($teammemberData->id) ? 1 : 0;
        // $filledFields += !empty($teammemberData->team_member) ? 1 : 0;
        // $filledFields += !empty($teammemberData->profilepic) ? 1 : 0;
        // $filledFields += !empty($teammemberData->staffcode) ? 1 : 0;
        // $filledFields += !empty($teammemberData->role->rolename) ? 1 : 0;
        // $filledFields += !empty($teammemberData->designation) ? 1 : 0;
        // $filledFields += !empty($teammemberData->mobile_no) ? 1 : 0;
        // $filledFields += !empty($teammemberData->dateofbirth) ? 1 : 0;
        // $filledFields += !empty($teammemberData->joining_date) ? 1 : 0;
        // $filledFields += !empty($teammemberData->department) ? 1 : 0;
        // $filledFields += !empty($teammemberData->emailid) ? 1 : 0;
        // $filledFields += !empty($teammemberData->personalemail) ? 1 : 0;
        // $filledFields += !empty($teammemberData->communicationaddress) ? 1 : 0;
        // $filledFields += !empty($teammemberData->permanentaddress) ? 1 : 0;
        // $filledFields += !empty($teammemberData->adharcardnumber) ? 1 : 0;
        // $filledFields += !empty($teammemberData->aadharupload) ? 1 : 0;
        // $filledFields += !empty($teammemberData->pancardno) ? 1 : 0;
        // $filledFields += !empty($teammemberData->panupload) ? 1 : 0;
        // $filledFields += !empty($teammemberData->emergencycontactnumber) ? 1 : 0;
        // $filledFields += !empty($teammemberData->nameofbank) ? 1 : 0;
        // $filledFields += !empty($teammemberData->bankaccountnumber) ? 1 : 0;
        // $filledFields += !empty($teammemberData->ifsccode) ? 1 : 0;
        // $filledFields += !empty($teammemberData->mothername) ? 1 : 0;
        // $filledFields += !empty($teammemberData->mothernumber) ? 1 : 0;
        // $filledFields += !empty($teammemberData->cancelcheque) ? 1 : 0;
        // $filledFields += !empty($teammemberData->fathername) ? 1 : 0;
        // $filledFields += !empty($teammemberData->fathernumber) ? 1 : 0;

        $totalFields = 24;
        $filledFields = 0;

        $filledFields += !empty($teammemberData->id) ? 1 : 0;
        $filledFields += !empty($teammemberData->team_member) ? 1 : 0;
        $filledFields += !empty($teammemberData->staffcode) ? 1 : 0;
        $filledFields += !empty($teammemberData->emailid) ? 1 : 0;
        $filledFields += !empty($teammemberData->personalemail) ? 1 : 0;
        $filledFields += !empty($teammemberData->mobile_no) ? 1 : 0;
        $filledFields += !empty($teammemberData->dateofbirth) ? 1 : 0;
        $filledFields += !empty($teammemberData->adharcardnumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->aadharupload) ? 1 : 0;
        $filledFields += !empty($teammemberData->pancardno) ? 1 : 0;
        $filledFields += !empty($teammemberData->panupload) ? 1 : 0;
        $filledFields += !empty($teammemberData->profilepic) ? 1 : 0;
        $filledFields += !empty($teammemberData->mothername) ? 1 : 0;
        $filledFields += !empty($teammemberData->mothernumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->fathername) ? 1 : 0;
        $filledFields += !empty($teammemberData->fathernumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->joining_date) ? 1 : 0;
        $filledFields += !empty($teammemberData->leavingdate) ? 1 : 0;
        $filledFields += !empty($teammemberData->addressupload) ? 1 : 0;
        $filledFields += !empty($teammemberData->permanentaddress) ? 1 : 0;
        $filledFields += !empty($teammemberData->communicationaddress) ? 1 : 0;
        $filledFields += !empty($teammemberData->nameasperbank) ? 1 : 0;
        $filledFields += !empty($teammemberData->nameofbank) ? 1 : 0;
        $filledFields += !empty($teammemberData->bankaccountnumber) ? 1 : 0;
        $filledFields += !empty($teammemberData->cancelcheque) ? 1 : 0;

        $profileCompletionPercentage = ($filledFields / $totalFields) * 100;
        $formattedProfileCompletion = number_format($profileCompletionPercentage, 2);
    @endphp
    @if ($formattedProfileCompletion == 100)
        <span class="badge badge-pill badge-success"
            style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
    @else
        <span class="badge badge-pill badge-danger"
            style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
    @endif
</td>

{{-- ss --}}
<div class="field_wrapper">

    <div class="row row-sm">
        <div class="col-2">
            @php
                // dd($timesheetedit[0]->assignment_id);
            @endphp
            <div class="form-group">
                <label class="font-weight-600">Client Name *</label>
                <select required class="language form-control" name="client_id[]" id="client"
                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                    Client
                    </option>

                    @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}">
                        {{ $clientData->client_name }}</option>
                    @endforeach
                    

                    @else
                    <option></option>
                    <option value="">Select Client</option>
                    @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}"{{ $timesheetedit[0]->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                        {{ $clientData->client_name }}</option>

                    @endforeach @endif
                    </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Assignment Name *</label>

                <select required class="form-control key" name="assignment_id[]" id="assignment">
                    {{-- @if (!empty($timesheet->assignment_id))
                        <option
                            value="{{ $timesheet->assignment_id }}"{{ App / Models / Assignment::where('id', $timesheetedit[0]->assignment_id)->first()->assignment_name ?? '' ? 'selected="selected"' : '' }}>
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif --}}
                    @if (!empty($timesheetedit[0]->assignment_id))
                        @php
                            $assignment = app('App\Models\Assignment')
                                ->where('id', $timesheetedit[0]->assignment_id)
                                ->first();
                        @endphp
                        @if ($assignment)
                            {{-- <option value="{{ $timesheetedit[0]->assignment_id }}">
                            {{ $assignment->assignment_name }}
                        </option> --}}
                            <option value="{{ $assignment->id }}">
                                {{ $assignment->assignment_name }}
                            </option>
                        @endif
                    @endif
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $assignment->id }}"
                            {{ $timesheetedit[0]->assignment_id == $assignment->id ? 'selected' : '' }}>
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>

            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>

                <select required class="language form-control" id="partner" name="partner[]">
                    @if (!empty($timesheetedit[0]->partner))
                        @php
                            $assignment = app('App\Models\Teammember')
                                ->where('id', $timesheetedit[0]->partner)
                                ->first();
                        @endphp
                        @if ($assignment)
                            <option value="{{ $timesheetedit[0]->partner }}">
                                {{ $assignment->team_member }}
                            </option>
                        @endif
                    @endif
                </select>
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item *</label>
                <input required type="text" name="workitem" id="totalhour" value="{{ $timesheetedit[0]->workitem }}"
                    class="form-control" placeholder="Enter Name">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input required type="text" name="location" id="location" value="{{ $timesheetedit[0]->location }}"
                    class="form-control" placeholder="Enter Location">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour *</label>
                <input required type="text" name="hour" id="location" value="{{ $timesheetedit[0]->hour }}"
                    class="form-control" placeholder="Enter Location">

                <span style="font-size: 10px;margin-left: 10px;"></span>
            </div>
        </div>
    </div>
</div>
<hr>

<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right">Save</button>
    <a class="btn btn-secondary" href="{{ url('timesheet') }}">
        Back</a>
</div>

{{-- <script type="text/javascript">
   $(function () {
    $('#timepicker').datetimepicker({
        use24hours: true,
        format: 'HH:mm'
    });
});
 </script> --}}

<script>
    function calculateTotal() {
        var hour1 = parseInt(document.getElementById("hour1").value) || 0;
        var hour2 = parseInt(document.getElementById("hour2").value) || 0;
        var hour3 = parseInt(document.getElementById("hour3").value) || 0;
        var hour4 = parseInt(document.getElementById("hour4").value) || 0;
        var hour5 = parseInt(document.getElementById("hour5").value) || 0;

        var totalSum = hour1 + hour2 + hour3 + hour4 + hour5;

        document.getElementById("totalhours").value = totalSum;
    }


    function validateTimeInput(inputId, maxTime) {
        const timeInput = document.getElementById(inputId);

        timeInput.addEventListener('input', function() {
            const inputTime = this.value;

            if (inputTime > maxTime) {
                this.setCustomValidity('The time entered exceeds the maximum of 24 hours');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Call the function for each input element
    // validateTimeInput('hour1', '24:00');
    // validateTimeInput('hour2', '24:00');
    // validateTimeInput('hour3', '24:00');
    // validateTimeInput('hour4', '24:00');
    // validateTimeInput('hour5', '24:00');
</script>

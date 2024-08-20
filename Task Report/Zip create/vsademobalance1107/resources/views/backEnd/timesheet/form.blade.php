<div class="field_wrapper">
    <style>
        .refreshoption {
            /* height: 4rem; */
            height: 56px;
        }

        .refresh {
            /* height: 4rem; !important  */
            height: 56px;
        }
    </style>

    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name *</label>
                <select required class="language form-control refresh" name="client_id[]" id="client"
                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
            Client
            </option>

            @foreach ($client as $clientData)
            <option value="{{ $clientData->id }}"
                {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                {{ $clientData->client_name }}</option>
            @endforeach
            

            @else
            <option></option>
            <option value="">Select Client</option>
            @foreach ($client as $clientData)
            <option value="{{ $clientData->id }}">
                {{ $clientData->client_name }} ({{ $clientData->client_code }})</option>
            @endforeach @endif
                    </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Assignment Name *</label>
                <select class="form-control key refreshoption assignmentvalue" name="assignment_id[]" id="assignment">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select required class="language form-control refreshoption partnervalue" id="partner"
                    name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item *</label>
                <textarea required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key refresh workitemnvalue" rows="2"></textarea>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key refresh locationvalue ">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour *</label>
                <input required type="text" class="form-control refresh readkey" id="hour1" name="hour[]"
                    min="0" oninput="calculateTotal(this)"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">

                <span style="font-size: 10px;margin-left: 10px;"></span>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Client Name</label>
                <select class="language form-control refresh" name="client_id[]" id="client1"
                    @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                    Client
                    </option>

                    @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}"
                        {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                        {{ $clientData->client_name }}</option>
                    @endforeach


                    @else
                    <option></option>
                    <option value="">Select Client</option>
                    @foreach ($client as $clientData)
                    <option value="{{ $clientData->id }}">
                        {{ $clientData->client_name }} ({{ $clientData->client_code }})</option>

                    @endforeach @endif
                    </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Assignment Name</label>
                <select class="form-control key refreshoption assignmentvalue1" name="assignment_id[]" id="assignment1">
                    @if (!empty($timesheet->assignment_id))
                        <option value="{{ $timesheet->assignment_id }}">
                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                        </option>
                    @endif
                </select>
                <!-- <select class="form-control key refreshoption" name="assignment_id[]" id="assignment">
             <option disabled style="display:block">Select
                Assignment
                </option>
                
            </select> -->


            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600">Partner *</label>
                <select class="language form-control refreshoption partnervalue1" id="partner1" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem1 refresh workitemnvalue1" rows="2"></textarea>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key location1 refresh locationvalue1">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="text" class="form-control hour1 refresh" id="hour2" min="0"
                    name="hour[]" oninput="calculateTotal(this)"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">

            </div>
        </div>
        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="form-group">
    <div class="col-10">
    </div>
    <div class="col-2" style="margin-left: 759px;">
        <div class="form-group">
            <label class="font-weight-600">Total Hour</label>
            <input type="text" class="time form-control" id="totalhours" name="totalhour"
                value="{{ $timesheet->hour ?? '' }}">
        </div>
    </div>

</div>
<div class="form-group">

    <button type="submit" class="btn btn-success" style="float:right"> Save</button>
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


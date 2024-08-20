<div class="row row-sm">
    <div class="col-3" id="Div1">
        <div class="form-group">
            <label class="font-weight-600"> Vendor*</label>
            <select class="language form-control" id="vendor" name="vendor_id"
                @if(Request::is('vendor/*/edit'))> <option disabled style="display:block">Please Select One</option>

                @foreach($vendorlist as $vendorvendorlistData)
                <option value="{{$vendorvendorlistData->id}}"
                    {{$vendor->sharewith == $vendorvendorlistData->id??'' ?'selected="selected"' : ''}}>
                    {{$vendorvendorlistData->vendorname}}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach($vendorlist as $vendorvendorlistData)
                <option value="{{$vendorvendorlistData->id}}">
                    {{ $vendorvendorlistData->vendorname}} </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-3" id="Div2" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Vendor Name *</label>
            <input type="text" id="vendorname" name="vendorname" value="{{ $vendor->vendorname ??''}}" class="form-control"
                placeholder="Enter Vendor Name">
        </div>
    </div>
    <div class="col-1">
        <div class="form-group" style="margin-top: 36px;">
            <a id="Button1" class="add_button" title="Add field" onclick="switchVisible();"><img
                    src="{{ url('backEnd/image/add-icon.png')}}" /></a>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Email *</label>
            <input type="email" id="email" name="email" value="{{ $vendor->email ??''}}" class="form-control"
                placeholder="Enter Email">
         
        </div>
    </div>
    <div class="col-2">
        <div class="form-group">
            <label class="font-weight-600">Phone No *</label>
            <input type="text" id="phoneno" name="phoneno" value="{{ $vendor->phoneno ??''}}" class="form-control"
                placeholder="Enter Phone No">
        </div>
    </div>

    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Name As Per Bank *</label>
            <input type="text" name="benficiaryname" id="benficiaryname" value="{{ $vendor->benficiaryname ??''}}" class="form-control"
                placeholder="Enter Name As Per Bank">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Name *</label>
            <input type="text" id="bankname" name="bankname" value="{{ $vendor->bankname ??''}}" class="form-control"
                placeholder="Enter Bank Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">IFSC Code *</label>
            <input type="text" id="ifsccode" name="ifsccode" value="{{ $vendor->ifsccode ??''}}" class="form-control"
                placeholder="Enter IFSC Code">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bank Account Number *</label>
            <input type="text" id="accountnumber" name="accountnumber" value="{{ $vendor->accountnumber ??''}}" class="form-control"
                placeholder="Enter Bank Account Number">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Gst No *</label>
            <input type="text" id="gstno" name="gstno" value="{{ $vendor->gstno ??''}}" class="form-control"
                placeholder="Enter Gst No">
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Vendor Link Send *</label>
            <select required name="linksend" class="form-control">
                <!--placeholder-->
                @if(Request::is('vendor/*/edit')) >
                @if($vendor->linksend=='1')
                <option value="1">Yes </option>
                <option value="2">No </option>

                @elseif($vendor->linksend=='2')
                <option value="2">No </option>
                <option value="1">Yes</option>

                @endif
                @else
                <option value="">Please Select One </option>
                <option value="1">Yes </option>
                <option value="2">No </option>

                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Vendor Type *</label>
            <select required name="type" class="form-control">
                <!--placeholder-->
                @if(Request::is('vendor/*/edit')) >
                @if($vendor->type=='1')
                <option value="1">Temporary </option>
                <option value="2">Regular </option>
                <option value="3">Recurring </option>

                @elseif($vendor->type=='2')
                <option value="2">Regular </option>
                <option value="1">Temporary</option>
                <option value="3">Recurring </option>
                
                @elseif($vendor->type=='3')
                <option value="3">Recurring </option>
                <option value="2">Regular </option>
                <option value="1">Temporary</option>
            

                @endif
                @else
                <option value="">Please Select One </option>
                <option value="1">Temporary </option>
                <option value="2">Regular </option>
                <option value="3">Recurring </option>


                @endif
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Item Name</label>
            <input type="text" name="itemname" class="form-control" placeholder="Enter Item Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Bill ( Attachment) </label>
            <input type="file" name="bill" class="form-control" placeholder="Enter Phone No">
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">PAN No.</label>
            <input type="text" name="pan" class="form-control" placeholder="Enter Item Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">PAN ( Attachment )</label>
            <input type="file" name="panfile" class="form-control" placeholder="Enter Phone No">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Adhar No.</label>
            <input type="text" name="adhar" class="form-control" placeholder="Enter Item Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Adhar ( Attachment )</label>
            <input type="file" name="adharfile" class="form-control" placeholder="Enter Phone No">
        </div>
    </div>
    
</div>
<div class="row row-sm">
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Amount </label>
        <input type="text"  name="amount" value="{{ $vendor->amount ??''}}" class="form-control"
            placeholder="Enter Amount">
    </div>
</div>
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600"> Approver *</label>
        <select class="language form-control" id="key" name="approver">

            <option>Please Select One</option>
            @foreach($teammember as $teammemberData)
            <option value="{{$teammemberData->id}}" @if(!empty($store->
                financial) && $store->
                financial==$teammemberData->id) selected @endif>
                {{ $teammemberData->title->title ??''}}. {{ $teammemberData->team_member }} (
                {{ $teammemberData->role->rolename }} )</option>
            @endforeach
        </select>
    </div>
</div>
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('vendor') }}">
        Cancel</a>

</div>

<script>
    function switchVisible() {
        if (document.getElementById('Div1')) {

            if (document.getElementById('Div1').style.display == 'none') {
                document.getElementById('Div1').style.display = 'block';
                document.getElementById('Div2').style.display = 'none';
            } else {
                document.getElementById('Div1').style.display = 'none';
                document.getElementById('Div2').style.display = 'block';
            }
        }
    }

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        $('#vendor').on('change', function () {
            var category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('vendorlist/fetch') }}",
                data: "category_id=" + category_id,
                success: function (response) {
                    $("#vendorname").val(response.vendorname);
                    $("#email").val(response.email);
					 $("#phoneno").val(response.phoneno);
                    $("#benficiaryname").val(response.benficiaryname);
                    $("#bankname").val(response.bankname);
                    $("#ifsccode").val(response.ifsccode);
                    $("#accountnumber").val(response.accountnumber);
                    $("#gstno").val(response.gstno);


                },
                error: function () {

                },
            });
        });
    });
    </script>
{{-- *  --}}
{{--  Start Hare  --}}
{{-- *  --}}
{{--  Start Hare  --}}
{{-- *  --}}
{{--  Start Hare  --}}
{{-- * regarding filter functionality   --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        // Common function to render table rows
        function renderTableRows(data) {
            $('table tbody').html("");
            $('#clickExcell').show();

            if (data.length === 0) {
                $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
            } else {
                $.each(data, function(index, item) {
                    var url = '/applyleave/' + item.id;
                    var createdAt = formatDate(item.created_at);
                    var fromDate = formatDate(item.from);
                    var toDate = formatDate(item.to);
                    var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                        60 * 1000)) + 1;

                    $('table tbody').append('<tr>' +
                        '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                        '<td>' + createdAt + '</td>' +
                        '<td>' + getStatusBadge(item.status) + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + fromDate + ' to ' + toDate + '</td>' +
                        '<td>' + holidays + '</td>' +
                        '<td>' + item.approvernames + '</td>' +
                        '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                        '</tr>');
                });
            }
        }

        // Common function to export data to Excel
        function exportToExcel(data) {
            const filteredData = data.map(item => {
                const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                    1000)) + 1;
                const createdAt = formatDate(item.created_at);
                const fromDate = formatDate(item.from);
                const toDate = formatDate(item.to);

                return {
                    Employee: item.team_member,
                    Date_of_Request: createdAt,
                    status: getStatusText(item.status),
                    Leave_Type: item.name,
                    from: fromDate,
                    to: toDate,
                    Days: holidays,
                    Approver: item.approvernames,
                    Reason_for_Leave: item.reasonleave
                };
            });

            const ws = XLSX.utils.json_to_sheet(filteredData);
            const headerCellStyle = {
                font: {
                    bold: true
                }
            };

            ws['!cols'] = [{
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 15
                },
                {
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 30
                }
            ];

            Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                ws[key].s = headerCellStyle;
            });

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
            const excelBuffer = XLSX.write(wb, {
                bookType: "xlsx",
                type: "array"
            });
            const dataBlob = new Blob([excelBuffer], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
        }

        // Common function to format date
        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Common function to get status text
        function getStatusText(status) {
            return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
        }

        // Common function to get status badge
        function getStatusBadge(status) {
            if (status === 0) {
                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
            } else if (status === 1) {
                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
            } else if (status === 2) {
                return '<span class="badge badge-danger">Rejected</span>';
            } else {
                return '';
            }
        }

        // Function to handle status change
        function handleStatusChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            $('#clickExcell').hide();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();

                    // Remove previus attachment on download button 
                    $('#clickExcell').off('click');

                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                    $('#clickExcell').show();
                }
            });
        }

        // Function to handle leave type change
        function handleLeaveTypeChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            $('#clickExcell').hide();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    // Remove previus attachment on download button 
                    $('#clickExcell').off('click');
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                    $('#clickExcell').show();
                }
            });
        }

        // Function to handle employee change
        function handleEmployeeChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            $('#clickExcell').hide();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    // Remove previus attachment on download button 
                    $('#clickExcell').off('click');
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                    $('#clickExcell').show();
                }
            });
        }

        // Function to handle leave period end date change
        function handleleaveperiodendChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            $('#clickExcell').hide();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    // Remove previus attachment on download button 
                    $('#clickExcell').off('click');
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                    $('#clickExcell').show();
                }
            });
        }

        //  end Request Date end date wise
        function handleEndRequestDateChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            $('#clickExcell').hide();


            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    $('#clickExcell').off('click');
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                    $('#clickExcell').show();
                }
            });
        }

        // Event handlers
        $('#employee1').change(handleEmployeeChange);
        $('#leave1').change(handleLeaveTypeChange);
        $('#status1').change(handleStatusChange);
        $('#end1').change(handleEndRequestDateChange);
        $('#endperiod1').change(handleleaveperiodendChange);
    });
</script>
{{--  Start Hare  --}}



{{-- *  --}}
{{--  Start Hare  --}}
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-info" onclick="saveForm()">Save Draft</button>
    <button type="submit" class="btn btn-primary" onclick="saveForm2()">Save</button>
    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?');">Send</button>
</div>


<script>
    function saveForm() {
        document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
    }

    function saveForm2() {
        var template = $('#template').val();
        if (template == '') {
            alert('Please Select Confirmation Type');
        } else {
            //   document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
            var url = "{{ url('/maildraft') }}";

            // Perform the URL hit
            window.location.href = url;

        }
    }
</script>

<script>
    function saveForm() {
        document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
    }

    function saveForm2() {
        var type = $('#template').val();
        //   var clientid = $("[name='clientid']").val();
        if (type == '') {
            alert('Please Select Confirmation Type');
        } else {
            var url = "{{ url('/mailsave') }}";
            // Append type and clientid to the URL
            //   url += "?type=" + type + "&clientid=" + clientid;
            url += "?type=" + type;
            window.location.href = url;

        }
    }

    function saveForm2() {
        document.getElementById('detailsForm').action = "{{ url('/finalsave') }}";
    }
</script>
{{-- * regarding form  --}}
{{--  Start Hare  --}}

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" onclick="saveForm()">Save</button>
    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?');">Send</button>
</div>
<script>
    function saveForm() {
        document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
    }

    //   function sendMail() {
    //       document.getElementById('detailsForm').action = "{{ url('/confirmation/mail') }}";
    //   }
</script>
{{-- *  --}}
{{--  Start Hare  --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function() {
        $('#template').on('change', function() {
            var template_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('confirmationtem') }}",
                data: "template_id=" + template_id,
                success: function(response) {
                    var desc = response.description;

                    // Check if "desc" exists in the response and is not empty before setting
                    if (desc && desc.trim() !== "") {
                        $('#summernote').summernote('code',
                            desc); // Update Summernote content
                    }
                },
                error: function() {

                },
            });
            $('#subcentre_id').html('');
        });
    });
</script>
{{-- *  --}}
{{--  Start Hare  --}}
<script>
    function saveForm() {
        if (confirm('Are you sure?')) {
            document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
            return true; // Form will be submitted
        }
        return false; // Form submission canceled
    }
    //   function sendMail() {
    //       document.getElementById('detailsForm').action = "{{ url('/confirmation/mail') }}";
    //   }
</script>

<script>
    $(document).on('change', '[id^=partner]', function() {
        var partnerValue = $(this).val();
        var index = $(this).attr('id').slice(-1);
        if (partnerValue != "" && partnerValue != "Select Partner") {
            $('.workItem' + index).attr('required', true);
            $('.location' + index).attr('required', true);
            $('.hour' + index).attr('required', true);
        } else {
            $('.workItem' + index).attr('required', false);
            $('.location' + index).attr('required', false);
            $('.hour' + index).attr('required', false);
        }
    });
</script>
{{-- * regarding replace function /regarding text replace function --}}
{{--  Start Hare  --}}

<script>
    function handleClientChange(clientId) {
        $('#' + clientId).on('change', function() {
            var cid = $(this).val();
            var datepickers = $('#datepickers').val();

            if (cid == 33) {
                var location = 'N/A';
                var workitem = 'N/A';
                var time = 0;

                // clientId me hai client,client1,client2,client3,client4
                // Extract the number from the client ID like 1,2,3,4
                //   var clientNumber = parseInt(clientId.replace('client', ''));
                var clientNumber = clientId.replace('clien', '');
                alert(clientNumber);
                if (!isNaN(clientNumber)) {
                    // Check if clientNumber is a valid number
                    $('.workitemnvalue' + clientNumber).val(workitem);
                    $('.locationvalue' + clientNumber).val(location);
                    $('#totalhours').val(time);
                    $('#hour' + (clientNumber + 1)).prop('readonly', true);
                } else {
                    // Default behavior for clientId 'client'
                    $('.workitemnvalue').val(workitem);
                    $('.locationvalue').val(location);
                    $('#totalhours').val(time);
                    $("#hour1").prop("readonly", true);
                }
            }

            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: {
                    cid: cid,
                    datepickers: datepickers
                },
                success: function(res) {
                    $('#' + clientId.replace('client', 'assignment')).html(res);
                },
                error: function() {},
            });
        });
    }
</script>
{{-- * sweech case  --}}
{{--  Start Hare  --}}
<script>
    switch (clientId) {
        case 'client':
            $('.workitemnvalue').val(workitem);
            $('.locationvalue').val(location);
            $("#hour1").prop("readonly", true);
            break;
        case 'client1':
            $('.workitemnvalue1').val(workitem);
            $('.locationvalue1').val(location);
            $("#hour2").prop("readonly", true);
            break;
        case 'client2':
        case 'client3':
        case 'client4':
            $('.workitemnvalue1').val(workitem);
            $('.locationvalue1').val(location);
            $("#hour1").prop("readonly", true);
            break;
        default:
            break;
    }
</script>
{{-- * selecteor / regarding selector/ regarding selecter / regarding jquery selector / regarding jquery selecter / regarding target --}}
{{--  Start Hare  --}}
{{-- for testing 
https://www.w3schools.com/jquery/trysel.asp?password=password&rr=on --}}
<script>
    if (cid == 33) {
        var location = 'N/A';
        var workitem = 'N/A';
        var time = 0;

        $('.workitemnvalue1').val(workitem);
        $('.locationvalue1').val(location);
        $('#totalhours').val(time);
        $("#hour1").prop("readonly", true);
    }

    if (cid == 33) {
        var location = 'leaave';
        var workitem = 'leaaveq';
        $("p").hide();
        $("[name='workitem']").val(workitem);
        $("[name='location']").val(workitem);
        $("#Lastname")
        $(".intro")
        $(".intro, #Lastname")
        $("h1")
        $("h1, p")
        $("p:first")
        $("p:last")
        $("tr:even")
        $("tr:odd")
        $("p:first-child")
        $("p:first-of-type")
        $("p:last-child")
        $("p:last-of-type")
        $("li:nth-child(1)")
        $("li:nth-last-child(1)")
        $("li:nth-of-type(2)")
        $("li:nth-last-of-type(2)")
        $("b:only-child")
        $("h3:only-of-type")
        $("div > p")
        $("div p")
        $("ul + p")
        $("ul ~ table")
        $("ul li:eq(0)")
        $("ul li:gt(0)")
        $("ul li:lt(2)")
        $(":header")
        $(":header:not(h1)")
        $(":animated")
        $(":focus")
        $(":contains(Duck)")
        $("div:has(p)")
        $(":empty")
        $(":parent")
        $("p:hidden")
        $("table:visible")
        $(":root")
        $("p:lang(it)")
        $("[id]")
        $("[id=my-Address]")
        $("p[id!=my-Address]")
        $("[id$=ess]")
        $("[id|=my]")
        $("[id^=L]")
        $("[title~=beautiful]")
        $("[id*=s]")
        $(":input")
        $(":text")
        $(":password")
        $(":radio")
        $(":checkbox")
        $(":submit")
        $(":reset")
        $(":button")
        $(":image")
        $(":file")
        $(":enabled")
        $(":disabled")
        $(":selected")
        $(":checked")
        $("*")
        $('[id^=partner]')
    }
</script>

<pre>
    | Selector             | Example                    | Selects                                                |
|----------------------|----------------------------|--------------------------------------------------------|
| *                    | $("*")                     | All elements                                           |
| #id                  | $("#lastname")             | The element with id="lastname"                         |
| .class               | $(".intro")                | All elements with class="intro"                        |
| .class, .class       | $(".intro, .demo")         | All elements with the class "intro" or "demo"          |
| element              | $("p")                     | All <p> elements                                       |
| el1, el2, el3        | $("h1, div, p")            | All <h1>, <div>, and <p> elements                      |
| :first               | $("p:first")               | The first <p> element                                  |
| :last                | $("p:last")                | The last <p> element                                   |
| :even                | $("tr:even")               | All even <tr> elements                                 |
| :odd                 | $("tr:odd")                | All odd <tr> elements                                  |
| :first-child         | $("p:first-child")         | All <p> elements that are the first child of their parent |
| :first-of-type       | $("p:first-of-type")       | All <p> elements that are the first <p> element of their parent |
| :last-child          | $("p:last-child")          | All <p> elements that are the last child of their parent |
| :last-of-type        | $("p:last-of-type")        | All <p> elements that are the last <p> element of their parent |
| :nth-child(n)        | $("p:nth-child(2)")        | All <p> elements that are the 2nd child of their parent |
| :nth-last-child(n)   | $("p:nth-last-child(2)")   | All <p> elements that are the 2nd child of their parent, counting from the last child |
| :nth-of-type(n)      | $("p:nth-of-type(2)")      | All <p> elements that are the 2nd <p> element of their parent |
| :nth-last-of-type(n) | $("p:nth-last-of-type(2)") | All <p> elements that are the 2nd <p> element of their parent, counting from the last child |
| :only-child          | $("p:only-child")          | All <p> elements that are the only child of their parent |
| :only-of-type        | $("p:only-of-type")        | All <p> elements that are the only child, of its type, of their parent |
| parent > child       | $("div > p")               | All <p> elements that are a direct child of a <div> element |
| parent descendant    | $("div p")                 | All <p> elements that are descendants of a <div> element |
| element + next       | $("div + p")               | The <p> element that are next to each <div> elements   |
| element ~ siblings   | $("div ~ p")               | All <p> elements that appear after the <div> element   |
| :eq(index)           | $("ul li:eq(3)")           | The fourth element in a list (index starts at 0)      |
| :gt(no)              | $("ul li:gt(3)")           | List elements with an index greater than 3            |
| :lt(no)              | $("ul li:lt(3)")           | List elements with an index less than 3               |
| :not(selector)       | $("input:not(:empty)")     | All input elements that are not empty                  |
| :header              | $(":header")               | All header elements <h1>, <h2>, ...                    |
| :animated            | $(":animated")             | All animated elements                                  |
| :focus               | $(":focus")                | The element that currently has focus                   |
| :contains(text)      | $(":contains('Hello')")    | All elements which contains the text "Hello"          |
| :has(selector)       | $("div:has(p)")            | All <div> elements that have a <p> element            |
| :empty               | $(":empty")                | All elements that are empty                            |
| :parent              | $(":parent")               | All elements that are a parent of another element      |
| :hidden              | $("p:hidden")              | All hidden <p> elements                                |
| :visible             | $("table:visible")         | All visible tables                                     |
| :root                | $(":root")                 | The document's root element                            |
| :lang(language)      | $("p:lang(de)")            | All <p> elements with a lang attribute value starting with "de" |
| [attribute]          | $("[href]")                | All elements with a href attribute                     |
| [attribute=value]    | $("[href='default.htm']")  | All elements with a href attribute value equal to "default.htm" |
| [attribute!=value]   | $("[href!='default.htm']") | All elements with a href attribute value not equal to "default.htm" |
| [attribute$=value]   | $("[href$='.jpg']")        | All elements with a href attribute value ending with ".jpg" |
| [attribute|=value]   | $("[title|='Tomorrow']")   | All elements with a title attribute value equal to 'Tomorrow', or starting with 'Tomorrow' followed by a hyphen |
| [attribute^=value]   | $("[title^='Tom']")        | All elements with a title attribute value starting with "Tom" |
| [attribute~=value]   | $("[title~='hello']")      | All elements with a title attribute value containing the specific word "hello" |
| [attribute*=value]   | $("[title*='hello']")      | All elements with a title attribute value containing the word "hello" |
| :input               | $(":input")                | All input elements                                     |
| :text                | $(":text")                 | All input elements with type="text"                    |
| :password            | $(":password")             | All input elements with type="password"                |
| :radio               | $(":radio")                | All input elements with type="radio"                   |
| :checkbox            | $(":checkbox")             | All input elements with type="checkbox"                |
| :submit              | $(":submit")               | All input elements with type="submit"                  |
| :reset               | $(":reset")                | All input elements with type="reset"                   |
| :button              | $(":button")               | All input elements with type="button"                  |
| :image               | $(":image")                | All input elements with type="image"                   |
| :file                | $(":file")                 | All input elements with type="file"                    |
| :enabled             | $(":enabled")              | All enabled input elements                             |
| :disabled            | $(":disabled")             | All disabled input elements
| :selected            | $(":selected")             | All selected input elements
| :checked             | $(":checked")              | All checked input elements
| like                 | $('[id^=partner]')         |  targets all elements whose id attribute starts with the string "partner".it would match elements like <div id="partner1">, <input id="partnerABC">, <select id="partner_xyz">, and so on.
</pre>


{{-- * val function / insert value / regarding val function   --}}
{{--  Start Hare  --}}
<script>
    if (cid == 33) {
        //   alert(cid);
        var location = 'hi';
        document.getElementById("totalhours").value = location;
    }
    if (cid == 33) {
        alert(cid);
        var location = 'hi';
        $('#key').val(location);
    }
</script>
{{-- *  --}}

<script>
    //   $(document).ready(function() {
    $("#timesheet-form").submit(function(e) {
        // Check if the "Client Name" dropdown is selected
        if ($("#client1").val() != "Select Client" && $("#client1").val() != "") {
            // If a client is selected, make the following fields required
            $("#assignment1").prop("required", true);
            $("#partner1").prop("required", true);
            $("#assignment2").prop("required", true);
        }
    });
</script>
{{--  Start Hare  --}}
{{-- * add html dynamically / regarding dynamically html --}}
{{--  Start Hare  --}}
{{-- html --}}
<div class="row row-sm">
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
                <select class="form-control key refreshoption" name="assignment_id[]" id="assignment1">
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
                <select class="language form-control refreshoption" id="partner1" name="partner[]">
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Work Item</label>
                <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                    class="form-control key workItem1 refresh" rows="2"></textarea>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="font-weight-600" style="width:100px;">Location *</label>
                <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                    class="form-control key location1 refresh">
            </div>
        </div>

        <div class="col-1">
            <div class="form-group">
                <label class="font-weight-600">Hour</label>
                <input type="number" class="form-control hour1 refresh" id="hour2" min="0" name="hour[]"
                    oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                    value="0" step="1">

            </div>
        </div>
        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>
    <div class="col-1">
        <div class="form-group" style="margin-top: 36px;">
            <a href="javascript:void(0);" class="add_button" title="Add field"><img
                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
        </div>
    </div>
</div>

{{-- ! ok done --}}
<script>
    $(document).ready(function() {
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 2;

        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter

                var fieldHTML = `<div class="row row-sm">
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Client Name *</label>
                        <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                            <option value="">Select Client</option>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}">
                                    {{ $clientData->client_name }} ({{ $clientData->client_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Assignment Name *</label>
                        <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Partner *</label>
                        <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600" style="width:100px;">Work Item *</label>
                        <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600" style="width:100px;">Location *</label>
                        <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label class="font-weight-600">Hour *</label>
                        <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                        <span style="font-size: 10px;margin-left: 10px;"></span>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group" style="margin-top: 36px;">
                        <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                    </div>
                </div>
            </div>`;

                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>

<script>
    $(document).ready(function() {
        var maxField = 4;
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var x = 1;

        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                var fieldHTML = `<div class="row row-sm">
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Client Name *</label>
                      <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                          <option value="">Select Client</option>
                          @foreach ($client as $clientData)
                              <option value="{{ $clientData->id }}">
                                  {{ $clientData->client_name }} ({{ $clientData->client_code }})
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Assignment Name *</label>
                      <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Partner *</label>
                      <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Work Item *</label>
                      <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Location *</label>
                      <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group">
                      <label class="font-weight-600">Hour *</label>
                      <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                      <span style="font-size: 10px;margin-left: 10px;"></span>
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group" style="margin-top: 36px;">
                      <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                  </div>
              </div>
          </div>`;

                $(wrapper).append(fieldHTML);
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('.row-sm').remove();
            x--;
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Function to handle change event for client select
        function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        $('#' + clientId.replace('client', 'assignment')).html(res);
                    },
                    error: function() {},
                });
            });
        }

        // Function to handle change event for assignment select
        function handleAssignmentChange(assignmentId) {
            $('#' + assignmentId).on('change', function() {
                var assignment = $(this).val();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "assignment=" + assignment,
                    success: function(res) {
                        $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                    },
                    error: function() {},
                });
            });
        }

        // Dynamically add client fields
        var maxField = 4;
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var x = 1;

        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                var fieldHTML = `<div class="row row-sm">
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Client Name *</label>
                      <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                          <option value="">Select Client</option>
                          @foreach ($client as $clientData)
                              <option value="{{ $clientData->id }}">
                                  {{ $clientData->client_name }} ({{ $clientData->client_code }})
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Assignment Name *</label>
                      <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Partner *</label>
                      <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Work Item *</label>
                      <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Location *</label>
                      <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group">
                      <label class="font-weight-600">Hour *</label>
                      <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                      <span style="font-size: 10px;margin-left: 10px;"></span>
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group" style="margin-top: 36px;">
                      <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                  </div>
              </div>
          </div>`;

                $(wrapper).append(fieldHTML);

                var clientId = 'client' + x;
                var assignmentId = 'assignment' + x;

                handleClientChange(clientId);
                handleAssignmentChange(assignmentId);
            }
        });

        handleClientChange('client');
        handleClientChange('client1');
        handleAssignmentChange('assignment');
        handleAssignmentChange('assignment1');
    });
</script>


<script>
    $(document).ready(function() {
        // Function to handle change event for client select
        function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        $('#' + clientId.replace('client', 'assignment')).html(res);
                    },
                    error: function() {},
                });
            });
        }

        // Function to handle change event for assignment select
        function handleAssignmentChange(assignmentId) {
            $('#' + assignmentId).on('change', function() {
                var assignment = $(this).val();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "assignment=" + assignment,
                    success: function(res) {
                        $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                    },
                    error: function() {},
                });
            });
        }

        // Dynamically add client fields
        var maxField = 4;
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var x = 1;
        var h = 2;

        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                h++;
                var fieldHTML = `<div class="row row-sm">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name *</label>
                    <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                        <option value="">Select Client</option>
                        @foreach ($client as $clientData)
                            <option value="{{ $clientData->id }}">
                                {{ $clientData->client_name }} ({{ $clientData->client_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name *</label>
                    <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner *</label>
                    <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item *</label>
                    <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location *</label>
                    <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour *</label>
                    <input required type="number" class="form-control refresh" id="hour${h}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                    <span style="font-size: 10px;margin-left: 10px;"></span>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                </div>
            </div>
        </div>`;

                $(wrapper).append(fieldHTML);

                var clientId = 'client' + x;
                var assignmentId = 'assignment' + x;

                handleClientChange(clientId);
                handleAssignmentChange(assignmentId);
            }
        });

        handleClientChange('client');
        handleClientChange('client1');
        handleAssignmentChange('assignment');
        handleAssignmentChange('assignment1');
    });

    function calculateTotal() {
        var totalSum = 0;
        $('input[name^="hour"]').each(function() {
            totalSum += parseInt($(this).val()) || 0;
        });

        document.getElementById("totalhours").value = totalSum;
    }
</script>


{{-- * Regarding date selection  --}}
{{--  Start Hare  --}}

<div class="col-md-5">
    <p style="float: right;color: white"><b>Select Date : </b> <input type="text" id="datepickers" name="date"
            value="{{ date('d-m-Y') }}" readonly></p>
</div>


<style>
    tr td:first-child a.ui-state-default {
        background-color: rgb(234, 0, 0) !important;
        color: white !important;
    }
</style>

<script>
    $(function() {
        var startDate = new Date();
        $("#datepickers").datepicker({
            maxDate: startDate,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
{{--  Start Hare  --}}
<style>
    td a.ui-state-default {
        background-color: green !important;
        color: white !important;
    }

    td span.ui-state-default {
        background-color: red !important;
        color: white !important;
    }
</style>

<script>
    $(function() {
        var startDate = new Date();
        var endDate = new Date();
        endDate.setDate(startDate.getDate() + 6);

        $("#datepickersq").datepicker({
            minDate: startDate,
            maxDate: endDate,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
{{--  Start Hare  --}}
<div class="col-md-5">
    <p style="float: right;color: white"><b>Select Date : </b> <input type="text" id="datepickersq"
            name="date" value="{{ date('d-m-Y') }}" readonly></p>
</div>

<script>
    $(function() {
        var startDate = new Date();
        var endDate = new Date();
        endDate.setDate(startDate.getDate() + 6);

        $("#datepickersq").datepicker({
            minDate: startDate,
            maxDate: endDate,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
{{--  Start Hare  --}}
<script>
    $(function() {
        var startDate = new Date();
        var endDate = new Date();
        startDate.setDate(startDate.getDate() - 10);
        endDate.setDate(startDate.getDate() + 16);

        $("#datepickersq").datepicker({
            minDate: startDate,
            maxDate: endDate,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
{{--  Start Hare  --}}
<script>
    // Get the input element by its ID
    const startDateInput = document.getElementById('startdate');

    // Add an event listener to listen for changes in the input value
    startDateInput.addEventListener('change', function() {
        // Get the selected date value
        const selectedDate = new Date(this.value);

        // Format the date to 'yyyy-mm-dd'
        const year = selectedDate.getFullYear();
        const month = ('0' + (selectedDate.getMonth() + 1)).slice(-2); // Add leading zero if needed
        const day = ('0' + selectedDate.getDate()).slice(-2); // Add leading zero if needed

        // Update the input value with the formatted date
        this.value = year + '-' + month + '-' + day;
    });
</script>
{{--  Start Hare  --}}
{{-- regarding date formate  --}}
<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });
    $(function() {
        $("#datepickers").datepicker({
            maxDate: new Date,
            dateFormat: 'dd-mm-yy'
        });
    });
</script>



{{-- * Remove extra space  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 14,
            dom: 'Bfrtip',
            "order": [
                // [2, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet Save',
                    // remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 10) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },

                    //  Remove extra space 
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        // remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ')
                                .trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{-- * two table on one page then table implement / column modify / column modification --}}
{{--  Start Hare  --}}


<script>
    $(document).ready(function() {
        $('#myTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'My timesheet Request',
                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },
                },
                'colvis'
            ]
        });

        $('#teamTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Team timesheet Request',

                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },

                },
                'colvis'
            ]
        });
    });
</script>
{{--  Start Hare  --}}
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }

    #teamTimesheetTable {
        width: 100% !important;

    }
</style>
<script>
    $(document).ready(function() {
        $('#myTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet_Download',

                },
                'colvis'
            ]
        });

        $('#teamTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet_Download',

                },
                'colvis'
            ]
        });
    });
</script>

{{-- * hide button  --}}
{{--  start hare --}}
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            // 'l' for the length menu
            dom: 'Bfrtip',
            // "order": [
            //     [0, "ASC"]
            // ],
            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Team List',
                    },
                    'colvis'
                ]
            @else
                buttons: []
            @endif
        });
    });
</script>

{{--  start har --}}

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            "dom": '1Bfrtip',
            "order": [
                [1, "desc"]
            ],

            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>
{{--  start har --}}
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }
</style>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                // 'l' for the length menu
                dom: 'lBfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Team List',
                    },
                    'colvis'
                ]
            @else
                buttons: []
            @endif
        });
    });
</script>

{{-- * accending order on date   --}}

<td> <span style="display: none;">
        {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
</td>
{{-- understanding code --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [],
            searching: false,
            @if (Auth::user()->role_id == 11 ||
                    Request::is('adminsearchtimesheet') ||
                    (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                columnDefs: [{
                    targets: [1, 2, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @else
                columnDefs: [{
                    targets: [1, 3, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @endif
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet_Download',
                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // If the data is a date, extract the date without HTML tags
                                if (column === 2) {
                                    // data = <span style="display: none;"> 2024-02-26</span>26-02-2024
                                    var cleanedText = $(data).text().trim();
                                    //   2024-02-26
                                    var dateParts = cleanedText.split(
                                        '-');
                                    //   20240226
                                    //   2,02,40,226
                                    // Assuming the date format is yyyy-mm-dd
                                    //   dateParts.length = 3 hai 
                                    if (dateParts.length === 3) {
                                        //   return dateParts[2] + '-' + dateParts[1] + '-' +
                                        //       dateParts[0];
                                        //  for testing
                                        //   return dateParts[0];
                                        //   dateParts[2]= 26
                                        //   dateParts[1]= 02
                                        //   dateParts[0]= 2024
                                    }
                                }
                                return data;
                            }
                        }
                    },
                    //   set width in excell
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // set column width
                        $('col', sheet).eq(0).attr('width', 15);
                        $('col', sheet).eq(1).attr('width', 15);
                        $('col', sheet).eq(3).attr('width', 30);
                        $('col', sheet).eq(4).attr('width', 30);
                        $('col', sheet).eq(5).attr('width', 30);
                        $('col', sheet).eq(6).attr('width', 30);
                        $('col', sheet).eq(7).attr('width', 30);

                        // remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{-- clean code  --}}

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [],
            searching: false,
            @if (Auth::user()->role_id == 11 ||
                    Request::is('adminsearchtimesheet') ||
                    (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                columnDefs: [{
                    targets: [1, 2, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @else
                columnDefs: [{
                    targets: [1, 3, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @endif
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet_Download',

                    //   remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // If the data is a date, extract the date without HTML tags
                                if (column === 2) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                return data;
                            }
                        }
                    },

                    //   set width in excell
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        // set column width
                        $('col', sheet).eq(0).attr('width', 15);
                        $('col', sheet).eq(1).attr('width', 15);
                        $('col', sheet).eq(3).attr('width', 30);
                        $('col', sheet).eq(4).attr('width', 30);
                        $('col', sheet).eq(5).attr('width', 30);
                        $('col', sheet).eq(6).attr('width', 30);
                        $('col', sheet).eq(7).attr('width', 30);

                        // remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{-- * on click button  --}}
<div class="col-1">
    <div class="form-group" style="margin-top: 36px;">
        <a href="javascript:void(0);" class="add_button" title="Add field"><img
                src="{{ url('backEnd/image/add-icon.png') }}" /></a>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 1;
        var fieldHTML = `
        <div class="row row-sm">
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Client Name</label>
              <select class="language form-control refresh" name="client_id[]" id="client4"
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
              <select class="form-control key refreshoption" name="assignment_id[]" id="assignment4">
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
              <select class="language form-control refreshoption" id="partner4" name="partner[]">
              </select>
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600" style="width:100px;">Work Item</label>
              <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                  class="form-control key workItem4 refresh" rows="2"></textarea>
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600" style="width:100px;">Location *</label>
              <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                  class="form-control key Location4 refresh">
          </div>
      </div>

      <div class="col-1">
          <div class="form-group">
              <label class="font-weight-600">Hour</label>
              <input type="number" class="form-control hour4 refresh" id="hour5" min="0"
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
`;

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>

{{-- * regarding pure javascript / regarding javascript   --}}

<script type="text/javascript">
    function sum() {

        var hour1 = document.getElementById('hour1').value;
        // alert(hour1);
        var hour2 = document.getElementById('hour2').value;
        var hour3 = document.getElementById('hour3').value;
        var hour4 = document.getElementById('hour4').value;
        var hour5 = document.getElementById('hour5').value;
        //  alert(hour2);
        var result = parseFloat(hour1) + parseFloat(hour2) + parseFloat(hour3) + parseFloat(hour4) + parseFloat(
            hour5);
        //alert(result);
        if (!isNaN(result)) {
            document.getElementById('totalhours').value = result;
        }
    }
</script>
{{-- * regarding option tag   --}}

<script>
    $(function() {
        $('#datepickers').on('change', function() {
            var refreshpage = $('.refresh');
            refreshpage.val('');
            $('.refreshoption option').remove();
        });
    });
</script>

{{-- * navbar / regarding navbar/ regarding url  --}}

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuItems = document.querySelectorAll('nav.sidebar-nav li a');
        const currentUrl = document.URL;

        menuItems.forEach((link) => {
            const href = link.href;

            if (href === currentUrl) {
                $(link).attr("aria-expanded", "true");

                const parent = link.closest("li");
                $(parent).addClass("mm-active").css({
                    "background-color": "#37a000",
                    "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                });

                const secondLevel = parent.querySelector("ul.nav-second-level");
                const thirdLevel = parent.querySelector("ul.nav-third-level");

                if (secondLevel) {
                    const parentMenu = secondLevel.closest("li");
                    $(parentMenu).addClass("mm-active").css({
                        "background-color": "#37a000",
                        "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                    });
                    secondLevel.classList.add("mm-show");
                }

                if (thirdLevel) {
                    $(thirdLevel).addClass("mm-show");

                    const secondLevel = thirdLevel.closest("ul.nav-second-level");
                    const parentMenu = secondLevel.closest("li");
                    $(parentMenu).addClass("mm-active").css({
                        "background-color": "#37a000",
                        "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                    });
                    secondLevel.classList.add("mm-show");
                }
            }
        });
    });
</script>


{{-- <script>
    $(document).ready(function() {
        var currentUrl = window.location.href;

        $('.metismenu li a').each(function() {
            var $this = $(this);
            var href = $this.prop('href');

            if (href === currentUrl) {
                console.log('Match found! Adding mm-active2 class.');
                $this.addClass('mm-active2');
            }
        });
    });
</script> --}}


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const menuItems = document.querySelectorAll('nav.sidebar-nav li a');
        const currentUrl = document.URL;

        menuItems.forEach((link) => {
            const href = link.href;

            if (href === currentUrl) {
                link.setAttribute("aria-expanded", "true");

                const parent = link.closest("li");
                parent.classList.add("mm-active");
                parent.style.backgroundColor = "green";
                parent.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";

                const secondLevel = parent.querySelector("ul.nav-second-level");
                const thirdLevel = parent.querySelector("ul.nav-third-level");

                if (secondLevel) {
                    const parentMenu = secondLevel.closest("li");
                    parentMenu.classList.add("mm-active");
                    parentMenu.style.backgroundColor = "green";
                    parentMenu.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";
                    secondLevel.classList.add("mm-show");
                }

                if (thirdLevel) {
                    thirdLevel.classList.add("mm-show");

                    const secondLevel = thirdLevel.closest("ul.nav-second-level");
                    const parentMenu = secondLevel.closest("li");
                    parentMenu.classList.add("mm-active");
                    parentMenu.style.backgroundColor = "green";
                    parentMenu.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";
                    secondLevel.classList.add("mm-show");
                }
            }
        });
    });
</script>


{{-- * php in javascript  / regarding php  --}}

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            searching: false,

            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                columnDefs: [{
                    targets: [1, 2, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @else
                columnDefs: [{
                    targets: [1, 3, 4, 5, 6, 7, 8, 9],
                    orderable: false
                }],
            @endif

            buttons: [{
                    extend: 'excelHtml5',
                    //   enabled: false,
                    filename: 'Timesheet_Download',
                    exportOptions: {
                        columns: ':visible'
                    },

                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        //   set column width
                        $('col', sheet).eq(0).attr('width', 15);
                        $('col', sheet).eq(1).attr('width', 15);
                        $('col', sheet).eq(3).attr('width', 30);
                        $('col', sheet).eq(4).attr('width', 30);
                        $('col', sheet).eq(5).attr('width', 30);
                        $('col', sheet).eq(6).attr('width', 30);
                        $('col', sheet).eq(7).attr('width', 30);
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#category7').change(function() {
            var search7 = $(this).val();
            var search4 = $('#category4').val();
            var search1 = $('#category1').val();

            var filterUrl = '';
            @if (Auth::user()->role_id == 13 && Request::is('timesheet/teamlist'))
                filterUrl = '/filter-patnerteam';
            @elseif (Auth::user()->role_id == 11)
                filterUrl = '/filter-dataadmin';
            @endif

            // Send an AJAX request to fetch filtered data based on the selected partner
            $.ajax({
                type: 'GET',
                //   url: '/filter-dataadmin',
                url: filterUrl,
                data: {
                    teamname: search7,
                    partnersearch: search1,
                    totalhours: search4
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html(""); // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/weeklylist?id=' + item.id +
                                '&teamid=' + item.teamid +
                                '&partnerid=' + item.partnerid +
                                '&startdate=' + item.startdate +
                                '&enddate=' + item.enddate;

                            // Format created_at date
                            var formattedDate = moment(item.created_at).format(
                                'DD-MM-YYYY');
                            var formattedTime = moment(item.created_at).format(
                                'hh:mm A');

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + item.week + '</td>' +
                                '<td>' + formattedDate + ' ' + formattedTime +
                                '</td>' +
                                '<td>' + item.totaldays + '</td>' +
                                '<td>' + item.totaltime + '</td>' +
                                //   '<td>' + item.partnername + '</td>' +
                                '</tr>');
                        });
                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });
    });
</script>
{{-- * regarding datatable / regarding filter / regarding basic class / regarding button  --}}



{{-- button name in text  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            layout: {
                topStart: 'buttons'
            },
            buttons: [{
                extend: 'copy',
                text: 'Copy to clipboard'
            }]
        });
    });
</script>


{{-- print button  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            layout: {
                topStart: 'buttons'
            },
            buttons: [{
                extend: 'print',
                name: 'print'
            }]
        });
    });
</script>

{{--  no need to script code only need jquery like  --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> --}}

<script>
    // no need to script code only need jquery like 
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            searching: false,
            buttons: [
                'colvis',
                'excel',
                'print'
            ]
        });
    });
</script>




{{-- remove basic class and add examplee id --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "order": [
                //   [2, "desc"]
            ],
            //   searching: false,
            columnDefs: [{
                targets: [0, 3, 4],
                orderable: false
            }],
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            //   dom: 'Bfrtip',
            //   dom: 'lrtip',
            //   dom: '<"wrapper"flipt>',
            dom: '<"top"i>rt<"bottom"flp><"clear">',
            //   dom: '<lf<t>ip>',
            //   dom: 'Blfrtip',
            "order": [
                [0, "desc"]
            ],
            buttons: []
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [], // Disable initial sorting

            columnDefs: [{
                    targets: [4],
                    orderable: false
                } // Disable sorting for the fifth column (Total Hour)
            ],

            //   buttons: [{
            //           extend: 'copyHtml5',
            //           exportOptions: {
            //               columns: [0, ':visible']
            //           }
            //       },
            //       {
            //           extend: 'excelHtml5',
            //   enabled: false,
            //           exportOptions: {
            //               columns: ':visible'
            //           }
            //       },
            //       {
            //           extend: 'pdfHtml5',
            //           exportOptions: {
            //               columns: [0, 1, 2, 5]
            //           }
            //       },
            //       'colvis'
            //   ]
        });
    });
</script>
{{-- *  --}}
<script>
    $(function() {
        $('#client1').on('change', function() {
            var cid = $(this).val();
            // alert(category_id);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "cid=" + cid,
                success: function(res) {
                    $('#assignment1').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
{{-- * form on submit / regarding submit   --}}
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }
</style>
{{-- ! 29-01-24 --}}
{{-- <script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                       //   enabled: false,
                    filename: 'Timesheet_Download',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Download',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    //   enabled: false,
                    filename: 'Timesheet_Download',
                    exportOptions: {
                        columns: ':visible'
                    },

                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        //   set column width
                        $('col', sheet).eq(0).attr('width', 15);
                        $('col', sheet).eq(1).attr('width', 15);
                        $('col', sheet).eq(3).attr('width', 30);
                        $('col', sheet).eq(4).attr('width', 30);
                        $('col', sheet).eq(5).attr('width', 30);
                        $('col', sheet).eq(6).attr('width', 30);
                        $('col', sheet).eq(7).attr('width', 30);
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },

                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Download',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>


{{-- validation for comparision date and block year for 4 disit --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startdate');
        var endDateInput = $('#enddate');

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
        });

        //   condition on submit
        $('form').submit(function(event) {
            var year = $('#year').val();
            var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();

            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearvalue = $('#year').val();
            if (year && startdate) {
                if (yearvalue != startyear) {
                    alert('Enter Start Date According Year');
                    startclear.val('');
                    // Prevent form submission
                    event.preventDefault();
                    // Exit the function
                    return;
                }
            }

            var endclear = $('#enddate');
            var endDateInput1 = $('#enddate').val();
            var endtDate = new Date(endDateInput1);
            var endyear = endtDate.getFullYear();
            var yearvalue = $('#year').val();
            if (year && enddate) {
                if (yearvalue != endyear) {
                    alert('Enter End Date According Year');
                    endclear.val('');
                    // Prevent form submission
                    event.preventDefault();
                    // Exit the function
                    return;
                }
            }

            if (year === "" && startdate === "" && enddate === "") {
                alert("Please select year.");
                event.preventDefault();
                return;
            }
            if (startdate !== "" && enddate === "") {
                alert("Please select End date.");
                event.preventDefault();
                return;
            }
            //   if (year !== "" && startdate !== "" && enddate === "") {
            //       alert("Please select End date.");
            //       event.preventDefault();
            //       return;
            //   }
            //   if (startdate !== "" && enddate !== "" && year === "") {
            //       alert("Please select Year.");
            //       event.preventDefault();
            //       return;
            //   }
        });
    });
</script>
{{-- *regarding form submit --}}
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
        });

        // Add form submission handling
        $('form').submit(function(event) {
            var year = $('#year').val();
            var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();

            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();

            var endclear = $('#enddate');
            var endDateInput1 = $('#enddate').val();
            var endDate = new Date(endDateInput1);
            var endyear = endDate.getFullYear();

            var yearvalue = $('#year').val();
            if (yearvalue != startyear || yearvalue != endyear) {
                alert('Enter Start and End Date According to the selected Year');
                startclear.val('');
                endclear.val('');
                event.preventDefault(); // Prevent form submission
                return; // Exit the function
            }

            if (year !== "" && startdate !== "" && enddate === "") {
                alert("Please select End date.");
                event.preventDefault();
                return;
            }

            if (year === "" || startdate === "" || enddate === "") {
                alert("Please select filter data.");
                event.preventDefault(); // Prevent form submission
            }
        });
    });
</script>

{{-- * regarding ajax --}}
{{-- * regarding ajax / table heading replace / regarding select box   --}}

{{-- data dynamically get in select box using ajax  --}}
<script>
    $(function() {

        $('#datepickers').on('change', function() {
            var timesheetdate = $(this).val();
            //   var datepickers = $('#datepickers').val();

            var refreshpage = $('.refresh');
            refreshpage.val('');
            $('.refreshoption option').remove();

            //   alert(datepickers);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                // url: '/timesheetrequest/reminder/list',
                data: {
                    timesheetdate: timesheetdate
                },
                success: function(res) {
                    $('#client').html(res);
                    $('#client1').html(res);
                    $('#client2').html(res);
                    $('#client3').html(res);
                    $('#client4').html(res);
                },
                error: function() {},
            });
        });
    });
</script>
{{-- data dynamically get in select box using ajax  --}}
<script>
    function handleClientChange(clientId) {
        $('#' + clientId).on('change', function() {
            var cid = $(this).val();
            var datepickers = $('#datepickers').val();
            var clientNumber = parseInt(clientId.replace('client', ''));

            if (cid == 33) {
                // Perform an AJAX request to fetch the holiday name based on the selected date
                $.ajax({
                    type: "get",
                    url: "{{ url('holidaysselect') }}", // Assuming this is the correct URL for fetching holiday name
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(response) {
                        // Assuming response contains the holiday name
                        var location = 'N/A';
                        var workitem = response.holidayName;
                        var time = 0;
                        //   console.log(response);

                        //   var assignmentSelect = $('.assignmentvalue');
                        //   assignmentSelect.empty();
                        //   assignmentSelect.append($('<option>', {
                        //       value: response.assignmentid,
                        //       text: response.assignmentname(response
                        //           .assignmentname / response
                        //           .assignmentgenerate_id)
                        //   }));





                        if (!isNaN(clientNumber)) {
                            var assignmentSelect = $('.assignmentvalue' + clientNumber);
                            assignmentSelect.empty();
                            assignmentSelect.append($('<option>', {
                                value: response.assignmentgenerate_id,
                                text: response.assignment_name + ' (' +
                                    response
                                    .assignmentname + '/' + response
                                    .assignmentgenerate_id + ')'
                            }));

                            var assignmentSelect = $('.partnervalue' + clientNumber);
                            assignmentSelect.empty();
                            assignmentSelect.append($('<option>', {
                                value: response.team_memberid,
                                text: response.team_member
                            }));

                            $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                'readonly', true);
                            $('.locationvalue' + clientNumber).val(location).prop(
                                'readonly', true);
                            $('#totalhours').val(time);
                            $('#hour' + (clientNumber + 1)).prop('readonly', true);
                        } else {

                            var assignmentSelect = $('.assignmentvalue');
                            assignmentSelect.empty();
                            assignmentSelect.append($('<option>', {
                                value: response.assignmentgenerate_id,
                                text: response.assignment_name + ' (' +
                                    response
                                    .assignmentname + '/' + response
                                    .assignmentgenerate_id + ')'
                            }));

                            var assignmentSelect = $('.partnervalue');
                            assignmentSelect.empty();
                            assignmentSelect.append($('<option>', {
                                value: response.team_memberid,
                                text: response.team_member
                            }));


                            $('.workitemnvalue').val(workitem).prop('readonly', true);
                            $('.locationvalue').val(location).prop('readonly', true);
                            $('#totalhours').val(time);
                            $("#hour1").prop("readonly", true);
                        }
                    },
                    error: function() {
                        // Handle error if AJAX request fails
                    }
                });
            } else {
                // Continue with the rest of your logic
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        // clear previous data 
                        if (!isNaN(clientNumber)) {
                            $('.assignmentvalue' + clientNumber).empty();
                            $('.partnervalue' + clientNumber).empty();
                            $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                                false);
                            $('.locationvalue' + clientNumber).val('').prop('readonly',
                                false);
                            $("#hour" + (clientNumber + 1)).prop("readonly", false);

                        } else {
                            $('.assignmentvalue').empty();
                            $('.partnervalue').empty();
                            $('.workitemnvalue').val('').prop('readonly', false);
                            $('.locationvalue').val('').prop('readonly', false);
                            $("#hour1").prop("readonly", false);
                        }

                        $('#' + clientId.replace('client', 'assignment')).html(res);

                    },
                    error: function() {
                        // Handle error if AJAX request fails
                    },
                });
            }
        });
    }
</script>

<script>
    //** status wise
    $('#status1').change(function() {
        var status1 = $(this).val();
        var employee1 = $('#employee1').val();
        var leave1 = $('#leave1').val();
        $.ajax({
            type: 'GET',
            url: '/filtering-applyleve',
            data: {
                status: status1,
                employee: employee1,
                leave: leave1
            },
            success: function(data) {
                // Replace the table body with the filtered data
                //  $('table tbody').html("");
                $('table thead, table tbody').html("");
                // Clear the table body
                if (data.length === 0) {
                    // If no data is found, display a "No data found" message
                    $('table tbody').append(
                        '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                    );
                } else {

                    // Add existing table heading
                    $('table thead').append(
                        '<tr>' +
                        '<th style="display: none;">id</th>' +
                        '<th>Employee</th>' +
                        '<th>Date of Requestaaaaa</th>' +
                        '<th>Status</th>' +
                        '<th>Leave Type</th>' +
                        '<th>Leave Period</th>' +
                        '<th>Days</th>' +
                        '<th>Approver</th>' +
                        '<th>Reason for Leave</th>' +
                        '</tr>'
                    );

                    $.each(data, function(index, item) {

                        // Create the URL dynamically
                        var url = '/applyleave/' + item.id;

                        var createdAt = new Date(item.created_at)
                            .toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                        var fromDate = new Date(item.from)
                            .toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                        var toDate = new Date(item.to)
                            .toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });

                        var holidays = Math.floor((new Date(item.to) -
                            new Date(item.from)) / (24 * 60 * 60 *
                            1000)) + 1;

                        // Add the rows to the table
                        $('table tbody').append('<tr>' +
                            '<td><a href="' + url + '">' + item
                            .team_member +
                            '</a></td>' +
                            '<td>' + createdAt + '</td>' +
                            '<td>' + getStatusBadge(item.status) + '</td>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + fromDate + ' to ' + toDate +
                            '</td>' +
                            '<td>' + holidays + '</td>' +
                            '<td>' + item.approvernames + '</td>' +
                            '<td style="width: 7rem;text-wrap: wrap;">' +
                            item.reasonleave + '</td>' +
                            '</tr>');
                    });



                    // Function to handle the status badge
                    function getStatusBadge(status) {
                        if (status == 0) {
                            return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                        } else if (status == 1) {
                            return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                        } else if (status == 2) {
                            return '<span class="badge badge-danger">Rejected</span>';
                        } else {
                            return '';
                        }
                    }

                    //   remove pagination after filter
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    // Change id aatribute dynamically in ajax
                    $('#examplee').attr('id', 'examplee1');
                    $('#examplee').removeAttr('id');
                }
            }
        });
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    $(function() {
        $('#category').on('change', function() {
            var category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('tags/create') }}",
                data: "category_id=" + category_id,
                success: function(res) {

                    $('#subcategory_id').html(res);


                },
                error: function() {

                },
            });
        });
        $('#subcategory_id').on('change', function() {
            var subcategory_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('tags/create') }}",
                data: "subcategory_id=" + subcategory_id,
                success: function(res) {

                    $('#step_id').html(res);


                },
                error: function() {

                },
            });
        });
        $('#step_id').on('change', function() {
            var step_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ url('tags/create') }}",
                data: "step_id=" + step_id,
                success: function(res) {

                    $('#audit_id').html(res);


                },
                error: function() {

                },
            });
        });

    });
</script>
{{-- ! Old code 03-01-24  --}}
{{-- <script>
     $(document).ready(function() {
         $('#examplee').DataTable({
             dom: 'Bfrtip',
             "pageLength": 25,
             "order": [
                 [3, "asc"]
             ],

             buttons: [

                 {
                     extend: 'copyHtml5',
                     exportOptions: {
                         columns: [0, ':visible']
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     filename: 'Apply Report List',
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     exportOptions: {
                         columns: [0, 1, 2, 5]
                     }
                 },
                 'colvis'
             ]
         });
     });
 </script> --}}

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "pageLength": 25,
            "order": [
                [3, "asc"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Apply Report List',
                    //  Change value Acreated to created and AApproved to Approved
                    customizeData: function(data) {
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                if (data.body[i][j] === 'ACreated') {
                                    data.body[i][j] = 'Created';
                                } else if (data.body[i][j] === 'BApproved') {
                                    data.body[i][j] = 'Approved';
                                } else if (data.body[i][j] === 'Rejected') {
                                    data.body[i][j] = 'Rejected';
                                }
                            }
                        }
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Apply Report List',
                    //  Change value Acreated to created and AApproved to Approved
                    customize: function(doc) {
                        // Assuming the status column is at index 3, adjust as needed
                        for (var i = 0; i < doc.content[1].table.body.length; i++) {
                            var originalValue = doc.content[1].table.body[i][3].text;
                            if (originalValue === 'ACreated') {
                                doc.content[1].table.body[i][3].text = 'Created';
                            } else if (originalValue === 'BApproved') {
                                doc.content[1].table.body[i][3].text = 'Approved';
                            } else if (originalValue === 'CRejected') {
                                doc.content[1].table.body[i][3].text = 'Rejected';
                            }
                        }
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{-- add library for excell download after filter  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

{{-- filter on apply leave --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- ! 11-01-2023 --}}
{{-- 
<script>
    $(document).ready(function() {

        //** leave period end date wise
        $('#endperiod1').change(function() {
            var endperiod1 = $(this).val();
            var startperiod1 = $('#startperiod1').val();
            // var end1 = $('#end1').val();
            // var status1 = $('#status1').val();
            // var employee1 = $('#employee1').val();
            // var leave1 = $('#leave1').val();
            // alert(endperiod1);
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    // end: end1,
                    // start: start1,
                    // status: status1,
                    // employee: employee1,
                    // leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });


        //** status wise
        $('#status1').change(function() {
            var status1 = $(this).val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            $.ajax({

                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //** start date wise
        $('#start1').change(function() {
            var start1 = $(this).val();
            var end1 = $('#end1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            //  alert(start1);
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });


        //  end Request Date end date wise
        $('#end1').change(function() {
            var end1 = $(this).val();
            var start1 = $('#start1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //   leave type wise
        $('#leave1').change(function() {
            var leave1 = $(this).val();
            var employee1 = $('#employee1').val();
            var status1 = $('#status1').val();
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');

                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //   team name wise
        $('#employee1').change(function() {
            var employee1 = $(this).val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });
    });
</script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Common function to render table rows
        function renderTableRows(data) {
            $('table tbody').html("");
            $('#clickExcell').show();

            if (data.length === 0) {
                $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
            } else {
                $.each(data, function(index, item) {
                    var url = '/applyleave/' + item.id;
                    var createdAt = formatDate(item.created_at);
                    var fromDate = formatDate(item.from);
                    var toDate = formatDate(item.to);
                    var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                        60 * 1000)) + 1;

                    $('table tbody').append('<tr>' +
                        '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                        '<td>' + createdAt + '</td>' +
                        '<td>' + getStatusBadge(item.status) + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + fromDate + ' to ' + toDate + '</td>' +
                        '<td>' + holidays + '</td>' +
                        '<td>' + item.approvernames + '</td>' +
                        '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                        '</tr>');
                });
            }
        }

        // Common function to export data to Excel
        function exportToExcel(data) {
            const filteredData = data.map(item => {
                const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                    1000)) + 1;
                const createdAt = formatDate(item.created_at);
                const fromDate = formatDate(item.from);
                const toDate = formatDate(item.to);

                return {
                    Employee: item.team_member,
                    Date_of_Request: createdAt,
                    status: getStatusText(item.status),
                    Leave_Type: item.name,
                    from: fromDate,
                    to: toDate,
                    Days: holidays,
                    Approver: item.approvernames,
                    Reason_for_Leave: item.reasonleave
                };
            });

            const ws = XLSX.utils.json_to_sheet(filteredData);
            const headerCellStyle = {
                font: {
                    bold: true
                }
            };

            ws['!cols'] = [{
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 15
                },
                {
                    wch: 15
                },
                {
                    wch: 20
                },
                {
                    wch: 30
                }
            ];

            Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                ws[key].s = headerCellStyle;
            });

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
            const excelBuffer = XLSX.write(wb, {
                bookType: "xlsx",
                type: "array"
            });
            const dataBlob = new Blob([excelBuffer], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            });
            saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
        }

        // Common function to format date
        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Common function to get status text
        function getStatusText(status) {
            return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
        }

        // Common function to get status badge
        function getStatusBadge(status) {
            if (status === 0) {
                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
            } else if (status === 1) {
                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
            } else if (status === 2) {
                return '<span class="badge badge-danger">Rejected</span>';
            } else {
                return '';
            }
        }

        // Function to handle status change
        function handleStatusChange() {
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                }
            });
        }

        // Function to handle leave type change
        function handleLeaveTypeChange() {
            var leave1 = $('#leave1').val();
            var employee1 = $('#employee1').val();
            var status1 = $('#status1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                }
            });
        }

        // Function to handle employee change
        function handleEmployeeChange() {
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                }
            });
        }

        // Function to handle leave period end date change
        function handleleaveperiodendChange() {
            var endperiod1 = $('#endperiod1').val();
            var startperiod1 = $('#startperiod1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                }
            });
        }

        //  end Request Date end date wise
        function handleEndRequestDateChange() {
            var end1 = $('#end1').val();
            var start1 = $('#start1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    renderTableRows(data);
                    $('.paging_simple_numbers').remove();
                    $('.dataTables_info').remove();
                    if (data.length > 0) {
                        $('#clickExcell').on('click', function() {
                            exportToExcel(data);
                        });
                    }
                }
            });
        }

        // Event handlers
        $('#status1').change(handleStatusChange);
        $('#leave1').change(handleLeaveTypeChange);
        $('#employee1').change(handleEmployeeChange);
        $('#endperiod1').change(handleleaveperiodendChange);
        $('#end1').change(handleEndRequestDateChange);

        //** start date wise
        $('#start1').change(function() {
            var start1 = $(this).val();
            var end1 = $('#end1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            //  alert(start1);
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });

    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {

        //   team name wise
        $('#employee1').change(function() {
            var employee1 = $(this).val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        //   Create Zip Folder button click event
        $('#downloadButton').click(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var assignmentgenerateid = {{ $assignmentgenerateid }}; // Use the variable from Blade

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



{{-- validation for comparision date and block year for 4 disit --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startdate');
        var endDateInput = $('#enddate');

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
{{-- <script>
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
              //   //   validation for year match
              //   var yearvalue = $('#year').val();
              //   if (yearvalue != startyear) {
              //       alert('Enter Start Date According Year');
              //       startclear.val('');
              //   }
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
              //   //   validation for year match
              //   var yearvalue = $('#year').val();
              //   if (yearvalue != endyear) {
              //       alert('Enter End Date According Year');
              //       endclear.val('');
              //   }
          });


          // Add form submission handling
          $('form').submit(function(event) {
              var year = $('#year').val();
              var startdate = $('#startdate').val();
              var enddate = $('#enddate').val();
              //   validation for year match
              var yearvalue = $('#year').val();
              if (yearvalue != startyear) {
                  alert('Enter Start Date According Year');
                  startclear.val('');
              }
              if (year === "" || startdate === "" || enddate === "") {
                  alert("Please select filter data.");
                  event.preventDefault(); // Prevent form submission
              }
          });
      });
  </script> --}}

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
        });

        // Add form submission handling
        $('form').submit(function(event) {
            var year = $('#year').val();
            var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();

            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearvalue = $('#year').val();
            if (yearvalue != startyear) {
                alert('Enter Start Date According Year');
                startclear.val('');
                event.preventDefault(); // Prevent form submission
                return; // Exit the function
            }

            if (year === "" || startdate === "" || enddate === "") {
                alert("Please select filter data.");
                event.preventDefault(); // Prevent form submission
            }
        });
    });
</script>

{{-- <script>
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
          });

          // Add form submission handling
          $('form').submit(function(event) {
              var year = $('#year').val();
              var startdate = $('#startdate').val();
              var enddate = $('#enddate').val();

              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();

              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endDate = new Date(endDateInput1);
              var endyear = endDate.getFullYear();

              var yearvalue = $('#year').val();
              if (yearvalue != startyear || yearvalue != endyear) {
                  alert('Enter Start and End Date According to the selected Year');
                  startclear.val('');
                  endclear.val('');
                  event.preventDefault(); // Prevent form submission
                  return; // Exit the function
              }

              if (year === "" || startdate === "" || enddate === "") {
                  alert("Please select filter data.");
                  event.preventDefault(); // Prevent form submission
              }
          });
      });
  </script> --}}

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
balanceconfirmationreminder
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

{{-- * --}}
{{-- * --}}
<div id="profileCompletion" class="alert alert-info" role="alert">

</div>
<script>
    $(document).ready(function() {
        var profileCompletionPercentage = {{ $formattedProfileCompletion }};
        // alert(profileCompletionPercentage);
        $('#profileCompletion').text(profileCompletionPercentage + '%');
    });
</script>
{{-- * --}}

{{-- <script>
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
                        $("#status").val(response.status);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script> --}}
{{-- <script>
        $(function() {
            $('body').on('click', '#editCompany2', function(event) {
                //        debugger;
                var id = $(this).data('id');
                // debugger;
                alert(id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp2') }}",
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
                        $("#status").val(response.status);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script> --}}




{{-- ###################################################################### --}}
{{--  --------------------- 29 sep 2023 joining date--------------- --}}

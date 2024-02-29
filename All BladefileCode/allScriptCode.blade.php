{{-- *  --}}
{{-- *  --}}
{{-- *  --}}
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
{{-- * regarding datatable / regarding filter / regarding basic class  --}}
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
{{-- * regarding ajax / table heading replace    --}}
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
<div id="profileCompletion" class="alert alert-info" role="alert">

</div>
<script>
    $(document).ready(function() {
        var profileCompletionPercentage = {{ $formattedProfileCompletion }};
        // alert(profileCompletionPercentage);
        $('#profileCompletion').text(profileCompletionPercentage + '%');
    });
</script>

{{-- ###################################################################### --}}
{{--  --------------------- 29 sep 2023 joining date--------------- --}}

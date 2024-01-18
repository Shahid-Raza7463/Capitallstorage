{{-- *  --}}
{{-- *  --}}
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

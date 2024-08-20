<script>
    $(document).ready(function() {
        // Master checkbox change event
        $("#masterCheckbox").change(function() {
            // Get the state of the master checkbox
            var isChecked = $(this).is(":checked");

            // Update the state of all checkboxes in the table body
            $("input[name='approve[]']").prop("checked", isChecked);
        });

        // Individual checkbox change event
        $("input[name='approve[]']").change(function() {
            // Check if all checkboxes are checked
            var allChecked = ($("input[name='approve[]']").length === $("input[name='approve[]']:checked").length);

            // Update the state of the master checkbox
            $("#masterCheckbox").prop("checked", allChecked);
        });

        // Send button click event
        $("#sendButton").click(function() {
            // Get IDs of checked checkboxes
            var checkedIDs = [];
            $("input[name='approve[]']:checked").each(function() {
                checkedIDs.push($(this).val());
            });

            var confirmationtype = '1';
            // Populate the modal input with the IDs
            $("#debtorid").val(checkedIDs.join(", "));
            $("#confirmationtype").val(confirmationtype);
           // debugger;
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Master checkbox change event
        $("#masterCheckboxx").change(function() {
            // Get the state of the master checkbox
            var isChecked = $(this).is(":checked");

            // Update the state of all checkboxes in the table body
            $("input[name='approves[]']").prop("checked", isChecked);
        });

        // Individual checkbox change event
        $("input[name='approves[]']").change(function() {
            // Check if all checkboxes are checked
            var allChecked = ($("input[name='approves[]']").length === $("input[name='approves[]']:checked").length);

            // Update the state of the master checkbox
            $("#masterCheckbox").prop("checked", allChecked);
        });

        // Send button click event
        $("#sendButtons").click(function() {
            // Get IDs of checked checkboxes
            var checkedIDs = [];
            $("input[name='approves[]']:checked").each(function() {
                checkedIDs.push($(this).val());
            });
            var confirmationtype = '2';
            // Populate the modal input with the IDs
            $("#debtorid").val(checkedIDs.join(", "));
            $("#confirmationtype").val(confirmationtype);
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Master checkbox change event
        $("#masterCheckboxxx").change(function() {
            // Get the state of the master checkbox
            var isChecked = $(this).is(":checked");

            // Update the state of all checkboxes in the table body
            $("input[name='approvess[]']").prop("checked", isChecked);
        });

        // Individual checkbox change event
        $("input[name='approvess[]']").change(function() {
            // Check if all checkboxes are checked
            var allChecked = ($("input[name='approvess[]']").length === $("input[name='approvess[]']:checked").length);

            // Update the state of the master checkbox
            $("#masterCheckbox").prop("checked", allChecked);
        });

        // Send button click event
        $("#sendButtonss").click(function() {
            // Get IDs of checked checkboxes
            var checkedIDs = [];
            $("input[name='approvess[]']:checked").each(function() {
                checkedIDs.push($(this).val());
            });
            var confirmationtype = '3';
            // Populate the modal input with the IDs
            $("#debtorid").val(checkedIDs.join(", "));
            $("#confirmationtype").val(confirmationtype);
        });
    });
</script>
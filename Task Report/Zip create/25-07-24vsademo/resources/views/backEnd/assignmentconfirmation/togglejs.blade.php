
<script>
    $(document).ready(function() {
        // Master toggle functionality
        $('.debtor-status-toggle-master').change(function() {
            var status = $(this).is(':checked') ? 1 : 0;
    
            // Toggle all slave checkboxes
            $('.debtor-status-toggle').prop('checked', status).change(); // Trigger change to fire AJAX for each slave
        });
    
        // Slave toggle functionality
        $('.debtor-status-toggle').change(function() {
            if (!$(this).hasClass('debtor-status-toggle-master')) { // Prevent recursion
                var debtorId = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
    
                $.ajax({
                    url: "{{ url('update-debtor-status') }}",
                    type: 'POST',
                    data: {
                        id: debtorId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message-text').text('Update successfully ');
                    $('#message-container').show(); // Show the message container

                    // Set timeout to hide the message after 10 seconds
                    setTimeout(function() {
                        $('#message-container').fadeOut(); // Gradually fade out the message
                    }, 10000); // 10000 milliseconds = 10 seconds
                },
                    error: function() {
                        alert('Error updating status for debtor ' + debtorId);
                    }
                });
            }
        });
    });
    </script>

<script>
    $(document).ready(function() {
        // Master toggle functionality
        $('.creditor-status-toggle-master').change(function() {
            var status = $(this).is(':checked') ? 1 : 0;
    
            // Toggle all slave checkboxes
            $('.creditor-status-toggle').prop('checked', status).change(); // Trigger change to fire AJAX for each slave
        });
    
        // Slave toggle functionality
        $('.creditor-status-toggle').change(function() {
            if (!$(this).hasClass('creditor-status-toggle-master')) { // Prevent recursion
                var debtorId = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
    
                $.ajax({
                    url: "{{ url('update-debtor-status') }}",
                    type: 'POST',
                    data: {
                        id: debtorId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message-text').text('Update successfully ');
                    $('#message-container').show(); // Show the message container

                    // Set timeout to hide the message after 10 seconds
                    setTimeout(function() {
                        $('#message-container').fadeOut(); // Gradually fade out the message
                    }, 10000); // 10000 milliseconds = 10 seconds
                },
                    error: function() {
                        alert('Error updating status for debtor ' + debtorId);
                    }
                });
            }
        });
    });
    </script>
<script>
    $(document).ready(function() {
        // Master toggle functionality
        $('.bank-status-toggle-master').change(function() {
            var status = $(this).is(':checked') ? 1 : 0;
    
            // Toggle all slave checkboxes
            $('.bank-status-toggle').prop('checked', status).change(); // Trigger change to fire AJAX for each slave
        });
    
        // Slave toggle functionality
        $('.bank-status-toggle').change(function() {
            if (!$(this).hasClass('bank-status-toggle-master')) { // Prevent recursion
                var debtorId = $(this).data('id');
                var status = $(this).is(':checked') ? 1 : 0;
    
                $.ajax({
                    url: "{{ url('update-debtor-status') }}",
                    type: 'POST',
                    data: {
                        id: debtorId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#message-text').text('Update successfully ');
                    $('#message-container').show(); // Show the message container

                    // Set timeout to hide the message after 10 seconds
                    setTimeout(function() {
                        $('#message-container').fadeOut(); // Gradually fade out the message
                    }, 10000); // 10000 milliseconds = 10 seconds
                },
                    error: function() {
                        alert('Error updating status for debtor ' + debtorId);
                    }
                });
            }
        });
    });
    </script>
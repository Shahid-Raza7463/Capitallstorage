//*
//*

<div id="profileCompletion" class="alert alert-info" role="alert">

</div>
// <script>
$(document).ready(function() {
    var profileCompletionPercentage = {{ $formattedProfileCompletion }};
    // alert(profileCompletionPercentage);
    $('#profileCompletion').text(profileCompletionPercentage + '%');
});
// </script>

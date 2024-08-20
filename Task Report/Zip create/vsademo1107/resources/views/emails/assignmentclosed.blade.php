<h3>Dear {{ $name ?? '' }} ,</h3>
<br>
<p>This email is to inform you that your assignment has been closed by OTP.</p>
<p>The OTP is <b>{{ $otp }}</b>. Please enter this OTP in the assignment submission form to close your
    assignment.
</p>

<div>
    <span><b>Client Name :</b> </span><span>{{ $client_name }} ({{ $client_code }})</span>
</div>
<div>
    <span><b>Assignment Name :</b></span> <span>{{ $assignmentname }} ({{ $asassignmentsignmentid }})</span>
</div>
<div>
    <span><b>Team Members :</b> </span>
 @foreach ($assignmentteammember as $teammembers)
        <span>{{ $teammembers->team_member }} ({{ $teammembers->staffcode }}),</span>
    @endforeach
</div>
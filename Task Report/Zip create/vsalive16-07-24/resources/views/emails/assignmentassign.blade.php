
<h3>
    Dear Sir/Madam</h3>
<br><br>
<p>You have been assigned a new assignment . Please click <a href="{{ url('assignmentmapping') }}">here</a> to check</p>
<p>Assignment Name : {{ $assignment_name }} ({{ $assignmentname }}) ({{ $assignmentid }})</p>
<p>Client Name : {{ $clientname ?? '' }}</p>
<p>Client Code : {{ $clientcode ?? '' }}</p>
<p>Assignment Partner : {{ $assignmentpartner->team_member ?? '' }} ({{ $assignmentpartner->staffcode ?? '' }})</p>
<p>Other Partner : {{ $otherpatner->team_member ?? 'N/A' }}
    @if ($otherpatner != null)
        ({{ $otherpatner->staffcode ?? '' }})
    @endif
</p>
<p>Team Leader :
    @foreach ($teamleader as $teamleaderDatas)
        {{ $teamleaderDatas->team_member ?? '' }} ({{ $teamleaderDatas->staffcode ?? '' }}),
    @endforeach
</p>
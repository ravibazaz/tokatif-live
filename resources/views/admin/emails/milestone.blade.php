Hello {{ $details['receiver'] }},

<div>
	<p><b>Project:</b>&nbsp;{{ $details['project_name'] }}</p>
	<p><b>Milestone:</b>&nbsp;{{ $details['milestone_name'] }}</p>
	<p><b>Start Date:</b>&nbsp;{{ $details['start_date'] }}</p>
	<p><b>End Date:</b>&nbsp;{{ $details['end_date'] }}</p>
	<p><b>Description:</b>&nbsp;{{ $details['description'] }}</p>
	<p><b>Assigned To:</b>&nbsp;{{ $details['assigned_to'] }}</p>
	<p><b>Created By:</b>&nbsp;{{ $details['created_by'] }}</p>
</div>

Thank You,
<br/>
{{ $details['sender'] }}





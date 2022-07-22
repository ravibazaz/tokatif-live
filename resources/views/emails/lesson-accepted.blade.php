Hi, {{ $details['receiver'] }}

<div>
	<p>Good news! Your lesson request has been accepted! Please check the details of your lesson via the button below!</p><br/>

	<p><b>Teacher : </b> {{ $details['teacher_name'] }}</p>
	<p><b>Lessin ID : </b> {{ $details['lession_id'] }}</p>
	<p><b>Course Name : </b> {{ $details['course_name'] }}</p>
	<p><b>Lesson Date/Time : </b> {{ $details['lession_time'] }}</p><br/>

	<p>Once every so often, mistakes in bookings happen. Please make sure you got the date and time right so your teacher is not waiting for you on the day!</p>

	<p><a href="{{ url('lesson-detail',$details['lession_id']) }}"><button class="btn btn-primary">View Lessn Details</button></a></p>
</div>

Happy learning!<br/>
Tokatif Team
Hi, {{ $details['receiver'] }}

<div>
	<p>{{ $details['msg'] }} <br>
	
	    Student: {{ $details['student_name'] }}  <br>
	    Course Name: {{ $details['course_name'] }}  <br> 
	    Lesson ID: {{ $details['lesson_id'] }}  <br> 
	    Lesson Date/Time: {{ $details['lesson_date'] }}  <br>  
	    Lesson Price: {{ $details['lesson_price'] }}  <br> 
	    
	    <a href="{{ $details['lesson_url'] }}" target="_blank">View Lesson Details</a>
	</p>
	
	<br> <strong>Please respond to the lesson request within 48 hours, or the lesson request will automatically expire.</strong>
</div>

Kind regards, <br/>
Tokatif Team
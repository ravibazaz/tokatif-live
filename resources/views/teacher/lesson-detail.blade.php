@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp

@include('include/head')

@if(session('id')!='' && session('role')=='1')
    @include('include/student-dashboard-header')
@elseif(session('id')!='' && session('role')=='2')
    @include('include/teacher-dashboard-header')
@else
    @include('include/header')
@endif


<section class="lesson-complited-banner">
 <div class="container">
  <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <h4>{{$booking_date}} {{$booking_time}}</h4>
     
     @if($lesson_started_at)
        <a href="javascript:vid(0);">Start - {{$lesson_started_at}}</a>
     @endif
     
     @if($lesson_completed_at)
        <a href="javascript:vid(0);">End - {{$lesson_completed_at}}</a>
     @endif
     
   </div>
  </div>
 </div>
</section>

<section class="lesson-complited-page">
 <div class="container">
	<div class="row">
	  <div class="col-lg-9 col-md-8 col-sm-8 col-12">
        <div class="total-complited-lesson">
        <div class="lesson-complited-text">
          <div class="my-lessons">
           <div class="row">
           <div class="col-lg-8 col-md-8 col-sm-8 col-12">
            <div class="my-teacher-00 recommended-teacher">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-12 col-12">
                       <div class="lesson-rightpic">
                        <img src="{{$teacher_photo}}" class="img-fluid">
                        <span class="offline-icon"><img src="{{$teacher_country_flag}}" class="img-fluid"></span>
                      </div>
                    </div>
                    <div class="col-lg-10 col-md-9 col-sm-12 col-12 pl-0">
                       <h4>{{$teacher_name}}</h4>
                       <!--<h5>Offline (Visited 2days ago)</h5>-->
                    </div>  
                </div> 
             </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-12"> <!--<p>Send Message To Teacher </p>--> </div>                          
          </div>
          </div>                             
          <hr/>
        
       </div>
        <div class="row">
          <div class="col-lg-7 col-md-8 col-sm-8 col-12 lesson-text">
            <h4>{{$lesson->name}}</h4>
            <small>{{$lesson_count}}</small>    
          </div>
          <div class="col-lg-5 col-md-4 col-sm-4 col-12"> 
            <ul class="lesson-box">
                <li><h5>{{$lesson->lesson_category}}</h5>
         	        <p>Category</p></li>
            
                <li><h5>{{$lesson->lesson_tag}}</h5>
         	        <p>Tag</p></li>  
         	        
                <li><h5>{{$lesson->language_taught}}</h5>
         	        <p>Language</p></li>
            </ul>
          </div> 
        </div>
        <div class="row">
          <div class="col-lg-12">
           <p>{{$lesson->description}}</p>
          </div>
        </div>
        <hr/>
        <div class="row communication-text align-items-center">
          <div class="col-lg-4 col-12">
            <h4>Communication Tool</h4>
            <span>
                @if($teacher_communication_tool=='skype')
                    <img src="{{asset('public/frontendassets/images/skype.png')}}" class="img-fluid"/> 
                @elseif($teacher_communication_tool=='zoom')
                    <img src="{{asset('public/frontendassets/images/zoom.png')}}" class="img-fluid"/> 
                @endif
            </span>
            <small>Teacher Account</small>
            <small>{{$teacher_communication_account_id}} <i><img src="{{asset('public/frontendassets/images/file-icon.png')}}" class="img-fluid"/></i></small>
          
          </div>
          
          @if($getLoggedIndata->role=='1')
          <div class="col-lg-8 col-12">
            <h5>Your Account</h5>
            <span>
                @if($getLoggedIndata->video_conferencing_platform=='skype')
                    <img src="{{asset('public/frontendassets/images/skype.png')}}" class="img-fluid"/> 
                @elseif($getLoggedIndata->video_conferencing_platform=='zoom')
                    <img src="{{asset('public/frontendassets/images/zoom.png')}}" class="img-fluid"/> 
                @endif
                
               {{$getLoggedIndata->user_account_id}}
            </span>
          </div>
          @endif
          
        </div>
        <hr/> 
        <div class="row record-text align-items-center">
          <div class="col-lg-12 col-12">
             <h4>Records</h4>
             
             @foreach($lesson_log as $val)
             <div class="record-text-sub">
                <h5>{{$val->action}}</h5>
                <p>{{date('d M Y h:i a',strtotime($val->created_at))}}</p>
             </div>
             @endforeach
             
             
             <!--<div class="record-text-sub">
             <h5>Teacher accepted the changes to the lesson request. The lesson</h5>
             <p>October 15, 2020 07:15 PM</p>
             </div>
             <div class="record-text-sub">
             <h5>Teacher accepted the changes to the lesson request. The lesson</h5>
             <p>October 15, 2020 07:15 PM</p>
             </div>
             <div class="record-text-sub">
             <h5>Teacher accepted the changes to the lesson request. The lesson</h5>
             <p>October 15, 2020 07:15 PM</p>
             </div>
             <div class="record-text-sub">
             <h5>Student sent a trial request. Awaiting response from the teacher</h5>
             <p>October 15, 2020 07:15 PM</p>
             </div>-->
          </div>
        </div>
       </div> 
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-12">
         <div class="upcoming-part">
          <h3> Upcoming </h3>
            <p>Your lesson is ready to begin at the scheduled time.</p>
			<p>If you need to cancel or reschedule your lesson, 
            make sure to read up on our cancellation and rescheduling policies first.  </p><br>
            
            @if($getLoggedIndata->role=='2' || $getLoggedIndata->role=='1')
                @if($bookingDate < date('Y-m-d') && $booking_status!='3')
                    <a href="{{ route('change-lesson-date',['id'=>$booking_id]) }}"> Change Date / Time </a>
                    <!--<a href="#">Cancel Lesson</a>-->
                @elseif($getLoggedIndata->role=='1')
                
                    @if($booking_status=='3' && $feedback_rating_count==0)
                        <a href="{{ route('feedback',['id'=>$booking_id]) }}"> Give Feedback </a> 
                    @endif
                    
                    @php
                        $invitationData = DB::table('lesson_invitation')->where('student_id', '=', session('id'))
                                                                        ->where('lesson_id', '=', Request::segment(2))
                                                                        ->where('booking_date', '>=', date('Y-m-d'))
                                                                        ->where('status', '=', '0')->first(); 
                    @endphp
                    
                    @if($invitationData)
                        <br><a href="{{ route('student-accept-lesson-invitation',['id'=>$invitationData->id]) }}"> Accept Invitation </a> 
                        <br><a href="{{ route('student-decline-lesson-invitation',['id'=>$invitationData->id]) }}"> Reject Invitation </a> 
                    @endif
                    
                @endif
            @endif
            
            
      
       </div>
      </div>
  </div>
</section>

@include('include/footer')



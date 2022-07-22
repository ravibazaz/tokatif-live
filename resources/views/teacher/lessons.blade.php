@include('include/head')
@include('include/teacher-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp

<section class="teacher-contain">
<div class="container">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      @include('include/teacher-left-sidebar')
     </div>
     
     <div class="col-lg-9 col-md-9 col-sm-12 col-12">
            @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> {{Session::get('success')}}
            </div>
            @endif
            @if(Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Note!</strong> {{Session::get('error')}}
            </div>
            @endif
            
        <section class="tab-section">
      
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item waves-effect waves-light">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
              Lesson Management</a>
            </li>
            <li class="nav-item waves-effect waves-light">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
              Lesson Request Settings</a>
            </li>
            <li class="nav-item waves-effect waves-light">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
              Lesson Booking Settings</a>
            </li>
            <!--<li class="nav-item waves-effect waves-light">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#languages" role="tab" aria-controls="contact" aria-selected="false">
              Calendar View Settings</a>
            </li>
            <li class="nav-item waves-effect waves-light">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#certificates" role="tab" aria-controls="contact" aria-selected="false">
              Teacher Calendar</a>
            </li>-->
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
              <h3>Lesson Management</h3>
               <div class="information-section information-basic">
                 
                 <div class="education-part Lesson">
                    <div class="form-row part-title align-items-center">
                        <div class="form-group col-md-6"><h3>All Lessons</h3></div>
                        <div class="form-group col-md-6 text-right"> </div>
                    </div>          
                    
                    @foreach($lessons as $val)
                    <div class="form-row Approved-row align-items-center">
                        <div class="form-group col-md-8">
                            <p><i class="fa fa-check-circle" aria-hidden="true"></i> <strong>{{$val->name}}</strong></p>
                            <ul class="reading-corses">
                             <li>{{$val->lesson_category}}  |  {{$val->language_taught}}</li>
                             <li><a href="javascript:void(0);">{{$val->lesson_tag}}</a></li>
                            </ul>
                         </div>
                        
                        @php
                          $lessons = DB::table('lesson_packages')
                                            ->select(DB::Raw('individual_lesson, total'))
                                            ->whereNull('deleted_at')
                                            ->where('lesson_id', '=', $val->id)
                                            ->get();

                          $lesson_amount = 0;
                          foreach($lessons as $lesson)
                          {
                              $lesson_amount += $lesson->individual_lesson + $lesson->total;
                          }

                        @endphp
                        <div class="form-group col-md-2">
                            <a href="javascript:void(0);" class="uploaded">USD {{number_format($lesson_amount,2)}}</a>
                        </div>     
                     
                        <div class="form-group col-md-2">
                            <div class="edite-delite">
                                <a href="javascript:void(0);" data-LessonID="{{$val->id}}" class="lessonDetailModal" ><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="{{route('lesson-edit',['id'=>$val->id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="{{ route('teacher-lesson-delete',['id'=>$val->id]) }}" onclick="return confirm('Do you want to delete the lesson ?')" class="actionLink"><i class="fa fa-trash-o"></i></a> 
                            </div>
                        </div>     
                     
                    </div>
                    @endforeach
                    
                  </div>
                   
                  <a href="{{route('add-lesson')}}" class="btn btn-submit"> Create New Lesson </a>
                
                 
              </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <h3>Lesson Request Settings</h3>
               <div class="information-section resume-certificate">
                 <form role="form" action="{{ route('teacher-availability-settings-update') }}" method="POST" enctype="multipart/form-data" > 
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="id" value="{{$getLoggedIndata->id}}" />
                    <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />
                    <input type="hidden" class="form-control" name="teacher_auto_accept_status" id="teacher_auto_accept_status" value="{{$user->teacher_auto_accept_status}}" />
                  <div class="form-row">
                    <div class="form-group col-md-12">
                       <h4>Lesson Requests</h4>
                      <label for="inputEmail4">Allow Lesson Reuqests From</label>
                      <select name="lesson_request_from" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option value="">--Please select--</option>
                        <option value="all" {{ ($user->lesson_request_from == 'all') ? 'selected' : '' }}>All Students</option>
                        <option value="current" {{ ($user->lesson_request_from == 'current') ? 'selected' : '' }}>Current Students</option>
                        <option value="nobody" {{ ($user->lesson_request_from == 'nobody') ? 'selected' : '' }}>Nobody</option>
                      </select>
                        @if ($errors->has('lesson_request_from'))
                            <span class="text-danger">{{ $errors->first('lesson_request_from') }}</span>
                        @endif
                      <p class="mt-2">Please be aware that if you are not accepting new students, your profile will not appear on the teacher search.</p>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12 example">
                        <h3>Auto-Accept</h3>
                        <button type="button" class="teacherAutoAcceptStatus btn btn-toggle mb-4 {{ ($user->teacher_auto_accept_status == 'true') ? 'active' : '' }}" data-toggle="button" aria-pressed="{{$user->teacher_auto_accept_status}}" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                        @if ($errors->has('teacher_auto_accept_status'))
                            <span class="text-danger">{{ $errors->first('teacher_auto_accept_status') }}</span>
                        @endif
                        <p>Automatically Accept Lesson Request From</p>
  
                    </div>
                  </div>
                <div class="form-row">  
                    <div class="form-group col-md-12">
                      <p><input type="radio" name="teacher_auto_accept_from" value="current" {{ ($user->teacher_auto_accept_from == 'current') ? 'checked' : '' }}> Current Student </p>   
                      <p><input type="radio" name="teacher_auto_accept_from" value="all" {{ ($user->teacher_auto_accept_from == 'all') ? 'checked' : '' }}> All Student </p> 
					</div>
					@if ($errors->has('teacher_auto_accept_from'))
                        <span class="text-danger">{{ $errors->first('teacher_auto_accept_from') }}</span>
                    @endif
                </div>
                     
                  <button type="submit" class="btn btn-submit">Save</button>
                <div></div></form>
              </div> 
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
             <h3>Lesson Booking Settings</h3>
                 <div class="information-section resume-certificate">
                 <form role="form" action="{{ route('teacher-booking-settings-update') }}" method="POST" enctype="multipart/form-data" > 
                    {{ csrf_field() }}
                    <input type="hidden" class="form-control" name="id" value="{{$getLoggedIndata->id}}" />
                    <input type="hidden" class="form-control" name="role" value="{{$getLoggedIndata->role}}" />
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Instant Tutoring</label>
                      <select name="instant_tutoring" class="custom-select mr-sm-2" id="">
                        <option value="">--Please select--</option>
                        <option value="2days" {{ ($user->instant_tutoring == '2days') ? 'selected' : '' }}>Atleast 2 days notice</option>
                        <option value="1day" {{ ($user->instant_tutoring == '1day') ? 'selected' : '' }}>Atleast 1 day notice</option>
                        <option value="12hours" {{ ($user->instant_tutoring == '12hours') ? 'selected' : '' }}>At value 12 hours notice</option>
                        <option value="6hours" {{ ($user->instant_tutoring == '6hours') ? 'selected' : '' }}>At value 6 hours notice</option>
                        <option value="3hours" {{ ($user->instant_tutoring == '3hours') ? 'selected' : '' }}>At value 3 hours notice</option>
                        <option value="1hour" {{ ($user->instant_tutoring == '1hour') ? 'selected' : '' }}>At value 1 hour notice</option>   
                      </select>
                        @if ($errors->has('instant_tutoring'))
                            <span class="text-danger">{{ $errors->first('instant_tutoring') }}</span>
                        @endif
                      <p class="mt-2">The minimum amount of time you wish to have between when a student books their first lesson and the lesson start time.<br/>
                      Tip: Most students like to schedule their first lesson within 2 days of the date they send the request on. 
                         If you wish to receive more students, please choose the minimum amount of time between these two dates. 
                         (This only applies to new students. Existing students may book a lesson with only 2 hours prior notice if your 
                         availability allow it).</p>
                    </div>
                    
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Booking Window</label>
                      <select name="booking_window" class="custom-select mr-sm-2" id=""> 
                        <option value="">--Please select--</option>
                        <option value="2months" {{ ($user->booking_window == '2months') ? 'selected' : '' }}>2 months in advance</option>
                        <option value="1month" {{ ($user->booking_window == '1month') ? 'selected' : '' }}>1 month in advance</option>
                        <option value="3weeks" {{ ($user->booking_window == '3weeks') ? 'selected' : '' }}>3 weeks in advance</option>
                        <option value="2weeks" {{ ($user->booking_window == '2weeks') ? 'selected' : '' }}>2 weeks in advance</option>
                      </select>
                        @if ($errors->has('booking_window'))
                            <span class="text-danger">{{ $errors->first('booking_window') }}</span>
                        @endif
                      <p class="mt-2">How far in advance can students book?<br/>
                      Tip: Tutors can keep their calendars available up to 2 months ahead.</p>
                    </div>
                  </div>
                   
                  <button type="submit" class="btn btn-submit">Save</button>
                <div></div></form>
              </div>
            </div>
            <div class="tab-pane fade" id="languages" role="tabpanel" aria-labelledby="languages-tab">
             <h3>Calendar View Options</h3>
               <div class="information-section resume-certificate">
                 <form>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Current Time Zone</label>
                      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option selected="">Australia/Perth GMT +8:00</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Week Starts On</label>
                      <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                        <option selected="">Week Starts On</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-row mt-3"> 
                   <div class="form-group col-md-12 calender-icon">
                      <label for="inputEmail4">Date Format</label>
                       <input type="input" class="form-control" id="inputDate">
                       <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                  </div> 
                  <div class="form-row mt-3"> 
                   <div class="form-group col-md-12 calender-icon">
                      <label for="inputEmail4">Time zone and calendar view</label>
                       <p>Choose your current time zone to avoid time zone confusion with your students.
						  Customize calendar view the way it suits you.</p>
                    </div>
                  </div>
                  
                  
                  <button type="submit" class="btn btn-submit">Save</button>
                <div></div></form>
              </div>
            </div>
            <div class="tab-pane fade" id="certificates" role="tabpanel" aria-labelledby="certificates-tab">
             <h3>Teacher Calendar</h3>
               <div class="information-section resume-certificate">
                  <div class="card">
                    <div class="card-body p-0">
                      <div id="calendar"></div>
                    </div>
                  </div>

<!-- calendar modal -->
<!--<div id="modal-view-event" class="modal modal-top fade calendar-modal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<h4 class="modal-title"><span class="event-icon"></span><span class="event-title"></span></h4>
				<div class="event-body"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="modal-view-event-add" class="modal modal-top fade calendar-modal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
  <form id="add-event">
    <div class="modal-body">
    <h4>Add Event Detail</h4>        
      <div class="form-group">
        <label>Event name</label>
        <input type="text" class="form-control" name="ename">
      </div>
      <div class="form-group">
        <label>Event Date</label>
        <input type='text' class="datetimepicker form-control" name="edate">
      </div>        
      <div class="form-group">
        <label>Event Description</label>
        <textarea class="form-control" name="edesc"></textarea>
      </div>
      <div class="form-group">
        <label>Event Color</label>
        <select class="form-control" name="ecolor">
          <option value="fc-bg-default">fc-bg-default</option>
          <option value="fc-bg-blue">fc-bg-blue</option>
          <option value="fc-bg-lightgreen">fc-bg-lightgreen</option>
          <option value="fc-bg-pinkred">fc-bg-pinkred</option>
          <option value="fc-bg-deepskyblue">fc-bg-deepskyblue</option>
        </select>
      </div>
      <div class="form-group">
        <label>Event Icon</label>
        <select class="form-control" name="eicon">
          <option value="circle">circle</option>
          <option value="cog">cog</option>
          <option value="group">group</option>
          <option value="suitcase">suitcase</option>
          <option value="calendar">calendar</option>
        </select>
      </div>        
  </div>
    <div class="modal-footer">
    <button type="submit" class="btn btn-primary" >Save</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>        
  </div>
  </form>
</div>
</div>
</div>-->



              </div>
            </div>
          </div>
  
        </section>
     </div>
     
     

    

   </div>
  </div>
</section>



<!-- Modal -->
<div class="modal fade lesson_details_modal" id="lesson_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Lesson Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
        <div id="LessonData"></div> 
       
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-submit">Book Now</button>-->
      </div>
    </div>
  </div>
</div>

@include('include/footer')

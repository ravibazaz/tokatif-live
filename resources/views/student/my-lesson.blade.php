@include('include/head')
@include('include/student-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
@endphp


<section class="lesson-list-page">

 <div class="container">
	<div class="row">
      <div class="col-lg-3 col-md-4 col-sm-4 col-12 mt-4">
        <div class="sort-by">
          <h4>Sort By</h4>
          <ul class="nav nav-tabs tabs-left">
           <li><a href="#home-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Action Required @if(count($pending)>0) <span class="white-round">{{count($pending)}}</span> @endif </a></li>
           <li><a href="#profile-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/upcomming-icon.png') }}"/> Upcoming @if(count($upcoming)>0) <span class="white-round">{{count($upcoming)}}</span> @endif </a></li> 
           <li><a href="#messages-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/witting.png') }}"/> Waiting @if(count($waiting)>0) <span class="white-round">{{count($waiting)}}</span> @endif </a></li>
           <li><a href="#settings-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/complited.png') }}"/> Completed @if(count($completed)>0) <span class="white-round">{{count($completed)}}</span> @endif </a></li> 
           <li><a href="#unscheduled-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/complited.png') }}"/> Unscheduled @if(count($incompleted)>0) <span class="white-round">{{count($incompleted)}}</span> @endif </a></li>
           <li><a href="#Unscheduled" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/unscheduled.png') }}"/> Today @if(count($today)>0) <span class="white-round">{{count($today)}}</span><i class="fa fa-check" aria-hidden="true"></i> @endif </a></li>
           <li><a href="#canceled" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/cancelle.png') }}"/> Cancelled @if(count($cancelled)>0) <span class="white-round">{{count($cancelled)}}</span> @endif </a></li>         
           <!--<li><a href="#actionrequired" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Required 1 <span class="white-round">{{count($cancelled)}}</span> </a></li> 
           <li><a href="#actionrequired1" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Required 2 <span class="white-round">{{count($cancelled)}}</span> </a></li>-->
          </ul>
        </div>
      </div>
	  <div class="col-lg-9 col-md-8 col-sm-8 col-12">
       <div class="tab-content">
           
            @if(Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> {{Session::get('success')}}</div>
            @endif
            @if(Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Note!</strong> {{Session::get('error')}}</div>
            @endif
           
         
         
        
        <div class="tab-pane active" id="home-v">
            @if(count($pending)>0)
                @foreach($pending as $val)
                
                @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    
                    $currentDt = new DateTime(date("Y-m-d"));
                    $later = new DateTime($val->booking_date); 

                    $day_diff = $currentDt->diff($later)->format("%r%a"); 
                    if($day_diff==0)
                        $diff = 'few hours';
                    else
                        $diff = $day_diff.' Days';
                @endphp
                <div class="lesson-listnew-1">
                    <div class="row align-items-center mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In {{$diff}} </h4>
                        <p>{{$studentData->video_conferencing_platform}} Classroom ( {{$studentData->user_account_id}} ) </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text">{{$lessonData->language_taught}} ({{$lessonData->lesson_tag}})- {{$lessonPackageData->time}} </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>New lesson invitation </h4>
                        <p class="red-text">{{date('d',strtotime($val->booking_date))}} {{date('M Y',strtotime($val->booking_date))}} - {{date('h:i a',strtotime($val->booking_time))}}</p>
                      </div>
                      <div class="col-lg-2 col-md-4 col-sm-4 col-12 text-center">
                        <h4>BookingID: {{$val->id}}</h4>
                        <p>${{number_format($val->booking_amount,2)}} USD</p>
                      </div>
                    </div>
                    <div class="eline-accept-total">
                        <div class="row align-items-center justify-content-md-center m-auto deline-accept">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="{{ route('student-decline-lesson',['id'=>$val->id]) }}" onclick="return confirm('Do you want to decline the lesson request?')" >DECLINE</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="{{ route('student-accept-lesson',['id'=>$val->id]) }}" onclick="return confirm('Do you want to accept the lesson request?')" >ACCEPT</a>
                            </div>
                        </div>
                    
                    <p class="text-center mt-2">
                        Expiration Date:
                        @if($val->booking_date==date('Y-m-d'))
                            {{date('d M Y', strtotime($val->booking_date))}}
                        @else
                            {{date('d M Y', strtotime($val->booking_date . " +48 hours"))}}
                        @endif
                    </p> 
                    </div>
                </div>
                @endforeach
            @endif
            
            
            
            @if(count($invitation)>0)
                @foreach($invitation as $val)
                
                @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    
                    $currentDt = new DateTime(date("Y-m-d"));
                    $later = new DateTime($val->booking_date); 

                    $day_diff = $currentDt->diff($later)->format("%r%a"); 
                    if($day_diff==0)
                        $diff = 'few hours';
                    else
                        $diff = $day_diff.' Days';
                @endphp
                <div class="lesson-listnew-1">
                    <div class="row align-items-center mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In {{$diff}} </h4>
                        <p>{{$studentData->video_conferencing_platform}} Classroom ( {{$studentData->user_account_id}} ) </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text">{{$lessonData->language_taught}} ({{$lessonData->lesson_tag}})- {{$lessonPackageData->time}} </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>New lesson invitation </h4>
                        <p class="red-text">{{date('d',strtotime($val->booking_date))}} {{date('M Y',strtotime($val->booking_date))}} - {{date('h:i a',strtotime($val->booking_time))}}</p>
                      </div>
                      <div class="col-lg-2 col-md-4 col-sm-4 col-12 text-center">
                        <h4>BookingID: {{$val->id}}</h4>
                        <p>${{number_format($val->booking_amount,2)}} USD</p>
                      </div>
                    </div>
                    <div class="eline-accept-total">
                        <div class="row align-items-center justify-content-md-center m-auto deline-accept"> 
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="{{ route('student-decline-lesson-invitation',['id'=>$val->id]) }}" onclick="return confirm('Do you want to decline the lesson request?')" >DECLINE</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="{{ route('student-accept-lesson-invitation',['id'=>$val->id]) }}" onclick="return confirm('Do you want to accept the lesson request?')" >ACCEPT</a>
                            </div>
                        </div>
                    
                        <p class="text-center mt-2">
                            Expiration Date:
                            @if($val->booking_date==date('Y-m-d'))
                                {{date('d M Y', strtotime($val->booking_date))}}
                            @else
                                {{date('d M Y', strtotime($val->booking_date . " +48 hours"))}}
                            @endif
                        </p> 
                    </div>
                </div>
                @endforeach
            @endif
            
            
        </div>
         
         
         
         
        <div class="tab-pane" id="profile-v">
            @if(count($upcoming)>0)
                @foreach($upcoming as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list upcoming-box">
                    <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                          <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                          <li> {{$lessonData->language_taught}} <br/> Language</li>
                          <li> {{$lessonPackageData->time}} <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            @if($exists && $studentData->profile_photo!='') 
                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                            @else
                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                            @endif
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4>{{$studentData->name}}</h4>
                           <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list upcoming-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        
        
        
        <div class="tab-pane" id="messages-v">
            @if(count($waiting)>0)
                @foreach($waiting as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list waiting-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                          <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                          <li> {{$lessonData->language_taught}} <br/> Language</li>
                          <li> {{$lessonPackageData->time}} <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            @if($exists && $studentData->profile_photo!='') 
                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                            @else
                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                            @endif
                        </div>
                       
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 pl-0">
                           <h4>{{$studentData->name}}</h4>
                           <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                        </div>  
         
                        <!--<div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>-->
                        
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12"> 
                        @if($val->lesson_completed_at=='' && strtotime(date('d-m-Y')) >= strtotime($val->booking_date))
                            <a href="{{ route('change-lesson-completion-time',['id'=>$val->id]) }}" class="button-room" onclick="return confirm('Do you want to mark the lesson as completed?')" > Mark as completed </a>
                        @endif
                      </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list waiting-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        
        
        
        
        <div class="tab-pane" id="settings-v">
            @if(count($completed)>0)
                @foreach($completed as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list completed-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                          <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                          <li> {{$lessonData->language_taught}} <br/> Language</li>
                          <li> {{$lessonPackageData->time}} <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            @if($exists && $studentData->profile_photo!='') 
                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                            @else
                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                            @endif
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4>{{$studentData->name}}</h4>
                           <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list completed-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        
        <div class="tab-pane" id="unscheduled-v">
            @if(count($incompleted)>0)
                @foreach($incompleted as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    $scheduled_package = DB::table('student_lessons')->where('lesson_id', $val->lesson_id)->count();

                    $total_package_count = 0;
                    $unscheduled_package = 0;
                    if($lessonPackageData->package ==  "5 lessons")
                    {
                        $total_package_count = 5;
                    }
                    else if($lessonPackageData->package == "10 lessons")
                    {
                        $total_package_count = 10;
                    }
                    else if($lessonPackageData->package == "20 lessons")
                    {
                        $total_package_count = 20;
                    }

                    $unscheduled_package = $total_package_count - $scheduled_package;

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list incompleted-box">
                   <div class="row align-items-center">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                            <ul class="lesson-list-box">
                              <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                              <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                              <li> {{$lessonData->language_taught}} <br/> Language</li>
                              <li> {{$lessonPackageData->time}} <br/> Duration</li>
                              <li> Scheduled : {{ $scheduled_package }} <br/> Unscheduled: {{ $unscheduled_package }} </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="row align-items-center lesson-list-right">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                    @if($exists && $studentData->profile_photo!='') 
                                        <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                                    @else
                                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                    @endif
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                                   <h4>{{$studentData->name}}</h4>
                                   <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                 <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                                </div>
                            </div>
                        </div>
                        <div class="pull-right col-md-11">
                            <div class="col-md-2 col-md-offset-10 pull-right">
                                <a href="{{ url('student/book-pending-lesson', $val->booking_id) }}" class="book-btn">Book</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list completed-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        <div class="tab-pane" id="Unscheduled">
            @if(count($today_start)>0)
                @foreach($today_start as $val)
                
                @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                
                    
                    $currentDt = new DateTime(date("Y-m-d"));
                    $later = new DateTime($val->booking_date); 

                    $day_diff = $currentDt->diff($later)->format("%r%a"); 
                    if($day_diff==0)
                        $diff = 'few hours'; 
                    else
                        $diff = $day_diff.' Days';
                @endphp
                <div class="lesson-listnew-1">
                    <div class="row align-items-center">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In {{$diff}} <br> {{date('h:i a',strtotime($val->booking_time))}} </h4>
                        <p>{{$studentData->video_conferencing_platform}} Classroom ( {{$studentData->user_account_id}} ) </p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text">{{$lessonData->language_taught}} ({{$lessonData->lesson_tag}})- {{$lessonPackageData->time}} </p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center"> 
                        @php $diff_mins = ''; @endphp
                        @if($val->lesson_started_at=='' && strtotime(date('H:i')) <= strtotime($val->booking_time))
                            @if (strtotime(date('H:i')) <= strtotime($val->booking_time))
                                @php
                                    $currentDtTime = date('Y-m-d H:i');
                                    $bookingDtTime = $val->booking_date." ".$val->booking_time;
                                    $date1 = new DateTime($currentDtTime);
                                    $date2 = new DateTime($bookingDtTime);
                                    $diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;
                                @endphp
                            @endif
                            
                            @if($diff_mins>=2 && $diff_mins<=60)
                            <a href="{{ route('student-enter-classroom',['id'=>$val->id]) }}" class="button-room" onclick="return confirm('Do you want to enter the class room now?')" >Enter class room </a>
                            @endif
                        @endif
                      </div>
                    </div>
                </div>
                @endforeach
            @endif
            
            @if(count($today)>0)
                @foreach($today as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list Unscheduled-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                          <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                          <li> {{$lessonData->language_taught}} <br/> Language</li>
                          <li> {{$lessonPackageData->time}} <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            @if($exists && $studentData->profile_photo!='') 
                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                            @else
                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                            @endif
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4>{{$studentData->name}}</h4>
                           <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list Unscheduled-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        
        
        
        <div class="tab-pane" id="canceled"> 
            @if(count($cancelled)>0)
                @foreach($cancelled as $val)
                    @php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    @endphp
                <div class="my-lesson-list cancelled-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> {{date('d',strtotime($val->booking_date))}} </h4> {{date('M Y',strtotime($val->booking_date))}} </li>
                          <li> {{date('h:i a',strtotime($val->booking_time))}} <br/> <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>
                          <li> {{$lessonData->language_taught}} <br/> Language</li>
                          <li> {{$lessonPackageData->time}} <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            @if($exists && $studentData->profile_photo!='') 
                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">
                            @else
                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                            @endif
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4>{{$studentData->name}}</h4>
                           <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                @endforeach
            @else
            <div class="my-lesson-list cancelled-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            @endif
        </div>
        
        
        
        
        <!--<div class="tab-pane" id="actionrequired"> 
            <div class="lesson-listnew-1">
                <div class="row align-items-center mb-3">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                    <h4>Upcoming In 32 Days</h4>
                    <p>tokatif Classroom</p>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                    <h4>Your lesson will start in</h4>
                    <p class="red-text">Chinese(Mandarin)- 45 minutes</p>
                  </div>
                  <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                    <h4>New lesson invitation </h4>
                    <p class="red-text">Thu, Jan 9 06:30 PM- 07:00PM</p>
                  </div>
                  <div class="col-lg-2 col-md-4 col-sm-4 col-12 text-center">
                    <h4>$4.01 USD</h4>
                  </div>
                </div>
                <div class="eline-accept-total">
                    <div class="row align-items-center justify-content-md-center m-auto deline-accept">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center"><a href="#">DELINE</a></div>
                        <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center"><a href="#">ACCEPT</a></div>
                    </div>
                <p class="text-center mt-2">Expiration Date:jan9,2020 03:53 AM(UTC+08:00)</p>
                </div>
            </div>
        </div>-->
        
        
        
        
        <!--<div class="tab-pane" id="actionrequired1"> 
            <div class="lesson-listnew-1">
                <div class="row align-items-center">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                    <h4>Upcoming In 32 Days</h4>
                    <p>Chinese(Mandarin)- 45 minutes</p>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                    <h4>Your lesson will start in</h4>
                    <p class="red-text">00 minutes 00 seconds</p>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center">
                    <a href="#" class="button-room">Enter class room</a>
                  </div>
                </div>
            </div>
        </div>-->
        
       
       
        
        
      </div>
      </div>
      
  </div>
  
</section>


@include('include/footer')





@include('include/head')
@include('include/teacher-dashboard-header')


@php
 $getLoggedIndata = getLoggedinData();
@endphp

<section class="mt-5">

<div class="col-lg-5 m-auto tab-Packaes">

    <ul class="nav nav-tabs" role="tablist">
    
    	<li class="nav-item">
    		<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Lessons</a>
    	</li>
    
    	<li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">My Packages</a>
    	</li>
    
    	<li class="nav-item">
    		<a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Schedule Lesson</a>
    	</li>
    
    </ul><!-- Tab panes -->
    
</div>




<div class="clearfix"></div>

<div class="tab-content">

	<div class="tab-pane active" id="tabs-1" role="tabpanel">

		<section class="lesson-list-page">



 <div class="container">

<div class="row">
 <div class="col-lg-12 col-md-12 col-sm-12 col-12">
   <div class="sort-by">



            <h4>

                <div class="btn-group float-right sort-dropdown" role="group">

                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      Sort By 

                    </button>

                    <div class="dropdown-menu">

                      <ul class="nav nav-tabs tabs-left">

            

                       <li><a href="#home-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Action Required @if(count($pending)>0) <span class="white-round">{{@count($pending)}}</span> @endif </a></li>

            

                       <li><a href="#profile-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/upcomming-icon.png') }}"/> Upcoming @if(count($upcoming)>0) <span class="white-round">{{@count($upcoming)}}</span> @endif </a></li> 

            

                       <li><a href="#messages-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/witting.png') }}"/> Waiting @if(count($waiting)>0) <span class="white-round">{{@count($waiting)}}</span> @endif </a></li>

            

                       <li><a href="#settings-v" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/complited.png') }}"/> Completed @if(count($completed)>0) <span class="white-round">{{@count($completed)}}</span> @endif </a></li> 

            

                       <li><a href="#Unscheduled" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/unscheduled.png') }}"/> Today @if(count($today_lesson)>0) <span class="white-round">{{@count($today_lesson)}}</span> @endif </a></li>

            

                       <li><a href="#canceled" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/cancelle.png') }}"/> Cancelled @if(count($cancelled)>0) <span class="white-round">{{@count($cancelled)}}</span> @endif </a></li>         

            

                       <!--<li><a href="#actionrequired" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Required 1 <span class="white-round">{{count($cancelled)}}</span> </a></li> 

            

                       <li><a href="#actionrequired1" data-toggle="tab"><img src="{{ asset('public/frontendassets/images/ic.png') }}"/> Required 2 <span class="white-round">{{count($cancelled)}}</span> </a></li>-->

            

                      </ul>

                    </div>

                </div>

            </h4>



        </div>
 
 </div>
</div>

	<div class="row">



      <div class="col-lg-3 col-md-4 col-sm-4 col-12 mt-4">

          @include('include/teacher-left-sidebar')

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

            
         <!--<div class="tab-pane active" id="home-v">



            @if(count($pending)>0)



                @foreach($pending as $val)



                    @php



                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 



                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 



                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 



                    



                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );



                    @endphp



                <div class="my-lesson-list action-required-box">



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



                         



                        </div>



                        



                    </div>



                      </div>



                   </div>



                </div>



                @endforeach



            @else



            <div class="my-lesson-list action-required-box"> 



                <div class="row align-items-center">



                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">



                    <p class="text-center"><b>No data Found!!</b></p> 



                  </div>



               </div>



            </div>



            @endif



         </div>-->



         



        



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

                                <a href="{{ route('teacher-decline-lesson',['id'=>$val->id]) }}" onclick="return confirm('Do you want to decline the lesson request?')" >DECLINE</a>

                            </div>

                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">

                                <a href="{{ route('teacher-accept-lesson',['id'=>$val->id]) }}" onclick="return confirm('Do you want to accept the lesson request?')" >ACCEPT</a>

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

            

            <!-- Listing -->

            <section class="lesson-gride">

                <div class="row">

              

              @if(count($pending)>0)

                @foreach($pending as $val)

            

                    @php

                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

            

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                    @endphp

                <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                    <div class="gride-box">   

                      <span class="gride-boxicon">

                        @if($exists && $studentData->profile_photo!='') 

                            <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                        @else

                            <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                        @endif

                         <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                     </span>

                     

                     <h4>{{$studentData->name}}</h4>

                     <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                     

                    <ul class="box-text-grid">

                      <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                      <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                      <li> {{$lessonData->language_taught}} Language</li>

                      <li> {{$lessonPackageData->time}} Duration</li>

                    </ul>

                   

                    </div>

                </div>

                @endforeach

              @endif

              

            

            </div>

            </section>



        </div>




        <div class="tab-pane" id="profile-v">

            <section class="lesson-gride">

                <div class="row">

                    @if(count($upcoming)>0)

                        @foreach($upcoming as $val)

        

                            @php

                            $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                            $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                            $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

        

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                            <div class="gride-box">   

                              <span class="gride-boxicon">

                                @if($exists && $studentData->profile_photo!='') 

                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                @else

                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                 <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                             </span>

                             

                             <h4>{{$studentData->name}}</h4>

                             <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                             

                            <ul class="box-text-grid">

                              <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                              <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                              <li> {{$lessonData->language_taught}} Language</li>

                              <li> {{$lessonPackageData->time}} Duration</li>

                            </ul>

                           

                            </div>

                        </div>

                        @endforeach

                    @endif

                </div>

            </section>

        </div>



        



        



        



        



        <div class="tab-pane" id="messages-v">

            <section class="lesson-gride">

                <div class="row">

                    @if(count($waiting)>0)

                        @foreach($waiting as $val)

        

                            @php

                            $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                            $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                            $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

        

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                            <div class="gride-box">   

                              <span class="gride-boxicon">

                                @if($exists && $studentData->profile_photo!='') 

                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                @else

                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                 <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                             </span>

                             

                             <h4>{{$studentData->name}}</h4>

                             <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                             

                            <ul class="box-text-grid">

                              <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                              <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                              <li> {{$lessonData->language_taught}} Language</li>

                              <li> {{$lessonPackageData->time}} Duration</li>

                            </ul>

                           

                            </div>

                        </div>

                        @endforeach

                    @endif

                </div>

            </section>

        </div>



        



        



        



        



        



        <div class="tab-pane" id="settings-v">

            <section class="lesson-gride">

                <div class="row">

                    @if(count($completed)>0)

                        @foreach($completed as $val)

        

                            @php

                            $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                            $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                            $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

        

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                            <div class="gride-box">   

                              <span class="gride-boxicon">

                                @if($exists && $studentData->profile_photo!='') 

                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                @else

                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                 <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                             </span>

                             

                             <h4>{{$studentData->name}}</h4>

                             <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                             

                            <ul class="box-text-grid">

                              <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                              <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                              <li> {{$lessonData->language_taught}} Language</li>

                              <li> {{$lessonPackageData->time}} Duration</li>

                            </ul>

                           

                            </div>

                        </div>

                        @endforeach

                    @endif

                </div>

            </section>

        </div>



        



        



        



        



        <div class="tab-pane" id="Unscheduled">

            <section class="lesson-gride">

                <div class="row">

                    @if(count(@$today_lesson)>0)

                        @foreach(@$today_lesson as $val)

        

                            @php

                            $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                            $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                            $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

        

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                            <div class="gride-box">   

                              <span class="gride-boxicon">

                                @if($exists && $studentData->profile_photo!='') 

                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                @else

                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                 <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                             </span>

                             

                             <h4>{{$studentData->name}}</h4>

                             <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                             

                            <ul class="box-text-grid">

                              <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                              <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                              <li> {{$lessonData->language_taught}} Language</li>

                              <li> {{$lessonPackageData->time}} Duration</li>

                            </ul>

                           

                            </div>

                        </div>

                        @endforeach

                    @endif

                </div>

            </section>

            

            

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



                        @if($val->lesson_started_at=='')



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



                            <a href="{{ route('teacher-enter-classroom',['id'=>$val->id]) }}" class="button-room" onclick="return confirm('Do you want to enter the class room now?')" >Enter class room </a>



                            @endif



                        @endif



                      </div>



                    </div>



                </div>



                @endforeach



            @endif



            





        </div>



        



        



        



        



        <div class="tab-pane" id="canceled"> 

            <section class="lesson-gride">

                <div class="row">

                    @if(count($cancelled)>0)

                        @foreach($cancelled as $val)

        

                            @php

                            $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 

                            $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 

                            $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 

        

                            $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                            <div class="gride-box">   

                              <span class="gride-boxicon">

                                @if($exists && $studentData->profile_photo!='') 

                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                @else

                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                @endif

                                 <!--<img src="https://staging.tokatif.com/storage/app/user_photo/t_young-woman-girl_1620715695.jpg" class="img-fluid">  -->              

                             </span>

                             

                             <h4>{{$studentData->name}}</h4>

                             <p>{{$studentData->video_conferencing_platform}} : {{$studentData->user_account_id}}</p>

                             

                            <ul class="box-text-grid">

                              <li><h3> {{date('d M Y',strtotime($val->booking_date))}} </h3></li>

                              <li> {{date('h:i a',strtotime($val->booking_time))}} <span class="">{{number_format($val->booking_amount,2)}} USD</span></li>

                              <li> {{$lessonData->language_taught}} Language</li>

                              <li> {{$lessonPackageData->time}} Duration</li>

                            </ul>

                           

                            </div>

                        </div>

                        @endforeach

                    @endif

                </div>

            </section>

        </div>



        



    



      </div>



      



      



        



      </div>



  </div>

  </div>

</section>

	</div>

	<div class="tab-pane" id="tabs-2" role="tabpanel">

		<section class="lesson-package">



<div class="container">



  <div class="row">



  <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      @include('include/teacher-left-sidebar')

     </div>



   <div class="col-lg-9 col-md-9 col-sm-12 col-12">



        <!--<ul class="nav nav-tabs" id="myTab" role="tablist">



          <li class="nav-item">



            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Package</a>



          </li>



          <li class="nav-item">



            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactive Package</a> 



          </li>



        </ul>-->

        



        <div class="row active-inactive-package">

          <div class="col-lg-12 col-md-12 col-sm-12 col-12">         

           <h3><i class="fa fa-play-circle" aria-hidden="true"></i> Active Packages {{count($active_packages)}}</h3>

            

            <div class="row">

                @if(count($active_packages)>0)

                    @foreach($active_packages as $val)

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                        

                        <div class="gride-box lesson-list-box">   

                          <span class="gride-boxicon">

                             <img src="https://staging.tokatif.com/storage/app/user_photo/active_inactive.jpg" class="img-fluid">

    					 </span>

                         

                         <h4><span class="upcoming-text">{{$val->name}}</span></h4>

                         <p>Language: {{$val->language_taught}}</p>

                         <p>Duration: {{$val->time}}</p>

                         <h4>Price: {{$val->total}} USD </h4>

    					 <p>{{$val->package}}</p>

                         

                        </div>

                    </div>

                    @endforeach

                @else

                    <div class="my-lesson-list">

                       <div class="row align-items-center">

                          <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                            <span class="upcoming-text">No data found!!</span>

                          </div>

                       </div>

                    </div>

                @endif

                     

              </div>



            

            

          </div>  

          

          

          

          <div class="col-lg-12 col-md-12 col-sm-12 col-12 inactive-tab mt-5">  

            <h3><i class="fa fa-stop-circle" aria-hidden="true"></i> Inactive {{count($inactive_packages)}}</h3>

            

             <div class="row">

                @if(count($inactive_packages)>0)

                    @foreach($inactive_packages as $val)

                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                    <div class="gride-box lesson-list-box">   

                      <span class="gride-boxicon">

                         <img src="https://staging.tokatif.com/storage/app/user_photo/active_inactive.jpg" class="img-fluid">

					 </span>

                     

                     <h4><span class="upcoming-text">{{$val->name}}</span></h4>

                     <p>Language: {{$val->language_taught}}</p>

                     <p>Duration: {{$val->time}}</p>

                     <h4>Price: {{$val->total}} USD </h4>

					 <p>{{$val->package}}</p>

                     

                    </div>

                </div>

                    @endforeach

                @else

                

                  

                 <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                        <span class="upcoming-text">No data found!!</span>

                      </div>

                   

             

                @endif 

                 

              </div>

            



            



            <!--<div class="my-lesson-list">



               <div class="row align-items-center">



                  <div class="col-lg-8 col-md-8 col-sm-8 col-12">



                    <ul class="lesson-list-box">



                      <li><h4> 15 </h4> Nov</li>



                      <li> 03:00 AM <br> <span class="upcoming-text">Upcoming In 32 Days</span></li>



                      <li> Chinese <br> Language</li>



                      <li> 30 minutes <br> Duration</li>



                    </ul>



                  </div>



                  <div class="col-lg-4 col-md-4 col-sm-4 col-12">



                    <div class="row align-items-center lesson-list-right">



                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">



                     <img src="images/profile-upload.png" class="img-fluid"></div>



                   



                    <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">



                       <h4>Mr. Zhang</h4>



                       <p>473 Lessons</p>



                    </div>  



     



                    <div class="col-lg-2 col-md-2 col-sm-12 col-12">



                     <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>



                    </div>



                    



                </div>



                  </div>



               </div>



            </div> --> 

            

          </div> 

         

        </div>



   



    </div>



   </div>



  </div>



</section>

	</div>

	<div class="tab-pane" id="tabs-3" role="tabpanel">

		<section class="calender-full-page">
            <div class="container">
                <div class="row">
        
                    <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                      @include('include/teacher-left-sidebar')
                    </div>
        
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
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
                        <section class="lessonnew-page">
                            <div class="container">
                                <form role="form" action="{{ route('send-lesson-invitation') }}" method="POST" enctype="multipart/form-data" >
                                    {{ csrf_field() }}
                                <div class="information-section">
                                    <!--<div class="form-row">
                                        <div class="form-group col-lg-12 img-select">
                                            <label>Choose a Student</label>
                                            <select name="student_id" id="i_student_id" class="vodiapicker">
                                                @foreach($students as $val)
                                                    @php 
                                                        $exists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );
                                                        
                                                        if($exists && $val->profile_photo!='') {
                                                            $photo = url('storage/app/user_photo/'.$val->profile_photo);
                                                        }else{
                                                            $photo = Asset("public/assets/dist/img/transparent.png");
                                                        }
                                                    @endphp
                                                <option value="{{$val->id}}" class="test" data-thumbnail="{{$photo}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>

                                            <div class="lang-select">
                                                <button class="btn-select" value=""></button>
                                                <div class="b">
                                                    <ul id="a"></ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="">Choose a Student</label>
                                            <select name="student_id" id="i_student_id" class="form-control custom-select invitationType">
                                                <option value="">Please Select</option> 
                                                @foreach($students as $val)
                                                    @php 
                                                        $exists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );
                                                        
                                                        if($exists && $val->profile_photo!='') {
                                                            $photo = url('storage/app/user_photo/'.$val->profile_photo);
                                                        }else{
                                                            $photo = Asset("public/assets/dist/img/transparent.png");
                                                        }
                                                    @endphp
                                                <option value="{{$val->id}}" {{ (Request::old('student_id') == $val->id) ? 'selected' : '' }} class="test" data-thumbnail="{{$photo}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                            
                                            @if($errors->has('student_id'))
                                                <span class="text-danger">{{ $errors->first('student_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <label for="inputEmail4">Choose a option</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <div class="slot-box">
                                              <h4>Lesson</h4>
                                              <input class="form-check-input invitationType" type="radio" name="type" id="exampleRadios1" value="lesson" {{ Request::old('type') == "lesson" ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <div class="slot-box">
                                              <h4>Package</h4>
                                              <input class="form-check-input invitationType" type="radio" name="type" id="exampleRadios2" value="package" {{ Request::old('type') == "package" ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                        @if($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-row LanguagesDivClass">
                                        <div class="form-group col-md-12">
                                            <label for="">Choose a Languages</label>
                                            <select name="language_taught" id="language_taught" class="form-control custom-select">
                                              <option value="">Please Select</option> 
                                              @foreach($lessons as $val)
                                              <option value="{{$val->language_taught}}" {{ (Request::old('language_taught') == $val->language_taught) ? 'selected' : '' }}>{{$val->language_taught}}</option>
                                              @endforeach
                                            </select>
                                            
                                            @if($errors->has('language_taught'))
                                                <span class="text-danger">{{ $errors->first('language_taught') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row LessonDivClass">
                                        <div class="form-group col-md-12">
                                            <label for="">Choose a Lesson</label>
                                            <select name="lesson_id" id="i_lesson_id" class="form-control custom-select">
                                              <option value="">Please Select</option>
                                              @foreach($lessons as $val)
                                              <option value="{{$val->id}}" {{ (Request::old('lesson_id') == $val->id) ? 'selected' : '' }}>{{$val->name}}</option>
                                              @endforeach
                                            </select>
                                            
                                            @if($errors->has('lesson_id'))
                                                <span class="text-danger">{{ $errors->first('lesson_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="">Choose Communication Tool</label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <div class="slot-box">
                                              <h4><span><img src="{{Asset("public/frontendassets/images/skype.png")}}" class="img-fluid"></span> Skype</h4>
                                              <input class="form-check-input iCommunicationTool" type="radio" name="communication_tool" id="exampleRadios5" value="skype" {{ Request::old('communication_tool') == "skype" ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <div class="slot-box">
                                              <h4><span><img src="{{Asset("public/frontendassets/images/zoom_1.png")}}" class="img-fluid"></span> Zoom</h4>
                                              <input class="form-check-input iCommunicationTool" type="radio" name="communication_tool" id="exampleRadios6" value="zoom" {{ Request::old('communication_tool') == "zoom" ? 'checked' : '' }} >
                                            </div>
                                        </div>
                                        @if($errors->has('communication_tool'))
                                            <span class="text-danger">{{ $errors->first('communication_tool') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-lg-12 col-12 bookright-icon mt-3">
                                            <input type="text" class="form-control" name="communication_tool_id" id="communication_tool_id" value="{{Request::old('communication_tool_id')}}" placeholder="Communication Tool ID" >
                                            @if($errors->has('communication_tool_id'))
                                                <span class="text-danger">{{ $errors->first('communication_tool_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row slot-time">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <label for="inputEmail4">Duration:</label>
                                        </div>
                                       <div class="col-lg-12 col-md-12 col-sm-12 col-12"> 
                                        <div class="row" id="fetchAllPackages">
                                          
                                        
                                        
                                        </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-3  mb-5 mt-4"> 
                                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                              <label>Price</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9 mb-5 mt-4">
                                            <div class="input-group">
                                              <input type="number" class="form-control" name="old_price" id="old_price" value="{{Request::old('old_price')}}" placeholder="$" readonly>
                                              <div class="input-group-prepend"> <span class="input-group-text" id="">USD</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row OfferPriceDivClass">
                                        <div class="form-group col-md-3  mb-5 mt-4"> 
                                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                              <input type="checkbox" class="custom-control-input" id="saveinformation">
                                              <label class="custom-control-label" for="saveinformation">Offer a new price</label>
                                            </div>
                                        </div>
                                        <div class="col-md-9 mb-5 mt-4">
                                            <div class="input-group">
                                              <input type="number" class="form-control" name="offer_price" id="offer_price" value="{{Request::old('offer_price')}}" placeholder="$" aria-describedby="inputGroupPrepend">
                                              <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupPrepend">USD</span> </div>
                                            </div>
                                            @if($errors->has('offer_price'))
                                                <span class="text-danger">{{ $errors->first('offer_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <section class="schedule-time">
                                        <h4>Schedule Time</h4>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="schedule_time" id="exampleRadiosSingle" value="Single" {{ Request::old('schedule_time') == "Single" ? 'checked' : '' }} >
                                                  <label class="form-check-label" for="exampleRadiosSingle"> Single </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="form-check">
                                                  <input class="form-check-input" type="radio" name="schedule_time" id="exampleRadiosWeekly" value="Weekly" {{ Request::old('schedule_time') == "Weekly" ? 'checked' : '' }} >
                                                  <label class="form-check-label" for="exampleRadiosWeekly"> Weekly </label>
                                                </div>
                                            </div>    
                                            @if($errors->has('schedule_time'))
                                                <span class="text-danger">{{ $errors->first('schedule_time') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-row mt-3"> 
                                            <div class="form-group col-md-6 calender-icon">
                                                <label for="inputEmail4">Choose a date</label>
                                                <input type="date" name="i_date" class="form-control" id="i_inputDate" value="{{Request::old('i_date')}}" >
                                                @if($errors->has('i_date'))
                                                    <span class="text-danger">{{ $errors->first('i_date') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">  
                                                <div class="form-group col-md-12 pl-0 m-0">
                                                    <label for="inputEmail4">Choose a Time</label>
                                                </div>
                                                <div class="form-row"> 
                                                    <div class="form-group col-md-5 pr-0">
                                                      <select name="from_time" id="from_time" class="form-control custom-select">
                                                        <option value="">From</option>
                                                        <?php 
                                                            $start = strtotime('00:00');
                                                            $end   = strtotime('23:30');
                                
                                                            for ($i=$start; $i<=$end; $i = $i + 30*60){
                                                               echo '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';
                                                            }
                                                        ?>
                                                      </select>
                                                      
                                                        @if($errors->has('from_time'))
                                                            <span class="text-danger">{{ $errors->first('from_time') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-5 p-0">
                                                      <select name="to_time" id="to_time" class="form-control custom-select">
                                                        <option value="">To</option>
                                                        <?php 
                                                            $start = strtotime('00:00');
                                                            $end   = strtotime('23:30');
                                
                                                            for ($i=$start; $i<=$end; $i = $i + 30*60){
                                                               echo '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';
                                                            }
                                                        ?>
                                                      </select>
                                                      
                                                        @if($errors->has('to_time'))
                                                            <span class="text-danger">{{ $errors->first('to_time') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-2 pl-0 len-delite text-center">
                                                      
                                                    </div>
                                                </div>
                                            </div>                           
                                                    
                                        </div>
                                    </section>
                                    <section class="confirmation-table">
                                        <h4>Confirmation</h4>
                                        <div class="form-row">       
                                            <div class="form-group col-md-12">
                                                <div class="confirmation-table-border">
                                                    <table class="wallet-invoice-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody> 
                                                            <tr>
                                                                <td>Schedule lesson with</td>
                                                                <td align="right" id="StudentName"></td>
                                                            </tr>
                                                            <tr style="display:none;">
                                                                <td>Lesson</td>
                                                                <td align="right" id="LessonName"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Language </td>
                                                                <td align="right" id="LanguageName"></td>
                                                            </tr>
                                                            <tr style="display:none;">
                                                                <td>Duration </td>
                                                                <td align="right" id="LessonDuration"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Price</td>
                                                                <td align="right" id="LessonPrice"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date </td>
                                                                <td align="right" id="LessonDate"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                                                                     
                                        </div>
                                    </section> 
                                    
                                    <button type="submit" class="btn btn-submit">Send a lesson invitation</button>
                                </div>
                                </form>
                            </div>
                        </section>
                    </div>
        
                </div>
            </div>
        </section>
        
	</div>

</div>



</section>


@include('include/footer')



<script>
//test for getting url value from attr
// var img1 = $('.test').attr("data-thumbnail");
// console.log(img1);

//test for iterating over child elements
var langArray = [];
$('.vodiapicker option').each(function(){
  var img = $(this).attr("data-thumbnail");
  var text = this.innerText;
  var value = $(this).val();
  var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
  langArray.push(item);
})

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', 'en');

//change button stuff on click
$('#a li').click(function(){
   var img = $(this).find('img').attr("src");
   var value = $(this).find('img').attr('value');
   var text = this.innerText;
   var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
  $('.btn-select').html(item);
  $('.btn-select').attr('value', value);
  $(".b").toggle();
  //console.log(value);
});

$(".btn-select").click(function(){
        $(".b").toggle();
    });

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang){
  //find an item with value of sessionLang
  var langIndex = langArray.indexOf(sessionLang);
  $('.btn-select').html(langArray[langIndex]);
  $('.btn-select').attr('value', sessionLang);
} else {
   var langIndex = langArray.indexOf('ch');
  console.log(langIndex);
  $('.btn-select').html(langArray[langIndex]);
  //$('.btn-select').attr('value', 'en');
}

</script>









<!-- Modal -->
<div class="modal fade" id="addTeacherAvailability" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Available Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="timeAvailabilityForm"> 
                    <input type="hidden" id="user_id" value="{{session('id')}}" /> 
                    <input type="hidden" id="selected_date" value="" /> 
                    <input type="hidden" id="selected_dayBtn" value="" /> 
                    <input type="hidden" id="selected_dateBtn" value="" /> 

                    <div id="newTimeSlot" class="timeSlotDiv">
                        <div class="form-row mb-2 align-items-center" id="timesDiv"></div>
                    </div>

                    <div class="form-row mb-2">
                        <div class="form-group col-md-12">
                            <div class="add-time-slot"><a href="javascript:void(0);" id="timeSlotAppend"><span>+</span><span>Add New Time Slot</span></a></div>
                        </div>
                    </div>
                    <div class="confirm-box" id="availabilityButton"></div>
                </form>
            </div>
        </div>
    </div>
</div>


























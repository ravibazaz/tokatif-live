@include('include/head')

@include('include/teacher-dashboard-header')



@php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

@endphp



<section class="lesson-package">

<div class="container">

  <div class="row">
  
  <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      @include('include/teacher-left-sidebar')

     </div>
  

   <div class="col-lg-9 col-md-9 col-sm-12 col-12">

       <ul class="nav nav-tabs" id="myTab" role="tablist">

          <li class="nav-item">

            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Students</a>

          </li>

          <li class="nav-item">

            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactive Students</a> 

          </li>

          <li class="nav-item">

            <a class="nav-link" id="potential-tab" data-toggle="tab" href="#potential" role="tab" aria-controls="potential" aria-selected="false">Potential Students</a> 

          </li>

        </ul>

        <div class="tab-content" id="myTabContent">

          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                

            <div class="student-lists">

                    <section class="student-lists-info">

                        <section class="lists-titles">

                          <section class="lists-title-name flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Name</span></section>

                          <section class="lists-title-total flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Total Lessons</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="These are the amount of lessons that the student has completed with you." width="18px"></span></span></span></section>

                          <section class="lists-title-filter lists-title-time flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="show-up-img" height="13"><span>Lesson Time</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="This learning language is based on what the student selected in your contact teacher form. If you only have one teaching language, the system will default to that language as the learning language." width="18px"></span></span></span></section>

                          <section class="lists-title lists-title-skill flex-2"><span>Language Skills</span></section>

                          <section class="lists-title list-title-action "><span>Actions</span></section>

                        </section>

                        

                        @if(count($active)>0)

                            @foreach($active as $val)

                                @php

                                    $studentData = DB::table('registrations')->where('id', '=', $val->student_id)->first(); 

                                    

                                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                                @endphp

                                

                                @php $flag = ''; @endphp

                                @if($val->country_living_in!='')

                                    @php

                                        $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 

                                        $flag = strtolower($countryFlagData->sortname);

                                    @endphp

                                @else

                                    @php

                                        $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

                                        $flag = strtolower($countryFlagData->sortname);

                                    @endphp

                                @endif

                                

                                

                                <div class="student-list">

                                    <div class="student-list-box">

                                        <div class="student-name-part flex-2">

                                          <div class="student-info "><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><div><span style="width: 40px; height: 40px; line-height: 40px; font-size: 18px;" class="ant-avatar ant-avatar-circle ant-avatar-image">

                                                

                                                @if($exists && $studentData->profile_photo!='') 

                                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                                @else

                                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                                @endif

                                                

                                                @if($flag)

                                                    @php $cFlag = asset('public/frontendassets/images/flags/'.$flag.'.png'); @endphp

                                                @else

                                                    @php $cFlag = asset('public/frontendassets/images/flage.png'); @endphp

                                                @endif

                            

                                                

                                                <i class="ant-avatar-flag" style="display: inline-block; background-size: contain; background-position: 50% center; background-repeat: no-repeat; border-radius: 50%; border: 1px solid rgb(233, 233, 235); right: 0px; width: 16px; height: 16px; background-image: url(&quot;{{$cFlag}}&quot;);"></i></span></div></span></span></span><div class="country-flag"><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><!--<div class="offline"><span>Offline</span></div>--></span></span></span></div></div>

                                          <div class="student-name">{{$studentData->name}}</div>

                                        </div>

                                        <div class="lists-title-potential-name flex-2">

                                            @php

                                                $lessonCount = DB::table('booking')->where('student_id', '=', $val->student_id)->where('teacher_id', '=', session('id'))->count(); 

                                            @endphp

                                          <div><span></span> • <span>{{$lessonCount}}</span></div>

                                        </div>

                                        <div class="lessons-time flex-2">

                                            @php

                                                $days = '';

                                                if($lessonCount>0){

                                                    $lastBooking = DB::table('booking')->where('student_id', '=', $val->student_id)

                                                                                    ->where('teacher_id', '=', session('id'))

                                                                                    ->orderBy('created_at', 'desc')->first();

                                                                                    

                                                    if($lastBooking->booking_date > date('Y-m-d')){

                                                        $datetime1 = new DateTime(date('Y-m-d'));

                                                        $datetime2 = new DateTime($lastBooking->booking_date);

                                                        $difference = $datetime1->diff($datetime2);

                                                        $days = $difference->d.' days ago'; 

                                                    }else{

                                                        $datetime1 = new DateTime($lastBooking->booking_date);

                                                        $datetime2 = new DateTime(date('Y-m-d'));

                                                        $difference = $datetime1->diff($datetime2);

                                                        $days = 'after '.$difference->d.' days';

                                                    }

                                                }

                                                

                                            @endphp

                                          <div class="last-time">{{$days}}</div>

                                        </div>

                                        <div class="language-skills flex-2">

                            @php

                              $skillLanguageArr = json_decode($studentData->languages_spoken, true);  //dd($skillLanguageArr); 

                            @endphp

                            

                            @if(count($skillLanguageArr)>0)

                                @foreach($skillLanguageArr as $key=>$v)

                                    @php

                                      if($v['level']=='Native')

                                        $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                      elseif($v['level']=='Beginner')

                                        $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                      elseif($v['level']=='Elementary')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Intermediate')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Upper Intermediate')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Advanced')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Proficient')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='')

                                        $l_span = '<span class="level level-color-1"></span>';

                                    @endphp

                                    

                                    <div>

                                        <span class="language"><span>{{ $v['language'] }}</span></span>

                                        <span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference">

                                            <div><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span></div>

                                            </span></span>

                                        </span>

                                    </div>

                            

                                @endforeach

                            @endif

                            

                          

                        </div>

                                        <div class="student-handle ">

                                          <div class="ActionStudentBtn-desktop">

                                            <span class="nav-item dropdown">

                                              <a class="nav-item mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                               <img class="more-btn" src="https://scdn.italki.com/orion/static/media/more.636a5540.svg" alt="more" width="20" height="20">

                                              </a>

                                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions"> 

                                                <!--<a href="{{ route('send-lesson-invitation',['id'=>$val->student_id]) }}" class="dropdown-item">Send a Lesson Invitation</a>-->

                                                <a href="{{ route('block-student',['id'=>$val->student_id]) }}" onclick="return confirm('Do you really want to block the student?')" class="dropdown-item">Block</a>

                                                <!--<a class="dropdown-item" href="#">Report</a>

                                                <a class="dropdown-item" href="#">Remove from this list</a>-->

                                              </div>

                                            </span>

                                          </div>

                                        </div>

                                    </div>

                                </div>

                               

                            @endforeach

                        @else

                            <div class="my-lesson-list">

                               <div class="row align-items-center">

                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                                    <ul class="lesson-list-box">

                                      <li><span class="upcoming-text">No active student found!!</span></li>

                                    </ul>

                                  </div>

                               </div>

                            </div>

                        @endif

                    </section>

                </div>

            

          </div>

          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

              

            <div class="student-lists">

                    <section class="student-lists-info">

                        <section class="lists-titles">

                          <section class="lists-title-name flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Name</span></section>

                          <section class="lists-title-total flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Total Lessons</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="These are the amount of lessons that the student has completed with you." width="18px"></span></span></span></section>

                          <section class="lists-title-filter lists-title-time flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="show-up-img" height="13"><span>Lesson Time</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="This learning language is based on what the student selected in your contact teacher form. If you only have one teaching language, the system will default to that language as the learning language." width="18px"></span></span></span></section>

                          <section class="lists-title lists-title-skill flex-2"><span>Language Skills</span></section>

                          <section class="lists-title list-title-action "><span>Actions</span></section>

                        </section>

                        

                        @if(count($inactive)>0)

                            @foreach($inactive as $val)

                                @php

                                    $studentData = DB::table('registrations')->where('id', '=', $val->student_id)->first(); 

                                    

                                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                                @endphp

                                

                                @php $flag = ''; @endphp

                                @if($val->country_living_in!='')

                                    @php

                                        $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 

                                        $flag = strtolower($countryFlagData->sortname);

                                    @endphp

                                @else

                                    @php

                                        $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

                                        $flag = strtolower($countryFlagData->sortname);

                                    @endphp

                                @endif

                                

                                

                                <div class="student-list">

                                    <div class="student-list-box">

                                        <div class="student-name-part flex-2">

                                          <div class="student-info "><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><div><span style="width: 40px; height: 40px; line-height: 40px; font-size: 18px;" class="ant-avatar ant-avatar-circle ant-avatar-image">

                                                

                                                @if($exists && $studentData->profile_photo!='') 

                                                    <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                                @else

                                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                                @endif

                                                

                                                @if($flag)

                                                    @php $cFlag = asset('public/frontendassets/images/flags/'.$flag.'.png'); @endphp

                                                @else

                                                    @php $cFlag = asset('public/frontendassets/images/flage.png'); @endphp

                                                @endif

                            

                                                

                                                <i class="ant-avatar-flag" style="display: inline-block; background-size: contain; background-position: 50% center; background-repeat: no-repeat; border-radius: 50%; border: 1px solid rgb(233, 233, 235); right: 0px; width: 16px; height: 16px; background-image: url(&quot;{{$cFlag}}&quot;);"></i></span></div></span></span></span><div class="country-flag"><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><!--<div class="offline"><span>Offline</span></div>--></span></span></span></div></div>

                                          <div class="student-name">{{$studentData->name}}</div>

                                        </div>

                                        <div class="lists-title-potential-name flex-2">

                                            @php

                                                $lessonCount = DB::table('booking')->where('student_id', '=', $val->student_id)->where('teacher_id', '=', session('id'))->count(); 

                                            @endphp

                                          <div><span></span> • <span>{{$lessonCount}}</span></div>

                                        </div>

                                        <div class="lessons-time flex-2">

                                            @php

                                                $days = '';

                                                if($lessonCount>0){

                                                    $lastBooking = DB::table('booking')->where('student_id', '=', $val->student_id)

                                                                                    ->where('teacher_id', '=', session('id'))

                                                                                    ->orderBy('created_at', 'desc')->first();

                                                                                    

                                                    if($lastBooking->booking_date > date('Y-m-d')){

                                                        $datetime1 = new DateTime(date('Y-m-d'));

                                                        $datetime2 = new DateTime($lastBooking->booking_date);

                                                        $difference = $datetime1->diff($datetime2);

                                                        $days = $difference->d.' days ago'; 

                                                    }else{

                                                        $datetime1 = new DateTime($lastBooking->booking_date);

                                                        $datetime2 = new DateTime(date('Y-m-d'));

                                                        $difference = $datetime1->diff($datetime2);

                                                        $days = 'after '.$difference->d.' days';

                                                    }

                                                }

                                                

                                            @endphp

                                          <div class="last-time">{{$days}}</div>

                                        </div>

                                        <div class="language-skills flex-2">

                            @php

                              $skillLanguageArr = json_decode($studentData->languages_spoken, true);  //dd($skillLanguageArr); 

                            @endphp

                            

                            @if(count($skillLanguageArr)>0)

                                @foreach($skillLanguageArr as $key=>$v)

                                    @php

                                      if($v['level']=='Native')

                                        $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                      elseif($v['level']=='Beginner')

                                        $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                      elseif($v['level']=='Elementary')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Intermediate')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Upper Intermediate')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Advanced')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='Proficient')

                                        $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                      elseif($v['level']=='')

                                        $l_span = '<span class="level level-color-1"></span>';

                                    @endphp

                                    

                                    <div>

                                        <span class="language"><span>{{ $v['language'] }}</span></span>

                                        <span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference">

                                            <div><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span></div>

                                            </span></span>

                                        </span>

                                    </div>

                            

                                @endforeach

                            @endif

                            

                          

                        </div>

                                        <div class="student-handle ">

                                          <div class="ActionStudentBtn-desktop">

                                            <span class="nav-item dropdown">

                                              <a class="nav-item mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                               <img class="more-btn" src="https://scdn.italki.com/orion/static/media/more.636a5540.svg" alt="more" width="20" height="20">

                                              </a>

                                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">

                                                <!--<a class="dropdown-item" href="#">Block</a>-->

                                                <a href="{{ route('block-student',['id'=>$val->student_id]) }}" onclick="return confirm('Do you really want to block the student?')" class="dropdown-item">Block</a>

                                                <!--<a class="dropdown-item" href="#">Report</a>

                                                <a class="dropdown-item" href="#">Remove from this list</a>-->

                                              </div>

                                            </span>

                                          </div>

                                        </div>

                                    </div>

                                </div>

                               

                            @endforeach

                        @else

                            <div class="my-lesson-list">

                               <div class="row align-items-center">

                                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                                    <ul class="lesson-list-box">

                                      <li><span class="upcoming-text">No inactive student found!!</span></li>

                                    </ul>

                                  </div>

                               </div>

                            </div>

                        @endif

                    </section>

                </div>

            

          </div>

          <div class="tab-pane fade" id="potential" role="tabpanel" aria-labelledby="potential-tab">

              

            <div class="student-lists">

                <section class="student-lists-info">

                    <section class="lists-titles">

                      <section class="lists-title-name flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Name</span></section>

                      <section class="lists-title-total flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="hidden-up-img" height="13"><span>Total Lessons</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="These are the amount of lessons that the student has completed with you." width="18px"></span></span></span></section>

                      <section class="lists-title-filter lists-title-time flex-2"><img src="https://scdn.italki.com/orion/static/media/coloredDown.a1ae761d.svg" alt="arrow" class="show-up-img" height="13"><span>Lesson Time</span><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference"><img class="AccountSettings-suportIcon" src="https://scdn.italki.com/orion/static/media/support.0600426c.svg" style="margin-left: 11px;" alt="This learning language is based on what the student selected in your contact teacher form. If you only have one teaching language, the system will default to that language as the learning language." width="18px"></span></span></span></section>

                      <section class="lists-title lists-title-skill flex-2"><span>Language Skills</span></section>

                      <section class="lists-title list-title-action "><span>Actions</span></section>

                    </section>

                    

                    @if(count($potential)>0)

                        @foreach($potential as $val)

                            @php

                                $studentData = DB::table('registrations')->where('id', '=', $val->student_id)->first(); 

                                

                                $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );

                            @endphp

                            

                            @php $flag = ''; @endphp

                            @if($val->country_living_in!='')

                                @php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 

                                    $flag = strtolower($countryFlagData->sortname);

                                @endphp

                            @else

                                @php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

                                    $flag = strtolower($countryFlagData->sortname);

                                @endphp

                            @endif

                            

                            

                            <div class="student-list">

                                <div class="student-list-box">

                                    <div class="student-name-part flex-2">

                                      <div class="student-info "><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><div><span style="width: 40px; height: 40px; line-height: 40px; font-size: 18px;" class="ant-avatar ant-avatar-circle ant-avatar-image">

                                            

                                            @if($exists && $studentData->profile_photo!='') 

                                                <img src="{{url('storage/app/user_photo/'.$studentData->profile_photo)}}" class="img-fluid">

                                            @else

                                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   

                                            @endif

                                            

                                            @if($flag)

                                                @php $cFlag = asset('public/frontendassets/images/flags/'.$flag.'.png'); @endphp

                                            @else

                                                @php $cFlag = asset('public/frontendassets/images/flage.png'); @endphp

                                            @endif

                        

                                            

                                            <i class="ant-avatar-flag" style="display: inline-block; background-size: contain; background-position: 50% center; background-repeat: no-repeat; border-radius: 50%; border: 1px solid rgb(233, 233, 235); right: 0px; width: 16px; height: 16px; background-image: url(&quot;{{$cFlag}}&quot;);"></i></span></div></span></span></span><div class="country-flag"><span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="right"><span class="tooltip-reference"><!--<div class="offline"><span>Offline</span></div>--></span></span></span></div></div>

                                      <div class="student-name">{{$studentData->name}}</div>

                                    </div>

                                    <div class="lists-title-potential-name flex-2">

                                        @php

                                            $lessonCount = DB::table('booking')->where('student_id', '=', $val->student_id)->where('teacher_id', '=', session('id'))->count(); 

                                        @endphp

                                      <div><span></span> • <span>{{$lessonCount}}</span></div>

                                    </div>

                                    <div class="lessons-time flex-2">

                                        @php

                                            $days = '';

                                            if($lessonCount>0){

                                                $lastBooking = DB::table('booking')->where('student_id', '=', $val->student_id)

                                                                                ->where('teacher_id', '=', session('id'))

                                                                                ->orderBy('created_at', 'desc')->first();

                                                                                

                                                if($lastBooking->booking_date > date('Y-m-d')){

                                                    $datetime1 = new DateTime(date('Y-m-d'));

                                                    $datetime2 = new DateTime($lastBooking->booking_date);

                                                    $difference = $datetime1->diff($datetime2);

                                                    $days = $difference->d.' days ago'; 

                                                }else{

                                                    $datetime1 = new DateTime($lastBooking->booking_date);

                                                    $datetime2 = new DateTime(date('Y-m-d'));

                                                    $difference = $datetime1->diff($datetime2);

                                                    $days = 'after '.$difference->d.' days';

                                                }

                                            }

                                            

                                        @endphp

                                      <div class="last-time">{{$days}}</div>

                                    </div>

                                    <div class="language-skills flex-2">

                        @php

                          $skillLanguageArr = json_decode($studentData->languages_spoken, true);  //dd($skillLanguageArr); 

                        @endphp

                        

                        @if(count($skillLanguageArr)>0)

                            @foreach($skillLanguageArr as $key=>$v)

                                @php

                                  if($v['level']=='Native')

                                    $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                  elseif($v['level']=='Beginner')

                                    $l_span = '<span class="level level-color-2"></span><span class="level level-color-2"></span><span class="level level-color-2"></span>';

                                  elseif($v['level']=='Elementary')

                                    $l_span = '<span class="level level-color-2 level-color-3"></span>';

                                  elseif($v['level']=='Intermediate')

                                    $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                  elseif($v['level']=='Upper Intermediate')

                                    $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                  elseif($v['level']=='Advanced')

                                    $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                  elseif($v['level']=='Proficient')

                                    $l_span = '<span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span>';

                                  elseif($v['level']=='')

                                    $l_span = '<span class="level level-color-1"></span>';

                                @endphp

                                

                                <div>

                                    <span class="language"><span>{{ $v['language'] }}</span></span>

                                    <span class="tooltip-container-box" gap="5"><span class="tooltip-container" placement="bottom"><span class="tooltip-reference">

                                        <div><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span><span class="level level-color-2 level-color-3"></span></div>

                                        </span></span>

                                    </span>

                                </div>

                        

                            @endforeach

                        @endif

                        

                      

                    </div>

                                    <div class="student-handle ">

                                      <div class="ActionStudentBtn-desktop">

                                        <span class="nav-item dropdown">

                                          <a class="nav-item mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                           <img class="more-btn" src="https://scdn.italki.com/orion/static/media/more.636a5540.svg" alt="more" width="20" height="20">

                                          </a>

                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">

                                            <!--<a class="dropdown-item" href="#">Block</a>-->

                                            <a href="{{ route('block-student',['id'=>$val->student_id]) }}" onclick="return confirm('Do you really want to block the student?')" class="dropdown-item">Block</a>

                                            <!--<a class="dropdown-item" href="#">Report</a>

                                            <a class="dropdown-item" href="#">Remove from this list</a>-->

                                          </div>

                                        </span>

                                      </div>

                                    </div>

                                </div>

                            </div>

                           

                        @endforeach

                    @else

                        <div class="my-lesson-list">

                           <div class="row align-items-center">

                              <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                                <ul class="lesson-list-box">

                                  <li><span class="upcoming-text">No potential student found!!</span></li>

                                </ul>

                              </div>

                           </div>

                        </div>

                    @endif

                </section>

            </div>



          </div>

        </div>

   

    </div>

   </div>

  </div>

</section>





@include('include/footer')










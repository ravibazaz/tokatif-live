@include('include/head')
@include('include/student-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp



<section class="step lesson-booking"> 
   <div class="container-fluid">
            <div class="row">
                  
                <div class="col-md-12  m-auto">
                    <section class="signup-step-container tab-section books_lesson_step">
                        
                        <div class="container-fluid">
                            
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
                          
                          
                  
                        @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $message)
                                      <li>{{ $message }}</li>
                                  @endforeach
                              </ul>
                          </div>
                        @endif
                        
                        
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-11 m-auto">
                                <div class="wizard">
                                    <div class="wizard-inner">
                                        <div class="connecting-line"></div>
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="<?php if (isset($_GET['year']) && isset($_GET['week'])) {echo 'disabled';}else{echo 'active';}?>">
                                                <a href="#lesson-step1" data-toggle="tab" aria-controls="lesson-step1" role="tab" aria-expanded="true">
                                                <span class="round-tab"><img src="{{ asset('public/frontendassets/images/stepimg1.png') }}" class="img-fluid"/></span> 
                                                <i>Select Lesson Type</i></a>
                                            </li>
                                            <li role="presentation" class="disabled">
                                                <a href="#lesson-step2" data-toggle="tab" aria-controls="lesson-step2" role="tab" aria-expanded="false">
                                                <span class="round-tab"><img src="{{ asset('public/frontendassets/images/stepimg2.png') }}" class="img-fluid"/></span> <i>Choose Lesson Options</i></a>
                                            </li>
                                            <li role="presentation" class="<?php if (isset($_GET['year']) && isset($_GET['week'])) {echo 'active';}else{echo 'disabled';}?>">
                                                <a href="#lesson-step3" data-toggle="tab" aria-controls="lesson-step3" role="tab">
                                                <span class="round-tab"><img src="{{ asset('public/frontendassets/images/stepimg3.png') }}" class="img-fluid"/></span> <i>Schedule Your Lessons</i></a>
                                            </li>
                                            <li role="presentation" class="disabled">
                                                <a href="#lesson-step4" data-toggle="tab" aria-controls="lesson-step4" role="tab">
                                                <span class="round-tab"><img src="{{ asset('public/frontendassets/images/stepimg4.png') }}" class="img-fluid"/></span> <i>Communication Tool</i></a>
                                            </li>
                                             <li role="presentation" class="disabled">
                                                <a href="#lesson-step5" data-toggle="tab" aria-controls="lesson-step5" role="tab">
                                                <span class="round-tab"><img src="{{ asset('public/frontendassets/images/stepimg5.png') }}" class="img-fluid"/></span> <i>Payment</i></a>
                                            </li>
                                        </ul>
                                    </div>
                    

                                    <!--<form action="{{ route('booking-data', ['id' => Request::segment(2)]) }}"  method="GET" class="login-box"> -->
                                        {{-- csrf_field() --}}
                                        <input type="hidden" name="teacher_id" value="{{Request::segment(2)}}" />
                                        <input type="hidden" name="booking_lesson_id" id="booking_lesson_id" value="" />
                                        <input type="hidden" name="booking_lesson_package_id" id="booking_lesson_package_id" value="" />
                                        <input type="hidden" name="booking_date" id="booking_date" value="" />
                                        <input type="hidden" name="booking_time" id="booking_time" value="" /> 
                                        <input type="hidden" name="booking_amount" id="booking_amount" value="" /> 
                                        <input type="hidden" id="slot" value="{{ session('b_booking_slot') ? session('b_booking_slot') : '' }}" />

                                        <div class="tab-content" id="main_form">
                                            <div class="tab-pane <?php if (isset($_GET['year']) && isset($_GET['week'])) {echo '';}else{echo 'active';}?>" role="tabpanel" id="lesson-step1">
                                                <div class="row mt-5"> 
                                                
                                                    @if(count($lessons)>0)
                                                    <div class="col-lg-9 col-12">
                                                       @foreach($lessons as $v)
                                                        @php
                                                            $packageData = DB::table('lesson_packages')->where('lesson_id', $v->id)->min('total');

                                                            $min_individual_lesson = DB::table('lesson_packages')->where('lesson_id', $v->id)->min('individual_lesson');

                                                            $min_amount = $min_individual_lesson;
                                                            if($min_individual_lesson > $packageData)
                                                            {
                                                              $min_amount = $packageData;
                                                            }
                                                        @endphp
           
                                                      @if($packageData)
                                                      <div class="lesson-box-select " data-lesson_name="{{ $v->name }}" data-lessonId="{{$v->id}}" style="cursor: pointer;">
                                                       <div class="row align-items-center"> 
                                                        <div class="col-lg-6 col-12">{{$v->name}}</div>
                                                        <div class="col-lg-3 col-12">{{$v->lesson_option}}</div> 
                                                        <div class="col-lg-3 col-12"> 
                                                         <div class="form-check">
                                                          USD {{number_format($min_amount,2)}} 
                                                          <input class="form-check-input" type="radio" name="lesson_id" id="lesson_id" value="{{$v->id}}" >
                                                        </div></div>
                                                        </div>
                                                      </div>
                                                      @endif
                                                      @endforeach
                                                      
                                                      
                                                    </div>
                                                    @else
                                                    <div class="col-lg-9 col-12 my-lessons my-teacher-00 recommended-teacher">
                                                        <h3 class="text-center" style="font-size: 32px;color: #929292;margin-top: 8px;">No time slot found!!</h3>
                                                    </div> 
                                                    @endif
                                                    
                                                    <div class="col-lg-3 col-12">
                                                        <div class="my-lessons my-teacher-00 recommended-teacher">
                                                            <div class="row">
                                                            @php 
                                                                $exists = file_exists( storage_path() . '/app/user_photo/' . $selected_teacher->profile_photo );
                                                            @endphp
                                                                <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                                                 <div class="lesson-rightpic">
                                                                    @if($exists && $selected_teacher->profile_photo!='') 
                                                                        <img src="{{url('storage/app/user_photo/'.$selected_teacher->profile_photo)}}" class="img-fluid">
                                                                    @else
                                                                        <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                                                    @endif
                                                                    
                                                                    @php $flag = ''; @endphp
                                                                    @if($selected_teacher->country_living_in!='')
                                                                        @php
                                                                            $countryFlagData = DB::table('countries')->where('name', '=', $selected_teacher->country_living_in)->first(); 
                                                                            $flag = strtolower($countryFlagData->sortname);
                                                                        @endphp
                                                                    @else
                                                                        @php
                                                                            $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
                                                                            $flag = strtolower($countryFlagData->sortname);
                                                                        @endphp
                                                                    @endif
                                                                    
                                                                    <span class="offline-icon">
                                                                         @if($flag)
                                                                            <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                                                                         @else
                                                                            <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                                                                         @endif
                                                                    </span>
                                                                  </div>
                                                                 </div>
                                                                <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
                                                                   <h4>{{$selected_teacher->name}}</h4>
                                                                   
                                                                    @php
                                                                      if($selected_teacher->teacher_type=='specialist_teacher')
                                                                        $teacherType = 'Specialist Teacher';
                                                                      elseif($selected_teacher->teacher_type=='community_tutor')
                                                                        $teacherType = 'Community Tutor';
                                                                      
                                                                    @endphp
                                                
                                                                   <h5>{{ $teacherType }}</h5>
                                                                   <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                                                                </div>  
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(count($lessons)>0)
                                                <ul class="list-inline pull-right">
                                                    <li><button type="button" class="getLessonType default-btn next-step">Continue to next step </button></li>
                                                </ul>
                                                @endif
                                            </div>
                                            <div class="tab-pane" role="tabpanel" id="lesson-step2">
                                               
                                               <div class="row mt-5">
                                                <div class="col-lg-9">
                                                 <h3>Choose Lesson Options</h3>
                                                 <p>Lessons must be scheduled at least 12 hours in advance.  If you buy a package,
                                                  you will be able to schedule your lessons after purchase. 
                                                  Lessons must be scheduled within six months of purchase date.</p>
                                                 
                                                 <table id="lesson_packages_table" width="100%" border="0" cellspacing="0" cellpadding="0" class="booking-steptable mt-5">
                                                  <tr>
                                                    <td><h3>30 Mins</h3></td>
                                                    <td><h3>45 Mins</h3></td>
                                                    <td><h3>60 Mins</h3></td>
                                                    <td><h3>75 Mins</h3></td>
                                                    <td><h3>90 Mins</h3></td>
                                                  </tr>
                                                  
                                                  
                                                </table>
                                                </div>
                                                
                                                <div class="col-lg-3 col-12">
                                                    <div class="my-lessons my-teacher-00 recommended-teacher">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                                         <div class="lesson-rightpic">
                                                            @if($exists && $selected_teacher->profile_photo!='') 
                                                                <img src="{{url('storage/app/user_photo/'.$selected_teacher->profile_photo)}}" class="img-fluid">
                                                            @else
                                                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                                            @endif
                                                            
                                                            <span class="offline-icon">
                                                                @if($flag)
                                                                    <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                                                                @else
                                                                    <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                                                                @endif
                                                            </span>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
                                                            <h4>{{$selected_teacher->name}}</h4>
                                                            <h5>{{ $teacherType }}</h5>
                                                           <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                                                        </div>  
                                                    </div> 
                                                    
                                                    <div class="lesson-type-text">
                                                    <h5>Lesson Type</h5>
                                                    <p class="lesson_type">{{ session('b_lesson_name') ? session('b_lesson_name') : '' }}</p>
                                                    </div>
                                                    
                                                    <div class="lesson-type-text">
                                                     <div class="row align-items-center">
                                                      <div class="col-lg-7">
                                                       <h5>Lesson Package</h5>
                                                       <p class="package-text">{{ session('b_lesson_package') ? session('b_lesson_package') : '' }} &nbsp;&nbsp;&nbsp;
                                                       {{ session('b_lesson_package_time') ? session('b_lesson_package_time') : '' }}
                                                       </p>
                                                      </div>
                                                      <div class="col-lg-5"> <h3 class="amount-text">USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</h3></div>
                                                    </div>
                                                    </div>
                                                    
                                                  </div>
                                                    </div>
                                                
                                                </div>
            
                                               
                                                
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 text-left">
                                                     <button type="button" class="default-btn prev-step lesson-back">
                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                     Back</button>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6 text-right">
                                                       <button type="button" class="getLessonPackageType default-btn next-step">Next 
                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                  </button>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="tab-pane <?php if (isset($_GET['year']) && isset($_GET['week'])) {echo 'active';}else{echo '';}?>" role="tabpanel" id="lesson-step3">
                                              
                                              <div class="row mt-5">
                                                <div class="col-lg-9 col-12">
                                                
                                                <?php
                                                $dt = new DateTime;
                                                if (isset($_GET['year']) && isset($_GET['week'])) {
                                                    $dt->setISODate($_GET['year'], $_GET['week']);
                                                } else {
                                                    $dt->setISODate($dt->format('o'), $dt->format('W'));
                                                }
                                                $year = $dt->format('o');
                                                $week = $dt->format('W');
                                                
                                                
                                                // Get prev & next month
                                                if (isset($_GET['week']) && isset($_GET['year'])) {
                                                    $ym = $_GET['year'].'-'.$_GET['week'];
                                                } else {
                                                    // This month
                                                    $ym = date('Y-m');
                                                }
                                                
                                                $timestamp = strtotime($ym . '-01');
                                                if ($timestamp === false) {
                                                    $ym = date('Y-m');
                                                    $timestamp = strtotime($ym . '-01');
                                                }
                                                // For H3 title
                                                $html_title = date('M, Y', $timestamp);
                                                $prevWeek = ($week-1);
                                                $nextWeek = ($week+1);
                                                
                                                $currentWeek = date("W", strtotime(date('Y-m-d')));
                                                ?>
                                                <div class="table-scrool">
                                                <table width="100%" border="1" cellspacing="0" cellpadding="5" style="border-color:#eaeaea;" class="booking-table">
                                                    <tr>
                                                       <td colspan="8" style="padding:10px 0;">
                                                        <h4 class="text-center">
                                                            @if(($prevWeek >= $currentWeek) && ($year >= date('Y')))
                                                            <a href="?week={{$prevWeek}}&year={{$year}}" class="">&lt;</a> @endif
                                                                <?php 
                                                                if (isset($_GET['week']) && isset($_GET['year'])) {
                                                                    $d = date('Y-').'01-01';
                                                                    $selectedMonth = date("M", strtotime($d." ".$currentWeek." weeks"));
                                                                    
                                                                    $selectedMonthNo = date("m", strtotime($_GET['year'].'W'.str_pad($_GET['week'], 2, 0, STR_PAD_LEFT)));
                                                                    $jd=gregoriantojd($selectedMonthNo,10,2019);
                                                                    $selectedMonthName = jdmonthname($jd,0); 
                                                                    
                                                                    echo $selectedMonthName;
                                                                }else{
                                                                    echo $html_title; 
                                                                }
                                                                 
                                                                ?>   
                                                            <a href="?week={{$nextWeek}}&year={{$year}}" class="">&gt;</a>
                                                        </h4>
                                                       </td>
                                                    </tr>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <?php
                                                        $dayArray = array();
                                                        $dateArray = array();
                                                        do {
                                                            $dayArray[] = $dt->format('l');
                                                            $dateArray[] = $dt->format('Y-m-d');
                                                            
                                                            echo "<th align='center'>" . $dt->format('l') . "<br>" . $dt->format('d M Y') . "</th>\n";
                                                            $dt->modify('+1 day');
                                                        } while ($week == $dt->format('W'));
                                                        ?>
                                                        
                                                    </tr>
                                                    
                                                    @php
                                                        $week_number = @$_GET['week']; 
                                                        $yr = @$_GET['year'];
                                                    @endphp
                                                    
                                                    
                                                    
                                                    @php
                                                        $start = strtotime('00:00');
                                                        $end   = strtotime('23:30');
                                                    @endphp
                                                    
                                                    @for ($i=$start; $i<=$end; $i = $i + 30*60)
                                                        @php
                                                            $now = strtotime(date("Y-m-d H:i:s"));
                                                        @endphp
                                                    <tr>
                                                        <td align="center">{{date('H:i',$i)}}</td>
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_0 = '';
                                                            $booking_window_date = "";

                                                            if($selected_teacher->booking_window == "2weeks")
                                                            {
                                                                $booking_window_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 14 days'));
                                                            }
                                                            else if($selected_teacher->booking_window == "3weeks")
                                                            {
                                                                $booking_window_date = date('Y-m-d', strtotime(date('Y-m-d'). ' + 21 days'));
                                                            }
                                                            else if($selected_teacher->booking_window == "1month")
                                                            {
                                                                $booking_window_date = date('Y-m-d', strtotime(date('Y-m-d'). ' +1 months'));
                                                            }
                                                            else if($selected_teacher->booking_window == "2months")
                                                            {
                                                                $booking_window_date = date('Y-m-d', strtotime(date('Y-m-d'). ' +2 months'));
                                                            }


                                                            if($dateArray[0] > date("Y-m-d") && $booking_window_date >= $dateArray[0]){
                                                                $OneDayExistCheck_0 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[0])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_0 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[0])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));
                                                                
                                                                if(count($OneDayExistCheck_0)>0){
                                                                    foreach($OneDayExistCheck_0 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_0 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[0] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_0 .= '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_0)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_0 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);

                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_0 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[0] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_0 .= '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_0}} tbl-td slot_{{$dateArray[0] . date('H-i',$i) }}" data-date="{{$dateArray[0]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td> 
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_1 = ''; 
                                                            if($dateArray[1] > date("Y-m-d") && $booking_window_date >= $dateArray[1]){
                                                                $OneDayExistCheck_1 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[1])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_1 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[1])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));
                                                                if(count($OneDayExistCheck_1)>0){
                                                                    foreach($OneDayExistCheck_1 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_1 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[1] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_1 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_1)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_1 as $v){
                                                                        $fromTime_1 = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime_1 = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime_1 && $tbl_time <= $toTime_1){
                                                                            $class_1 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[1] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_1 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        
                                                        <td class="{{$class_1}} tbl-td slot_{{$dateArray[1] . date('H-i',$i) }}" data-date="{{$dateArray[1]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_2 = ''; 
                                                            if($dateArray[2] > date("Y-m-d") && $booking_window_date >= $dateArray[2]){
                                                                $OneDayExistCheck_2 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[2])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_2 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[2])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                                    
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));


                                                                if(count($OneDayExistCheck_2)>0){
                                                                    foreach($OneDayExistCheck_2 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_2 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[2] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_2 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_2)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_2 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_2 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[2] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_2 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_2}} tbl-td slot_{{$dateArray[2] . date('H-i',$i) }}" data-date="{{$dateArray[2]}}" data-time="{{date('H:i',$i)}}">&nbsp;</td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_3 = ''; 
                                                            if($dateArray[3] > date("Y-m-d") && $booking_window_date >= $dateArray[3]){
                                                                $OneDayExistCheck_3 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[3])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_3 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[3])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_3)>0){
                                                                    foreach($OneDayExistCheck_3 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_3 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[3] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_3 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_3)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_3 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_3 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[3] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_3 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_3}} tbl-td slot_{{$dateArray[3] . date('H-i',$i) }}" data-date="{{$dateArray[3]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_4 = ''; 
                                                            if($dateArray[4] > date("Y-m-d") && $booking_window_date >= $dateArray[4]){
                                                                $OneDayExistCheck_4 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[4])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_4 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[4])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_4)>0){
                                                                    foreach($OneDayExistCheck_4 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_4 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[4] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_4 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_4)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_4 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_4 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[4] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_4 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_4}} tbl-td slot_{{$dateArray[4] . date('H-i',$i) }}" data-date="{{$dateArray[4]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_5 = ''; 
                                                            if($dateArray[5] > date("Y-m-d") && $booking_window_date >= $dateArray[5]){
                                                                $OneDayExistCheck_5 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[5])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_5 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[5])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));             
                                                                if(count($OneDayExistCheck_5)>0){
                                                                    foreach($OneDayExistCheck_5 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_5 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[5] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_5 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_5)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_5 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_5 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[5] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_5 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_5}} tbl-td slot_{{$dateArray[5] . date('H-i',$i) }}" data-date="{{$dateArray[5]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <?php
                                                            $class_6 = ''; 
                                                            if($dateArray[6] > date("Y-m-d") && $booking_window_date >= $dateArray[6]){
                                                                $OneDayExistCheck_6 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('date', '=', $dateArray[6])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_6 = DB::table('teacher_availability')->where('user_id', Request::segment(2))
                                                                                    ->where('day', '=', $dayArray[6])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_6)>0){
                                                                    foreach($OneDayExistCheck_6 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_6 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[6] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_6 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }elseif(count($weeklyExistCheck_6)>0){
                                                                    
                                                                    foreach($weeklyExistCheck_6 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_6 .= ' ping-bg';
                                                                        }

                                                                        if(count($bookings))
                                                                        {
                                                                            foreach($bookings as $booking){
                                                                                if($booking['booking_date'] == $dateArray[6] && $booking['booking_time'] == date('H:i',$i))
                                                                                {
                                                                                    $class_6 = '';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                  
                                                        ?>
                                                        <td class="{{$class_6}} tbl-td slot_{{$dateArray[6] . date('H-i',$i) }}" data-date="{{$dateArray[6]}}" data-time="{{date('H:i',$i)}}">&nbsp;  </td>
                                                    </tr>
                                                    @endfor
                                                    
                                                </table>
                                               </div>
                                               </div>
                                               <div class="col-lg-3 col-12">
                                                    <div class="my-lessons my-teacher-00 recommended-teacher">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                                         <div class="lesson-rightpic">
                                                            @if($exists && $selected_teacher->profile_photo!='') 
                                                                <img src="{{url('storage/app/user_photo/'.$selected_teacher->profile_photo)}}" class="img-fluid">
                                                            @else
                                                                <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                                            @endif
                                                            
                                                            <span class="offline-icon">
                                                                @if($flag)
                                                                    <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                                                                @else
                                                                    <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                                                                @endif
                                                            </span>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
                                                            <h4>{{$selected_teacher->name}}</h4>
                                                            <h5>{{ $teacherType }}</h5>
                                                           <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                                                        </div>  
                                                    </div>  
                                                    
                                                    <div class="lesson-type-text">
                                                    <h5>Lesson Type</h5>
                                                    <p class="lesson_type">{{ session('b_lesson_name') ? session('b_lesson_name') : '' }}</p>
                                                    </div>
                                                    
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-7">
                                                       <h5>Lesson Package</h5>
                                                       <p class="package-text">{{ session('b_lesson_package') ? session('b_lesson_package') : '' }} &nbsp;&nbsp;&nbsp;
                                                       {{ session('b_lesson_package_time') ? session('b_lesson_package_time') : '' }}
                                                       </p>
                                                      </div>
                                                      <div class="col-lg-5"> <h3 class="amount-text">USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</h3></div>
                                                    </div>
                                                    </div>
                                                    
                                                  </div>
                                                    </div>
                                              
                                              </div>   
                                              <div class="form-row">
                                                    <div class="form-group col-md-6 text-left">
                                                     <button type="button" class="default-btn prev-step package-back">
                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                     Back</button>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6 text-right">
                                                       <button type="button" class="default-btn next-step getBookingDtTime">Next 
                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                  </button>
                                                    </div>
                                                  </div>  
                                            </div>
                                            <div class="tab-pane" role="tabpanel" id="lesson-step4">
                                                <div class="row mt-5">
                                                    <div class="col-lg-9 col-12">
                                                      <h3>Communication Tool</h3>
                                                      <p>These are the communication tools your teacher uses. 
                                                        Please choose your preferred video conferencing platform.</p>
                                                        
                                                      <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                          <div class="communication-row">
                                                           <div class="row align-items-center"> 
                                                            <div class="col-lg-9 col-12"><i class="fa fa-skype" aria-hidden="true"></i> Skype</div>
                                                            <div class="col-lg-3 col-12"> 
                                                             <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="communication_tool" id="" value="skype" checked="">
                                                            </div></div>
                                                          </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                          <div class="communication-row">
                                                           <div class="row align-items-center"> 
                                                            <div class="col-lg-9 col-12"><i class="fa fa-video-camera" aria-hidden="true"></i> Zoom</div>
                                                            <div class="col-lg-3 col-12"> 
                                                             <div class="form-check">
                                                              <input class="form-check-input" type="radio" name="communication_tool" id="" value="zoom" checked="">
                                                            </div></div>
                                                          </div>
                                                          </div>
                                                        </div>
                                                      </div> 
                                                      
                                                      <div class="form-row">
                                                        <div class="form-group col-lg-12 col-12 bookright-icon mt-3">
                                                          
                                                           <label for="inputEmail4">Your ID:</label>
                                                           <input type="text" class="form-control" name="communication_account_id" id="communication_account_id" value="" placeholder=""> 
                                                           <!--<a href="#">Edit</a>-->
                                                           <p class="mt-3">Please be aware that any changes will also be updated on your profile.</p>
                                                        </div>
                                                      </div> 
                                                                          
                                                      
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-12">
                                                        <div class="my-lessons my-teacher-00 recommended-teacher">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                                             <div class="lesson-rightpic">
                                                                @if($exists && $selected_teacher->profile_photo!='') 
                                                                    <img src="{{url('storage/app/user_photo/'.$selected_teacher->profile_photo)}}" class="img-fluid">
                                                                @else
                                                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                                                @endif
                                                                
                                                                <span class="offline-icon">
                                                                    @if($flag)
                                                                        <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                                                                    @else
                                                                        <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                                                                    @endif
                                                                </span>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
                                                                <h4>{{$selected_teacher->name}}</h4>
                                                                <h5>{{ $teacherType }}</h5>
                                                               <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                                                            </div>  
                                                        </div>  
                                                    
                                                    <div class="lesson-type-text">
                                                    <h5>Lesson Type</h5>
                                                    <p class="lesson_type">{{ session('b_lesson_name') ? session('b_lesson_name') : '' }}</p>
                                                    </div>
                                                    
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-7">
                                                       <h5>Lesson Package</h5>
                                                       <p class="package-text">{{ session('b_lesson_package') ? session('b_lesson_package') : '' }} &nbsp;&nbsp;&nbsp;
                                                       {{ session('b_lesson_package_time') ? session('b_lesson_package_time') : '' }}
                                                       </p>
                                                      </div>
                                                      <div class="col-lg-5"> <h3 class="amount-text">USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</h3></div>
                                                    </div>
                                                    </div>
                                                    
                                                  </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 text-left">
                                                     <button type="button" class="default-btn prev-step communication-back">
                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                     Back</button>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-6 text-right">
                                                       <button type="button" class="default-btn next-step getBookingData">Next 
                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                  </button>
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="tab-pane" role="tabpanel" id="lesson-step5">
                                                <div class="row mt-5">
                                                    <div class="col-lg-9 col-12">
                                                      <h3>Payment</h3> 
                                                      <!--<div class="row mb-5">
                                                        <div class="col-lg-12 col-12">
                                                          <div class="communication-row-payment">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                                <label class="form-check-label" for="exampleCheck1">
                                                                 Tokatif Balance / $ 0.00 USD<br/>
                                                                 Your Tokatif Balance will be automatically deducted
                                                                 </label>
                                                              </div>
                                                           </div>
                                                        </div>
                                                        
                                                      </div> 
                                                    
                                                      <h3>Choose Payment Method</h3> 
                                                      <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                          <div class="communication-row active">
                                                       <div class="row align-items-center"> 
                                                        <div class="col-lg-9 col-12"><img src="{{ asset('public/frontendassets/images/credit-card.png') }}" class="img-fluid"/> Credit / Debit Card</div>
                                                        <div class="col-lg-3 col-12"> 
                                                         <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="exampleRadiosSkype" id="" value="exampleRadiosSkype" checked="">
                                                        </div></div>
                                                      </div>
                                                      </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                          <div class="communication-row">
                                                       <div class="row align-items-center"> 
                                                        <div class="col-lg-9 col-12"><img src="{{ asset('public/frontendassets/images/paypal-lesson.png') }}" class="img-fluid"/> Paypal</div>
                                                        <div class="col-lg-3 col-12"> 
                                                         <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="exampleRadiosZoom" id="" value="exampleRadiosZoom" checked="">
                                                        </div></div>
                                                      </div>
                                                      </div>
                                                        </div>
                                                      </div>--> 
                                                      
                                                      <div class="form-row">
                                                        <div class="form-group col-lg-12 col-12 mt-3 required">
                                                           <label>Cardholder's Name</label>
                                                           <input type="text" name="cardholder_name" id="cardholder_name" class="form-control" placeholder="Cardholder's Name"> 
                                                        </div>
                                                      </div> 
                                                            
                                                     <div class="form-row">
                                                        <div class="form-group col-lg-12 col-12 mt-3  required">
                                                           <label for="">Card Number</label>
                                                           <input type="text" name="card_no" id="card_no" size="20" class="form-control card-number" placeholder="Card Number"> 
                                                        </div>
                                                      </div>
                                                      <div class="form-row mt-3">
                                                        <div class="form-group col-md-4 expiration required">
                                                            <label for="inputEmail4">Expiry Month</label>
                                                            <select name="expiry_month" id="expiry_month" class="form-control card-expiry-month" >
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4 expiration required">
                                                          <label for="inputEmail4">Expiry Year</label>
                                                          <input type="text" name="expiry_year" id="expiry_year" size="4" class="form-control card-expiry-year" placeholder="Expiry Year"> 
                                                        </div>
                                                        <div class="form-group col-md-4 cvc required">
                                                          <label for="inputEmail4">Security Code (CVV)</label>
                                                          <input type="text" name="cvv" id="cvv" size="3" class="form-control card-cvc" placeholder="CVV"> 
                                                        </div>
                                                      </div>   
                                                      
                                                      <div class="form-row">
                                                       <div class="form-group col-md-12">
                                                         <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                                            <input type="checkbox" name="saveinformation" id="saveinformation" class="custom-control-input">
                                                            <label class="custom-control-label" for="saveinformation">Save this card information for next time</label>
                                                          </div>
                                                          </div>
                                                      </div> 
                                                      
                                                      <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <p>All currency conversion is an estimate and may vary. 
                                                                Your final payment will be made in USD. All sales are final, 
                                                                purchases may be refunded for Tokatif Credits only.</p>  
                                                         
                                                        </div>
                                                     </div> 
                                                     
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 text-left">
                                                         <button type="button" class="default-btn prev-step payment-back">
                                                          <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                                         Back</button>
                                                        </div>
                                                    </div>  
                                                      
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-12">
                                                        <div class="my-lessons my-teacher-00 recommended-teacher">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-3 col-sm-12 col-12">
                                                             <div class="lesson-rightpic">
                                                                @if($exists && $selected_teacher->profile_photo!='') 
                                                                    <img src="{{url('storage/app/user_photo/'.$selected_teacher->profile_photo)}}" class="img-fluid">
                                                                @else
                                                                    <img src={{Asset("public/assets/dist/img/transparent.png")}} class="img-fluid">   
                                                                @endif
                                                                
                                                                <span class="offline-icon">
                                                                    @if($flag)
                                                                        <img src="{{ asset('public/frontendassets/images/flags/'.$flag.'.png') }}" class="img-fluid">
                                                                    @else
                                                                        <img src="{{ asset('public/frontendassets/images/flage.png') }}"> 
                                                                    @endif
                                                                </span>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-8 col-md-9 col-sm-12 col-12 pl-0">
                                                                <h4>{{$selected_teacher->name}}</h4>
                                                                <h5>{{ $teacherType }}</h5>
                                                               <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                                                            </div>  
                                                        </div>  
                                                    
                                                    <div class="lesson-type-text">
                                                    <h5>Lesson Type</h5>
                                                    <p class="lesson_type">{{ session('b_lesson_name') ? session('b_lesson_name') : '' }}</p>
                                                    </div>
                                                    
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-6">
                                                       <h5>Lesson Package</h5>
                                                       <p class="package-text">{{ session('b_lesson_package') ? session('b_lesson_package') : '' }} &nbsp;&nbsp;&nbsp;
                                                       {{ session('b_lesson_package_time') ? session('b_lesson_package_time') : '' }}
                                                       </p>
                                                      </div>
                                                      <div class="col-lg-6"><p>&nbsp;</p></div>
                                                    </div>
                                                    </div>
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-6">
                                                       <h5>Communication Tool</h5>
                                                      </div>
                                                      <div class="col-lg-6">
                                                          <p class="communication-text">{{ session('b_communication_tool') ? session('b_communication_tool') : 'N/A' }}  : 
                                                            {{ session('b_communication_tool_account_id') ? session('b_communication_tool_account_id') : 'N/A' }}
                                                          </p>
                                                      </div>
                                                    </div>
                                                    </div>
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-6">
                                                       <h5>Sub Total</h5>
                                                      </div>
                                                        <div class="col-lg-6 text-right">
                                                          <h3 class="amount-text">USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }} </h3>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-6">
                                                       <h5>Fees</h5>
                                                      </div>
                                                      <div class="col-lg-6 text-right"><h3>USD 0.00</h3></div>
                                                    </div>
                                                    </div>
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                      <div class="col-lg-6">
                                                       <h5>Total</h5>
                                                      </div>
                                                      <div class="col-lg-6 text-right"><h3 class="amount-text">USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</h3></div>
                                                    </div>
                                                    </div>
                                                    
                                                    <div class="lesson-type-text">
                                                     <div class="row">
                                                        <div class="col-lg-12"> <!--<a href="{{route('stripe')}}">Pay</a> -->
                                                            <a class="button-pay payment-data-modal pay-amount-text" href="javascript:void(0);">Pay USD {{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    
                                                  </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                    <!--</form>-->
                                    
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    </section>   
                </div>
            </div>
        </div>
</section>




<!--<div class="book-footer">
  <div class="bookflow-avatar">
    <div class="avatar avatar-small avatar-placeholder" url="2T067011380"><img src="https://imagesavatar-static01.italki.com/2T067011380_Avatar.jpg" alt="Avatar"></div>
  </div>
  <div class="info_divider"></div>
  <div class="bookflow-lesson">
    <p class="teacher-course-name"><span>Lesson ID:</span></p> <input type="text" id="b_lesson_id" value="" /> 
    <p class="teacher-course-name"><span>Lesson Package ID:</span></p> <input type="text" id="b_lesson_package_id" value="" /> 
    <p class="teacher-course-duration"><span>60 min</span></p> 
  </div>
  <p class="bookflow-price"><span>$ 21.00</span></p>
  <div class="bookflow-right-section">
    <button id="schedule_next_btn" type="button" class="ant-btn bookflow-next-btn ant-btn-secondary"><span>NEXT</span></button>
  </div>
</div>-->



<!-- Modal -->
<div class="modal fade" id="paymentDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Payment Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="form-row"> 
        <div class="form-group col-lg-6 col-12">
            <p> Tokatif Pvt Ltd.<br/>
                Lesson Type: <span class="lesson_type">{{ session('b_lesson_name') ? session('b_lesson_name') : '' }} </span><br/>
                Lesson Package: <span class="package-text">{{ session('b_lesson_package') ? session('b_lesson_package') : '' }} &nbsp;&nbsp;&nbsp;
                                {{ session('b_lesson_package_time') ? session('b_lesson_package_time') : '' }}</span><br/>
                                
                Communication Tool: <span class="communication-text">{{ session('b_communication_tool') ? session('b_communication_tool') : 'N/A' }}  : 
                                    {{ session('b_communication_tool_account_id') ? session('b_communication_tool_account_id') : 'N/A' }}</span><br/>
                                    
                
            </p>
        </div> 
        <div class="form-group col-lg-6 col-12 pull-right">
            <p>Date: {{date('M d, Y')}} <br/>
                Teacher ID: {{Request::segment(2)}} <br/>
                Total: <span class="amount-text">{{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }}</span> <br/>
            </p>
        </div>
       </div>    
       <!--<div class="form-row"> 
        <div class="form-group col-lg-6 col-12">
          <label for="">Bill To</label>
          <input type="email" class="form-control" id="" aria-describedby="emailHelp" placeholder="Please Enter Your Name">
           </div> 
        <div class="form-group col-lg-6 col-12">
          <label for="">&nbsp;</label>
          <input type="email" class="form-control" id="" aria-describedby="emailHelp" placeholder="Please Enter Address">
           </div>
       </div>
       <div class="form-row">       
        <div class="form-group col-md-12">
         <a href="#" class="save-de-btn"> Save Detail</a>
        </div>
        </div> -->   
           
       <div class="form-row">       
        <div class="form-group col-md-12">
         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="wallet-invoice-table">
              <tr>
                <td>Item</td>
                <td align="right">Amount</td>
              </tr>
              <!--<tr>
                <td>Tokatif Credits</td>
                <td align="right">$5.00 USD</td>
              </tr>-->
              <tr>
                <td>Sub Total</td>
                <td align="right" class="amount-text">${{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }} USD</td>
              </tr>
              <!--<tr>
                <td>Processing Fee</td>
                <td align="right">$0.48 USD</td>
              </tr>
              <tr>
                <td>Sales Tax</td>
                <td align="right">$ 0.00</td>
              </tr>-->
              <tr>
                <td><strong>Total</strong></td>
                <td align="right"><strong class="amount-text">${{ session('b_booking_amt') ? number_format(session('b_booking_amt'),2) : '0.00' }} USD</strong></td>
              </tr>
            </table>

           </div>                                                                     
         </div>
         
      </div>
      <div class="modal-footer text-center">
        <form id="paymentForm" action="" method="POST" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"> 
            @csrf
            <input type="hidden" name="payment_teacher_id" id="payment_teacher_id" value="{{Request::segment(2)}}" />
            <input type="hidden" name="payment_lesson_id" id="payment_lesson_id" value="" />
            <input type="hidden" name="payment_lesson_package_id" id="payment_lesson_package_id" value="" />
            <input type="hidden" name="payment_booking_date" id="payment_booking_date" value="" />
            <input type="hidden" name="payment_booking_time" id="payment_booking_time" value="" /> 
            <input type="hidden" name="payment_booking_amount" id="payment_booking_amount" value="" /> 
            
            <input type="hidden" name="payment_communication_tool" id="payment_communication_tool" value="" /> 
            <input type="hidden" name="payment_communication_account_id" id="payment_communication_account_id" value="" /> 
            
            <input type="hidden" name="payment_cardholder_name" id="payment_cardholder_name" value="" /> 
            <input type="hidden" name="payment_card_no" id="payment_card_no" value="" /> 
            <input type="hidden" name="payment_expiry_month" id="payment_expiry_month" value="" /> 
            <input type="hidden" name="payment_expiry_year" id="payment_expiry_year" value="" /> 
            <input type="hidden" name="payment_cvv" id="payment_cvv" value="" /> 
            <input type="hidden" name="payment_saveinformation" id="payment_saveinformation" value="" />
            <input type="hidden" id="payment_slot" name="booking_slots" value="{{ session('b_booking_slot') ? session('b_booking_slot') : '' }}" />
            
            <button type="submit" id="bookingBtn" class="btn btn-submit stripePay"> Pay Now </button> 
        </form>
      </div>
    </div>
  </div>
</div>



@include('include/footer')
<script type="text/javascript">
    
    $(document).on('click', '.lesson-box', function(){

        var lesson = $(this).data('lesson');
        var amount = $(this).data('amount');
        var time = $(this).data('time');

        var package_text = lesson+'&nbsp;&nbsp;&nbsp;'+time;

        $('.package-text').html(package_text);
        $('.amount-text').html("USD "+amount);
        $('.pay-amount-text').html("PAY USD "+amount);

        $('#booking_amount').val(amount);
    });

</script>
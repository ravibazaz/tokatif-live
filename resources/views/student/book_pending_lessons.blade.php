@include('include/head')
@include('include/student-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
@endphp

<section class="step lesson-booking"> 
   <div class="container-fluid">
            <div class="row ">
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
                                    <div class="col-lg-8">
                                        <h3 class="text-center">Book Pending Lessons</h3>
                                    </div>
                                    @php 
                                        $exists = file_exists( storage_path() . '/app/user_photo/' . $selected_teacher->profile_photo );
                                    @endphp

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

                                    @php
                                      if($selected_teacher->teacher_type=='specialist_teacher')
                                        $teacherType = 'Specialist Teacher';
                                      elseif($selected_teacher->teacher_type=='community_tutor')
                                        $teacherType = 'Community Tutor';
                                      
                                    @endphp

                                    <!--<form action="{{ route('booking-data', ['id' => $id]) }}"  method="GET" class="login-box"> -->
                                        {{-- csrf_field() --}}
                                        <div class="tab-content" id="main_form">

                                            <div class="active" id="booking_pending_lesson_calander">
                                              
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
                                                            <!-- <a href="?week={{$prevWeek}}&year={{$year}}" class="">&lt;</a> -->
                                                            <a href="javascript:;" data-week="{{ $prevWeek }}" data-year="{{ $year }}" class="btn-next-month">&lt;</a>
                                                            @endif
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
                                                            <!-- <a href="?week={{$nextWeek}}&year={{$year}}" class="">&gt;</a> -->
                                                            <a href="javascript:;" data-week="{{ $nextWeek }}" data-year="{{ $year }}" class="btn-next-month">&gt;</a>
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
                                                                $OneDayExistCheck_0 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[0])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();

                                                                $weeklyExistCheck_0 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[0])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));
                                                                
                                                                if(count($OneDayExistCheck_0)>0){
                                                                    foreach($OneDayExistCheck_0 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_0 .= ' ping-bg available-slot';
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
                                                                            $class_0 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_1 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[1])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_1 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[1])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));
                                                                if(count($OneDayExistCheck_1)>0){
                                                                    foreach($OneDayExistCheck_1 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_1 .= ' ping-bg available-slot';
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
                                                                            $class_1 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_2 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[2])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_2 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[2])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                                    
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));


                                                                if(count($OneDayExistCheck_2)>0){
                                                                    foreach($OneDayExistCheck_2 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_2 .= ' ping-bg available-slot';
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
                                                                            $class_2 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_3 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[3])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
       
                                                                $weeklyExistCheck_3 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[3])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_3)>0){
                                                                    foreach($OneDayExistCheck_3 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_3 .= ' ping-bg available-slot';
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
                                                                            $class_3 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_4 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[4])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();

                                                                $weeklyExistCheck_4 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[4])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();

                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_4)>0){
                                                                    foreach($OneDayExistCheck_4 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_4 .= ' ping-bg available-slot';
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
                                                                            $class_4 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_5 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[5])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();

                                                                $weeklyExistCheck_5 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[5])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();

                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));             
                                                                if(count($OneDayExistCheck_5)>0){
                                                                    foreach($OneDayExistCheck_5 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_5 .= ' ping-bg available-slot';
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
                                                                            $class_5 .= ' ping-bg available-slot';
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
                                                                $OneDayExistCheck_6 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('date', '=', $dateArray[6])
                                                                                    ->where('type', '=', '1')
                                                                                    ->get();
                                                                                    
                                                                $weeklyExistCheck_6 = DB::table('teacher_availability')->where('user_id', $id)
                                                                                    ->where('day', '=', $dayArray[6])
                                                                                    ->where('type', '=', '2')
                                                                                    ->get();
                                                                
                                                                $tbl_time = DateTime::createFromFormat('H:i', date('H:i',$i));                
                                                                if(count($OneDayExistCheck_6)>0){
                                                                    foreach($OneDayExistCheck_6 as $v){
                                                                        $fromTime = DateTime::createFromFormat('H:i', $v->from_time);
                                                                        $toTime = DateTime::createFromFormat('H:i', $v->to_time);
                                                                        
                                                                        if($tbl_time >= $fromTime && $tbl_time <= $toTime){
                                                                            $class_6 .= ' ping-bg available-slot';
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
                                                                            $class_6 .= ' ping-bg available-slot';
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
        <p class="lesson_type">{{ $booking_data->name }}</p>
        </div>
        
        <div class="lesson-type-text">
         <div class="row">
          <div class="col-lg-7">
           <h5>Lesson Package</h5>
           <p class="package-text">{{ $booking_data->package }} &nbsp;&nbsp;&nbsp;{{ $booking_data->time }}
           </p>
          </div>
          <div class="col-lg-5"> <h3 class="amount-text"></h3></div>
        </div>
        </div>
        
      </div>
        </div>


                                              </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        
                                    <div class="form-row">
                                        <div class="form-group col-md-6 text-left">
                                         
                                        </div>
                                        
                                        <div class="form-group col-md-6 text-right">
                                            <form method="post" action="{{ url('student/book-pending-lesson', $booking_data->booking_id) }}">
                                                @csrf

                                                <input type="hidden" name="booking_dates" id="booking_dates" value="" />
                                                <input type="hidden" name="booking_times" id="booking_times" value="" />

                                                <button type="submit" class="btn btn btn-submit default-btn">Book</button>
                                            </form>
                                        </div>
                                    </div>  
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    </section>   
                </div>
            </div>
        </div>
</section>

@include('include/footer')
<script type="text/javascript">

    var slot = "{{ $booking_data->booking_slots }}";
    var package_lessons = "{{ $pending_lesson }}";
    var package = "{{ $booking_data->package }}";
    var package_time = "{{ $booking_data->time }}";
    var package_type = "{{ $booking_data->name }}";

    localStorage.clear('selected_slots');

    $(document).on('click', '.btn-submit', function(e){

        if(localStorage.getItem("selected_slots") !== null)
        {
            var selected_slots = localStorage.getItem('selected_slots').split(',');
            var dates = [];
            var times = [];

            $(selected_slots).each(function(key, selected_slot){
                
                var new_string = selected_slot.replace('slot_', '');
                var time = new_string.substr(new_string.length - 5);
                var date = new_string.replace(time, '');

                dates.push(date);
                times.push(time.replace('-', ':'));
            });

            $('#booking_dates').val(dates);
            $('#booking_times').val(times);
        }

    });

    $(document).on('click', '.light-bg', function(){

        var selected_slots = localStorage.getItem('selected_slots').split(',');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var slot_name = "slot_"+date+time.replace(":","-");
        
        var new_slots = jQuery.grep(selected_slots, function(value) {
            return value != slot_name;
        });

        localStorage.clear('selected_slots');
        if(new_slots.length > 0)
        {
            localStorage.setItem('selected_slots', new_slots);
        }
    });

    $(document).on('click', '.btn-next-month', function(){

        var week = $(this).data('week');
        var year = $(this).data('year');
        var id = "{{ $id }}";
        var flag = "{{ $flag }}";
        var teacherType = "{{ $teacherType }}";

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
        $.ajax({
            url: "{{ url('get-next-month-calendar') }}",
            type: 'GET',
            data: { week : week, year : year, id : id, flag : flag, teacherType: teacherType, flag : flag, teacherType: teacherType },
            success: function (data) {
                $('#booking_pending_lesson_calander').html(data);
                $('#lesson-step3').removeClass('tab-pane');
                $('#lesson-step3 .form-row').html('');

                $('.lesson_type').html(package_type);
                $(".package-text").html(package+"&nbsp;&nbsp;&nbsp;"+package_time);
                $('.amount-text').html("");

                if(localStorage.getItem("selected_slots") !== null)
                {
                    var selected_slots = localStorage.getItem('selected_slots').split(',');
                    $(selected_slots).each(function(key, selected_slot){

                        $('.ping-bg').each(function(){
                            if($(this).hasClass(selected_slot))
                            {
                                var time = $(this).data('time');
                                var date = $(this).data('date');

                                $(this).addClass('parent-slot');
                                $(this).addClass('light-bg');
                                $(this).removeClass('ping-bg');

                                if(slot == 2)
                                {
                                    var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                                    var class_name = ".slot_"+date+second_slot;

                                    $(class_name).addClass('light-bg');
                                    $(class_name).addClass('parent-slot');
                                    $(class_name).removeClass('ping-bg');
                                }
                                else if(slot == 3)
                                {
                                    var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                                    var class_name = ".slot_"+date+second_slot;

                                    var third_slot = moment.utc(time,'hh:mm').add(60,'minutes').format('hh-mm');
                                    var third_class_name = ".slot_"+date+third_slot;

                                    $(class_name).addClass('light-bg');
                                    $(class_name).addClass('parent-slot');
                                    $(class_name).removeClass('ping-bg');

                                    $(third_class_name).addClass('light-bg');
                                    $(third_class_name).addClass('parent-slot');
                                    $(third_class_name).removeClass('ping-bg');
                                }
                            }
                        });
                    });
                }
            }
        });
    });

    $(document).on('click','.parent-slot',function(e){

        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var _this = $(this);
        var package_lessons = $("#package_lessons").val();

        $(this).addClass('ping-bg');
        $(this).removeClass('parent-slot');
        $(this).removeClass('light-bg');

        if(slot == 2)
        {
            var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
            var class_name = ".slot_"+date+second_slot;

            if($(class_name).hasClass("available-slot"))
            {
                $(class_name).removeClass('light-bg');
                $(class_name).removeClass('parent-slot');
                $(class_name).addClass('ping-bg');
            }
        }
        else if(slot == 3)
        {
            var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
            var class_name = ".slot_"+date+second_slot;

            if($(class_name).hasClass("available-slot"))
            {
                $(class_name).removeClass('light-bg');
                $(class_name).removeClass('parent-slot');
                $(class_name).addClass('ping-bg');

                var third_slot = moment.utc(time,'hh:mm').add(60,'minutes').format('hh-mm');
                var third_class_name = ".slot_"+date+third_slot;

                if($(third_class_name).hasClass("available-slot"))
                {
                    $(third_class_name).removeClass('light-bg');
                    $(third_class_name).removeClass('parent-slot');
                    $(third_class_name).addClass('ping-bg');
                }
            }
        }
    });

    $(document).on('click','.ping-bg',function(e){

        var date = $(this).attr('data-date');
        var time = $(this).attr('data-time');
        var _this = $(this);

        // var lessons_count = $('.parent-slot').length;
        if(localStorage.getItem("selected_slots") !== null)
        {
            var lessons_count = localStorage.getItem('selected_slots').split(',').length;
        }
        else
        {
            var lessons_count = 0;
        }

        if(lessons_count >= package_lessons && package_lessons >= 1)
        {
            if(package_lessons <= 1)
            {
                $('.available-slot').removeClass('light-bg');
                $('.available-slot').removeClass('parent-slot');
                $('.available-slot').addClass('ping-bg');

                if(slot == 1)
                {
                    count_selected_slot(_this);
                    $(_this).addClass("light-bg");
                    $(_this).addClass("parent-slot");
                }

                if(slot == 2)
                {
                    var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                    var class_name = ".slot_"+date+second_slot;

                    if($(class_name).hasClass("available-slot"))
                    {
                        $(_this).addClass("light-bg");
                        $(_this).addClass("parent-slot");

                        $(class_name).addClass("light-bg");
                        // $(class_name).addClass("parent-slot");
                    }
                }
                else if(slot == 3)
                {
                    var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                    var class_name = ".slot_"+date+second_slot;
                    var third_slot = moment.utc(time,'hh:mm').add(60,'minutes').format('hh-mm');
                    var third_class_name = ".slot_"+date+third_slot;

                    if($(class_name).hasClass("available-slot") && $(third_class_name).hasClass("available-slot"))
                    {
                        $(_this).addClass("light-bg");
                        $(_this).addClass("parent-slot");

                        $(class_name).addClass("light-bg");
                        // $(class_name).addClass("parent-slot");

                        if($(third_class_name).hasClass("available-slot"))
                        {
                            $(third_class_name).addClass("light-bg");
                            // $(third_class_name).addClass("parent-slot");
                        }
                    }
                }
            }
            else
            {
                alert('You can book only '+ package_lessons +' slots.');
            }
        }
        else
        {
            
            // $('.ping-bg').removeClass('light-bg');
            $(_this).removeClass('ping-bg');
            $(_this).addClass("light-bg");
            $(_this).addClass("parent-slot");

            var time = $(_this).data('time');
            var date = $(_this).data('date');

            if(slot == 1)
            {
                count_selected_slot(_this);
            }

            if(slot == 2)
            {
                var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                var class_name = ".slot_"+date+second_slot;

                if(!$(class_name).hasClass("ping-bg"))
                {
                    // $('.ping-bg').removeClass('light-bg');
                    $(_this).removeClass('light-bg');
                    $(_this).removeClass('parent-slot');
                    $(_this).addClass("ping-bg");
                    alert('Please select two available slots');
                }
                else
                {
                    count_selected_slot(_this);
                    // $('.ping-bg').removeClass('light-bg');
                    $(_this).addClass("light-bg");
                    $(_this).removeClass("ping-bg");

                    $(class_name).addClass('light-bg');
                    $(class_name).removeClass('ping-bg');
                }
            }
            else if(slot == 3)
            {
                var second_slot = moment.utc(time,'hh:mm').add(30,'minutes').format('hh-mm');
                var class_name = ".slot_"+date+second_slot;

                if($(class_name).hasClass("ping-bg"))
                {
                    var third_slot = moment.utc(time,'hh:mm').add(60,'minutes').format('hh-mm');
                    var third_class_name = ".slot_"+date+third_slot;

                    if(!$(third_class_name).hasClass("ping-bg"))
                    {
                        // $('.ping-bg').removeClass('light-bg');
                        $(_this).addClass("ping-bg");
                        $(_this).removeClass('light-bg');
                        $(_this).removeClass('parent-slot');
                        $('#booking_date').val("");
                        $('#booking_time').val("");
                        alert('Please select three available slots');
                    }
                    else
                    {
                        count_selected_slot(_this);
                        // $('.ping-bg').removeClass('light-bg');
                        $(_this).addClass("light-bg");
                        $(_this).removeClass("ping-bg");

                        $(class_name).addClass('light-bg');
                        $(class_name).removeClass('ping-bg');

                        $(third_class_name).addClass('light-bg');
                        $(third_class_name).removeClass('ping-bg');
                    }
                }
                else
                {
                    // $('.ping-bg').removeClass('light-bg');
                    $(_this).addClass("ping-bg");
                    $(_this).removeClass('parent-slot');
                    $(_this).removeClass('light-bg');
                    $('#booking_date').val("");
                    $('#booking_time').val("");
                    alert('Please select three available slots');
                }
            }
        }
    });

    
    function count_selected_slot(_this)
    {
        var date = $(_this).data('date');
        var time = $(_this).data('time');
        var slot_name = "slot_"+date+time.replace(":","-");

        if(localStorage.getItem("selected_slots") !== null)
        {
            var selected_slots = localStorage.getItem('selected_slots').split(',');
            new_slots = selected_slots;
            new_slots.push(slot_name);

            $(selected_slots).each(function(key, selected_slot){
                if(selected_slot != slot_name)
                {
                    new_slots.push(selected_slot);
                }
            });

            var unique = new_slots.filter(function(itm, i, new_slots) {
                return i == new_slots.indexOf(itm);
            });

            localStorage.clear('selected_slots');
            localStorage.setItem('selected_slots', unique);
        }
        else
        {
            var selected_slots = [];
            selected_slots.push(slot_name);

            localStorage.clear('selected_slots');
            localStorage.setItem('selected_slots', slot_name);
        }
    }

</script>
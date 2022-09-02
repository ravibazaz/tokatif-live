<div class="tab-pane <?php if (isset($year) && isset($week)) {echo 'active';}else{echo '';}?>" role="tabpanel" id="lesson-step3">
                                              
  <div class="row mt-5">
    <div class="col-lg-9 col-12">
    
    <?php
    $dt = new DateTime;
    if (isset($year) && isset($week)) {
        $dt->setISODate($year, $week);
    } else {
        $dt->setISODate($dt->format('o'), $dt->format('W'));
    }
    $year = $dt->format('o');
    $week = $dt->format('W');


    // Get prev & next month
    if (isset($week) && isset($year)) {
        $ym = $year.'-'.$week;
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
                    if (isset($week) && isset($year)) {
                        $d = date('Y-').'01-01';
                        $selectedMonth = date("M", strtotime($d." ".$currentWeek." weeks"));
                        
                        $selectedMonthNo = date("m", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
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
            $week_number = @$week; 
            $yr = @$year;
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
           <button type="button" class="default-btn next-step getBookingDtTime">    Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </button>
        </div>
      </div>  
</div>
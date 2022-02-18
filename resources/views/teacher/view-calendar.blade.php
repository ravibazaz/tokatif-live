@include('include/head')
@include('include/teacher-dashboard-header')

@php
 $getLoggedIndata = getLoggedinData();
@endphp


<?php

// Set your timezone
date_default_timezone_set('Asia/Tokyo');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Check format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());

// For H3 title
$html_title = date('F Y', $timestamp); 

// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// Number of days in the month
$day_count = date('t', $timestamp);
 
// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


// Create Calendar!!
$weeks = array();
$week = '';

// Add empty cell
$week .= str_repeat('<div class="calendar-item fz16 mh95 calendar-out-month"><span class="item-date">&nbsp;</span></div>', $str);


for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
    $date = $ym . '-' . $day;
    
    $calenderDay = date('l', strtotime($date));
    
    
    $bookingData = DB::table('booking')->where('teacher_id', session('id'))->where('booking_date', $date)->get();
    
    $class = ''; 
    $timeClass = ''; 
    
    if ($today == $date) {
        
        if (count($bookingData)>0) {
            $timeClass = 'waiting';
            
            $timeArr = array();
            foreach($bookingData as $val){
                $timeArr[] = '<div class="item-list waiting '.$timeClass.' "><span class="item-time">'.date('h:i A', strtotime($val->booking_time)).'</span></div>';
            }
            
            $d = $day.'</span><br>'.implode(" ", $timeArr);  
            
            $week .= '<div class="calendar-item fz16 mh95"><span class="item-date">' . $d;  
            
        }else{
            $week .= '<div class="calendar-item fz16 mh95"><span class="item-date">' . $day .'</span>'; 
        }
        
        
    }else{
        
        if(strtotime($date) <= time()){ 
            $class .= ' calendar-out-month '; 
        }
        
        if(strtotime($date) < time()){ 
            $timeClass = 'completed';
        }
        
        if (count($bookingData)>0) {
            //$class .= 'yellow-bg ';
            
            if(strtotime($date) > time()){ 
                $timeClass = 'upcoming';
            }
            
            $timeArr = array();
            foreach($bookingData as $val){
                $timeArr[] = '<div class="item-list  '.$timeClass.' "><span class="item-time">'.date('h:i A', strtotime($val->booking_time)).'</span></div>';
            }
            
            
            $d = $day.'</span><br>'.implode(" ", $timeArr);  
            
            $week .= '<div class="calendar-item fz16 mh95 '.$class.' "><span class="item-date">' . $d;  
        }else{
            $week .= '<div class="calendar-item fz16 mh95 '.$class.' "><span class="item-date">' . $day .'</span>'; 
        }
        
    
    }



    $week .= '</div>';
 
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {
    
        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<div class="calendar-item fz16 mh95 calendar-out-month"><span class="item-date">&nbsp;</span></div>', 6 - ($str % 7)); 
        }
    
        $weeks[] = $week; 
    
        // Prepare for new week
        $week = '';
    }





}

?>

<section class="teacher-contain">
  <div class="container">
    <div class="row">
      <div class="calendar-wrap1 calendar-wrap-desktop">
        <div class="first-part">
          <div class="calendar-header">
            
            <div class="header-item">
              
            </div>
            
            <div class="header-item">
              <p class="month">
                <a href="?ym=<?php echo $prev; ?>" class="arrow-wrap"><span class="arrow arrow-left"> </span></a>
                    <span class="calender-month"><?php echo $html_title; ?></span>
                <a href="?ym=<?php echo $next; ?>" class="arrow-wrap"><span class="arrow arrow-right"> </span></a>
              </p>
            </div>
            
            
            <div class="header-item">
              <!--<div class="calendar-switch-tabs">
                
              </div>-->
            </div>
          </div>
          <div class="calendar-body">
            <div class="weekName weeksday">
              <p class="calendar-item fz16"><span>Sunday</span></p>
              <p class="calendar-item fz16"><span>Monday</span></p>
              <p class="calendar-item fz16"><span>Tuesday</span></p>
              <p class="calendar-item fz16"><span>Wednesday</span></p>
              <p class="calendar-item fz16"><span>Thursday</span></p>
              <p class="calendar-item fz16"><span>Friday</span></p>
              <p class="calendar-item fz16"><span>Saturday</span></p>
            </div>
            <div class="weekName">
                
                <?php
                    foreach ($weeks as $week) {
                        echo $week;
                    }
                ?>
                
            </div>
          </div>
        </div>
        <div class="calendar-footer">
          
          <div class="footer-letf">
            <div class="status-item">
              <p class="status-circle color-green"> </p>
              <p class="status-text"><span>Upcoming</span></p>
            </div>
            <div class="status-item">
              <p class="status-circle color-purple"> </p>
              <p class="status-text"><span>Today</span></p>
            </div>
            <div class="status-item">
              <p class="status-circle color-grey"> </p>
              <p class="status-text"><span>Previous</span></p>
            </div>
          </div>
          <div class="footer-right">
            <a href="{{route('teacher-calendar')}}" class="ant-btn calendar-change-availability ant-btn-default"><span>Edit Availability</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@include('include/footer')





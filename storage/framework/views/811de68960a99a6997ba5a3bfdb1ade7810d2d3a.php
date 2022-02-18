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
$html_title = date('M, Y', $timestamp); 

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
$week .= str_repeat('<td class="calendar-out-month">&nbsp;</td>', $str);

for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
    $date = $ym . '-' . $day;
    
    $calenderDay = date('l', strtotime($date));
    
    if($day<10){
        $num_padded = sprintf("%02d", $day);
        $date = $ym . '-' . $num_padded.$day;
    }
    
    
    $bookingData = DB::table('booking')->where('student_id', session('id'))->where('booking_date', $date)->get(); 
    
    $class = '';  
    $spanClass = '';
    
    if ($today == $date) {
        
        if (count($bookingData)>0) {
            $spanClass = '<span class="marked-yellow"></span>';
        }
        
        $week .= '<td class="marked" >' . $day .$spanClass;
        
    }else{
        
        if (count($bookingData)>0) {
            $spanClass = '<span class="marked-green"></span>';
        }
        
        if(count($bookingData)>0 && $date < date('Y-m-d')){
            $spanClass = '<span class="marked-black"></span>';
        }
        
        
        $week .= '<td class="'.$class.'" >' . $day .$spanClass; 
        
    }



    $week .= '</td>';
 
    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {
    
        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td class="calendar-out-month">&nbsp;</td>', 6 - ($str % 7));
        }
    
        $weeks[] = '<tr>' . $week . '</tr>';
    
        // Prepare for new week
        $week = '';
    }





}

?>

<table>
    <thead>
      <tr>
        <th colspan="7"><?php echo $html_title; ?></th>
      </tr>
      <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
      </tr>
    </thead>
    <tbody>
    <?php
        foreach ($weeks as $week) {
            echo $week;
        }
    ?>
    </tbody>
</table><?php /**PATH /home/tokatifc/public_html/resources/views/include/student-current-month-calendar.blade.php ENDPATH**/ ?>
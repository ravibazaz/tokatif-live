<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php

 $getLoggedIndata = getLoggedinData();

?>





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

    

    //echo "========================".$today." :: ".$date; 

    $availabilityOneDayData = DB::table('teacher_availability')->where('user_id', session('id'))->where('date', $date)->get();  

    $availabilityWeeklyData = DB::table('teacher_availability')->where('user_id', session('id'))->where('day', $calenderDay)->where('type', '2')->get();  

    

    $class = ''; 

    $timeClass = ''; 

    

    if ($today == $date) {

        

        if (count($availabilityOneDayData)>0) {

            //$class .= 'yellow-bg';

            $timeArr = array();

            

            if (count($availabilityOneDayData)>0){

                $timeClass = 'yellow-worning';

                if(strtotime($date) <= time()){ 

                    $timeClass = 'back-time';

                }

                    

                

                foreach($availabilityOneDayData as $val){

                    $from_time = $val->from_time;

                    $to_time = $val->to_time;

                    

                    $timeArr[] = '<div class="item-list completed '.$timeClass.' "><span class="item-time">'.$from_time.' - '.$to_time.'</span></div>';

                    

                    

                }

                

                

            }

            

            

            $d = $day.'</span><br>'.implode(" ", $timeArr);  

            

            $week .= '<div class="calendar-item fz16 mh95"><span class="item-date">' . $d;  

            

            

        }else{

            

            $d = $day;  

            if(count($availabilityWeeklyData)>0){

                

                $timeArr = array();

                

                $timeClass = 'yellow-worning';

                

                foreach($availabilityWeeklyData as $val){

                    $from_time = $val->from_time;

                    $to_time = $val->to_time;

                    

                    $timeArr[] = '<div class="item-list completed '.$timeClass.'"><span class="item-time">'.$from_time.' - '.$to_time.'</span></div>';

                    

                    

                }

                

                

                $d = $day.'</span><br>'.implode(" ", $timeArr);  

            }

            

            $week .= '<div class="calendar-item fz16 mh95"><span class="item-date">' . $d .'</span>'; 

        }

        

    }else{

        

        if(strtotime($date) <= time()){ 

            $class .= ' calendar-out-month '; 

        }

        

        if($date > date('Y-m-d')){ 

            $class .= ' bookingPopup '; 

        }

        

        if (count($availabilityOneDayData)>0 || count($availabilityWeeklyData)>0) {

            //$class .= 'yellow-bg';

            $timeArr = array();

            

            if(count($availabilityOneDayData)>0){

                

                $timeClass = 'green-time';

                if(strtotime($date) <= time()){ 

                    $timeClass = 'back-time';

                }

                    

                foreach($availabilityOneDayData as $val){

                    $from_time = $val->from_time;

                    $to_time = $val->to_time;

                    

                    $timeArr[] = '<div class="item-list completed '.$timeClass.'"><span class="item-time">'.$from_time.' - '.$to_time.'</span></div>';

                    

                }

                

                if($availabilityOneDayData[0]->type=='2'){

                    $avlDay = date('l', strtotime($availabilityOneDayData[0]->date));

                    $calenderDay = date('l', strtotime($date));

                    

                    if($calenderDay==$avlDay){

                        //$class = 'yellow-bg';

                    }

                }

            }elseif(count($availabilityWeeklyData)>0){

                

                $timeClass = 'green-time';

                if(strtotime($date) < time()){ 

                    $timeClass = 'back-time';

                }

                

                

                foreach($availabilityWeeklyData as $val){

                    $from_time = $val->from_time;

                    $to_time = $val->to_time;

                    

                    $timeArr[] = '<div class="item-list completed '.$timeClass.'"><span class="item-time">'.$from_time.' - '.$to_time.'</span></div>';

                    

                }

                

                

            }

            

            

            $d = $day.'</span><br>'.implode(" ", $timeArr); 

            

            $week .= '<div class="calendar-item fz16 mh95 '.$class.'" data-Date="'.$date.'" data-Day="'.date('l', strtotime($date)).'"  data-DateBtn="'.date('jS F, Y', strtotime($date)).'" ><span class="item-date">' .$d; 

        }else{

            $week .= '<div class="calendar-item fz16 mh95 '.$class.'" data-Date="'.$date.'" data-Day="'.date('l', strtotime($date)).'"  data-DateBtn="'.date('jS F, Y', strtotime($date)).'" ><span class="item-date">' . $day .'</span>';

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



<section class="calender-full-page mt-5">

  <div class="container">

    <div class="row">

      <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     </div>

      <div class="col-lg-9 col-md-9 col-sm-12 col-12">

        <div class="calendar-wrap calendar-wrap-desktop">

          <div class="first-part">

            <div class="calendar-header">

              

              <div class="header-item">

                <p class="month">

                    <a href="?ym=<?php echo $prev; ?>" class="arrow-wrap"><span class="arrow arrow-left"> </span></a>

                        <span class="calender-month"> <?php echo $html_title; ?> </span>

                    <a href="?ym=<?php echo $next; ?>" class="arrow-wrap"><span class="arrow arrow-right"> </span></a> 

                </p>

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

          

        </div>

      </div>

    </div>

  </div>

</section>





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

                <input type="hidden" id="user_id" value="<?php echo e(session('id')); ?>" /> 

                <input type="hidden" id="selected_date" value="" /> 

                <input type="hidden" id="selected_dayBtn" value="" /> 

                <input type="hidden" id="selected_dateBtn" value="" /> 

                

            <div id="newTimeSlot" class="timeSlotDiv">

                

                <div class="form-row mb-2 align-items-center" id="timesDiv">

                </div>

                    

                    

                    <!--<div class="form-group col-md-5">

                      <select class="custom-select mr-sm-2 from_time" name="from_time[]" id="from_time">

                        <?php 

                            $start = strtotime('00:00');

                            $end   = strtotime('23:30');

                            for ($i=$start; $i<=$end; $i = $i + 30*60){

                               echo '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';

                            }

                        ?>

                      </select>

                    </div>

                        

                    <div class="form-group col-md-5"> 

                      <select class="custom-select mr-sm-2 to_time" name="to_time[]" id="to_time">

                        <?php 

                            $start = strtotime('00:00');

                            $end   = strtotime('23:30');

                            for ($i=$start; $i<=$end; $i = $i + 30*60){

                               echo '<option value="'.date('H:i',$i).'">'.date('H:i',$i).'</option>';

                            }

                        ?>

                      </select>

                    </div>

                    <div class="form-group remove-time-row col-md-2 text-center">

                        <a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

                    </div> --> 

                    

                

            </div>

       

            <div class="form-row mb-2">

                <div class="form-group col-md-12">

                  <div class="add-time-slot"><a href="javascript:void(0);" id="timeSlotAppend"><span>+</span><span>Add New Time Slot</span></a></div>

                </div>

            </div>

                      

            <div class="confirm-box" id="availabilityButton"> </div>

            

            </form>

        </div>

      

    </div>

  </div>

</div>



<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>







<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/availability-calendar.blade.php ENDPATH**/ ?>
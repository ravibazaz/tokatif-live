<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
?>

<section class="teacher-contain">
<div class="container">
  <div class="row">
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     </div>
     
     <div class="col-lg-6 col-md-6 col-sm-12 col-12">
       <div class="row align-items-center">
         <div class="col-lg-4 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Current Balance</p>
           <h4>$<?php echo e(number_format($getLoggedIndata->teacher_wallet_amount,2)); ?> USD</h4>
           
          </div>
         </div>
         <div class="col-lg-8 col-md-8 col-sm-8 col-12 pr-0">
          <div class="blance-box">
            <!--<p> Total Booking </p>-->
            <!--<div style="width: 100%; height: 40px; position: absolute; top: 47.5%; left: 8px; margin-top: -20px; line-height:19px; text-align: center; z-index: 999999999999999">
                <?php echo e($totalBooking); ?> <Br /> Total
            </div>-->
            <div id="teacherChartContainer"></div> 
          </div>
         </div>
       </div>
       <div class="row mt-4">
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Average Rating</p>
           <h4><i class="fa fa-star" aria-hidden="true"></i> <?php echo e($average_rating); ?> </h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +<?php echo e($average_rating); ?> Rating </a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Badges</p>
           <h4><?php echo e($totalBadges); ?></h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +<?php echo e($totalBadges); ?> Badges</a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Lessons</p>
           <h4><?php echo e($lessonCount); ?></h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i> +<?php echo e($lessonCount); ?> Lessons</a>
          </div>
         </div>
         <div class="col-lg-3 col-md-4 col-sm-4 col-12 pr-0">
          <div class="blance-box">
           <p>Total Students</p>
           <h4><?php echo e($studentCount); ?></h4>
           <a href="javascript:void(0);"><i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>+<?php echo e($studentCount); ?> Students</a>
          </div>
         </div>
       </div>
       <div class="row mt-4">
         <div class="col-lg-12 col-12">
            <div id="lineChartContainer" style="height: 150px; width: 100%;"></div>
         </div> 
       </div>

       <div class="row mt-4">
         <div class="col-lg-12 col-12">
            <div id="lineChartContainer_2" style="height: 150px; width: 100%;"></div> 
         </div> 
       </div>

       <!-- <div class="row mt-4">
         <div class="col-lg-12 col-12">
          <?php
          $july_HT_Data = DB::table('booking')->where('teacher_id', '=', session('id'))->where('status', '=', '3')
                                    ->whereMonth('lesson_completed_at', '07')
                                    ->whereYear('lesson_completed_at', date('Y'))->get(); 

          //echo "<pre>"; print_r($july_HT_Data);
          $july_HT = 0;
          if(count($july_HT_Data)>0) {
            foreach($july_HT_Data as $val){
                $start = $val->lesson_started_at;
                $end = $val->lesson_completed_at;

                $seconds = strtotime($end) - strtotime($start);

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                

                $july_HT += $minutes;

                echo "min:: ".$minutes."<br>";
            }
          }

          if($july_HT > 1){
            $july_HT = floor($july_HT / 60);
          }
          echo $july_HT;
          ?>
        </div>
      </div> -->
       
     </div>
     
     

    <?php $flag = ''; ?>
    <?php if($getLoggedIndata->country_living_in!=''): ?>
        <?php
            $countryFlagData = DB::table('countries')->where('name', '=', $getLoggedIndata->country_living_in)->first(); 
            $flag = strtolower($countryFlagData->sortname);
        ?>
    <?php else: ?>
        <?php
            $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
            $flag = strtolower($countryFlagData->sortname);
        ?>
    <?php endif; ?>
     <div class="col-lg-3 col-md-3 col-sm-12 col-12">
       <!--<div class="student-left-sidebar"></div>-->
      <div class="profile-box right-pic-profile">
           <div class="row">
             <div class="col-12">
               <div class="img-profile">
                    <?php 
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );
                    ?>
                    
                    <?php if($exists && $getLoggedIndata->profile_photo!=''): ?> 
                        <img src="<?php echo e(url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)); ?>" class="img-fluid">
                    <?php else: ?>
                        <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                    <?php endif; ?>
                 <div class="flag-img">
                     <?php if($flag): ?>
                        <img src="<?php echo e(asset('public/frontendassets/images/flags/'.$flag.'.png')); ?>" class="img-fluid">
                     <?php else: ?>
                        <img src="<?php echo e(asset('public/frontendassets/images/flage.png')); ?>"> 
                     <?php endif; ?>
                 </div>
               </div>   
             </div>
           </div>
           
           
            
           <div class="row">
               <div class="col-lg-12">
                   <h3><?php echo e($getLoggedIndata->name); ?> </h3> <!--<div class="flag flag-us"></div>-->  
               </div> 
           </div>
           
           <div class="row">
           <div class="col-lg-12">
             <ul>
               <li>User ID <span><?php echo e($getLoggedIndata->id); ?> </span> </li>
               <li>From <span><?php echo e($getLoggedIndata->country_of_origin); ?></span></li>
               <li>Living in  <span><?php echo e($getLoggedIndata->country_living_in); ?> <br> (<?php echo e(date('d-M-Y h:i a')); ?>)</span> </li>
             </ul>
           </div> 
           </div>
           
           </div>  
        <div class="my-lessons my-teacher-00 recommended-teacher mt-4 upcoming-lessons">
            <?php if(count($booking)>0): ?>
            <div class="row">
                <div class="col"><h2>Upcoming Lessons </h2></div>
            </div>
            
            <?php $__currentLoopData = $booking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                ?>
            <div class="row mt-4 align-items-center">
                <div class="col-lg-4 col-md-3 col-sm-12 col-12 pr-0">
                 <div class="duration-box">
                   <h6><span><?php echo e($lessonPackageData->package); ?></span></h6>
                 </div>
                </div>
               
                <div class="col-lg-7 col-md-7 col-sm-12 col-12 pr-0">
                   <h5><?php echo e($lessonData->name); ?></h5>
                   <p><?php echo e($lessonData->language_taught); ?> - <?php echo e($lessonPackageData->time); ?></p> 
                   <h4><?php echo e($studentData->name); ?></h4>
                </div>  
 
                <!--<div class="col-lg-1 col-md-2 col-sm-12 col-12 p-0">
                 <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </div>-->
                
            </div>  
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            
          </div>
     </div>

   </div>
  </div>
</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/dashboard.blade.php ENDPATH**/ ?>
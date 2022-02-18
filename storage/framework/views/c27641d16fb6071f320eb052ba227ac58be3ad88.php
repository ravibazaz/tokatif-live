<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
?>


<section class="lesson-list-page">

 <div class="container">
	<div class="row">
      <div class="col-lg-3 col-md-4 col-sm-4 col-12 mt-4">
        <div class="sort-by">
          <h4>Sort By</h4>
          <ul class="nav nav-tabs tabs-left">
           <li><a href="#home-v" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/ic.png')); ?>"/> Action Required <?php if(count($pending)>0): ?> <span class="white-round"><?php echo e(count($pending)); ?></span> <?php endif; ?> </a></li>
           <li><a href="#profile-v" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/upcomming-icon.png')); ?>"/> Upcoming <?php if(count($upcoming)>0): ?> <span class="white-round"><?php echo e(count($upcoming)); ?></span> <?php endif; ?> </a></li> 
           <li><a href="#messages-v" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/witting.png')); ?>"/> Waiting <?php if(count($waiting)>0): ?> <span class="white-round"><?php echo e(count($waiting)); ?></span> <?php endif; ?> </a></li>
           <li><a href="#settings-v" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/complited.png')); ?>"/> Completed <?php if(count($completed)>0): ?> <span class="white-round"><?php echo e(count($completed)); ?></span> <?php endif; ?> </a></li> 
           <li><a href="#Unscheduled" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/unscheduled.png')); ?>"/> Today <?php if(count($today)>0): ?> <span class="white-round"><?php echo e(count($today)); ?></span><i class="fa fa-check" aria-hidden="true"></i> <?php endif; ?> </a></li>
           <li><a href="#canceled" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/cancelle.png')); ?>"/> Cancelled <?php if(count($cancelled)>0): ?> <span class="white-round"><?php echo e(count($cancelled)); ?></span> <?php endif; ?> </a></li>         
           <!--<li><a href="#actionrequired" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/ic.png')); ?>"/> Required 1 <span class="white-round"><?php echo e(count($cancelled)); ?></span> </a></li> 
           <li><a href="#actionrequired1" data-toggle="tab"><img src="<?php echo e(asset('public/frontendassets/images/ic.png')); ?>"/> Required 2 <span class="white-round"><?php echo e(count($cancelled)); ?></span> </a></li>-->
          </ul>
        </div>
      </div>
	  <div class="col-lg-9 col-md-8 col-sm-8 col-12">
       <div class="tab-content">
           
            <?php if(Session::get('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> <?php echo e(Session::get('success')); ?></div>
            <?php endif; ?>
            <?php if(Session::get('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Note!</strong> <?php echo e(Session::get('error')); ?></div>
            <?php endif; ?>
           
         
         
        
        <div class="tab-pane active" id="home-v">
            <?php if(count($pending)>0): ?>
                <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php
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
                ?>
                <div class="lesson-listnew-1">
                    <div class="row align-items-center mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In <?php echo e($diff); ?> </h4>
                        <p><?php echo e($studentData->video_conferencing_platform); ?> Classroom ( <?php echo e($studentData->user_account_id); ?> ) </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text"><?php echo e($lessonData->language_taught); ?> (<?php echo e($lessonData->lesson_tag); ?>)- <?php echo e($lessonPackageData->time); ?> </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>New lesson invitation </h4>
                        <p class="red-text"><?php echo e(date('d',strtotime($val->booking_date))); ?> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> - <?php echo e(date('h:i a',strtotime($val->booking_time))); ?></p>
                      </div>
                      <div class="col-lg-2 col-md-4 col-sm-4 col-12 text-center">
                        <h4>BookingID: <?php echo e($val->id); ?></h4>
                        <p>$<?php echo e(number_format($val->booking_amount,2)); ?> USD</p>
                      </div>
                    </div>
                    <div class="eline-accept-total">
                        <div class="row align-items-center justify-content-md-center m-auto deline-accept">
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="<?php echo e(route('student-decline-lesson',['id'=>$val->id])); ?>" onclick="return confirm('Do you want to decline the lesson request?')" >DECLINE</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="<?php echo e(route('student-accept-lesson',['id'=>$val->id])); ?>" onclick="return confirm('Do you want to accept the lesson request?')" >ACCEPT</a>
                            </div>
                        </div>
                    
                    <p class="text-center mt-2">
                        Expiration Date:
                        <?php if($val->booking_date==date('Y-m-d')): ?>
                            <?php echo e(date('d M Y', strtotime($val->booking_date))); ?>

                        <?php else: ?>
                            <?php echo e(date('d M Y', strtotime($val->booking_date . " +48 hours"))); ?>

                        <?php endif; ?>
                    </p> 
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            
            
            <?php if(count($invitation)>0): ?>
                <?php $__currentLoopData = $invitation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php
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
                ?>
                <div class="lesson-listnew-1">
                    <div class="row align-items-center mb-3">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In <?php echo e($diff); ?> </h4>
                        <p><?php echo e($studentData->video_conferencing_platform); ?> Classroom ( <?php echo e($studentData->user_account_id); ?> ) </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text"><?php echo e($lessonData->language_taught); ?> (<?php echo e($lessonData->lesson_tag); ?>)- <?php echo e($lessonPackageData->time); ?> </p>
                      </div>
                      <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>New lesson invitation </h4>
                        <p class="red-text"><?php echo e(date('d',strtotime($val->booking_date))); ?> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> - <?php echo e(date('h:i a',strtotime($val->booking_time))); ?></p>
                      </div>
                      <div class="col-lg-2 col-md-4 col-sm-4 col-12 text-center">
                        <h4>BookingID: <?php echo e($val->id); ?></h4>
                        <p>$<?php echo e(number_format($val->booking_amount,2)); ?> USD</p>
                      </div>
                    </div>
                    <div class="eline-accept-total">
                        <div class="row align-items-center justify-content-md-center m-auto deline-accept"> 
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="<?php echo e(route('student-decline-lesson-invitation',['id'=>$val->id])); ?>" onclick="return confirm('Do you want to decline the lesson request?')" >DECLINE</a>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                                <a href="<?php echo e(route('student-accept-lesson-invitation',['id'=>$val->id])); ?>" onclick="return confirm('Do you want to accept the lesson request?')" >ACCEPT</a>
                            </div>
                        </div>
                    
                        <p class="text-center mt-2">
                            Expiration Date:
                            <?php if($val->booking_date==date('Y-m-d')): ?>
                                <?php echo e(date('d M Y', strtotime($val->booking_date))); ?>

                            <?php else: ?>
                                <?php echo e(date('d M Y', strtotime($val->booking_date . " +48 hours"))); ?>

                            <?php endif; ?>
                        </p> 
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            
        </div>
         
         
         
         
        <div class="tab-pane" id="profile-v">
            <?php if(count($upcoming)>0): ?>
                <?php $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    ?>
                <div class="my-lesson-list upcoming-box">
                    <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> <?php echo e(date('d',strtotime($val->booking_date))); ?> </h4> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> </li>
                          <li> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> <br/> <span class=""><?php echo e(number_format($val->booking_amount,2)); ?> USD</span></li>
                          <li> <?php echo e($lessonData->language_taught); ?> <br/> Language</li>
                          <li> <?php echo e($lessonPackageData->time); ?> <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <?php if($exists && $studentData->profile_photo!=''): ?> 
                                <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                            <?php else: ?>
                                <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                            <?php endif; ?>
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4><?php echo e($studentData->name); ?></h4>
                           <p><?php echo e($studentData->video_conferencing_platform); ?> : <?php echo e($studentData->user_account_id); ?></p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="my-lesson-list upcoming-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            <?php endif; ?>
        </div>
        
        
        
        
        <div class="tab-pane" id="messages-v">
            <?php if(count($waiting)>0): ?>
                <?php $__currentLoopData = $waiting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    ?>
                <div class="my-lesson-list waiting-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> <?php echo e(date('d',strtotime($val->booking_date))); ?> </h4> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> </li>
                          <li> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> <br/> <span class=""><?php echo e(number_format($val->booking_amount,2)); ?> USD</span></li>
                          <li> <?php echo e($lessonData->language_taught); ?> <br/> Language</li>
                          <li> <?php echo e($lessonPackageData->time); ?> <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <?php if($exists && $studentData->profile_photo!=''): ?> 
                                <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                            <?php else: ?>
                                <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                            <?php endif; ?>
                        </div>
                       
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 pl-0">
                           <h4><?php echo e($studentData->name); ?></h4>
                           <p><?php echo e($studentData->video_conferencing_platform); ?> : <?php echo e($studentData->user_account_id); ?></p>
                        </div>  
         
                        <!--<div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>-->
                        
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12"> 
                        <?php if($val->lesson_completed_at=='' && strtotime(date('d-m-Y')) >= strtotime($val->booking_date)): ?>
                            <a href="<?php echo e(route('change-lesson-completion-time',['id'=>$val->id])); ?>" class="button-room" onclick="return confirm('Do you want to mark the lesson as completed?')" > Mark as completed </a>
                        <?php endif; ?>
                      </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="my-lesson-list waiting-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            <?php endif; ?>
        </div>
        
        
        
        
        
        <div class="tab-pane" id="settings-v">
            <?php if(count($completed)>0): ?>
                <?php $__currentLoopData = $completed; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    ?>
                <div class="my-lesson-list completed-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> <?php echo e(date('d',strtotime($val->booking_date))); ?> </h4> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> </li>
                          <li> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> <br/> <span class=""><?php echo e(number_format($val->booking_amount,2)); ?> USD</span></li>
                          <li> <?php echo e($lessonData->language_taught); ?> <br/> Language</li>
                          <li> <?php echo e($lessonPackageData->time); ?> <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <?php if($exists && $studentData->profile_photo!=''): ?> 
                                <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                            <?php else: ?>
                                <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                            <?php endif; ?>
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4><?php echo e($studentData->name); ?></h4>
                           <p><?php echo e($studentData->video_conferencing_platform); ?> : <?php echo e($studentData->user_account_id); ?></p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="my-lesson-list completed-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            <?php endif; ?>
        </div>
        
        
        
        
        <div class="tab-pane" id="Unscheduled">
            <?php if(count($today_start)>0): ?>
                <?php $__currentLoopData = $today_start; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php
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
                ?>
                <div class="lesson-listnew-1">
                    <div class="row align-items-center">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Upcoming In <?php echo e($diff); ?> <br> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> </h4>
                        <p><?php echo e($studentData->video_conferencing_platform); ?> Classroom ( <?php echo e($studentData->user_account_id); ?> ) </p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center right-bor">
                        <h4>Your lesson duration</h4>
                        <p class="red-text"><?php echo e($lessonData->language_taught); ?> (<?php echo e($lessonData->lesson_tag); ?>)- <?php echo e($lessonPackageData->time); ?> </p>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center"> 
                        <?php $diff_mins = ''; ?>
                        <?php if($val->lesson_started_at=='' && strtotime(date('H:i')) <= strtotime($val->booking_time)): ?>
                            <?php if(strtotime(date('H:i')) <= strtotime($val->booking_time)): ?>
                                <?php
                                    $currentDtTime = date('Y-m-d H:i');
                                    $bookingDtTime = $val->booking_date." ".$val->booking_time;
                                    $date1 = new DateTime($currentDtTime);
                                    $date2 = new DateTime($bookingDtTime);
                                    $diff_mins = abs($date1->getTimestamp() - $date2->getTimestamp()) / 60;
                                ?>
                            <?php endif; ?>
                            
                            <?php if($diff_mins>=2 && $diff_mins<=60): ?>
                            <a href="<?php echo e(route('student-enter-classroom',['id'=>$val->id])); ?>" class="button-room" onclick="return confirm('Do you want to enter the class room now?')" >Enter class room </a>
                            <?php endif; ?>
                        <?php endif; ?>
                      </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            <?php if(count($today)>0): ?>
                <?php $__currentLoopData = $today; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    ?>
                <div class="my-lesson-list Unscheduled-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> <?php echo e(date('d',strtotime($val->booking_date))); ?> </h4> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> </li>
                          <li> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> <br/> <span class=""><?php echo e(number_format($val->booking_amount,2)); ?> USD</span></li>
                          <li> <?php echo e($lessonData->language_taught); ?> <br/> Language</li>
                          <li> <?php echo e($lessonPackageData->time); ?> <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <?php if($exists && $studentData->profile_photo!=''): ?> 
                                <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                            <?php else: ?>
                                <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                            <?php endif; ?>
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4><?php echo e($studentData->name); ?></h4>
                           <p><?php echo e($studentData->video_conferencing_platform); ?> : <?php echo e($studentData->user_account_id); ?></p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="my-lesson-list Unscheduled-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            <?php endif; ?>
        </div>
        
        
        
        
        <div class="tab-pane" id="canceled"> 
            <?php if(count($cancelled)>0): ?>
                <?php $__currentLoopData = $cancelled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $lessonData = DB::table('lessons')->where('id', $val->lesson_id)->latest('created_at')->first(); 
                    $lessonPackageData = DB::table('lesson_packages')->where('lesson_id', $val->lesson_id)->where('id', $val->lesson_package_id)->latest('created_at')->first(); 
                    $studentData = DB::table('registrations')->where('id', $val->student_id)->latest('created_at')->first(); 
                    
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                    ?>
                <div class="my-lesson-list cancelled-box">
                   <div class="row align-items-center">
                      <div class="col-lg-8 col-md-8 col-sm-8 col-12">
                        <ul class="lesson-list-box">
                          <li><h4> <?php echo e(date('d',strtotime($val->booking_date))); ?> </h4> <?php echo e(date('M Y',strtotime($val->booking_date))); ?> </li>
                          <li> <?php echo e(date('h:i a',strtotime($val->booking_time))); ?> <br/> <span class=""><?php echo e(number_format($val->booking_amount,2)); ?> USD</span></li>
                          <li> <?php echo e($lessonData->language_taught); ?> <br/> Language</li>
                          <li> <?php echo e($lessonPackageData->time); ?> <br/> Duration</li>
                        </ul>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="row align-items-center lesson-list-right">
                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                            <?php if($exists && $studentData->profile_photo!=''): ?> 
                                <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                            <?php else: ?>
                                <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                            <?php endif; ?>
                        </div>
                       
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 pl-0">
                           <h4><?php echo e($studentData->name); ?></h4>
                           <p><?php echo e($studentData->video_conferencing_platform); ?> : <?php echo e($studentData->user_account_id); ?></p>
                        </div>  
         
                        <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                         <!--<a href="#" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>-->
                        </div>
                        
                    </div>
                      </div>
                   </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="my-lesson-list cancelled-box">
               <div class="row align-items-center">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><b>No data Found!!</b></p> 
                  </div>
               </div>
            </div>
            <?php endif; ?>
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


<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<?php /**PATH /home/tokatifc/public_html/resources/views/student/my-lesson.blade.php ENDPATH**/ ?>
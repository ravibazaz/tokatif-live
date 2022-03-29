<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
?>

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

<section class="teacher-contain">
<div class="container">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
      <div class="student-left-sidebar studentleft-tobg">
        <div class="profile-box">
           <div class="row">
             <div class="col">
               <div class="img-profile">
                   <?php 
                        $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );
                    ?>
                    
                    <?php if($exists && $getLoggedIndata->profile_photo!=''): ?> 
                        <img src="<?php echo e(url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)); ?>" class="img-fluid">
                    <?php else: ?>
                        <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                    <?php endif; ?>
                    
                    <!--<img src="<?php echo e(asset('public/frontendassets/images/profile-pic.png')); ?>" class="img-fluid"/>-->
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
           <div class="col">
             <h3><?php echo e($getLoggedIndata->name); ?></h3>
                <h6 style="font-size:10px;">
                    <!-- <img src="<?php echo e(asset('public/frontendassets/images/avilable.png')); ?>"/>-->  
                    <img src="<?php echo e(asset('public/frontendassets/images/offline.png')); ?>"/> Offline (Visited 2days ago)
                </h6>
             </div> 
           <div class="col"><a href="<?php echo e(route('teacher-profile-edit')); ?>">Edit Profile</a></div>
           </div>
           
           <div class="row">
           <div class="col-lg-12">
             <ul>
               <li>Age <span><?php echo e($age); ?> Years</span></li>
               <li>From <span><?php echo e($getLoggedIndata->country_of_origin); ?></span></li>
               <li>Living in  <span><?php echo e($getLoggedIndata->country_living_in); ?> (<?php echo e(date('d-M-Y h:i a')); ?>)</span></li>
               <li>User ID <span><?php echo e($getLoggedIndata->id); ?></span></li>
             </ul>
           </div> 
           </div>
           
           </div>
           
         <div class="my-lessons my-teacher-00 s-profile mt-4">
            <div class="row">
                <div class="col-12"><h2>My Students </h2></div>
            </div>
            
            <?php $__currentLoopData = $myStudentIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                <?php
                    $studentData = DB::table('registrations')->where('id', '=', $val->student_id)->first(); 
                
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                ?>
            <div class="row mt-4">
                <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                 <div class="small-pic">
                    <?php if($exists && $studentData->profile_photo!=''): ?> 
                        <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                    <?php else: ?>
                        <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                    <?php endif; ?>
                </div>
                </div>
               
                <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                   <h4><?php echo e($studentData->name); ?> <span></h4>
                   <h5><?php echo e($studentData->country_living_in); ?></h5>
                   <span> <i class="fa fa-star" aria-hidden="true"></i> 5.0</span>
                </div>  
 
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <!--<span class="btn-book">10</span>-->
                </div>
                
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            
          </div>
            
           
        </div>
     </div>
     
     <div class="col-lg-8 col-md-6 col-sm-12 col-12">
        <div class="languages-section mb-4">
          <div class="row">
            <div class="col-12">
            <h2>Introduction</h2>
             <p> <?php echo e($getLoggedIndata->about_me); ?> </p>
            </div>
            
          </div>
          <div class="languages-box">
            <div class="row">
              <div class="col-lg-12 col-12">
               <h3>Languages I know</h3>
               
                <?php if($getLoggedIndata->languages_spoken!=''): ?>
               
                    <?php
                      $skillLanguageArr = json_decode($getLoggedIndata->languages_spoken, true);  //dd($skillLanguageArr); 
                    ?>
                
                    <?php if(count($skillLanguageArr)>0): ?>
                    <ul>
                       
                        <?php $__currentLoopData = $skillLanguageArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                              if($val['level']=='Native')
                                $l_img = 'meter4.png';
                              elseif($val['level']=='Beginner')
                                $l_img = 'meter4.png';
                              elseif($val['level']=='Elementary')
                                $l_img = 'meter3.png';
                              elseif($val['level']=='Intermediate')
                                $l_img = 'meter2.png';
                              elseif($val['level']=='Upper Intermediate')
                                $l_img = 'meter1.png';
                              elseif($val['level']=='Advanced')
                                $l_img = 'meter1.png';
                              elseif($val['level']=='Proficient')
                                $l_img = 'meter1.png';
                              elseif($val['level']=='')
                                $l_img = 'meter4.png';
                            ?>
                            <li> 
                                <a href="javascript:void(0);">   
                                <?php echo e($val['language']); ?> <img src="<?php echo e(asset('public/frontendassets/images/'.$l_img)); ?>" class="img-fluid"/> 
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       
                     <!--<li><a href="#">English <img src="<?php echo e(asset('public/frontendassets/images/meter1.png')); ?>" class="img-fluid"/></a></li>
                     <li><a href="#">German <img src="<?php echo e(asset('public/frontendassets/images/meter2.png')); ?>" class="img-fluid"/></a></li>
                     <li><a href="#">Japanese <img src="<?php echo e(asset('public/frontendassets/images/meter3.png')); ?>" class="img-fluid"/></a></li>
                     <li><a href="#">Chinese <img src="<?php echo e(asset('public/frontendassets/images/meter4.png')); ?>" class="img-fluid"/></a></li>-->
                    </ul>
                    <?php endif; ?>
                    
                <?php endif; ?>
               </div>
             </div> 
             <hr>
            <div class="row">
              <div class="col-lg-12 col-12">
               <h3>Languages I taught </h3>
                
                <?php if($getLoggedIndata->languages_taught!=''): ?>
                
                    <?php
                      $taughtLanguageArr = json_decode($getLoggedIndata->languages_taught, true);  //dd($taughtLanguageArr); 
                    ?>
                
                    <?php if(count($taughtLanguageArr)>0): ?>
                    <ul>
                       
                        <?php $__currentLoopData = $taughtLanguageArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li> 
                                <a href="javascript:void(0);">   
                                <?php echo e($value['language']); ?> <img src="<?php echo e(asset('public/frontendassets/images/meter1.png')); ?>" class="img-fluid"/> 
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    </ul>
                    <?php endif; ?>
                    
                <?php endif; ?>
               </div>
             </div> 
          </div>
        </div>        
                  
                  
        <div class="my-lessons lesson-feedback mt-4">
            <div class="row"><div class="col"><h2>Lesson Feedback</h2></div></div>
             <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-left">Completed Lessons</div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center">No of Badges</div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-right">Reviews</div>
             </div>
             
             <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-left"><?php echo e($completedLessonCount); ?></div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center">49</div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-right">100</div>
             </div>
             
          </div> 
        
        <div class="my-lessons lesson-feedback mt-4">
            <div class="row"><div class="col"><h2>Community Activity</h2></div></div>
             <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-left">Article Post</div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center">Forum</div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-right">Comments</div>
             </div>
             
             <div class="row">
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-left"><?php echo e($postedArticleCount); ?></div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center"><?php echo e($postedForumCount); ?></div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-right">100</div>
             </div>
             
          </div>  
                
     </div>
   </div>
  </div>
</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/profile.blade.php ENDPATH**/ ?>
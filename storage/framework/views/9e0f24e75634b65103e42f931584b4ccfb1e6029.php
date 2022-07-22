<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

?>



<section class="teacher-contain">

<div class="container">

  <div class="row">

    <?php $flag = ''; ?>

    <?php if($getLoggedIndata->country_living_in!=''): ?>

        <?php

            $countryFlagData = DB::table('countries')->where('name', '=', $getLoggedIndata->country_living_in)->first(); 

            $flag = strtolower($countryFlagData->sortname);

        ?>

    <?php else: ?>

        <?php

            $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

            $flag = "";
            if($countryFlagData)
            {
              $flag = strtolower($countryFlagData->sortname);
            }

        ?>

    <?php endif; ?>

    <?php if(session()->has('success')): ?>
        <div class="col-md-12">
            <div class="alert alert-success">
                <?php echo e(session()->get('success')); ?>

            </div>
        </div>
    <?php elseif(session()->has('error')): ?>
        <div class="col-md-12">
            <div class="alert alert-danger">
                <?php echo e(session()->get('error')); ?>

            </div>
        </div>
    <?php endif; ?>

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      <div class="student-left-sidebar">

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

                    <!--<img src="<?php echo e(asset('public/frontendassets/images/profile-pic.png')); ?>" class="img-fluid"/>  -->

                    

                 <div class="flag-img">

                     <?php if($flag): ?>

                        <img src="<?php echo e(asset('public/frontendassets/images/flags/'.$flag.'.png')); ?>" class="img-fluid">

                     <?php else: ?>

                        <img src="<?php echo e(asset('public/frontendassets/images/flage.png')); ?>"> 

                     <?php endif; ?>

                 </div>

               </div>   

             </div>

             <div class="col"><a href="<?php echo e(route('student-profile-edit')); ?>">Edit Profile</a></div>

           </div>

           

           <div class="row">

           <div class="col-lg-12"><h3><?php echo e($getLoggedIndata->name); ?></h3></div> 

           </div>

           

           <div class="row">

           <div class="col-lg-12">

             <ul>

               <li>User ID <span><?php echo e($getLoggedIndata->id); ?></span></li>

               <li>From <span><?php echo e($getLoggedIndata->country_of_origin); ?></span></li>

               <li>Living in  <span><?php echo e($getLoggedIndata->country_living_in); ?> <br> (<?php echo e(date('d-M-Y h:i a')); ?>)</span></li>

             </ul>

           </div> 

           </div>

           

           </div>

           

        <div class="total-lessons">

          <div id="chartContainer"></div>

        </div>   

        

        <!--

        <div class="total-lessons">

            <h3>Total Lessons</h3>

            <div class="row">

                <div style="width: 100%; height: 40px; position: absolute; top:38.5%; left: 0; margin-top: -20px; line-height:19px; text-align: center; z-index: 999999999999999">

                    <?php echo e($chartTotalLessons); ?> <Br /> Total

                </div>

                <div id="chartContainer"></div>

            </div>

        </div> 

        <div class="download-app">

          <div class="row align-items-center"> 

           <div class="col-lg-4 col-md-5 col-sm-4 col-4">

             <img src="<?php echo e(asset('public/frontendassets/images/yellow-bg.png')); ?>" class="img-fluid"/>

           </div>

           <div class="col-lg-8 col-md-7 col-sm-8 col-8">

               <h4>Download the</h4>

               <h5>Tokatif Mobile App</h5>

           </div>

           </div>

        </div>-->

           

        </div>

     </div>

     

     

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

      

        <div class="languages-section mb-4">

          <div class="row">

            <div class="col"><h2>Languages</h2></div>

            <div class="col"><a href="<?php echo e(route('student-profile-edit')); ?>" class="update-font">Update <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

          </div>

          <div class="languages-box">

            <div class="row">

              <div class="col-lg-12 col-12">

               <h3> Languages I know </h3>

                

                

                <?php if($getLoggedIndata->languages_spoken!=''): ?>

                

                    <?php

                      $skillLanguageArr = json_decode($getLoggedIndata->languages_spoken, true);  //dd($skillLanguageArr); 

                    ?>

                <?php if(count($skillLanguageArr)>0 && $getLoggedIndata->languages_spoken!=''): ?>

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

               <h3>Languages I'm learning</h3>

                

                

                <?php if($getLoggedIndata->languages_taught!=''): ?>

                    <?php

                      $taughtLanguageArr = json_decode($getLoggedIndata->languages_taught, true);  //dd($taughtLanguageArr); 

                    ?>

                <?php if(count($taughtLanguageArr)>0 && $getLoggedIndata->languages_taught!=''): ?>

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

        <div class="my-lessons">

            <div class="row">

            <div class="col"><h2>My Lessons</h2></div>

            <div class="col"><a href="<?php echo e(route('my-lesson')); ?>" class="update-font">Explore All <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

          </div>

            <?php $__currentLoopData = $myLessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php

                    $class="";

                    $iClass="";
                    $status = "";

                    if($val->status=='0'){

                        $status = 'Waiting';

                        $iClass="fa-hourglass-end";

                        $class="Unscheduled";

                    }

                    if($val->status=='1'){

                        $status = 'Booked';

                        $iClass="fa fa-arrow-circle-down";

                        $class="upcom";

                    }

                    if($val->status=='2'){

                        $status = 'Cancelled';

                        $iClass="fa fa-arrow-circle-down";

                        $class="cancel";

                    }

                ?>

            <div class="row mt-4">

                <div class="col-lg-7 col-md-7 col-sm-12 col-12">

                   <h4><?php echo e(date("jS F, Y", strtotime($val->booking_date))); ?> - <?php echo e(date('h:ia', strtotime($val->booking_time))); ?></h4> 

                   <h5><?php echo e($val->language_taught); ?>  |  <?php echo e($val->time); ?></h5> 

                </div>  

                

                <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                    <h5 class="<?php echo e($class); ?>"><i class="fa <?php echo e($iClass); ?>" aria-hidden="true"></i> <?php echo e($status); ?> </h5> 

                    <?php if($val->booking_date > date('Y-m-d')): ?>

                        <?php

                            $datetime1 = new DateTime(date('Y-m-d'));

                            $datetime2 = new DateTime($val->booking_date);

                            $difference = $datetime1->diff($datetime2);

                            $days = $difference->d.' days'; 

                        ?>

                    <p>in <?php echo e($days); ?></p>

                    <?php else: ?>

                        <?php

                            $datetime1 = new DateTime($val->booking_date);

                            $datetime2 = new DateTime(date('Y-m-d'));

                            $difference = $datetime1->diff($datetime2);

                            $days = $difference->d.' days'; 

                        ?>

                    <p>before <?php echo e($days); ?></p>

                    <?php endif; ?>

                </div>

                

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    <?php 

                        $teacherData = DB::table('registrations')->where('id', $val->teacher_id)->first();

                        $exists = file_exists( storage_path() . '/app/user_photo/' . $teacherData->profile_photo );

                    ?>

                    <span class="upcoming-img">

                        <?php if($exists && $teacherData->profile_photo!=''): ?> 

                            <img src="<?php echo e(url('storage/app/user_photo/'.$teacherData->profile_photo)); ?>" class="img-fluid">

                        <?php else: ?>

                            <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                        <?php endif; ?>

                    </span>

                </div>

                

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            

            

          </div>          

        <div class="my-lessons my-teacher-00 mt-4">

            <div class="row">

                <div class="col"><h2>My Teachers </h2></div> 

                <div class="col"><a href="<?php echo e(route('teachers')); ?>" class="update-font">Explore All <i class="fa fa-pencil" aria-hidden="true"></i></a></div>

            </div>

            

            <?php $__currentLoopData = $myTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php 

                    $teacherData = DB::table('registrations')->where('id', $val->teacher_id)->first();

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $teacherData->profile_photo );

                    

                    if($teacherData->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    /* elseif($teacherData->teacher_type=='community_tutor') */
                    else
                        $teacherType = 'Community Tutor';

                ?>

            <div class="row mt-4">

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    <span class="upcoming-img">

                        <?php if($exists && $teacherData->profile_photo!=''): ?> 

                            <img src="<?php echo e(url('storage/app/user_photo/'.$teacherData->profile_photo)); ?>" class="img-fluid">

                        <?php else: ?>

                            <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                        <?php endif; ?>

                    </span>

                </div>

               

                <div class="col-lg-7 col-md-7 col-sm-12 col-12">

                   <h4><?php echo e($teacherData->name); ?> <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5><?php echo e($teacherType); ?></h5>

                   <p><i class="fa fa-circle" aria-hidden="true"></i> Offline (Visited 2days ago)</p>

                </div>  

 

                <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                    <a href="<?php echo e(route('lesson-booking',['id'=>$val->teacher_id])); ?>" class="btn-book">Book</a>

                </div>

                

            </div> 

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            

            

          </div> 

          

       <div class="my-lessons my-teacher-00 mt-4">

            <div class="row">

                <div class="col"><h2>Community Updates</h2></div>

                <div class="col text-right"><div class="dropdown">

                    <span class="btn btn-secondary"> Articles </span>

                </div></div>

            </div>

          

            <?php $__currentLoopData = $communities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php 

                    $postedByData = DB::table('registrations')->where('id', $val->added_by)->first();

                    $exists = file_exists( storage_path() . '/app/user_photo/' . $postedByData->profile_photo );

                    

                    if($postedByData->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    /* elseif($postedByData->teacher_type=='community_tutor')*/
                    else
                        $teacherType = 'Community Tutor';

                ?>

            <div class="row mt-4 mb-3">

                <div class="col-lg-2 col-md-2 col-sm-12 col-12">

                    <span class="upcoming-img">

                        <?php 

                            $postedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $postedByData->profile_photo );

                        ?>

                     

                        <?php if($postedByPhotoExists && $postedByData->profile_photo!=''): ?> 

                          <img src="<?php echo e(url('storage/app/user_photo/'.$postedByData->profile_photo)); ?>" class="img-fluid">

                        <?php else: ?>

                          <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                        <?php endif; ?>

                    </span>

                </div>

               

                <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                   <h4><?php echo e($postedByData->name); ?> <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5><?php echo e($teacherType); ?></h5>

                </div>  

 

                <div class="col-lg-4 col-md-34 col-sm-12 col-12">

                   <h4><?php echo e(date("j M Y", strtotime($val->created_at))); ?> - <?php echo e(date('h:iA', strtotime($val->created_at))); ?></h4> 

                </div>

                

                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">

                 <h4><?php echo e($val->title); ?></h4>

                 <p><?php echo e($val->description); ?></p>

                <ul class="community-list"> 

                    <?php

                        $commentCount = DB::table('community_comments')->where('community_id', '=', $val->id)->count(); 

                    ?>

                    <li><a href="javascript:void(0);"><i class="fa fa-commenting-o" aria-hidden="true"></i> <?php echo e($commentCount); ?> </a></li>

                    

                   <!--<li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                   <li><a href="#"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> 1,005</a></li>

                   <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> 4</a></li>-->

                </ul>    

               </div> 

            </div> 

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            

            

          </div>     

          

          

     </div>

     

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

      <div class="book-free">

        <span class="gift-item"><img src="<?php echo e(asset('public/frontendassets/images/book-gift.png')); ?>" class="img-fluid"/></span>

         <h3>Book Discounted Trial Lessons</h3>

         <p>You have 3 discounted trial lessons left!</p>

        </div>

      <div class="book-free blance-box mt-4">

        <div class="row">

         <div class="col-lg-8 col-md-9 col-sm-9 col-12">

          <h3>Tokatif Tokens</h3>

          <!--<p>USD 10.00</p>-->

          </div>

          <div class="col-lg-4 col-md-3 col-sm-3 col-12">

            <a href="<?php echo e(route('add-credit')); ?>">Add <i class="fa fa-plus-circle" aria-hidden="true"></i></a>

           </div>

          </div>

        </div> 

        <div class="my-lessons my-teacher-00 recommended-teacher mt-4">

            <div class="row">

                <div class="col"><h2>Recommended Teachers</h2></div>

            </div>

          

            <?php $__currentLoopData = $recommendedTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php 

                    $recommendedTeacherLessonCount = DB::table('lessons')->where('deleted_at', '=', null)->where(['user_id'=>$val->id])->count(); 

                

                    $tExists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );

                    

                    if($val->teacher_type=='specialist_teacher')

                        $teacherType = 'Specialist Teacher';

                    /* elseif($val->teacher_type=='community_tutor') */
                    else
                        $teacherType = 'Community Tutor';

                ?>

            <div class="row mt-4">

                <div class="col-lg-3 col-md-3 col-sm-12 col-3"> 

                    <span class="upcoming-img">

                        <?php if($tExists && $val->profile_photo!=''): ?> 

                          <img src="<?php echo e(url('storage/app/user_photo/'.$val->profile_photo)); ?>" class="img-fluid">

                        <?php else: ?>

                          <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                        <?php endif; ?>

                    </span>

                </div>
            

                <div class="col-lg-7 col-md-7 col-sm-12 col-7">

                   <h4><?php echo e($val->name); ?> <span><i class="fa fa-star" aria-hidden="true"></i> 5.0</span></h4>

                   <h5><?php echo e($teacherType); ?></h5>

                   <p><?php echo e($recommendedTeacherLessonCount); ?> Lessons</p>

                </div>  

 

                <div class="col-lg-2 col-md-2 col-sm-12 col-2">

                 <a href="<?php echo e(route('teacher-detail',['id'=>$val->id])); ?>" class="btn-book"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

                </div>

                

            </div> 

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>  

        

         

     </div>

   </div>

  </div>

</section>



<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home/tokatifc/public_html/resources/views/student/dashboard.blade.php ENDPATH**/ ?>
<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php if(session('id')!='' && session('role')=='1'): ?>

    <?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php elseif(session('id')!='' && session('role')=='2'): ?>

    <?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php else: ?>

    <?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>



<?php 

$getVisitorCountry = getVisitorCountry();

?>







<?php echo $__env->make('user/teacher-search-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<section class="find-teacher-section">

 <div class="container-fluid">

     <h2>Found Best Teacher for You </h2>

	<div class="row">

	    

       <div class="col-md-12" id="teacherListDiv"> 

        

        <?php if(count($user)>0): ?>   

            <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="find-teacher-box mb-4">

                

                <div class="row">

                    

                     <div class="col-lg-9 col-md-9 col-sm-12 col-12">

                        

                        <div class="row align-items-center justify-content-between">

                           <div class="col-lg-2 col-md-2 col-sm-2 col-12">

                            <a href="<?php echo e(route('teacher-detail',['id'=>$val->id])); ?>">

                            <div class="find-profile">

                                <?php 

                                    $exists = file_exists( storage_path() . '/app/user_photo/' . $val->profile_photo );

                                ?>

                             

                                <?php if($exists && $val->profile_photo!=''): ?> 

                                  <img src="<?php echo e(url('storage/app/user_photo/'.$val->profile_photo)); ?>" class="img-fluid">

                                <?php else: ?>

                                  <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                                <?php endif; ?>

                                

                            

                            

                                

                            <?php $flag = ''; ?>

                            <?php if($val->country_living_in!=''): ?>

                                <?php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 

                                    $flag = (isset($countryFlagData->sortname)) ? strtolower($countryFlagData->sortname) : "";

                                ?>

                            <?php else: ?>

                                <?php

                                    $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 

                                    $flag = (isset($countryFlagData->sortname)) ? strtolower($countryFlagData->sortname) : "";

                                ?>

                            <?php endif; ?>

                            

                            <span class="find-offline">

                                

                                <?php if($flag): ?>

                                    <img src="<?php echo e(asset('public/frontendassets/images/flags/'.$flag.'.png')); ?>" class="img-fluid">

                                <?php else: ?>

                                    <img src="<?php echo e(asset('public/frontendassets/images/flage.png')); ?>" class="img-fluid"> 

                                <?php endif; ?>

                                

                                <!--<img src="<?php echo e(asset('public/frontendassets/images/fine-offline.png')); ?>" class="img-fluid"/>-->

                            </span>

                           </div>

                            </a>

                           </div>
                           
                           
                           <div class="col-lg-1 col-md-1 col-sm-1 col-12 p-0">

                                <a href="<?php echo e(route('teacher-detail',['id'=>$val->id])); ?>">

                                    <h4> <?php echo e($val->name); ?> <span> </span> </h4>

                                    <p>

                                        <?php
                                          
                                          $teacherType = '';
                                          if($val->teacher_type=='specialist_teacher')

                                            $teacherType = 'Specialist Teacher';

                                          elseif($val->teacher_type=='community_tutor')

                                            $teacherType = 'Community Tutor';

                                          

                                        ?>

                    

                                        <?php echo e($teacherType); ?>


                                        

                                    </p>

                                </a>

                               </div>
                               
                                  
                           <div class="col-lg-9 col-md-9 col-sm-9 col-12 ">

                             <div class="row">

                               

                               

                               <div class="col-lg-6 col-md-6 col-sm-6 col-12 pr-0">

                                <ul class="bdg-icon">

                                 <li>

                                 <img src="<?php echo e(asset('public/frontendassets/images/bdg1.png')); ?>" class="img-fluid"/>

                                  <span class="tool-tips">Hover over me</span>

                                 </li>

                                 <li><img src="<?php echo e(asset('public/frontendassets/images/bdg2.png')); ?>" class="img-fluid"/>

                                  <span class="tool-tips">Hover over 2</span>

                                 </li>

                                 <li><img src="<?php echo e(asset('public/frontendassets/images/bdg3.png')); ?>" class="img-fluid"/>

                                 <span class="tool-tips">Hover over 3</span>

                                 </li>

                                </ul> 

                               </div>

                               <div class="col-lg-6 col-md-6 col-sm-6 col-12  text-right">

                                <?php if(session('id')): ?>

                                    <?php

                                        $favoriteData = DB::table('favorite_teachers')->where('student_id', '=', session('id')) 

                                                                                    ->where('teacher_id', '=', $val->id)

                                                                                    ->where('deleted_at', '=', null)->count(); 

                                    ?>

                                <div class="heard-purple">

                                    <?php if($favoriteData>0): ?>

                                        <img src="<?php echo e(asset('public/frontendassets/images/purple-heard.png')); ?>" class="FavoriteList img-fluid" data-teacherID="<?php echo e($val->id); ?>" data-type="remove" style="cursor: pointer;" /> 

                                    <?php else: ?>

                                        <img src="<?php echo e(asset('public/frontendassets/images/heart-red.png')); ?>" class="FavoriteList img-fluid" data-teacherID="<?php echo e($val->id); ?>" data-type="add" style="cursor: pointer;" />

                                    <?php endif; ?>

                                </div>

                                <?php endif; ?>

                                

                                <?php $currentWeek = date("W", strtotime(date('Y-m-d'))); ?>

                                <a href="<?php echo e(route('lesson-booking',['id'=>$val->id])); ?>" class="book-btn">Book</a> 

                               </div>

                             </div>

                              <div class="row mt-3">

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box">

                                    <?php

                                        //$lessonCount = DB::table('lessons')->where('user_id', '=', $val->id)->where('deleted_at', '=', null)->count();

                                        $lessonCount = DB::table('booking')->where('teacher_id', '=', $val->id)->where('lesson_completed_at', '!=', null)->count();

                                    ?>

                                   <h3><?php echo e($lessonCount); ?></h3>

                                   <p>Lessons</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box">

                                    <?php

                                        $studentCount = DB::table('booking')->where('teacher_id', '=', $val->id)->distinct('student_id')->count('student_id');

                                    ?>

                                   <h3><?php echo e($studentCount); ?></h3>

                                   <p>Students</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">

                                 <div class="r-box hourly">

                                    <?php

                                    $minLessonsPrice = DB::table('lessons')

                                                        ->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')

                                                        ->whereNull('lessons.deleted_at')

                                                        ->where('lessons.user_id', '=', $val->id)

                                                        ->min('lesson_packages.total');

                                    $min_individual_lesson = DB::table('lessons')

                                                        ->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')

                                                        ->whereNull('lessons.deleted_at')

                                                        ->where('lessons.user_id', '=', $val->id)

                                                        ->min('lesson_packages.individual_lesson');

                                    $min_amount = $min_individual_lesson;
                                    if($min_individual_lesson > $minLessonsPrice)
                                    {
                                      $min_amount = $packageData;
                                    } 

                                    ?>

                                   <h3>USD <?php echo e(number_format($min_amount,2)); ?> </h3>

                                   <p>Min Booking Price</p>

                                 </div>

                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-6 col-12">

                                 <div class="r-box hourly">

                                    <?php

                                    $maxLessonsPrice = DB::table('lessons')

                                                        ->leftJoin('lesson_packages', 'lessons.id', '=', 'lesson_packages.lesson_id')

                                                        ->whereNull('lessons.deleted_at')

                                                        ->where('lessons.user_id', '=', $val->id)

                                                        ->max('lesson_packages.total'); 

                                    ?>

                                   <h3>USD <?php echo e(number_format($maxLessonsPrice,2)); ?></h3>

                                   <p>Max Booking Price</p>

                                   <!--<p>Trial</p>-->

                                 </div>

                                </div>

                              </div>

                           </div>                        

                        </div>

                        <hr/>

                        <div class="row"> 

                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                            <div class="languages-box">

                               <h3>Teaches</h3>

                                <?php

                                  $taughtLanguageArr = json_decode($val->languages_taught, true);  

                                ?>

                                

                                <?php if($val->languages_taught!='' && count($taughtLanguageArr)>0): ?>

                                <ul>

                                   

                                    <?php $__currentLoopData = $taughtLanguageArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <li> 

                                            <a href="javascript:void(0);">   

                                            <?php echo e($value['language']); ?> <img src="<?php echo e(asset('public/frontendassets/images/meter1.png')); ?>" class="img-fluid"/> 

                                            </a>

                                        </li>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                

                                </ul>

                                <?php else: ?>

                                <ul><li> N/A </li></ul>

                                <?php endif; ?>

        					</div>

                          </div> 

                          <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                           <div class="languages-box">

                               <h3>Also Speak</h3>

                                <?php

                                  $skillLanguageArr = json_decode($val->languages_spoken, true);  

                                ?>

                                

                                <?php if($val->languages_spoken !='' && count($skillLanguageArr)>0): ?>

                                <ul>

                                    <?php $__currentLoopData = $skillLanguageArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php

                                          if($value['level']=='Native')

                                            $l_img = 'meter4.png';

                                          elseif($value['level']=='Beginner')

                                            $l_img = 'meter4.png';

                                          elseif($value['level']=='Elementary')

                                            $l_img = 'meter3.png';

                                          elseif($value['level']=='Intermediate')

                                            $l_img = 'meter2.png';

                                          elseif($value['level']=='Upper Intermediate')

                                            $l_img = 'meter1.png';

                                          elseif($value['level']=='Advanced')

                                            $l_img = 'meter1.png';

                                          elseif($value['level']=='Proficient')

                                            $l_img = 'meter1.png';

                                          elseif($value['level']=='')

                                            $l_img = 'meter4.png';

                                        ?>

                                        <li> 

                                            <a href="javascript:void(0);">   

                                            <?php echo e($value['language']); ?> <img src="<?php echo e(asset('public/frontendassets/images/'.$l_img)); ?>" class="img-fluid"/> 

                                            </a>

                                        </li>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                 

                                </ul>

                                <?php else: ?>

                                N/A

                                <?php endif; ?>

        					</div>

                          </div>

                        </div>

                        

                     </div>

                    

                 

                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                        <div class="find-video">

                         <?php if($val->youtube_link !=''): ?>

                            <iframe width="100%" height="100%" src="<?php echo e(str_replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/", $val->youtube_link)); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                         <?php elseif($val->video !=''): ?>

                            

                         <?php else: ?>

                         <?php echo e($val->about_me); ?>


                         <?php endif; ?>

                        </div>

                    </div> 

                </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php else: ?>

        <div class="find-teacher-box mb-4 text-center">

            No teacher found!!

        </div>

        <?php endif; ?>

        

        

        

       </div>



	</div>

  </div>

</section>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



<script src="https://cdn.jsdelivr.net/gh/andreivictor/bootstrap-tooltip-custom-class@1.1.0/bootstrap-v4/tooltip/dist/js/bootstrap-tooltip-custom-class.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/13.1.5/nouislider.js"></script>



<script>

$(".box-video").click(function(){

  $('iframe',this)[0].src += "&amp;autoplay=1";

  $(this).addClass('open');

});

</script>





<script>



document.addEventListener("DOMContentLoaded", function(){

  window.addEventListener('scroll', function() {

      if (window.scrollY > 50) {

        document.getElementById('navbar_top').classList.add('fixed-top');

        // add padding top to show content behind navbar

        navbar_height = document.querySelector('.navbar').offsetHeight;

        document.body.style.paddingTop = navbar_height + 'px';

      } else {

        document.getElementById('navbar_top').classList.remove('fixed-top');

         // remove padding top from body

        document.body.style.paddingTop = '0';

      } 

  });

}); 

// DOMContentLoaded  end

</script>







<script>



var rangeSlider = document.getElementById('slider-range');



noUiSlider.create(rangeSlider, {

    start: [4000],

    range: {

        'min': [1],

        'max': [10000]

    }

});

var rangeSliderValueElement = document.getElementById('slider-range-value');

rangeSlider.noUiSlider.on('update', function (values, handle) {

    rangeSliderValueElement.innerHTML = values[handle];

});

</script>



<script>

//$(document).click(function(e) {

//	if (!$(e.target).is('.card-body')) {

//    	$('.card-body').collapse('hide');	    

//    } 

//});



jQuery('button').click( function(e) {

    jQuery('#headingSix').collapse('hide');

});



</script>









<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>









<?php /**PATH /home/tokatifc/public_html/resources/views/user/teachers.blade.php ENDPATH**/ ?>
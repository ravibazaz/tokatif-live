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





<section class="article-list">

<div class="container-fluid">

  <div class="row">
  
    <div class="col-lg-3 col-md-3 col-sm-12 col-12 mt-5">
        <?php if(session('id')!='' && session('role')=='2'): ?>
            <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
     </div>
     

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

       <div class="row">

        

        <?php if(count($communities)>0): ?>   

            <?php $__currentLoopData = $communities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-lg-6 col-md-6 col-sm-6 col-12 mt-5">

               <div class="aricle-box">

                    <?php 

                        $exists = file_exists( storage_path() . '/app/article/' . $val->photo );

                    ?>

                    

                    <?php if($exists && $val->photo!=''): ?> 

                        <img src="<?php echo e(url('storage/app/article/'.$val->photo)); ?>" class="img-fluid">

                    <?php else: ?>

                        <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                    <?php endif; ?>

                    

                    

                    <a href="<?php echo e(route('community-detail',['id'=>$val->id])); ?>"><h4><?php echo e($val->title); ?></h4></a>    

                    <p><?php echo e($val->description); ?></p>   

                    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <?php

                        $addedByData = DB::table('registrations')->where('id', '=', $val->added_by)->first(); 

                        $addedByName = $addedByData->name;

                          

                          if($addedByData->teacher_type!='' && $addedByData->teacher_type=='specialist_teacher')

                            $teacherType = 'Specialist Teacher';

                          elseif($addedByData->teacher_type!='' && $addedByData->teacher_type=='community_tutor')

                            $teacherType = 'Community Tutor';

                          else

                            $teacherType = '';

                          

                        ?>

                        

                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 pr-0">

                            <?php 

                                $addedByPhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedByData->profile_photo );

                            ?>

                         

                            <?php if($addedByPhotoExists && $addedByData->profile_photo!=''): ?> 

                              <img src="<?php echo e(url('storage/app/user_photo/'.$addedByData->profile_photo)); ?>" class="img-fluid">

                            <?php else: ?>

                              <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                            <?php endif; ?>

                         <!--<img src="<?php echo e(asset('public/frontendassets/images/upload-teacher.png')); ?>" class="img-fluid">-->

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">

                           <h4><?php echo e($addedByName); ?></h4>

                           <h5><?php echo e($teacherType); ?></h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                          <h3><?php echo e(date("F d, Y", strtotime($val->created_at))); ?></h3>

                        </div> 

                     </div>

                     <hr/>

                     <div class="row">

                      <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">

                        <?php

                          $taughtLanguageArr = json_decode($addedByData->languages_taught, true);  

                        ?>

                        

                        

                        <ul class="community-list">

                            <?php if($addedByData->languages_taught!='' && count($taughtLanguageArr)>0): ?>

                            <?php $__currentLoopData = $taughtLanguageArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <li> 

                                    <a href="javascript:void(0);">   

                                    <?php echo e($value['language']); ?> <img src="<?php echo e(asset('public/frontendassets/images/meter1.png')); ?>" class="img-fluid"/> 

                                    </a>

                                </li>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php endif; ?>

                            

                            <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                            <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 

                        

                        </ul>

                        

                        

                    <!--<ul class="community-list">

                       <li><a href="#">Japanese <img src="<?php echo e(asset('public/frontendassets/images/meter3.png')); ?>" class="img-fluid"></a></li>

                       <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> 1,005</a></li>

                       <li><a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> 654</a></li> 

                    </ul>-->

                    </div>

                    </div>

                    

             		</div>

               </div>

            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php else: ?>

            <div class="col-md-12">

                <div class="aricle-box">

                    <h2 class="text-center">No article found!!</h2>

                </div>

            </div>

        <?php endif; ?>

        

      </div>

     </div>

     <div class="col-lg-3 col-md-3 col-sm-12 col-12">

        <?php if(session('role')=='2'): ?>

            <a href="<?php echo e(route('add-community')); ?>" class="btn btn-submit">Create New Article</a>

        <?php endif; ?>

       <div class="aricle-box mb-5">

        <h2>Trending Articles</h2>

        

            <?php if(count($TrendingArticles)>0): ?>   

                <?php $__currentLoopData = $TrendingArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="trending-box">

                    <h3><?php echo e($pValue->title); ?></h3>    

                    <div class="my-lessons my-teacher-00 mt-3">

                        <div class="row align-items-center">

                            <?php

                            $addedBy_P_Data = DB::table('registrations')->where('id', '=', $pValue->added_by)->first(); 

                            $addedByPName = $addedBy_P_Data->name;

                              

                              if($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='specialist_teacher')

                                $teacherTypeP = 'Specialist Teacher';

                              elseif($addedBy_P_Data->teacher_type!='' && $addedBy_P_Data->teacher_type=='community_tutor')

                                $teacherTypeP = 'Community Tutor';

                              else

                                $teacherTypeP = '';

                              

                            ?>

                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                                <?php 

                                    $addedBy_P_PhotoExists = file_exists( storage_path() . '/app/user_photo/' . $addedBy_P_Data->profile_photo );

                                ?>

                             

                                <?php if($addedBy_P_PhotoExists && $addedBy_P_Data->profile_photo!=''): ?> 

                                  <img src="<?php echo e(url('storage/app/user_photo/'.$addedBy_P_Data->profile_photo)); ?>" class="img-fluid">

                                <?php else: ?>

                                  <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   

                                <?php endif; ?>

                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                               <h4><?php echo e($addedByPName); ?></h4>

                               <h5><?php echo e($teacherTypeP); ?></h5>

                            </div> 

                            <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                              <h3><?php echo e(date("F d, Y", strtotime($pValue->created_at))); ?></h3>

                            </div> 

                        </div>

                 	</div>

                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

            

            

           <!--<div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="<?php echo e(asset('public/frontendassets/images/upload-teacher.png')); ?>" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>

           <div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="<?php echo e(asset('public/frontendassets/images/upload-teacher.png')); ?>" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>

           <div class="trending-box">

                  <h3>Bachelor of Arts in Counseling Skills</h3>    

                  <div class="my-lessons my-teacher-00 mt-3">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 pr-0">

                         <img src="<?php echo e(asset('public/frontendassets/images/upload-teacher.png')); ?>" class="img-fluid">

                         </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">

                           <h4>Mr. Zhang </h4>

                           <h5>Community Tutor</h5>

                        </div> 

                        <div class="col-lg-3 col-md-3 col-sm-12 col-12 p-0">

                          <h3>Sep 1, 2020</h3>

                        </div> 

                     </div>

                    

             		</div>

               </div>  -->      

       </div>

       

      <figure><img src="<?php echo e(asset('public/frontendassets/images/ad-post.png')); ?>" class="img-fluid"/></figure> 

     </div>

   </div>

  </div>

</section>





<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php /**PATH /home/tokatifc/public_html/resources/views/community/list.blade.php ENDPATH**/ ?>
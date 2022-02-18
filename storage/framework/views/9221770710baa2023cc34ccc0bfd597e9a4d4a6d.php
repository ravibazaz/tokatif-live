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





<section class="support-list">

  <div class="container">

    <div class="row">
    
    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
        <?php if(session('id')!='' && session('role')=='2'): ?>
            <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
     </div>

      <div class="col-lg-9 col-md-9 col-sm-12 col-12 m-auto">

          

        <?php $__currentLoopData = $support; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            

            <?php 

                $exists = file_exists( storage_path() . '/app/support/' . $val->image ); 

            ?>



        <div class="g__space"> 

          <!--<a href="/en/collections/2415332-help-for-users" class="paper ">-->

          <div class="collection o__ltr paper">

            <div class="collection__photo">

			 <?php if($exists && $val->image!=''): ?> 

                <img src="<?php echo e(url('storage/app/support/'.$val->image)); ?>" class="img-fluid"> 

             <?php else: ?>

                <img src="<?php echo e(asset('public/frontendassets/images/help.png')); ?>" class="img-fluid">   

             <?php endif; ?>

            </div>

            <div class="collection_meta" dir="ltr">

              <h2 class="t__h3 c__primary"><?php echo e($val->title); ?></h2>

              <p class="paper__preview"><?php echo e($val->description); ?></p>

              <div class="avatar">

                <div class="avatar__photo avatars__images o__ltr">  

                <img src="<?php echo e(url('storage/app/fabicon.ico')); ?>" alt="Stacy avatar" class="avatar__image"> </div>

                <div class="avatar__info">

                  <div> <span class="c__darker"> Written by </span> <br>

                     <span class="c__darker"> Admin </span> </div>

                </div>

              </div>

            </div> 

          </div>

          <!--</a> -->

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          

          

              

      </div>

    </div>

  </div>

</section>





<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>









<?php /**PATH /home/tokatifc/public_html/resources/views/support/list.blade.php ENDPATH**/ ?>
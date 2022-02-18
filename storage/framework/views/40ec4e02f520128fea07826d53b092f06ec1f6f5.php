<?php
 $websitedata = getwebsite_data();
 $getLoggedIndata = getLoggedinData();
?>

<header>

<section class="logo-part inner-header">
    <div id="nav_bg">
    <div class="container"> 
      <div class="row justify-content-end">
        <div class="col-lg-5 col-md-6 col-sm-6 col-12">
          <a class="navbar-brand float-left d-inline-block" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('storage/app/imagesdoc/inner_logo.png')); ?>" class="img-fluid"/></a>
          <a class="navbar-brand float-left d-none" href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('storage/app/imagesdoc/inner_logo.png')); ?>" class="img-fluid"/></a>
          
           <?php echo $__env->make('include/header-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
          
        </div> 
        
        <div class="col-lg-7 col-md-6 col-sm-6 col-12 float-right text-right right-menu"> 
          <a class="log-in" href="<?php echo e(route('teacher-dashboard')); ?>"><i class="fa fa-th-large" aria-hidden="true"></i> Dashboard </a>
          <!--<a class="log-in" href="<?php echo e(route('teachers')); ?>"><i class="fa fa-search" aria-hidden="true"></i>Find a Teacher</a>-->
          <a class="log-in" href="<?php echo e(route('view-calendar')); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> Calendar</a>
          <a class="log-in" href="<?php echo e(route('messages')); ?>"><i class="fa fa-comments" aria-hidden="true"></i> Messages</a>
          <div class="dropdown">
            <?php 
                $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );
            ?>
            <span class="profile-icon">
                <?php if($exists && $getLoggedIndata->profile_photo!=''): ?> 
                  <img src=<?php echo e(url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)); ?> class="img-fluid">
                <?php else: ?>
                  <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                <?php endif; ?>
                 <!--<img src="<?php echo e(asset('public/frontendassets/images/profile-img.png')); ?>" class="img-fluid"/>-->
            </span>
              <button class="btn btn-profile-top dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
              <?php echo e($getLoggedIndata->name); ?>

              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php echo e(route('teacher-profile')); ?>"><i class="fa fa-user" aria-hidden="true"></i> View Profile</a>
                    <a class="dropdown-item" href="<?php echo e(route('switch-to-student-mode')); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Switch to student mode </a>
                    <!--
                    <a class="dropdown-item" href="#"><i class="fa fa-gift" aria-hidden="true"></i> Refer a Friend</a>-->
                    <a class="dropdown-item" href="<?php echo e(URL::route('logout')); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                
              </div>
            </div> 
          
        </div>
         
    </div>
    </div>
  </div>
</section>
</header><?php /**PATH /home/tokatifc/public_html/resources/views/include/teacher-dashboard-header.blade.php ENDPATH**/ ?>
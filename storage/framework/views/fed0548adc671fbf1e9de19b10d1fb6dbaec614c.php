<?php

 $websitedata = getwebsite_data();

 $loggedindata = getLoggedinData();

?> 

   

<header>



<section class="logo-part">

    <div id="nav_bg">

    <div class="container-fluid"> 

      <div class="row justify-content-end">

        <div class="col-lg-6 col-md-5 col-sm-6 col-12">

          <a class="navbar-brand float-left d-inline-block" href="<?php echo e(url('/')); ?>">

            <img src="<?php echo e(asset('storage/app/imagesdoc/'.$websitedata[0]->logo)); ?>" class="img-fluid"/>

          </a>

          <a class="navbar-brand float-left d-none" href="<?php echo e(url('/')); ?>">

            <img src="<?php echo e(asset('storage/app/imagesdoc/'.$websitedata[0]->logo)); ?>" class="img-fluid"/>

          </a>

          <div class="follow-social social-top float-right">

              <ul>

                <li><a target="_blank" href="<?php echo e($websitedata[0]->facebook_link); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                <li><a target="_blank" href="<?php echo e($websitedata[0]->linkedin_link); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                <li><a target="_blank" href="<?php echo e($websitedata[0]->twitter_link); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

              </ul>

            </div>
            

          <?php echo $__env->make('include/header-search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

          

        </div> 

        

        <div class="col-lg-4 col-md-6 col-sm-4 col-12 float-right text-right pr-lg-0">

            

            

            <?php if(Session::has('id')): ?>

                <?php if($loggedindata->role!='2'): ?> 

                    <a class="log-in" href="<?php echo e(route('teachers')); ?>"><i class="fa fa-search" aria-hidden="true"></i> Find a Teacher</a>

                <?php endif; ?>

            <?php else: ?>

                <a class="log-in" href="<?php echo e(route('teachers')); ?>"><i class="fa fa-search" aria-hidden="true"></i> Find a Teacher</a>

            <?php endif; ?>

               

          

              

          

          

          <?php if(Session::has('id')): ?>

            <?php if($loggedindata->role=='1'): ?> 

                <a class="bnt-teach" href="<?php echo e(route('student-dashboard')); ?>">Dashboard</a> 

            <?php else: ?>

                <a class="bnt-teach" href="<?php echo e(route('teacher-dashboard')); ?>">Dashboard</a>

            <?php endif; ?> 

          

            <a class="log-in" href="<?php echo e(URL::route('logout')); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout </a>

          <?php else: ?>

          <a class="bnt-teach" href="<?php echo e(route('create-teacher-account')); ?>">Teach with us</a> 

          <a class="bnt-teach" href="<?php echo e(route('create-account')); ?>">Learn with us</a>

         
        </div>
        
        
         <div class="col-lg-2 col-md-1 col-sm-2 col-12 float-right text-right">
         
         
         
            <a class="log-in" href="<?php echo e(route('login')); ?>"><i class="fa fa-user-o" aria-hidden="true"></i> Log in</a>

          <a class="log-in" href="<?php echo e(route('create-account')); ?>"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign Up</a>

          <?php endif; ?>
         </div>

         

    </div>

    </div>

  </div>

</section>



  <!--<div class="navbar_wrap">

    <section class="top_head">



      <div class="container">



        <div class="row">



          <div class="col-lg-8 col-md-12 col-sm-12">



            <div class="top-top">



              <ul class="list-inline">



                <li class="list-inline-item"><i class="fa fa-phone" aria-hidden="true"></i><a href="#" target="_blank">1-800-123-1234</a></li>



                <li class="list-inline-item"><i class="fa fa-paper-plane" aria-hidden="true"></i> <a href="#" target="_blank">aislingkellynutrition@gmail.com</a></li>

                

                <li class="list-inline-item"><i class="fa fa-clock-o" aria-hidden="true"></i><a href="#" target="_blank">Mon-Sat: 9am to 6pm</a></li> 	   		



              </ul>     



            </div>



                   



          </div>

          <div class="col-lg-4 col-md-12 col-sm-12">



            <div class="social_top">



              <ul class="list-inline">



                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i>

</a></li>



                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i>

</a></li>

                

                <li class="list-inline-item"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> 	   		



              </ul>     



            </div>



                   



          </div>



        </div>



      </div>



    </section>

  </div>-->



</header>

<?php /**PATH /home/tokatifc/public_html/resources/views/include/header.blade.php ENDPATH**/ ?>
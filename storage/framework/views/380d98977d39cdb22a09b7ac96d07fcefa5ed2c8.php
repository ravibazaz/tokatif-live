<html lang="en">

<head>
    <?php
        $websitedata = getwebsite_data()
    ?>
    
<title><?php echo e($websitedata[0]->website); ?></title>

<!-- Required meta tags -->

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

<link rel="icon" type="image/png" href="<?php echo e(asset('storage/app/fabicon.ico')); ?>"  />


<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 


<!-- Bootstrap -->
<!--<link href="<?php echo e(asset('public/frontendassets/css/flags.css?ddasda=42342423')); ?>" rel="stylesheet">-->

<link href="<?php echo e(asset('public/frontendassets/css/style.css')); ?>" rel="stylesheet">

<link href="<?php echo e(asset('public/frontendassets/css/bootstrap.min.css')); ?>" rel="stylesheet">


<link rel="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css">



<link href="<?php echo e(asset('public/frontendassets/css/font-awesome.min.css')); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('public/frontendassets/css/css_animate.css')); ?>">

</head>


<body>



<!-- Preloader -->
<!--<div id="preloader">
   <div class="center">
      <div class="spinner">
         <div class="blob top"></div>
         <div class="blob bottom"></div>
         <div class="blob left"></div>
         <div class="blob move-blob"></div>
      </div>
   </div>
</div>-->




<div class="top_btn"> 
    <a class="scrollToTop" href="javascript:void(0)" style="display: block;"> <i class="fa fa-angle-up" aria-hidden="true"></i></a> 
</div>
 
 
 <?php /**PATH /home/tokatifc/public_html/resources/views/include/head.blade.php ENDPATH**/ ?>
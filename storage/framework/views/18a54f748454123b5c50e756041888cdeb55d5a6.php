<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="banner_sec">
 <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

          <ol class="carousel-indicators">
         
          <?php for($i=0;$i<count($banner_data);$i++): ?>
         
          <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo e($i); ?>" <?php if($i == 0): ?> class="active" <?php else: ?> class="" <?php endif; ?>></li>
             
          <?php endfor; ?>

        </ol>

          <div class="carousel-inner">

   <?php for($i=0;$i<count($banner_data);$i++): ?>
            <div <?php if($i == 0): ?> class="carousel-item active" <?php else: ?> class="carousel-item" <?php endif; ?> > <img class="img-fluid" src="<?php echo e(asset('storage/app/imagesdoc/'.$banner_data[$i]->image)); ?>" alt="First slide">
            

              <div class="carousel-caption">

                <div class="container">

                  <div class="row">

                    <div class="col-lg-12 text-left">
                        
                    <?php
                    echo($banner_data[$i]->title)
                    ?>   
                  
                       <form action="">         
                          <div class="input-group mb-4 border rounded-pill p-1">
                            <input type="search" placeholder="Find My Teacher" aria-describedby="button-addon3" class="form-control bg-none border-0">
                            <div class="input-group-append border-0">
                              <button id="button-addon3" type="button" class="btn btn-link text-success"><i class="fa fa-search"></i></button>
                            </div>
                          </div>
                        </form>
                    </div>

                </div>

              </div>

            </div>

            </div>
    <?php endfor; ?>

        </div>

     </div>
</section>

<section class="language-section">
  <div class="container">
   <div class="row">
       
    <?php $__currentLoopData = $languages_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
       <div class="language-box">
         <a href="javascript:void(0);"><span><img src="<?php echo e(asset('storage/app/language/'.$values->image)); ?>" class="img-fluid"/></span> 
             <?php echo e($values->name); ?> </a>
       </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
       
       
      
       
    </div>
  </div>
</section>

<div class="container">
 <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
   <h3 class="why-title">Why Learn with Tokatif</h3>
   </div>
  </div>
</div>

<section class="why-learn">
  <div class="container">
    <div class="row">
        <?php $__currentLoopData = $whylearns_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_one=>$values_one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        
      <div class="col-lg-4 col-md-4 col-sm-6 col-12">
         <div class="why-box">
            <figure><img src="<?php echo e(asset('storage/app/whylearn/'.$values_one->image)); ?>" class="img-fluid"/> 
                <img src="<?php echo e(asset('storage/app/whylearn/'.$values_one->hover_image)); ?>" class="img-fluid img_hover"/></figure>
           <h4><?php echo e($values_one->title); ?></h4>
           <p> <?php echo e($values_one->description); ?></p>
         </div>
      </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
     
    </div>
  </div>
</section>

<div class="container">
 <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <a href="<?php echo e(route('create-account')); ?>" class="start-btn">Start  Learning Now</a>
   </div>
  </div>
</div>


   
<section class="why-teach">
  <div class="container">
   <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <h3>Why Teach with Tokatif</h3>
   </div>
  </div>
   <div class="row">
       
       
     <?php $__currentLoopData = $whyteches_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_one=>$values_one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
     <div class="col-lg-4 col-md-4 col-sm-4 col-12">
       <div class="teach-box">
          <div class="bg-icon"><img src="<?php echo e(asset('storage/app/whytech/'.$values_one->image)); ?>" class="img-fluid"/></div>
         <h4><?php echo e($values_one->title); ?> </h4>
         <p><?php echo e($values_one->description); ?></p>
       </div>
    </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  

       
       
   </div>
   
   <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-12">
     <a href="<?php echo e(route('create-teacher-account')); ?>" class="start-teaching">Start Teaching Now</a>
   </div>
  </div>
  
  </div>

</section>

<section class="how-it-work">
  <div class="container">
   <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <h3>How It Works</h3>
   </div>
   </div>
   <div class="row">
       
       
    <?php $__currentLoopData = $howitworks_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_one=>$values_one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
       <div class="how-box how-box1" style="background-image:url(<?php echo e(asset('storage/app/howitworks/'.$values_one->back_image)); ?>);background-repeat: no-repeat;
background-position: bottom center;">
                     
            <figure><img src="<?php echo e(asset('storage/app/howitworks/'.$values_one->image)); ?>" class="img-fluid" ></figure>
            <h4><?php echo e($values_one->title); ?> </h4>
            <p><?php echo e($values_one->description); ?></p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
            
       
   </div>
 </div>
</section>

<section class="become-fluent">
   <div class="container">
     <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
      <h3>Become fluent in</h3>
   </div>
   </div>
     <div class="row">
         
         
         
         <?php $__currentLoopData = $becomefluents_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_one=>$values_one): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
       <div class="col-lg-3 col-md-3 col-sm-4 col-6">
         <div class="fluent-box">
           <figure><img src="<?php echo e(asset('storage/app/becomefluent/'.$values_one->image)); ?>" class="img-fluid"/>
           <a href="javascript:void(0);"><?php echo e($values_one->title); ?></a>
           </figure>
                    
         </div>
       </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
         
         
     </div>
     <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
        <h4>Don’t see the language you’re looking for?</h4>
        <a href="javascript:void(0);" class="start-teaching">Browse All Languages</a>
    </div>
  </div>
  </div>
</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/tokatifc/staging.tokatif.com/resources/views/home/homepage.blade.php ENDPATH**/ ?>
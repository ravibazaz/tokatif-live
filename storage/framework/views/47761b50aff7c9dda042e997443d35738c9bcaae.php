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
            <div <?php if($i == 0): ?> class="carousel-item active" <?php else: ?> class="carousel-item" <?php endif; ?> >  
            <img class="img-fluid" src="<?php echo e(asset('storage/app/home_banner/'.$banner_data[$i]->image)); ?>" alt="First slide">
            

              <div class="carousel-caption">

                <div class="container">

                  <div class="row">

                    <div class="col-lg-12 text-left">
                        
                    <?php
                    echo($banner_data[$i]->title)
                    ?>   
                  
                       
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
   <div class="row align-items-center">
       
    <?php $__currentLoopData = $languages_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
       <div class="language-box">
         <a href="<?php echo e(route('teacher-search',['language'=>$values->name])); ?>"><span><img src="<?php echo e(asset('storage/app/language/'.$values->image)); ?>" class="img-fluid"/></span> 
             <?php echo e($values->name); ?> </a>
       </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    
    
       
    </div>
    
   <div class="row align-items-center"> 
    <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center m-auto">
       
      <div class="language-box dropdown">
  <button class="btn btn-warning btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
    SEE MORE
  </button>
  <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(10px, 58px, 0px); top: 0px; left: 0px; will-change: transform;">
  
  <div class="ant-row">
    <div class="ant-col ant-col-24 border-b border-gray6 flex capitalize "><span class="ant-input-search my-3 mx-4 ant-input-affix-wrapper"><span class="ant-input-prefix"><svg width="24" height="24" viewBox="0 0 24 24" fill="#BFBFBF" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M6.75 12C6.75 9.10051 9.10051 6.75 12 6.75C14.8995 6.75 17.25 9.10051 17.25 12C17.25 13.347 16.7427 14.5755 15.9088 15.5049C15.8209 15.5415 15.7385 15.5956 15.667 15.6671C15.5956 15.7386 15.5415 15.8209 15.5049 15.9088C14.5755 16.7427 13.347 17.25 12 17.25C9.10051 17.25 6.75 14.8995 6.75 12ZM16.2133 17.2739C15.0585 18.1976 13.5938 18.75 12 18.75C8.27208 18.75 5.25 15.7279 5.25 12C5.25 8.27208 8.27208 5.25 12 5.25C15.7279 5.25 18.75 8.27208 18.75 12C18.75 13.5938 18.1976 15.0585 17.2739 16.2133L18.5304 17.4697C18.8233 17.7626 18.8233 18.2375 18.5304 18.5304C18.2375 18.8233 17.7626 18.8233 17.4697 18.5304L16.2133 17.2739Z"></path>
      </svg></span>
      <input data-cy="ts_pl_input" placeholder="English" class="ant-input" type="text" value="">
      </span></div>
  </div>
   <ul>
        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><a class="dropdown-item" href="<?php echo e(url('teachers', $language['name'])); ?>"><?php echo e($language['name']); ?></a> </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <!--<li> <a class="dropdown-item" href="#">English</a> </li>-->
   <!--<li> <a class="dropdown-item" href="#">Chinese (Mandarin)</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">French</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">English</a> </li>-->
   <!--<li> <a class="dropdown-item" href="#">Chinese (Mandarin)</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">French</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">English</a> </li>-->
   <!--<li> <a class="dropdown-item" href="#">Chinese (Mandarin)</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">French</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">English</a> </li>-->
   <!--<li> <a class="dropdown-item" href="#">Chinese (Mandarin)</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">French</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">English</a> </li>-->
   <!--<li> <a class="dropdown-item" href="#">Chinese (Mandarin)</a></li>-->
   <!--<li> <a class="dropdown-item" href="#">French</a></li>-->
    
    </ul>
  </div>
</div> 
      
      </div>
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
           <a href="<?php echo e(route('teacher-search',['language'=>$values_one->title])); ?>"><?php echo e($values_one->title); ?></a>
           </figure>
                    
         </div>
       </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
         
         
     </div>
     <div class="row">
    
  </div>
  </div>
</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/tokatifc/public_html/resources/views/home/homepage.blade.php ENDPATH**/ ?>
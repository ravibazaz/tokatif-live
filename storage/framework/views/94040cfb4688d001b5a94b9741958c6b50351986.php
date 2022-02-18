<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php 

    $getLoggedIndata = getLoggedinData();

    $getVisitorCountry = getVisitorCountry();

?>





<section class="messages-section">

 <div class="container">

	<div class="row">

	  <div class="col-lg-3 col-md-3 col-sm-12 col-12">

       
       
       <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
        
      </div>

	  <div class="col-md-9 col-md-9 col-sm-6 col-12">
         <div class="my-wallet">

           <div class="row"> 

           <div class="col-lg-6 col-12"><h3>Teacher Wallet</h3></div>

           <div class="col-lg-6 col-12 text-right"><!--<a href="#" class="bye-credite">Buy Credits</a>--></div>

          </div>

           <div class="row">

           <div class="col-lg-4 col-12">

             <div class="avaliable-box">

               <h4>$<?php echo e(number_format($getLoggedIndata->teacher_wallet_amount,2)); ?> USD</h4>

                <p>Available Balance <i class="fa fa-question-circle" aria-hidden="true"></i></p>

             </div>

           </div>

           <div class="col-lg-4 col-12 pl-0">

             <div class="avaliable-box total-blans">

               <h4>$<?php echo e(number_format($getLoggedIndata->teacher_wallet_amount,2)); ?> USD</h4>

                <p>Total Balance <i class="fa fa-question-circle" aria-hidden="true"></i></p>

             </div>

           </div>

           <div class="col-lg-4 col-12 pl-0">

            <div class="avaliable-box unavailable-box">

               <h4>$00.00 USD</h4>

                <p>Unavailable Pending <i class="fa fa-question-circle" aria-hidden="true"></i></p>

             </div>

           </div>

         </div>

          <p class="pt-4">The amounts listed here are close approaximations. 

             There may be a slight difference due to changes in foreign exachange rate. All amounts are based on US Dollars.</p>

        </div>
      </div>
      
      <!--<div class="col-lg-3 col-md-3 col-sm-12 col-12">
       <div class="gift-card-left">

           <h3>Tokatif Gift Cards</h3>

           <h5>Give the gift of language</h5>

           <a href="#">Buy Now</a>

           <h4>Redeem a Gift Card</h4>

           <p>To redeem your Gift Card, simply copy and paste the code into the box below and submit.</p>

           <form>

             <div class="form-group gift-code clearfix">

                  <input type="email" name="email" value="" placeholder="Please enter your code" required>

                  <button type="submit" class="gift-btn"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>

                </div>

           </form>

       </div>
       </div>-->

	</div>

  </div>

</section>







<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>











<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/my-wallet.blade.php ENDPATH**/ ?>
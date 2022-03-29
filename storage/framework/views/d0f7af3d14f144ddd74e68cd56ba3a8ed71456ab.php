<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php
 $websitedata = getwebsite_data();
 $getLoggedIndata = getLoggedinData();
?>



<style>
a.disabled {
  pointer-events: none;
  cursor: default;
}
</style>

<!--latest html-->
<section class="signin-section">
<div class="container">
   <div class="container login-container">
            <div class="row">
            
            <div class="col-md-6 login-form-2 m-auto">
              <div class="single-signup">
                    <ul class="tab-group">
                        <li class="tab active"><a data-toggle="tab" href="#tabs-2" role="tab">Email</a></li>
                        <li class="tab"><a data-toggle="tab" href="#tabs-1" role="tab">Phone</a></li>
                    </ul>
                    <hr/>
                    
                    <div class="tab-content">
                    
                        <div class="tab-pane active" id="tabs-2" role="tabpanel">
                        <form id="register_form_submit" action="<?php echo e(route('register-user')); ?>">
                         <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="text" class="form-control" id="user_name" placeholder="Name" value="" autocomplete="off">
                        </div>
                        <div class="form-group verification-code">
                         <input type="email" class="form-control" id="user_email" placeholder="Email" value="" autocomplete="off" >
                         <a href="javascript:void(0);" onclick="sendcode_mail();">Send Code</a>
                        </div>
                        
                        <div class="form-group verification-code">
                            <input type="text" class="form-control" id="verificationcode" placeholder="Verification Code" value="" autocomplete="off">
                            <a href="javascript:void(0);" onclick="verify_code();" id="code_received_email" class="disabled">Verify</a>
                        </div>

                        <p id="message_code"></p>

                        <div class="form-group">
                         <input type="password" name="signupcpassword" id="user_password" class="form-control"   placeholder="Password" autocomplete="off">
                        </div>
                         
                         <div class="form-group">
                          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Your Confirm Password *" autocomplete="off" >
                         </div>
                        
                         
                        <span id="error_message"></span>
                         
                         <br>
                         
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Sign Up" />
                        </div>
                        <div class="form-group">
                           <p>Already have an account? <a href="<?php echo e(route('login')); ?>">Log in</a></p>
                        </div>
                  
                        <div class="bts">
                          <a href="<?php echo e($websitedata[0]->facebook_link); ?>" class="fblogin social"><i class="fa fa-facebook"></i></a>
                           <a href="<?php echo e($websitedata[0]->twitter_link); ?>" class="twlogin social"><i class="fa fa-twitter"></i></a>
                          <!--<a href="#" class="gplogin social"><i class="fa fa-google-plus"></i></a>
                          <a href="#" class="alogin social"><i class="fa fa-apple" aria-hidden="true"></i></a>  -->            
                        </div>
                        
                        
						<p><small>By logging in or creating an account, you agree to Tokatif's<br/> 
						<a href="<?php echo e(route('terms')); ?>">Terms of Service</a> and  
						<a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy.</a></small></p>
                    </form>
                    </div>
                    
                        <div class="tab-pane" id="tabs-1" role="tabpanel">
                        <form  id="register_form_submit_phone" action="<?php echo e(route('register-user-phone')); ?>">
                    <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <input type="text" class="form-control" id="user_name_phone" placeholder="Name" value="" />
                        </div>
                        <div class="form-group row">
                        <div class="col-3 pr-0">
                           <select class="form-control" id="country_code">
                              <option>+61 </option>
                              <option>+62 </option>
                              <option>+63 </option>
                              <option>+64 </option>
                              <option>+65 </option>
                            </select>
                          </div>
                          <div class="col-9">
                           <div class="verification-code">
                            <input type="text" name="signupphone" id="phone_number" class="form-control" placeholder="Phone">
                            <a href="javascript:void(0);" onclick="sendcode_phone();">Send Code</a>
                            </div>
                          </div>
                        </div>

                        <p id="error_message_phone_verify"></p>
                        <div class="form-group verification-code">
                            <input type="text" class="form-control" id="verification_code_phone" placeholder="Verification Code" value="" />
                            <a href="javascript:void(0);" onclick="verify_code_phone();" id="code_received_phn" class="disabled">Verify Code</a>
                        </div>
                        <p id="message_code_phone"></p>
                        <div class="form-group">
                         <input type="password" name="signupcpassword" id="user_password_phone" class="form-control"  placeholder="Password">
                        </div>
                        
                        <div class="form-group">
                          <input type="password" class="form-control" name="confirm_password" id="confirm_password_phone" placeholder="Your Confirm Password *" autocomplete="off" >
                         </div>
                        
                        
                         <span id="error_message_phone"></span> 
                         <br>
                        
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Sign Up" />
                        </div>
                        <div class="form-group">
                           <p>Already have an account? <a href="<?php echo e(route('login')); ?>">Log in</a></p>
                        </div>
                  
                        <div class="bts">
                            <a href="<?php echo e($websitedata[0]->facebook_link); ?>" class="fblogin social"><i class="fa fa-facebook"></i></a>
                           <a href="<?php echo e($websitedata[0]->twitter_link); ?>" class="twlogin social"><i class="fa fa-twitter"></i></a>
                        </div>
                        
                        
						<p><small>By logging in or creating an account, you agree to Tokatif's<br/> 
						<a href="<?php echo e(route('terms')); ?>">Terms of Service</a> and  
						<a href="<?php echo e(route('privacy-policy')); ?>">Privacy Policy.</a></small></p>
                    </form>
                    </div>
                   
                    
                    </div> 
                   
                  </div>  
                </div>
            </div>
        </div>
  </div>
</section>





<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script>
$('#inputDate').datepicker({});

$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});

</script>
<?php /**PATH /home/tokatifc/public_html/resources/views/user/register.blade.php ENDPATH**/ ?>
<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<section class="signin-section">
<div class="container">
   <div class="container login-container">
            <div class="row">

                <div class="col-md-6 login-form-1 m-auto">
                    
                      <?php if(Session::get('success')): ?>
                      <div class="alert alert-success alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo e(Session::get('success')); ?></div>
                      <?php endif; ?>
                      <?php if(Session::get('error')): ?>
                      <div class="alert alert-danger alert-dismissible fade show">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Note!</strong> <?php echo e(Session::get('error')); ?></div>
                      <?php endif; ?>
              
                    <h3>Log In</h3>
                       
                       <form action="<?php echo e(route('post-login-data')); ?>" method="POST">
                       <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label>Email Id / Phone Number</label>
                            <input type="text" name="username" class="form-control" placeholder="Your Email / Phone Number *" value="" />
                            <?php if($errors->has('username')): ?>
                                <span class="text-danger"><?php echo e($errors->first('username')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Your Password *" value="" />
                            <?php if($errors->has('password')): ?>
                                <span class="text-danger"><?php echo e($errors->first('password')); ?></span>
                            <?php endif; ?>
                        </div>

                                          
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                        </form>
                        
                        
                        <div class="form-group">
                            <a href="<?php echo e(route('forgot-password')); ?>" class="btnForgetPwd">Forgot Your Password?</a>
                        </div> 
                        <div class="form-group you-dont">
                            Don't have an account! <a href="<?php echo e(route('create-account')); ?>" class="btnForgetPwd">Sign Up Here </a>
                        </div> 
                         
                         
                </div>
            </div>
        </div>
    </div>
</section>




<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH /home/tokatifc/public_html/resources/views/user/login.blade.php ENDPATH**/ ?>
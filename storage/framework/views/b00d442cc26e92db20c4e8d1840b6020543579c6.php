<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<section class="signin-section">
    <div class="container">
        <div class="login-container">
            <div class="card login-form">
            	<div class="card-body">
            		<h3 class="card-title text-center">Forgot your password?</h3>
            		
            		<!--Password must contain one lowercase letter, one number, and be at least 7 characters long.-->
            		
            		<div class="card-text">
            		    
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
                          
            			<form action="<?php echo e(route('post-forgot-password-data')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
            				<!--<div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                              <a class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </a>
                            </div>-->
            				<div class="form-group">
            					<label for="exampleInputEmail1">Email</label>
            					<input type="email" name="email" class="form-control form-control-sm">
            					<?php if($errors->has('email')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                                <?php endif; ?>
            				</div>
            				<button type="submit" class="btn btn-primary btn-block submit-btn">Confirm</button>
            			</form>
            		</div>
            	</div>
            </div>     
        </div>
    </div>
</section>



<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<?php /**PATH /home/tokatifc/public_html/resources/views/user/forgot-password.blade.php ENDPATH**/ ?>
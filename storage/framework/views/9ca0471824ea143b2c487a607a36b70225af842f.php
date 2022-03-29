<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<section class="signin-section">
    <div class="container">
        <div class="login-container">
            <div class="card login-form">
            	<div class="card-body">
            		<h3 class="card-title text-center">Reset your password</h3>
            		
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
                          
                          
            			<form action="<?php echo e(url('reset-password/'.$q)); ?>" method="POST"> 
                            <?php echo csrf_field(); ?>
            				<input type="hidden" name="u_id" value="<?php echo e($id); ?>" />
                            <input type="hidden" name="u_token" value="<?php echo e($q); ?>" />
            				<div class="form-group">
            					<label for="">New Password</label>
            					<input type="password" name="npassword" value="<?php echo e(Request::old('npassword')); ?>" class="form-control form-control-sm">
            					<?php if($errors->has('npassword')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('npassword')); ?></span>
                                <?php endif; ?>
            				</div>
            				<div class="form-group">
            					<label for="">Retype Password</label>
            					<input type="password" name="rpassword" value="<?php echo e(Request::old('rpassword')); ?>" class="form-control form-control-sm">
            					<?php if($errors->has('rpassword')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('rpassword')); ?></span>
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

<?php /**PATH /home/tokatifc/public_html/resources/views/user/reset-password.blade.php ENDPATH**/ ?>
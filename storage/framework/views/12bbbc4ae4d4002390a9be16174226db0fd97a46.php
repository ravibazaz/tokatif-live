
<!-- Content Header (Page header) -->
<?php $__env->startSection('content'); ?>
    


<div class="login-box">
 <?php echo $__env->make('admin.includes.auth_logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
    <?php if(Session::get('error')): ?>
    <div class="alert alert-danger"><?php echo e(Session::get('error')); ?></div>
    <?php endif; ?>
     <?php if(Session::get('success')): ?>
    <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
    <?php endif; ?>
    <form action="<?php echo e(URL::route('admin-login')); ?>" method="post">
      <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
         
        </div>
        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="alert alert-danger"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="alert alert-danger"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="row">
          <div class="col-8">
            <!-- <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div> -->
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="<?php echo e(route('admin-forgot-password')); ?>">I forgot my password</a>
      </p> 
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <?php echo $__env->make('admin.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="hold-transition login-page">

    <!-- Content Header (Page header) -->
   <?php echo $__env->yieldContent('content'); ?>
  

<?php echo $__env->make('admin.includes.lib', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /home/tokatifc/staging.tokatif.com/resources/views/admin/layouts/auth.blade.php ENDPATH**/ ?>
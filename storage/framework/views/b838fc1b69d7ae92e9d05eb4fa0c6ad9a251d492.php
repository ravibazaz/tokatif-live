<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <?php echo $__env->make('admin.includes.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php echo $__env->make('admin.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php echo $__env->make('admin.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <?php echo $__env->yieldContent('content'); ?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <?php echo $__env->make('admin.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </footer>

  
</div>
<!-- ./wrapper -->

<?php echo $__env->make('admin.includes.lib', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>
<script>
var baseUrl = "<?php echo url('/admin'); ?>"
</script>
</body>
</html>
<?php /**PATH /home/tokatifc/public_html/resources/views/admin/layouts/default.blade.php ENDPATH**/ ?>
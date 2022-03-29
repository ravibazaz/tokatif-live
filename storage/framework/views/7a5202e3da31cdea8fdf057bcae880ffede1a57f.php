
<?php $__env->startSection('content'); ?>
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php echo e($title); ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <?php echo $__env->make('admin.includes.breadcrumb',['breadcrumb'=>$breadcrumb], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <section class="content">
    <div class="row">
        <div class="col-12">
          
          <?php if(Session::get('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo e(Session::get('success')); ?>

          </div>
          <?php endif; ?>
          <?php if(Session::get('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Note!</strong> <?php echo e(Session::get('error')); ?>

          </div>
          <?php endif; ?>

          <div class="card">
            <div class="card-header">
               <!-- <div class="row">
                <div class="col-md-12">
                  <?php if($errors->any()): ?>
                      <div class="alert alert-danger">
                          <ul>
                              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <li><?php echo e($message); ?></li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                      </div>
                  <?php endif; ?>
                </div>
              </div> -->
            </div>
            
            <!-- /.card-header -->
            <div class="card-body">

              <form action="<?php echo e(url('admin/privacy/'.$privacy->id)); ?>" method="POST" enctype="multipart/form-data">
              <?php echo e(csrf_field()); ?>


              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Title</label>
                  <input type="text" name="title" value="<?php echo e($privacy->title); ?>" class="form-control" placeholder="">
                  <?php if($errors->has('title')): ?>
                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Description</label>
                  <textarea name="description" class="form-control" rows="6" placeholder=""><?php echo e($privacy->description); ?></textarea>
                  <?php if($errors->has('description')): ?>
                    <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                  <?php endif; ?>
                </div>

              </div>


              <div class="form-group">
                <br><button type="submit" class="btn btn-primary">Submit</button>
              </div>

              </form>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/privacy/edit.blade.php ENDPATH**/ ?>
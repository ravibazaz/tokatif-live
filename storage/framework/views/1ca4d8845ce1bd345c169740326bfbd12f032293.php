
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
          

          <div class="card">
            <div class="card-header">
               <div class="row">
                <div class="col-md-5 mb-5">
                   <div class="input-group md-form form-sm form-2 pl-0">
                    <h3 class="card-title"><?php echo e($title); ?></h3>
                  </div>
                </div>

                <div class="col-md-5 mb-5">
                  
                </div>

                <div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <a href="<?php echo e(route('admin-support-add')); ?>" class="btn btn-primary"> Add  </a>
                  </div>
                </div>


              </div>
            </div>
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
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $support; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php 
                    $exists = file_exists( storage_path() . '/app/support/' . $a->image );
                  ?> 
                    
                <tr>
                  <td><?php echo e($a->id); ?></td>
                  <td><?php echo e($a->title); ?></td>
                  <td>
                    <?php if($exists && $a->image!=''): ?> 
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/support/'.$a->image)); ?> style="width: 100px;" alt="user image">
                    <?php else: ?>
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/noimage.jpg')); ?> style="width: 100px;" alt="user image">   
                    <?php endif; ?>
                  </td>
                  <td>
                    <a href="<?php echo e(route('admin-support-edit',['id'=>$a->id])); ?>" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>
                    <a href="<?php echo e(route('admin-support-delete',['id'=>$a->id])); ?>" onclick="return confirm('Are you sure?')" class="actionLink"><i class="fa fa-trash"></i></a> 
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                </tbody>
               
              </table>
              <?php echo e($support->links()); ?>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/support/list.blade.php ENDPATH**/ ?>
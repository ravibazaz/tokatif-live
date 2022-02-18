
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

                <!--<div class="col-md-5 mb-5">
                  <form action="<?php echo e(route('admin-teacher-search')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search" aria-label="Search" name="q" value=<?php echo e(app('request')->input('q')); ?>>
                    <div class="input-group-append">
                      <button class="btn input-group-text amber lighten-3"><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                      <span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                          aria-hidden="true"></i></span>
                    </div>
                  </div>
                  </form>
                </div>-->

                <!--<div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <a href="" class="btn btn-primary"> Add Customer </a>
                  </div>
                </div>-->


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
                  <th>Logo</th>
                  <th>Social Links</th>
                  <th>Copyright</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $website_setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  <?php 
                    $exists = file_exists( storage_path() . '/app/imagesdoc/' . $a->logo );
                  ?> 
                
                <tr>
                  <td><?php echo e($a->id); ?></td>
                  <td>
                    <?php if($exists && $a->logo!=''): ?> 
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/imagesdoc/'.$a->logo)); ?> style="width: 100px;" alt="user image">
                    <?php else: ?>
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/noimage.jpg')); ?> style="width: 100px;" alt="user image">   
                    <?php endif; ?>
                  </td>
                  <td>
                      <b>Facebook:</b> <?php echo e($a->facebook_link); ?> <br>
                      <b>Linkedin:</b> <?php echo e($a->linkedin_link); ?> <br>
                      <b>Twitter:</b> <?php echo e($a->twitter_link); ?> <br>
                      <b>Pininterest:</b> <?php echo e($a->pininterest_link); ?> <br>
                  </td>
                  <td><?php echo e($a->copyright_content); ?></td>
                  <td>
                    <a href="<?php echo e(route('admin-website-setting-edit',['id'=>$a->id])); ?>" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                </tbody>
               
              </table>
              <?php echo e($website_setting->links()); ?>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/website_setting/list.blade.php ENDPATH**/ ?>

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
                  <form action="<?php echo e(route('admin-teacher-search')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 amber-border" type="text" placeholder="Search" aria-label="Search" name="q" value=<?php echo e(app('request')->input('q')); ?>>
                    <div class="input-group-append">
                      <button class="btn input-group-text amber lighten-3"><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                      <!-- <span class="input-group-text amber lighten-3" id="basic-text1"><i class="fas fa-search text-grey"
                          aria-hidden="true"></i></span> -->
                    </div>
                  </div>
                  </form>
                </div>

                <div class="col-md-2 mb-2">
                  <div class="input-group md-form form-sm form-2 pl-0">
                    <!--<a href="" class="btn btn-primary"> Add </a>-->
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
                  <th>Teacher Type</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone </th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($a->id); ?></td>
                  <td><?php echo e($a->teacher_type); ?></td>
                  <td><?php echo e($a->name); ?></td>
                  <td><?php echo e($a->email); ?></td>
                  <td><?php echo e($a->phone_number); ?></td>
                  <td><?php echo e($a->address); ?></td>
                  <td>
                     <?php if($a->status=='0'): ?>
                     <a href="<?php echo e(route('admin-teacher-approve',['id'=>$a->id])); ?>" onclick="return confirm('Are you sure?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> 
                     <?php endif; ?>
                     
                    <a href="<?php echo e(route('admin-teacher-details',['id'=>$a->id])); ?>" class="actionLink" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a>
                    <a href="<?php echo e(route('admin-teacher-delete',['id'=>$a->id])); ?>" onclick="return confirm('Are you sure?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a> 
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                </tbody>
               
              </table>
              <?php echo e($teachers->links()); ?>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/teachers/list.blade.php ENDPATH**/ ?>
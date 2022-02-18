
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
                    <!--<a href="<?php echo e(route('admin-article-add')); ?>" class="btn btn-primary"> Add  </a>-->
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
                  <th width="10%">Id</th>
                  <th width="15%">Title</th>
                  <th width="20%">Description</th>
                  <th width="10%">Added By</th>
                  <th width="20%">Image</th>
                  <th width="10%">Status</th>
                  <th width="15%">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php 
                    $exists = file_exists( storage_path() . '/app/article/' . $a->photo );
                    
                    $addedByData = DB::table('registrations')->where('id', $a->added_by)->first();
                  ?> 
                    
                <tr>
                  <td><?php echo e($a->id); ?></td>
                  <td><?php echo e($a->title); ?></td> 
                  <td><?php echo e($a->description); ?></td>
                  <td><?php echo e($addedByData->name); ?></td>
                  <td>
                    <?php if($exists && $a->photo!=''): ?> 
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/article/'.$a->photo)); ?> style="width: 100px;" alt="photo">
                    <?php else: ?>
                    <img class="img-bordered-sm" src=<?php echo e(url('storage/app/noimage.jpg')); ?> style="width: 100px;" alt="photo">   
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if($a->status=='1'): ?> 
                        <?php $status = 'Approved'; ?>
                    <?php elseif($a->status=='2'): ?> 
                        <?php $status = 'New'; ?>
                    <?php else: ?>
                        <?php $status = 'Rejected'; ?>
                    <?php endif; ?>
                    
                    <?php echo e($status); ?>

                  </td>
                  <td>
                    <!--<a href="<?php echo e(route('admin-article-edit',['id'=>$a->id])); ?>" class="actionLink"><i class="fa fa-pencil-square-o"></i></a>-->
                    <?php if($a->status=='2'): ?> 
                    <a href="<?php echo e(route('admin-article-approve',['id'=>$a->id])); ?>" onclick="return confirm('Do you want to approve this article?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Approve"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a> 
                    <a href="<?php echo e(route('admin-article-reject',['id'=>$a->id])); ?>" onclick="return confirm('Do you want to reject this article?')" class="actionLink" data-toggle="tooltip" data-placement="top" title="Reject"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a> 
                    <?php endif; ?>
                    <a href="<?php echo e(route('admin-article-delete',['id'=>$a->id])); ?>" onclick="return confirm('Are you sure?')" class="actionLink"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></a> 
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
                </tbody>
               
              </table>
              <?php echo e($article->links()); ?>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/community/article/list.blade.php ENDPATH**/ ?>
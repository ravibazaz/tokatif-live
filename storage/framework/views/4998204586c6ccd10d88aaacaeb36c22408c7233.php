
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

              <form action="<?php echo e(url('admin/website-setting/'.$website_setting->id)); ?>" method="POST" enctype="multipart/form-data">
              <?php echo e(csrf_field()); ?>


              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Name</label>
                  <input type="text" name="website" value="<?php echo e($website_setting->website); ?>" class="form-control" placeholder="">
                  <?php if($errors->has('website')): ?>
                    <span class="text-danger"><?php echo e($errors->first('website')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Logo</label>
                  <input type="hidden" name="earlier_logo" value="<?php echo e($website_setting->logo); ?>" />  
                  <input type="file" name="logo" class="form-control" placeholder="">
                  <img src="<?php echo e(url('')); ?>/storage/app/imagesdoc/<?php echo e($website_setting->logo); ?>" width="200" />
                  
                  <?php if($errors->has('logo')): ?>
                    <span class="text-danger"><?php echo e($errors->first('logo')); ?></span>
                  <?php endif; ?>
                </div>
              </div>



              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Footer Logo</label>
                  <input type="file" name="footer_logo" class="form-control" placeholder="">
                  <input type="hidden" name="earlier_footer_logo" value="<?php echo e($website_setting->footer_logo); ?>" /> 
                  <img src="<?php echo e(url('')); ?>/storage/app/imagesdoc/<?php echo e($website_setting->footer_logo); ?>" width="200" />
                  
                  <?php if($errors->has('footer_logo')): ?>
                    <span class="text-danger"><?php echo e($errors->first('footer_logo')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputEmail4">Website Favicon</label>
                  <input type="file" name="favicon" class="form-control" placeholder="">
                  <input type="hidden" name="earlier_favicon" value="<?php echo e($website_setting->favicon); ?>" /> 
                  <img src="<?php echo e(url('')); ?>/storage/app/<?php echo e($website_setting->favicon); ?>" width="60" />
                  
                  <?php if($errors->has('favicon')): ?>
                    <span class="text-danger"><?php echo e($errors->first('favicon')); ?></span>
                  <?php endif; ?>
                </div>
              </div>
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Facebook Link</label>
                  <input type="text" class="form-control" name="facebook_link" id="facebook_link" value="<?php echo e($website_setting->facebook_link); ?>" >
                  <?php if($errors->has('facebook_link')): ?>
                    <span class="text-danger"><?php echo e($errors->first('facebook_link')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Linkedin Link</label>
                  <input type="text" class="form-control" name="linkedin_link" id="linkedin_link" value="<?php echo e($website_setting->linkedin_link); ?>" >
                  <?php if($errors->has('linkedin_link')): ?>
                    <span class="text-danger"><?php echo e($errors->first('linkedin_link')); ?></span>
                  <?php endif; ?>
                </div>
              </div>
              
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Twitter Link</label>
                  <input type="text" class="form-control" name="twitter_link" id="twitter_link" value="<?php echo e($website_setting->twitter_link); ?>" >
                  <?php if($errors->has('facebook_link')): ?>
                    <span class="text-danger"><?php echo e($errors->first('twitter_link')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Pininterest Link</label>
                  <input type="text" class="form-control" name="pininterest_link" id="pininterest_link" value="<?php echo e($website_setting->pininterest_link); ?>" >
                  <?php if($errors->has('pininterest_link')): ?>
                    <span class="text-danger"><?php echo e($errors->first('pininterest_link')); ?></span>
                  <?php endif; ?>
                </div>
              </div>
              
              
              
              
              
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputCity">Copyright Content</label>
                  <textarea class="form-control" name="copyright_content" id="copyright_content"><?php echo e($website_setting->copyright_content); ?></textarea>
                  <?php if($errors->has('copyright_content')): ?>
                    <span class="text-danger"><?php echo e($errors->first('copyright_content')); ?></span>
                  <?php endif; ?>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputZip">Footer Content Below Logo</label>
                  <textarea class="form-control" name="footer_content" id="footer_content"><?php echo e($website_setting->footer_content); ?></textarea>
                  <?php if($errors->has('footer_content')): ?>
                    <span class="text-danger"><?php echo e($errors->first('footer_content')); ?></span>
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
<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/tokatifc/public_html/resources/views/admin/website_setting/edit.blade.php ENDPATH**/ ?>
<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php if(session('id')!='' && session('role')=='1'): ?>

    <?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php elseif(session('id')!='' && session('role')=='2'): ?>

    <?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php else: ?>

    <?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php endif; ?>



<?php

 $getLoggedIndata = getLoggedinData();

 $getVisitorCountry = getVisitorCountry();

?>







<section class="article-list article-add-page">

<div class="container">

  <div class="row">

  <div class="col-lg-3 col-md-3 col-sm-12 col-12">
      <?php echo $__env->make('include/teacher-left-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     </div>

     <div class="col-lg-6 col-md-6 col-sm-12 col-12">

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

          

      

        <form role="form" action="<?php echo e(route('post-community-data')); ?>" method="POST" enctype="multipart/form-data" > 

        <?php echo e(csrf_field()); ?>


        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />

        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />

                

        <div class="form-row">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Post Type *</label>

                <select class="custom-select mr-sm-2" name="post_type" id="post_type">

                    <option value="">Please Choose</option>

                    <option value="article" <?php echo e((Request::old('post_type') == 'article') ? 'selected' : ''); ?>>Article</option>

                    <option value="forum" <?php echo e((Request::old('post_type') == 'forum') ? 'selected' : ''); ?>>Forum</option>

                </select>

                <?php if($errors->has('post_type')): ?>

                    <span class="text-danger"><?php echo e($errors->first('post_type')); ?></span> 

                <?php endif; ?>

            </div>            

        </div>

        

        <div class="form-row" id="ForumTopicDiv">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Forum Topic</label>

                <select class="custom-select mr-sm-2" name="forum_topic" id="forum_topic">

                    <!--<option value="">Please Choose</option>-->

                    <option value="lets_discuss" <?php echo e((Request::old('forum_topic') == 'lets_discuss') ? 'selected' : ''); ?>>Let’s Discuss</option>

                    <option value="ask_a_question" <?php echo e((Request::old('forum_topic') == 'ask_a_question') ? 'selected' : ''); ?>>Ask A Question</option>

                    <option value="check_my_work" <?php echo e((Request::old('forum_topic') == 'check_my_work') ? 'selected' : ''); ?>>Check My Work</option>

                    <option value="share_resources" <?php echo e((Request::old('forum_topic') == 'share_resources') ? 'selected' : ''); ?>>Share Resources</option>

                    <option value="find_a_language_exchange_partner" <?php echo e((Request::old('forum_topic') == 'find_a_language_exchange_partner') ? 'selected' : ''); ?>>Find A Language Exchange Partner</option>

                </select>

                <?php if($errors->has('forum_topic')): ?>

                    <span class="text-danger"><?php echo e($errors->first('forum_topic')); ?></span>

                <?php endif; ?>

            </div>            

        </div>



        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Title *</label>

                <input type="text" class="form-control" name="title" id="title" value="<?php echo e(Request::old('title')); ?>" placeholder="Enter Title of Article">

                <?php if($errors->has('title')): ?>

                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>

                <?php endif; ?>

            </div>

        </div>

        

        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <label for="inputEmail4">Description *</label>

                <textarea name="description" id="editor1" class="form-control" rows="5" cols="80"><?php echo e(Request::old('description')); ?></textarea> 

                <?php if($errors->has('description')): ?>

                    <span class="text-danger"><?php echo e($errors->first('description')); ?></span> 

                <?php endif; ?>

            </div>

        </div>

        

        <div class="form-row mt-3">

            <div class="col-md-12">

                <div class="impression-left">

                    <p>Click or Drage here to upload Photo *</p>

                    <input type="file" class="form-control-file" name="photo" id="community_photo" accept="image/*">

                    <span id="community_photo_frame"></span>

                    <?php if($errors->has('photo')): ?>

                        <span class="text-danger"><?php echo e($errors->first('photo')); ?></span>

                    <?php endif; ?>

                </div> 

            </div>

        </div>

      

        

        <div class="form-row mt-3">

            <div class="form-group col-lg-12">

                <button type="submit" class="btn btn-submit">Save</button> 

                <button type="submit" onClick="history.go(0);" class="cancel-btn">Cancel</button>

            </div>

        </div>                                             

        </form>

    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 col-12">

        <div class="some-god">

         <h3>Some Good Examples for Title</h3>

         <p>How to let this IELTS sentence be correct?</p>

         <p>Can someone explain the role of '하면' in this sentence?</p>

         <p>In English, what's the right way of saying "the middle-left/rig</p>

         <p>Is well turned out= neatly turned out?</p>

        </div>

    </div>

   </div>

  </div>

</section>





<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php /**PATH /home/tokatifc/public_html/resources/views/community/add.blade.php ENDPATH**/ ?>
<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/student-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
?>

<section class="teacher-contain student-profile-edit">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-8 col-sm-12 col-12">
        <div class="container">
          <div class="row">
            <div class="col-md-3 mb-3">
             <div class="basic-box">
              <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                <li class="nav-item"> 
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                    <img src="<?php echo e(asset('public/frontendassets/images/basic.png')); ?>" class="normal"> 
                    <img src="<?php echo e(asset('public/frontendassets/images/basic-hover.png')); ?>" class="hover-on"> Basic Information</a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images//languages.png')); ?>" class="normal"/>  
                    <img src="<?php echo e(asset('public/frontendassets/images//languages-hover.png')); ?>" class="hover-on"/> Languages</a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/communition.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/communition-hover.png')); ?>" class="hover-on"/> Communication Tool</a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" id="Introduction-tab" data-toggle="tab" href="#Introduction" role="tab" aria-controls="Introduction" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/introduation.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/introduation-hover.png')); ?>" class="hover-on"/> Introduction</a> 
                </li>
              </ul>
              </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-9">
             <div class="tab-section">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active edit-p-tab1" id="home" role="tabpanel" aria-labelledby="home-tab">
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
                  
                  <?php if($errors->any()): ?>
                  <div class="alert alert-danger">
                      <ul>
                          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li><?php echo e($message); ?></li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                  </div>
                  <?php endif; ?>
                  
                                      
                   <h2>Basic Information</h2>
                   <div class="information-section">
                    <form role="form" action="<?php echo e(route('basic-info-update')); ?>" method="POST" enctype="multipart/form-data" > 
                    <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                     <div class="form-row"> 
                      <div class="form-group col-md-3" id="view_uploaded_photo"> 
                        <?php 
                            $exists = file_exists( storage_path() . '/app/user_photo/' . $getLoggedIndata->profile_photo );
                        ?> 
                        
                        <?php if($exists && $getLoggedIndata->profile_photo!=''): ?> 
                          <img src=<?php echo e(url('storage/app/user_photo/'.$getLoggedIndata->profile_photo)); ?> class="img-fluid">
                        <?php else: ?>
                          <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                        <?php endif; ?>
                
                        <!--<img src="<?php echo e(asset('public/frontendassets/images/lady.png')); ?>" class="img-fluid">-->
                      </div>
                      <div class="col-md-9">
                      <p> At least 500x500 pixels JPG, PNG and BMP formats only Maximum size of 2MB Complete requirements list</p>
                      
                      <div class="upload-btn-wrapper">
                          <button class="btn">Change Photo</button>
                          <input type="file" name="my_profile_photo" id="my_profile_photo" accept="image/*" >
                          <input type="hidden" name="earlier_img" value="<?php echo e($getLoggedIndata->profile_photo); ?>" />
                        </div>
                      </div>
                      </div>
                      
                      <div class="form-row">
                        <div class="form-group col-lg-12">
                          <label for="inputEmail4">Display Name</label>
                          <input type="text" class="form-control" name="display_name" value="<?php echo e($getLoggedIndata->name); ?>" placeholder="">
                          <?php if($errors->has('display_name')): ?>
                            <span class="text-danger"><?php echo e($errors->first('display_name')); ?></span>
                          <?php endif; ?>
                        </div>
                        
                      </div>
                      
                      
                      <div class="form-row mt-3"> 
                       <div class="form-group col-md-6 calender-icon">
                          <label for="inputEmail4">Birthday <?php echo e($getLoggedIndata->dob); ?></label>
                           <input type="date" class="form-control" name="dob" value="<?php echo e($getLoggedIndata->dob ? date('Y-m-d', strtotime($getLoggedIndata->dob)) : ''); ?>">
                           
                           <!--<i class="fa fa-calendar" aria-hidden="true"></i>-->
                            <?php if($errors->has('dob')): ?>
                                <span class="text-danger"><?php echo e($errors->first('dob')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Gender</label>
                           <ul class="radio-btn">
                              <li>
                                <input type="radio" id="f-option" name="gender" value="Male" <?php echo e(($getLoggedIndata->gender == 'Male') ? 'checked=checked' : ''); ?>>
                                <label for="f-option"><i class="fa fa-male" aria-hidden="true"></i> Male</label>             
                              </li>
                              
                              <li>
                                <input type="radio" id="s-option" name="gender" value="Female" <?php echo e(($getLoggedIndata->gender == 'Female') ? 'checked=checked' : ''); ?>>
                                <label for="s-option"><i class="fa fa-female" aria-hidden="true"></i> Female</label>                              
                              </li>
                              
                              <li>
                                <input type="radio" id="t-option" name="gender" value="Not Given" <?php echo e(($getLoggedIndata->gender == 'Not Given') ? 'checked=checked' : ''); ?>>
                                <label for="t-option"><img src="<?php echo e(asset('public/frontendassets/images/not-given.png')); ?>">Not Given</label> 
                              </li>
                            </ul>
                            <?php if($errors->has('gender')): ?>
                                <span class="text-danger"><?php echo e($errors->first('gender')); ?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Country of Origin</label>
                          <select class="custom-select mr-sm-2" name="country_of_origin">
                            <option value="">--Please select--</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($val->name); ?>" <?php echo e(($getLoggedIndata->country_of_origin == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                          </select>
                          
                          <?php if($errors->has('country_of_origin')): ?>
                            <span class="text-danger"><?php echo e($errors->first('country_of_origin')); ?></span>
                          <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Living in</label>
                          <select class="custom-select mr-sm-2" name="country_living_in">
                            <option value="">--Please select--</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($val->name); ?>" <?php echo e(($getLoggedIndata->country_living_in == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                          </select>
                          
                          <?php if($errors->has('country_living_in')): ?>
                            <span class="text-danger"><?php echo e($errors->first('country_living_in')); ?></span>
                          <?php endif; ?>
                        </div>
                      </div>
                      
                      
                      
                     <!--<div class="form-row mt-3"> 
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Video Conferencing Platform</label>
                            <select name="video_conferencing_platform" class="form-control custom-select">
                                <option value="">--Please select--</option>
                                <option value="skype" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'skype') ? 'selected' : ''); ?>>Skype ID</option> 
                                <option value="zoom" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'zoom') ? 'selected' : ''); ?>>Zoom Link</option>
                                <option value="other" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'other') ? 'selected' : ''); ?>>Other</option>
                            </select>
                            <?php if($errors->has('video_conferencing_platform')): ?>
                                <span class="text-danger"><?php echo e($errors->first('video_conferencing_platform')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">User Account ID</label>
                            <input type="text" name="user_account_id" id="user_account_id" value="<?php echo e($getLoggedIndata->user_account_id); ?>" class="form-control" placeholder=""/>
                            <?php if($errors->has('user_account_id')): ?>
                                <span class="text-danger"><?php echo e($errors->first('user_account_id')); ?></span>
                            <?php endif; ?>
                        </div>
                      </div>-->
                      
                      <div class="form-row mt-3"> 
                        <div class="form-group col-md-6">
                            <label for="inputEmail4"> Address </label>
                            <input type="text" name="address" value="<?php echo e($getLoggedIndata->address); ?>" class="form-control" placeholder="">
                            <?php if($errors->has('address')): ?>
                                <span class="text-danger"><?php echo e($errors->first('address')); ?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      
                      <button type="submit" class="btn btn-submit">Save</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <h2>Languages</h2>
                  <div class="information-section resume-certificate">
                    <form role="form" action="<?php echo e(route('languages-update')); ?>" method="POST" enctype="multipart/form-data" > 
                    <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                      
                      
                      
                      <div class="education-part">
                      <div class="form-row part-title align-items-center">
                         <div class="form-group col-md-12"><h3>Languages I know</h3></div>
                        </div> 
                      <div class="form-row part-title align-items-center">
                         <div class="form-group col-md-12"> <label for="inputEmail4">Native Language</label></div>
                        </div>
                      
                      <div class="form-row language-row align-items-center regLangDiv" id="reg-boxes-wrap">
                        <div style="display:flex;width:100%; margin:0 -15px;">
                            <div class="form-group col-md-6">
                              <select name="language[]" class="custom-select mr-sm-2">
                                <option value="">--Please select--</option>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('language') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                              </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                              <select name="lang_level[]" class="custom-select mr-sm-2">
                                <option value="">--Please select--</option>
                                <option value="Native">Native</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Elementary">Elementary</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Upper Intermediate">Upper Intermediate</option> 
                                <option value="Advanced">Advanced</option>
                                <option value="Proficient">Proficient</option>
                              </select>
                            </div>
                         
                            <div class="form-group col-md-2">
                                <div class="edite-delite remove-reg-lang-row">
                                   <a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </div>
                            </div> 
                        </div>    
                      </div>
                      
                      <div class="form-row mt-3"> 
                          <div class="form-group col-md-12">
                            <button type="button" id="langAppend" class="btn btn-addmore"><i class="fa fa-plus" aria-hidden="true"></i> Add More Languages</button> 
                          </div>
                      </div>
                      </div>
                      
                      
                      <div class="education-part">
                      <div class="form-row part-title align-items-center">
                         <div class="form-group col-md-12"><h3>Languages I Teach</h3></div>
                      </div>
                      <div class="form-row taughtLangDiv" id="taught-boxes-wrap">
                        <div style="display:flex;width:100%; margin:0 -15px;">
                           <div class="form-group col-md-9">
                              <label for="inputEmail4">Languages I Teach</label>
                              <select name="taught_lang[]" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                <option value="">--Please select--</option>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('language') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                              </select>
                            </div> 
                            <div class="form-group col-md-3">
                                <label for="">Delete</label>
                                <div class="input-group-text remove-taught-lang-row form-control"><i class="fa fa-trash-o" aria-hidden="true"></i></div>
                            </div>
                        </div>
                      </div>
                      <div class="form-row mt-3"> 
                          <div class="form-group col-md-12">
                            <button type="button" id="taughtAppend" class="btn btn-addmore"><i class="fa fa-plus" aria-hidden="true"></i> Add More Languages</button>
                          </div>
                      </div>
                         
                      </div>
                      
                      
                      
                      
                      <button type="submit" class="btn btn-submit">Save</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <h2>Communication Tool</h2>
                  <div class="information-section">
                    <form role="form" action="<?php echo e(route('communication-tool-update')); ?>" method="POST" enctype="multipart/form-data" > 
                    <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                      <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Preferred Video Conferencing Platform</label>
                            <select name="video_conferencing_platform" class="form-control custom-select">
                                <option value="">--Please select--</option>
                                <option value="skype" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'skype') ? 'selected' : ''); ?>>Skype ID</option> 
                                <option value="zoom" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'zoom') ? 'selected' : ''); ?>>Zoom Link</option>
                                <option value="other" <?php echo e(($getLoggedIndata->video_conferencing_platform == 'other') ? 'selected' : ''); ?>>Other</option>
                            </select>
                            <?php if($errors->has('video_conferencing_platform')): ?>
                                <span class="text-danger"><?php echo e($errors->first('video_conferencing_platform')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">User Account ID</label>
                            <input type="text" name="user_account_id" id="user_account_id" value="<?php echo e($getLoggedIndata->user_account_id); ?>" class="form-control" placeholder=""/>
                            <?php if($errors->has('user_account_id')): ?>
                                <span class="text-danger"><?php echo e($errors->first('user_account_id')); ?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                     <!--<div class="form-row mt-3"> 
                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-addmore"><i class="fa fa-plus" aria-hidden="true"></i> Add More Platform</button>
                      </div>
                      </div>-->
                      
                      <button type="submit" class="btn btn-submit">Save</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="Introduction" role="tabpanel" aria-labelledby="Introduction-tab">
                    <h2>Introduction</h2>
                    <div class="information-section">
                        <form role="form" action="<?php echo e(route('introduction-update')); ?>" method="POST" enctype="multipart/form-data" > 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4">About Me</label>
                                    <textarea name="about_me" rows="5" class="form-control"><?php echo e($getLoggedIndata->about_me); ?></textarea>
                                    <?php if($errors->has('about_me')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('about_me')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <!--<div class="form-group col-md-12">
                                    <label for="inputEmail4">About My Lessons</label>
                                    <textarea name="about_my_lessons" rows="5" class="form-control"><?php echo e($getLoggedIndata->about_my_lessons); ?></textarea>
                                    <?php if($errors->has('about_my_lessons')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('about_my_lessons')); ?></span>
                                    <?php endif; ?>
                                </div>-->
                            </div>
                      
                            <button type="submit" class="btn btn-submit">Save</button>
                        </form>
                    </div>
                </div>
              </div>
            </div>
            </div>
            <!-- /.col-md-8 --> 
          </div>
        </div>
        <!-- /.container --> 
      </div>
    </div>
  </div>
</section>


<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php /**PATH /home/tokatifc/public_html/resources/views/student/edit-profile.blade.php ENDPATH**/ ?>
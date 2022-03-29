<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                <li class="nav-item"> 
                    <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/video-gallery1.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/video-gallery2.png')); ?>" class="hover-on"/> Video </a> 
                </li>
                <li class="nav-item"> 
                    <a class="nav-link" id="resume-tab" data-toggle="tab" href="#resume" role="tab" aria-controls="resume" aria-selected="false"> 
                    <img src="<?php echo e(asset('public/frontendassets/images/introduation.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/introduation-hover.png')); ?>" class="hover-on"/> Resume & Certificates </a> 
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
                    <form role="form" action="<?php echo e(route('teacher-basic-info-update')); ?>" method="POST" enctype="multipart/form-data" > 
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
                          <label for="inputEmail4">Birthday </label>
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
                      
                      
                      
                     
                      
                      <div class="form-row mt-3"> 
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Teacher Type</label>
                          <select class="custom-select mr-sm-2" name="teacher_type">
                            <option value="">--Please select--</option>
                            <option value="community_tutor" <?php echo e(($getLoggedIndata->teacher_type == 'community_tutor') ? 'selected' : ''); ?>>Community Tutor</option>               
                            <option value="specialist_teacher" <?php echo e(($getLoggedIndata->teacher_type == 'specialist_teacher') ? 'selected' : ''); ?>>Specialist Teacher</option>               
                          </select>
                          <?php if($errors->has('teacher_type')): ?>
                            <span class="text-danger"><?php echo e($errors->first('teacher_type')); ?></span>
                          <?php endif; ?>
                        </div>
                        
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
                    <form role="form" action="<?php echo e(route('teacher-languages-update')); ?>" method="POST" enctype="multipart/form-data" > 
                    <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                      <div class="education-part">
                      <div class="form-row part-title align-items-center">
                         <div class="form-group col-md-12"><h3>Languages I taught</h3></div>
                      </div>
                      
                      
                      <?php if($getLoggedIndata->languages_taught!=''): ?>
                        
                        <?php
                            $languagesTaughtArr = json_decode($getLoggedIndata->languages_taught, true);
                        ?>
                      
                        <div class="form-row taughtLangDiv" id="taught-boxes-wrap">
                          
                            <?php $__currentLoopData = $languagesTaughtArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="display:flex;width:100%; margin:0 -15px;">
                                <div class="form-group col-md-9">
                                    <label for="inputEmail4">Languages I taught</label>
                                    <select name="taught_lang[]" class="custom-select mr-sm-2" id="">
                                        <option value="">--Please select--</option>
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val->name); ?>" <?php echo e(($val->name == $v['language'])  ? 'selected' : ''); ?>><?php echo e($val->name); ?></option> 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div> 
                                <div class="form-group col-md-3">
                                    <label for="">Delete</label>
                                    <div class="input-group-text remove-taught-lang-row form-control"><i class="fa fa-trash-o" aria-hidden="true"></i></div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                        </div>
                      
                      <?php else: ?>
                      <div class="form-row taughtLangDiv" id="taught-boxes-wrap">
                        <div style="display:flex;width:100%; margin:0 -15px;">
                            <div class="form-group col-md-9">
                                <label for="inputEmail4">Languages I taught</label>
                                <select name="taught_lang[]" class="custom-select mr-sm-2" id="">
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
                      <?php endif; ?>
                      
                      
                      
                      <div class="form-row mt-3"> 
                          <div class="form-group col-md-12">
                            <button type="button" id="taughtAppend" class="btn btn-addmore"><i class="fa fa-plus" aria-hidden="true"></i> Add More Languages</button>
                          </div>
                      </div>
                         
                      </div>
                      <div class="education-part">
                        <div class="form-row part-title align-items-center">
                            <div class="form-group col-md-12"><h3>Languages I know</h3></div>
                        </div> 
                        <div class="form-row part-title align-items-center">
                            <div class="form-group col-md-12"><label for="inputEmail4">Native Language</label></div>
                        </div>
                        
                        
                        
                        
                        <?php if($getLoggedIndata->languages_spoken!=''): ?>
                        
                            <?php
                                $languagesSpokenArr = json_decode($getLoggedIndata->languages_spoken, true);
                            ?>
                        <div class="form-row language-row align-items-center regLangDiv" id="reg-boxes-wrap">
                            <?php $__currentLoopData = $languagesSpokenArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="display:flex;width:100%; margin:0 -15px;">
                                
                                <div class="form-group col-md-6">
                                  <select name="language[]" class="custom-select mr-sm-2">
                                    <option value="">--Please select--</option>
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($val->name); ?>" <?php echo e(($val->name == $v['language'])  ? 'selected' : ''); ?>> <?php echo e($val->name); ?> </option>               
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                  </select>
                                </div>
                                <div class="form-group col-md-4">
                                  <select name="lang_level[]" class="custom-select mr-sm-2">
                                    <option value="">--Please select--</option>
                                    <option value="Native" <?php echo e(($v['level']=='Native')  ? 'selected' : ''); ?>>Native</option>
                                    <option value="Beginner" <?php echo e(($v['level']=='Beginner')  ? 'selected' : ''); ?>>Beginner</option>
                                    <option value="Elementary" <?php echo e(($v['level']=='Elementary')  ? 'selected' : ''); ?>>Elementary</option>
                                    <option value="Intermediate" <?php echo e(($v['level']=='Intermediate')  ? 'selected' : ''); ?>>Intermediate</option>
                                    <option value="Upper Intermediate" <?php echo e(($v['level']=='Upper Intermediate')  ? 'selected' : ''); ?>>Upper Intermediate</option> 
                                    <option value="Advanced" <?php echo e(($v['level']=='Advanced')  ? 'selected' : ''); ?>>Advanced</option>
                                    <option value="Proficient" <?php echo e(($v['level']=='Proficient')  ? 'selected' : ''); ?>>Proficient</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="edite-delite remove-reg-lang-row">
                                       <a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </div>
                        <?php else: ?>
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
                        <?php endif; ?>
                      
                      
                      
                      <div class="form-row mt-3"> 
                          <div class="form-group col-md-12">
                            <button type="button" id="langAppend" class="btn btn-addmore"><i class="fa fa-plus" aria-hidden="true"></i> Add More Languages</button> 
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
                    <form role="form" action="<?php echo e(route('teacher-communication-tool-update')); ?>" method="POST" enctype="multipart/form-data" > 
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
                    <div class="information-section information-basic">
                        <form role="form" action="<?php echo e(route('teacher-introduction-update')); ?>" method="POST" enctype="multipart/form-data" > 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4"><h4>About Me</h4></label>
                                    <textarea name="about_me" rows="5" class="form-control"><?php echo e($getLoggedIndata->about_me); ?></textarea>
                                    <?php if($errors->has('about_me')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('about_me')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="inputEmail4"><h4>About My Lessons</h4></label>
                                    <textarea name="about_my_lessons" rows="5" class="form-control"><?php echo e($getLoggedIndata->about_my_lessons); ?></textarea>
                                    <?php if($errors->has('about_my_lessons')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('about_my_lessons')); ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                
                                <!--<div class="form-group col-md-12">
                                    <label for="inputEmail4"><h4>My Lessons & Teaching Style</h4></label>
                                    <textarea name="" rows="5" class="form-control"><?php echo e($getLoggedIndata->about_me); ?></textarea>
                                    <?php if($errors->has('about_me')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('about_me')); ?></span>
                                    <?php endif; ?>
                                </div>-->
                                
                                
                                <?php
                                  $myTeachingMaterialArr = json_decode($getLoggedIndata->my_teaching_material, true);
                                ?>
                                
                                <?php if($getLoggedIndata->my_teaching_material!=''): ?>
                                <div class="form-row">
                                    <div class="form-group col-md-12"><h4>My Teaching Material (Optional)</h4></div>
                                    <div class="form-group col-md-4">
                                      <div class="form-check">
                                        <input type="checkbox" name="my_teaching_material[]" value="PDF file" <?php echo e(in_array('PDF file',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> class="form-check-input" id="exampleCheck1"> 
                                        <label class="form-check-label" for="exampleCheck1">PDF file </label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" name="my_teaching_material[]" value="Audio files" <?php echo e(in_array('Audio files',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> class="form-check-input" id="exampleCheck2"> 
                                        <label class="form-check-label" for="exampleCheck2">Audio files</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" name="my_teaching_material[]" value="Flashcards" <?php echo e(in_array('Flashcards',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> class="form-check-input" id="exampleCheck3">
                                        <label class="form-check-label" for="exampleCheck3">Flashcards</label> 
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" name="my_teaching_material[]" value="Test templates and examples" <?php echo e(in_array('Test templates and examples',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> class="form-check-input" id="exampleCheck4">
                                        <label class="form-check-label" for="exampleCheck4">Test templates and examples</label> 
                                      </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Text documents" <?php echo e(in_array('Text documents',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck5">
                                        <label class="form-check-label" for="exampleCheck5">Text documents</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Image files" <?php echo e(in_array('Image files',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck6">
                                        <label class="form-check-label" for="exampleCheck6">Image files </label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Articles and news" <?php echo e(in_array('Articles and news',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck7">
                                        <label class="form-check-label" for="exampleCheck7">Articles and news </label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Graphs and charts" <?php echo e(in_array('Graphs and charts',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck8">
                                        <label class="form-check-label" for="exampleCheck8">Graphs and charts</label>
                                      </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                     <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Presentation slides/PPT" <?php echo e(in_array('Presentation slides/PPT',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck9">
                                        <label class="form-check-label" for="exampleCheck9">Presentation slides/PPT</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Video files" <?php echo e(in_array('Video files',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck10">
                                        <label class="form-check-label" for="exampleCheck10">Video files </label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Quizzes" <?php echo e(in_array('Quizzes',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck11">
                                        <label class="form-check-label" for="exampleCheck11">Quizzes</label>
                                      </div>
                                      <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="my_teaching_material[]" value="Homework assignments" <?php echo e(in_array('Homework assignments',$myTeachingMaterialArr)===true ? 'checked' : ''); ?> id="exampleCheck12">
                                        <label class="form-check-label" for="exampleCheck12">Homework assignments </label>
                                      </div>
                                      
                                    </div>	
                                    
                                    <!--<div class="form-group col-md-12">
                                        <h5><i class="fa fa-check-circle" aria-hidden="true"></i> <strong>Approved</strong></h5>
                                    </div>-->
                                </div>
                                <?php endif; ?>
                        
                                
                            </div>
                      
                            <button type="submit" class="btn btn-submit">Save</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                    
                    
                    <form role="form" action="<?php echo e(route('teacher-video-update')); ?>" class="vdo" method="POST" enctype="multipart/form-data" > 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                    <div class="AccountSettings-box">
  					<div class="AccountSettings-box-header"><span>Video</span></div>
                      <div class="AccountSettings-box-body ">
                        <div class="Upload-Wrapper">
                          <div>
                            <div style="text-align: center;">
                              <div class="video-box">
                                <!--<video src="https://v.italki.cn/BE8B29D8-FE5A-4651-8E27-52D312B37762.mp4" class="local-video" loop controls></video>-->
                                
                                <?php if($getLoggedIndata->youtube_link !=''): ?>
                                    <iframe width="100%" height="315" src="<?php echo e($getLoggedIndata->youtube_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="mb-4"></iframe>
                                <?php elseif($getLoggedIndata->video !=''): ?>
                                    <video src="<?php echo e(url('storage/app/video/'.$getLoggedIndata->video)); ?>" class="local-video" loop controls></video>     
                                <?php else: ?>
                                    
                                <?php endif; ?>
                                
                                
                                <div class="videobox">
                                    <?php if($getLoggedIndata->video!='' || $getLoggedIndata->youtube_link !=''): ?>
                                    <span>Change Video</span>
                                    <?php else: ?>
                                    <span>Upload Video</span>
                                    <?php endif; ?>
                                    
                                  
                                    <input type="file" name="video" class="videoInput" id="" accept="video/*"> 
                                  
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <section class="profile-video-characteristics">
                          <ul class="video-info-lists">
                            <li><span>By submitting your video to tokatif, you acknowledge that you agree to tokatif's Terms of Service. Please be sure not to violate others' copyright or privacy rights.</span></li>
                            <li><span>File size may not exceed 500 MB</span></li>
                            <li><span>Please take some time to read the <a href="#" id="teacher-introduction-video-requirements" target="_blank">Video Introduction Requirements</a> before you update your video.</span></li>
                          </ul>
                          <hr>
                          
                          <div class="form-group col-md-12">
                          <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input checked" id="customControlInline4">
                            <label class="custom-control-label" for="customControlInline4">I have a webcam and I can offer video-based lessons.</label>
                          </div>
                          </div>
                          
                        </section>
                      </div>
                      <div class="AccountSettings-box-footer">
                        <div class="setting-show-status"></div> 
                        <button type="submit" class="btn btn-submit">Save</button>
                      </div>
                     </div>
                     </form> 
                    
                </div>
                <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume-tab">
                    <h3>Resume and Certificates</h3>
                    <div class="information-section resume-certificate">
                     <form>
                       <div class="education-part">
                        <div class="form-row part-title align-items-center">
                         <div class="form-group col-md-6"><h3>Education</h3></div>
                         <div class="form-group col-md-6 text-right" data-toggle="modal" data-target="#addEducationModal">Add Education</div>
                        </div>
                        
                      
                          <?php
                            $educationArr = json_decode($getLoggedIndata->education, true);
                          ?>
                          
                          <?php if($educationArr): ?>
                          <?php if(count($educationArr)>0): ?>
                            <?php $__currentLoopData = $educationArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-row Approved-row align-items-center">
                                <div class="form-group col-md-2">
                                 <h4><?php echo e($val['education_year']); ?></h4>
                                 <h5>Approved</h5>
                                </div>
                                <div class="form-group col-md-6">
                                    <p><strong><?php echo e($val['education_lang']); ?></strong><br/> &nbsp;&nbsp; </p>
                                </div>
                                <div class="form-group col-md-2">
                                   
                                </div> 
                                <div class="form-group col-md-2">
                                    
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>
                          <?php endif; ?>
                        
                        
                      </div>
                        
                       <div class="education-part">
                        <div class="form-row part-title align-items-center">
                            <div class="form-group col-md-6"><h3>Work Experience</h3></div>
                            <div class="form-group col-md-6 text-right" data-toggle="modal" data-target="#addWorkExperienceModal">Add Work Experience</div>
                        </div>
                        
                        <?php
                            $experienceArr = json_decode($getLoggedIndata->experience, true);
                        ?>
                        
                        <?php if($experienceArr): ?>
                        <?php if(count($experienceArr)>0): ?>
                            <?php $__currentLoopData = $experienceArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-row Approved-row align-items-center">
                                <div class="form-group col-md-2">
                                 <h4><?php echo e($val['experience_year']); ?></h4>
                                 <h5>Approved</h5>
                                </div>
                                
                                <div class="form-group col-md-8">
                                    <p><strong><?php echo e($val['designation']); ?></strong><br/>
        						                <?php echo e($val['organization']); ?></p>
                                </div>
                                 
                            
                                <div class="form-group col-md-2">
                                    
                                </div>     
                                
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        
                        
                        
                      </div>
                      
                        <div class="education-part">
                            <div class="form-row part-title align-items-center">
                             <div class="form-group col-md-6"><h3>Certificates</h3></div>
                             <div class="form-group col-md-6 text-right" data-toggle="modal" data-target="#addCertificateModal">Add Certificates</div>
                            </div>
                            
                            <?php
                                $certificateArr = json_decode($getLoggedIndata->certificate, true);
                            ?>
                            
                            <?php if($certificateArr): ?>
                            <?php if(count($certificateArr)>0): ?>
                                <?php $__currentLoopData = $certificateArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-row Approved-row align-items-center">
                                    <div class="form-group col-md-2">
                                     <h4><?php echo e($val['certificate_year']); ?></h4>
                                     <h5>Approved</h5>
                                    </div>
                                    
                                    <div class="form-group col-md-1">
                                       <img src="<?php echo e(asset('public/frontendassets/images/certifcat.jpg')); ?>" class="img-fluid"/>
                                    </div>
                                 
                                    <div class="form-group col-md-7">
                                        <p><strong><?php echo e($val['certificate_designation']); ?></strong><br/>
            						                organization - <?php echo e($val['certificate_organization']); ?></p>
                                    </div>
            
                                    <div class="form-group col-md-2">
                                        
                                    </div>     
                                    
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php endif; ?>
                      
                            
                        </div>
                      
                       <!--<div class="form-row align-items-center">
                      <div class="form-group col-md-12">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Public - title and description visible on my teaching profile</label>
                      </div>
                      </div>
                      </div> 
                      <button type="submit" class="btn btn-submit">Save</button> -->
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




<!-- Education --> 
<div class="modal fade" id="addEducationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">Add Education</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <form role="form" action="<?php echo e(route('teacher-education-update')); ?>" method="POST" enctype="multipart/form-data" > 
        <?php echo e(csrf_field()); ?>

      <div class="modal-body">
        <div class="md-form mb-5">
            <label>Education Year</label>
            <input type="number" name="education_year" min="4" class="form-control" required>
        </div>

        <div class="md-form">
            <label>Education Language</label>
            <input type="text" name="education_lang" class="form-control" required>
        </div>
        
        <div class="md-form">
            <label>Education File</label>
            <input type="file" name="education_file" accept=".pdf, .doc, .docx" class="form-control" required>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-outline-warning waves-effect"> Save </button>
      </div>
      </form>
    </div>
    <!--/.Content-->
  </div>
</div>




<!-- Work Experience --> 
<div class="modal fade" id="addWorkExperienceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">Add Work Experience</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <form role="form" action="<?php echo e(route('teacher-work-exp-update')); ?>" method="POST" enctype="multipart/form-data" > 
        <?php echo e(csrf_field()); ?>

      <div class="modal-body">
        <div class="md-form mb-5">
            <label>Experience Year</label>
            <input type="number" name="experience_year" min="4" class="form-control" required>
        </div>

        <div class="md-form">
            <label>Designation</label>
            <input type="text" name="designation" class="form-control" required>
        </div>
        
        <div class="md-form">
            <label>Organization</label>
            <input type="text" name="organization" class="form-control" required>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-outline-warning waves-effect"> Save </button>
      </div>
      </form>
    </div>
    <!--/.Content-->
  </div>
</div>



<!-- Certificates --> 
<div class="modal fade" id="addCertificateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">Add Certificate </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      <form role="form" action="<?php echo e(route('teacher-certificate-update')); ?>" method="POST" enctype="multipart/form-data" > 
        <?php echo e(csrf_field()); ?>

      <div class="modal-body">
        <div class="md-form mb-5">
            <label>Year</label>
            <input type="number" name="certificate_year" min="4" class="form-control" required>
        </div>

        <div class="md-form">
            <label>Designation</label>
            <input type="text" name="certificate_designation" class="form-control" required>
        </div>
        
        <div class="md-form">
            <label>Organization</label>
            <input type="text" name="certificate_organization" class="form-control" required>
        </div>
      </div>

      <!--Footer-->
      <div class="modal-footer justify-content-center">
        <button type="submit" class="btn btn-outline-warning waves-effect"> Save </button>
      </div>
      </form>
    </div>
    <!--/.Content-->
  </div>
</div>




<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/edit-profile.blade.php ENDPATH**/ ?>
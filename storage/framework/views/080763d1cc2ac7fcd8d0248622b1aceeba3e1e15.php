<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('include/header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
    .nxt-step{
        background-color: #ffe001;
    }
    .prev-step, .nxt-step {
        font-size: 16px;
        padding: 8px 24px;
        border: none;
        border-radius: 30px;
        margin-top: 30px;
        cursor: pointer;
    }
</style>


<section class="step" id="teacher_registration">

    <div class="container">

        <div class="row">

            <div class="col-md-12  m-auto">

                 

          

                <section class="signup-step-container tab-section">

                    

                    <div class="container">

                        <div class="row d-flex justify-content-center">

                            <div class="col-md-12">

                                <div class="wizard">

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

                                    <div class="wizard-inner">

                                        <div class="connecting-line"></div>

                                        <ul class="nav nav-tabs" role="tablist">

                                            <li role="presentation" class="active">

                                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true">

                                                <span class="round-tab"><img src="<?php echo e(asset('public/frontendassets/images/stepimg1.png')); ?>" class="img-fluid"/></span> 

                                                <i>Apply to<br/> Teach</i></a>

                                            </li>

                                            <li role="presentation" class="disabled">

                                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false">

                                                <span class="round-tab"><img src="<?php echo e(asset('public/frontendassets/images/stepimg2.png')); ?>" class="img-fluid"/></span> <i>Personal<br/> Information</i></a>

                                            </li>

                                            <li role="presentation" class="disabled">

                                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab">

                                                <span class="round-tab"><img src="<?php echo e(asset('public/frontendassets/images/stepimg3.png')); ?>" class="img-fluid"/></span> <i>Profile <br/>Description</i></a>

                                            </li>

                                            <li role="presentation" class="disabled">

                                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab">

                                                <span class="round-tab"><img src="<?php echo e(asset('public/frontendassets/images/stepimg4.png')); ?>" class="img-fluid"/></span> <i>Video <br/>Introduction</i></a>

                                            </li>

                                             <li role="presentation" class="disabled">

                                                <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab">

                                                <span class="round-tab"><img src="<?php echo e(asset('public/frontendassets/images/stepimg5.png')); ?>" class="img-fluid"/></span> <i>Profile <br/>Verification</i></a>

                                            </li>

                                        </ul>

                                    </div>

                    

                                    <form role="form" action="<?php echo e(route('post-teacher-data')); ?>" method="POST" enctype="multipart/form-data" class="login-box"> 

                                        <?php echo e(csrf_field()); ?>


                                        <div class="tab-content" id="main_form">

                                            <section class="tab-pane active" role="tabpanel" id="step1">

                                                <h4 class="text-center step-title">On Tokatif there are two types of teachers.<br/> Which one are you?</h4>

                                                <span class="text-danger" id="teacher_type_error"></span>
                                                <?php if($errors->has('teacher_type')): ?>

                                                    <span class="text-danger"><?php echo e($errors->first('teacher_type')); ?></span>

                                                <?php endif; ?>

                                                <div class="row mt-5">

                                                    <div class="col-md-4 pr-0">

                                                        <div class="description-box">

                                                            <h3 class="mt-5">Description</h3>

                                                            <h4>Required Documents</h4>

                                                            <h5>Commission Scheme</h5>

                                                            <h6>Lesson starting price</h6>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4 p-0">

                                                        <div class="teacherType community-tutors text-center" data-searchType="community_tutor">

                                                            <img src="<?php echo e(asset('public/frontendassets/images/user-img1.png')); ?>" class="img-fluid"/>

                                                           <h3>Community Tutors</h3>

                                                           <p>A native or highly proficient speaker who is looking to share their knowledge of 

                                                              the language they speak with others. </p>

                                                           <h4 class="none-heading">None</h4>

                                                           <ul>

                                                            <li>Level 0 – 15%, 140hr</li>

                                                            <li>Level 1 – 14%, 280hr</li>

                                                            <li>Level 2 – 13%, 420hr</li>

                                                            <li>Level 3 – 12%, 560hr</li>

                                                            <li>Level 4 – 11%, 700hr</li> 

                                                            </ul>

                                                            <p>USD 5.00</p>

                                                        </div>

                                                    </div>

                                                    

                                                    <div class="col-md-4 pl-0 ">

                                                        <div class="teacherType community-tutors community-tutors-2 text-center" data-searchType="specialist_teacher">

                                                            <img src="<?php echo e(asset('public/frontendassets/images/specialist-teachers.png')); ?>" class="img-fluid"/>

                                                           <h3>Specialist Teachers</h3>

                                                           <p>A native or highly proficient speaker who has been professionally trained in the field of teaching 

                                                              specific languages to second language learners.</p>

                                                              

                                                           <p>Scanned documents showing your professional training or experience in teaching the 

                                                              language(s) you have chosen.  </p>   

                                                           <ul>

                                                            <li>Level 0 – 15%, 120hr</li>

                                                            <li>Level 1 – 14%, 240hr</li>

                                                            <li>Level 2 – 13%, 360hr</li>

                                                            <li>Level 3 – 12%, 480hr</li>

                                                            <li>Level 4 – 11%, 600hr</li>

                                                            <li>Level 5 – 10%, 1000hr</li>  

                                                            </ul>

                                                            <p>USD 10.00</p>

                                                        </div>

                                                    </div>

                                                    

                                                </div>

                                                <ul class="list-inline pull-right">

                                                    <li><button type="button" data-step="1" class="default-btn nxt-step">Continue to next step</button></li>

                                                </ul>

                                            </section>

                                            

                                            <section class="tab-pane" role="tabpanel" id="step2">

                                                <div class="all-info-container">

                                                    <div class="list-content">

                                                        <a href="#listone" data-toggle="collapse" aria-expanded="true" aria-controls="listone">Basic Information

                                                        <i class="fa fa-chevron-down"></i></a>

                                                        <div class="collapse show" id="listone">

                                                            <div class="list-box">

                                                              <h4 class="text-center">Basic Information</h4>

                                                              <input type="hidden" id="teacherTyp" name="teacher_type" value="<?php echo e(Request::old('teacher_type')); ?>">

                                                                <div class="form-group">

                                                                    <label for="inputAddress">Display Name</label>

                                                                    <input type="text" name="display_name" id="display_name" value="<?php echo e(Request::old('display_name', (isset($user)) ? $user->name : '')); ?>" class="form-control" placeholder="">
                                                                    <span class="text-danger" id="display_name_error"></span>
                                                                    <?php if($errors->has('display_name')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('display_name')); ?></span>

                                                                    <?php endif; ?>

                                                                </div>

                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Preferred Video Conferencing Platform</label>

                                                                      <select name="video_conferencing_platform" class="form-control custom-select">

                                                                        <option value="skype" <?php echo e((Request::old('video_conferencing_platform') == 'skype') ? 'selected' : ''); ?>>Skype ID</option> 

                                                                        <option value="zoom" <?php echo e((Request::old('video_conferencing_platform') == 'zoom') ? 'selected' : ''); ?>>Zoom </option>

                                                                        <!--<option value="other" <?php echo e((Request::old('video_conferencing_platform') == 'other') ? 'selected' : ''); ?>>Other</option>-->

                                                                      </select>

                                                                      <?php if($errors->has('video_conferencing_platform')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('video_conferencing_platform')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">User Account ID</label>

                                                                      <input type="text" name="user_account_id" id="user_account_id" value="<?php echo e(Request::old('user_account_id')); ?>" class="form-control" placeholder=""/>

                                                                        <span class="text-danger" id="user_account_id_error"></span>
                                                                      <?php if($errors->has('user_account_id')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('user_account_id')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                </div>

                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Country of Origin</label>

                                                                      <select name="country_of_origin" class="form-control custom-select">

                                                                        <option value="">--Please select--</option>

                                                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                         <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('country_of_origin', (isset($user)) ? $user->country_of_origin : '') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               

                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                                                                      </select>

                                                                      

                                                                      <?php if($errors->has('country_of_origin')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('country_of_origin')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Living In</label>

                                                                      <select name="country_living_in" class="form-control custom-select">

                                                                        <option value="">--Please select--</option>

                                                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                         <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('country_living_in', (isset($user)) ? $user->country_living_in : '') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               

                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                                                                      </select>

                                                                      

                                                                      <?php if($errors->has('country_living_in')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('country_living_in')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                

                                                                    <!--<div class="form-group col-md-6">

                                                                      <label for="">&nbsp;</label>

                                                                      <select id="" class="form-control custom-select">

                                                                        <option selected>Choose</option>

                                                                        <option>...</option>

                                                                      </select>

                                                                    </div>-->

                                                                </div>

                                                              

                                                              

                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Email</label>

                                                                      <input type="email" name="email" id="email" value="<?php echo e(Request::old('email', (isset($user)) ? $user->email : '')); ?>" class="form-control" placeholder="" />
                                                                      <span class="text-danger" id="email_error"></span>
                                                                      <?php if($errors->has('email')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('email')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Phone</label>

                                                                      <input type="tel" name="phone" id="phone" value="<?php echo e(Request::old('phone', (isset($user)) ? $user->phone_number : '')); ?>" class="form-control" placeholder=""/>
                                                                      <span class="text-danger" id="phone_error"></span>
                                                                      <?php if($errors->has('phone')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('phone')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                </div>

                                                                

                                                                
                                                                <?php if(!isset($user)): ?>
                                                                <div class="form-row">

                                                                    <div class="form-group col-md-6">

                                                                      <label for="">Password</label>

                                                                      <input type="password" name="password" id="password" value="<?php echo e(Request::old('password')); ?>" class="form-control" placeholder="" />

                                                                      <?php if($errors->has('password')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('password')); ?></span>

                                                                      <?php endif; ?>

                                                                    </div>

                                                                    

                                                                </div>
                                                                <?php endif; ?>
                                                              

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="list-content">

                                                        <a href="#listtwo" data-toggle="collapse" aria-expanded="false" aria-controls="listtwo">

                                                        Private Information<i class="fa fa-chevron-down"></i></a>

                                                        <div class="collapse" id="listtwo">

                                                            <div class="list-box">

                                                                 

                                                                <!--<div class="form-row">

                                                                <div class="form-group col-md-6">

                                                                  <label for="">First Name</label>

                                                                 <select class="custom-select mr-sm-2" id="">

                                                                    <option selected>First Name</option>

                                                                    <option>...</option>

                                                                  </select>

                                                                </div>

                                                                <div class="form-group col-md-6">

                                                                  <label for="">Last Name</label>

                                                                 <select class="custom-select mr-sm-2" id="">

                                                                    <option selected>Last Name</option>

                                                                    <option>...</option>

                                                                  </select>

                                                                </div>

                                                              </div>-->

                                                                <div class="form-row">

                                                                <div class="form-group col-md-6 calender-icon">

                                                                  <label for="">Date Of Birth</label>

                                                                  <input type="date" name="dob" id="dob" value="<?php echo e(Request::old('dob', (isset($user)) ? $user->dob : '')); ?>" class="form-control" >
                                                                  <span class="text-danger" id="dob_error"></span>
                                                                  <!--<i class="fa fa-calendar" aria-hidden="true"></i>-->

                                                                  <?php if($errors->has('dob')): ?>

                                                                    <span class="text-danger"><?php echo e($errors->first('dob')); ?></span>

                                                                  <?php endif; ?>

                                                                </div>

                                                                <div class="form-group col-md-6">

                                                                  <label for="">Gender</label>

                                                                  <ul class="radio-btn">

                                                                  <li>

                                                                    <input type="radio" name="gender" id="f-option" value="Male" <?php echo e((Request::old('gender') == 'Male') ? 'checked=checked' : ''); ?>>

                                                                    <label for="f-option"><i class="fa fa-male" aria-hidden="true"></i> Male</label>             

                                                                  </li>

                                                                  

                                                                  <li>

                                                                    <input type="radio" name="gender" id="s-option" value="Female" <?php echo e((Request::old('gender') == 'Female') ? 'checked=checked' : ''); ?>>

                                                                    <label for="s-option"><i class="fa fa-female" aria-hidden="true"></i> Female</label>                              

                                                                  </li>

                                                                  

                                                                  <li>

                                                                    <input type="radio" name="gender" id="t-option" value="Not Given" <?php echo e((Request::old('gender') == 'Not Given') ? 'checked=checked' : ''); ?>>

                                                                    <label for="t-option"><img src="<?php echo e(asset('public/frontendassets/images/not-given.png')); ?>">Not Given</label>

                                                                  </li>

                                                                </ul> <br><br>
                                                                <span class="text-danger" id="gender_error"></span>
                                                                <?php if($errors->has('gender')): ?>

                                                                    <span class="text-danger"><?php echo e($errors->first('gender')); ?></span>

                                                                <?php endif; ?>

                                                                </div>

                                                              </div>

                                                                

                                                                <div class="form-group">

                                                                    <label for="inputAddress">Street Address</label>

                                                                    <input type="text" name="street_address" value="<?php echo e(Request::old('street_address')); ?>" class="form-control" placeholder="">

                                                                    <span class="text-danger" id="street_address_error"></span>
                                                                    <?php if($errors->has('street_address')): ?>

                                                                        <span class="text-danger"><?php echo e($errors->first('street_address')); ?></span>

                                                                    <?php endif; ?>

                                                                </div>

                                                              

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="list-content">

                                                        <a href="#listthree" data-toggle="collapse" aria-expanded="false" aria-controls="listthree">

                                                        Language Skills<i class="fa fa-chevron-down"></i></a>

                                                        <div class="collapse" id="listthree">

                                                            <div class="list-box mt-3">

                                                               <h4> Language Skills</h4>

                                                                <div class="form-row radious-none">

                                                                <div class="form-group col-md-6 pr-0">

                                                                  <label for="">Languages Spoken</label>

                                                                </div>

                                                                <div class="form-group col-md-4 p-0">

                                                                  <label for="">Level</label>

                                                                </div>

                                                                <div class="form-group col-md-2 pl-0 len-delite text-center">

                                                                  <label for="">Delete</label>

                                                                </div>

                                                              </div>

                                                              

                                                            <div class="regLangDiv" id="reg-boxes-wrap"> 

                                                                <div class="form-row radious-none">

                                                                    <div class="form-group col-md-6 pr-0">

                                                                      <select name="language[]" class="form-control custom-select">

                                                                        <option value="">--Please select--</option>

                                                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                         <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('language') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                                                                      </select>

                                                                    </div>

                                                                    <div class="form-group col-md-4 p-0">

                                                                      <select name="lang_level[]" class="form-control custom-select"> 
                                                                        <option value="Native" <?php echo e((Request::old('lang_level') == 'Native') ? 'selected' : ''); ?>>Native</option>
                                                                        <option value="Beginner" <?php echo e((Request::old('lang_level') == 'Beginner') ? 'selected' : ''); ?>>Beginner</option>
                                                                        <option value="Elementary" <?php echo e((Request::old('lang_level') == 'Elementary') ? 'selected' : ''); ?>>Elementary</option>
                                                                        <option value="Intermediate" <?php echo e((Request::old('lang_level') == 'Intermediate') ? 'selected' : ''); ?>>Intermediate</option>
                                                                        <option value="Upper Intermediate" <?php echo e((Request::old('lang_level') == 'Upper Intermediate') ? 'selected' : ''); ?>>Upper Intermediate</option> 
                                                                        <option value="Advanced" <?php echo e((Request::old('lang_level') == 'Advanced') ? 'selected' : ''); ?>>Advanced</option>
                                                                        <option value="Proficient" <?php echo e((Request::old('lang_level') == 'Proficient') ? 'selected' : ''); ?>>Proficient</option>
                                                                      </select>

                                                                    </div>

                                                                    <div class="form-group col-md-2 pl-0 len-delite text-center">

                                                                      <div class="input-group-text remove-reg-lang-row form-control"><i class="fa fa-trash-o" aria-hidden="true"></i></div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="form-row mt-3"> 

                                                              <div class="form-group col-md-12">

                                                                <button type="button" id="langAppend" class="btn btn-addmore">

                                                                 <i class="fa fa-plus" aria-hidden="true"></i> Add More Platform</button>

                                                              </div>

                                                            </div>

                                                            

                                                            

                                                            <div class="form-row mt-3"> 

                                                                <div class="form-group col-md-12">   

                                                           		    <p>Specialist teachers must provide scanned documents showing their professional 

                                                             	 training or experience for each of the languages they have chosen to teach.</p>

                                                                </div>

                                                            </div>   

                                                            

                                                            

                                                                <div class="form-row taughtLangDiv" id="taught-boxes-wrap">

                                                                    <div style="display:flex;width:100%; margin:0 -15px;">

                                                                        <div class="form-group col-md-10">

                                                                          <label for="inputEmail4">Languages Taught</label>

                                                                          <select name="taught_lang[]" class="custom-select mr-sm-2">

                                                                            <option value="">--Please select--</option>

                                                                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                             <option value="<?php echo e($val->name); ?>" <?php echo e((Request::old('language') == $val->name) ? 'selected' : ''); ?>><?php echo e($val->name); ?></option>               
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                                                                          </select>

                                                                        </div>

                                                                        <div class="form-group col-md-2 pl-0 len-delite text-center">
                                                                          <label for="">Delete</label>
                                                                          <div class="input-group-text remove-taught-lang-row form-control"><i class="fa fa-trash-o" aria-hidden="true"></i></div>
                                                                        </div>

                                                                    </div>

                                                                </div>   

                                                                <div class="form-row mt-3"> 

                                                                  <div class="form-group col-md-12">

                                                                    <button type="button" id="taughtAppend" class="btn btn-addmore">

                                                                     <i class="fa fa-plus" aria-hidden="true"></i> Add Language Taught</button>

                                                                  </div>

                                                                </div> 

                                                            

                                                            

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="list-content">

                                                        <a href="#listfour" data-toggle="collapse" aria-expanded="false" aria-controls="listfour">Profile Photo<i class="fa fa-chevron-down"></i></a>

                                                        <div class="collapse" id="listfour">

                                                            <div class="list-box">

                                                              <div class="form-row">

                                                                <div class="form-group col-md-12 text-center">

                                                                  <h3>Make a Great First Impression</h3>

                                                                  <h5>Tutors who look friendly and professional get the most students</h5>

                                                                 </div>

                                                                 </div>

                                                                <div class="row mt-5">

                                                                <div class="col-md-6">

                                                                  <div class="impression-left" id="drop-region">

                                                                    <p>Click or Drage here to upload Photo</p>

                                                                    <input type="file" name="teacher_phpto" id="t-upload-photo" value="<?php echo e(Request::old('teacher_phpto')); ?>" accept="image/*">

                                                                    <span id="image-preview"></span>

                                                                  </div> 

                                                                  <p class="text-center mt-3">JPG or PNG format. Maximum 5 MB</p> 

                                                                  

                                                                </div>

                                                                <div class="col-md-6">

                                                                  <div class="impression-right">

                                                                    <h4>Tips for an amazing photo</h4>

                                                                    <ul class="impression-img">

                                                                     <li><img src="<?php echo e(asset('public/frontendassets/images/impration-img1.png')); ?>" class="img-fluid"/></li>

                                                                     <li><img src="<?php echo e(asset('public/frontendassets/images/impration-img2.png')); ?>" class="img-fluid"/></li>

                                                                     <li><img src="<?php echo e(asset('public/frontendassets/images/impration-img3.png')); ?>" class="img-fluid"/></li>

                                                                    </ul>

                                                                    <ul class="smile-list">

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Smile and look at the camera</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Frame your head and shoulders</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Your photo is centered and upright</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Use neutral lighting and background</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Your face and eyes are fully visible (expect for religious reason)</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> Avoid logos or contact information</li>

                                                                        <li><img src="<?php echo e(asset('public/frontendassets/images/bulp-icon.png')); ?>" class="img-fluid"/> You are the only person in the photo</li>

                                                                    </ul>

                                                                  </div>

                                                                </div>

                                                              </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="list-content">

                                                        <a href="#listfive" data-toggle="collapse" aria-expanded="false" aria-controls="listfive">

                                                         Professional Teaching Background 

                                                        <i class="fa fa-chevron-down"></i></a>

                                                        <div class="collapse" id="listfive">

                                                            <div class="list-box">

                                                              <div class="form-row">

                                                                <div class="form-group col-md-12 text-center">

                                                                  <h3>Professional Teaching Background </h3>

                                                                  <h5>Please upload relevant documents showing 

                                                                      your training or experience as a language teacher.<br/>

                                                                       Uploaded files are ONLY visible to Tokatif staff.</h5>

                                                                 </div>

                                                                 </div>

                                                                <div class="row mt-5">

                                                                <div class="col-md-10 m-auto">

                                                                 <div class="education-upload">

                                                                   <a href="#education1" data-toggle="collapse" aria-expanded="false" aria-controls="education1">

                                                        			 Education<i class="fa fa-chevron-down"></i></a>

                                                                   <div class="collapse" id="education1">

                                                                    <hr>

                                                                    

                                                                    

                                                                    <div class="mt-3 mb-2 educationDiv" id="edu-boxes-wrap">

                                                                        <div class="row"> 

                                                                            <div class="form-group col-md-3 text-center">

                                                                                <input type="number" name="education_year[]" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Doctorate Year">

                                                                            </div>

                                                                            <div class="form-group col-md-4">

                                                                                <input type="text" name="education_lang[]" class="form-control" placeholder="Doctorate Language">

                                                                            </div>

                                                                            <div class="form-group col-md-4">

                                                                                <input type="file" name="education_file[]" class="uploaded-btn">Doctorate file upload

                                                                            </div>

                                                                        

                                                                            <div class="form-group remove-edu-row col-md-1">

                                                                                <!--<button><i class="fa fa-plus" aria-hidden="true"></i></button>-->

                                                                                <button type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <div class="form-row mt-3"> 

                                                                      <div class="form-group col-md-12">

                                                                        <button type="button" id="eduAppend" class="btn btn-addmore">

                                                                         <i class="fa fa-plus" aria-hidden="true"></i> Add More </button>

                                                                      </div>

                                                                    </div>

                                                                    

                                                                    

                                                                    

                                                                    <hr>

                                                                    <!--<div class="row mt-3 mb-2">

                                                                    <div class="form-group col-md-3 text-center">

                                                                      <h3><input type="number" name="" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Phd Year"></h3>

                                                                     </div>

                                                                     <div class="form-group col-md-4">

                                                                      <h3><input type="text" name="" class="form-control" placeholder="Phd Language"></h3>

                                                                      <p>MIT Banglore</p>

                                                                     </div>

                                                                     

                                                                     <div class="form-group col-md-4">

                                                                      <input type="file" name="" class="uploaded-btn">Doctorate file upload

                                                                      </div>

                                                                      

                                                                      <div class="form-group col-md-1">

                                                                        <button><i class="fa fa-minus" aria-hidden="true"></i></button>

                                                                      </div>

                                                                     

                                                                    </div>-->

                                                                    

                                                                   </div>  

                                                                  </div>

                                                                 <div class="education-upload mt-3">

                                                                   <a href="#education2" data-toggle="collapse" aria-expanded="false" aria-controls="education2">

                                                        			 Work Experience<i class="fa fa-chevron-down"></i></a>

                                                                   <div class="collapse" id="education2">

                                                                    <hr>

                                                                    

                                                                    

                                                                    <div class="mt-3 mb-2 wExpDiv" id="wExp-boxes-wrap">

                                                                        <div class="row"> 

                                                                            <div class="form-group col-md-2">

                                                                              <h3><input type="number" name="experience_year[]" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Year"></h3>

                                                                            </div>

                                                                            <div class="form-group col-md-3">

                                                                              <input type="text" name="designation[]" class="form-control" placeholder="Designation">

                                                                            </div>

                                                                            <div class="form-group col-md-3"><input type="text" name="organization[]" class="form-control" placeholder="Organization"></div>                                     <div class="form-group col-md-3"><textarea name="" class="form-control" placeholder="Experience"></textarea></div>

                                                                         

                                                                            <div class="form-group remove-wExp-row col-md-1">

                                                                                <button type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <div class="form-row mt-3"> 

                                                                      <div class="form-group col-md-12">

                                                                        <button type="button" id="wExpAppend" class="btn btn-addmore">

                                                                         <i class="fa fa-plus" aria-hidden="true"></i> Add More </button>

                                                                      </div>

                                                                    </div>

                                                                    

                                                                    

                                                                   </div>  

                                                                  </div> 

                                                                 <div class="education-upload mt-3">

                                                                   <a href="#education3" data-toggle="collapse" aria-expanded="false" aria-controls="education3">

                                                        			 Certificates<i class="fa fa-chevron-down"></i></a>

                                                                   <div class="collapse" id="education3">

                                                                    <hr>

                                                                    

                                                                    <div class="mt-3 mb-2 certDiv" id="cert-boxes-wrap">

                                                                        <div class="row">

                                                                            <div class="form-group col-md-3 text-center">

                                                                              <input type="number" name="certificate_year[]" min="1900" max="<?=date('Y')?>" step="1" class="form-control" placeholder="Year">

                                                                            </div>

                                                                            <div class="form-group col-md-4">

                                                                              <input type="text" name="certificate_designation[]" class="form-control" placeholder="Designation">

                                                                            </div>

                                                                            <div class="form-group col-md-4">

                                                                             <input type="text" name="certificate_organization[]" class="form-control" placeholder="Organization">

                                                                            </div>

                                                                         

                                                                            <div class="form-group remove-cert-row col-md-1">

                                                                                <button><i class="fa fa-minus" aria-hidden="true"></i></button>

                                                                            </div>

                                                                        </div>

                                                                     <!--<a href="#" class="uploaded-btn" type="button" data-toggle="modal" data-target="#exampleModal">												                       											

                                                                     Add Education</a>-->

                                                                    </div>

                                                                    <div class="form-row mt-3"> 

                                                                      <div class="form-group col-md-12">

                                                                        <button type="button" id="certAppend" class="btn btn-addmore">

                                                                         <i class="fa fa-plus" aria-hidden="true"></i> Add More </button>

                                                                      </div>

                                                                    </div>

                                                                    

                                                                    

                                                                   </div>  

                                                                  </div> 

                                                                </div>

                                                                

                                                              </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                

                                                <div class="form-row">

                                                    <div class="form-group col-md-4 text-left">

                                                     <button type="button" class="default-btn prev-step">

                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>

                                                     Back</button>

                                                    </div>

                                                    <div class="form-group col-md-4 text-center">

                                                      <!--<button type="button" class="default-btn next-step skip-btn">Save For Later</button>-->

                                                    </div>

                                                    <div class="form-group col-md-4 text-right">

                                                       <button type="button" data-step="2" class="default-btn step-2 nxt-step">Next 

                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

            											</button>

                                                    </div>

                                                  </div>

                                            </section>

                                            <section class="tab-pane" role="tabpanel" id="step3">

                                               <h4 class="text-center">Profile Description</h4>

                                                 <div class="form-row">

                                                   <div class="form-group col-md-12">

                                                    <label for="exampleFormControlTextarea1">About Me</label>

                                                    <textarea class="form-control" name="about_me" id="about_me" placeholder="Tell Us About Yourself " rows="3"><?php echo e(Request::old('about_me')); ?></textarea>

                                                    <small>250 characters min  |  1000 character limit</small> <br>
                                                    <span class="text-danger" id="about_me_error"></span>
                                                    <?php if($errors->has('about_me')): ?>

                                                        <span class="text-danger"><?php echo e($errors->first('about_me')); ?></span>

                                                    <?php endif; ?>

                                                  </div>              

                                               </div>

                                                 <div class="form-row mt-4">

                                                   <div class="form-group col-md-12">

                                                    <label for="exampleFormControlTextarea1">About My Lessons </label>

                                                    <textarea class="form-control" name="about_my_lessons" id="about_my_lessons" placeholder="Tell Us About Your Lessons" rows="3"><?php echo e(Request::old('about_my_lessons')); ?></textarea>

                                                    <small>250 characters min  |  1000 character limit</small> <br>

                                                    <span class="text-danger" id="about_my_lessons_error"></span>
                                                    <?php if($errors->has('about_my_lessons')): ?>

                                                        <span class="text-danger"><?php echo e($errors->first('about_my_lessons')); ?></span>

                                                    <?php endif; ?>

                                                  </div>              

                                               </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-4 text-left">

                                                     <button type="button" class="default-btn prev-step">

                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>

                                                     Back</button>

                                                    </div>

                                                    <div class="form-group col-md-4 text-center">

                                                      <!--<button type="button" class="default-btn next-step skip-btn">Save For Later</button>-->

                                                    </div>

                                                    <div class="form-group col-md-4 text-right">

                                                       <button type="button" data-step="3" class="default-btn nxt-step">Next 

                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

            											</button>

                                                    </div>

                                                  </div>

                                            </section>

                                            <section class="tab-pane" role="tabpanel" id="step4">

                                                <h4 class="text-center">Video Introduction</h4>

                                                <div class="row mt-5">

                                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                                    <h3>Steps to follow when uploading your video</h3>

                                                    <ul class="record-video">

                                                     <li><span>1</span> Record video <a href="#">(Tips for great video)</a></li>

                                                     <li><span>2</span> Upload onto YouTube</li>

                                                     <li><span>3</span> Title your video: Learn (language) with (name of person) on tokatif.com 

                                                      <a href="#">(See example)</a></li>

                                                     <li><span>4</span> Set video to PUBLIC or UNLISTED</li>

                                                     <li><span>5</span> Copy and paste link below</li>

                                                    </ul>

                                                 </div>

                                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                                    <h3>Video requirements</h3>

                                                    <ul class="record-video">

                                                     <li>1. Must be between 1-3 minutes</li>

                                                     <li>2. Must be filmed horizontally</li>

                                                     <li>3. Must have good lighting and clear sound</li>

                                                     <li>4. Your face and eyes are fully visible (except for religious reasons)</li>

                                                     <li>5. Must not include personal contact information or external advertisements</li>

                                                    </ul>

                                                 </div>

                                                </div>

                                                <hr/>

                                                <div class="row mt-5">

                                                 <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                                                    <h3>Examples</h3>

                                                    <p>A person named John Smith teaching English would title their video “Learn English with John Smith on tokatif.com”</p>

                                                 </div>

                                                </div>

                                                <hr/>

                                                

                                                <div class="row mt-5">

                                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                                    <h3>Tips for an amazing video</h3>

                                                    <ul class="record-video">

                                                     <li>1. Plan and practise what you are going to say</li>

                                                     <li>2. Showcase the language that you are teaching</li>

                                                     <li>3. Highlight any teaching certification and experience</li>

                                                     <li>4. Invite students to book a lesson with you</li>

                                                     </ul>

                                                 </div>

                                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">

                                                    <h3>Things to consider</h3>

                                                    <ul class="record-video">

                                                     <li>1. Filming outdoors may help make your video more visually

                                                            appealing, but the sound of wind and other external noises

                                                            may make it hard for students to hear what you’re saying.</li>

                                                     <li>2. Adding background music may make your video more exciting, 

                                                            but it can also be a distraction to the more serious students</li>

                                                     <li>3. Simple is best.</li>

                                                     </ul>

                                                 </div>

                                                </div>

                                                

                                                <!--<a href="#" class="video-upload">Upload Your Video</a>-->

                                                <!--<input type="file" name="video" value="<?php echo e(Request::old('video')); ?>" class="video-upload" accept="video/*"> Upload Your Video

                                                <?php if($errors->has('video')): ?>

                                                    <span class="text-danger"><?php echo e($errors->first('video')); ?></span>

                                                <?php endif; ?>

                                                

                                                

                                                <br>OR<br>-->

                                                <div>

                                                    Enter Youtube video URL: (Like: https://www.youtube.com/embed/fC9da6eqaq)

                                                    <input type="text" name="youtube_link" id="youtube_link" value="<?php echo e(Request::old('youtube_link')); ?>" class="form-control" placeholder=""/>

                                                    <?php if($errors->has('youtube_link')): ?>

                                                        <span class="text-danger"><?php echo e($errors->first('youtube_link')); ?></span>

                                                    <?php endif; ?>

                                                </div>

                                                

                                                

                                                

                                                

                                                <div class="form-row">

                                                    <div class="form-group col-md-4 text-left">

                                                     <button type="button" class="default-btn prev-step">

                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>

                                                     Back</button>

                                                    </div>

                                                    <div class="form-group col-md-4 text-center">

                                                      <!--<button type="button" class="default-btn next-step skip-btn">Save For Later</button>-->

                                                    </div>

                                                    <div class="form-group col-md-4 text-right">

                                                       <button type="button" data-step="4" class="default-btn nxt-step">Next 

                                                       <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

            											</button>

                                                    </div>

                                                </div>

                                            </section>

                                            <section class="tab-pane" role="tabpanel" id="step5">

                                             <div class="row">

                                              <div class="col-lg-8 m-auto">

                                                <h4 class="text-center">Profile Verification</h4>

                                                <h5>Confirm Your Identity</h5>

                                                <h3>Documents requirements</h3>

                                                <div class="form-row"> 

                                                    <div class="form-group col-md-12 upload-custom">

                                                        <p>1. Scanned copy (or close up photo) of your photo ID (i.e. passport, ID card, driver’s license)</p>

                                                        <p>2. Photo of applicant holding the same photo ID with the person’s photo and name clearly visible</p>

                                                    </div>

                                                </div>

                                                

                                                <div class="form-row">

                                                 

                                                    <div class="form-group col-md-6 upload-custom">

                                                       <label for="">Click or Drag here to upload Photo</label>

    												   <input type="file" name="scanned_id_proof" id="upload-photo" value="<?php echo e(Request::old('scanned_id_proof')); ?>" accept="image/*" >

    												   <span id="frame"></span>

                                                    </div>

                                                    <?php if($errors->has('scanned_id_proof')): ?>

                                                        <span class="text-danger"><?php echo e($errors->first('scanned_id_proof')); ?></span>

                                                    <?php endif; ?>

                                                    

                                                    

                                                    <div class="form-group col-md-6 upload-custom-1">

                                                       <label for="">Click or Drag here to upload Photo</label>

    												   <input type="file" name="applicant_with_scanned_id_proof" id="upload-photo-1" value="<?php echo e(Request::old('applicant_with_scanned_id_proof')); ?>" accept="image/*" >

                                                       <span id="a_frame"></span>

                                                    </div>

                                                    <?php if($errors->has('applicant_with_scanned_id_proof')): ?>

                                                        <span class="text-danger"><?php echo e($errors->first('applicant_with_scanned_id_proof')); ?></span>

                                                    <?php endif; ?>

                                                </div>

                                                 

                                                 <div class="form-row">

                                                    <div class="form-group col-md-6 text-left">

                                                     <button type="button" class="default-btn prev-step">

                                                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>

                                                     Back</button>

                                                    </div>

                                                    

                                                    <div class="form-group col-md-6 text-right">

                                                        <button type="submit" data-step="5" class="default-btn nxt-step"> Finish </button> 

                                                    </div>

                                                  </div> 

                                                  </div>

                                                  </div>

                                            </section>

                                            <section class="clearfix"></section>

                                        </div>

                                        

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>   

            </div>

        </div>

    </div>

</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/tokatifc/public_html/resources/views/user/teacher-registration.blade.php ENDPATH**/ ?>
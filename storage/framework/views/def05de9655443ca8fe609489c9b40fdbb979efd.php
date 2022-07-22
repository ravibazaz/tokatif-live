<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
 $getVisitorCountry = getVisitorCountry();
?>



<section class="teacher-contain student-profile-edit student-setting-all">
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
                    <img src="<?php echo e(asset('public/frontendassets/images/general_2.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/general_2_hover.png')); ?>" class="hover-on"/> General </a> 
                </li>
                
                <li class="nav-item"> <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/password_2.png')); ?>" class="normal"/>  
                    <img src="<?php echo e(asset('public/frontendassets/images/password_2_hover.png')); ?>" class="hover-on"/> Change Password</a> 
                </li>
                <li class="nav-item"> <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/privacy.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/privacy_hover.png')); ?>" class="hover-on"/> Privacy </a> 
                </li>
                <li class="nav-item"> <a class="nav-link" id="Introduction-tab" data-toggle="tab" href="#Introduction" role="tab" aria-controls="Introduction" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/notification.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/notification_hover.png')); ?>" class="hover-on"/> Notifications</a> 
                </li>
                
                <!--<li class="nav-item"> <a class="nav-link" id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/video-gallery1.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/video-gallery2.png')); ?>" class="hover-on"/> Video </a> 
                </li>-->
                
                
                <li class="nav-item"> <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">
                    <img src="<?php echo e(asset('public/frontendassets/images/payment.png')); ?>" class="normal"/> 
                    <img src="<?php echo e(asset('public/frontendassets/images/payment_hover.png')); ?>" class="hover-on"/> Payment </a> 
                </li>
              </ul>
              </div>
            </div>
            <!-- /.col-md-4 -->
            <div class="col-md-9">
             <div class="tab-section">
              <div class="tab-content" id="myTabContent">
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
                      
                <div class="tab-pane fade show active edit-p-tab1" id="home" role="tabpanel" aria-labelledby="home-tab">
                   <h2>General</h2>
                   <div class="information-section">
                  
                     <form role="form" action="<?php echo e(route('teacher-settings-update')); ?>" method="POST" enctype="multipart/form-data" > 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                      <div class="form-row">
                        <div class="form-group col-lg-6 col-12">
                          <div class="input-group right-icon-text">
                          <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroupPrepend2">
                           <i class="fa fa-envelope" aria-hidden="true"></i></span>
                           </div>
                           <input type="email" name="email" value="<?php echo e($getLoggedIndata->email); ?>" class="form-control border-left-0" id="" placeholder="Email">
                            <?php if($errors->has('email')): ?>
                                <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                            <?php endif; ?>
                            <!--<a href="#">Change</a>-->
                          </div>
                        </div>
                        <div class="form-group col-lg-6 col-12">
                          <div class="input-group right-icon-text">
                          <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroupPrepend2">
                           <i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
                           </div>
                           <input type="number" name="phone" value="<?php echo e($getLoggedIndata->phone_number); ?>" class="form-control border-left-0" id="" placeholder="Phone Number">
                            <!--<a href="#">Add</a>-->
                          </div>
                        </div>
                        
                        
                      </div>
                      
                      
                      
                      <!--<div class="form-row">
                        <div class="form-group col-md-12 url-personal">
                         <p>Personal URL <a href="#">https://www.tokatif.com/teachmejapanese</a></p>
                        </div>
                        </div>-->
                      <!--<div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Display Language</label>
                          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                            <option selected="">English</option>
                            <option value="1">English</option>
                            <option value="2">English</option>
                            <option value="3">English</option>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Email Language</label>
                          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                            <option selected="">English</option>
                            <option value="1">English</option>
                            <option value="2">English</option>
                            <option value="3">English</option>
                          </select>
                        </div>
                      </div>-->
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Timezone</label>
                          <select class="custom-select mr-sm-2" name="timezone">
                            <option value="">--Please select--</option>
                            <?php $__currentLoopData = $timezone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($val->timezone); ?>" <?php echo e(($getLoggedIndata->timezone == $val->timezone) ? 'selected' : ''); ?>><?php echo e($val->timezone); ?></option>               
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Time Format</label>
                          <select class="custom-select mr-sm-2" name="time_format">
                            <option value="">--Please select--</option>
                            <option selected="12H" <?php echo e(($getLoggedIndata->time_format == '12H') ? 'selected' : ''); ?>>12H</option>
                            <option value="24H" <?php echo e(($getLoggedIndata->time_format == '24H') ? 'selected' : ''); ?>>24H</option> 
                          </select>
                        </div>
                      </div>
                      
                     <div class="form-row mt-3"> 
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Currency</label>
                        <select class="custom-select mr-sm-2" name="currency">
                            <option value="">--Please select--</option>
                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($val->code); ?>" <?php echo e(($getLoggedIndata->currency == $val->code) ? 'selected' : ''); ?>><?php echo e($val->code); ?> &nbsp; <?php echo e($val->symbol); ?></option>               
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </select>
                      </div>
                      </div>
                      
                      
                      <button type="submit" class="btn btn-submit">Save</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <h2>Change Password</h2>
                  <div class="information-section resume-certificate">
                     
                     <form role="form" action="<?php echo e(route('teacher-password-update')); ?>" method="POST" enctype="multipart/form-data" > 
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" class="form-control" name="id" value="<?php echo e($getLoggedIndata->id); ?>" />
                        <input type="hidden" class="form-control" name="role" value="<?php echo e($getLoggedIndata->role); ?>" />
                        
                      <div class="education-part">
					 <div class="form-row mt-3"> 
                      <div class="form-group col-md-12">
                        <label for="inputEmail4">Old Password</label>
                        <input type="password" class="form-control" name="old_password" aria-describedby="" placeholder="Old Password">
                        <?php if($errors->has('old_password')): ?>
                            <span class="text-danger"><?php echo e($errors->first('old_password')); ?></span>
                        <?php endif; ?>
                      </div>
                      </div>
                      
                      <h5 style="color:#861dcf; font-weight:600; font-size:16px; margin-top:15px;">Forgot Your Password?</h5>
                      
                      <div class="form-row mt-3"> 
                      <div class="form-group col-md-12">
                        <label for="inputEmail4">New Password</label>
                        <input type="password" class="form-control" name="new_password" aria-describedby="" placeholder="New Password">
                        <?php if($errors->has('new_password')): ?>
                            <span class="text-danger"><?php echo e($errors->first('new_password')); ?></span>
                        <?php endif; ?>
                      </div>
                      </div>
                      
                      <div class="form-row mt-3"> 
                      <div class="form-group col-md-12">
                        <label for="inputEmail4">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" aria-describedby="" placeholder="Confirm Password">
                        <?php if($errors->has('confirm_password')): ?>
                            <span class="text-danger"><?php echo e($errors->first('confirm_password')); ?></span>
                        <?php endif; ?>
                      </div>
                      </div>
                      
                      </div>
                      
                      <button type="submit" class="btn btn-submit">Update</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                  <h2>Privacy</h2>
                  <div class="information-section">
                     <form>
                      <div class="form-row">
                        <div class="form-group col-md-12 col-12">
                          <h4>Contact Permissions</h4>
                          <label for="inputEmail4">Who can send me message</label>
                          <select class="custom-select mr-sm-2" name="">
                            <option value="">--Please select--</option>
                            <option value="my_following">People I am following</option>
                            <option value="anyone">Anyone</option>
                          </select>
                        </div>
                      </div>
                      
                      <div class="form-row mt-3"> 
                       <div class="form-group col-md-12">
                         <h4>Block List </h4>
                       </div>
                       
                        
                        <?php if(count($blockedUsers)>0): ?> 
                            <?php $__currentLoopData = $blockedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <?php
                                    $studentData = DB::table('registrations')->where('id', '=', $val->user_id)->first(); 
                                
                                    $exists = file_exists( storage_path() . '/app/user_photo/' . $studentData->profile_photo );
                                ?>
                                
                                <?php $flag = ''; ?>
                                <?php if($val->country_living_in!=''): ?>
                                    <?php
                                        $countryFlagData = DB::table('countries')->where('name', '=', $val->country_living_in)->first(); 
                                        $flag = strtolower($countryFlagData->sortname);
                                    ?>
                                <?php else: ?>
                                    <?php
                                        $countryFlagData = DB::table('countries')->where('name', '=', $getVisitorCountry)->first(); 
                                        $flag = strtolower($countryFlagData->sortname);
                                    ?>
                                <?php endif; ?>
                            <div class="form-group col-md-6">
                              <div class="b-full">
                                <div class="row align-items-center">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                 	    
                                 	    <?php if($exists && $studentData->profile_photo!=''): ?> 
                                            <img src="<?php echo e(url('storage/app/user_photo/'.$studentData->profile_photo)); ?>" class="img-fluid">
                                        <?php else: ?>
                                            <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="img-fluid">   
                                        <?php endif; ?>
                    
                                        <span class="block-icon">
                                            <?php if($flag): ?>
                                                <?php $cFlag = asset('public/frontendassets/images/flags/'.$flag.'.png'); ?>
                                            <?php else: ?>
                                                <?php $cFlag = asset('public/frontendassets/images/flage.png'); ?>
                                            <?php endif; ?>
                                            <img src="<?php echo e($cFlag); ?>"/>
                                        </span>
                                    </div>
               				        <div class="col-lg-6 col-md-7 col-sm-12 col-12 pl-0">
                                       <h4><?php echo e($studentData->name); ?></h4>
                                    </div>  
                     
                                    <div class="col-lg-3 col-md-2 col-sm-12 col-12">
                                        <a href="<?php echo e(route('unblock-user',['id'=>$val->user_id])); ?>" onclick="return confirm('Do you really want to unblock the user?')" class="btn-book">Unblock</a>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <div class="form-group col-md-12">
                            <div class="b-full">
                                <div class="row align-items-center">
                   				    <div class="col-lg-12 col-md-12 col-sm-12 col-12 pl-0">
                                       <h4 class="text-center">No one currently blocked</h4>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        
                      </div>
                      
                      
                      
                       <div class="form-row mt-3"> 
                        <div class="form-group col-md-12">
                        <h4>Other Privacy Settings</h4>
                       </div>
                       
                       <div class="form-group col-md-12">
                         <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline1">
                            <label class="custom-control-label" for="customControlInline1">Allow people to view my following</label>
                          </div>
                          </div>
                           <div class="form-group col-md-12">
                          <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline2">
                            <label class="custom-control-label" for="customControlInline2">Allow people to view my lesson feedback</label>
                          </div>
                          </div>
                           <div class="form-group col-md-12">
                          <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline3">
                            <label class="custom-control-label" for="customControlInline3">Allow people to view my age</label>
                          </div>
                          </div>
                      </div>
                      
                     <div class="form-row mt-3">  
                     
                      <div class="form-group col-md-12">
                        <h4>My Data</h4>
                       </div>
                     
                      <div class="form-group col-md-12 dow-btn">
                        <label for="inputEmail4">Who can send me message</label>
                        <button type="submit" class="btn btn-submit">Download My Data</button>
                      </div>
                      
                      <div class="deactive-part"> 
                      
                       <div class="form-group col-md-12">
                        <h4>Account Deactivation</h4>
                       </div>
                      
                      
                      <div class="form-group col-md-12 dow-btn">
                        <button type="submit" class="btn btn-submit">Deactivate</button>
                      </div>
                      </div>
                     </div>
                      
                      <button type="submit" class="btn btn-submit">Save</button>
                    </form>
                  </div>
                </div>
                <div class="tab-pane fade" id="Introduction" role="tabpanel" aria-labelledby="Introduction-tab">
                   <h2>Notification</h2>
                   <div class="information-section">
                    <h4>Browser Notifications</h4>
                   
                   <div class="form-row">
                        <div class="form-group col-md-12 example">
                         <button type="button" class="btn btn-toggle mb-4" data-toggle="button" aria-pressed="false" autocomplete="off"><div class="handle"></div> </button>
      
                         <p>Browser notifications are currently disabled Tokatif browser notifications 
                           let you know when you have an important new notification or message. 
                           We strongly recommend enabling them.
                           To enable browser notifications, please visit your browser settings and give notification permissions to tokatif</p>
      
                        </div>
                      </div>
                 
                 <div class="form-row">
                    <div class="form-group col-md-12">
                        <h4>Email Notifications</h4>
                    </div>
                    

                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Important Lesson Updates" class="custom-control-input" id="customControlInline14">
                                <label class="custom-control-label" for="customControlInline14">Important Lesson Updates</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Other Lesson Updates" class="custom-control-input" id="customControlInline15">
                                <label class="custom-control-label" for="customControlInline15">Other Lesson Updates</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Upcoming Lesson Reminder" class="custom-control-input" id="customControlInline16">
                                <label class="custom-control-label" for="customControlInline16">Upcoming Lesson Reminder</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Upcoming Lesson Reminder" class="custom-control-input" id="customControlInline17">
                                <label class="custom-control-label" for="customControlInline17">Upcoming Lesson Reminder</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Upcoming Lesson 30 Mins Before Notified" class="custom-control-input" id="customControlInline18">
                                <label class="custom-control-label" for="customControlInline18">Upcoming Lesson 30 Mins Before Notified</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Upcoming Lesson 2 Hours Before Notified" class="custom-control-input" id="customControlInline19">
                                <label class="custom-control-label" for="customControlInline19">Upcoming Lesson 2 Hours Before Notified</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Someone Sends Me A Message On Tokatif" class="custom-control-input" id="customControlInline20">
                                <label class="custom-control-label" for="customControlInline20">Someone Sends Me A Message On Tokatif</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Tokatif Notifications" class="custom-control-input" id="customControlInline21">
                                <label class="custom-control-label" for="customControlInline21">Tokatif Notifications</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Tokatif Community Notifications" class="custom-control-input" id="customControlInline22">
                                <label class="custom-control-label" for="customControlInline22">Tokatif Community Notifications</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Friend Request" class="custom-control-input" id="customControlInline23">
                                <label class="custom-control-label" for="customControlInline23">Friend Request</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="checkbox" name="notifications[]" value="Tokatif Newsletters And Updates" class="custom-control-input" id="customControlInline24">
                                <label class="custom-control-label" for="customControlInline24">Tokatif Newsletters And Updates</label>
                            </div>
                        </div>

                 </div> 
                 
                 <div class="form-row">
                    <div class="form-group col-md-12">
                        <h4>Tokatif Insight</h4>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlInline25">
                            <label class="custom-control-label" for="customControlInline25">Allow Tokatif Team To Contact Me For Product Improvement.</label>
                        </div>
                    </div>  
                 </div> 
                  
                  
                    <button type="submit" class="btn btn-submit">Save Settings</button> 
                    <input type="button" class="ncheck btn-unsubscribe btn-submit" value="Subscribe All"/>
                    
                    </div>
                </div>
                
                <!--<div class="tab-pane fade" id="video" role="tabpanel" aria-labelledby="video-tab">
                    
                    
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
                        <div class="setting-show-status"><span class="setting-footer-circle"></span><span>Approved</span></div> 
                        <button type="submit" class="btn btn-submit">Save</button>
                      </div>
                     </div>
                     </form> 
                    
                </div>-->
                
                <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                    <h2>Saved Payment Methods</h2>
                    <div class="information-section">
                        <div class="row">
                            <?php if(count($saved_card_details)>0): ?>
                            <div class="col-md-8">
                                
                                <?php $__currentLoopData = $saved_card_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="payment-card">
                                    <div class="row mb-3">
                                        <div class="col-sm-6"><img src="<?php echo e(asset('public/frontendassets/images/visa.png')); ?>" class="img-fluid"/></div>
                                        <div class="col-sm-6 text-right"><a href="javascript:void(0);"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                                    </div>
                          
                                    <div class="row">
                                        <div class="col-sm-8 text-left">
                                         <p>Card Number</p>
                                         <h4> <?php echo e($val->card_no); ?> </h4>
                                        </div>
                          
                                        <div class="col-sm-4 text-right"> 
                                            <small> <strong>Expiration Date</strong></small><br/>
                                            <small> <?php echo e($val->expiry_month); ?>/<?php echo e($val->expiry_year); ?> </small>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <!--<div class="payment-card">
                           
                           <div class="row mb-3">
                          <div class="col-sm-6"><img src="<?php echo e(asset('public/frontendassets/images/master-card.png')); ?>" class="img-fluid"/></div>
                          <div class="col-sm-6 text-right"><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                          </div>
                          
                          <div class="row">
                            <div class="col-sm-8 text-left">
                             <p>Card Number</p>
                             <h4> 85XX - XXXX - XXXX - 8080</h4>
                             </div>
                          
                          <div class="col-sm-4 text-right"> 
                           <small> <strong>Expiration Date</strong></small><br/>
                          <small> 07/25 </small></div>
                          </div>
                          </div>
                                <div class="payment-card">
                           
                           <div class="row mb-3">
                          <div class="col-sm-6"><img src="<?php echo e(asset('public/frontendassets/images/paypal.png')); ?>" class="img-fluid"/></div>
                          <div class="col-sm-6 text-right"><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                          </div>
                          
                          <div class="row">
                            <div class="col-sm-8 text-left">
                             <p>Card Number</p>
                             <h4> 85XX - XXXX - XXXX - 8080</h4>
                             </div>
                          
                          <div class="col-sm-4 text-right"> 
                           <small> <strong>Expiration Date</strong></small><br/>
                          <small> 07/25 </small></div>
                          </div>
                          </div>-->
                            </div>
                            <?php else: ?>
                            <div class="col-md-12 text-center"> 
                                No saved card details found!!
                            </div>
                            <?php endif; ?>
                        </div>
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






<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/setting.blade.php ENDPATH**/ ?>
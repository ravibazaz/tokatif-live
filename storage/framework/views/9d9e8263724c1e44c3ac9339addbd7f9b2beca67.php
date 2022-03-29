<?php echo $__env->make('include/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('include/teacher-dashboard-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
 $getLoggedIndata = getLoggedinData();
?>
<section class="messages-section">
  <div class="container">
    <div class="row no-gutters">
      <div class="col-md-4 border-right"> 
        <!--<div class="settings-tray">
		  <img class="profile-image" src="https://www.clarity-enhanced.net/wp-content/uploads/2020/06/filip.jpg" alt="Profile img">
		  <span class="settings-tray--right">
			<i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
			<i class="material-icons"><img src="images/user-message.png"/></i>
			<i class="material-icons"><img src="images/message-flag.png"/></i>
		  </span>
		</div>-->
        <div class="search-box">
          <div class="input-wrapper"> <i class="fa fa-search" aria-hidden="true"></i>
            <input placeholder="Search here" class="chatUserSearch" value="" type="text">
          </div>
        </div>
        <div id="chatUsers">
    		<?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    		<div class="friend-drawer friend-drawer--onhover user" id="<?php echo e($user->id); ?>">
    		    <?php 
                    $exists = file_exists( storage_path() . '/app/user_photo/' . $user->profile_photo );
                ?>
                
                <?php if($exists && $user->profile_photo!=''): ?> 
                    <img src="<?php echo e(url('storage/app/user_photo/'.$user->profile_photo)); ?>" class="profile-image">
                <?php else: ?>
                    <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="profile-image">   
                <?php endif; ?>
                
                <?php
                  $chatData1 = DB::table('chat')->where('to', session('id'))->where('from', $user->id)->latest('created_at')->first(); 
                  $chatData2 = DB::table('chat')->where('to', $user->id)->where('from', session('id'))->latest('created_at')->first();
                  
                  $unread = '';
                  $lastChatMsg = '';
                  $lastMsg = '';
                  
                  if($chatData1){
                        if($chatData1->message!=''){
                            $lastChatMsg = $chatData1->message; 
                            $lastMsg = substr($chatData1->message, 0, 9).'...';
                        }else{
                            $lastChatMsg = $chatData1->file; 
                            $lastMsg = 'File sent...';
                        }
                        
                        $unread = $chatData1->is_read;
                        $unreadCount = DB::table('chat')->where('to', '=', session('id'))->where('from', '=', $user->id)
                                                        ->where('is_read', '=', 0)->count(); 
                  }
                  
                  if($chatData2){
                        if($chatData2->message!=''){
                            $lastChatMsg = $chatData2->message; 
                            $lastMsg = substr($chatData2->message, 0, 9).'...';
                        }else{
                            $lastChatMsg = $chatData2->file; 
                            $lastMsg = 'File sent...';
                        }
                        
                        $unread = $chatData2->is_read;
                        $unreadCount = DB::table('chat')->where('to', '=', session('id'))->where('from', '=', $user->id)
                                                        ->where('is_read', '=', 0)->count(); 
                  }
                ?>
                
                  
    		  
    		  <div class="text">
    			<h6><?php echo e($user->name); ?></h6>
    			
    			<?php if($chatData1): ?>
    			    <p class="text-muted"><?php echo e($lastMsg); ?></p>
    			<?php elseif($chatData2): ?>
    			    <p class="text-muted"><?php echo e($lastMsg); ?></p>
    			<?php endif; ?>
    		  </div>
    		  
    		   <?php if($unread==0 && $lastChatMsg!=''): ?>
    		    <span class="time text-muted small">16 Min ago</span>
        		    <?php if($unreadCount>0): ?>
                    <span class="not-seen"><?php echo e($unreadCount); ?></span>
                    <?php endif; ?>
               <?php else: ?>
                <span class="time text-muted small">yesterday
                   <div class="seen-sign"><img src="<?php echo e(asset('public/frontendassets/images/seen.png')); ?>"/></div>
                </span>
               <?php endif; ?>
               <span class="chat-online"></span>
    		</div>
    		<hr>
    		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
      </div>
      <div class="col-md-8">
        <div id="chatMessages">
          <div class="settings-tray">
            <div class="friend-drawer no-gutters friend-drawer--grey">
              <div style="width: 100%;">
                <h4 class="text-center">Welcome! <?php echo e($getLoggedIndata->name); ?></h4>
                <h6 class="text-center">Start messaging..</h6>
              </div>
              <span class="settings-tray--right"></span> </div>
          </div>
          <div class="message-blank"> <i class="fa fa-comments-o" aria-hidden="true"></i> </div>
          
        </div>
      </div>
    </div>
  </div>
</section>

<?php echo $__env->make('include/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php /**PATH /home/tokatifc/public_html/resources/views/teacher/messages.blade.php ENDPATH**/ ?>
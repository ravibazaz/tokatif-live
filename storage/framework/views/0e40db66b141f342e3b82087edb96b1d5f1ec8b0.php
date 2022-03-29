<div class="settings-tray">
	<div class="friend-drawer no-gutters friend-drawer--grey">
	    <?php 
            $exists = file_exists( storage_path() . '/app/user_photo/' . $user->profile_photo );
        ?>
        
        <?php if($exists && $user->profile_photo!=''): ?> 
            <img src="<?php echo e(url('storage/app/user_photo/'.$user->profile_photo)); ?>" class="profile-image">
        <?php else: ?>
            <img src=<?php echo e(Asset("public/assets/dist/img/transparent.png")); ?> class="profile-image">   
        <?php endif; ?>

    	<div class="text">
    	  <h6><?php echo e($user->name); ?></h6>
    	  <p class="text-muted">Online</p>
    	</div>
    	<span class="settings-tray--right">
    	<!--<i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
    	<i class="material-icons"><img src="<?php echo e(asset('public/frontendassets/images/user-message.png')); ?>"/></i>
    	<i class="material-icons"><img src="<?php echo e(asset('public/frontendassets/images/message-flag.png')); ?>"/></i>-->
        </span>
  </div>
</div>
<div class="chat-panel ">
   <div class="chat-text message-wrapper">
    <p class="messages">
        
        
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($message->file!=''): ?> 
                <?php 
                    $fileName = current(explode(".", $message->file));
                    $ext = pathinfo($message->file, PATHINFO_EXTENSION); 
                    
                    $exists = file_exists( storage_path() . '/app/chat/' . $message->file );
                            
                    $path='';
                    $size='';
                    if($exists && $message->file!=''){ 
                        $path = url('storage/app/chat/'.$message->file);
                        
                        $headers  = get_headers($path, 1);
                        $size = $headers['Content-Length'];
                        $filesize = round($size / 1024).' KB'; 
                    }
                    
                ?>
                <div class="row no-gutters">
                    <div class="FileMessageBar FileMessageBar-desktop FileMessageBar-file-wrap">
                    <div class="chat-message-right <?php echo e(($message->from == session('id')) ? '' : 'chat-message-left'); ?>">  
                      <div class="chat-message-bar">
                        <div class="chat-message-avatar-box"></div>
                        <div class="chat-message-bar-box">
                          <div class="chat-message-bar-main">
                            <a href="<?php echo e($path); ?>" target="_blank">
                                <div class="OptionsBtn OptionsBtn-desktop OptionsBtn-center optionsBtn-sender">
                                  <div class="flex flex-row OptionsBtn-btnBox"><i class="fa fa-download" aria-hidden="true"></i></div>
                                </div>
                            </a>
                            <div class="chat-message-text-box">
                              <div class="chat-message-text px-4 py-3 md:p-4">
                                <div class="FileMessageBar-file FileMessageBar-file-pointer">
                                  <div class="file-info">
                                    <div class="file-info-name"><?php echo e($fileName); ?></div>
                                    <div class="file-info-bar"><span><?php echo e($filesize); ?></span><span class="uppercase">&nbsp;•&nbsp; <?php echo e($ext); ?> </span></div>
                                  </div>
                                  <div class="FileMessageBar-fileIcon"><svg fill="#BFBFBF" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m10.2685 18.539 7.6001-7.3953c1.1479-1.1167 1.1602-2.9189.0298-4.01875-1.1318-1.10106-2.9829-1.089-4.1283.02529-.1764.17331-.4211.28063-.6915.28063-.2661 0-.5073-.10392-.683-.2723-.1736-.17085-.2809-.40594-.2809-.66545 0-.2631.1103-.50113.2884-.67272 1.9094-1.85765 4.9913-1.87695 6.8783-.04102 1.8858 1.83468 1.8672 4.83552-.0445 6.69542l-7.6027 7.3942c-1.91429 1.8636-4.99 1.8828-6.88077.0445-1.8858-1.8347-1.8697-4.833.03964-6.6906l4.15422-4.04162c.52845-.52133 1.26241-.84426 2.07401-.84426.8004 0 1.5255.31418 2.0519.82273 1.1365 1.10575 1.1216 2.89945-.0274 4.01735l-2.7711 2.696c-.1765.1733-.42116.2807-.6916.2807-.26673 0-.50841-.1044-.6842-.2735-.17325-.1708-.28031-.4057-.28031-.6649 0-.2628.11006-.5006.28777-.6722l2.76994-2.696c.1764-.1704.2856-.4065.2856-.6674 0-.5194-.4328-.9404-.9666-.9404-.2657 0-.5064.1043-.6811.2731l-4.1529 4.0403c-1.14536 1.1143-1.15526 2.9141-.02477 4.0139 1.13546 1.1035 2.9804 1.0927 4.13197-.0277z" fill="#bfbfbf"></path>
                                    </svg></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="time-table">
                        <p><?php echo e(date('d M y, h:i a', strtotime($message->created_at))); ?></p>
                        <div class="checkmark-sent-delivered">✓</div>
                 		 <div class="checkmark-read">✓</div>
                      </div>
                    </div>
        
                </div>
                </div>
        
                
            <?php else: ?> 
                <div class="row no-gutters">
            		<div class="col-md-3 <?php echo e(($message->from == session('id')) ? 'offset-md-9' : ''); ?>">
            		  <div class="chat-bubble chat-bubble--<?php echo e(($message->from == session('id')) ? 'right' : 'left'); ?>">
            			<?php if($message->message!=''): ?>
                		    <?php echo e($message->message); ?>

                		<?php endif; ?>
            		  </div>
                      <div class="timestamp"><?php echo e(date('d M y, h:i a', strtotime($message->created_at))); ?></div>
                      <div class="checkmark-sent-delivered">✓</div>
                      <div class="checkmark-read">✓</div>
            		</div>
        	    </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
                
            
    </p>
</div>

<div class="row">
    	<div class="col-12">
    	  <div class="chat-box-tray d-flex">
    		
    		
    		<input type="text" id="chat_textbox" placeholder="Type your message here...">
    		<div class="file-icon-chat">
    		    <input type="file" name="file" id="file" class="chat_file"/>
                <span class="file-custom-icon"><i class="fa fa-paperclip" aria-hidden="true"></i></span>
            </div>
    		
    		 
    	  </div>
    	</div>
    </div>
</div>
<?php /**PATH /home/tokatifc/public_html/resources/views/user/chat-messages.blade.php ENDPATH**/ ?>
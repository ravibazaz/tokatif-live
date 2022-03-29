Hi <?php echo e($details['name']); ?>,

<p>Forgot your password?</p>
<div>
    To reset your password please follow the link below: <br/>
    <a href="<?php echo e($details['url']); ?>" target="_blank"> Click here </a>  <br/>

    If you're not sure why you're receiving this message, you can report it to us by emailing support@tokatif.com. <br/><br/>

    If you suspect someone may have unauthorised access to your account, we suggest you change your password as a precaution by visiting  <a href="<?php echo e(url('/login')); ?>" target="_blank"> Login </a>  <br/><br/>

    If you need further assistance, please contact our Help team. <br/>

</div>
<br/>

Kind regards, <br/>
Tokatif Team
<?php /**PATH /home/tokatifc/public_html/resources/views/emails/forgot-password.blade.php ENDPATH**/ ?>
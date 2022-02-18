<?php
error_reporting(1);

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


function send_smtp_mail($to, $toName, $subject, $html){
    
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output 
        //$mail->SMTPDebug = 3;                                     // Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'api.crescentek.in';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'donot-reply@api.crescentek.in';                     //SMTP username
        $mail->Password   = 'Z%@1@{^*4e,a';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('donot-reply@api.crescentek.in', 'Tokatif');
        $mail->addAddress($to, $toName);     //Add a recipient
        
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $html;
        
        if($mail->send()) {
            return 1;
            //echo 'Email has been sent..';
        }else{
            return 'N/A';
        }
        
    } catch (Exception $e) {
        return "Email could not be sent!! Mailer Error: {$mail->ErrorInfo}";
    }

    
}
    
?>
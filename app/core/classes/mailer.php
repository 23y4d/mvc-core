<?php 

namespace app\core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class mailer 

{

    public static function notify($email, $content) 
    {            
        $mail =  new PHPMailer();
        $mail->isSMTP();
        $mail->Host =  config('mail.host');
        $mail->SMTPAuth  = true;
        $mail->Port = config('mail.port');
        $mail->Username = config('mail.user');
        $mail->Password = config('mail.password');
    
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('welcome@mvc.com','mvc.com');
        $mail->addAddress($email);
        $mail->Subject = 'mv.com | Activate your account';
        $mail->isHTML(true);
        $mail->Body = $content;


        if ($mail->send()) {
            return true;
        }
        return false;
    }
}




<?php
require_once __DIR__ . '/db.php'; require_once __DIR__ . '/functions.php';
class EmailService {
  public static function sendEmail($to,$subject,$body,$altBody=''){
    $status='failed'; $error=null;
    try{
      $autoload=BASE_PATH.'/vendor/autoload.php';
      if(file_exists($autoload) && defined('SMTP_HOST') && SMTP_HOST !== ''){
        require_once $autoload;
        $mail=new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host=SMTP_HOST;
        $mail->SMTPAuth=SMTP_AUTH;
        $mail->Username=SMTP_USER;
        $mail->Password=SMTP_PASS;
        $mail->SMTPSecure=SMTP_SECURE;
        $mail->Port=(int)SMTP_PORT;
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to); $mail->isHTML(true); $mail->Subject=$subject; $mail->Body=$body; $mail->AltBody=$altBody ?: strip_tags($body); $mail->send(); $status='sent';
      } else {
        $headers="MIME-Version: 1.0\r\n";
        $headers.="Content-type:text/html;charset=UTF-8\r\n";
        $headers.="From: ".SMTP_FROM_NAME." <".SMTP_FROM_EMAIL.">\r\n";
        $status = @mail($to,$subject,$body,$headers) ? 'sent' : 'failed'; if($status==='failed') $error='SMTP not configured and PHP mail() failed.';
      }
    }catch(\Exception $e){ $error=$e->getMessage(); }
    self::logEmail($to,$subject,$body,$status,$error); return $status==='sent';
  }
  public static function logEmail($to,$subject,$body,$status,$error){ try{ db()->prepare('INSERT INTO email_logs(recipient,subject,body,status,error_message) VALUES(?,?,?,?,?)')->execute([$to,$subject,$body,$status,$error]); }catch(Exception $e){} }
  public static function sendContactConfirmation($email,$name){ return self::sendEmail($email,'We received your message - MACDEF','<p>Dear '.e($name).',</p><p>Thank you for contacting MACDEF. We have received your message and will get back to you soon.</p>'); }
  public static function sendAdminNotification($subject,$name,$email,$message){ $admin=ADMIN_EMAIL; return self::sendEmail($admin,$subject,'<h3>New contact message</h3><p><b>Name:</b> '.e($name).'</p><p><b>Email:</b> '.e($email).'</p><p>'.nl2br(e($message)).'</p>'); }
}
?>
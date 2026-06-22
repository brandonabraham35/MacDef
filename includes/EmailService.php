<?php
require_once __DIR__ . '/db.php'; require_once __DIR__ . '/functions.php';
class EmailService {
  public static function sendEmail($to,$subject,$body,$altBody=''){
    $status='failed'; $error=null;
    try{
      $autoload=BASE_PATH.'/vendor/autoload.php';
      if(file_exists($autoload) && getSetting('smtp_host','')!=''){
        require_once $autoload;
        $mail=new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP(); $mail->Host=getSetting('smtp_host',''); $mail->SMTPAuth=(int)getSetting('smtp_auth','1')===1;
        $mail->Username=getSetting('smtp_user',''); $mail->Password=getSetting('smtp_pass',''); $mail->SMTPSecure=getSetting('smtp_secure','tls'); $mail->Port=(int)getSetting('smtp_port','587');
        $mail->setFrom(getSetting('smtp_from_email', getSetting('contact_email','info@macdef.org')), getSetting('smtp_from_name','MACDEF'));
        $mail->addAddress($to); $mail->isHTML(true); $mail->Subject=$subject; $mail->Body=$body; $mail->AltBody=$altBody ?: strip_tags($body); $mail->send(); $status='sent';
      } else {
        $headers="MIME-Version: 1.0
Content-type:text/html;charset=UTF-8
From: ".getSetting('smtp_from_name','MACDEF')." <".getSetting('contact_email','info@macdef.org').">
";
        $status = @mail($to,$subject,$body,$headers) ? 'sent' : 'failed'; if($status==='failed') $error='SMTP not configured and PHP mail() failed.';
      }
    }catch(Exception $e){ $error=$e->getMessage(); }
    self::logEmail($to,$subject,$body,$status,$error); return $status==='sent';
  }
  public static function logEmail($to,$subject,$body,$status,$error){ try{ db()->prepare('INSERT INTO email_logs(recipient,subject,body,status,error_message) VALUES(?,?,?,?,?)')->execute([$to,$subject,$body,$status,$error]); }catch(Exception $e){} }
  public static function sendContactConfirmation($email,$name){ return self::sendEmail($email,'We received your message - MACDEF','<p>Dear '.e($name).',</p><p>Thank you for contacting MACDEF. We have received your message and will get back to you soon.</p>'); }
  public static function sendAdminNotification($subject,$name,$email,$message){ $admin=getSetting('admin_email',getSetting('contact_email','info@macdef.org')); return self::sendEmail($admin,$subject,'<h3>New contact message</h3><p><b>Name:</b> '.e($name).'</p><p><b>Email:</b> '.e($email).'</p><p>'.nl2br(e($message)).'</p>'); }
}
?>
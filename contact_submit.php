<?php require_once 'includes/db.php'; require_once 'includes/functions.php'; require_once 'includes/EmailService.php';
if($_SERVER['REQUEST_METHOD']!=='POST') redirect('contact.php');
$first=sanitize($_POST['first_name']??''); $last=sanitize($_POST['last_name']??''); $email=clean($_POST['email']??''); $subject=sanitize($_POST['subject']??''); $message=clean($_POST['message']??'');
if(!$first||!$last||!filter_var($email,FILTER_VALIDATE_EMAIL)||!$subject||!$message){ redirect('contact.php?error=Please fill all fields correctly'); }
db()->prepare('INSERT INTO contact_submissions(first_name,last_name,email,subject,message) VALUES(?,?,?,?,?)')->execute([$first,$last,$email,$subject,$message]);
EmailService::sendContactConfirmation($email,$first.' '.$last); EmailService::sendAdminNotification('New MACDEF Contact Message: '.$subject,$first.' '.$last,$email,$message);
redirect('contact.php?success=Message sent successfully');
?>

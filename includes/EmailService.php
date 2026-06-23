<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

class EmailService {
    public static function sendEmail($to, $subject, $body, $email_type = 'system_notification', $altBody = '') {
        $status = 'failed';
        $error = null;

        // Wrap body in HTML template if it's not already wrapped
        $html_body = (strpos($body, '<!DOCTYPE html>') === false) ? self::renderTemplate($subject, $body) : $body;

        try {
            $autoload = BASE_PATH . '/vendor/autoload.php';
            if (file_exists($autoload) && defined('SMTP_HOST') && SMTP_HOST !== '') {
                require_once $autoload;
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = SMTP_HOST;
                $mail->SMTPAuth = SMTP_AUTH;
                $mail->Username = SMTP_USER;
                $mail->Password = SMTP_PASS;
                $mail->SMTPSecure = SMTP_SECURE;
                $mail->Port = (int)SMTP_PORT;
                $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
                $mail->addAddress($to);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = $html_body;
                $mail->AltBody = $altBody ?: strip_tags($body);
                $mail->send();
                $status = 'sent';
            } else {
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
                $status = @mail($to, $subject, $html_body, $headers) ? 'sent' : 'failed';
                if ($status === 'failed') $error = 'SMTP not configured and PHP mail() failed.';
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        self::logEmail($to, $subject, $html_body, $status, $error, $email_type);
        return $status === 'sent';
    }

    public static function logEmail($to, $subject, $body, $status, $error, $email_type = 'system_notification') {
        try {
            db()->prepare('INSERT INTO email_logs(recipient, subject, body, status, error_message, email_type) VALUES(?,?,?,?,?,?)')
                ->execute([$to, $subject, $body, $status, $error, $email_type]);
        } catch (Exception $e) {
            // Silently fail if log fails
        }
    }

    public static function renderTemplate($title, $body) {
        $logo = SITE_URL . '/assets/images/macdef-logo.png';
        $year = date('Y');

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7fb; margin: 0; padding: 0; color: #333; }
                .wrapper { width: 100%; table-layout: fixed; background-color: #f4f7fb; padding-bottom: 40px; }
                .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; font-family: sans-serif; color: #4a4a4a; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
                .header { background-color: #002D62; padding: 30px; text-align: center; }
                .header img { width: 80px; }
                .header h1 { color: #D4AF37; margin: 10px 0 0; font-size: 18px; text-transform: uppercase; letter-spacing: 2px; }
                .content { padding: 40px 30px; line-height: 1.6; }
                .content h2 { color: #002D62; margin-top: 0; font-size: 22px; }
                .footer { padding: 30px; text-align: center; font-size: 12px; color: #777; background-color: #f9f9f9; border-top: 1px solid #eee; }
                .footer p { margin: 5px 0; }
                .btn { display: inline-block; padding: 12px 25px; background-color: #D4AF37; color: #002D62; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
                .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                .details-table td { padding: 10px; border-bottom: 1px solid #eee; }
                .details-table td.label { font-weight: bold; color: #002D62; width: 40%; }
            </style>
        </head>
        <body>
            <center class='wrapper'>
                <table class='main' width='100%'>
                    <tr>
                        <td class='header'>
                            <img src='{$logo}' alt='MACDEF'>
                            <h1>Ma'di Cultural and Development Foundation</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class='content'>
                            <h2>{$title}</h2>
                            {$body}
                        </td>
                    </tr>
                    <tr>
                        <td class='footer'>
                            <p><strong>Ma'di Cultural and Development Foundation (MACDEF)</strong></p>
                            <p>Uganda | +256 000 000 000 | info@macdef.org</p>
                            <p><a href='".SITE_URL."' style='color: #002D62; text-decoration: none;'>www.macdef.org</a></p>
                            <p>&copy; {$year} MACDEF. All Rights Reserved.</p>
                        </td>
                    </tr>
                </table>
            </center>
        </body>
        </html>";
    }

    public static function sendAdminNotification($action, $details, $message = '') {
        $subject = "ADMIN NOTIFICATION: New Website Activity";
        $body = "
        <p>A new activity has been recorded on the website.</p>
        <table class='details-table'>
            <tr><td class='label'>Action</td><td>{$action}</td></tr>";

        foreach ($details as $label => $value) {
            $body .= "<tr><td class='label'>{$label}</td><td>" . e($value) . "</td></tr>";
        }

        $body .= "</table>";

        if ($message) {
            $body .= "<p><strong>Message:</strong><br>" . nl2br(e($message)) . "</p>";
        }

        $body .= "<p>Please log in to the MACDEF Admin Dashboard to review full details.</p>";

        return self::sendEmail(ADMIN_EMAIL, $subject, $body, 'admin_notification');
    }

    public static function sendUserConfirmation($email, $name, $type = 'Message') {
        $subject = "We Received Your {$type} - MACDEF";
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>Thank you for contacting MACDEF.</p>
        <p>We have successfully received your {$type} submission and our team will review it shortly.</p>
        <p>Our team will get back to you as soon as possible.</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $subject, $body, 'user_confirmation');
    }

    public static function sendDonationStatusUpdate($email, $name, $ref, $status, $admin_message = '') {
        $subject = "Donation Status Update - MACDEF";
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>Your donation reference <strong>#" . e($ref) . "</strong> has been updated.</p>
        <p><strong>Current Status:</strong> " . e($status) . "</p>";

        if ($admin_message) {
            $body .= "<p><strong>Additional Information:</strong><br>" . nl2br(e($admin_message)) . "</p>";
        }

        $body .= "
        <p>Thank you for supporting MACDEF and helping preserve heritage and community development.</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $subject, $body, 'donation_status');
    }

    public static function sendMembershipStatusUpdate($email, $name, $status, $admin_notes = '') {
        $subject = "Membership Application Update - MACDEF";
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>Your membership/application status has been updated.</p>
        <p><strong>Current Status:</strong> " . e($status) . "</p>";

        if ($admin_notes) {
            $body .= "<p><strong>Next Steps:</strong><br>" . nl2br(e($admin_notes)) . "</p>";
        }

        $body .= "
        <p>If you have questions, contact our team.</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $subject, $body, 'membership_status');
    }

    public static function sendContactReply($email, $name, $reply_subject, $reply_message) {
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>" . nl2br(e($reply_message)) . "</p>
        <p>Thank you for contacting MACDEF.</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $reply_subject, $body, 'contact_reply');
    }

    public static function sendDonorReply($email, $name, $subject, $message) {
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>" . nl2br(e($message)) . "</p>
        <p>Thank you for supporting MACDEF.</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $subject, $body, 'donor_reply');
    }

    public static function sendMemberReply($email, $name, $subject, $message) {
        $body = "
        <p>Hello " . e($name) . ",</p>
        <p>" . nl2br(e($message)) . "</p>
        <p>Best regards,<br>MACDEF Team</p>";

        return self::sendEmail($email, $subject, $body, 'member_reply');
    }
}
?>
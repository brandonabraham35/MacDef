<?php require_once dirname(__DIR__).'/includes/auth.php'; require_once dirname(__DIR__).'/includes/EmailService.php'; require_login();
if($_SERVER['REQUEST_METHOD']==='POST' && ($_POST['_action']??'')==='resend'){
    if(verify_csrf($_POST['csrf_token']??'')){
        $id = (int)$_POST['id'];
        $stmt = db()->prepare('SELECT * FROM email_logs WHERE id=?');
        $stmt->execute([$id]);
        $log = $stmt->fetch();
        if($log){
            if(EmailService::sendEmail($log['recipient'], $log['subject'], $log['body'])){
                $_SESSION['flash'] = 'Email resent successfully.';
            } else {
                $_SESSION['flash_err'] = 'Failed to resend email.';
            }
        }
    }
    redirect('email_logs.php');
}
$pageTitle='Email Logs'; $rows=db()->query('SELECT * FROM email_logs ORDER BY created_at DESC LIMIT 200')->fetchAll(); include __DIR__.'/includes/header.php'; $flash=$_SESSION['flash']??'';$err=$_SESSION['flash_err']??'';unset($_SESSION['flash'],$_SESSION['flash_err']); ?>
<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif;?><?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif;?>
<div class="panel"><table class="data-table"><thead><tr><th>Recipient</th><th>Subject</th><th>Status</th><th>Error</th><th>Date</th><th>Action</th></tr></thead><tbody><?php if(!$rows):?><tr><td colspan="6" class="empty">No email logs yet.</td></tr><?php endif; foreach($rows as $r):?><tr><td><?= e($r['recipient']) ?></td><td><?= e($r['subject']) ?></td><td><span class="badge b-<?= e($r['status']) ?>"><?= e($r['status']) ?></span></td><td><?= e(mb_strimwidth($r['error_message']??'',0,120,'...')) ?></td><td><?= e(date('d M Y H:i',strtotime($r['created_at']))) ?></td><td><form method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="_action" value="resend"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn-primary btn-sm" style="padding:2px 8px; font-size:12px;">Resend</button></form></td></tr><?php endforeach;?></tbody></table></div>
<?php include __DIR__.'/includes/footer.php'; ?>

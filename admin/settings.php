<?php require_once dirname(__DIR__).'/includes/auth.php'; require_login();
$keys=['site_name','site_title','contact_phone','contact_email','admin_email','contact_address','facebook_url','twitter_url','instagram_url','smtp_host','smtp_auth','smtp_user','smtp_pass','smtp_secure','smtp_port','smtp_from_email','smtp_from_name'];
if($_SERVER['REQUEST_METHOD']==='POST'){ if(verify_csrf($_POST['csrf_token']??'')){ foreach($keys as $k) setSetting($k,$_POST[$k]??''); $_SESSION['flash']='Settings saved.'; } else $_SESSION['flash_err']='Invalid token.'; redirect('settings.php'); }
$pageTitle='Settings / Mailing'; include __DIR__.'/includes/header.php'; $flash=$_SESSION['flash']??'';$err=$_SESSION['flash_err']??'';unset($_SESSION['flash'],$_SESSION['flash_err']); ?>
<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif;?><?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif;?>
<form method="post" class="panel resource-form"><?= csrf_field() ?><h3>Site Contact & Mailing Settings</h3><div class="form-grid">
<?php foreach($keys as $k):?><div class="form-field"><label><?= e(ucwords(str_replace('_',' ',$k))) ?></label><input type="<?= $k==='smtp_pass'?'password':'text' ?>" name="<?= e($k) ?>" value="<?= e(getSetting($k,'')) ?>"></div><?php endforeach;?></div><button class="btn-primary">Save Settings</button></form>
<?php include __DIR__.'/includes/footer.php'; ?>

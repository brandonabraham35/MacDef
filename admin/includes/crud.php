<?php
require_once dirname(__DIR__,2).'/includes/auth.php';
function crud_find($table,$id){ $st=db()->prepare("SELECT * FROM `$table` WHERE id=? LIMIT 1"); $st->execute([(int)$id]); return $st->fetch() ?: null; }
function crud_handle($cfg){
 require_login(); $pdo=db(); $table=$cfg['table']; $fields=$cfg['fields'];
 if($_SERVER['REQUEST_METHOD']==='POST'){
  if(!verify_csrf($_POST['csrf_token'] ?? '')){ $_SESSION['flash_err']='Invalid session token.'; redirect(basename($_SERVER['PHP_SELF'])); }
  $action=$_POST['_action']??'';
  if($action==='delete'){ $row=crud_find($table,(int)$_POST['id']); if($row){ foreach($fields as $f){ if(($f['type']??'')==='image' && !empty($row[$f['name']])) delete_upload($row[$f['name']]); } $pdo->prepare("DELETE FROM `$table` WHERE id=?")->execute([(int)$_POST['id']]); $_SESSION['flash']=$cfg['singular'].' deleted.';} redirect(basename($_SERVER['PHP_SELF'])); }
  $id=(int)($_POST['id']??0); $existing=$id?crud_find($table,$id):null; $cols=[]; $errors=[];
  foreach($fields as $f){ $n=$f['name']; $type=$f['type']??'text'; if($type==='image'){
    if(!empty($_FILES[$n]['name'])){ $up=handle_upload($_FILES[$n],'image'); if(!$up['ok']){$errors[]=$up['error'];} else { if($existing && !empty($existing[$n])) delete_upload($existing[$n]); $cols[$n]=$up['path']; } }
    elseif($existing){ $cols[$n]=$existing[$n]; } else $cols[$n]=null;
    if(!empty($f['required']) && empty($cols[$n])) $errors[]=$f['label'].' is required.'; continue;
  }
  if($type==='checkbox'){ $cols[$n]=isset($_POST[$n])?1:0; continue; }
  $val=clean($_POST[$n]??''); if(!empty($f['required']) && $val==='') $errors[]=$f['label'].' is required.'; if($type==='number') $val=$val===''?0:(int)$val; $cols[$n]=$val;
  }
  if($errors){ $_SESSION['flash_err']=implode(' ',$errors); redirect(basename($_SERVER['PHP_SELF']).($id?'?edit='.$id:'?new=1')); }
  if($existing){ $set=implode(', ',array_map(fn($c)=>"`$c`=?",array_keys($cols))); $p=array_values($cols); $p[]=$id; $pdo->prepare("UPDATE `$table` SET $set WHERE id=?")->execute($p); $_SESSION['flash']=$cfg['singular'].' updated.'; }
  else { $names=implode(', ',array_map(fn($c)=>"`$c`",array_keys($cols))); $ph=implode(',',array_fill(0,count($cols),'?')); $pdo->prepare("INSERT INTO `$table`($names) VALUES($ph)")->execute(array_values($cols)); $_SESSION['flash']=$cfg['singular'].' created.'; }
  redirect(basename($_SERVER['PHP_SELF']));
 }}
function crud_render($cfg){ $pdo=db(); $table=$cfg['table']; $fields=$cfg['fields']; $self=basename($_SERVER['PHP_SELF']); $edit=!empty($_GET['edit'])?crud_find($table,(int)$_GET['edit']):null; $show=$edit||isset($_GET['new']); $rows=$pdo->query("SELECT * FROM `$table` ORDER BY ".($cfg['order']??'id DESC'))->fetchAll(); $flash=$_SESSION['flash']??''; $err=$_SESSION['flash_err']??''; unset($_SESSION['flash'],$_SESSION['flash_err']); ?>
<?php if($flash):?><div class="flash ok"><?= e($flash) ?></div><?php endif; ?><?php if($err):?><div class="flash err"><?= e($err) ?></div><?php endif; ?>
<div class="content-head"><h2><?= e($cfg['title']) ?></h2><a class="btn-primary" href="?new=1">+ Add <?= e($cfg['singular']) ?></a></div>
<?php if($show):?><form class="resource-form" method="post" enctype="multipart/form-data"><?= csrf_field() ?><input type="hidden" name="_action" value="<?= $edit?'update':'create' ?>"><?php if($edit):?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?><h3><?= $edit?'Edit':'New' ?> <?= e($cfg['singular']) ?></h3>
<?php foreach($fields as $f): $n=$f['name']; $v=$edit[$n]??''; ?><div class="form-field"><label><?= e($f['label']) ?></label>
<?php if(($f['type']??'text')==='textarea'):?><textarea name="<?= e($n) ?>" rows="5"><?= e($v) ?></textarea>
<?php elseif(($f['type']??'text')==='checkbox'):?><label><input type="checkbox" name="<?= e($n) ?>" <?= $v?'checked':'' ?>> Active</label>
<?php elseif(($f['type']??'text')==='image'):?><?php if($v):?><div><img src="../<?= e($v) ?>" style="max-height:80px;border-radius:8px"></div><?php endif; ?><input type="file" name="<?= e($n) ?>" accept="image/*">
<?php else:?><input type="<?= e($f['type']??'text') ?>" name="<?= e($n) ?>" value="<?= e($v) ?>">
<?php endif;?></div><?php endforeach;?><button class="btn-primary" type="submit">Save</button> <a class="btn-ghost" href="<?= e($self) ?>">Cancel</a></form><?php endif; ?>
<div class="panel"><table class="data-table"><thead><tr><?php foreach($fields as $f): if(!empty($f['list'])):?><th><?= e($f['label']) ?></th><?php endif; endforeach;?><th>Actions</th></tr></thead><tbody><?php if(!$rows):?><tr><td colspan="8" class="empty">No records yet.</td></tr><?php endif; foreach($rows as $r):?><tr><?php foreach($fields as $f): if(!empty($f['list'])): $n=$f['name']; ?><td><?php if(($f['type']??'')==='image' && !empty($r[$n])):?><img src="../<?= e($r[$n]) ?>" style="height:50px;border-radius:6px"><?php else:?><?= e(mb_strimwidth((string)($r[$n]??''),0,80,'...')) ?><?php endif;?></td><?php endif; endforeach;?><td><a href="?edit=<?= (int)$r['id'] ?>">Edit</a> <form method="post" class="confirm-delete" style="display:inline"><?= csrf_field() ?><input type="hidden" name="_action" value="delete"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="link-danger" type="submit">Delete</button></form></td></tr><?php endforeach;?></tbody></table></div><?php }
?>

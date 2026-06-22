<?php
function sanitize($data){ return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8'); }
function clean($data){ return trim((string)$data); }
function e($data){ return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8'); }
function redirect($url){ header('Location: '.$url); exit(); }
function csrf_token(){ if(session_status()===PHP_SESSION_NONE) session_start(); if(empty($_SESSION['csrf_token'])) $_SESSION['csrf_token']=bin2hex(random_bytes(32)); return $_SESSION['csrf_token']; }
function csrf_field(){ return '<input type="hidden" name="csrf_token" value="'.e(csrf_token()).'">'; }
function verify_csrf($t){ return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$t); }
function count_rows($table){ try{return (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();}catch(Exception $e){return 0;} }
function formatDate($date){ return $date ? date('F j, Y', strtotime($date)) : ''; }
function slugify($text){ $text=preg_replace('~[^\pL\d]+~u','-',trim($text)); $text=iconv('utf-8','us-ascii//TRANSLIT',$text); $text=preg_replace('~[^-\w]+~','',$text); $text=trim($text,'-'); $text=preg_replace('~-+~','-',$text); return strtolower($text ?: 'item'); }
function handle_upload($file, $kind='image'){
    if(!isset($file)||$file['error']!==UPLOAD_ERR_OK) return ['ok'=>false,'error'=>'No valid file was uploaded.'];
    $allowed = $kind==='document' ? ['pdf','doc','docx'] : ['jpg','jpeg','png','gif','webp'];
    $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION)); if(!in_array($ext,$allowed,true)) return ['ok'=>false,'error'=>'Invalid file type.'];
    if($file['size']>8*1024*1024) return ['ok'=>false,'error'=>'File is too large. Maximum 8MB.'];
    if($kind==='image' && getimagesize($file['tmp_name'])===false) return ['ok'=>false,'error'=>'File is not a valid image.'];
    $dir = $kind==='document' ? 'uploads/documents/' : 'uploads/images/';
    if(strpos($_SERVER['SCRIPT_NAME'] ?? '', '/admin/')!==false) $base=dirname(__DIR__); else $base=__DIR__.'/..';
    $abs=rtrim($base, '/\\').'/'.$dir; if(!is_dir($abs)) mkdir($abs,0755,true);
    $name=date('YmdHis').'-'.bin2hex(random_bytes(4)).'.'.$ext; $absfile=$abs.$name;
    if(move_uploaded_file($file['tmp_name'],$absfile)) return ['ok'=>true,'path'=>$dir.$name];
    return ['ok'=>false,'error'=>'Upload failed.'];
}
function delete_upload($path){ $abs=BASE_PATH.'/'.ltrim($path,'/'); if(is_file($abs)) @unlink($abs); }
?>
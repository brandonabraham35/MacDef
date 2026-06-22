<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php'; require_once __DIR__ . '/functions.php';
function current_admin(){ return $_SESSION['admin'] ?? null; }
function require_login(){ if(empty($_SESSION['admin'])) redirect('login.php'); }
function login_admin($email,$password){ $stmt=db()->prepare('SELECT * FROM users WHERE email=? AND role="admin" LIMIT 1'); $stmt->execute([$email]); $u=$stmt->fetch(); if($u && password_verify($password,$u['password'])){ $_SESSION['admin']=['id'=>$u['id'],'name'=>$u['full_name'],'email'=>$u['email']]; return true;} return false; }
?>
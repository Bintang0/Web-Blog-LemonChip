<?php 
session_start();
require 'functions.php';

// Ambil ID user sebelum logout
$UserId = $_SESSION['UserId'] ?? 'Unknown';
$ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

// Tulis log aktivitas logout
writeLog("UserID $UserId telah logout", "INFO");

// Hapus sesi
$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke halaman utama
header('Location: index.php');
exit;

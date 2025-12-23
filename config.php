<?php
declare(strict_types=1);

// Database configuration
const DB_HOST = 'localhost';
const DB_NAME = 'u282649697_iskcon_db';
const DB_USER = 'u282649697_krsnasonuyadav';
const DB_PASS = 'Krishna.radha@burla@iskcon.094';

// App settings
const APP_NAME = 'ISKCON Portal';
const BASE_URL = '/';

// Session configuration
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
ini_set('session.cookie_samesite', 'Lax');

if (session_status() === PHP_SESSION_NONE) {
  session_name('ISKCONSESSID');
  session_start();
}

function get_db_connection(): PDO {
  static $pdo = null;
  if ($pdo === null) {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
  }
  return $pdo;
} 
<?php
require_once __DIR__ . '/../config.php';
$db = get_db_connection();
$username = 'admin';
$password = 'ChangeThis123!';
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $db->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
try {
  $stmt->execute([$username, $hash]);
  echo "Created admin user '$username' with password '$password'";
} catch (Throwable $e) {
  echo 'Failed: ' . $e->getMessage();
} 
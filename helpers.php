<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function generate_csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool {
  return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
}

function is_logged_in(): bool {
  return !empty($_SESSION['admin_user_id']);
}

function require_login(): void {
  if (!is_logged_in()) {
    header('Location: /admin/login.php');
    exit;
  }
}

function current_ip(): string {
  return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function is_login_locked(PDO $db): bool {
  $stmt = $db->query('SELECT locked_until FROM login_lockout WHERE id = 1');
  $row = $stmt->fetch();
  if (!$row) return false;
  if ($row['locked_until'] === null) return false;
  return strtotime($row['locked_until']) > time();
}

function record_login_attempt(PDO $db, bool $success): void {
  $db->prepare('INSERT INTO login_attempts (ip_address, attempted_at, was_successful) VALUES (?, NOW(), ?)')
     ->execute([current_ip(), $success ? 1 : 0]);

  try {
    $db->beginTransaction();
    $row = $db->query('SELECT fail_count, locked_until FROM login_lockout WHERE id = 1 FOR UPDATE')->fetch();
    if (!$row) {
      $db->prepare('INSERT INTO login_lockout (id, fail_count, locked_until) VALUES (1, 0, NULL)')->execute();
      $row = ['fail_count' => 0, 'locked_until' => null];
    }

    if ($success) {
      $db->prepare('UPDATE login_lockout SET fail_count = 0 WHERE id = 1')->execute();
      $db->commit();
      return;
    }

    if (!empty($row['locked_until']) && strtotime($row['locked_until']) > time()) {
      $db->commit();
      return;
    }

    $newCount = ((int)$row['fail_count']) + 1;
    if ($newCount >= 5) {
      $db->prepare('UPDATE login_lockout SET fail_count = 0, locked_until = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id = 1')->execute();
    } else {
      $db->prepare('UPDATE login_lockout SET fail_count = ? WHERE id = 1')->execute([$newCount]);
    }
    $db->commit();
  } catch (Throwable $e) {
    if ($db->inTransaction()) {
      $db->rollBack();
    }
    // swallow to not leak info on login route
  }
}

function sanitize_filename(string $name): string {
  $name = preg_replace('/[^A-Za-z0-9_\.-]/', '_', $name);
  return trim($name, '_');
}

function redirect_with_message(string $url, string $message, string $type = 'success'): void {
  $_SESSION['flash'] = ['message' => $message, 'type' => $type];
  header('Location: ' . $url);
  exit;
}

function get_and_clear_flash(): ?array {
  if (isset($_SESSION['flash'])) {
    $msg = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $msg;
  }
  return null;
} 
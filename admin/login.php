<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
$db = get_db_connection();

$flash = get_and_clear_flash();
$csrf = generate_csrf_token();
$locked = is_login_locked($db);
$security_code = '2200';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf'] ?? '')) {
    redirect_with_message('/admin/login.php', 'Invalid CSRF token.', 'error');
  }

  if ($locked) {
    redirect_with_message('/admin/login.php', 'Too many failed attempts. Login locked for 1 hour.', 'error');
  }

  $username = trim((string)($_POST['username'] ?? ''));
  $password = (string)($_POST['password'] ?? '');
  $code = trim((string)($_POST['code'] ?? ''));

  if ($code !== $security_code) {
    redirect_with_message('/admin/login.php', 'Invalid security code.', 'error');
  }

  $stmt = $db->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  $ok = $user && password_verify($password, $user['password_hash']);
  record_login_attempt($db, $ok);

  if ($ok) {
    session_regenerate_id(true);
    $_SESSION['admin_user_id'] = (int)$user['id'];
    $_SESSION['admin_username'] = $user['username'];
    redirect_with_message('/admin/dashboard.php', 'Welcome back, ' . htmlspecialchars($user['username']) . '.');
  } else {
    redirect_with_message('/admin/login.php', 'Invalid credentials.', 'error');
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login - ISKCON Portal</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <h2><i class="fas fa-shield-alt" style="color: var(--admin-primary); margin-right: 0.5rem;"></i>Admin Login</h2>
      <?php if ($locked): ?>
        <div class="alert error">Too many failed attempts. Login is locked for up to 1 hour.</div>
      <?php endif; ?>
      <?php if ($flash): ?>
        <div class="alert <?php echo $flash['type']; ?>" data-flash><?php echo htmlspecialchars($flash['message']); ?></div>
      <?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
        <div class="form-row">
          <label><i class="fas fa-user" style="margin-right: 0.5rem;"></i>Username</label>
          <input name="username" required autocomplete="username" placeholder="Enter your username" <?php echo $locked ? 'disabled' : ''; ?>>
        </div>
        <div class="form-row">
          <label><i class="fas fa-lock" style="margin-right: 0.5rem;"></i>Password</label>
          <input type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" <?php echo $locked ? 'disabled' : ''; ?>>
        </div>
        <div class="form-row">
          <label><i class="fas fa-key" style="margin-right: 0.5rem;"></i>Security Code</label>
          <input type="password" name="code" id="securityCode" inputmode="numeric" pattern="\d{4}" maxlength="4" placeholder="Enter 4-digit code" required <?php echo $locked ? 'disabled' : ''; ?>>
        </div>
        <button class="button" type="submit" id="loginButton" disabled>
          <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i>
          Login to Dashboard
        </button>
        <p id="codeHint" class="form-hint">
          <i class="fas fa-info-circle" style="margin-right: 0.25rem;"></i>
          Enter security code to enable login
        </p>
       </form>
    </div>
  </div>
     <script>
       document.addEventListener('DOMContentLoaded', function () {
         var codeInput = document.getElementById('securityCode');
         var loginBtn = document.getElementById('loginButton');
         var hint = document.getElementById('codeHint');
         if (!codeInput || !loginBtn) return;
 
         function updateButtonState() {
           var isValid = codeInput.value.trim() === '2200';
           var isLocked = codeInput.disabled;
           loginBtn.disabled = !isValid || isLocked;
           if (hint) {
             hint.style.display = (!isLocked && !isValid) ? 'block' : 'none';
           }
         }
 
         codeInput.addEventListener('input', updateButtonState);
         updateButtonState();
       });
    </script>
    <script src="/assets/js/admin.js"></script>
    <script>
      // Enhanced login page interactions
      document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
          input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
          });
          input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
          });
        });

        // Add typing animation to security code
        const codeInput = document.getElementById('securityCode');
        codeInput.addEventListener('input', function() {
          this.style.letterSpacing = '0.5rem';
          setTimeout(() => {
            this.style.letterSpacing = 'normal';
          }, 200);
        });
      });
   </body>
   </html>

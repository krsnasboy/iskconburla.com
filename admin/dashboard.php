<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();
$flash = get_and_clear_flash();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - ISKCON Portal</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
</head>
<body>
<style>
    :root {
      --admin-primary: #6a3093;
      --admin-primary-rgb: 106, 48, 147;
      --admin-primary-dark: #4a1d6b;
      --admin-secondary: #a569bd;
      --admin-success: #27ae60;
      --admin-success-dark: #1e8449;
      --admin-danger: #e74c3c;
      --admin-danger-dark: #c0392b;
      --admin-warning: #f39c12;
      --admin-warning-dark: #d35400;
      --admin-info: #3498db;
      --admin-info-dark: #2980b9;
      --admin-gray-100: #f8f9fa;
      --admin-gray-200: #e9ecef;
      --admin-gray-300: #dee2e6;
      --admin-gray-400: #ced4da;
      --admin-gray-500: #adb5bd;
      --admin-gray-600: #6c757d;
      --admin-gray-700: #495057;
      --admin-gray-800: #343a40;
      --admin-gray-900: #212529;
      --admin-radius: 0.375rem;
      --admin-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --admin-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      --admin-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --admin-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --admin-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      --admin-shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
      line-height: 1.5;
      color: var(--admin-gray-800);
      background-color: var(--admin-gray-100);
      font-size: 16px;
    }

    header {
      background-color: white;
      box-shadow: var(--admin-shadow-sm);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
    }

    nav {
      display: flex;
      align-items: center;
      padding: 1rem 0;
    }

    .admin-nav-toggle {
      background: none;
      border: none;
      color: var(--admin-gray-600);
      font-size: 1.25rem;
      cursor: pointer;
      display: none;
      padding: 0.5rem;
    }

    .admin-nav-links {
      display: flex;
      gap: 1rem;
      align-items: center;
      flex-wrap: wrap;
    }

    .admin-nav-links a {
      color: var(--admin-gray-700);
      text-decoration: none;
      font-weight: 500;
      padding: 0.5rem;
      border-radius: var(--admin-radius);
      transition: all 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .admin-nav-links a:hover {
      color: var(--admin-primary);
      background-color: var(--admin-gray-200);
    }

    .admin-nav-links a i {
      font-size: 0.9em;
    }

    main {
      padding: 1.5rem 0 3rem;
      min-height: calc(100vh - 60px);
    }

    h2, h3, h4 {
      color: var(--admin-gray-800);
      margin-bottom: 1rem;
      font-weight: 600;
    }

    h2 {
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
    }

    h3 {
      font-size: 1.5rem;
    }

    h4 {
      font-size: 1.25rem;
    }

    .alert {
      padding: 1rem;
      border-radius: var(--admin-radius);
      margin-bottom: 1.5rem;
      font-weight: 500;
    }

    .alert.error {
      background-color: #fdecea;
      color: var(--admin-danger-dark);
      border-left: 4px solid var(--admin-danger);
    }

    .alert.success {
      background-color: #e8f5e9;
      color: var(--admin-success-dark);
      border-left: 4px solid var(--admin-success);
    }

    .grid {
      display: grid;
      gap: 1.5rem;
    }

    .grid-3 {
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .dashboard-card {
      background-color: white;
      border-radius: var(--admin-radius);
      box-shadow: var(--admin-shadow);
      padding: 1.5rem;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--admin-shadow-lg);
    }

    .dashboard-card h3 {
      font-size: 1.25rem;
      margin: 1rem 0;
      color: var(--admin-gray-800);
    }

    .dashboard-card p {
      color: var(--admin-gray-600);
      margin-bottom: 1.5rem;
      flex-grow: 1;
    }

    .dashboard-card .button {
      align-self: flex-start;
      margin-top: auto;
    }

    .button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1.5rem;
      background-color: var(--admin-primary);
      color: white;
      border: none;
      border-radius: var(--admin-radius);
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
      font-size: 1rem;
      text-decoration: none;
    }

    .button:hover {
      background-color: var(--admin-primary-dark);
      transform: translateY(-1px);
      box-shadow: var(--admin-shadow-md);
    }

    @media (max-width: 768px) {
      .admin-nav-toggle {
        display: block;
      }

      .admin-nav-links {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        padding: 1rem;
        box-shadow: var(--admin-shadow-md);
      }

      .admin-nav-links[aria-expanded="true"] {
        display: flex;
      }

      .admin-nav-links a {
        width: 100%;
        padding: 0.75rem;
      }

      h2 {
        font-size: 1.5rem;
      }

      h3 {
        font-size: 1.25rem;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 0 0.75rem;
      }

      .grid-3 {
        grid-template-columns: 1fr;
      }

      .dashboard-card {
        padding: 1.25rem;
      }

      .button {
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
      }
    }
  </style>
<header>
  <div class="container">
    <nav>
      <button class="admin-nav-toggle" aria-expanded="false" aria-controls="adminNavLinks" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div id="adminNavLinks" class="admin-nav-links">
        <a href="/admin/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="/admin/events.php"><i class="fas fa-calendar-alt"></i> Events</a>
        <a href="/admin/darshan.php"><i class="fas fa-images"></i> Daily Darshan</a>
        <a href="/admin/services.php"><i class="fas fa-hands-helping"></i> Services</a>
        <span style="margin-left:auto"></span>
        <a href="/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?>)</a>
      </div>
    </nav>
  </div>
</header>
<main>
  <div class="container">
    <h2><i class="fas fa-user-circle" style="color: var(--admin-primary); margin-right: 0.75rem;"></i>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?></h2>
    <?php if ($flash): ?>
      <div class="alert <?php echo $flash['type']; ?>" data-flash><?php echo htmlspecialchars($flash['message']); ?></div>
    <?php endif; ?>
    <div class="grid grid-3">
      <div class="dashboard-card">
        <div style="background: linear-gradient(135deg, var(--admin-info), var(--admin-info-dark)); color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; box-shadow: var(--admin-shadow-lg);">
          <i class="fas fa-calendar-alt"></i>
        </div>
        <h3>Manage Events</h3>
        <p>Create and edit upcoming events with timelines and descriptions.</p>
        <a class="button" href="/admin/events.php">
          <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
          Open Events
        </a>
      </div>
      <div class="dashboard-card">
        <div style="background: linear-gradient(135deg, var(--admin-success), var(--admin-success-dark)); color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; box-shadow: var(--admin-shadow-lg);">
          <i class="fas fa-images"></i>
        </div>
        <h3>Manage Daily Darshan</h3>
        <p>Upload temple images and manage the daily darshan gallery.</p>
        <a class="button" href="/admin/darshan.php">
          <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
          Open Gallery
        </a>
      </div>
      <div class="dashboard-card">
        <div style="background: linear-gradient(135deg, var(--admin-warning), var(--admin-warning-dark)); color: white; width: 4rem; height: 4rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; box-shadow: var(--admin-shadow-lg);">
          <i class="fas fa-hands-helping"></i>
        </div>
        <h3>Manage Services</h3>
        <p>Create spiritual services and view devotee registrations.</p>
        <a class="button" href="/admin/services.php">
          <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
          Open Services
        </a>
      </div>
    </div>
  </div>
</main>
<script src="/assets/js/admin.js"></script>
<script>
// Dashboard-specific enhancements
document.addEventListener('DOMContentLoaded', function() {
  // Add click animations to dashboard cards
  const dashboardCards = document.querySelectorAll('.dashboard-card');
  dashboardCards.forEach(card => {
    card.addEventListener('click', function(e) {
      if (e.target.tagName !== 'A') {
        const link = this.querySelector('a.button');
        if (link) {
          link.click();
        }
      }
    });

    // Add pulse effect
    card.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  });
});
</script>
</body>
</html>

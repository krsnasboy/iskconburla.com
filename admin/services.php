<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();
$db = get_db_connection();
$flash = get_and_clear_flash();
$csrf = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf'] ?? '')) {
    redirect_with_message('/admin/services.php', 'Invalid CSRF token.', 'error');
  }
  $action = $_POST['action'] ?? '';
  if ($action === 'create') {
    $title = trim((string)($_POST['title'] ?? ''));
    $reqs = trim((string)($_POST['requirements'] ?? ''));
    $desc = trim((string)($_POST['short_description'] ?? ''));
    if ($title === '' || $reqs === '' || $desc === '') {
      redirect_with_message('/admin/services.php', 'All fields are required.', 'error');
    }
    $stmt = $db->prepare('INSERT INTO services (title, requirements, short_description) VALUES (?, ?, ?)');
    $stmt->execute([$title, $reqs, $desc]);
    redirect_with_message('/admin/services.php', 'Service created.');
  } elseif ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
      $db->prepare('DELETE FROM services WHERE id = ?')->execute([$id]);
      redirect_with_message('/admin/services.php', 'Service deleted.');
    }
  }
}

$services = $db->query('SELECT id, title, requirements, short_description, created_at FROM services ORDER BY id DESC')->fetchAll();
$registrations = $db->query('SELECT r.id, r.full_name, r.phone, r.notes, r.registered_at, s.title AS service_title FROM service_registrations r JOIN services s ON r.service_id = s.id ORDER BY r.id DESC LIMIT 200')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Services - Admin</title>

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

    .card {
      background-color: white;
      border-radius: var(--admin-radius);
      box-shadow: var(--admin-shadow);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
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

    .form-row {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--admin-gray-700);
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid var(--admin-gray-300);
      border-radius: var(--admin-radius);
      font-size: 1rem;
      transition: border-color 0.2s;
    }

    input[type="text"]:focus,
    textarea:focus {
      outline: none;
      border-color: var(--admin-primary);
      box-shadow: 0 0 0 3px rgba(var(--admin-primary-rgb), 0.1);
    }

    textarea {
      min-height: 100px;
      resize: vertical;
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
    }

    .button:hover {
      background-color: var(--admin-primary-dark);
      transform: translateY(-1px);
      box-shadow: var(--admin-shadow-md);
    }

    .button.danger {
      background-color: var(--admin-danger);
    }

    .button.danger:hover {
      background-color: var(--admin-danger-dark);
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: var(--admin-radius);
      overflow: hidden;
      box-shadow: var(--admin-shadow);
      margin-bottom: 1.5rem;
    }

    .table th,
    .table td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid var(--admin-gray-200);
    }

    .table th {
      background-color: var(--admin-gray-100);
      font-weight: 600;
      color: var(--admin-gray-700);
    }

    .table tr:last-child td {
      border-bottom: none;
    }

    .table tr:hover {
      background-color: var(--admin-gray-100);
    }

    .registration-tooltip {
      position: absolute;
      background: white;
      border: 1px solid var(--admin-gray-200);
      border-radius: var(--admin-radius);
      padding: 1rem;
      box-shadow: var(--admin-shadow-lg);
      z-index: 1000;
      max-width: 300px;
      font-size: 0.875rem;
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

      .table {
        display: block;
        overflow-x: auto;
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

      .card {
        padding: 1rem;
      }

      .button {
        padding: 0.625rem 1.25rem;
        font-size: 0.9375rem;
      }

      .table th,
      .table td {
        padding: 0.75rem;
        display: block;
        text-align: right;
      }

      .table td::before {
        content: attr(data-label);
        float: left;
        font-weight: 600;
        color: var(--admin-gray-600);
      }

      .table tr {
        display: block;
        margin-bottom: 1rem;
        border-bottom: 2px solid var(--admin-gray-200);
      }

      .table thead {
        display: none;
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
        <a href="/admin/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
    </nav>
  </div>
</header>
<main>
  <div class="container">
    <h2><i class="fas fa-hands-helping" style="color: var(--admin-primary); margin-right: 0.75rem;"></i>Services Management</h2>
    <?php if ($flash): ?>
      <div class="alert <?php echo $flash['type']; ?>" data-flash><?php echo htmlspecialchars($flash['message']); ?></div>
    <?php endif; ?>

    <div class="card">
      <h3><i class="fas fa-plus-circle" style="color: var(--admin-success); margin-right: 0.5rem;"></i>Create New Service</h3>
      <form method="post">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="create">
        <div class="form-row">
          <label><i class="fas fa-heading" style="margin-right: 0.5rem;"></i>Service Title</label>
          <input name="title" required maxlength="200" placeholder="Enter service title...">
        </div>
        <div class="form-row">
          <label><i class="fas fa-clipboard-list" style="margin-right: 0.5rem;"></i>Requirements</label>
          <textarea name="requirements" rows="3" required maxlength="500" placeholder="List the requirements for this service..."></textarea>
        </div>
        <div class="form-row">
          <label><i class="fas fa-align-left" style="margin-right: 0.5rem;"></i>Description</label>
          <textarea name="short_description" rows="3" required maxlength="500" placeholder="Describe the service in detail..."></textarea>
        </div>
        <button class="button" type="submit">
          <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
          Create Service
        </button>
      </form>
    </div>

    <h3 style="margin-top:3rem; color: var(--admin-gray-800);"><i class="fas fa-list" style="margin-right: 0.5rem;"></i>Existing Services</h3>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Requirements</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($services as $sv): ?>
          <tr>
            <td data-label="Title"><?php echo htmlspecialchars($sv['title']); ?></td>
            <td data-label="Requirements"><?php echo htmlspecialchars($sv['requirements']); ?></td>
            <td data-label="Description"><?php echo htmlspecialchars($sv['short_description']); ?></td>
            <td data-label="Actions">
              <form method="post" onsubmit="return confirm('Delete this service?');">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo (int)$sv['id']; ?>">
                <button class="button danger" type="submit">
                  <i class="fas fa-trash" style="margin-right: 0.5rem;"></i>
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
          <tr><td colspan="4" style="text-align: center; padding: 2rem; color: var(--admin-gray-500);">
            <i class="fas fa-hands-helping" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3; display: block;"></i>
            No services created yet
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <h3 style="margin-top:3rem; color: var(--admin-gray-800);"><i class="fas fa-users" style="margin-right: 0.5rem;"></i>Recent Registrations</h3>
    <table class="table">
      <thead>
        <tr>
          <th>Service</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Notes</th>
          <th>At</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($registrations as $r): ?>
          <tr>
            <td data-label="Service"><?php echo htmlspecialchars($r['service_title']); ?></td>
            <td data-label="Name"><?php echo htmlspecialchars($r['full_name']); ?></td>
            <td data-label="Phone"><?php echo htmlspecialchars($r['phone'] ?? ''); ?></td>
            <td data-label="Notes"><?php echo htmlspecialchars($r['notes'] ?? ''); ?></td>
            <td data-label="At"><?php echo htmlspecialchars($r['registered_at']); ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($registrations)): ?>
          <tr><td colspan="5" style="text-align: center; padding: 2rem; color: var(--admin-gray-500);">
            <i class="fas fa-users" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.3; display: block;"></i>
            No registrations received yet
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
<script src="/assets/js/admin.js"></script>
<script>
// Services page specific enhancements
document.addEventListener('DOMContentLoaded', function() {
  // Enhanced table interactions
  const registrationRows = document.querySelectorAll('.table tbody tr');
  registrationRows.forEach(row => {
    row.addEventListener('click', function() {
      // Highlight clicked row
      registrationRows.forEach(r => r.classList.remove('selected'));
      this.classList.add('selected');

      // Show details in a tooltip
      const name = this.cells[1].textContent;
      const service = this.cells[0].textContent;
      const phone = this.cells[2].textContent;
      const notes = this.cells[3].textContent;

      showRegistrationDetails(this, {name, service, phone, notes});
    });
  });

  // Auto-resize textareas
  const textareas = document.querySelectorAll('textarea');
  textareas.forEach(textarea => {
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });
  });

  // Search functionality
  addSearchToTable();
});

function showRegistrationDetails(row, data) {
  // Remove existing tooltips
  document.querySelectorAll('.registration-tooltip').forEach(t => t.remove());

  if (!data.name) return;

  const tooltip = document.createElement('div');
  tooltip.className = 'registration-tooltip';
  tooltip.style.cssText = `
    position: absolute;
    background: white;
    border: 1px solid var(--admin-gray-200);
    border-radius: var(--admin-radius);
    padding: 1rem;
    box-shadow: var(--admin-shadow-lg);
    z-index: 1000;
    max-width: 300px;
    font-size: 0.875rem;
  `;

  tooltip.innerHTML = `
    <div style="font-weight: 600; margin-bottom: 0.5rem; color: var(--admin-primary);">
      ${data.name}
    </div>
    <div style="margin-bottom: 0.25rem;"><strong>Service:</strong> ${data.service}</div>
    ${data.phone ? `<div style="margin-bottom: 0.25rem;"><strong>Phone:</strong> ${data.phone}</div>` : ''}
    ${data.notes ? `<div><strong>Notes:</strong> ${data.notes}</div>` : ''}
  `;

  document.body.appendChild(tooltip);

  const rect = row.getBoundingClientRect();
  tooltip.style.left = (rect.right + 10) + 'px';
  tooltip.style.top = rect.top + 'px';

  // Remove tooltip after 3 seconds or on click elsewhere
  setTimeout(() => tooltip.remove(), 3000);
  document.addEventListener('click', () => tooltip.remove(), {once: true});
}

function addSearchToTable() {
  const table = document.querySelector('.table');
  if (!table) return;

  const searchContainer = document.createElement('div');
  searchContainer.style.cssText = `
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  `;

  const searchInput = document.createElement('input');
  searchInput.type = 'text';
  searchInput.placeholder = 'Search registrations...';
  searchInput.style.cssText = `
    flex: 1;
    padding: 0.5rem 1rem;
    border: 2px solid var(--admin-gray-200);
    border-radius: var(--admin-radius);
    font-size: 0.875rem;
  `;

  const searchIcon = document.createElement('i');
  searchIcon.className = 'fas fa-search';
  searchIcon.style.color = 'var(--admin-gray-400)';

  searchContainer.appendChild(searchIcon);
  searchContainer.appendChild(searchInput);
  table.parentElement.insertBefore(searchContainer, table);

  searchInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    const rows = table.querySelectorAll('tbody tr');

    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(query) ? '' : 'none';
    });
  });
}

// Add selected row styling
const style = document.createElement('style');
style.textContent = `
  .table tbody tr.selected {
    background-color: rgba(var(--admin-primary-rgb), 0.1) !important;
    transform: scale(1.01);
  }
`;
document.head.appendChild(style);
</script>
</body>
</html>

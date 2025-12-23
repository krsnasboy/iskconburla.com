<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();
$db = get_db_connection();
$flash = get_and_clear_flash();
$csrf = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf'] ?? '')) {
    redirect_with_message('/admin/events.php', 'Invalid CSRF token.', 'error');
  }
  $action = $_POST['action'] ?? '';
  if ($action === 'create') {
    $title = trim((string)($_POST['title'] ?? ''));
    $desc = trim((string)($_POST['short_description'] ?? ''));
    $datetime = trim((string)($_POST['event_datetime'] ?? ''));
    if ($title === '' || $desc === '' || $datetime === '') {
      redirect_with_message('/admin/events.php', 'All fields are required.', 'error');
    }
    $stmt = $db->prepare('INSERT INTO events (title, short_description, event_datetime) VALUES (?, ?, ?)');
    $stmt->execute([$title, $desc, $datetime]);
    $eventId = (int)$db->lastInsertId();

    // Insert optional timelines provided in the create form
    $timeLabels = isset($_POST['tl_time_label']) && is_array($_POST['tl_time_label']) ? $_POST['tl_time_label'] : [];
    $tlTitles   = isset($_POST['tl_title']) && is_array($_POST['tl_title']) ? $_POST['tl_title'] : [];
    $positions  = isset($_POST['tl_position']) && is_array($_POST['tl_position']) ? $_POST['tl_position'] : [];
    if (!empty($timeLabels) && !empty($tlTitles)) {
      $ins = $db->prepare('INSERT INTO event_timelines (event_id, time_label, title, position) VALUES (?, ?, ?, ?)');
      $count = max(count($timeLabels), count($tlTitles));
      for ($i = 0; $i < $count; $i++) {
        $tl = trim((string)($timeLabels[$i] ?? ''));
        $tt = trim((string)($tlTitles[$i] ?? ''));
        $pos = (int)($positions[$i] ?? 0);
        if ($tl !== '' && $tt !== '') {
          $ins->execute([$eventId, $tl, $tt, $pos]);
        }
      }
    }

    redirect_with_message('/admin/events.php', 'Event created.');
  } elseif ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
      $db->prepare('DELETE FROM events WHERE id = ?')->execute([$id]);
      redirect_with_message('/admin/events.php', 'Event deleted.');
    }
  } elseif ($action === 'add_timeline') {
    $eventId = (int)($_POST['event_id'] ?? 0);
    $timeLabel = trim((string)($_POST['time_label'] ?? ''));
    $title = trim((string)($_POST['timeline_title'] ?? ''));
    if ($eventId <= 0 || $timeLabel === '' || $title === '') {
      redirect_with_message('/admin/events.php', 'Timeline fields are required.', 'error');
    }
    $pos = (int)($_POST['position'] ?? 0);
    $stmt = $db->prepare('INSERT INTO event_timelines (event_id, time_label, title, position) VALUES (?, ?, ?, ?)');
    $stmt->execute([$eventId, $timeLabel, $title, $pos]);
    redirect_with_message('/admin/events.php', 'Timeline item added.');
  } elseif ($action === 'delete_timeline') {
    $id = (int)($_POST['timeline_id'] ?? 0);
    if ($id > 0) {
      $db->prepare('DELETE FROM event_timelines WHERE id = ?')->execute([$id]);
      redirect_with_message('/admin/events.php', 'Timeline item deleted.');
    }
  }
}

$events = $db->query('SELECT id, title, short_description, event_datetime FROM events ORDER BY event_datetime DESC')->fetchAll();

// Fetch timelines grouped by event
$timelinesByEvent = [];
if (!empty($events)) {
  $ids = array_map(fn($e) => (int)$e['id'], $events);
  $in = implode(',', array_fill(0, count($ids), '?'));
  $stmt = $db->prepare("SELECT id, event_id, time_label, title, position FROM event_timelines WHERE event_id IN ($in) ORDER BY position ASC, id ASC");
  $stmt->execute($ids);
  while ($row = $stmt->fetch()) {
    $timelinesByEvent[(int)$row['event_id']][] = $row;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Events - Admin</title>

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
    input[type="datetime-local"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid var(--admin-gray-300);
      border-radius: var(--admin-radius);
      font-size: 1rem;
      transition: border-color 0.2s;
    }

    input[type="text"]:focus,
    input[type="datetime-local"]:focus,
    input[type="number"]:focus,
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

    .button.secondary {
      background-color: var(--admin-gray-200);
      color: var(--admin-gray-700);
    }

    .button.secondary:hover {
      background-color: var(--admin-gray-300);
    }

    .button.danger {
      background-color: var(--admin-danger);
    }

    .button.danger:hover {
      background-color: var(--admin-danger-dark);
    }

    .grid {
      display: grid;
      gap: 1rem;
    }

    .grid-2 {
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .timeline-row {
      padding: 1rem;
      border: 1px solid var(--admin-gray-200);
      border-radius: var(--admin-radius);
      position: relative;
    }

    .remove-timeline {
      width: 100%;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      border-radius: var(--admin-radius);
      overflow: hidden;
      box-shadow: var(--admin-shadow);
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

    .table ul {
      margin: 0;
      padding-left: 1rem;
    }

    .table li {
      margin-bottom: 0.5rem;
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
    <h2><i class="fas fa-calendar-alt" style="color: var(--admin-primary); margin-right: 0.75rem;"></i>Events Management</h2>
    <?php if ($flash): ?>
      <div class="alert <?php echo $flash['type']; ?>" data-flash><?php echo htmlspecialchars($flash['message']); ?></div>
    <?php endif; ?>

    <div class="card">
      <h3><i class="fas fa-plus-circle" style="color: var(--admin-success); margin-right: 0.5rem;"></i>Create New Event</h3>
      <form method="post" id="create-event-form">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="create">
        <div class="form-row">
          <label><i class="fas fa-heading" style="margin-right: 0.5rem;"></i>Event Title</label>
          <input name="title" required maxlength="200" placeholder="Enter event title...">
        </div>
        <div class="form-row">
          <label><i class="fas fa-align-left" style="margin-right: 0.5rem;"></i>Short Description</label>
          <textarea name="short_description" rows="3" required maxlength="500" placeholder="Describe the event..."></textarea>
        </div>
        <div class="form-row">
          <label><i class="fas fa-clock" style="margin-right: 0.5rem;"></i>Date & Time</label>
          <input type="datetime-local" name="event_datetime" required>
        </div>
        <h4 style="margin-top:2rem; color: var(--admin-gray-700);"><i class="fas fa-list-ol" style="margin-right: 0.5rem;"></i>Event Timeline (optional)</h4>
        <p style="margin:0.5rem 0 1rem 0; color: var(--admin-gray-500); font-size: 0.875rem;"><i class="fas fa-info-circle" style="margin-right: 0.25rem;"></i>Add timeline items for detailed event schedule. Positions auto-adjust.</p>
        <div id="timeline-rows" class="grid grid-2">
          <div class="card timeline-row">
            <div class="form-row">
              <label>Time label</label>
              <input name="tl_time_label[]" placeholder="10:00 pm">
            </div>
            <div class="form-row">
              <label>Title</label>
              <input name="tl_title[]" placeholder="Mahaabhishek">
            </div>
            <div class="form-row">
              <label>Position</label>
              <input type="number" name="tl_position[]" value="0" readonly>
            </div>
            <button type="button" class="button secondary remove-timeline" style="margin-top:8px; display:none;">Remove</button>
          </div>
        </div>
        <div class="form-row">
          <button type="button" class="button secondary" id="add-timeline">
            <i class="fas fa-plus" style="margin-right: 0.5rem;"></i>
            Add Timeline Item
          </button>
        </div>
        <template id="timeline-row-template">
          <div class="card timeline-row">
            <div class="form-row">
              <label>Time label</label>
              <input name="tl_time_label[]" placeholder="">
            </div>
            <div class="form-row">
              <label>Title</label>
              <input name="tl_title[]" placeholder="">
            </div>
            <div class="form-row">
              <label>Position</label>
              <input type="number" name="tl_position[]" value="0" readonly>
            </div>
            <button type="button" class="button secondary remove-timeline" style="margin-top:8px;">Remove</button>
          </div>
        </template>
        <button class="button" type="submit">
          <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
          Create Event
        </button>
      </form>
    </div>

    <!-- Removed separate Add Timeline card to avoid duplicates -->

    <h3 style="margin-top:3rem; color: var(--admin-gray-800);"><i class="fas fa-list" style="margin-right: 0.5rem;"></i>Existing Events</h3>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Date/Time</th>
          <th>Description</th>
          <th>Timelines</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($events as $ev): ?>
          <tr>
            <td data-label="Title"><?php echo htmlspecialchars($ev['title']); ?></td>
            <td data-label="Date/Time"><?php echo htmlspecialchars(date('Y-m-d H:i', strtotime($ev['event_datetime']))); ?></td>
            <td data-label="Description"><?php echo htmlspecialchars($ev['short_description']); ?></td>
            <td data-label="Timelines">
              <ul style="margin:0; padding-left:16px;">
                <?php foreach ($timelinesByEvent[(int)$ev['id']] ?? [] as $tl): ?>
                  <li>
                    <strong><?php echo htmlspecialchars($tl['time_label']); ?></strong> - <?php echo htmlspecialchars($tl['title']); ?>
                    <form method="post" style="display:inline" onsubmit="return confirm('Delete this timeline item?');">
                      <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                      <input type="hidden" name="action" value="delete_timeline">
                      <input type="hidden" name="timeline_id" value="<?php echo (int)$tl['id']; ?>">
                      <button class="button danger" type="submit" style="font-size: 0.75rem; padding: 0.5rem 1rem;">
                        <i class="fas fa-trash" style="margin-right: 0.25rem;"></i>
                        Delete
                      </button>
                    </form>
                  </li>
                <?php endforeach; ?>
                <?php if (empty($timelinesByEvent[(int)$ev['id']] ?? [])): ?>
                  <li>No timeline yet.</li>
                <?php endif; ?>
              </ul>
              <!-- Removed per-event inline Add Timeline form to avoid duplicates -->
            </td>
            <td data-label="Actions">
              <form method="post" onsubmit="return confirm('Delete this event?');">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo (int)$ev['id']; ?>">
                <button class="button danger" type="submit">
                  <i class="fas fa-trash" style="margin-right: 0.5rem;"></i>
                  Delete Event
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($events)): ?>
          <tr><td colspan="5">No events yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
<script>
  (function() {
    const rowsContainer = document.getElementById('timeline-rows');
    const addBtn = document.getElementById('add-timeline');
    const tpl = document.getElementById('timeline-row-template');

    function updatePositions() {
      const rows = rowsContainer.querySelectorAll('.timeline-row');
      rows.forEach((row, idx) => {
        const posInput = row.querySelector('input[name="tl_position[]"]');
        if (posInput) posInput.value = String(idx);
        const removeBtn = row.querySelector('.remove-timeline');
        if (removeBtn) removeBtn.style.display = rows.length > 1 ? '' : 'none';
      });
    }

    function addRow() {
      const fragment = tpl.content.cloneNode(true);
      const newRow = fragment.querySelector('.timeline-row');
      rowsContainer.appendChild(newRow);
      attachRemove(newRow);
      updatePositions();
    }

    function attachRemove(row) {
      const btn = row.querySelector('.remove-timeline');
      if (!btn) return;
      btn.addEventListener('click', () => {
        row.remove();
        updatePositions();
      });
    }

    // Initialize
    rowsContainer.querySelectorAll('.timeline-row').forEach(attachRemove);
    updatePositions();
    addBtn.addEventListener('click', addRow);
  })();
</script>
<script src="/assets/js/admin.js"></script>
<script>
// Events page specific enhancements
document.addEventListener('DOMContentLoaded', function() {
  // Enhance timeline management
  const timelineRows = document.querySelectorAll('.timeline-row');
  timelineRows.forEach(row => {
    row.addEventListener('dragover', function(e) {
      e.preventDefault();
      this.style.background = 'rgba(var(--admin-primary-rgb), 0.1)';
    });

    row.addEventListener('dragleave', function() {
      this.style.background = '';
    });
  });

  // Add confirmation dialogs with better styling
  const deleteButtons = document.querySelectorAll('button[type="submit"]');
  deleteButtons.forEach(btn => {
    if (btn.textContent.includes('Delete')) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const isTimeline = this.closest('li');
        const message = isTimeline ?
          'Are you sure you want to delete this timeline item?' :
          'Are you sure you want to delete this event? This action cannot be undone.';

        if (confirm(message)) {
          showLoadingState(this);
          this.closest('form').submit();
        }
      });
    }
  });
});
</script>
</body>
</html>

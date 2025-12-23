<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers.php';
require_login();
$db = get_db_connection();
$flash = get_and_clear_flash();
$csrf = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf'] ?? '')) {
    redirect_with_message('/admin/darshan.php', 'Invalid CSRF token.', 'error');
  }
  $action = $_POST['action'] ?? '';
  if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
      $stmt = $db->prepare('SELECT image_path FROM daily_darshan WHERE id = ?');
      $stmt->execute([$id]);
      $row = $stmt->fetch();
      if ($row) {
        $db->prepare('DELETE FROM daily_darshan WHERE id = ?')->execute([$id]);
        $path = __DIR__ . '/../' . ltrim($row['image_path'], '/');
        @unlink($path);
      }
      redirect_with_message('/admin/darshan.php', 'Entry deleted.');
    }
  } elseif ($action === 'upload') {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      redirect_with_message('/admin/darshan.php', 'Please select a valid image.', 'error');
    }

    $file = $_FILES['image'];
    $allowed = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/webp' => '.webp'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (!isset($allowed[$mime])) {
      redirect_with_message('/admin/darshan.php', 'Only JPG, PNG, WEBP images allowed.', 'error');
    }
    if ($file['size'] > 5 * 1024 * 1024) {
      redirect_with_message('/admin/darshan.php', 'Image must be under 5MB.', 'error');
    }

    $ext = $allowed[$mime];
    $base = bin2hex(random_bytes(8));
    $safeName = $base . $ext;
    $uploadDir = __DIR__ . '/../uploads/darshan';
    if (!is_dir($uploadDir)) {
      @mkdir($uploadDir, 0755, true);
    }
    $target = $uploadDir . '/' . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
      redirect_with_message('/admin/darshan.php', 'Upload failed. Try again.', 'error');
    }

    $caption = trim((string)($_POST['caption'] ?? ''));
    $relPath = '/uploads/darshan/' . $safeName;
    $stmt = $db->prepare('INSERT INTO daily_darshan (image_path, caption) VALUES (?, ?)');
    $stmt->execute([$relPath, $caption !== '' ? $caption : null]);

    redirect_with_message('/admin/darshan.php', 'Image uploaded successfully.');
  }
}

$images = $db->query('SELECT id, image_path, caption, uploaded_at FROM daily_darshan ORDER BY id DESC')->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Daily Darshan - Admin</title>

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
    input[type="file"],
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
    input[type="file"]:focus,
    input[type="datetime-local"]:focus,
    input[type="number"]:focus,
    textarea:focus {
      outline: none;
      border-color: var(--admin-primary);
      box-shadow: 0 0 0 3px rgba(var(--admin-primary-rgb), 0.1);
    }

    .form-hint {
      font-size: 0.875rem;
      color: var(--admin-gray-500);
      margin-top: 0.25rem;
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

    .img-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .img-grid .card {
      display: flex;
      flex-direction: column;
      padding: 0;
      overflow: hidden;
    }

    .img-grid img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .img-grid img:hover {
      transform: scale(1.03);
    }

    .img-grid p {
      padding: 1rem;
      font-size: 0.9375rem;
      color: var(--admin-gray-700);
    }

    .img-grid form {
      padding: 0 1rem 1rem;
      margin-top: auto;
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

      .img-grid {
        grid-template-columns: 1fr;
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
    <h2><i class="fas fa-images" style="color: var(--admin-primary); margin-right: 0.75rem;"></i>Daily Darshan Gallery</h2>
    <?php if ($flash): ?>
      <div class="alert <?php echo $flash['type']; ?>" data-flash><?php echo htmlspecialchars($flash['message']); ?></div>
    <?php endif; ?>

    <div class="card" style="margin-bottom:16px;">
      <h3><i class="fas fa-upload" style="color: var(--admin-success); margin-right: 0.5rem;"></i>Upload New Image</h3>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
        <input type="hidden" name="action" value="upload">
        <div class="form-row">
          <label for="darshanImage"><i class="fas fa-image" style="margin-right: 0.5rem;"></i>Select Image</label>
          <input id="darshanImage" type="file" name="image" accept="image/jpeg,image/png,image/webp" required>
          <p class="form-hint"><i class="fas fa-info-circle" style="margin-right: 0.25rem;"></i>Supported formats: JPG, PNG, WEBP (Max 5MB)</p>
        </div>
        <div class="form-row">
          <label for="caption"><i class="fas fa-pen" style="margin-right: 0.5rem;"></i>Caption (optional)</label>
          <input id="caption" type="text" name="caption" maxlength="255" placeholder="Write a short, meaningful caption...">
        </div>
        <button class="button" type="submit">
          <i class="fas fa-cloud-upload-alt" style="margin-right: 0.5rem;"></i>
          Upload Image
        </button>
      </form>
    </div>

    <div class="img-grid">
      <?php foreach ($images as $img): ?>
        <div class="card">
          <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="Daily Darshan">
          <?php if ($img['caption']): ?><p><?php echo htmlspecialchars($img['caption']); ?></p><?php endif; ?>
          <form method="post" onsubmit="return confirm('Delete this entry?');">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?php echo (int)$img['id']; ?>">
            <button class="button danger" type="submit">
              <i class="fas fa-trash" style="margin-right: 0.5rem;"></i>
              Delete
            </button>
          </form>
        </div>
      <?php endforeach; ?>
      <?php if (empty($images)): ?>
        <div style="text-align: center; padding: 4rem 2rem; color: var(--admin-gray-500);">
          <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
          <p style="font-size: 1.125rem; margin-bottom: 0.5rem;">No darshan images yet</p>
          <p style="font-size: 0.875rem;">Upload your first temple image to get started</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>
<script src="/assets/js/admin.js"></script>
<script>
// Darshan page specific enhancements
document.addEventListener('DOMContentLoaded', function() {
  // Enhanced image grid with lightbox effect
  const images = document.querySelectorAll('.img-grid img');
  images.forEach(img => {
    img.addEventListener('click', function() {
      createLightbox(this.src, this.alt);
    });

    // Add loading placeholder
    img.addEventListener('load', function() {
      this.style.opacity = '1';
    });

    img.style.opacity = '0';
    img.style.transition = 'opacity 0.3s ease';
  });

  // Drag and drop for file upload
  const fileInput = document.getElementById('darshanImage');
  const uploadArea = fileInput.parentElement;

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
  });

  ['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
  });

  uploadArea.addEventListener('drop', handleDrop, false);

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  function highlight() {
    uploadArea.style.background = 'rgba(var(--admin-primary-rgb), 0.1)';
    uploadArea.style.borderColor = 'var(--admin-primary)';
  }

  function unhighlight() {
    uploadArea.style.background = '';
    uploadArea.style.borderColor = '';
  }

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    if (files.length > 0) {
      fileInput.files = files;
      fileInput.dispatchEvent(new Event('change', { bubbles: true }));
    }
  }
});

function createLightbox(src, alt) {
  const lightbox = document.createElement('div');
  lightbox.style.cssText = `
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    cursor: pointer;
  `;

  const img = document.createElement('img');
  img.src = src;
  img.alt = alt;
  img.style.cssText = `
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    border-radius: var(--admin-radius);
    box-shadow: var(--admin-shadow-2xl);
  `;

  lightbox.appendChild(img);
  document.body.appendChild(lightbox);

  lightbox.addEventListener('click', () => {
    document.body.removeChild(lightbox);
  });

  // Fade in animation
  lightbox.style.opacity = '0';
  setTimeout(() => {
    lightbox.style.transition = 'opacity 0.3s ease';
    lightbox.style.opacity = '1';
  }, 10);
}
</script>
</body>
</html>

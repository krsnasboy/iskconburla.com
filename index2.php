<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ISKCON Portal</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
  <script defer src="/assets/js/main.js"></script>
</head>
<body>
  <header>
    <div class="container">
      <nav>
        <strong>ISKCON Portal</strong>
        <a href="/events.php">Events</a>
        <a href="/daily-darshan.php">Daily Darshan</a>
        <a href="/services.php">Services</a>
        <span style="margin-left:auto"></span>
        <a href="/admin/login.php">Admin</a>
      </nav>
    </div>
  </header>
  <main>
    <div class="container">
      <div class="grid grid-3">
        <div class="card">
          <h3>Events</h3>
          <p>See upcoming temple events and timelines.</p>
          <a class="button" href="/events.php">View Events</a>
        </div>
        <div class="card">
          <h3>Daily Darshan</h3>
          <p>Offer your darshan by sharing images and captions.</p>
          <a class="button" href="/daily-darshan.php">Open Gallery</a>
        </div>
        <div class="card">
          <h3>Services</h3>
          <p>Explore sevas and register to participate.</p>
          <a class="button" href="/services.php">View Services</a>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <div class="container">© <?php echo date('Y'); ?> ISKCON.</div>
  </footer>
</body>
</html> 
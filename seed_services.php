<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

$db = get_db_connection();

// Check if services already exist
$existing = $db->query('SELECT COUNT(*) as count FROM services')->fetch();
if ($existing['count'] > 0) {
    echo "Services already exist in database.\n";
    exit;
}

// Add sample services
$services = [
    [
        'title' => 'Bhagavad Gita Study Circle',
        'requirements' => 'Open to all devotees. No prior knowledge required. Bring your own copy of Bhagavad Gita if possible.',
        'short_description' => 'Weekly study sessions on the sacred teachings of Bhagavad Gita. Learn the timeless wisdom of Lord Krishna.'
    ],
    [
        'title' => 'Kirtan & Bhajan Sessions',
        'requirements' => 'All are welcome. Musical instruments provided. No musical experience necessary.',
        'short_description' => 'Join us for devotional singing and chanting. Experience the divine through music and mantras.'
    ],
    [
        'title' => 'Prasadam Distribution',
        'requirements' => 'Clean clothes and pure heart. Food handling training provided.',
        'short_description' => 'Help distribute blessed food to devotees and visitors. Serve the Lord through food service.'
    ]
];

$stmt = $db->prepare('INSERT INTO services (title, requirements, short_description) VALUES (?, ?, ?)');

foreach ($services as $service) {
    $stmt->execute([$service['title'], $service['requirements'], $service['short_description']]);
    echo "Added service: " . $service['title'] . "\n";
}

echo "Sample services added successfully!\n";
?> 
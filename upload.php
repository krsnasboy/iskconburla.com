<?php
header('Content-Type: application/json');

if (!isset($_FILES['photo'])) {
    echo json_encode(["success" => false, "error" => "No file received"]);
    exit;
}

$uploadDir = 'uploads/';
$fileName = basename($_FILES['photo']['name']);
$safeName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
$targetFile = $uploadDir . $safeName;

// Debugging checks
if (!is_dir($uploadDir)) {
    echo json_encode(["success" => false, "error" => "Upload folder does not exist"]);
    exit;
}

if (!is_writable($uploadDir)) {
    echo json_encode(["success" => false, "error" => "Upload folder is not writable"]);
    exit;
}

if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
    echo json_encode(["success" => true, "url" => "https://iskconburla.com/" . $targetFile]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "move_uploaded_file failed",
        "details" => $_FILES['photo']
    ]);
}
?>

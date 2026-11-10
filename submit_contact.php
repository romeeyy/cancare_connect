<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'ok' => false,
        'message' => 'Method not allowed.',
    ]);
    exit;
}

require __DIR__ . '/config.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$company = trim($_POST['company'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'ok' => false,
        'message' => 'Please enter a valid name and email address.',
    ]);
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO contact_messages (name, email, company, message)
     VALUES (:name, :email, :company, :message)'
);

$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':company' => $company !== '' ? $company : null,
    ':message' => $message !== '' ? $message : null,
]);

echo json_encode([
    'ok' => true,
    'message' => 'Message saved.',
]);

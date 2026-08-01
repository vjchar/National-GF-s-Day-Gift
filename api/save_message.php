<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/config.php';

if (!isLoggedIn()) {
    jsonResponse(['success' => false, 'message' => 'Unauthorized.'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$name = trim((string)($_POST['name'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($name === '' || $message === '') {
    jsonResponse(['success' => false, 'message' => 'Please complete both fields.'], 422);
}

if (mb_strlen($name) > 60 || mb_strlen($message) > 1000) {
    jsonResponse(['success' => false, 'message' => 'Your message is too long.'], 422);
}

$messages = readJsonFile(MESSAGE_FILE, []);
$messages[] = [
    'name' => $name,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s'),
];

if (!writeJsonFile(MESSAGE_FILE, $messages)) {
    jsonResponse(['success' => false, 'message' => 'The message could not be saved.'], 500);
}

jsonResponse(['success' => true, 'message' => 'Your reply was saved. ♡']);

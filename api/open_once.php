<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

if (!isLoggedIn()) {
    jsonResponse([
        'success' => false,
        'message' => 'Unauthorized.'
    ], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse([
        'success' => false,
        'message' => 'Method not allowed.'
    ], 405);
}

// Always return the message
jsonResponse([
    'success' => true,
    'message' => 'Here is the truth I want you to remember: even on difficult days, even when we misunderstand each other, I still see you as someone worth choosing, understanding, and loving. You are not only part of my happiest memories—you are part of the future I keep hoping for.'
]);
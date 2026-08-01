<?php
declare(strict_types=1);

session_start();

const APP_NAME = 'Our Little Universe';
const GIRLFRIEND_NAME = 'My Love Zaza';
const YOUR_NAME = 'VJ';

/*
 | Change this password before deployment.
 | Default password: ourlove
 */
const GIFT_PASSWORD_HASH = '$2y$12$pPsXoQo6VHKYS4.pfary8uVgWCL6wh6CMwVd6jqfVb23LnPGr0b/y';

const RELATIONSHIP_START = '2024-06-04';
const HER_BIRTHDAY = '1998-12-20';
const ANNIVERSARY_MONTH_DAY = '06-04';

const DATA_DIRECTORY = __DIR__ . '/data';
const MESSAGE_FILE = DATA_DIRECTORY . '/messages.json';
const OPEN_ONCE_FILE = DATA_DIRECTORY . '/open_once.json';

function ensureDataFiles(): void
{
    if (!is_dir(DATA_DIRECTORY)) {
        mkdir(DATA_DIRECTORY, 0775, true);
    }

    if (!file_exists(MESSAGE_FILE)) {
        file_put_contents(MESSAGE_FILE, json_encode([], JSON_PRETTY_PRINT));
    }

    if (!file_exists(OPEN_ONCE_FILE)) {
        file_put_contents(
            OPEN_ONCE_FILE,
            json_encode(['opened' => false, 'opened_at' => null], JSON_PRETTY_PRINT)
        );
    }
}

function isLoggedIn(): bool
{
    return isset($_SESSION['gift_access']) && $_SESSION['gift_access'] === true;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function jsonResponse(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

function readJsonFile(string $path, array $fallback = []): array
{
    if (!file_exists($path)) {
        return $fallback;
    }

    $contents = file_get_contents($path);
    $decoded = json_decode($contents ?: '', true);

    return is_array($decoded) ? $decoded : $fallback;
}

function writeJsonFile(string $path, array $data): bool
{
    return file_put_contents(
        $path,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    ) !== false;
}

ensureDataFiles();

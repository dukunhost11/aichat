<?php
// config/functions.php
session_start();

function sendJSON($data, $status = 200)
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

function isLoggedIn()
{
    return !empty($_SESSION['user_id']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        redirect('/login.php');
    }
}

function getCurrentUserId()
{
    return $_SESSION['user_id'] ?? null;
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

function sanitize($text)
{
    return htmlspecialchars(trim($text), ENT_QUOTES, 'UTF-8');
}

<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/functions.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? null;

if ($action === 'register') {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = sanitize($data['name'] ?? '');
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $data['password'] ?? '';
    $confirm = $data['confirm_password'] ?? '';

    if (!$name || !$email || !$password || !$confirm) {
        sendJSON(['error' => 'Please complete all fields.'], 422);
    }
    if ($password !== $confirm) {
        sendJSON(['error' => 'Passwords do not match.'], 422);
    }
    if (strlen($password) < 8) {
        sendJSON(['error' => 'Password must be at least 8 characters.'], 422);
    }

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        sendJSON(['error' => 'Email already registered.'], 409);
    }

    $password_hash = hashPassword($password);
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :hash)');
    $stmt->execute([
        ':username' => $name,
        ':email' => $email,
        ':hash' => $password_hash,
    ]);

    sendJSON(['success' => true, 'message' => 'Registration successful. Please login.']);

} elseif ($action === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        sendJSON(['error' => 'Please enter email and password.'], 422);
    }

    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !verifyPassword($password, $user['password_hash'])) {
        sendJSON(['error' => 'Invalid credentials.'], 401);
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $email;
    $_SESSION['logged_in_at'] = time();

    sendJSON(['success' => true, 'message' => 'Login successful.']);

} elseif ($action === 'logout') {
    session_destroy();
    sendJSON(['success' => true]);

} else {
    sendJSON(['error' => 'Invalid auth action.'], 400);
}

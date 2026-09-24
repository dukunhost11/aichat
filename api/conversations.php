<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/functions.php';

header('Content-Type: application/json');

if (!isLoggedIn()) {
    sendJSON(['error' => 'Unauthorized'], 401);
}

$user_id = getCurrentUserId();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $conversationId = $_GET['id'] ?? null;
    if ($conversationId) {
        $stmt = $pdo->prepare('SELECT id, title, model, created_at, updated_at FROM conversations WHERE id = :id AND user_id = :user_id');
        $stmt->execute([':id' => $conversationId, ':user_id' => $user_id]);
        $conversation = $stmt->fetch();
        if (!$conversation) {
            sendJSON(['error' => 'Conversation not found.'], 404);
        }

        $stmt = $pdo->prepare('SELECT role, content, created_at FROM messages WHERE conversation_id = :conversation_id ORDER BY created_at ASC');
        $stmt->execute([':conversation_id' => $conversationId]);
        $conversation['messages'] = $stmt->fetchAll();
        sendJSON($conversation);
    }

    $stmt = $pdo->prepare('SELECT id, title, model, created_at, updated_at FROM conversations WHERE user_id = :user_id ORDER BY updated_at DESC');
    $stmt->execute([':user_id' => $user_id]);
    $conversations = $stmt->fetchAll();
    sendJSON($conversations);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $title = sanitize($data['title'] ?? 'New Conversation');
    $model = $data['model'] ?? DEFAULT_MODEL;

    $stmt = $pdo->prepare('INSERT INTO conversations (user_id, title, model) VALUES (:user_id, :title, :model)');
    $stmt->execute([
        ':user_id' => $user_id,
        ':title' => $title,
        ':model' => $model,
    ]);

    sendJSON(['success' => true, 'id' => $pdo->lastInsertId()]);
}

if ($method === 'DELETE') {
    parse_str(file_get_contents('php://input'), $input);
    $conversation_id = $input['id'] ?? null;
    if (!$conversation_id) {
        sendJSON(['error' => 'Conversation id required.'], 422);
    }
    $stmt = $pdo->prepare('DELETE FROM conversations WHERE id = :id AND user_id = :user_id');
    $stmt->execute([':id' => $conversation_id, ':user_id' => $user_id]);
    sendJSON(['success' => true]);
}

sendJSON(['error' => 'Method not allowed'], 405);

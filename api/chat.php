<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJSON(['error' => 'Method not allowed'], 405);
}

if (!isLoggedIn()) {
    sendJSON(['error' => 'Unauthorized'], 401);
}

$data = json_decode(file_get_contents('php://input'), true);
$conversation_id = $data['conversation_id'] ?? null;
$message = trim($data['message'] ?? '');
$model = $data['model'] ?? DEFAULT_MODEL;

if (empty($message)) {
    sendJSON(['error' => 'Message cannot be empty'], 400);
}

$user_id = getCurrentUserId();
if (!$conversation_id) {
    $stmt = $pdo->prepare('INSERT INTO conversations (user_id, title, model) VALUES (:user_id, :title, :model)');
    $stmt->execute([
        ':user_id' => $user_id,
        ':title' => 'New Conversation',
        ':model' => $model,
    ]);
    $conversation_id = $pdo->lastInsertId();
}

$stmt = $pdo->prepare('INSERT INTO messages (conversation_id, role, content) VALUES (:conversation_id, "user", :content)');
$stmt->execute([
    ':conversation_id' => $conversation_id,
    ':content' => $message,
]);

$stmt = $pdo->prepare('SELECT role, content FROM messages WHERE conversation_id = :conversation_id ORDER BY created_at ASC');
$stmt->execute([':conversation_id' => $conversation_id]);
$history = $stmt->fetchAll();

$messages = array_map(function ($item) {
    return [
        'role' => $item['role'],
        'content' => $item['content'],
    ];
}, $history);

$openrouter_payload = [
    'messages' => $messages,
    'model' => $model,
    'max_tokens' => 1000,
    'temperature' => 0.7,
    'stream' => false,
];

$openrouter_api_key = getenv('OPENROUTER_API_KEY');
$ch = curl_init(OPENROUTER_API_URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $openrouter_api_key,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($openrouter_payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch);

if ($response === false) {
    sendJSON(['error' => 'AI request failed.'], 500);
}

$result = json_decode($response, true);
if (!isset($result['choices'][0]['message']['content'])) {
    sendJSON(['error' => 'Invalid AI response.'], 500);
}

$assistantText = $result['choices'][0]['message']['content'];
$stmt = $pdo->prepare('INSERT INTO messages (conversation_id, role, content) VALUES (:conversation_id, "assistant", :content)');
$stmt->execute([
    ':conversation_id' => $conversation_id,
    ':content' => $assistantText,
]);

sendJSON(['success' => true, 'conversation_id' => $conversation_id, 'assistant' => $assistantText]);

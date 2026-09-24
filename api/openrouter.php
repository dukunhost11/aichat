<?php
require_once __DIR__ . '/../config/functions.php';
require_once __DIR__ . '/../config/config.php';

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$openrouter_api_key = getenv('OPENROUTER_API_KEY');
if (!$openrouter_api_key) {
    echo "data: " . json_encode(['error' => 'OpenRouter API key not configured']) . "\n\n";
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? [];
$model = $input['model'] ?? DEFAULT_MODEL;
$max_tokens = isset($input['max_tokens']) ? (int) $input['max_tokens'] : 1000;

$payload = [
    'model' => $model,
    'messages' => $messages,
    'max_tokens' => $max_tokens,
    'temperature' => 0.7,
    'stream' => true,
];

$ch = curl_init(OPENROUTER_API_URL);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $openrouter_api_key,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $chunk) {
    $lines = explode("\n", trim($chunk));
    foreach ($lines as $line) {
        if (strpos($line, 'data:') === 0) {
            $json = trim(substr($line, 5));
            if ($json === '[DONE]') {
                continue;
            }
            $item = json_decode($json, true);
            if (isset($item['choices'][0]['delta']['content'])) {
                echo "data: " . json_encode(['content' => $item['choices'][0]['delta']['content']]) . "\n\n";
                ob_flush();
                flush();
            }
        }
    }
    return strlen($chunk);
});

curl_exec($ch);
curl_close($ch);

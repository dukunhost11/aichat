<?php
require_once __DIR__ . '/config/functions.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — AI Chat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Söhne:wght@300;400;500;600;700&family=Söhne+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body class="page-dashboard">
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <button id="new-chat-btn" class="btn-new-chat" title="New chat">
                    <i class="fas fa-plus"></i>
                    <span>New Chat</span>
                </button>
            </div>

            <div class="sidebar-search">
                <input id="conversation-search" type="search" placeholder="Search chats...">
                <i class="fas fa-search"></i>
            </div>

            <div id="conversations-list" class="conversations-list"></div>

            <div class="sidebar-footer">
                <div class="model-selector">
                    <label><i class="fas fa-microchip"></i> Model</label>
                    <select id="model-select">
                        <option value="mistral-7b-instruct">Mistral 7B</option>
                        <option value="llama-3.1-instruct">Llama 3.1</option>
                        <option value="gemma-2">Gemma 2</option>
                        <option value="qwen-2.5">Qwen 2.5</option>
                    </select>
                </div>
                <button id="logout-btn" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </div>
        </aside>

        <!-- Main Chat Area -->
        <main class="chat-main">
            <div class="chat-container">
                <!-- Chat Messages -->
                <div class="messages-wrapper">
                    <div id="messages-container" class="messages-container"></div>
                </div>

                <!-- Chat Input -->
                <div class="chat-input-section">
                    <form id="message-form" class="message-form">
                        <div class="input-wrapper">
                            <textarea id="message-input" name="message" placeholder="Message AI Chat..."
                                rows="3"></textarea>
                            <button id="send-btn" type="submit" class="btn-send" title="Send message">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="input-info">
                            <span id="char-count">0 / 2000</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Panel: Preview & Code -->
            <aside class="right-panel">
                <div class="panel-tabs">
                    <button class="panel-tab active" data-tab="preview">
                        <i class="fas fa-eye"></i>
                        <span>Preview</span>
                    </button>
                    <button class="panel-tab" data-tab="code">
                        <i class="fas fa-code"></i>
                        <span>Code</span>
                    </button>
                </div>

                <div id="preview" class="panel-content preview-content">
                    <div class="preview-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Preview will appear here</p>
                    </div>
                    <iframe id="preview-iframe" class="preview-iframe"
                        sandbox="allow-scripts allow-same-origin"></iframe>
                </div>

                <div id="code" class="panel-content code-content" style="display:none;">
                    <div class="code-viewer">
                        <pre id="code-block"><code></code></pre>
                    </div>
                </div>

                <div class="panel-actions">
                    <button id="copy-btn" class="action-btn" title="Copy code">
                        <i class="fas fa-copy"></i>
                        <span>Copy</span>
                    </button>
                    <button id="download-btn" class="action-btn" title="Download">
                        <i class="fas fa-download"></i>
                        <span>Download</span>
                    </button>
                    <button id="deploy-btn" class="action-btn" title="Deploy">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Deploy</span>
                    </button>
                </div>
            </aside>
        </main>
    </div>
    <script src="js/dashboard.js"></script>
</body>

</html>
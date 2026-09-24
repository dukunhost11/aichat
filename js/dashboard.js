class WebsiteBuilder {
    constructor() {
        this.currentConversationId = null;
        this.currentCode = '';
        this.isLoading = false;
        this.model = 'mistral-7b-instruct';

        // DOM elements
        this.messageInput = document.getElementById('message-input');
        this.sendBtn = document.getElementById('send-btn');
        this.newChatBtn = document.getElementById('new-chat-btn');
        this.messagesContainer = document.getElementById('messages-container');
        this.conversationsList = document.getElementById('conversations-list');
        this.modelSelect = document.getElementById('model-select');
        this.logoutBtn = document.getElementById('logout-btn');
        this.messageForm = document.getElementById('message-form');
        this.charCount = document.getElementById('char-count');

        // Preview elements
        this.previewTabs = document.querySelectorAll('.preview-tab');
        this.previewIframe = document.getElementById('preview-iframe');
        this.codeBlock = document.getElementById('code-block');
        this.copyBtn = document.getElementById('copy-btn');
        this.downloadBtn = document.getElementById('download-btn');
        this.deployBtn = document.getElementById('deploy-btn');

        this.init();
    }

    async init() {
        this.setupEventListeners();
        await this.loadConversations();
    }

    setupEventListeners() {
        this.sendBtn.addEventListener('click', (event) => {
            event.preventDefault();
            this.sendMessage();
        });

        this.messageForm.addEventListener('submit', (event) => {
            event.preventDefault();
            this.sendMessage();
        });

        this.messageInput.addEventListener('input', () => {
            this.charCount.textContent = `${this.messageInput.value.length} / 2000`;
            this.autoResizeTextarea();
        });

        this.modelSelect.addEventListener('change', () => {
            this.model = this.modelSelect.value;
        });

        this.newChatBtn.addEventListener('click', () => this.createNewChat());
        this.logoutBtn.addEventListener('click', async () => {
            await fetch('/api/auth.php?action=logout', { method: 'POST' });
            window.location.href = '/login.php';
        });

        // Preview/Code tab switching
        this.previewTabs.forEach((tab) => {
            tab.addEventListener('click', () => this.switchTab(tab.dataset.tab));
        });

        // Action buttons
        this.copyBtn.addEventListener('click', () => this.copyCode());
        this.downloadBtn.addEventListener('click', () => this.downloadCode());
        this.deployBtn.addEventListener('click', () => this.deployCode());
    }

    autoResizeTextarea() {
        this.messageInput.style.height = 'auto';
        this.messageInput.style.height = `${this.messageInput.scrollHeight}px`;
    }

    switchTab(tabName) {
        // Update tab buttons
        document.querySelectorAll('.panel-tab').forEach((tab) => {
            tab.classList.toggle('active', tab.dataset.tab === tabName);
        });

        // Update content panels
        const previewContent = document.getElementById('preview');
        const codeContent = document.getElementById('code');

        if (tabName === 'preview') {
            previewContent.style.display = 'block';
            codeContent.style.display = 'none';
            if (this.previewIframe && this.previewIframe.hidden) {
                this.previewIframe.hidden = false;
            }
        } else {
            previewContent.style.display = 'none';
            codeContent.style.display = 'block';
            if (this.previewIframe) {
                this.previewIframe.hidden = true;
            }
        }
    }

    appendMessage(role, content) {
        const messageEl = document.createElement('div');
        messageEl.className = `message message-${role}`;
        messageEl.setAttribute('data-role', role);

        const contentEl = document.createElement('div');
        contentEl.className = 'message-content';
        contentEl.textContent = content;

        messageEl.appendChild(contentEl);
        this.messagesContainer.appendChild(messageEl);
        this.scrollToBottom();
        return messageEl;
    }

    scrollToBottom() {
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    async sendMessage() {
        if (this.isLoading) return;

        const message = this.messageInput.value.trim();
        if (!message) return;

        this.isLoading = true;
        this.messageInput.disabled = true;
        this.sendBtn.disabled = true;

        this.appendMessage('user', message);
        this.messageInput.value = '';
        this.charCount.textContent = '0 / 2000';
        this.autoResizeTextarea();

        const assistantEl = this.appendMessage('ai', 'Generating your code...');

        try {
            const response = await fetch('/api/chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    conversation_id: this.currentConversationId,
                    message: message + ' (Respond with only HTML, CSS, and JavaScript code. Include <html>, <head>, <body> tags. Make it complete and functional.)',
                    model: this.model,
                }),
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.error || 'Unable to send message.');
            }

            assistantEl.querySelector('.message-text').textContent = 'Code generated! Preview on the right.';
            this.currentConversationId = data.conversation_id;

            // Extract code from response
            this.currentCode = data.assistant;
            this.updatePreview(this.currentCode);
            this.updateCodeBlock(this.currentCode);

            this.scrollToBottom();
            await this.loadConversations();
        } catch (error) {
            assistantEl.querySelector('.message-text').textContent = 'Error generating code. Please try again.';
            console.error(error);
        } finally {
            this.isLoading = false;
            this.messageInput.disabled = false;
            this.sendBtn.disabled = false;
            this.messageInput.focus();
        }
    }

    updatePreview(code) {
        const doc = this.previewIframe.contentDocument || this.previewIframe.contentWindow.document;
        doc.open();
        doc.write(code);
        doc.close();
    }

    updateCodeBlock(code) {
        this.codeBlock.textContent = code;
    }

    copyCode() {
        navigator.clipboard.writeText(this.currentCode).then(() => {
            this.copyBtn.textContent = '✓ Copied!';
            setTimeout(() => {
                this.copyBtn.textContent = '📋 Copy';
            }, 2000);
        }).catch(() => {
            alert('Failed to copy code.');
        });
    }

    downloadCode() {
        const element = document.createElement('a');
        const file = new Blob([this.currentCode], { type: 'text/html' });
        element.href = URL.createObjectURL(file);
        element.download = 'index.html';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }

    deployCode() {
        alert('Deploy feature coming soon! For now, download the code and upload to your InfinityFree hosting via FTP.');
    }

    async createNewChat() {
        const response = await fetch('/api/conversations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ title: 'New Build', model: this.model }),
        });
        const data = await response.json();
        if (data.success) {
            this.currentConversationId = data.id;
            this.currentCode = '';
            this.messagesContainer.innerHTML = '';
            this.updatePreview('<html><body style="display:flex;align-items:center;justify-content:center;height:100vh;background:#f5f5f5;"><h2 style="color:#999;">Start building...</h2></body></html>');
            this.updateCodeBlock('');
            this.highlightConversation(data.id);
        }
    }

    async loadConversations() {
        const response = await fetch('/api/conversations.php');
        if (!response.ok) return;
        const conversations = await response.json();
        this.renderConversations(conversations);
    }

    renderConversations(items) {
        this.conversationsList.innerHTML = '';
        items.forEach((item) => {
            const row = document.createElement('button');
            row.type = 'button';
            row.className = 'conversation-item';
            row.dataset.id = item.id;
            row.innerHTML = `
                <div>
                    <strong>${this.escapeHtml(item.title)}</strong>
                    <p>${new Date(item.updated_at).toLocaleString()}</p>
                </div>
            `;
            row.addEventListener('click', () => this.loadConversation(item.id));
            this.conversationsList.appendChild(row);
        });
    }

    async loadConversation(conversationId) {
        const response = await fetch(`/api/conversations.php?id=${conversationId}`);
        if (!response.ok) return;
        const result = await response.json();
        if (!result || !Array.isArray(result.messages)) return;

        this.currentConversationId = conversationId;
        this.messagesContainer.innerHTML = '';
        result.messages.forEach((message) => {
            this.appendMessage(message.role, message.content);
            if (message.role === 'assistant') {
                this.currentCode = message.content;
            }
        });

        if (this.currentCode) {
            this.updatePreview(this.currentCode);
            this.updateCodeBlock(this.currentCode);
        }
    }

    highlightConversation(conversationId) {
        const items = this.conversationsList.querySelectorAll('.conversation-item');
        items.forEach((item) => {
            item.classList.toggle('active', item.dataset.id === String(conversationId));
        });
    }
}

document.addEventListener('DOMContentLoaded', () => new WebsiteBuilder());

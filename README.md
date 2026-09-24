# 🚀 AI Website Builder

A PHP-based website builder powered by OpenRouter AI. Chat with AI to generate HTML/CSS/JS code, preview it live, and deploy to your hosting.

## 🎯 Features

- **Chat-driven code generation** - Request any website or component
- **Live preview** - See your code rendered instantly in an iframe
- **Code viewer** - Toggle between preview and source code
- **Copy code** - Copy to clipboard with one click
- **Download** - Save as HTML file
- **Deploy ready** - Deploy to InfinityFree or any hosting
- **Multi-model support** - Choose from Mistral, Llama, Gemma, Qwen
- **Conversation history** - Save and reuse your projects

## 📋 Requirements

- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.2+
- OpenRouter API key (free)

## 🔧 Setup

### 1. Database Setup

Import the schema:
```bash
mysql -u root -p your_database_name < schema.sql
```

### 2. Environment Variables

Create a `.env` file in the root:
```env
DB_HOST=127.0.0.1
DB_NAME=aichat
DB_USER=root
DB_PASS=your_password
OPENROUTER_API_KEY=your_api_key_here
```

### 3. Get OpenRouter API Key

1. Go to https://openrouter.ai
2. Sign up (free)
3. Create an API key
4. Add to `.env`

### 4. Configure Web Server

**For Apache:**
Create `.htaccess` in root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?$1 [L,QSA]
</IfModule>
```

**For Nginx:**
```nginx
location / {
    try_files $uri $uri/ /index.php?$uri&$args;
}
```

### 5. File Structure

```
aichat/
├── index.php              # Landing page
├── login.php              # Login page
├── register.php           # Register page
├── dashboard.php          # Builder interface
├── schema.sql             # Database schema
├── .env                   # Environment variables (create this)
├── api/
│   ├── auth.php          # Authentication
│   ├── chat.php          # Code generation
│   ├── conversations.php # Project management
│   └── openrouter.php    # AI API calls
├── config/
│   ├── db.php            # Database connection
│   ├── functions.php     # Helper functions
│   └── config.php        # Constants
├── css/
│   ├── style.css         # Global styles
│   ├── landing.css       # Landing page styles
│   └── dashboard.css     # Builder interface styles
└── js/
    ├── main.js           # Global scripts
    ├── auth.js           # Auth handling
    └── dashboard.js      # Builder logic
```

## 🌐 Deployment to InfinityFree

### Step 1: Upload Files

Use FTP or File Manager:
- Host: `ftp.yourdomain.infinityfree.com`
- Upload all files to `public_html`

### Step 2: Create Database

1. Go to InfinityFree Control Panel
2. Create MySQL database
3. Import `schema.sql` via phpMyAdmin
4. Update `.env` with InfinityFree credentials

### Step 3: Set Permissions

Make these directories writable:
```bash
chmod 755 api/
chmod 755 config/
```

## 📝 Usage

1. **Register** - Create account at `/register.php`
2. **Login** - Sign in at `/login.php`
3. **Build** - Go to dashboard and start requesting code
4. **Preview** - See live preview instantly
5. **Export** - Copy or download your code
6. **Deploy** - Upload HTML file to your hosting

## 🤖 Supported Models

- `mistral-7b-instruct` - Fast, good quality
- `llama-3.1-instruct` - Advanced reasoning
- `gemma-2` - Efficient
- `qwen-2.5` - Multilingual
- More available via OpenRouter

## 🔐 Security Notes

- Never commit `.env` with real API keys
- Use HTTPS in production
- Validate all user inputs server-side
- Keep OpenRouter API key safe

## 🐛 Troubleshooting

**"Database connection failed"**
- Check `.env` credentials
- Ensure MySQL is running
- Verify database exists

**"OpenRouter API key not configured"**
- Add `OPENROUTER_API_KEY` to `.env`
- Restart server
- Check key is valid

**"Preview not showing"**
- Check browser console for errors
- Ensure iframe sandbox allows scripts
- Verify generated code is valid HTML

## 📚 API Endpoints

- `POST /api/auth.php?action=register` - Register user
- `POST /api/auth.php?action=login` - Login
- `POST /api/auth.php?action=logout` - Logout
- `POST /api/chat.php` - Send message + generate code
- `GET /api/conversations.php` - List projects
- `POST /api/conversations.php` - Create project
- `GET /api/conversations.php?id=X` - Get project with messages
- `DELETE /api/conversations.php` - Delete project

## 💡 Tips

- Use specific requests: "Create a modern landing page for a SaaS company"
- Request complete projects with multiple sections
- Save your favorite builds and reuse them
- Ask for improvements on previous code

## 📄 License

MIT

## 🙋 Support

For issues or questions, check the code comments or create a GitHub issue.

Happy building! 🎉

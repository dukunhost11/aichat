<?php
require_once __DIR__ . '/config/functions.php';
if (isLoggedIn()) {
    header('Location: /dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — AI Chat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Söhne:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="page-auth">
    <main class="auth-shell">
        <div class="auth-panel">
            <div class="auth-header">
                <a class="brand" href="/" aria-label="Back to home">
                    <i class="fas fa-sparkles"></i>
                    <span>AI Chat</span>
                </a>
                <h2>Welcome back</h2>
                <p>Sign in to your account to continue</p>
            </div>

            <form id="login-form" class="auth-form">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required aria-label="Email address">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required aria-label="Password">
                </div>

                <button type="submit" class="button button-primary button-block">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <p id="login-error" class="form-error"></p>

                <div class="auth-divider">
                    <span>or</span>
                </div>

                <p class="auth-meta">
                    Don't have an account? <a href="/register.php">Create one free</a>
                </p>
            </form>
        </div>
    </main>

    <script src="js/auth.js"></script>
</body>

</html>
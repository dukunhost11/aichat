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
    <title>Create Account — AI Chat</title>
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
                <h2>Create Account</h2>
                <p>Join and start chatting with AI models instantly</p>
            </div>

            <form id="register-form" class="auth-form">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Your name" required aria-label="Full name">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required aria-label="Email address">
                </div>

                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required aria-label="Password" minlength="6">
                </div>

                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-check-circle"></i> Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required aria-label="Confirm password" minlength="6">
                </div>

                <label class="checkbox-label">
                    <input type="checkbox" id="terms" required>
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="button button-primary button-block">
                    <span>Create Account</span>
                    <i class="fas fa-arrow-right"></i>
                </button>

                <p id="register-error" class="form-error"></p>

                <div class="auth-divider">
                    <span>already have account?</span>
                </div>

                <p class="auth-meta">
                    <a href="/login.php">Sign in instead</a>
                </p>
            </form>
        </div>
    </main>

    <script src="js/auth.js"></script>
</body>

</html>
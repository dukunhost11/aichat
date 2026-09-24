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
    <meta name="description" content="Advanced AI Chat Platform - Experience the future of conversational AI with unlimited models, real-time streaming, and powerful integrations.">
    <meta name="keywords" content="AI, Chat, LLM, Artificial Intelligence">
    <title>AI Chat — Unlimited Edition</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Söhne:wght@300;400;500;600;700&family=Söhne+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/landing.css">
</head>

<body class="page-landing">
    <!-- Navigation Bar -->
    <header class="topbar">
        <div class="brand-row">
            <a class="brand" href="/" aria-label="AI Chat Home">
                <i class="fas fa-sparkles"></i>
                <span>AI Chat</span>
            </a>
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="/login.php" class="button button-secondary">Sign In</a>
                <a href="/register.php" class="button button-primary">Get Started <i class="fas fa-arrow-right"></i></a>
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-copy">
                <h1>The Most Advanced AI Chat Platform</h1>
                <p class="hero-subtitle">Experience the future of conversational AI with unlimited models, real-time streaming, and powerful integrations. No credit card required.</p>
                <div class="hero-actions">
                    <a href="/register.php" class="button button-primary button-lg">Get Started Free <i class="fas fa-arrow-right"></i></a>
                    <a href="#features" class="button button-secondary button-lg">Learn More</a>
                </div>
                <div class="hero-trust">
                    <span><i class="fas fa-check-circle"></i> No credit card required</span>
                    <span><i class="fas fa-check-circle"></i> 5+ AI Models</span>
                    <span><i class="fas fa-check-circle"></i> Unlimited conversations</span>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-header">
                        <div>
                            <i class="fas fa-circle" style="color: var(--primary); font-size: 0.4rem; margin-right: 0.2rem;"></i>
                            <span>New Chat</span>
                        </div>
                        <span class="tag">Active</span>
                    </div>
                    <div class="hero-card-messages">
                        <div class="msg msg-user">Build me a landing page</div>
                        <div class="msg msg-ai">
                            <i class="fas fa-pen" style="opacity: 0.6; margin-right: 0.5rem;"></i>
                            I'll create a beautiful page for you...
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features-section">
            <div class="section-header">
                <h2>Everything you need</h2>
                <p>Powerful features for seamless AI conversations</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-brain"></i></div>
                    <h3>5+ AI Models</h3>
                    <p>Access Mistral, Llama 3, Gemma, Qwen and more. Switch models instantly.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-bolt"></i></div>
                    <h3>Lightning Fast</h3>
                    <p>Real-time streaming responses with instant feedback as AI thinks.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-history"></i></div>
                    <h3>Full History</h3>
                    <p>Never lose a conversation. Search, organize, and revisit anytime.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h3>Works Everywhere</h3>
                    <p>Beautiful responsive design that looks perfect on any device.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-code"></i></div>
                    <h3>Code Generation</h3>
                    <p>Generate, preview, and export code instantly with syntax highlighting.</p>
                </article>
                <article class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Privacy First</h3>
                    <p>Your conversations are secure and private. We never share your data.</p>
                </article>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="section stats-section">
            <div class="stat-card">
                <div class="stat-value"><i class="fas fa-infinity"></i></div>
                <span>Unlimited Conversations</span>
            </div>
            <div class="stat-card">
                <div class="stat-value">5+</div>
                <span>AI Models Available</span>
            </div>
            <div class="stat-card">
                <div class="stat-value"><i class="fas fa-flash"></i></div>
                <span>Real-time Streaming</span>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="section pricing-section">
            <div class="section-header">
                <h2>Simple, transparent pricing</h2>
                <p>Start free. Always free. Premium features coming soon.</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card pricing-card-featured">
                    <div class="plan-badge"><i class="fas fa-star"></i> Most Popular</div>
                    <p class="plan-name">Free Plan</p>
                    <p class="price">$0<span>/month</span></p>
                    <ul>
                        <li><i class="fas fa-check"></i> Unlimited conversations</li>
                        <li><i class="fas fa-check"></i> 5+ AI models</li>
                        <li><i class="fas fa-check"></i> Full conversation history</li>
                        <li><i class="fas fa-check"></i> Code generation & export</li>
                        <li><i class="fas fa-check"></i> Community support</li>
                    </ul>
                    <a href="/register.php" class="button button-primary button-block">Get Started</a>
                </div>
                <div class="pricing-card">
                    <div class="plan-badge">Coming Soon</div>
                    <p class="plan-name">Premium Plan</p>
                    <p class="price">$9<span>/month</span></p>
                    <ul>
                        <li><i class="fas fa-check"></i> Everything in Free</li>
                        <li><i class="fas fa-check"></i> Priority models</li>
                        <li><i class="fas fa-check"></i> Advanced analytics</li>
                        <li><i class="fas fa-check"></i> API access</li>
                        <li><i class="fas fa-check"></i> Priority support</li>
                    </ul>
                    <a href="#" class="button button-secondary button-block">Coming Soon</a>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <h2>Ready to get started?</h2>
            <p>Join thousands of users enjoying unlimited AI conversations today</p>
            <div class="cta-buttons">
                <a href="/register.php" class="button button-primary button-lg">Create Free Account <i class="fas fa-rocket"></i></a>
                <a href="/login.php" class="button button-secondary button-lg">Sign In <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4><i class="fas fa-sparkles"></i> AI Chat</h4>
                <p>Advanced AI conversations for everyone.</p>
            </div>
            <div class="footer-section">
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
            </div>
            <div class="footer-section">
                <h4>Company</h4>
                <a href="#">About</a>
                <a href="#">Blog</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 AI Chat. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
</body>

</html>

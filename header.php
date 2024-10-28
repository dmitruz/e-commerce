<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_COOKIE['is_admin']) && $_COOKIE['is_admin'] === "true") {
    $_SESSION['is_admin'] = true;
}

$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>

<header class="bg-light border-bottom sticky-header">
    <div class="container-fluid d-flex justify-content-between align-items-center py-3 m-0">
        <div class="logo">
            <a href="#" class="navbar-brand">
                <img src="./images/fridge-svgrepo-com.svg" alt="logo" width="40" height="40">
            </a>
        </div>
        <nav class="ms-auto">
            <ul class="nav">
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li class="nav-item">
                        <a href="create.php" class="btn btn-dark">Add Product</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="signout.php">Sign Out (<?= $_SESSION['user_name']; ?>)</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endif; ?>

                <li class="nav-item">
                    <div class="shopping-cart">
                        <a href="cart.php" class="nav-link">
                            <img src="images/shopping-cart-02.svg" alt="Shopping Cart" width="30" height="30">
                            <span class="cart-count"><?= $cart_count; ?></span>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Cookie Consent Modal -->
<div id="cookieConsent" class="cookie-consent-modal">
    <p class="cookie-text">We use cookies to improve your experience. By continuing, you agree to our use of cookies.</p>
    <button id="acceptCookies" class="btn btn-success">Accept</button>
    <button id="declineCookies" class="btn btn-secondary">Decline</button>
</div>

<style>
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: white;
    }
    .nav-item .btn, .nav-link {
        margin-left: 10px;
    }
    .shopping-cart {
        position: relative;
        display: flex;
        align-items: center;
    }
    .shopping-cart img {
        margin-right: 5px;
    }
    .cart-count {
        position: absolute;
        top: -5px;
        background-color: red;
        color: white;
        padding: 2px 6px;
        border-radius: 50%;
        font-size: 10px;
    }
    .cookie-consent-modal {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        padding: 10px;
        
        z-index: 9999;
    }
    .cookie-consent-modal p {
        margin: 20px;
    }
    
</style>

<script>
    // Check if the cookie consent has already been given
    if (!document.cookie.includes("cookieConsent=true")) {
        document.getElementById('cookieConsent').style.display = 'block';
    }

    // Handle the Accept button
    document.getElementById('acceptCookies').onclick = function() {
        document.cookie = "cookieConsent=true; path=/; max-age=" + 60 * 60 * 24 * 30;
        document.getElementById('cookieConsent').style.display = 'none';
    };

    // Handle the Decline button
    document.getElementById('declineCookies').onclick = function() {
        document.getElementById('cookieConsent').style.display = 'none';
    };
</script>

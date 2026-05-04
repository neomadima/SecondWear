<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear — Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #fefcf8; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 28px; }
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            flex-wrap: wrap;
            padding: 28px 0 20px 0;
            border-bottom: 1px solid #eae6df;
        }
        .logo { cursor: pointer; }
        .logo h1 { font-size: 32px; font-weight: 800; background: linear-gradient(135deg, #1f2a1e, #3a4a37); background-clip: text; -webkit-background-clip: text; color: transparent; }
        .nav-menu { display: flex; gap: 32px; flex-wrap: wrap; }
        .nav-link { text-decoration: none; font-weight: 500; color: #3a3a2e; padding: 6px 0; border-bottom: 2px solid transparent; }
        .nav-link:hover, .nav-link.active { color: #2c5e2a; border-bottom-color: #2c5e2a; }
        .profile-card { background: white; border-radius: 28px; padding: 32px; margin: 30px 0; border: 1px solid #eae2d6; }
        .info-row { display: flex; padding: 12px 0; border-bottom: 1px solid #f0ece6; flex-wrap: wrap; gap: 10px; }
        .info-label { width: 140px; font-weight: 600; color: #5c5a4a; }
        .footer-note { border-top: 1px solid #e2d9cf; padding: 32px 0; text-align: center; color: #6a5e4b; margin-top: 40px; }
    </style>
</head>
<body>
<div class="container">
    <div class="top-header">
        <div class="logo" onclick="location.href='index.php'"><h1>SecondWear <span>♻️ campus exchange</span></h1></div>
        <div class="nav-menu">
            <a href="index.php" class="nav-link">Home</a>
            <a href="shop.php" class="nav-link">Shop</a>
            <a href="sell.php" class="nav-link">Sell</a>
            <a href="cart.php" class="nav-link">Cart <span id="cartCount">(0)</span></a>
            <a href="profile.php" class="nav-link active">Profile</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a>
        </div>
    </div>
    <h2 style="margin-top: 30px;">👤 My Account</h2>
    <div class="profile-card">
        <div class="info-row"><div class="info-label">Full Name:</div><div>Thabo Nkosi</div></div>
        <div class="info-row"><div class="info-label">Email:</div><div>thabo@campus.ac.za</div></div>
        <div class="info-row"><div class="info-label">Campus:</div><div>Pretoria Campus</div></div>
        <div class="info-row"><div class="info-label">Member since:</div><div>March 2025</div></div>
        <div class="info-row"><div class="info-label">Escrow Wallet:</div><div><i class="fas fa-shield-alt"></i> R0.00</div></div>
    </div>
    <div class="footer-note">⭐ Smart pricing assistant active · Earn cashback on every sale</div>
</div>
<!-- Update the cart count badge using browser localStorage -->
<script>
    function updateCartCount() { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        let span = document.getElementById("cartCount");
        if(span) span.innerText = `(${cart.reduce((a,b)=>a+b.qty,0)})`;
    }
    updateCartCount();
    window.addEventListener('storage', () => updateCartCount());
</script>
</body>
</html>
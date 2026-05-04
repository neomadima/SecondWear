<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- cart.php — shopping cart page using localStorage; allows quantity updates and checkout simulation -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear — Cart</title>
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
        .cart-container { background: white; border-radius: 28px; padding: 32px; margin: 30px 0; border: 1px solid #eae2d6; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid #eee; flex-wrap: wrap; gap: 15px; }
        .cart-summary { text-align: right; padding: 25px 0; border-top: 2px solid #eae2d6; margin-top: 20px; }
        .btn-primary { background: #1f3b1a; color: white; padding: 14px 32px; border-radius: 40px; border: none; cursor: pointer; font-weight: 600; }
        .btn-secondary { background: #e9e2d4; padding: 8px 20px; border-radius: 40px; border: none; cursor: pointer; }
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
            <a href="cart.php" class="nav-link active">Cart <span id="cartCount">(0)</span></a>
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a></div>
    </div>
    <h2 style="margin-top: 30px;">🛒 Your Shopping Cart</h2>
    <div class="cart-container" id="cartContainer"></div>
    <div class="footer-note">🔒 Secure payments with Escrow — seller gets paid after you confirm receipt</div>
</div>
<script>
    function updateCartDisplay() {
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]");
        let countSpan = document.getElementById("cartCount");
        if(countSpan) countSpan.innerText = `(${cart.reduce((a,b)=>a+b.qty,0)})`;
        let container = document.getElementById("cartContainer");
        if(!container) return;
        if(cart.length === 0) { container.innerHTML = "<div style='text-align:center; padding:60px'><i class='fas fa-shopping-bag' style='font-size:48px; color:#ccc'></i><p style='margin-top:20px'>Your cart is empty. <a href='shop.php' style='color:#2c5e2a'>Start shopping →</a></p></div>"; return; }
        let html = "", total = 0;
        cart.forEach((item, idx) => { 
            total += item.price * item.qty;
            html += `<div class="cart-item"><div><strong>${item.name}</strong><br>R${item.price} × ${item.qty} = R${item.price * item.qty}<br><small><i class="fas fa-map-pin"></i> ${item.campus || "Various"}</small></div><div><button class="btn-secondary" onclick="updateQuantity(${idx}, -1)">-</button> <span style="margin:0 15px">${item.qty}</span> <button class="btn-secondary" onclick="updateQuantity(${idx}, 1)">+</button> <button class="btn-secondary" onclick="removeItem(${idx})">Remove</button></div></div>`;
        });
        html += `<div class="cart-summary"><h3>Total: R${total}</h3><br><button class="btn-primary" onclick="checkout()">Proceed to Checkout →</button></div>`;
        container.innerHTML = html;
    }
    window.updateQuantity = function(idx, delta) { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        if(cart[idx]) { cart[idx].qty += delta; if(cart[idx].qty <= 0) cart.splice(idx,1); localStorage.setItem("secondwear_cart", JSON.stringify(cart)); updateCartDisplay(); } 
    }
    window.removeItem = function(idx) { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        cart.splice(idx,1); localStorage.setItem("secondwear_cart", JSON.stringify(cart)); updateCartDisplay(); 
    }
    window.checkout = function() { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        if(cart.length===0) alert("Cart is empty"); 
        else { alert("✅ Escrow payment initiated! Funds held securely."); localStorage.setItem("secondwear_cart", "[]"); updateCartDisplay(); window.location.href = "profile.php"; } 
    }
    updateCartDisplay();
    window.addEventListener('storage', () => updateCartDisplay());
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- index.php — Main landing page for SecondWear with hero section, category shortcuts, and featured content -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear — Sustainable Campus Fashion</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #fefcf8; color: #1a1a1a; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 28px; }
        
        /* Navigation Bar */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px 0;
            border-bottom: 1px solid #eae6df;
            background: white;
        }
        .logo { cursor: pointer; }
        .logo h1 { font-size: 28px; font-weight: 800; color: #1a3b1a; }
        .logo span { font-size: 12px; font-weight: 400; color: #6b5e4a; margin-left: 5px; }
        .nav-menu { display: flex; gap: 32px; align-items: center; flex-wrap: wrap; }
        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: #333;
            font-size: 15px;
            transition: 0.2s;
        }
        .nav-link:hover, .nav-link.active { color: #2c5e2a; }
        .action-icons { display: flex; gap: 20px; }
        .action-icons .icon-btn {
            background: none;
            border: none;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 40px;
        }
        
        /* HERO SECTION */
        .hero {
            background: linear-gradient(135deg, #1a3b1a 0%, #2d5a2a 100%);
            border-radius: 28px;
            margin: 30px 0;
            padding: 60px 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .hero-content { flex: 1; min-width: 280px; }
        .hero-content h1 { font-size: 48px; font-weight: 800; margin-bottom: 20px; line-height: 1.2; }
        .hero-content p { font-size: 18px; margin-bottom: 30px; opacity: 0.9; }
        .hero-buttons { display: flex; gap: 15px; flex-wrap: wrap; }
        .btn-primary { background: white; color: #1a3b1a; padding: 12px 28px; border-radius: 40px; text-decoration: none; font-weight: 600; }
        .btn-outline { background: transparent; color: white; border: 2px solid white; padding: 12px 28px; border-radius: 40px; text-decoration: none; font-weight: 600; }
        .hero-image { flex: 1; text-align: center; min-width: 280px; }
        .hero-image i { font-size: 180px; opacity: 0.8; }
        
        /* FEATURES BANNER */
        .features {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin: 40px 0;
            padding: 30px 0;
            border-top: 1px solid #eae6df;
            border-bottom: 1px solid #eae6df;
        }
        .feature-item { text-align: center; flex: 1; min-width: 150px; }
        .feature-item i { font-size: 32px; color: #2c5e2a; margin-bottom: 12px; }
        .feature-item h4 { font-size: 16px; margin-bottom: 5px; }
        .feature-item p { font-size: 13px; color: #666; }
        
        /* SECTION TITLE */
        .section-title {
            text-align: center;
            margin: 50px 0 30px;
        }
        .section-title h2 { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
        .section-title p { color: #666; }
        
        /* CATEGORY GRID */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid #eae6df;
            transition: 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }
        .category-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); border-color: #2c5e2a; }
        .category-card i { font-size: 40px; color: #2c5e2a; margin-bottom: 15px; }
        .category-card h4 { font-size: 16px; font-weight: 600; }
        
        /* NEW ARRIVALS GRID */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 24px; margin: 30px 0; }
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: 0.25s;
            border: 1px solid #eee;
            cursor: pointer;
            position: relative;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .product-img { background-color: #f8f8f8; aspect-ratio: 1 / 1; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .product-img img { width: 100%; height: 100%; object-fit: cover; }
        .product-img i { font-size: 60px; color: #999; }
        .product-info { padding: 12px; }
        .product-title { font-weight: 600; font-size: 14px; margin-bottom: 4px; }
        .product-price { font-weight: 700; color: #2c5e2a; font-size: 16px; }
        .new-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #2c5e2a;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        /* PERSONA SECTION (Style Guides) */
        .persona-section { background: white; border-radius: 28px; padding: 40px; margin: 50px 0; border: 1px solid #eae6df; }
        .persona-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-top: 30px; }
        .persona-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 20px;
            background: #fefcf8;
            transition: 0.3s;
            cursor: pointer;
        }
        .persona-card:hover { background: #f0f5ec; transform: scale(1.02); }
        .persona-card i { font-size: 48px; color: #2c5e2a; margin-bottom: 15px; }
        .persona-card h4 { font-size: 20px; margin-bottom: 8px; }
        .persona-card p { font-size: 13px; color: #666; }
        
        /* CTA BANNER */
        .cta-banner {
            background: linear-gradient(135deg, #f5f2ec 0%, #e8e4dc 100%);
            border-radius: 28px;
            padding: 50px;
            text-align: center;
            margin: 50px 0;
        }
        .cta-banner h2 { font-size: 32px; margin-bottom: 15px; }
        .cta-banner p { color: #555; margin-bottom: 25px; }
        
        /* FOOTER */
        .footer { border-top: 1px solid #eae6df; padding: 40px 0 30px; margin-top: 50px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 30px; }
        .footer-col { flex: 1; min-width: 180px; }
        .footer-col h4 { margin-bottom: 15px; font-size: 16px; }
        .footer-col a { display: block; color: #666; text-decoration: none; font-size: 13px; margin-bottom: 8px; }
        .footer-col a:hover { color: #2c5e2a; }
        .copyright { text-align: center; padding-top: 30px; border-top: 1px solid #eae6df; margin-top: 30px; color: #888; font-size: 12px; }
        
        @media (max-width: 768px) {
            .hero { padding: 40px 30px; text-align: center; }
            .hero-content h1 { font-size: 32px; }
            .hero-buttons { justify-content: center; }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Navigation Bar -->
    <div class="top-header">
        <div class="logo" onclick="location.href='index.php'"><h1>SecondWear <span>♻️ campus exchange</span></h1></div>
        <div class="nav-menu">
            <a href="index.php" class="nav-link active">Home</a>
            <a href="shop.php" class="nav-link">Shop</a>
            <a href="sell.php" class="nav-link">Sell</a>
            <a href="cart.php" class="nav-link">Cart <span id="cartCount">(0)</span></a>
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a></div>
        <div class="action-icons">
            <button class="icon-btn"><i class="fas fa-search"></i></button>
            <button class="icon-btn"><i class="far fa-heart"></i></button>
        </div>
    </div>

    <!-- HERO SECTION -->
    <div class="hero">
        <div class="hero-content">
            <h1>Style that doesn't<br>cost the Earth</h1>
            <p>Shop pre-loved fashion from students across South Africa.<br>Save money, reduce waste, look amazing.</p>
            <div class="hero-buttons">
                <a href="shop.php" class="btn-primary">Shop Now →</a>
                <a href="sell.php" class="btn-outline">Sell Your Clothes</a>
            </div>
        </div>
        <div class="hero-image">
            <i class="fas fa-tshirt"></i>
        </div>
    </div>

    <!-- FEATURES -->
    <div class="features">
        <div class="feature-item"><i class="fas fa-shield-alt"></i><h4>Secure Escrow</h4><p>Payments protected</p></div>
        <div class="feature-item"><i class="fas fa-map-marker-alt"></i><h4>Campus Exchange</h4><p>Meet on campus</p></div>
        <div class="feature-item"><i class="fas fa-video"></i><h4>Fit-Check™</h4><p>Video authenticity</p></div>
        <div class="feature-item"><i class="fas fa-chart-line"></i><h4>Smart Pricing</h4><p>AI price assistant</p></div>
    </div>

    <!-- SHOP BY CATEGORY -->
    <div class="section-title">
        <h2>Shop by Category</h2>
        <p>Find exactly what you're looking for</p>
    </div>
    <div class="category-grid">
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-female"></i><h4>Women</h4></div>
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-male"></i><h4>Men</h4></div>
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-tshirt"></i><h4>Tops</h4></div>
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-shopping-bag"></i><h4>Dresses</h4></div>
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-shoe-prints"></i><h4>Jackets</h4></div>
        <div class="category-card" onclick="location.href='shop.php'"><i class="fas fa-shopping-cart"></i><h4>Accessories</h4></div>
    </div>

    <!-- NEW ARRIVALS SECTION -->
    <div class="section-title">
        <h2>🔥 Just Dropped</h2>
        <p>The latest pre-loved pieces added by students</p>
    </div>
    <div class="product-grid" id="newArrivalsGrid"></div>
    <div style="text-align: center;">
        <a href="shop.php" class="btn-primary" style="background: #2c5e2a; display: inline-block;">View All →</a>
    </div>

    <!-- STYLE GUIDES (Personas) -->
    <div class="persona-section">
        <div style="text-align: center;">
            <h2>Find Your Style</h2>
            <p>Discover looks curated just for you</p>
        </div>
        <div class="persona-grid">
            <div class="persona-card" onclick="alert('✨ The Cool girl collection coming soon!')">
                <i class="fas fa-sunglasses"></i>
                <h4>The Cool girl</h4>
                <p>edgy & streetwear</p>
            </div>
            <div class="persona-card" onclick="alert('✨ The Romantic girl collection coming soon!')">
                <i class="fas fa-feather-alt"></i>
                <h4>The Romantic girl</h4>
                <p>soft & dreamy</p>
            </div>
            <div class="persona-card" onclick="alert('✨ The Sexy girl collection coming soon!')">
                <i class="fas fa-fire"></i>
                <h4>The Sexy girl</h4>
                <p>bold & confident</p>
            </div>
            <div class="persona-card" onclick="alert('✨ The Influencer collection coming soon!')">
                <i class="fas fa-camera-retro"></i>
                <h4>The Influencer</h4>
                <p>trendsetting</p>
            </div>
        </div>
    </div>

    <!-- CTA BANNER -->
    <div class="cta-banner">
        <h2>Got clothes to sell?</h2>
        <p>Turn your pre-loved fashion into cash. It's free to list!</p>
        <a href="sell.php" class="btn-primary" style="background: #2c5e2a; display: inline-block;">Start Selling →</a>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-col">
            <h4>SecondWear</h4>
            <a href="#">About Us</a>
            <a href="#">How it Works</a>
            <a href="#">Buyer Protection</a>
            <a href="#">Sustainability</a>
        </div>
        <div class="footer-col">
            <h4>Shop</h4>
            <a href="shop.php">Women</a>
            <a href="shop.php">Men</a>
            <a href="#">New Arrivals</a>
            <a href="#">Sale</a>
        </div>
        <div class="footer-col">
            <h4>Sell</h4>
            <a href="sell.php">Start Selling</a>
            <a href="#">Selling Tips</a>
            <a href="#">Shipping Guide</a>
            <a href="#">Pricing Assistant</a>
        </div>
        <div class="footer-col">
            <h4>Support</h4>
            <a href="#">Help Center</a>
            <a href="#">Contact Us</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
        </div>
    </div>
    <div class="copyright">
        © 2025 SecondWear — Sustainable campus fashion exchange. All rights reserved.
    </div>
</div>

<!-- PRODUCT DETAIL MODAL (same as before) -->
<div id="productDetailPage" class="product-detail-page" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:white; z-index:2000; overflow-y:auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid #eee; background: white; position: sticky; top:0;">
        <button id="detailBackBtn" style="background:none; border:none; font-size:16px; cursor:pointer; display:flex; align-items:center; gap:8px; padding:8px 16px;"><i class="fas fa-arrow-left"></i> Back to Home</button>
        <button id="detailCloseBtn" style="background:none; border:none; font-size:24px; cursor:pointer; padding:8px 16px;"><i class="fas fa-times"></i></button>
    </div>
    <div id="detailContent"></div>
</div>

<style>
    .product-detail-page { display: none; }
    .product-detail-page.active { display: block; }
    .detail-container { display: flex; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; padding: 30px; gap: 40px; }
    .detail-image { flex: 1; min-width: 300px; background: #f8f8f8; border-radius: 16px; display: flex; align-items: center; justify-content: center; padding: 40px; }
    .detail-image i { font-size: 200px; color: #999; }
    .detail-info { flex: 1; min-width: 300px; }
    .detail-price { font-size: 28px; font-weight: 700; color: #0066cc; margin: 10px 0; }
    .detail-delivery { color: #666; font-size: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #eee; }
    .button-group { display: flex; gap: 12px; margin: 20px 0; }
    .buy-btn { flex: 1; background: #0066cc; color: white; border: none; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer; }
    .offer-btn { flex: 1; background: white; color: #0066cc; border: 1px solid #0066cc; padding: 14px; border-radius: 40px; font-weight: 600; cursor: pointer; }
    .seller-info { background: #f8f8f8; padding: 16px; border-radius: 12px; margin: 20px 0; display: flex; justify-content: space-between; }
    .detail-specs { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin: 20px 0; padding: 16px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
    .spec-item { display: flex; gap: 12px; }
    .spec-label { font-weight: 600; color: #666; min-width: 80px; }
    .protection-badge { background: #e8f4e8; color: #2e7d32; padding: 12px; border-radius: 8px; font-size: 13px; margin-top: 20px; text-align: center; }
    @media (max-width: 768px) { .detail-container { flex-direction: column; } .button-group { flex-direction: column; } }
</style>

<script>
    // New Arrivals Data (5 items for home page)
    const newArrivals = [
        { id: 1, name: "Floral Summer Dress", price: 210, campus: "Johannesburg", category: "Dresses", gender: "women", description: "Beautiful floral summer dress. Only worn once. Perfect condition.", size: "M", brand: "Zara", color: "Multi-floral", condition: "Like New", seller: "Sarah J.", sellerLocation: "Gauteng, Johannesburg", timePosted: "2 hours ago", imagePath: "images/Floral Summer Dress.webp" },
        { id: 2, name: "Ripcurl T-Shirt", price: 100, campus: "Gauteng", category: "Tops", gender: "men", description: "Ripcurl t-shirt. Only size inside slightly off. Rest perfect, no flaws.", size: "3XL", brand: "Rip Curl", color: "Turquoise", condition: "Like New", seller: "Mark S.", sellerLocation: "Gauteng, Irene", timePosted: "4 minutes ago", imagePath: "images/Ripcurl T-Shirt.webp" },
        { id: 3, name: "Leather Moto Jacket", price: 590, campus: "Cape Town", category: "Jackets", gender: "women", description: "Genuine leather moto jacket. Excellent condition.", size: "S", brand: "Zara", color: "Black", condition: "Excellent", seller: "Mike T.", sellerLocation: "Western Cape, Cape Town", timePosted: "5 hours ago", imagePath: "images/Leather Moto Jacket.webp" },
        { id: 4, name: "Classic Oxford Shirt", price: 279, campus: "Pretoria", category: "Shirts", gender: "men", description: "Classic Oxford shirt. Premium cotton. No flaws.", size: "L", brand: "Tommy Hilfiger", color: "White", condition: "Like New", seller: "David R.", sellerLocation: "Gauteng, Irene", timePosted: "4 minutes ago", imagePath: "images/Classic Oxford Shirt.webp" },
        { id: 5, name: "Oversized Knit Sweater", price: 180, campus: "Cape Town", category: "Sweaters", gender: "women", description: "Cozy oversized knit sweater. Like new condition.", size: "L", brand: "H&M", color: "Cream", condition: "Like New", seller: "Emma K.", sellerLocation: "Western Cape, Cape Town", timePosted: "1 day ago", imagePath: "images/Oversized Knit Sweater.webp" }
    ];

    function updateCartCount() { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        let span = document.getElementById("cartCount");
        if(span) span.innerText = `(${cart.reduce((a,b)=>a+b.qty,0)})`;
    }

    function addToCart(product, quantity = 1) { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        let existing = cart.find(p=>p.id===product.id); 
        if(existing) existing.qty += quantity; 
        else cart.push({...product, qty: quantity}); 
        localStorage.setItem("secondwear_cart", JSON.stringify(cart)); 
        updateCartCount(); 
        return true;
    }

    function getHomeProductById(id) {
        return newArrivals.find(p => p.id === id);
    }

    function openProductDetail(productOrId) {
        const product = typeof productOrId === 'object' ? productOrId : getHomeProductById(productOrId);
        if (!product) return;
        const detailPage = document.getElementById("productDetailPage");
        const detailContent = document.getElementById("detailContent");
        
        let imageHtml = '<i class="fas fa-tshirt"></i>';
        if (product.imageData) {
            imageHtml = `<img src="${product.imageData}" alt="${product.name}">`;
        } else if (product.imagePath) {
            imageHtml = `<img src="${product.imagePath}" alt="${product.name}">`;
        }
        
        detailContent.innerHTML = `
            <div class="detail-container">
                <div class="detail-image">${imageHtml}</div>
                <div class="detail-info">
                    <h1 style="font-size: 24px; margin-bottom: 8px;">${product.name}</h1>
                    <div class="detail-price">R ${product.price}</div>
                    <div class="detail-delivery">
                        <i class="fas fa-truck"></i> + Delivery from R 49 with The Courier Guy<br>
                        <i class="fas fa-shield-alt"></i> + Buyer Protection fee
                    </div>
                    <div class="button-group">
                        <button class="buy-btn" id="buyNowDetailBtn">Buy</button>
                        <button class="offer-btn" id="makeOfferBtn">Make an offer</button>
                    </div>
                    <div class="seller-info">
                        <div><i class="fas fa-clock"></i> ${product.timePosted || "Recently"}</div>
                        <div><i class="fas fa-map-marker-alt"></i> ${product.sellerLocation || product.campus}</div>
                    </div>
                    <div class="detail-description" style="margin:20px 0; line-height:1.6;">${product.description}</div>
                    <div class="detail-specs">
                        <div class="spec-item"><span class="spec-label">Size:</span><span class="spec-value">${product.size || "M"}</span></div>
                        <div class="spec-item"><span class="spec-label">Brand:</span><span class="spec-value">${product.brand || "Various"}</span></div>
                        <div class="spec-item"><span class="spec-label">Color:</span><span class="spec-value">${product.color || "Various"}</span></div>
                        <div class="spec-item"><span class="spec-label">Condition:</span><span class="spec-value">${product.condition || "Like New"}</span></div>
                        <div class="spec-item"><span class="spec-label">Gender:</span><span class="spec-value">${product.gender === "women" ? "Women" : "Men"}</span></div>
                    </div>
                    <div class="protection-badge">
                        <i class="fas fa-shield-alt"></i> Buyer Protection is applied to all purchases made on SecondWear
                    </div>
                </div>
            </div>
        `;
        
        detailPage.classList.add("active");
        document.body.style.overflow = "hidden";
        
        setTimeout(() => {
            document.getElementById("buyNowDetailBtn").onclick = () => {
                addToCart(product, 1);
                alert(`✅ ${product.name} added to cart!`);
                closeDetailPage();
            };
            document.getElementById("makeOfferBtn").onclick = () => {
                let offer = prompt("Enter your offer amount (R):", product.price - 20);
                if(offer && !isNaN(offer)) alert(`💰 Offer of R${offer} sent to seller!`);
            };
        }, 50);
    }

    function closeDetailPage() {
        document.getElementById("productDetailPage").classList.remove("active");
        document.body.style.overflow = "auto";
    }

    function renderNewArrivals() {
        let grid = document.getElementById("newArrivalsGrid");
        if(!grid) return;
        grid.innerHTML = newArrivals.map(p => {
            let thumbHtml = '<i class="fas fa-tshirt"></i>';
            if (p.imageData) {
                thumbHtml = `<img src="${p.imageData}" alt="${p.name}">`;
            } else if (p.imagePath) {
                thumbHtml = `<img src="${p.imagePath}" alt="${p.name}">`;
            }
            return `
            <div class="product-card" onclick="openProductDetail(${p.id})">
                <div class="new-badge">🔥 NEW</div>
                <div class="product-img">${thumbHtml}</div>
                <div class="product-info">
                    <div class="product-title">${p.name}</div>
                    <div class="product-price">R ${p.price}</div>
                    <div style="font-size:11px; color:#888;"><i class="fas fa-map-marker-alt"></i> ${p.campus}</div>
                </div>
            </div>
        `}).join("");
    }

    document.getElementById("detailBackBtn").onclick = closeDetailPage;
    document.getElementById("detailCloseBtn").onclick = closeDetailPage;
    window.onclick = (e) => { if (e.target === document.getElementById("productDetailPage")) closeDetailPage(); };

    renderNewArrivals();
    updateCartCount();
    window.openProductDetail = openProductDetail;
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- shop.php — product browsing page with filters, gender tabs, and detail view -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear — Shop All</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Your existing styles – keep them exactly as before */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; color: #111; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 28px; }
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 20px 0;
            border-bottom: 1px solid #e0e0e0;
            background: white;
        }
        .logo { cursor: pointer; }
        .logo h1 { font-size: 28px; font-weight: 800; color: #1a3b1a; }
        .logo span { font-size: 12px; font-weight: 400; color: #6b5e4a; margin-left: 5px; }
        .nav-menu { display: flex; gap: 32px; flex-wrap: wrap; }
        .nav-link { text-decoration: none; font-weight: 500; color: #333; font-size: 15px; transition: 0.2s; }
        .nav-link:hover, .nav-link.active { color: #2c5e2a; }
        .action-icons .icon-btn { background: none; border: none; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 40px; }
        .filters-section {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin: 30px 0;
            border: 1px solid #eee;
        }
        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }
        .gender-buttons {
            display: flex;
            gap: 8px;
            background: #f5f5f5;
            padding: 4px;
            border-radius: 40px;
        }
        .gender-btn {
            padding: 10px 24px;
            border-radius: 40px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            background: transparent;
            transition: 0.2s;
        }
        .gender-btn.active {
            background: #2c5e2a;
            color: white;
        }
        .filter-select {
            padding: 10px 20px;
            border-radius: 40px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            font-family: inherit;
            min-width: 160px;
        }
        .results-count {
            margin-left: auto;
            font-size: 14px;
            color: #666;
        }
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
        .product-location { font-size: 11px; color: #888; margin-top: 4px; }
        .user-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff9800;
            color: white;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }
        .footer-note { border-top: 1px solid #e0e0e0; padding: 24px 0; text-align: center; color: #666; font-size: 12px; margin-top: 40px; }
        .product-detail-page {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 2000;
            overflow-y: auto;
        }
        .product-detail-page.active { display: block; }
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #eee;
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .back-btn {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #333;
            padding: 8px 16px;
            border-radius: 30px;
        }
        .back-btn:hover { background: #f0f0f0; }
        .detail-container { display: flex; flex-wrap: wrap; max-width: 1200px; margin: 0 auto; padding: 30px; gap: 40px; }
        .detail-image { flex: 1; min-width: 300px; background: #f8f8f8; border-radius: 16px; display: flex; align-items: center; justify-content: center; padding: 40px; overflow: hidden; }
        .detail-image img { max-width: 100%; max-height: 400px; object-fit: contain; }
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
        @media (max-width: 768px) {
            .filter-row { flex-direction: column; align-items: stretch; }
            .gender-buttons { align-self: flex-start; }
            .results-count { margin-left: 0; margin-top: 10px; }
            .detail-container { flex-direction: column; }
            .button-group { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="top-header">
        <div class="logo" onclick="location.href='index.php'"><h1>SecondWear <span>♻️ campus exchange</span></h1></div>
        <div class="nav-menu">
            <a href="index.php" class="nav-link">Home</a>
            <a href="shop.php" class="nav-link active">Shop</a>
            <a href="sell.php" class="nav-link">Sell</a>
            <a href="cart.php" class="nav-link">Cart <span id="cartCount">(0)</span></a>
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a>
        </div>
        <div class="action-icons"><button class="icon-btn"><i class="fas fa-search"></i></button></div>
    </div>

    <h2 style="margin-top: 20px;">🛍️ Shop All Items</h2>

    <div class="filters-section">
        <div class="filter-row">
            <div class="gender-buttons">
                <button class="gender-btn active" data-gender="women">👩 Women</button>
                <button class="gender-btn" data-gender="men">👨 Men</button>
            </div>
            <select id="categoryFilter" class="filter-select">
                <option value="all">All Categories</option>
            </select>
            <select id="campusFilter" class="filter-select">
                <option value="all">All Campuses</option>
                <option>Pretoria</option><option>Johannesburg</option><option>Cape Town</option><option>Durban</option>
            </select>
            <select id="sortFilter" class="filter-select">
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
            </select>
            <div class="results-count" id="resultsCount">Showing 0 items</div>
        </div>
    </div>

    <div class="product-grid" id="shopGrid"></div>
    <div class="footer-note">© SecondWear — secure escrow payments · Buyer Protection on all purchases</div>
</div>

<!-- PRODUCT DETAIL MODAL -->
<div id="productDetailPage" class="product-detail-page">
    <div class="detail-header">
        <button class="back-btn" id="detailBackBtn"><i class="fas fa-arrow-left"></i> Back to products</button>
        <button class="back-btn" id="detailCloseBtn"><i class="fas fa-times"></i></button>
    </div>
    <div id="detailContent"></div>
</div>

<script>
    // ------------------------------------------------------------
    // DEFAULT PRODUCTS WITH IMAGE BASE64 FIELDS (fill in your own)
    // ------------------------------------------------------------
    const defaultWomenProducts = [
        { id: 1, name: "Floral Summer Dress", price: 210, campus: "Johannesburg", category: "Dresses", gender: "women", description: "Beautiful floral summer dress. Only worn once. Perfect condition.", size: "M", brand: "Zara", color: "Multi-floral", condition: "Like New", seller: "Sarah J.", sellerLocation: "Gauteng, Johannesburg", timePosted: "2 hours ago", imagePath: "images/Floral Summer Dress.webp", imageBase64: "" },
        { id: 2, name: "Little Black Dress", price: 189, campus: "Pretoria", category: "Dresses", gender: "women", description: "Classic little black dress. Timeless piece.", size: "S", brand: "H&M", color: "Black", condition: "Like New", seller: "Emma K.", sellerLocation: "Gauteng, Pretoria", timePosted: "1 day ago", imagePath: "images/Little Black Dress.webp", imageBase64: "" },
        { id: 3, name: "Bohemian Maxi Dress", price: 299, campus: "Cape Town", category: "Dresses", gender: "women", description: "Flowing bohemian maxi dress.", size: "L", brand: "Free People", color: "Multi", condition: "Excellent", seller: "Lisa N.", sellerLocation: "Cape Town", timePosted: "5 hours ago", imagePath: "images/Bohemian Maxi Dress.webp", imageBase64: "" },
        { id: 4, name: "Satin Slip Dress", price: 165, campus: "Durban", category: "Dresses", gender: "women", description: "Elegant satin slip dress.", size: "XS", brand: "Forever New", color: "Champagne", condition: "Like New", seller: "Thando M.", sellerLocation: "Durban", timePosted: "1 day ago", imagePath: "images/Satin Slip Dress.webp", imageBase64: "" },
        { id: 5, name: "Wrap Midi Dress", price: 245, campus: "Johannesburg", category: "Dresses", gender: "women", description: "Flattering wrap-style midi dress.", size: "M", brand: "Zara", color: "Navy", condition: "Very Good", seller: "Amy W.", sellerLocation: "Johannesburg", timePosted: "3 days ago", imagePath: "images/Wrap Midi Dress.webp", imageBase64: "" },
        { id: 6, name: "Cropped T-Shirt", price: 89, campus: "Johannesburg", category: "Tops", gender: "women", description: "Trendy cropped t-shirt.", size: "M", brand: "Cotton On", color: "White", condition: "Like New", seller: "Nadia K.", sellerLocation: "Johannesburg", timePosted: "1 week ago", imagePath: "images/Cropped T-Shirt.webp", imageBase64: "" },
        { id: 7, name: "Silk Blouse", price: 159, campus: "Pretoria", category: "Tops", gender: "women", description: "Luxurious silk blouse.", size: "S", brand: "Zara", color: "Ivory", condition: "Excellent", seller: "Claire B.", sellerLocation: "Pretoria", timePosted: "4 days ago", imagePath: "images/Silk Blouse.webp", imageBase64: "" },
        { id: 8, name: "High-Rise Cargo Pants", price: 245, campus: "Pretoria", category: "Pants", gender: "women", description: "Trendy cargo pants.", size: "M", brand: "Zara", color: "Olive", condition: "Like New", seller: "Sarah J.", sellerLocation: "Pretoria", timePosted: "1 week ago", imagePath: "images/High-Rise Cargo Pants.webp", imageBase64: "" },
        { id: 9, name: "Leather Moto Jacket", price: 590, campus: "Cape Town", category: "Jackets", gender: "women", description: "Genuine leather moto jacket.", size: "S", brand: "Zara", color: "Black", condition: "Excellent", seller: "Mike T.", sellerLocation: "Cape Town", timePosted: "5 hours ago", imagePath: "images/Leather Moto Jacket.webp", imageBase64: "" },
        { id: 10, name: "Oversized Knit Sweater", price: 180, campus: "Cape Town", category: "Sweaters", gender: "women", description: "Cozy oversized knit sweater.", size: "L", brand: "H&M", color: "Cream", condition: "Like New", seller: "Emma K.", sellerLocation: "Cape Town", timePosted: "1 day ago", imagePath: "images/Oversized Knit Sweater.webp", imageBase64: "" }
    ];

    const defaultMenProducts = [
        { id: 101, name: "Classic Oxford Shirt", price: 279, campus: "Pretoria", category: "Shirts", gender: "men", description: "Classic Oxford shirt. Premium cotton.", size: "L", brand: "Tommy Hilfiger", color: "White", condition: "Like New", seller: "David R.", sellerLocation: "Pretoria", timePosted: "4 minutes ago", imagePath: "images/Classic Oxford Shirt.webp", imageBase64: "" },
        { id: 102, name: "Bomber Jacket", price: 460, campus: "Cape Town", category: "Jackets", gender: "men", description: "Classic bomber jacket.", size: "XL", brand: "Nike", color: "Navy", condition: "Like New", seller: "John K.", sellerLocation: "Cape Town", timePosted: "1 hour ago", imagePath: "images/Bomber Jacket.webp", imageBase64: "" },
        { id: 103, name: "Slim Fit Chinos", price: 310, campus: "Johannesburg", category: "Pants", gender: "men", description: "Modern slim fit chinos.", size: "32", brand: "Woolworths", color: "Khaki", condition: "Like New", seller: "Peter W.", sellerLocation: "Johannesburg", timePosted: "2 hours ago", imagePath: "images/Slim Fit Chinos.webp", imageBase64: "" },
        { id: 104, name: "Merino Wool Sweater", price: 399, campus: "Pretoria", category: "Sweaters", gender: "men", description: "Luxury merino wool sweater.", size: "M", brand: "Country Road", color: "Charcoal", condition: "Excellent", seller: "James B.", sellerLocation: "Pretoria", timePosted: "6 hours ago", imagePath: "images/Merino Wool Sweater.webp", imageBase64: "" },
        { id: 105, name: "Ripcurl T-Shirt", price: 100, campus: "Gauteng", category: "Tops", gender: "men", description: "Ripcurl t-shirt. Only size inside slightly off.", size: "3XL", brand: "Rip Curl", color: "Turquoise", condition: "Like New", seller: "Mark S.", sellerLocation: "Gauteng", timePosted: "4 minutes ago", imagePath: "images/Ripcurl T-Shirt.webp", imageBase64: "" },
        { id: 106, name: "Graphic T-Shirt", price: 129, campus: "Durban", category: "Tops", gender: "men", description: "Streetwear graphic tee.", size: "XL", brand: "Unknown", color: "Black", condition: "Like New", seller: "Andile S.", sellerLocation: "Durban", timePosted: "1 day ago", imagePath: "images/Graphic T-Shirt.webp", imageBase64: "" },
        { id: 107, name: "Denim Jacket", price: 359, campus: "Pretoria", category: "Jackets", gender: "men", description: "Classic denim jacket.", size: "L", brand: "Levi's", color: "Blue", condition: "Very Good", seller: "Chris T.", sellerLocation: "Pretoria", timePosted: "3 hours ago", imagePath: "images/Denim Jacket.webp", imageBase64: "" }
    ];

    const womenCategories = ["Dresses", "Tops", "Pants", "Jackets", "Sweaters"];
    const menCategories = ["Shirts", "Tops", "Pants", "Jackets", "Sweaters"];

    let currentGender = "women";
    let currentCampus = "all";
    let currentCategory = "all";
    let currentSort = "price_asc";

    function getUserProducts() {
        return JSON.parse(localStorage.getItem("secondwear_products") || "[]");
    }

    function getAllProducts() {
        const defaultProducts = currentGender === "women" ? defaultWomenProducts : defaultMenProducts;
        const userProducts = getUserProducts().filter(p => p.gender === currentGender);
        return [...defaultProducts, ...userProducts];
    }

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

    function getProductById(id) {
        return getAllProducts().find(p => p.id === id);
    }

    function openProductDetail(productOrId) {
        const product = typeof productOrId === 'object' ? productOrId : getProductById(productOrId);
        if (!product) return;
        const detailPage = document.getElementById("productDetailPage");
        const detailContent = document.getElementById("detailContent");
        
        // Determine which image to show: user uploaded (imageData) > image file path > base64 > fallback icon
        let imageHtml = '<i class="fas fa-tshirt"></i>';
        if (product.imageData) {
            imageHtml = `<img src="${product.imageData}" alt="${product.name}">`;
        } else if (product.imagePath) {
            imageHtml = `<img src="${product.imagePath}" alt="${product.name}">`;
        } else if (product.imageBase64 && product.imageBase64.trim() !== "") {
            imageHtml = `<img src="${product.imageBase64}" alt="${product.name}">`;
        }
        
        detailContent.innerHTML = `
            <div class="detail-container">
                <div class="detail-image">
                    ${imageHtml}
                </div>
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
                    <div class="detail-description">${product.description}</div>
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

    function updateCategoryDropdown() {
        const categories = currentGender === "women" ? womenCategories : menCategories;
        const dropdown = document.getElementById("categoryFilter");
        dropdown.innerHTML = '<option value="all">📁 All Categories</option>' + 
            categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');
    }

    function renderShop() {
        let products = getAllProducts();
        let filtered = [...products];
        
        if(currentCampus !== "all") {
            filtered = filtered.filter(p => p.campus === currentCampus);
        }
        if(currentCategory !== "all") {
            filtered = filtered.filter(p => p.category === currentCategory);
        }
        
        if(currentSort === "price_asc") {
            filtered.sort((a,b)=>a.price-b.price);
        } else if(currentSort === "price_desc") {
            filtered.sort((a,b)=>b.price-a.price);
        }
        
        const resultsCount = document.getElementById("resultsCount");
        if(resultsCount) {
            resultsCount.innerHTML = `📊 Showing ${filtered.length} of ${products.length} items`;
        }
        
        let grid = document.getElementById("shopGrid");
        if(!grid) return;
        
        if(filtered.length === 0) { 
            grid.innerHTML = "<div style='grid-column:1/-1; text-align:center; padding:60px'><i class='fas fa-search' style='font-size:48px; color:#ccc'></i><p style='margin-top:20px'>No items found. Try different filters!</p></div>"; 
            return; 
        }
        
        grid.innerHTML = filtered.map(p => {
            // Determine thumbnail image
            let thumbHtml = '<i class="fas fa-tshirt"></i>';
            if (p.imageData) {
                thumbHtml = `<img src="${p.imageData}" alt="${p.name}">`;
            } else if (p.imagePath) {
                thumbHtml = `<img src="${p.imagePath}" alt="${p.name}">`;
            } else if (p.imageBase64 && p.imageBase64.trim() !== "") {
                thumbHtml = `<img src="${p.imageBase64}" alt="${p.name}">`;
            }
            
            return `
            <div class="product-card" onclick="openProductDetail(${p.id})">
                <div class="product-img">
                    ${thumbHtml}
                </div>
                <div class="product-info">
                    <div class="product-title">${p.name}</div>
                    <div class="product-price">R ${p.price}</div>
                    <div class="product-location"><i class="fas fa-map-marker-alt"></i> ${p.campus}</div>
                </div>
                ${p.isUserAdded ? '<div class="user-badge">👤 User Listing</div>' : ''}
            </div>
        `}).join("");
    }

    function setGender(gender) {
        currentGender = gender;
        currentCategory = "all";
        document.getElementById("categoryFilter").value = "all";
        updateCategoryDropdown();
        renderShop();
        
        document.querySelectorAll(".gender-btn").forEach(btn => {
            if(btn.getAttribute("data-gender") === gender) {
                btn.classList.add("active");
            } else {
                btn.classList.remove("active");
            }
        });
    }

    document.querySelectorAll(".gender-btn").forEach(btn => {
        btn.onclick = () => setGender(btn.getAttribute("data-gender"));
    });
    
    document.getElementById("categoryFilter").onchange = (e) => { 
        currentCategory = e.target.value; 
        renderShop(); 
    };
    
    document.getElementById("campusFilter").onchange = (e) => { 
        currentCampus = e.target.value; 
        renderShop(); 
    };
    
    document.getElementById("sortFilter").onchange = (e) => { 
        currentSort = e.target.value; 
        renderShop(); 
    };
    
    document.getElementById("detailBackBtn").onclick = closeDetailPage;
    document.getElementById("detailCloseBtn").onclick = closeDetailPage;
    window.onclick = (e) => { if (e.target === document.getElementById("productDetailPage")) closeDetailPage(); };
    
    window.addEventListener('storage', () => {
        renderShop();
        updateCartCount();
    });

    updateCategoryDropdown();
    renderShop();
    updateCartCount();
    window.openProductDetail = openProductDetail;
</script>
</body>
</html>
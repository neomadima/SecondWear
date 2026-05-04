<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- sell.php — item listing page for sellers with image upload, product details, and user-generated listings -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecondWear — Sell Your Items</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: #f5f5f5; color: #1a1a1a; }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 28px; }
        
        /* Navigation Bar */
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
        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: #333;
            font-size: 15px;
            transition: 0.2s;
        }
        .nav-link:hover, .nav-link.active { color: #2c5e2a; }
        .action-icons .icon-btn { background: none; border: none; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 40px; }
        
        /* Sell Page Styles */
        .sell-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin: 30px 0;
        }
        
        /* Left Column - Image Upload */
        .image-upload-section {
            flex: 1;
            min-width: 300px;
            background: white;
            border-radius: 24px;
            padding: 24px;
            border: 1px solid #eee;
        }
        .image-upload-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .camera-container {
            background: #f8f8f8;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            border: 2px dashed #ccc;
            transition: 0.3s;
            cursor: pointer;
        }
        .camera-container:hover {
            border-color: #2c5e2a;
            background: #f0f5ec;
        }
        .camera-icon {
            font-size: 60px;
            color: #2c5e2a;
            margin-bottom: 15px;
        }
        .camera-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        .camera-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .camera-btn {
            padding: 10px 20px;
            border-radius: 40px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .camera-btn-primary {
            background: #2c5e2a;
            color: white;
        }
        .camera-btn-secondary {
            background: #e0e0e0;
            color: #333;
        }
        .image-preview {
            margin-top: 20px;
            display: none;
        }
        .image-preview.active {
            display: block;
        }
        .preview-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 15px;
        }
        .remove-img-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 13px;
        }
        .image-instructions {
            font-size: 12px;
            color: #888;
            margin-top: 15px;
            text-align: center;
        }
        
        /* Right Column - Product Details Form */
        .product-form-section {
            flex: 1.5;
            min-width: 350px;
            background: white;
            border-radius: 24px;
            padding: 24px;
            border: 1px solid #eee;
        }
        .form-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            transition: 0.2s;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #2c5e2a;
        }
        .form-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .form-row .form-group {
            flex: 1;
        }
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #2c5e2a;
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.2s;
        }
        .submit-btn:hover {
            background: #1a3b1a;
        }
        
        /* Tips Section */
        .tips-section {
            background: #e8f4e8;
            border-radius: 16px;
            padding: 20px;
            margin-top: 30px;
        }
        .tips-title {
            font-weight: 600;
            margin-bottom: 12px;
        }
        .tips-list {
            list-style: none;
        }
        .tips-list li {
            margin-bottom: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tips-list li i {
            color: #2c5e2a;
        }
        
        /* My Listings Section */
        .listings-section {
            margin: 40px 0;
            background: white;
            border-radius: 24px;
            padding: 24px;
            border: 1px solid #eee;
        }
        .listings-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .listing-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #eee;
            flex-wrap: wrap;
            gap: 15px;
        }
        .listing-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .listing-thumb {
            width: 60px;
            height: 60px;
            background: #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .listing-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .listing-thumb i {
            font-size: 30px;
            color: #999;
        }
        .listing-details h4 {
            font-size: 16px;
            margin-bottom: 4px;
        }
        .listing-details p {
            font-size: 13px;
            color: #666;
        }
        .listing-price {
            font-weight: 700;
            color: #2c5e2a;
            font-size: 18px;
        }
        .delete-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 30px;
            cursor: pointer;
        }
        .empty-listings {
            text-align: center;
            padding: 40px;
            color: #888;
        }
        
        .footer-note { border-top: 1px solid #e0e0e0; padding: 24px 0; text-align: center; color: #666; font-size: 12px; margin-top: 40px; }
        
        @media (max-width: 768px) {
            .sell-container { flex-direction: column; }
            .form-row { flex-direction: column; gap: 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="top-header">
        <div class="logo" onclick="location.href='index.php'"><h1>SecondWear <span>♻️ campus exchange</span></h1></div>
        <div class="nav-menu">
            <a href="index.php" class="nav-link">Home</a>
            <a href="shop.php" class="nav-link">Shop</a>
            <a href="sell.php" class="nav-link active">Sell</a>
            <a href="cart.php" class="nav-link">Cart <span id="cartCount">(0)</span></a>
            <a href="profile.php" class="nav-link">Profile</a>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a></div>
        <div class="action-icons"><button class="icon-btn"><i class="fas fa-question-circle"></i> Help</button></div>
    </div>

    <h2 style="margin-top: 30px;">📦 Sell Your Pre-Loved Items</h2>
    <p style="color: #666; margin-bottom: 20px;">Take a photo and list your item in minutes. It's free to sell!</p>

    <div class="sell-container">
        <!-- LEFT COLUMN - CAMERA / PHOTO UPLOAD -->
        <div class="image-upload-section">
            <div class="image-upload-title">
                <i class="fas fa-camera"></i> Product Photo
            </div>
            
            <div class="camera-container" id="cameraArea">
                <div class="camera-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="camera-text">
                    Take a photo or upload from your device
                </div>
                <div class="camera-buttons">
                    <button class="camera-btn camera-btn-primary" id="openCameraBtn">
                        <i class="fas fa-camera"></i> Take Photo
                    </button>
                    <button class="camera-btn camera-btn-secondary" id="uploadFileBtn">
                        <i class="fas fa-upload"></i> Upload Image
                    </button>
                </div>
                <input type="file" id="fileInput" accept="image/*" capture="environment" style="display: none;">
                <div class="image-instructions">
                    <i class="fas fa-info-circle"></i> For best results, use good lighting and show the item clearly
                </div>
            </div>
            
            <div class="image-preview" id="imagePreview">
                <img id="previewImg" class="preview-img" alt="Product preview">
                <button class="remove-img-btn" id="removeImageBtn">
                    <i class="fas fa-trash"></i> Remove Photo
                </button>
            </div>
        </div>

        <!-- RIGHT COLUMN - PRODUCT DETAILS FORM -->
        <div class="product-form-section">
            <div class="form-title">
                <i class="fas fa-info-circle"></i> Item Details
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-tag"></i> Item Name *</label>
                <input type="text" id="itemName" placeholder="e.g., Vintage Levi's Jeans, Nike Air Max">
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-ruler"></i> Size *</label>
                    <select id="itemSize">
                        <option value="">Select Size</option>
                        <option>XS</option><option>S</option><option>M</option><option>L</option>
                        <option>XL</option><option>XXL</option><option>3XL</option>
                        <option>28</option><option>30</option><option>32</option><option>34</option><option>36</option><option>38</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tag"></i> Brand</label>
                    <input type="text" id="itemBrand" placeholder="e.g., Zara, Nike, H&M">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-tshirt"></i> Category *</label>
                    <select id="itemCategory">
                        <option value="">Select Category</option>
                        <option>Dresses</option><option>Tops</option><option>Pants</option>
                        <option>Skirts</option><option>Jackets</option><option>Sweaters</option>
                        <option>Shirts</option><option>Jeans</option><option>Shorts</option>
                        <option>Activewear</option><option>Shoes</option><option>Accessories</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-venus-mars"></i> Gender *</label>
                    <select id="itemGender">
                        <option value="women">Women</option>
                        <option value="men">Men</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Campus *</label>
                    <select id="itemCampus">
                        <option>Pretoria</option>
                        <option>Johannesburg</option>
                        <option>Cape Town</option>
                        <option>Durban</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Price (R) *</label>
                    <input type="number" id="itemPrice" placeholder="e.g., 299">
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-palette"></i> Color</label>
                <input type="text" id="itemColor" placeholder="e.g., Black, Blue, Red">
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-align-left"></i> Description *</label>
                <textarea id="itemDesc" rows="4" placeholder="Describe your item - condition, size details, any flaws, why you're selling..."></textarea>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-star"></i> Condition *</label>
                <select id="itemCondition">
                    <option>Like New - Worn once or twice</option>
                    <option>Excellent - Minimal wear</option>
                    <option>Very Good - Some signs of use</option>
                    <option>Good - Visible wear but functional</option>
                </select>
            </div>
            
            <button class="submit-btn" id="submitListingBtn">
                <i class="fas fa-cloud-upload-alt"></i> Publish Listing
            </button>
            
            <div class="tips-section">
                <div class="tips-title">
                    <i class="fas fa-lightbulb"></i> Selling Tips
                </div>
                <ul class="tips-list">
                    <li><i class="fas fa-check-circle"></i> Take clear, well-lit photos</li>
                    <li><i class="fas fa-check-circle"></i> Be honest about condition</li>
                    <li><i class="fas fa-check-circle"></i> Price competitively - check similar items</li>
                    <li><i class="fas fa-check-circle"></i> Respond quickly to buyer questions</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- MY LISTINGS SECTION -->
    <div class="listings-section">
        <div class="listings-title">
            <i class="fas fa-list-ul"></i> Your Active Listings
        </div>
        <div id="myListings"></div>
    </div>

    <div class="footer-note">💰 Earn money safely — Escrow payment releases after buyer confirms delivery</div>
</div>

<script>
    let uploadedImageData = null;
    let userListings = JSON.parse(localStorage.getItem("secondwear_products") || "[]");
    
    function updateCartCount() { 
        let cart = JSON.parse(localStorage.getItem("secondwear_cart") || "[]"); 
        let span = document.getElementById("cartCount");
        if(span) span.innerText = `(${cart.reduce((a,b)=>a+b.qty,0)})`;
    }
    
    function saveListings() { 
        localStorage.setItem("secondwear_products", JSON.stringify(userListings)); 
        renderListings();
        // Trigger storage event for shop page to update
        window.dispatchEvent(new Event('storage'));
    }
    
    window.deleteListing = function(idx) { 
        userListings.splice(idx,1); 
        saveListings(); 
    }
    
    function renderListings() {
        let container = document.getElementById("myListings");
        if(!container) return;
        if(userListings.length === 0) { 
            container.innerHTML = "<div class='empty-listings'><i class='fas fa-box-open' style='font-size:48px; color:#ccc; margin-bottom:15px; display:block;'></i>No listings yet. Upload your first item above!</div>"; 
            return; 
        }
        container.innerHTML = userListings.map((l,idx) => `
            <div class="listing-card">
                <div class="listing-info">
                    <div class="listing-thumb">
                        ${l.imageData ? `<img src="${l.imageData}" style="width:60px; height:60px; object-fit:cover; border-radius:12px;">` : '<i class="fas fa-tshirt"></i>'}
                    </div>
                    <div class="listing-details">
                        <h4>${l.name}</h4>
                        <p>${l.category} · ${l.size} · ${l.campus}</p>
                        <p style="font-size:12px; color:#888;">${l.condition}</p>
                    </div>
                    <div class="listing-price">R ${l.price}</div>
                </div>
                <button class="delete-btn" onclick="deleteListing(${idx})">Remove</button>
            </div>
        `).join("");
    }
    
    function handleImage(file) {
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadedImageData = e.target.result;
                document.getElementById("previewImg").src = uploadedImageData;
                document.getElementById("imagePreview").classList.add("active");
                document.getElementById("cameraArea").style.display = "none";
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please select an image file");
        }
    }
    
    document.getElementById("openCameraBtn").onclick = () => {
        const input = document.getElementById("fileInput");
        input.setAttribute('capture', 'environment');
        input.click();
    };
    
    document.getElementById("uploadFileBtn").onclick = () => {
        const input = document.getElementById("fileInput");
        input.removeAttribute('capture');
        input.click();
    };
    
    document.getElementById("fileInput").onchange = (e) => {
        if (e.target.files && e.target.files[0]) {
            handleImage(e.target.files[0]);
        }
    };
    
    document.getElementById("removeImageBtn").onclick = () => {
        uploadedImageData = null;
        document.getElementById("imagePreview").classList.remove("active");
        document.getElementById("cameraArea").style.display = "block";
        document.getElementById("fileInput").value = "";
    };
    
    document.getElementById("submitListingBtn").onclick = () => {
        let name = document.getElementById("itemName").value;
        let price = parseInt(document.getElementById("itemPrice").value);
        let size = document.getElementById("itemSize").value;
        let brand = document.getElementById("itemBrand").value;
        let category = document.getElementById("itemCategory").value;
        let gender = document.getElementById("itemGender").value;
        let campus = document.getElementById("itemCampus").value;
        let color = document.getElementById("itemColor").value;
        let desc = document.getElementById("itemDesc").value;
        let condition = document.getElementById("itemCondition").value;
        
        if(!name) { alert("Please enter item name"); return; }
        if(!price || price <= 0) { alert("Please enter a valid price"); return; }
        if(!size) { alert("Please select a size"); return; }
        if(!category) { alert("Please select a category"); return; }
        if(!desc) { alert("Please enter a description"); return; }
        if(!uploadedImageData) { alert("Please take or upload a photo of your item"); return; }
        
        let newItem = { 
            id: Date.now(), 
            name, 
            price, 
            size,
            brand: brand || "Not specified",
            category, 
            gender, 
            campus, 
            color: color || "Not specified",
            description: desc, 
            condition: condition.split(" - ")[0],
            imageData: uploadedImageData,
            timePosted: "Just now",
            sellerLocation: campus,
            seller: "You",
            isUserAdded: true
        };
        
        userListings.push(newItem);
        saveListings();
        
        document.getElementById("itemName").value = "";
        document.getElementById("itemPrice").value = "";
        document.getElementById("itemSize").value = "";
        document.getElementById("itemBrand").value = "";
        document.getElementById("itemCategory").value = "";
        document.getElementById("itemColor").value = "";
        document.getElementById("itemDesc").value = "";
        document.getElementById("itemCondition").value = "Like New - Worn once or twice";
        
        uploadedImageData = null;
        document.getElementById("imagePreview").classList.remove("active");
        document.getElementById("cameraArea").style.display = "block";
        document.getElementById("fileInput").value = "";
        
        alert(`✅ "${name}" has been listed successfully! It will now appear in the Shop page.`);
    };
    
    renderListings();
    updateCartCount();
    window.addEventListener('storage', () => updateCartCount());
</script>
</body>
</html>
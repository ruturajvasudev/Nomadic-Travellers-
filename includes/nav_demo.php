<?php
  // Optional: Process any search query submitted via GET.
  $searchQuery = "";
  if (isset($_GET['search'])) {
      $searchQuery = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
      // Additional backend processing can be added here.
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Responsive Navbar with Falling Leaves & Flowers</title>
  <!-- Bootstrap CSS (v5.3) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Global Styles */
    body {
      font-family: Georgia, serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
    }
    .fw-bold { font-weight: bold; }
    
    /* COMMON NAVBAR STYLING */
    .custom-navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 0.5rem 1rem;
    }
    /* Logo Styling with Hover Animation */
    .navbar-brand img {
      height: 110px;
      transition: transform 0.3s ease;
      cursor: pointer;
    }
    .navbar-brand img:hover { transform: rotate(3deg) scale(1.05); }
    
    /* ========== DESKTOP NAVBAR (Large Screens) ========== */
    .desktop-navbar { padding: 1rem 0; }
    .desktop-navbar .desktop-header {
      text-align: center;
      margin-bottom: 1rem;
    }
    .desktop-navbar .desktop-header .site-name {
      color: #ff4081;
      font-size: 1.8rem;
    }
    .desktop-navbar .nav-links { margin-bottom: 1rem; }
    .desktop-navbar .nav-links .nav-link {
      color: #333;
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      padding: 0.5rem 1rem;
      text-decoration: none;
    }
    .desktop-navbar .nav-links .nav-link:hover { color: #ff4081; }
    .desktop-navbar .search-row { text-align: center; }
    .desktop-search-input {
      border: none;
      border-bottom: 1px solid #333;
      background: transparent;
      outline: none;
      font-size: 1rem;
      color: #333;
      width: 300px;
      text-align: center;
    }
    .desktop-search-input::placeholder { color: #aaa; }
    
    /* ========== MOBILE NAVBAR (Small Screens) ========== */
    .mobile-navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 0.5rem 1rem;
    }
    .mobile-navbar .container-fluid {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .mobile-navbar .top-row {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .mobile-navbar .site-name {
      color: #ff4081;
      font-size: 1.8rem;
      font-weight: bold;
      margin-top: 0.5rem;
      text-align: center;
    }
    
    /* Full-Screen Mobile Offcanvas Menu – occupies entire screen */
    .mobile-offcanvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #fff;
      z-index: 1050;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      display: flex;
      flex-direction: column;
    }
    .mobile-offcanvas.active {
      opacity: 1;
      pointer-events: all;
    }
    /* Offcanvas Header: Centered logo and site name with close button */
    .offcanvas-header {
      position: relative;
      padding: 1rem;
      border-bottom: 1px solid #ddd;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .offcanvas-header .site-name {
      color: #ff4081;
      font-size: 1.8rem;
      font-weight: bold;
      margin-top: 0.5rem;
    }
    .offcanvas-header .close-btn {
      position: absolute;
      top: 1rem;
      right: 1.5rem;
      font-size: 2rem;
      color: #ff4081;
      background: none;
      border: none;
      cursor: pointer;
    }
    /* Offcanvas Navigation Links */
    .offcanvas-links {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .offcanvas-links li a {
      display: block;
      width: 100%;
      text-align: center;
      text-transform: uppercase;
      font-size: 1.2rem;
      letter-spacing: 2px;
      padding: 1.2rem 0;
      font-weight: bold;
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #ddd;
    }
    .offcanvas-links li a:hover { color: #ff4081; }
    /* Offcanvas Search: placed at bottom, centered */
    .offcanvas-search {
      padding: 1rem;
      border-top: 1px solid #ddd;
      text-align: center;
    }
    .mobile-search-input {
      width: 80%;
      font-size: 2.5rem;
      border: none;
      border-bottom: 1px solid #333;
      background: transparent;
      text-align: center;
      outline: none;
    }
    .mobile-search-input::placeholder { color: #aaa; }
    
    /* ========== FALLING PETALS EFFECT ========== */
    #petals {
      pointer-events: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 1000;
    }
    #petals span {
      position: absolute;
      top: -10%;
      animation: fall linear infinite;
    }
    @keyframes fall {
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>

<?php
  // (Optional) Display search results if a query was submitted.
  if (!empty($searchQuery)) {
      echo '<div class="container mt-3"><p class="fw-bold">Search results for: <span class="fw-bold">' . $searchQuery . '</span></p></div>';
  }
?>

<!-- ========== MOBILE NAVBAR (Visible on screens less than lg) ========== -->
<nav style="width: 100%;" class="mobile-navbar d-lg-none">
  <div class="container-fluid">
    <!-- First Row: Toggle & Logo -->
    <div class="top-row w-100 d-flex justify-content-between align-items-center">
      <!-- Hamburger Button -->
      <button class="btn" id="mobileMenuToggle">
        <i class="fas fa-bars" style="color:#ff4081; font-size:1.5rem;"></i>
      </button>
      <!-- Centered Logo -->
      <a class="navbar-brand" href="#">
        <img src="../travellogo.png" alt="Logo">
      </a>
      <!-- Right-side placeholder -->
      <div style="width:40px;"></div>
    </div>
    <!-- Second Row: Site Name -->
    <div class="site-name">SITE NAME</div>
  </div>
</nav>

<!-- Mobile Full-Screen Offcanvas Menu -->
<div class="mobile-offcanvas d-lg-none" id="mobileOffcanvas">
  <div class="offcanvas-header">
    <a class="navbar-brand" href="#">
      <img src="../travellogo.png" alt="Logo" style="height:110px;">
    </a>
    <div class="site-name fw-bold">SITE NAME</div>
    <button class="close-btn" id="closeMobileOffcanvas">&times;</button>
  </div>
  <ul class="offcanvas-links">
    <li><a href="#">HOME</a></li>
    <li><a href="#">ABOUT</a></li>
    <li><a href="#">SERVICES</a></li>
    <li><a href="#">CONTACT</a></li>
  </ul>
  <div class="offcanvas-search">
    <form action="index.php" method="get">
      <input type="text" class="mobile-search-input fw-bold" name="search" placeholder="Search...">
    </form>
  </div>
</div>

<!-- ========== DESKTOP NAVBAR (Visible on screens lg and above) ========== -->
<div class="desktop-navbar d-none d-lg-block">
  <div class="desktop-header">
    <a class="navbar-brand" href="#">
      <img src="../travellogo.png" alt="Logo">
    </a>
    <div class="site-name fw-bold">SITE NAME</div>
  </div>
  <ul class="nav justify-content-center nav-links">
    <li class="nav-item"><a class="nav-link fw-bold" href="#">HOME</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">ABOUT</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">SERVICES</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">CONTACT</a></li>
  </ul>
  <div class="search-row">
    <form action="index.php" method="get">
      <input type="text" class="desktop-search-input fw-bold" name="search" placeholder="Search...">
    </form>
  </div>
</div>

<!-- FALLING PETALS CONTAINER -->
<div id="petals"></div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JavaScript -->
<script>
  // Toggle Mobile Offcanvas Menu
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const mobileOffcanvas = document.getElementById('mobileOffcanvas');
  const closeMobileOffcanvas = document.getElementById('closeMobileOffcanvas');
  
  mobileMenuToggle.addEventListener('click', () => {
    mobileOffcanvas.classList.add('active');
  });
  closeMobileOffcanvas.addEventListener('click', () => {
    mobileOffcanvas.classList.remove('active');
  });

  // Falling Petals Effect
  // Create a mixed set of falling items:
  // - Dark flowers (using the ❀, 🪻, or ❀˖° symbols) will get a dark color.
  // - Pink leaves (using the 🍃 symbol) will get a pink color.
  const petalOptions = [
    { symbol: "💠", type: "flower" },
    { symbol: "🪻", type: "flower" },
    { symbol: "❀˖°", type: "flower" },
    { symbol: "🍁", type: "leaf" }
  ];
  
  // Dark color palette for flowers (darker shades)
  const darkColors = ["#000000", "#343434", "#353839", "#2F4F4F", "#36454F", "#191970", "#555D50", "#2D383A"];
  // Pink color palette for leaves (vivid pinks)
  const pinkColors = ["#FF1493", "#DB7093", "#C71585", "#FF69B4"];
  
  const numPetals = 25;  // Adjust the number as desired
  const petalsContainer = document.getElementById('petals');
  
  for (let i = 0; i < numPetals; i++) {
    const petal = document.createElement('span');
    // Randomly choose one of the options
    const option = petalOptions[Math.floor(Math.random() * petalOptions.length)];
    petal.innerHTML = option.symbol;
    
    // Random font size between 12px and 16px for small ornaments
    const size = Math.random() * 4 + 12;
    petal.style.fontSize = size + 'px';
    
    // Choose a color based on type
    if (option.type === "flower") {
      petal.style.color = darkColors[Math.floor(Math.random() * darkColors.length)];
    } else {
      petal.style.color = pinkColors[Math.floor(Math.random() * pinkColors.length)];
    }
    
    // Random horizontal starting position
    petal.style.left = Math.random() * 100 + '%';
    // Random opacity between 0.5 and 1
    petal.style.opacity = Math.random() * 0.5 + 0.5;
    
    // Random animation duration between 10s and 16s and random delay between 0s and 5s
    const duration = Math.random() * 6 + 10;
    const delay = Math.random() * 5;
    petal.style.animation = `fall ${duration}s linear ${delay}s infinite`;
    
    petalsContainer.appendChild(petal);
  }
</script>
</body>
</html>

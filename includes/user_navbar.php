<?php
  // Optional: Process search query if submitted via GET
  $searchQuery = "";
  if (isset($_GET['search'])) {
      $searchQuery = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');
      // Additional backend processing can be added here
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Responsive Navbar with Mobile Nomadic Travellers!</title>
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
    .fw-bold {
      font-weight: bold;
    }
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
    .navbar-brand img:hover {
      transform: rotate(3deg) scale(1.05);
    }
    /* ========== DESKTOP NAVBAR (Large Screens) ========== */
    .desktop-navbar {
      padding: 1rem 0;
    }
    .desktop-navbar .desktop-header {
      text-align: center;
      margin-bottom: 1rem;
    }
    .desktop-navbar .desktop-header .site-name {
      color: #ff4081;
      font-family: 'Dancing Script', cursive;
      font-size: 1.8rem;
    }
    .desktop-navbar .nav-links {
      margin-bottom: 1rem;
    }
    .desktop-navbar .nav-links .nav-link {
      color: #333;
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      padding: 0.5rem 1rem;
      text-decoration: none;
    }
    .desktop-navbar .nav-links .nav-link:hover {
      color: #ff4081;
    }
    .desktop-navbar .search-row {
      text-align: center;
    }
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
    .desktop-search-input::placeholder {
      color: #aaa;
    }
    /* ========== MOBILE NAVBAR (Small Screens) ========== */
    /* Top Mobile Navbar – always visible */
    .mobile-navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      padding: 0.5rem 1rem;
    }
    /* Use flex-column to allow a second row for the Nomadic Travellers! */
    .mobile-navbar .container-fluid {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    /* First row: toggle & logo */
    .mobile-navbar .top-row {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    /* Second row: Nomadic Travellers! */
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
    /* Offcanvas Header: Centered logo and Nomadic Travellers! with close button */
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
    .offcanvas-links li a:hover {
      color: #ff4081;
    }
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
    .mobile-search-input::placeholder {
      color: #aaa;
    }

    .slideshow {
      width: 100%;
      position: relative;
    }

    .slideshow img {
      width: 100%;
      display: none;
    }

    .slideshow img.active {
      display: block;
    }
  </style>
</head>
<body>

<?php
  // (Optional) Display search results if submitted.
  if (!empty($searchQuery)) {
      echo '<div class="container mt-3"><p class="fw-bold">Search results for: <span class="fw-bold">' . $searchQuery . '</span></p></div>';
  }
?>

<!-- ========== MOBILE NAVBAR (visible on screens less than lg) ========== -->
<nav class="mobile-navbar d-lg-none">
  <div class="container-fluid">
    <!-- First Row: Toggle & Logo -->
    <div class="top-row w-100 d-flex justify-content-between align-items-center">
      <!-- Hamburger Button -->
      <button class="btn" id="mobileMenuToggle">
        <i class="fas fa-bars" style="color:#ff4081; font-size:1.5rem;"></i>
      </button>
      <!-- Centered Logo -->
      <a class="navbar-brand" href="#">
        <img src="travellogo.png" alt="Logo">
      </a>
      <!-- Right-side placeholder -->
      <div style="width:40px;"></div>
    </div>
    <!-- Second Row: Nomadic Travellers! -->
    <div class="site-name">Nomadic Travellers!</div>
  </div>
</nav>

<!-- Mobile Full-Screen Offcanvas Menu -->
<div class="mobile-offcanvas d-lg-none" id="mobileOffcanvas">
  <div class="offcanvas-header">
    <a class="navbar-brand" href="#">
      <img src="travellogo.png" alt="Logo" style="height:110px;">
    </a>
    <div class="site-name fw-bold">Nomadic Travellers!</div>
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

<!-- ========== DESKTOP NAVBAR (visible on screens lg and above) ========== -->
<div class="desktop-navbar d-none d-lg-block">
  <div class="desktop-header">
    <a class="navbar-brand" href="#">
      <img src="travellogo.png" alt="Logo">
    </a>
    <div class="site-name fw-bold">Nomadic Travellers!</div>
  </div>
  <ul class="nav justify-content-center nav-links">
    <li class="nav-item"><a class="nav-link fw-bold" href="#">HOME</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">ABOUT</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">SERVICES</a></li>
    <li class="nav-item"><a class="nav-link fw-bold" href="#">CONTACT</a></li>
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
</script>
</body>
</html>

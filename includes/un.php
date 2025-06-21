<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nomadic Travellers Navbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    body {
      margin: 0;
      font-family: 'Georgia', serif;
      background: #fff;
    }

    .desktop-navbar {
      position: relative;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem 2rem;
      padding:45px;
    }

    .nav-section {
      display: flex;
      gap: 2.5rem;
      align-items: center;
      z-index: 2;
    }

    .nav-link {
      text-decoration: none;
      color: #222;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 0.95rem;
      letter-spacing: 1px;
    }

    .logo-section {
      position: relative;
      z-index: 3;
      margin: 0 2rem;
    }

    .logo-section img {
      height: 100px;
      width: 100px;
      border-radius: 50%;
      background: #fff;
      object-fit: cover;
      position: relative;
      z-index: 3;
    }

    /* THICK BLACK LINE with SEMICIRCLE */
    .desktop-navbar::before {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 3px;
      background-color: black;
      z-index: 1;
    }

    .desktop-navbar::after {
      content: "";
      position: absolute;
      bottom: -25px;
      left: 50%;
      transform: translateX(-50%);
      width: 110px;
      height: 55px;
      background: #fff;
      border: 3px solid black;
      border-radius: 0 0 110px 110px;
      border-top: none;
      z-index: 2;
    }
  </style>
</head>
<body>

  <!-- DESKTOP NAVBAR -->
  <div class="desktop-navbar">
    <!-- Left Nav -->
    <div class="nav-section">
      <a href="#" class="nav-link">Home</a>
      <a href="#" class="nav-link">About</a>
    </div>

    <!-- Center Logo -->
    <div class="logo-section">
      <img src="../tl.png" alt="Nomadic Travellers Logo">
    </div>

    <!-- Right Nav -->
    <div class="nav-section">
      <a href="#" class="nav-link">Services</a>
      <a href="#" class="nav-link">Contact</a>
    </div>
  </div>

</body>
</html>

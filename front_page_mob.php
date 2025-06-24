<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <title>Welcome to Front Page</title>
<!-- this is main branch demo check-->
  <!-- edited on 24/06/2025 tuesday-->

  <!-- edited on 24/06/2025 its tuesday -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
   /* Fixed background image section */
   .hero-section {
  position: relative;
  width: 100%;
  min-height: 100vh;
  background-image: url('imgs/bg_img1.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: scroll; /* changed from fixed for mobile compatibility */
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: white;
  text-align: center;
  padding: 10px;
}
.hero-text {
  font-size: 2.0rem;
  font-weight: bold;
  color: white;
  overflow-wrap: break-word;
  white-space: normal;
  border-right: none;
  width: auto;
  text-align: center;
}


@keyframes typing {
  from { width: 0 }
  to { width: 20ch }  /* Adjust to match character count */
}

@keyframes blink-caret {
  from, to { border-color: transparent }
  50% { border-color: rgba(255,255,255,0.75) }
}
    .explore-btn {
  padding: 15px 30px;
  font-size: 1.0rem;
  background-color: transparent;
  border: 2px solid white;
  border-radius: 8px;
  cursor: pointer;
  color: white;
  display: flex;
  align-items: center;
  gap: 10px;
  transition: background-color 0.3s ease, transform 0.2s ease, border-color 0.3s ease;
}

.explore-btn:hover {
  background-color: #ff4081;
  border-color: #ff4081;
  transform: scale(1.05);
}


    /* Example scrollable content */
    .content {
      padding: 80px 20px;
      background: #fff;
      text-align: center;
    }

    .content h2 {
      margin-bottom: 20px;
    }

    .content p {
      max-width: 800px;
      margin: auto;
      line-height: 1.8;
      color: #333;
    }
  </style>
</head>
<body>

  <!-- PHP Navbar Include -->
  <?php include('includes/user_navbar.php'); ?>

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="hero-text" style="padding:50px;">Welcome to Our World</div>
    <button class="explore-btn" onclick="scrollToContent()">
  Explore More <span style="font-size: 1.3rem;">➜</span>
</button>
  </div>



 
  </div>
</div>




</body>
</html>

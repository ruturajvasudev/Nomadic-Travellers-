<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "travel_app");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all blogs
$sql = "SELECT * FROM locations ORDER BY created_at DESC";
$result = $conn->query($sql);
$blogs = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $blogs[] = $row;
  }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stylish Landing Page</title>
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
  height: 100vh;
  background: url('imgs/bg_img1.jpg') center center / cover no-repeat fixed;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  color: white;
  text-align: center;
  z-index: 1;
}

    .hero-text {
  font-size: 3rem;
  font-weight: bold;
  color: white;
  white-space: nowrap;
  overflow: hidden;
  border-right: 4px solid rgba(255,255,255,0.75); /* Simulated cursor */
  width: 0;
  animation: typing 3s steps(24, end) forwards, blink-caret 0.75s step-end 4;
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
  font-size: 1.4rem;
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

<!-- Responsive Section Below Hero -->
<div class="container my-5">
  <div class="row align-items-center">
    
    <!-- Left: Mobile Image --><!-- Left: Live Mobile View in iPhone-like Frame -->
    <div class="col-md-6 text-center mb-4 mb-md-0">
  <div style="max-width: 360px; width: 100%; aspect-ratio: 1/2; border: 6px solid #ccc; border-radius: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; margin: auto; position: relative;">
    
    <!-- Simulated Notch -->
    <div style="width: 40%; height: 20px; background: black; border-radius: 0 0 20px 20px; position: absolute; top: 0; left: 50%; transform: translateX(-50%); z-index: 2;"></div>

    <!-- iFrame Preview -->
    <iframe src="front_page_mob.php" style="width:100%; height:100%; border:none;"></iframe>
  </div>
</div>

    
    <!-- Right: Text Content -->
    <div class="col-md-6">
      <h2 class="mb-3">Experience It on Mobile</h2>
      <p class="lead">
        Enjoy a seamless, responsive design that looks great on every device. Our mobile-first approach ensures a smooth and intuitive experience.
      </p>
      <a href="#" class="btn btn-outline-primary">Learn More</a>
    </div>
    
  </div>
</div>




<!-- View Blogs Section -->
<section class="py-5 bg-light" id="view-blogs">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Explore Travel Blogs</h2>
      <p class="text-muted">Discover journeys, destinations, and personal stories shared by travelers like you.</p>
    </div>

    <div class="row">
      <?php foreach ($blogs as $blog): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100 shadow-sm border-0 blog-card">
            <?php if (!empty($blog['header_image'])): ?>
              <img src="<?= htmlspecialchars($blog['header_image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($blog['title']) ?>">
            <?php else: ?>
              <img src="imgs/default.jpg" class="card-img-top" alt="Default Image">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
              <?php if (!empty($blog['subtitle'])): ?>
                <h6 class="text-muted"><?= htmlspecialchars($blog['subtitle']) ?></h6>
              <?php endif; ?>
              <p class="card-text text-truncate" style="max-height: 4.5em; overflow: hidden;">
                <?= nl2br(htmlspecialchars($blog['description'])) ?>
              </p>
              <p class="small text-muted">
                <i class="bi bi-geo-alt-fill"></i>
                <?= htmlspecialchars($blog['location_name'] . ', ' . $blog['city'] . ', ' . $blog['state'] . ', ' . $blog['country']) ?>
              </p>
              <a href="blog_detail.php?id=<?= $blog['id'] ?>" class="btn btn-sm btn-primary">Read More</a>
            </div>
            <div class="card-footer bg-white border-0 small text-muted">
              Posted on <?= date('F j, Y', strtotime($blog['created_at'])) ?>
              <?php if (!empty($blog['tags'])): ?>
                <div class="mt-2">
                  <?php foreach (explode(',', $blog['tags']) as $tag): ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars(trim($tag)) ?></span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (empty($blogs)): ?>
        <p class="text-center text-muted">No blogs found. Be the first to share your travel story!</p>
      <?php endif; ?>
    </div>
  </div>
</section>



</body>
</html>

<?php
$conn = new mysqli("localhost", "root", "", "travel_app");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT b.*, u.username, u.profile_photo 
        FROM locations b 
        JOIN users u ON b.user_id = u.id 
        ORDER BY b.created_at DESC 
        LIMIT 6";
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


    .blog-card-sm {
  background: white;
  border-radius: 14px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
}

.blog-card-sm:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  color: #ff4081;
}

.blog-card-sm:hover .blog-title {
  color: #ff4081;

}

.blog-card-sm:hover .blog-subtitle {
  color: #ff4081;
}

.blog-img {
  width: 100%;
  height: 280px;
  background-size: cover;
  background-position: center;
}

.blog-body {
  padding: 16px 18px 20px;
}

.blog-title {
  font-size: 1.05rem;
  font-weight: 600;
  margin: 0 0 6px;
  color: #212529;
}

.blog-location {
  font-size: 0.85rem;
}

.blog-author {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 12px;
}

.author-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #fff;
  box-shadow: 0 0 0 2px #ff4081;
}

.author-name {
  font-size: 0.95rem;
  font-weight: 500;
}

.testimonial-card {
  max-width: 700px;
  margin: auto;
  padding: 30px 20px;
  border-radius: 12px;
  background-color: #f9f9f9;
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease;
}

.testimonial-card:hover {
  transform: scale(1.01);
}

.testimonial-img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #ff4081;
}

.testimonial-text {
  font-style: italic;
  color: #555;
  margin-top: 15px;
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

    <div class="container">
            <div class="container my-5">
          <h2 class="text-center mb-4">Explore Recent Blogs</h2>

          <?php if (!empty($blogs)): ?>
            <div class="d-flex justify-content-center">
              <div class="row justify-content-center" style="max-width: 1140px; width: 100%;">
                <?php foreach ($blogs as $blog): ?>
                  <div class="col-md-4 mb-4 d-flex align-items-stretch">
                  <a href="blog_detail.php?id=<?= $blog['id'] ?>" class="text-decoration-none text-dark w-100">
          <div class="blog-card-sm w-100">
            <div class="blog-img" style="background-image: url('<?= htmlspecialchars($blog['header_image']) ?: 'uploads/default-banner.jpg' ?>');"></div>
            <div class="blog-body">
              <h6 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h6>
              <p class="blog-subtitle"><?= htmlspecialchars(substr($blog['description'], 0, 60)) ?>...</p>

              <div class="blog-location text-muted small">
                📍 <?= htmlspecialchars($blog['location_name'] . ', ' . $blog['city']) ?>
              </div>

              <div class="blog-author mt-3">
                <img src="uploads/<?= htmlspecialchars($blog['profile_photo']) ?>" class="author-img" alt="Author">
                <div>
                  <div class="author-name"><?= htmlspecialchars($blog['username']) ?></div>
                  <div class="text-muted small"><?= date('M d, Y', strtotime($blog['created_at'])) ?></div>
                </div>
              </div>
            </div>
          </div>
  
</a>

          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <p class="text-center text-muted">No blogs found. Be the first to share your travel story!</p>
  <?php endif; ?>
</div>
 
  
  </div>

    <div class="text-center mt-4">
      <a href="all_blogs.php" class="btn btn-outline-primary px-4">View More</a>
    </div>
  </div>
</section>


</div>



</div>


      <?php if (empty($blogs)): ?>
        <p class="text-center text-muted">No blogs found. Be the first to share your travel story!</p>
      <?php endif; ?>
    </div>
  </div>
</section>



  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        <div class="text-center mb-5">
        <h2 class="fw-bold">Explore Travel Blogs</h2>
        <div class="row">
        <div class="col-md-1"><img src ="imgs/lf.png" class="img-fluid" height="400px"></div>
        <div class="col-md-8"><img src="imgs/community_img.jpg" class="img-fluid" height="150px"></div>
        <div class="col-md-1"><img src ="imgs/rf.png" class="img-fluid" style="float: left;"></div>

<div class="text-center mt-6"><br><br><br>
      <a href="all_blogs.php" class="btn btn-lg btn-outline-primary px-6">
        Join the Community and Share your Experience Today!
      </a>
    </div>
      </div>
        </div>

      </div>

      </div>
      </div>
<!-- Testimonial Section Matching the Image Style -->
<!-- Testimonial Section Matching the Image Style -->
<!-- Darker Background with Foreground Card Slider -->
<section style="background-color: #001f3f; padding: 60px 0;">
 
<div class="container">
    <div class="rounded-4 p-5 position-relative" style="z-index: 1;background-color:rgb(2, 21, 40);">
      <div class="row align-items-center">
        <!-- Left side static text -->
        <div class="col-lg-3 mb-4 mb-lg-0 text-white">
          <img src="imgs/quotes.png" class="img-fluid">
          <h3 class="fw-bold">Connect with<br>other members</h3>
          <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
          <a href="#" class="text-white text-decoration-underline">Connect now →</a>
          <br><br>
        </div>

        <!-- Right side carousel -->
        <div class="col-lg-9">
          <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

              <!-- SLIDES (3 Total, 9 Users) -->
              <!-- Slide 1 -->
              <div class="carousel-item active">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user1.jpg" class="card-img-top" alt="Michael" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam nonummy.</p>
                        <h6 class="mb-0">Michael</h6>
                        <small class="text-muted">MDS Manufacturing</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user2.jpg" class="card-img-top" alt="Diane" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam nonummy.</p>
                        <h6 class="mb-0">Diane</h6>
                        <small class="text-muted">ABC Rentals</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user3.jpg" class="card-img-top" alt="Allison" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam nonummy.</p>
                        <h6 class="mb-0">Allison</h6>
                        <small class="text-muted">Grand Party Rental</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Slide 2 -->
              <div class="carousel-item">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user4.jpg" class="card-img-top" alt="Carlos" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae.</p>
                        <h6 class="mb-0">Carlos</h6>
                        <small class="text-muted">Dev Enterprises</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user5.jpg" class="card-img-top" alt="Priya" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.</p>
                        <h6 class="mb-0">Priya</h6>
                        <small class="text-muted">Bloom Co.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user6.jpg" class="card-img-top" alt="Rahul" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                        <h6 class="mb-0">Rahul</h6>
                        <small class="text-muted">Xplore India</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Slide 3 -->
              <div class="carousel-item">
                <div class="row">
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user7.jpg" class="card-img-top" alt="Sneha" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        <h6 class="mb-0">Sneha</h6>
                        <small class="text-muted">TripWorld</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user8.jpg" class="card-img-top" alt="Amit" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.</p>
                        <h6 class="mb-0">Amit</h6>
                        <small class="text-muted">GoLocal</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card border-0 shadow h-100">
                      <img src="imgs/user9.jpg" class="card-img-top" alt="Neha" style="height: 200px; object-fit: cover;">
                      <div class="card-body">
                        <div class="text-primary fs-1 lh-1">“</div>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.</p>
                        <h6 class="mb-0">Neha</h6>
                        <small class="text-muted">Wanderlust Co.</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Carousel Controls -->
            <div class="text-center mt-4">
              <button class="carousel-control-prev position-relative d-inline-block me-3" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
              </button>
              <button class="carousel-control-next position-relative d-inline-block" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
              </button>
            </div>

            <!-- Indicators -->
            <div class="carousel-indicators justify-content-center mt-3">
              <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active bg-light" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" class="bg-light" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" class="bg-light" aria-label="Slide 3"></button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>





<!-- About Us Section - Professional Look -->
<!-- Modern About Us Inspired Section -->
<section style="background-color: #faf4ef; padding: 80px 0; font-family: 'Georgia', serif;">
  <div class="container">
    <div class="row align-items-center">

      <!-- Text + Styled Intro Section -->
      <div class="col-lg-6 position-relative mb-5 mb-lg-0">
        <div style="background-color: #fff; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-radius: 10px;">
          <h5 style="text-transform: uppercase; letter-spacing: 2px; color: #666;">Meet the</h5>
          <h1 style="font-family: 'Dancing Script', cursive; font-size: 48px; color: #000;">Ruturaj</h1>
          <h3 style="font-weight: 300; margin-top: -10px;">Your Tech Guide</h3>
          <p style="margin-top: 20px; font-size: 16px; color: #444;">
            I'm Ruturaj, a passionate full-stack developer who stepped away from the usual to craft something that reflects performance, clean code, and inspiring UI. I left traditional roles to chase creativity, tech freedom, and the dream of innovation.
            <br><br><br><br> </p>
        </div>

        <!-- Floating Secondary Image -->
        <img src="imgs/fs.jpg" alt="My Favorite Spot" style="width: 220px; height: 150px; object-fit: cover; border-radius: 8px;transform: rotate(5deg); position: absolute; bottom: -30px; left: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border: 4px solid white;">
        <img src="imgs/fs.jpg" alt="My Favorite Spot" style="width: 220px; height: 150px; object-fit: cover; border-radius: 8px;transform: rotate(-15deg); position: absolute; bottom: -30px; right: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border: 4px solid white;">

        <img src="imgs/bg_img1.jpg" alt="Floating Image 1" style="width: 250px; position: absolute; top: -30px; right: -20px; transform: rotate(15deg); z-index: 1; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);border: 4px solid white;">

      </div>

      <!-- Right Main Image -->
      <div class="col-lg-6 position-relative text-center">
        <img src="imgs/user3.jpg" alt="Ruturaj Balloon Ride" style="border-radius: 16px; width: 100%; max-width: 500px; height: auto; box-shadow: 0 8px 25px rgba(0,0,0,0.2);">

        <!-- Floating Badge -->
          <!-- Decorative Badge -->
          <div style="position: absolute; top: 0; right: 50%; transform: translateX(50%) rotate(-10deg); background-color: #fff7d6; border-radius: 100px; padding: 12px 30px; font-size: 24px; font-weight: bold; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 3; border: 3px dashed #000;">
          ABOUT RUTURAJ
        </div>
      </div>

    </div>
  </div>
</section>



<!-- Add this in <head> -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

</body>
</html>


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}$conn = new mysqli("localhost", "root", "", "travel_app");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$query = "SELECT l.id, l.title, l.subtitle, l.description, l.created_at, u.username
          FROM locations l
          JOIN users u ON u.id = l.user_id
          WHERE l.user_id = {$_SESSION['user_id']}
          ORDER BY l.created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Travel Blogs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }
    .header {
      background-color: #ff4081;
      color: #fff;
      padding: 30px 0;
      text-align: center;
    }
    .blog-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      margin: 40px auto;
      max-width: 1200px;
    }
    .blog-card {
      width: 350px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(255, 64, 129, 0.2);
      border: 1px solid #ff4081;
      background-color: #fff;
      transition: transform 0.3s;
    }
    .blog-card:hover {
      transform: scale(1.02);
    }
    .blog-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .blog-body {
      padding: 20px;
    }
    .blog-title {
      font-size: 20px;
      color: #ff4081;
      font-weight: bold;
    }
    .blog-subtitle {
      font-size: 14px;
      color: #888;
      margin-bottom: 10px;
    }
    .read-more {
      background-color: #ff4081;
      border: none;
      color: #fff;
      padding: 8px 16px;
      border-radius: 20px;
      margin-top: 10px;
      font-size: 14px;
    }
    .read-more:hover {
      background-color: #e0306e;
    }
  </style>
</head>
<body>
<?php

include 'includes/customer_topnavbar.php'; 
include 'includes/customer_navbar.php'; 

?>
<div class="header">
  <h1><i class="bi bi-journal-text me-2"></i>Travel Stories</h1>
  <p>Every journey begins with a story!</p>
</div>

<div class="blog-grid">
  <?php while($row = $result->fetch_assoc()): ?>
    <?php
      // Get one image as preview
      $imgQuery = $conn->query("SELECT image_path FROM location_images WHERE location_id = {$row['id']} LIMIT 1");
      $imgPath = ($imgQuery && $imgQuery->num_rows > 0) ? $imgQuery->fetch_assoc()['image_path'] : 'https://via.placeholder.com/350x180?text=No+Image';
    ?>
    <div class="blog-card">
      <img src="<?= $imgPath ?>" class="blog-image" alt="Preview">
      <div class="blog-body">
        <div class="blog-title"><?= htmlspecialchars($row['title']) ?></div>
        <div class="blog-subtitle"><?= htmlspecialchars($row['subtitle']) ?></div>
        <a href="blog_detail.php?id=<?= $row['id'] ?>" class="read-more">Read More</a>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</body>
</html>


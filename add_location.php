<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];

    // Replace *text* with <strong>text</strong>
    $description = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $description);

    $conn = new mysqli("localhost", "root", "", "travel_app");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO locations (user_id, title, subtitle, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $subtitle, $description);
    $stmt->execute();

    $location_id = $stmt->insert_id;

    // Handle image uploads
    $upload_dir = "uploads/";
    foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
        $filename = basename($_FILES['images']['name'][$index]);
        $target = $upload_dir . uniqid() . "_" . $filename;
        if (move_uploaded_file($tmpName, $target)) {
            $img_stmt = $conn->prepare("INSERT INTO location_images (location_id, image_path) VALUES (?, ?)");
            $img_stmt->bind_param("is", $location_id, $target);
            $img_stmt->execute();
        }
    }

    $stmt->close();
    $conn->close();

    echo '<script>alert("location added successfully")</script>';
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Location Blog | Travel Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff;
      color: #333;
      transition: margin-left 0.3s;
    }
    body.collapsed {
      margin-left: 80px;
    }
    body:not(.collapsed) {
      margin-left: 250px;
    }
    .navbar {
      background-color: #ff4081;
      transition: all 0.3s;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
    }
    .dashboard-card {
      background: #fff;
      border: 2px solid #ff4081;
      border-radius: 20px;
      padding: 20px;
    }
    .icon {
      font-size: 2rem;
      color: #ff4081;
    }
    .profile-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    body.collapsed .navbar-brand span {
      display: none;
    }
  </style>
</head>
<body>

<?php

include 'includes/customer_topnavbar.php'; 
include 'includes/customer_navbar.php'; 

?>
<div class="container mt-4">
  <h4 class="mb-4 text-center text-danger"><i class="bi bi-geo-alt-fill"></i> Add New Location Blog</h4>
  <form id="addLoc" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
      <label for="subtitle" class="form-label">Subtitle</label>
      <input type="text" class="form-control" id="subtitle" name="subtitle">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description <small class="text-muted">(Use *text* to bold)</small></label>
      <textarea class="form-control" id="description" name="description" rows="6" placeholder="Write your blog here... use *bold* to highlight"></textarea>
    </div>
    <div class="mb-3">
      <label for="images" class="form-label">Upload Images</label>
      <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
    </div>
    <button type="submit" class="btn btn-danger"><i class="bi bi-upload"></i> Submit Blog</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  if (localStorage.getItem('sidebar-collapsed') === 'true') {
    document.body.classList.add('collapsed');
  }

  document.querySelector('.toggle-btn')?.addEventListener('click', function () {
    document.body.classList.toggle('collapsed');
    localStorage.setItem('sidebar-collapsed', document.body.classList.contains('collapsed'));
  });
</script>
</body>
</html>


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Travel App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      
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
    .navbar-brand, .nav-link, .dashboard-card h5 {
     
    }
    .dashboard-card {
      background: #fff;
      border: 2px solid #ff4081;
      border-radius: 20px;
      padding: 20px;
      transition: all 0.3s;
    }
    .dashboard-card:hover {
      box-shadow: 0 4px 20px rgba(255, 64, 129, 0.3);
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
    .navbar-brand span {
      transition: all 0.3s;
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
  <div class="row g-4">
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-geo-alt-fill"></i></div>
        <h5>Total Locations</h5>
        <p>18</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-pencil-square"></i></div>
        <h5>Create Location Blog</h5>
        <a href="#" class="btn btn-sm btn-outline-danger mt-2">Create Now</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-bar-chart-line"></i></div>
        <h5>View Analytics</h5>
        <a href="#" class="btn btn-sm btn-outline-danger mt-2">View</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-journal-richtext"></i></div>
        <h5>My Blogs</h5>
        <a href="#" class="btn btn-sm btn-outline-danger mt-2">View Blogs</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-gear"></i></div>
        <h5>Account Settings</h5>
        <a href="#" class="btn btn-sm btn-outline-danger mt-2">Manage</a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dashboard-card text-center">
        <div class="icon mb-2"><i class="bi bi-box-arrow-right"></i></div>
        <h5>Logout</h5>
        <a href="logout.php" class="btn btn-sm btn-outline-danger mt-2">Logout</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Optional: Sync sidebar toggle class with this page too
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

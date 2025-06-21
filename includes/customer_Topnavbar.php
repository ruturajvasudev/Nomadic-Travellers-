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
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" alt="Logo" width="40" class="me-2">
      <span>Travel Dashboard</span>
    </a>
    <div class="ms-auto">
      <span class="text-white me-3">Welcome, <?= $_SESSION['username']; ?></span>
      <img src="uploads/<?= $_SESSION['profile_photo']; ?>" class="profile-img" alt="Profile">
    </div>
  </div>
</nav>
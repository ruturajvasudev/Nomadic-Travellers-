<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Navbar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      transition: margin-left 0.3s;
    }
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #ff4081;
      padding-top: 60px;
      transition: all 0.3s;
      z-index: 1000;
    }
    .sidebar.collapsed {
      width: 80px;
    }
    .sidebar .nav-link {
      color: white;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .sidebar .nav-link:hover {
      background-color: #e73370;
      color: #fff;
    }
    .sidebar .logo {
      position: absolute;
      top: 10px;
      left: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .sidebar.collapsed .logo span,
    .sidebar.collapsed .nav-link span {
      display: none;
    }
    .toggle-btn {
      position: absolute;
      top: 15px;
      right: -35px;
      background-color: #ff4081;
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      color: white;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
      transition: margin-left 0.3s;
    }
    body.collapsed .main-content {
      margin-left: 80px;
    }
  </style>
</head>
<body>
<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" width="30" alt="Logo">
    <span class="fw-bold text-white">Travel Admin</span>
    <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  </div>
  <nav class="nav flex-column mt-4">
    <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door"></i> <span>Dashboard</span></a>
    <a class="nav-link" href="#"><i class="bi bi-geo-alt"></i> <span>Locations</span></a>
    <a class="nav-link" href="#"><i class="bi bi-pencil"></i> <span>Create Blog</span></a>
    <a class="nav-link" href="#"><i class="bi bi-bar-chart"></i> <span>Analytics</span></a>
    <a class="nav-link" href="#"><i class="bi bi-journal-text"></i> <span>My Blogs</span></a>
    <a class="nav-link" href="#"><i class="bi bi-gear"></i> <span>Settings</span></a>
    <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-left"></i> <span>Logout</span></a>
  </nav>
</div>

<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('collapsed');
    document.body.classList.toggle('collapsed');
  }
</script>
</body>
</html>

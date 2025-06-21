<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'travel_app');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, username, password, profile_photo FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['profile_photo'] = $user['profile_photo'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'No account found with that email.';
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Travel App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
    }
    .login-card {
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }
    .login-logo {
      width: 80px;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-custom {
      background-color: #ff4081;
      color: white;
      border-radius: 30px;
      padding: 10px 30px;
      font-weight: bold;
    }
    .btn-custom:hover {
      background-color: #e73370;
    }
  </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="col-md-6 login-card">
    <div class="text-center mb-4">
      <img src="https://cdn-icons-png.flaticon.com/512/201/201623.png" alt="Travel Logo" class="login-logo">
      <h3 class="mt-2">Welcome Back, Traveler</h3>
      <p>Please log in to continue</p>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-custom">Login</button>
      </div>
    </form>
    <div class="text-center mt-3">
      <small>Don't have an account? <a href="register.php" class="text-info">Register here</a></small>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

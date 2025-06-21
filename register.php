<?php
$registrationStatus = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $country = $_POST['country'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    $passwordValid = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password);

    if ($password !== $confirm_password || !$passwordValid) {
        $registrationStatus = 'fail';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Handle profile photo upload
        $photo = $_FILES['profile_photo']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file);

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'travel_app');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (username, country, contact_number, address, email, password, profile_photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $country, $contact, $address, $email, $hashed_password, $photo);

        if ($stmt->execute()) {
            $registrationStatus = 'success';
        } else {
            $registrationStatus = 'fail';
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="text-center mb-4">Register to Share Your Travel Locations</h2>
  <form method="POST" enctype="multipart/form-data" id="registrationForm">
    <div class="row mb-3">
      <div class="col">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="col">
        <input type="text" name="country" class="form-control" placeholder="Country" required>
      </div>
    </div>

    <div class="mb-3">
      <input type="text" name="contact" class="form-control" placeholder="Contact Number" required>
    </div>

    <div class="mb-3">
      <input type="text" name="address" class="form-control" placeholder="Address" required>
    </div>

    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email Address" required>
    </div>

    <div class="mb-3">
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
      <div class="form-text text-muted">
        Must be 8+ characters with uppercase, lowercase, number, and special character.
      </div>
    </div>

    <div class="mb-3">
      <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
    </div>

    <div class="mb-3">
      <input type="file" name="profile_photo" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Register</button>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header <?= $registrationStatus == 'success' ? 'bg-success' : 'bg-danger' ?>">
        <h5 class="modal-title text-white">
          <?= $registrationStatus == 'success' ? 'Registration Successful' : ($registrationStatus ? 'Registration Failed' : '') ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= $registrationStatus == 'success' ? 'You have been successfully registered!' : ($registrationStatus ? 'Please check your inputs and try again.' : '') ?>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php if ($registrationStatus): ?>
  var resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
  resultModal.show();
<?php endif; ?>
</script>

</body>
</html>

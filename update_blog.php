<?php
$conn = new mysqli("localhost", "root", "", "travel_app");

$id = $_POST['blog_id'];
$title = $conn->real_escape_string($_POST['title']);
$subtitle = $conn->real_escape_string($_POST['subtitle']);
$description = $conn->real_escape_string($_POST['description']);

$conn->query("UPDATE locations SET title='$title', subtitle='$subtitle', description='$description' WHERE id=$id");

// Add new images
if (!empty($_FILES['new_images']['name'][0])) {
  foreach ($_FILES['new_images']['tmp_name'] as $key => $tmpName) {
    $imgName = basename($_FILES['new_images']['name'][$key]);
    $target = "uploads/" . time() . "_" . $imgName;
    if (move_uploaded_file($tmpName, $target)) {
      $conn->query("INSERT INTO location_images (location_id, image_path) VALUES ($id, '$target')");
    }
  }
}

if (isset($_FILES['header_image']) && $_FILES['header_image']['error'] == 0) {
  $headerImagePath = 'uploads/' . time() . '_' . basename($_FILES['header_image']['name']);
  move_uploaded_file($_FILES['header_image']['tmp_name'], $headerImagePath);
  $conn->query("UPDATE locations SET header_image='$headerImagePath' WHERE id=$id");
}

header("Location: blog_detail.php?id=$id");
?>

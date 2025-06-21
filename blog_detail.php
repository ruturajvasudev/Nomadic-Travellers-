<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
$conn = new mysqli("localhost", "root", "", "travel_app");
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch blog data
$blog = $conn->query("SELECT l.*, u.username FROM locations l JOIN users u ON u.id = l.user_id WHERE l.id = $id")->fetch_assoc();
$images = [];
$resImg = $conn->query("SELECT * FROM location_images WHERE location_id = $id");
while ($img = $resImg->fetch_assoc()) $images[] = $img;
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($blog['title']) ?> | Travel Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
  body {
    font-family: 'Segoe UI', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    background-color: #fff; /* Fallback color */
}

body::before {
    content: '';
    position: fixed;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    background: url('travel.gif') no-repeat center center;
    background-size: cover;
    transform: translate(-50%, -50%);
    z-index: -1; /* Keeps the GIF behind the text */
    opacity: 0.8; /* Optional: To make the GIF subtle */
    background-color: rgba(255, 255, 255, 0.7); /* Light background behind text */
       box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.5); /* Optional: Shadow for better focus */
}

body * {
    position: relative;
    z-index: 1; /* Ensures text is above the GIF */
}

    .container1 { max-width: 900px; margin: 50px auto; }
    h1 { color: #ff4081; }
    .inserted-img { max-width:600px ; border-radius: 10px; display: block; margin: auto;margin: 20px 0; object-fit: cover; max-height: 400px; }
    .image-thumb { width: 100px; height: 100px; object-fit: cover; border-radius: 5px; position: relative; margin: 10px; }
    .remove-image { position: absolute; top: 2px; right: 2px; background: #000a; color: white; border-radius: 50%; cursor: pointer; padding: 2px 6px; }
  </style>
</head>
<body>
<?php

include 'includes/customer_topnavbar.php'; 
include 'includes/customer_navbar.php'; 

?>

<?php if (!empty($blog['header_image'])): ?>
  <div class="blog-header" style="background-image: url('<?= $blog['header_image'] ?>'); background-size: cover; background-position: center; height: 300px;">
    <div class="d-flex align-items-center justify-content-center h-100 text-white text-center" style="background-color: rgba(0,0,0,0.5);">
      <h1 class="display-4"><?= htmlspecialchars($blog['title']) ?><br></h1>
      <h5 class="display-6"><br><br><br><?= htmlspecialchars($blog['subtitle']) ?></h5>

    </div>
  </div>
<?php endif; ?>

<div class="container1">
  <h1><?= htmlspecialchars($blog['title']) ?></h1>
  
  <div id="blog-content">
  
  <?php
  $desc = $blog['description']; // Do NOT escape here; we handle formatting ourselves
$desc = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $desc);

    $parts = explode('<i>', $desc);
    $imageCount = count($images);

    foreach ($parts as $index => $para) {
      echo "<p>$para</p>";
      if ($index < $imageCount) {
        echo "<center><img src='{$images[$index]['image_path']}' class='inserted-img' ></center>";
      }
    }

    // Append any remaining images
    if (count($parts) < $imageCount) {
      for ($j = count($parts); $j < $imageCount; $j++) {
        echo "<center><img src='{$images[$j]['image_path']}' class='inserted-img'></center>";
      }
    }
  ?>

  </div>

  <button class="btn btn-warning mt-4" data-bs-toggle="modal" data-bs-target="#editModal">
    <i class="bi bi-pencil-square"></i> Edit Blog
  </button>


<form  method="POST" onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.');" class="d-inline">
  <input type="hidden" name="blog_id" value="<?= $id ?>">
  <button class="btn btn-danger"><i class="bi bi-trash"></i> Delete Blog</button>
</form></div>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['blog_id'])) {
  $id = intval($_POST['blog_id']);

  // Fetch images first to delete from disk
  $images = $conn->query("SELECT image_path FROM location_images WHERE location_id = $id");
  while ($img = $images->fetch_assoc()) {
    if (file_exists($img['image_path'])) {
      unlink($img['image_path']);
    }
  }

  // Delete images from DB
  $conn->query("DELETE FROM location_images WHERE location_id = $id");

  // Delete blog
  $conn->query("DELETE FROM locations WHERE id = $id");

  header("Location: all_blogs.php?deleted=1");
  exit();
}?>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="update_blog.php" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Edit Blog</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="blog_id" value="<?= $id ?>">
        <div class="mb-3">
          <label>Title</label>
          <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($blog['title']) ?>" required>
        </div>
        <div class="mb-3">
          <label>Subtitle</label>
          <input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($blog['subtitle']) ?>">
        </div>
        <div class="mb-3">
          <label>Description (Use *bold* and &lt;i&gt; to insert images)</label>
          <textarea name="description" id="descInput" rows="6" class="form-control"><?= htmlspecialchars($blog['description']) ?></textarea>
        </div>
        <div class="mb-3">
          <label>Preview</label>
          <div class="border p-3" id="descPreview"></div>
        </div>
        <div class="mb-3">
          <label>Existing Images</label><br>
          <div class="d-flex flex-wrap">
            <?php foreach ($images as $img): ?>
              <div class="image-thumb">
                <img src="<?= $img['image_path'] ?>" class="w-100 h-100 rounded">
                <span class="remove-image" onclick="removeImage(<?= $img['id'] ?>, this)">×</span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="mb-3">
            <label for="header_image" class="form-label">Header Image (for blog top section)</label>
            <input type="file" class="form-control" name="header_image" id="header_image" accept="image/*">
            <?php if (!empty($blog['header_image'])): ?>
              <div class="mt-2">
                <img src="<?= $blog['header_image'] ?>" alt="Header Image" class="img-thumbnail" width="200">
              </div>
            <?php endif; ?>
</div>

        <div class="mb-3">
          <label>Add More Images</label>
          <input type="file" name="new_images[]" class="form-control" multiple>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('descInput').addEventListener('input', function () {
  let content = this.value
    .replace(/</g, "&lt;").replace(/>/g, "&gt;")
    .replace(/\*(.*?)\*/g, "<strong>$1</strong>")
    .replace(/&lt;i&gt;/g, "<i class='bi bi-image'></i> <em>(Image will be inserted here)</em>");
  document.getElementById('descPreview').innerHTML = content.replace(/\n/g, "<br>");
});

function removeImage(id, el) {
  if (confirm("Delete this image?")) {
    fetch("remove_image.php?id=" + id).then(res => res.text()).then(data => {
      if (data.trim() === "success") el.parentElement.remove();
    });
  }
}
</script>
</body>
</html>



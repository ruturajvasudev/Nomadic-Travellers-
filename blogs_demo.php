<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
$conn = new mysqli("localhost", "root", "", "travel_app");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch all locations
$query = "SELECT l.id, l.title, l.subtitle, l.description, l.tags, l.created_at, u.username
          FROM locations l
          JOIN users u ON u.id = l.user_id
          WHERE l.user_id = {$_SESSION['user_id']}
          ORDER BY l.created_at DESC";
$result = $conn->query($query);

// Collect unique tags
$allTags = [];
$locations = [];

while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
    if (!empty($row['tags'])) {
        $tagsArray = array_map('trim', explode(',', $row['tags']));
        $allTags = array_merge($allTags, $tagsArray);
    }
}
$uniqueTags = array_unique($allTags);
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
    .search-tags-container {
      text-align: center;
      margin-top: 20px;
    }
    .search-input {
      width: 250px;
      padding: 8px 12px;
      border-radius: 20px;
      border: 1px solid #ccc;
      outline: none;
      margin-bottom: 10px;
      transition: border-color 0.3s;
    }
    .search-input:focus {
      border-color: #ff4081;
    }
    .tags-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin: 10px auto 20px;
    }
    .tag-btn {
      background-color: #eee;
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .tag-btn.active {
      background-color: #ff4081;
      color: #fff;
      transform: scale(1.1);
      box-shadow: 0 0 10px rgba(255, 64, 129, 0.5);
    }
    .clear-btn {
      background-color: #ff4081;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 15px;
      font-size: 12px;
      margin-left: 10px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    .clear-btn:hover {
      background-color: #e0306e;
    }
    .blog-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      margin: 20px auto 60px;
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
      text-decoration: none;
    }
    .read-more:hover {
      background-color: #e0306e;
    }
    .hidden {
      display: none;
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
  <img src="floraldivider.png" width="300px">
</div>

<div class="search-tags-container">
  <input type="text" id="searchInput" class="search-input" placeholder="Search tags...">
  <button class="clear-btn" onclick="clearFilters()">Clear All</button>
</div>

<div class="tags-container" id="tagsContainer">
  <?php foreach ($uniqueTags as $tag): ?>
    <button class="tag-btn" data-tag="<?= htmlspecialchars($tag) ?>" onclick="toggleTag(this)"><?= htmlspecialchars($tag) ?></button>
  <?php endforeach; ?>
</div>

<div class="blog-grid" id="blogGrid">
  <?php foreach ($locations as $row): ?>
    <?php
      $imgQuery = $conn->query("SELECT image_path FROM location_images WHERE location_id = {$row['id']} LIMIT 1");
      $imgPath = ($imgQuery && $imgQuery->num_rows > 0) ? $imgQuery->fetch_assoc()['image_path'] : 'https://via.placeholder.com/350x180?text=No+Image';
      $tagsAttr = strtolower(str_replace(' ', '', $row['tags']));
    ?>
    <div class="blog-card" data-tags="<?= $tagsAttr ?>">
      <img src="<?= $imgPath ?>" class="blog-image" alt="Preview">
      <div class="blog-body">
        <div class="blog-title"><?= htmlspecialchars($row['title']) ?></div>
        <div class="blog-subtitle"><?= htmlspecialchars($row['subtitle']) ?></div>
        <a href="blog_detail.php?id=<?= $row['id'] ?>" class="read-more">Read More</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
let selectedTags = [];

function toggleTag(button) {
  const tag = button.getAttribute('data-tag').toLowerCase().replace(/\s/g, '');

  button.classList.toggle('active');

  if (button.classList.contains('active')) {
    selectedTags.push(tag);
  } else {
    selectedTags = selectedTags.filter(t => t !== tag);
  }

  filterBlogs();
}

function clearFilters() {
  selectedTags = [];
  document.querySelectorAll('.tag-btn').forEach(btn => btn.classList.remove('active'));
  filterBlogs();
}

function filterBlogs() {
  const blogs = document.querySelectorAll('.blog-card');

  if (selectedTags.length === 0) {
    blogs.forEach(blog => blog.classList.remove('hidden'));
    return;
  }

  blogs.forEach(blog => {
    const blogTags = blog.getAttribute('data-tags') || '';

    let match = selectedTags.some(tag => blogTags.includes(tag));
    if (match) {
      blog.classList.remove('hidden');
    } else {
      blog.classList.add('hidden');
    }
  });
}

document.getElementById('searchInput').addEventListener('input', function() {
  const searchVal = this.value.toLowerCase();
  document.querySelectorAll('#tagsContainer .tag-btn').forEach(btn => {
    if (btn.textContent.toLowerCase().includes(searchVal)) {
      btn.style.display = 'inline-block';
    } else {
      btn.style.display = 'none';
    }
  });
});
</script>

</body>
</html>

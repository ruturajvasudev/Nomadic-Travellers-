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
    $tags = $_POST['tags'];
    $location_name = $_POST['location_name'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $full_address = $_POST['full_address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $description = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $description);

    $conn = new mysqli("localhost", "root", "", "travel_app");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO locations (user_id, title, subtitle, description, tags, location_name, country, state, city, postal_code, full_address, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssddd", $user_id, $title, $subtitle, $description, $tags, $location_name, $country, $state, $city, $postal_code, $full_address, $latitude, $longitude);
    $stmt->execute();

    $location_id = $stmt->insert_id;

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

    echo '<script>alert("Location added successfully");</script>';
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
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
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
    #map {
      width: 100%;
      height: 300px;
      border: 2px solid #ccc;
      border-radius: 8px;
    }
    #mapAlert {
      color: red;
      font-size: 0.9rem;
      display: none;
    }
    .leaflet-container {
      width: 100% !important;
      height: 100% !important;
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
      <label for="tags" class="form-label">Tags <small class="text-muted">(comma separated)</small></label>
      <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g., beach, hiking, mountains">
    </div>
    <div class="mb-3">
      <label for="images" class="form-label">Upload Images</label>
      <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
    </div>

    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#locationModal">
      <i class="bi bi-geo"></i> Fill Location Details
    </button>
    <button type="submit" id="submitBtn" class="btn btn-danger" disabled><i class="bi bi-upload"></i> Submit Blog</button>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" data-bs-backdrop="true" data-bs-keyboard="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Location Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <input type="text" id="location_name" name="location_name" class="form-control mb-2" placeholder="Location Name" form="addLoc">
            <input type="text" id="country" name="country" class="form-control mb-2" placeholder="Country" form="addLoc">
            <input type="text" id="state" name="state" class="form-control mb-2" placeholder="State/Province" form="addLoc">
            <input type="text" id="city" name="city" class="form-control mb-2" placeholder="City (optional)" form="addLoc">
            <input type="text" id="postal_code" name="postal_code" class="form-control mb-2" placeholder="Postal Code" form="addLoc">
            <textarea id="full_address" name="full_address" class="form-control mb-2" placeholder="Full Address" form="addLoc"></textarea>
            <input type="hidden" name="latitude" id="latitude" form="addLoc">
            <input type="hidden" name="longitude" id="longitude" form="addLoc">
            <div id="mapAlert">⚠️ Please move the marker or search to set a valid location.</div>
          </div>
          <div class="col-md-6">
            <div id="map" class="w-100 h-100"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmLocation()" id="confirmLocationBtn" disabled>Confirm Location</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
  let map, marker;
  function initMap() {
    const defaultLatLng = [28.6139, 77.2090];
    map = L.map('map').setView(defaultLatLng, 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    marker = L.marker(defaultLatLng, { draggable: true }).addTo(map);
    marker.on('dragend', updateCoordinates);
    updateCoordinates();
  }

  async function updateCoordinates() {
    const { lat, lng } = marker.getLatLng();
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    document.getElementById('mapAlert').style.display = 'none';
    document.getElementById('confirmLocationBtn').disabled = false;

    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
    const data = await response.json();
    if (data && data.address) {
      const { city, town, village, state, country, postcode } = data.address;
      document.getElementById("city").value = city || town || village || '';
      document.getElementById("state").value = state || '';
      document.getElementById("country").value = country || '';
      document.getElementById("postal_code").value = postcode || '';
    }
  }

  async function updateMapFromAddress() {
    const country = document.getElementById("country").value;
    const state = document.getElementById("state").value;
    const city = document.getElementById("city").value;
    const full_address = document.getElementById("full_address").value;

    const address = `${full_address}, ${city}, ${state}, ${country}`;
    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`);
    const data = await response.json();

    if (data.length > 0) {
      const lat = parseFloat(data[0].lat);
      const lon = parseFloat(data[0].lon);
      map.setView([lat, lon], 12);
      marker.setLatLng([lat, lon]);
      updateCoordinates();
    } else {
      document.getElementById('mapAlert').style.display = 'block';
      document.getElementById('confirmLocationBtn').disabled = true;
    }
  }

  document.getElementById("country").addEventListener("blur", updateMapFromAddress);
  document.getElementById("state").addEventListener("blur", updateMapFromAddress);
  document.getElementById("city").addEventListener("blur", updateMapFromAddress);
  document.getElementById("full_address").addEventListener("blur", updateMapFromAddress);

  function confirmLocation() {
    const { lat, lng } = marker.getLatLng();
    if (!lat || !lng) {
      document.getElementById('mapAlert').style.display = 'block';
      return;
    }
    document.getElementById("latitude").value = lat;
    document.getElementById("longitude").value = lng;
    document.getElementById("submitBtn").disabled = false;
    bootstrap.Modal.getInstance(document.getElementById('locationModal')).hide();
  }

  window.addEventListener('load', initMap);
</script>
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

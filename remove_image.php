<?php
$conn = new mysqli("localhost", "root", "", "travel_app");
$id = intval($_GET['id']);
$conn->query("DELETE FROM location_images WHERE id = $id");
echo "success";
?>

<?php
$conn = new mysqli("localhost","root","","travel_app");
if ($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$result = $conn->query("SELECT * FROM locations ORDER BY created_at DESC");
$pagesHTML = "";
while($row = $result->fetch_assoc()){
    $title = htmlspecialchars($row['title']);
    $subtitle = htmlspecialchars($row['subtitle']);
    $desc = nl2br(htmlspecialchars(preg_replace('/\*(.*?)\*/','<strong>$1</strong>',$row['description'])));
    $imgs = "";
    $r2 = $conn->query("SELECT image_path FROM location_images WHERE location_id={$row['id']}");
    while($img = $r2->fetch_assoc()){
        $imgs .= "<img src=\"".htmlspecialchars($img['image_path'])."\" style=\"width:100%;margin:10px 0;\"/>";
    }
    $pagesHTML .= "<div class=\"fb-page\"><h2>$title</h2><h4>$subtitle</h4><div>$desc $imgs</div></div>";
}
?>
<!DOCTYPE html>
<html><head>
  <meta charset="UTF-8">
  <title>Flipbook Magazine</title>
  <!-- 3D FlipBook CSS (from jsDelivr) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/3d-flip-book@1.9.9/dist/css/flipbook.css"/>
  <style>
    body { margin:0; background:#eee; }
    .fb-container { max-width:900px; margin:20px auto; }
    .fb-page { padding:20px; font-family:Georgia,serif; }
    .fb-page h2 { margin:10px 0; }
    .fb-page h4 { margin:5px 0;color:#555; }
  </style>
</head><body>
  <div class="fb-container">
    <div id="flipbook"><?= $pagesHTML ?></div>
  </div>

  <!-- Required JS libs (via CDN) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/108/three.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>
  <script type="text/javascript">
    window.PDFJS_LOCALE = { pdfJsWorker: 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js' };
  </script>
  <!-- 3D FlipBook JS (from jsDelivr) -->
  <script src="https://cdn.jsdelivr.net/npm/3d-flip-book@1.9.9/dist/js/3dflipbook.min.js"></script>

  <script>
    $("#flipbook").flipBook({
      pages: '.fb-page',
      width: 900,
      height: 600,
      gradients: true,
      autoCenter: true
    });
  </script>
</body></html>

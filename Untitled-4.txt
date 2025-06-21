<?php
$conn = new mysqli("localhost", "root", "", "travel_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM locations ORDER BY created_at DESC");
$locations = [];

while ($row = $result->fetch_assoc()) {
    $location_id = $row['id'];
    $imageResult = $conn->query("SELECT * FROM location_images WHERE location_id = $location_id");

    $images = [];
    while ($img = $imageResult->fetch_assoc()) {
        $images[] = $img['image_path'];
    }

    $row['images'] = $images;
    $locations[] = $row;
}

function formatContent($text, $images) {
    $text = htmlspecialchars($text);
    $text = preg_replace('/\*(.*?)\*/', '<strong>$1</strong>', $text);
    foreach ($images as $imgPath) {
        $text = preg_replace('/&lt;i&gt;/', '<img src="' . htmlspecialchars($imgPath) . '" class="auto-img"/>', $text, 1);
    }
    return nl2br($text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Magazine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jQuery, Turn.js, html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.turnjs.com/lib/turn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Georgia', serif;
            background: linear-gradient(#d0d0d0, #f0f0f0);
            margin: 0;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .controls {
            margin-bottom: 20px;
        }

        button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #d62828;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        #magazine-container {
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 10px solid #fff;
            background: #fff;
            width: 1020px;
        }

        #flipbook {
            width: 1000px;
            height: 700px;
            margin: 0 auto;
        }

        .page {
            width: 500px;
            height: 700px;
            padding: 40px ;
            box-sizing: border-box;
            background: #fcfcfc;
            border: 1px solid black;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .mag-title {
            font-family: 'Baskerville', serif;
            font-size: 34px;
            text-align: center;
            font-weight:bold;
            margin-bottom: 10px;
            letter-spacing: 1px;
            color:rgb(244, 5, 5);
        }

        .mag-subtitle {
            font-family: 'Arial', sans-serif;
            font-size: 20px;
            text-align: center;
            font-weight:bold;
            color:rgb(19, 65, 7);
            margin-bottom: 20px;
            color: #666;
        }

        .location-description {
            font-size: 16px;
            line-height: 1.6;
            color: #444;
        }

        .auto-img {
            width: 400px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .cover-page {
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding: 0;
        }

        .cover-page img {
            max-width: 90%;
            height: auto;
            border-radius: 8px;
        }

        .cover-title {
            font-size: 40px;
            margin-top: 30px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .cover-subtitle {
            font-size: 22px;
            margin-top: 10px;
            color: #ddd;
        }
        * {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

    </style>
</head>
<body>

<div class="controls">
    <button id="prevPage">Previous</button>
    <button id="nextPage">Next</button>
    <button id="downloadPDF">Download as PDF</button>
</div>

<div id="magazine-container">
    <div id="flipbook">
        <!-- Cover Page -->
        <?php if (!empty($locations[0]['images'][0])): ?>
            <div class="page cover-page">
                <img src="<?= htmlspecialchars($locations[0]['images'][0]) ?>" alt="Cover Image">
                <div class="cover-title"><?= htmlspecialchars($locations[0]['title']) ?></div>
                <div class="cover-subtitle"><?= htmlspecialchars($locations[0]['subtitle']) ?></div>
                
            </div>
        <?php endif; ?>

        <!-- Inner Pages -->
        <?php foreach ($locations as $location): ?>
            <?php
            $description = formatContent($location['description'], $location['images']);
            $chunks = str_split($description, 1000);
            ?>
            <?php foreach ($chunks as $chunkIndex => $chunk): ?>
                <div class="page">
                    <?php if ($chunkIndex === 0): ?>
                        <div class="mag-title"><?= htmlspecialchars($location['title']) ?></div>
                        <?php if (!empty($location['subtitle'])): ?>
                            <div class="mag-subtitle"><?= htmlspecialchars($location['subtitle']) ?></div>
                        <?php endif; ?>
                       <center> <img src="floraldivider.png" width="200"></center>
                    <?php endif; ?>
                    <div class="location-description"><?= $chunk ?></div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#flipbook').turn({
            width: 1000,
            height: 700,
            autoCenter: true,
            display: 'double',
            acceleration: true,
            gradients: true,
            elevation: 50
        });

        $('#prevPage').click(function () {
            $('#flipbook').turn('previous');
        });

        $('#nextPage').click(function () {
            $('#flipbook').turn('next');
        });

        $('#downloadPDF').click(function () {
            const element = document.getElementById('flipbook');
            html2pdf().set({
                margin: 0,
                filename: 'travel_magazine.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'pt', format: 'a4', orientation: 'landscape' }
            }).from(element).save();
        });
    });
</script>

</body>
</html>

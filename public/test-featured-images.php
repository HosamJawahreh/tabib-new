<?php
// Simple test to check if images are accessible
echo "<h1>Testing Featured Product Images</h1>";

// Check if thumbnail directory exists
$thumbDir = __DIR__ . '/assets/images/thumbnails/';
echo "<h2>Thumbnail Directory: " . ($thumbDir) . "</h2>";
echo "<p>Exists: " . (is_dir($thumbDir) ? 'YES' : 'NO') . "</p>";

// List some thumbnails
if (is_dir($thumbDir)) {
    $files = array_slice(scandir($thumbDir), 2, 10); // Skip . and ..
    echo "<h3>Sample Files:</h3><ul>";
    foreach ($files as $file) {
        if (strpos($file, '_thumb.webp') !== false) {
            $url = '/assets/images/thumbnails/' . $file;
            echo "<li>";
            echo "<strong>$file</strong><br>";
            echo "<img src='$url' style='width: 100px; height: 100px; object-fit: contain; border: 1px solid #ccc; padding: 5px; background: #f8f9fa;' alt='test'>";
            echo "<br>URL: <code>$url</code>";
            echo "</li><br>";
        }
    }
    echo "</ul>";
}

echo "<hr>";
echo "<h2>Test with Bootstrap Grid & CSS</h2>";
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link rel="stylesheet" href="/assets/front/css/product-card-responsive.css?v=' . time() . '">';

echo '<div class="container-fluid px-4"><div class="row g-4">';
if (is_dir($thumbDir)) {
    $files = array_slice(scandir($thumbDir), 2, 6);
    foreach ($files as $file) {
        if (strpos($file, '_thumb.webp') !== false) {
            $url = '/assets/images/thumbnails/' . $file;
            echo '
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 product-item">
                <div class="product-card h-100 shadow-sm">
                    <div class="product-thumb position-relative">
                        <a href="#" class="d-block">
                            <img src="' . $url . '" alt="test" class="img-fluid product-image">
                        </a>
                    </div>
                    <div class="product-content p-3">
                        <h6>Test Product</h6>
                        <p class="text-success">10.00 JD</p>
                    </div>
                </div>
            </div>';
        }
    }
}
echo '</div></div>';
?>

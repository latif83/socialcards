<?php
// ---------------------------------------------
// 1. SETUP UPLOAD DIRECTORY (works on Azure + Localhost)
// ---------------------------------------------
$uploadDir = __DIR__ . "/uploads/";

// If uploads folder doesn't exist, create it
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// ---------------------------------------------
// 2. HANDLE UPLOAD REQUEST
// ---------------------------------------------
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {

    $file = $_FILES["image"];
    $allowedTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif", "image/webp"];

    // Error check
    if ($file["error"] !== 0) {
        $message = "Upload error!";
    }
    // Validate file type
    elseif (!in_array($file["type"], $allowedTypes)) {
        $message = "Invalid file type! Please upload JPG, PNG, GIF or WEBP.";
    }
    else {
        // Create unique filename
        $fileName = uniqid() . "_" . basename($file["name"]);
        $targetFile = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            $message = "Upload successful! Saved as: <br><strong>$fileName</strong>";

            // Public file URL (this works for localhost + Azure)
            $publicUrl = "uploads/" . $fileName;
        } else {
            $message = "Failed to move uploaded file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Test</title>
</head>
<body>

<h2>Test Image Upload</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

<?php if (!empty($message)): ?>
    <p><?= $message ?></p>

    <?php if (!empty($publicUrl)): ?>
        <p>Preview:</p>
        <img src="<?= $publicUrl ?>" width="200">
    <?php endif; ?>
<?php endif; ?>

</body>
</html>

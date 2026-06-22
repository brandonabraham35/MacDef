<?php
/**
 * Sanitize input data
 */
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Format date for display
 */
function formatDate($date) {
    return date('F j, Y', strtotime($date));
}

/**
 * Redirect to a given URL
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Generate a slug from string
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

/**
 * Upload an image
 */
function uploadImage($file, $targetDir) {
    $targetFile = $targetDir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($file["tmp_name"]);
    if($check === false) return ["success" => false, "message" => "File is not an image."];

    if ($file["size"] > 5000000) return ["success" => false, "message" => "File is too large."];

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return ["success" => false, "message" => "Only JPG, JPEG, PNG & GIF files are allowed."];
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return ["success" => true, "path" => $targetFile];
    } else {
        return ["success" => false, "message" => "Error uploading file."];
    }
}
?>

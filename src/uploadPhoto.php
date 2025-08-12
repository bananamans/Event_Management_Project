<?php
include("check_login.php");

$profileIcon;

if (isset($_SESSION['photo']) && $_SESSION['photo']) {
    echo "<script> alert('The file has been uploaded successfully'); </script>";
    unset($_SESSION['photo']);
}
if (isset($_SESSION['photo']) && !$_SESSION['photo']) {
    echo "<script> alert('Error: There was an error uploading the file, please make sure the photo size is suitable for profile picture'); </script>";
    unset($_SESSION['photo']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "<script> alert('Error: Please upload an image'); </script>";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "<script> alert('Error: Image already exists'); </script>";
        $uploadOk = 0;
    }

    // Check the file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "<script> alert('Error: File size too large'); </script>";
        $uploadOk = 0;
    }

    // Allow only file formats jpeg, jpg and png
    $allowedFormats = array("jpeg", "jpg", "png");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "<script> alert('Error: Only JPEG, JPG, AND PNG files are allowed'); </script>";
        $uploadOk = 0;
    }

    // Retrieve the username from the session
    $username = $_SESSION['username'];

    // Remove spaces from the username and replace them with an underscore
    $username = str_replace(' ', '_', $username);

    // Construct the new filename using the modified username and PNG extension
    $newFilename = $username . '.png';
    $targetFile = $targetDir . $newFilename;

    // Check the original file extension
    $originalExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

    // Convert the uploaded image to PNG format if it's not already a PNG
    if ($originalExtension !== 'png') {
        if ($originalExtension === 'jpg' || $originalExtension === 'jpeg') {
            $image = imagecreatefromjpeg($_FILES["image"]["tmp_name"]);
        } elseif ($originalExtension === 'gif') {
            $image = imagecreatefromgif($_FILES["image"]["tmp_name"]);
        } else {
            echo "<script> alert('Error: Only JPG, JPEG, and PNG files can be uploaded'); </script>";
            $uploadOk = 0;
        }

        if ($uploadOk) {
            imagepng($image, $targetFile);
            imagedestroy($image);
        }
    } else {
        // Move the uploaded file to the target directory without conversion
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    }

    if ($uploadOk) {
        $_SESSION['photo'] = true;
        $profileIcon = $targetFile;
        $_SESSION['profile_icon'] = $profileIcon;

        header("Location: uploadPhoto.php");
        exit();
    } else {
        $_SESSION['photo'] = false;
        header("Location: uploadPhoto.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="images/favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="SignForm.css" />
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <div class="signFormContainer">
        <h1>Upload photo</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"
            id="upload-photo">
            <label for="image">Select an image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <input type="submit" value="Upload" id="upload">
        </form>

    </div>

</body>

</html>
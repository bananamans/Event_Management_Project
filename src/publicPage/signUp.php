<?php
// Connect to the database
include('../connectDB.php');

// Get form input values
$nameValue = $_POST['fullName'];
$passwordValue = trim($_POST['password']);
$conPassValue = trim($_POST['confirm-password']);
$emailValue = trim($_POST['email']);

$errors = array();
$valid = true;

if (empty($nameValue)) {
    $valid = false;
    $errors[] = "Please enter your full name.";
}

if (empty($passwordValue)) {
    $valid = false;
    $errors[] = "Please enter a password.";
}

if (empty($conPassValue)) {
    $valid = false;
    $errors[] = "Please enter confirm password.";
}

if (empty($emailValue)) {
    $valid = false;
    $errors[] = "Please enter your email.";
}

if ($valid) {
    // Validate full name
    if (!preg_match('/^[a-zA-Z\s]*[a-zA-Z][a-zA-Z\s]*$/', $nameValue)) {
        $valid = false;
        $errors[] = "Full name should only contain letters and spaces.";
    }

    // Validate email
    if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        $errors[] = "Please enter a valid email address.";
    }

    // Validate password
    if (strlen($passwordValue) < 6) {
        $valid = false;
        $errors[] = "Password should be at least 6 characters long.";
    }
    if (!preg_match('/[A-Z]/', $passwordValue)) {
        $valid = false;
        $errors[] = "Password should contain at least one uppercase letter.";
    }
    if (!preg_match('/[0-9]/', $passwordValue)) {
        $valid = false;
        $errors[] = "Password should contain at least one numeric character.";
    }
    if (!preg_match('/[\W]/', $passwordValue)) {
        $valid = false;
        $errors[] = "Password should contain at least one special character.";
    }
    if (preg_match('/\s/', $passwordValue)) {
        $valid = false;
        $errors[] = "Password should not contain spaces.";
    }

    if ($passwordValue !== $conPassValue) {
        $valid = false;
        $errors[] = "Please make sure re-enter password is the same as the password.";
    }

    // Perform username availability check
    $query = "SELECT * FROM user WHERE username = '$nameValue'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $valid = false;
        $errors[] = "Username has been taken.";
    }
}

if (empty($errors)) {
    $sql = "INSERT INTO user (username, password, email) VALUES
('$nameValue', '$passwordValue', '$emailValue')";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../login.php?registration=success");
        mysqli_close($conn);
        exit;
    } else {
        header("Location: signUp.html?registration=failed");
        mysqli_close($conn);
        exit;
    }
} else {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo "please register again";
}

mysqli_close($conn);
?>
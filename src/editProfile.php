<?php
include("connectDB.php");
include("check_login.php");

$username = $_SESSION['username'];
$password = $_SESSION['password'];
$email = $_SESSION['email'];

if (isset($_SESSION['edit']) && $_SESSION['edit']) {
    echo "<script> alert('Changes successfully saved'); </script>";
    unset($_SESSION['edit']);
}
if (isset($_SESSION['edit']) && !$_SESSION['edit']) {
    echo "<script> alert('Failed to save changes'); </script>";
    unset($_SESSION['edit']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST['name'];
    $newEmail = trim($_POST['email']);
    $oldPassword = trim($_POST['oldPassword']);
    $newPassword = trim($_POST['newPassword']);

    $errors = array();
    $valid = true;

    if (empty($newName)) {
        $valid = false;
        $errors[] = "Please enter your full name.";
    }

    if (empty($oldPassword)) {
        $valid = false;
        $errors[] = "Please enter your old password.";
    }

    if (empty($newPassword)) {
        $valid = false;
        $errors[] = "Please enter your new password.";
    }

    if (empty($newEmail)) {
        $valid = false;
        $errors[] = "Please enter your email.";
    }

    if ($valid) {

        if ($oldPassword != $password) {
            $valid = false;
            $errors[] = "Incorrect old password!";
        }

        // Validate full name
        if (!preg_match('/^[a-zA-Z\s]*[a-zA-Z][a-zA-Z\s]*$/', $newName)) {
            $valid = false;
            $errors[] = "Username should only contain letters and spaces.";
        }

        // Validate email
        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $valid = false;
            $errors[] = "Please enter a valid email address.";
        }

        // Validate password
        if (strlen($newPassword) < 6) {
            $valid = false;
            $errors[] = "New password should be at least 6 characters long.";
        }
        if (!preg_match('/[A-Z]/', $newPassword)) {
            $valid = false;
            $errors[] = "New password should contain at least one uppercase letter.";
        }
        if (!preg_match('/[0-9]/', $newPassword)) {
            $valid = false;
            $errors[] = "New password should contain at least one numeric character.";
        }
        if (!preg_match('/[\W]/', $newPassword)) {
            $valid = false;
            $errors[] = "New password should contain at least one special character.";
        }
        if (preg_match('/\s/', $newPassword)) {
            $valid = false;
            $errors[] = "New password should not contain spaces.";
        }

        // Perform username availability check
        $query = "SELECT * FROM user WHERE username = '$newName'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0 && $newName != $username) {
            $valid = false;
            $errors[] = "Username has been taken.";
        }
    }

    if (empty($errors)) {

        $success = true;
        $stmtUser = $conn->prepare("UPDATE user SET username = ?, email = ?, password = ? WHERE username = ?");
        $stmtUser->bind_param("ssss", $newName, $newEmail, $newPassword, $username);
        $success = $stmtUser->execute();


        if ($success) {
            $stmtEvent = $conn->prepare("UPDATE event SET username = ? WHERE username = ?");
            $stmtEvent->bind_param("ss", $newName, $username);
            $success = $stmtEvent->execute();
        }


        if ($success) {
            $stmtPayment = $conn->prepare("UPDATE payment SET username = ? WHERE username = ?");
            $stmtPayment->bind_param("ss", $newName, $username);
            $success = $stmtPayment->execute();
        }

        if ($success) {
            // Redirect to the profile page after successful update
            $_SESSION['username'] = $newName;
            $_SESSION['email'] = $newEmail;
            $_SESSION['password'] = $newPassword;

            //update the profile icon name if user has one
            if (isset($_SESSION['profile_icon']) && !empty($_SESSION['profile_icon'])) {
                $newProfileIcon = 'images/' . $newName . '.png';
                rename($_SESSION['profile_icon'], $newProfileIcon);
                $_SESSION['profile_icon'] = $newProfileIcon;
            }

            $_SESSION['edit'] = true;
            mysqli_close($conn);
            header("Location: editProfile.php");
            exit();
        } else {
            $_SESSION['edit'] = false;
            mysqli_close($conn);
            header("Location: editProfile.php");
            exit();
        }
    } else {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c55c2b3c60.js" crossorigin="anonymous"></script>
    <style>
        .togglePassword {
            top: 55%;
            right: 95px;
        }
    </style>
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <div class="signFormContainer">
        <h1>Edit Profile</h1>
        <div id="edit-profile-form">
            <form class="signForm" action="editProfile.php" method="post">
                <div class="formGroup">
                    <label>Username</label><br>
                    <input type="text" id="newName" class="loginInput" name="name" maxlength="30"
                        value="<?php echo $username; ?>" required />
                </div>
                <div class="formGroup">
                    <label>Email</label><br>
                    <input type="email" id="newEmail" class="loginInput" name="email" maxlength="50"
                        value="<?php echo $email; ?>" required />
                </div>
                <div class="formGroup">
                    <label>Old password</label><br>
                    <input type="password" id="oldPassword" class="loginInput" name="oldPassword" maxlength="20"
                        required />
                    <span class="togglePassword" onclick="toggleOldPasswordVisibility()">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <div class="formGroup">
                    <label>New Password</label><br>
                    <input type="password" id="newPassword" class="loginInput" name="newPassword" maxlength="20"
                        required />
                    <span class="togglePassword" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <button class="login-button" id="saveBtn" type="submit" onclick="verifyChanges(event)">Save
                    Changes</button>
            </form>
        </div>
    </div>
    <script src="editProfile.js"></script>
</body>

</html>
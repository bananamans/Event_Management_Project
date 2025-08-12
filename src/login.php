<?php
include("connectDB.php");

session_start();

$userFound = true;
$errors = array();
$alert = false;

if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameValue = trim($_POST['fullName']);
    $passwordValue = trim($_POST['password']);

    $valid = true;

    if (empty($nameValue)) {
        $valid = false;
        $errors[] = "Please enter your full name.";
    }
    if ($valid && !preg_match('/^[a-zA-Z\s]*$/', $nameValue)) {
        $valid = false;
        $errors[] = "Full name should only contain letters and spaces.";
    }

    if (empty($errors)) {
        $sql = "SELECT * FROM user WHERE username='$nameValue' AND password='$passwordValue'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if ($result && mysqli_num_rows($result) > 0) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['email'] = $row['email'];

            $username = $row['username'];

            // Remove spaces from the username or replace them with an underscore
            $username = str_replace(' ', '_', $username);

            // Construct the filename for the profile icon
            $profileIcon = "images/" . $username . ".png";
            if (file_exists($profileIcon)) {
                $_SESSION['profile_icon'] = $profileIcon;
            } else {
                $_SESSION['profile_icon'] = "";
            }

            $_SESSION['loggedin'] = true;
            mysqli_close($conn);
            // Redirect the user to dashboard
            header("Location: memberDashboard.php");
            exit();
        } else {
            $userFound = false;
        }
    }
    mysqli_close($conn);
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
    <script src="https://kit.fontawesome.com/c55c2b3c60.js" crossorigin="anonymous"></script>
    <title>Techvent</title>
</head>

<body>
    <?php
    include("navbar.php");
    ?>

    <!-- content -->
    <div class="signFormContainer">
        <h1>Log in</h1>
        <div id="login-form">
            <form class="signForm" action="login.php" method="post">
                <div class="formGroup" id="login-name">
                    <input type="text" id="fullName" class="loginInput" name="fullName" maxlength="30"
                        placeholder="Username" required />
                </div>
                <div class="formGroup">
                    <input type="password" id="password" class="loginInput" name="password" maxlength="20"
                        placeholder="Password" required />
                    <span class="togglePassword" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </span>
                </div>
                <button class="login-button" type="submit" onclick="verifyLogin()">Log in</button>
                <div>
                    <p><a href="publicPage/signUp.html" id="create-account">Sign up here!</a></p>
                    <p><a href="adminLogin.php" id="admin-login-text">Log in as admin</a></p>
                </div>
            </form>
        </div>
    </div>
    <script>
        <?php if (!empty($errors)): ?>
            setTimeout(function () {
                alert(<?php echo json_encode(implode('\n', $errors)); ?>);
            }, 100);
        <?php endif; ?>

        <?php if (!$userFound): ?>
            setTimeout(function () {
                alert('Incorrect username or password');
            }, 100);
        <?php endif; ?>

        <?php if ($alert): ?>
            setTimeout(function () {
                alert('Please log in first');
            }, 100);
        <?php endif; ?>
    </script>

    <script src="login.js"></script>
    <script>
        document.getElementById("navProfilePic").innerHTML =
            '<a href="login.php">Login</a>';

        document.getElementById("logo").addEventListener("click", () => {
            window.location.href = "index.html";
        });
    </script>
</body>

</html>
<?php
include("connectDB.php");

session_start();

$adminFound = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nameValue = trim($_POST['fullName']);
    $passwordValue = trim($_POST['password']);

    $sql = "SELECT * FROM admin WHERE admin_username='$nameValue' AND admin_password='$passwordValue'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($result && mysqli_num_rows($result) > 0) {
        $_SESSION['admin_username'] = $row['admin_username'];
        $_SESSION['admin_password'] = $row['admin_password'];

        // Redirect the admin to dashboard
        header("Location: adminPage/adminDashboard.php");
        mysqli_close($conn);
        exit();
    } else {
        $adminFound = false;
    }
}

mysqli_close($conn);
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
    <div class="signFormContainer" style="padding-bottom: 60px;">
        <h1>Log in as admin</h1>
        <div id="login-form">
            <form class="signForm" action="adminLogin.php" method="post">
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
                <button class="login-button" type="submit">Log in</button>
            </form>
        </div>
    </div>

    <script>
    const togglePasswordVisibility = () => {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
    document.getElementById("navProfilePic").innerHTML =
        '<a href="login.php">Login</a>';

    document.getElementById("logo").addEventListener("click", () => {
        window.location.href = "index.html";
    });
    <?php if (!$adminFound): ?>
    setTimeout(function() {
        alert('Incorrect admin username or password');
    }, 100);
    <?php endif; ?>
    </script>


</body>

</html>
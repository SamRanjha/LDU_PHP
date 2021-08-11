<html>
<?php
session_start();
require "config.php";
?>

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
        <h3>"Welcome, " <?php $_SESSION['username'] ?> "!"; </h3>
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ?>
            <input type="submit" name="logout" value="Logout"><br>
        </form>
    <?php } else { ?>
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ?>
            <label>Username</label><br>
            <input type="text" name="username"><br>
            <label>Password</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="checkbox" name="remember" id="remember" />
            <label for="remember-me">Remember me</label><br>
            <input type="submit" name="submit" value="Submit Form"><br>
        </form>
    <?php } ?>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
        session_destroy();
        showAlertAndReturntoPage("Log Out Successfull");
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $userName = $_POST['username'];
        $password = $_POST['password'];

        if (empty($userName)) {
            showAlertAndReturntoPage("Username can not be blank");
        }

        if (empty($password)) {
            showAlertAndReturntoPage("Password can not be blank");
        }

        $queryForSelect = "SELECT username FROM 6470exerciseusers WHERE username = '$userName' and password_hash = '$encodedPassword'";
        if ($stmt = mysqli_prepare($db, $queryForSelect)) {
            $error = mysqli_query($db, $queryForSelect);
            if ($error) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    if (!empty($_POST["remember"])) {
                        setcookie("username", $userName, time() + (10 * 365 * 24 * 60 * 60));
                    }
                    showAlertAndReturntoPage("Welcome " . $userName);
                } else {
                    showAlertAndReturntoPage("Username or password invalid.");
                }
            } else {
                showAlertAndReturntoPage("Something went wrong. Please try again later.");
            }
            mysqli_stmt_close($stmt);
        }

    }

    function showAlertAndReturntoPage($alertMessage)
    {
        echo '<script type="text/javascript">';
        echo "alert('$alertMessage');";
        echo 'window.location.href = "login.php";';
        echo '</script>';
    }
    ?>

</body>

</html>
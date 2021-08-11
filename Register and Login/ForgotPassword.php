<html>

<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
</head>

<body>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ?>
        <label>Username</label>
        <input type="text" name="username">
        <label>Phone Number</label>
        <input type="text" id="phone" name="password">
        <input type="submit" name="submit" value="Submit Form"><br>
    </form>

    <?php
    require "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userName = $_POST['username'];
        $phone = $_POST['phone'];
        echo  $userName;

        if (empty($userName)) {
            showAlertAndReturntoPage("Username can not be blank");
        }

        if (empty($password)) {
            showAlertAndReturntoPage("Password can not be blank");
        }

        $queryForSelect = "SELECT username FROM 6470exerciseusers WHERE username = '$userName' and PHONE = '$phone'";

        $error = mysqli_query($db, $queryForSelect) or trigger_error("Query Failed! SQL: $queryForInsert - Error: " . mysqli_error($db), E_USER_ERROR);;
        if ($error) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $newPassword = randomPassword();
                showAlertAndReturntoPage("New password is: " . $newPassword);
            } else {
                showAlertAndReturntoPage("Wrong username or phone number");
            }
        } else {
            showAlertAndReturntoPage("Something went wrong. Please try again later.");
        }
        mysqli_stmt_close($stmt);
    }


    function showAlertAndReturntoPage($alertMessage)
    {
        echo '<script type="text/javascript">';
        echo "alert('$alertMessage');";
        echo 'window.location.href = "ForgotPassword.php";';
        echo '</script>';
    }

    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
    ?>

</body>

</html>
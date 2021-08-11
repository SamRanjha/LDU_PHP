<html>

<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
</head>

<body>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ?>
        <label>Username</label>
        <input type="text" name="username">
        <label>Old Password</label>
        <input type="password" id="oldpassword" name="oldpassword">
        <label>New Password</label>
        <input type="password" id="newpassword" name="newpassword">
        <input type="submit" name="submit" value="Submit Form"><br>
    </form>

    <?php
    require "config.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userName = $_POST['username'];
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];

        if (empty($userName)) {
            showAlertAndReturntoPage("Username can not be blank");
        }

        if (empty($oldpassword)) {
            showAlertAndReturntoPage("Old Password can not be blank");
        }

        if (empty($newpassword)) {
            showAlertAndReturntoPage("New Password can not be blank");
        }

        $encodedOldPassword = password_hash($oldpassword, PASSWORD_DEFAULT);

        $queryForSelect = "SELECT username FROM 6470exerciseusers WHERE username = '$userName' and password_hash = '$encodedOldPassword'";

        $error = mysqli_query($db, $queryForSelect) or trigger_error("Query Failed! SQL: $queryForInsert - Error: " . mysqli_error($db), E_USER_ERROR);;
        if ($error) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                $encodedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $queryForSelect = "UPDATE 6470exerciseusers set password_hash = '$encodedNewPassword' where username = '$userName'";
                $error = mysqli_query($db, $queryForInsert) or trigger_error("Query Failed! SQL: $queryForInsert - Error: " . mysqli_error($db), E_USER_ERROR);;
                if ($error) {
                    showAlertAndReturntoPage("Password Updated successfully");
                } else {
                    showAlertAndReturntoPage("Something went wrong. Please try again later.");
                }
            } else {
                showAlertAndReturntoPage("Wrong username or password");
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
        echo 'window.location.href = "ChangePasword.php";';
        echo '</script>';
    }
    ?>

</body>

</html>
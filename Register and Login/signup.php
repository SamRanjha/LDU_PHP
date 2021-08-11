<html>

<head>
    <meta charset="utf-8">
    <title>User Registration</title>
</head>

<body>
    <?php
    require_once "config.php";
    $isInserted = false;
    $userName = "";
    $phoneNumber = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userName = trim(mysqli_real_escape_string($db, $_POST['username']));
        $password = trim(mysqli_real_escape_string($db, $_POST['password']));
        $phoneNumber = trim(mysqli_real_escape_string($db, $_POST['phonenumber']));

        if (empty($userName)) {
            showAlertAndReturntoPage("Username can not be blank");
        }

        if (empty($password)) {
            showAlertAndReturntoPage("Password can not be blank");
        }

        if (empty($phoneNumber)) {
            showAlertAndReturntoPage("PhoneNumber can not be blank");
        }

        $queryForSelect = "SELECT USERNAME FROM 6470exerciseusers WHERE USERNAME = '$userName'";

        if ($stmt = mysqli_prepare($db, $queryForSelect)) {
            $error = mysqli_query($db, $queryForSelect);
            if ($error) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0) {
                    showAlertAndReturntoPage("This username is already taken.");
                }
            } else {
                showAlertAndReturntoPage("Something went wrong. Please try again later.");
            }
            mysqli_stmt_close($stmt);
        }

        $encodedPassword = password_hash($password, PASSWORD_DEFAULT);

        $queryForInsert = "INSERT INTO 6470exerciseusers (username, password_hash, phone) VALUES ('$userName', '$encodedPassword', '$phoneNumber')";
        $error = mysqli_query($db, $queryForInsert) or trigger_error("Query Failed! SQL: $queryForInsert - Error: " . mysqli_error($db), E_USER_ERROR);;
        if ($error) {
            $isInserted = true;
            echo '<script type="text/javascript">';
            $url = "signup.php?inserted=true&user=".urlencode($userName)."&phone=".urlencode($phoneNumber);
            echo "window.location.href = '$url';";
            echo '</script>';
        } else {
            showAlertAndReturntoPage("Something went wrong. Please try again later.");
        }
        showAlertAndReturntoPage("Inserting done");
    } else if (isset($_GET["inserted"]) && $_GET["inserted"]) { ?>
        <h3> UserName : <?php echo $_GET["user"]?> </h3><br>
        <h3> Password : <?php echo $_GET["phone"] ?> </h3><br>
    <?php } else if (!isset($_GET["inserted"])) { ?>
        <div class="wrapper">
            <h2>Sign Up</h2>
            <form method="POST" action="" ?>
                <label>Username</label><br>
                <input type="text" id="username" name="username" class="form-control"><br>
                <label>Password</label><br>
                <input type="password" id="password" name="password" class="form-control"><br>
                <label>Phone Number</label><br>
                <input type="text" id="phonenumber" name="phonenumber" class="form-control"><br>
                <input type="submit" id="inputName" name="submit" value="Submit Form"><br>
            </form>
        </div>


    <?php }
    $isInserted = true;
    function showAlertAndReturntoPage($alertMessage)
    {
        echo '<script type="text/javascript">';
        echo "alert('$alertMessage');";
        echo 'window.location.href = "signup.php";';
        echo '</script>';
    }
    ?>

</body>

</html>
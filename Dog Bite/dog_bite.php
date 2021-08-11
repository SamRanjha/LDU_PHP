<html>

<head>
    <meta charset="utf-8">
    <title>Did Charlie Bite You</title>
</head>

<body>
    <form method="post">
        <input type="submit" name="test" value="CHECK" />
    </form>
   
    <?php
    $didDogBite = -1;
    function isBitten() {
        $no = rand(0, 1);
        if ($no == 0) {
            return true;
        }

        return false;
    }

    if(array_key_exists('test',$_POST)){
        $didDogBite = isBitten();
        if ($didDogBite == 1) {
            echo "<input type='text' size = '50' value = 'Charlie bit your finger!'>";
        } else if ($didDogBite == 0) {
            echo "<input type='text' size = '50' value = 'Charlie did not bite your finger! '>";
        }
     }
?>

</body>



</html>


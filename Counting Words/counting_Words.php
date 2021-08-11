<html>

<head>
    <meta charset="utf-8">
    <title>Counting Words</title>
</head>

<body>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" ?>
        <input type="text" name="sentence">
        <input type="submit" name="submit" value="Submit Form"><br>
    </form>

    <?php
    $words_freq_map;
    function countWords($inputString)
    {
        if (strlen($inputString) == 0) {
            return;
        }
        $lowerString = strtolower($inputString);
        $words = explode(' ', $lowerString);
        $words_freq_map = array();

        for ($i = 0; $i < count($words); $i++) {
            $word = $words[$i];
            if (array_key_exists($word, $words_freq_map)) {
                $words_freq_map[$word]++;
            } else {
                $words_freq_map[$word] = 1;
            }
        }
        arsort($words_freq_map);
        array_to_table($words_freq_map);
        return;
    }

    function array_to_table($words_freq_map)
    {
        if (count($words_freq_map) < 1) {
            $words_freq_map = array();
            return;
        }
        echo "<table>";
        echo "<th> Word </th>";
        echo "<th> Frequency </th>";


        foreach ($words_freq_map as $value => $count) {
            echo "<tr>";
            echo "<td>" . $value . "</td>";
            echo "<td>" . $count . "</td>;
            </tr>";
        }
        echo "</table>";
        $words_freq_map = array();
    }

    if (array_key_exists('submit', $_POST)) {
        $post_data = file_get_contents('php://input');
        $sentence = $_POST["sentence"];
        header('Location:' . $_SERVER['PHP_SELF'] . '?sentence=' . $sentence);
        die;
    }

    if (isset($_GET["sentence"])) {
        $sentence = $_GET["sentence"];
        countWords($sentence);
    }
    ?>

</body>



</html>
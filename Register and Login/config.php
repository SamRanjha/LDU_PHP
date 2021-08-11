<?php
$dbServer = '127.0.0.1';
$userName = 'root';
$password = '';
$dbName = 's6470';

$conn = new mysqli($dbServer, $userName, '');

if (!$conn) {
  die("Failed to connect to MySQL: " . $conn->connect_error);
}

if (!mysqli_select_db($conn, $dbName)){
  $query = "CREATE DATABASE ".$dbName.";";
  echo "<script> alert('$query'); </script>";
  if ($conn->query($query)) {
      echo "Database created successfully";
  }else {
      die("Error creating database: " . $conn->error);
  }
}

$conn->close();

$db = mysqli_connect($dbServer, $userName, $password, $dbName);

$tableQuery = "DROP TABLE 6470exerciseusers";

$tableQuery = "CREATE TABLE IF NOT EXISTS 6470exerciseusers (
  USERNAME VARCHAR(100),
  PASSWORD_HASH CHAR(100),
  PHONE VARCHAR(10)
  )";

if ($db->query($tableQuery)) {
  // echo "Table created successfully";
}else {
  die("Error creating table: " . $db->error);
}

?>

<?php
//skript pro odstranění uživatele
$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";

$conn=mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$id = $_GET['id'];
$sql = "DELETE FROM `uzivatele` WHERE `uzivatele`.`id` = '$id'";

$result = $conn->query($sql);
if ($result) {
    echo "User deleted"; 
    header("Location: uzivatele.php?sort=id", true, 301);
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close()
?> 
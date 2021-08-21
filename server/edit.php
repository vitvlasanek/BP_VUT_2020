<?php
//skript pro zapsání úpravy uživatele
$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}          
$id = $_GET['id'];
$sql = "UPDATE `uzivatele` SET `cislo` = '$_POST[cislo]', `jmeno` = '$_POST[jmeno]', `prijmeni` = '$_POST[prijmeni]', `nazev karty` = '$_POST[nazev_karty]', `rfid` = '$_POST[rfid]' WHERE `uzivatele`.`id` = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    sleep(1);
    header("Location: uzivatele.php?sort=id", true, 301);
} 
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close()
?>

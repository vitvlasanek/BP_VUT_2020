<?php
//skript pro vyhledání informace o přístupu z dveři ke kterým je připojeno ESP. To si údaj vezme pomoci http.GET
$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$door = $_GET['door'];
$sql = "SELECT pristup FROM zaznamy WHERE `dvere` = '$door' ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo $row['pristup']; 
}
$conn->close()
?> 
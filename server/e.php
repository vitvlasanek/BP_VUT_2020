<?php

//skript pro vložení nového uživatele do databáze

$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}                              

$sql = "SELECT * FROM uzivatele WHERE rfid ='$_POST[rfid]'";
		$result = $conn->query($sql);

			if ($result->num_rows > 0) {
                echo "K tomuto tagu byl již připřazen uživatel.";
                }
            else{
                $sql="INSERT INTO `uzivatele` (`cislo`, `jmeno`, `prijmeni`, `nazev karty`, `rfid`)
                VALUES('$_POST[cislo]','$_POST[jmeno]','$_POST[prijmeni]','$_POST[nazev_karty]','$_POST[rfid]')";

                if ($conn->query($sql) === TRUE) {
                    echo "Nový uživatel úspěšně vytvořen";
                    sleep(1);
                    header("Location: uzivatele.php?sort=id", true, 301);
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
$conn->close()
?>
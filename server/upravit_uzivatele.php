<html>
<!-- stránka pro úpravu existujících uživatelů -->
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel = "icon" href = "FSI_icon.png"type = "image/x-icon">
<title>Upravit uživatele</title>
<style>
.button{
width: 15%;
padding:16px 0px;
}

</style>
</head>
<body>

<?php

$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";
$id = $_GET['id'];
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM uzivatele WHERE `uzivatele`.`id` = $id";
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        ?>

        <button class="button button1" onclick="window.location.href='uzivatele.php?sort=';">Zpět</button><br><br><br>
        <form action="edit.php?id=<?= $row["id"];?>" method="post">
        <div style="text-align:center;">
        <label for="cislo">Číslo:</label><br>
        <input type="number" name="cislo"placeholder="Číslo" autocomplete="off" value=<?php echo $row["cislo"]; ?>><br><br>
        <label for="jmeno">Jméno:</label><br>
        <input type="text" minlength="2" name="jmeno" placeholder="Jméno" required autocomplete="off" value=<?php echo $row["jmeno"]; ?>><br><br>
        <label for="prijmeni">Příjmení:</label><br>
        <input type="text" minlength="2" name="prijmeni" placeholder="Příjmení" required autocomplete="off" value=<?php echo $row["prijmeni"]; ?>><br><br>
        <label for="nazev_karty">Typ karty:</label><br>
        <input type="text" name="nazev_karty" placeholder="Název karty" autocomplete="off" value=<?php echo $row["nazev karty"]; ?>><br><br>
        <label for="rfid">RFID:</label><br>
        <input type="number" name="rfid"  min="100000000" max="99999999999" placeholder="RFID" value=<?php echo $row["rfid"]; ?> required autocomplete="off"><br><br>
        <input type="submit" value="Uložit změny">
        </div>
        </form>
        <?php
    }   
    $result->free();
}
$conn->close()
?>
</body>
</html>
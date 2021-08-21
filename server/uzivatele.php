<!DOCTYPE html>
<html>
<!-- stránka se seznamem uživatelů-->
<head>
	 	<meta http-equiv="content-type" content="text/html;charset=utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<title>Uživatelé</title>
    	<link rel = "icon" href = "FSI_icon.png"type = "image/x-icon">
		<link rel="stylesheet" type="text/css" href="style.css">
		<style>
		    th {
 		    border-left: 1px solid white;
		    }
		    th:hover {
		    background-color:cadetblue;
            }
            .smazat:link, .smazat:visited, .edit:link, .edit:visited {
                color: black;
                text-decoration: none;
                }   

            .smazat:hover {
            color: red;
            }
            .edit:hover {
            color: yellow;
            }

        </style>
</head>
<body>
<button class="button button1" onclick="window.location.href='main.html';">Zpět</button>
<button class="button button2" onclick="window.location.href='pridat_uzivatele.php?rfid=';">Přidat uživatele</button>
<table id="myTable">
    <th style="width:3%;"><a href="uzivatele.php?sort=id">ID:</a></th>
    <th style="width:15%;"><a href="uzivatele.php?sort=cislo">Číslo:</a></th>
    <th style="width:20%;"><a href="uzivatele.php?sort=jmeno">Jméno:</a></th>
    <th style="width:20%;"><a href="uzivatele.php?sort=prijmeni">Příjmení:</a></th>
    <th style="width:22%;"><a href="uzivatele.php?sort=nazev_karty">Název karty:</a></th>
    <th style="width:20%;"><a href="uzivatele.php?sort=rfid">RFID:</a></th>
    <th style="width:10%;">Správa</th> 
<?php

include "create_dtb.php";

$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT `id`, `cislo`, `jmeno`, `prijmeni`, `nazev karty`, `rfid` FROM `uzivatele`";
if ($_GET['sort'] == 'id')
{
    $sql .= " ORDER BY id";
}
elseif ($_GET['sort'] == 'cislo')
{
    $sql .= " ORDER BY cislo";
}
elseif ($_GET['sort'] == 'jmeno')
{
    $sql .= " ORDER BY jmeno";
}
elseif ($_GET['sort'] == 'prijmeni')
{
    $sql .= " ORDER BY prijmeni";
}
elseif ($_GET['sort'] == 'nazev karty')
{
    $sql .= " ORDER BY nazev_karty";
}
elseif ($_GET['sort'] == 'rfid')
{
    $sql .= " ORDER BY rfid";
}


if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr> 
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo $row["cislo"]; ?></td>
            <td><?php echo $row["jmeno"]; ?></td>
            <td><?php echo $row["prijmeni"]; ?></td>
            <td><?php echo $row["nazev karty"]; ?></td>
            <td><?php echo $row["rfid"]; ?></td>
            <td><a href="delete.php?id=<?= $row["id"];?>" onclick="return confirm('Opravdu chcete uživatele smazat?')" class=smazat>Smazat</a>
            <a href="upravit_uzivatele.php?id=<?= $row["id"];?>" class=edit>Upravit</a></td>
        </tr>
        <?php
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
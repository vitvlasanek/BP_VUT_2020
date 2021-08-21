<?php
//zobrazení příchodů
include "create_dtb.php";

if(isset($_POST['search']))
{
    $valueToSearch = $_POST['valueToSearch'];
    // vyhledávání v databázi
    $query = "SELECT * FROM `zaznamy` WHERE CONCAT(`pristup`, `cislo`, `dvere`, `jmeno`, `prijmeni`, `rfid`, `reading_time`) LIKE '%".$valueToSearch."%' ORDER BY `zaznamy`.`id` DESC";
    $search_result = filterTable($query);
    
}
 else {
    $query = "SELECT * FROM `zaznamy` ORDER BY `zaznamy`.`id` DESC";
    $search_result = filterTable($query);
}

function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "prichody");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}

?>

<!DOCTYPE html>
<html>
    <head>
    	<meta http-equiv="content-type" content="text/html;charset=utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Záznamy</title>
    	<link rel = "icon" href = "FSI_icon.png"type = "image/x-icon">
    	<link rel="stylesheet" type="text/css" href="style.css">
    	<style>
    	.button1{
			width: 10%;
        }
        .pridat:link, .pridat:visited {
                color: black;
                text-decoration: none;
                }   

        .pridat:hover {
            color: chartreuse;
        }
        </style>
    </head>
    <body>
        <button class="button button1" onclick="window.location.href='main.html';">Zpět</button>        
		<form action="prichody.php" method="post">
        	<!--<input type="submit" name="search" value="Zrušit filtr">-->
        	<div style="text-align:right;">
        	<input type="text" name="valueToSearch" placeholder="Filtrovat...">
        	<input type="submit" name="search" value="Hledej">
            </div>
            <table>
                <tr class="header">
                    <th style="width:10%;">Přístup</th>
                    <th style="width:10%;">Číslo</th>
                    <th style="width:5%;">Dveře</th>
                    <th style="width:15%;">Jméno</th>
                    <th style="width:15%;">Příjmení</th>
                    <th style="width:15%;">Rfid</th>
                    <th style="width:15%;">Čas</th>
                    <th style="width:15%;"></th>
                </tr>

                <?php while($row = mysqli_fetch_array($search_result)):?>
                <tr>
                    <td><?php 
                    if($row["pristup"] <= "0"){
			 			$row_pristup = "zamítnut";
					}
					else{
		 			$row_pristup = "povolen";
					}
					echo "$row_pristup";
					?></td>
                    <td><?php echo $row['cislo'];?></td>
                    <td><?php echo $row['dvere'];?></td>
                    <td ><?php echo $row['jmeno'];?></td>
                    <td><?php echo $row['prijmeni'];?></td>
                    <td><?php echo $row['rfid'];?></td>
                    <td><?php echo $row['reading_time'];?></td>
                    <td>
                        <?php if ($row["pristup"] == "0" && $row['jmeno'] != "ALARM") {
                        ?><a href="pridat_uzivatele.php?rfid=<?=$row['rfid'];?>" class=pridat>Přidat uživatele</a> <?php } ?>
                        </td>
                </tr>
                <?php endwhile;?>
            </table>
        </form>
        
    </body>
</html>
<?php

//tento skript slouží k automatickému vytváření databází


//definice databáze
$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";

		//připojení k serveru
       $conn = new mysqli($servername, $username, $password);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
		} 
		
		//ověření jestli databáze existuje
		if (!mysqli_select_db($conn,$dbname)){
			//tvorba databáze a tabulek
			$sql = "CREATE DATABASE ".$dbname;
			if ($conn->query($sql) === TRUE) {
				echo "";
				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql1 = "CREATE TABLE `uzivatele` (
                     `id` INT(6) NOT NULL AUTO_INCREMENT , 
                     `cislo` INT(30) NOT NULL , 
                     `jmeno` VARCHAR(30) NOT NULL , 
                     `prijmeni` VARCHAR(30) NOT NULL , 
                     `nazev karty` VARCHAR(30) , 
                     `rfid` INT(30) NOT NULL , 
                     PRIMARY KEY (`id`)) ENGINE = InnoDB;
					 CREATE TABLE `zaznamy` ( 
						 `id` INT(6) NOT NULL AUTO_INCREMENT , 
						 `pristup` TINYINT(1) NULL DEFAULT NULL , 
						 `dvere` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
						 `cislo` INT(30) NOT NULL , 
						 `jmeno` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
						 `prijmeni` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL , 
                         `rfid` INT(34) NOT NULL , 
						 `reading_time` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
						 PRIMARY KEY (`id`)) ENGINE = InnoDB;";
  					if($conn->multi_query($sql1) === TRUE) {
					echo "";
					}
			}
			else {
				echo "Error creating database: " . $conn->error;
			}
		}
$conn->close();
?>

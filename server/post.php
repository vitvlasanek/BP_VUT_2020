<?php
//skript pro vytvoření záznamu v databázi
include "create_dtb.php";

$servername = "localhost";
$dbname = "prichody";
$username = "root";
$password = "";
$api_key_value = "44ff56";

$api_key= "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $rfid = test_input($_POST["rfid"]);
		$dvere = test_input($_POST["door"]);   
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

		$sql = "SELECT cislo, jmeno, prijmeni FROM uzivatele WHERE rfid ='$rfid'";
		$result = $conn->query($sql);

			if ($result->num_rows > 0) {
  				while($row = $result->fetch_assoc()) {
  					$cislo = $row["cislo"];
    				$jmeno = $row["jmeno"];
    				$prijmeni = $row["prijmeni"];
    				$pristup = "1";	
   		 		}
			} 
			elseif ($rfid == ALARM){
  				echo "Alarm";
  				$cislo = "ALARM";
  				$jmeno = "ALARM";
   		 		$prijmeni = "ALARM";
   		 		$pristup = "0";
			}

			else {
  				echo "0 results";
  				$cislo = "nezname";
  				$jmeno = "nezname";
   		 		$prijmeni = "nezname";
   		 		$pristup = "0";
			}
   		     $sql = "INSERT INTO zaznamy (pristup, cislo, dvere, jmeno, prijmeni, rfid)
   		     VALUES ('" . $pristup . "','" . $cislo . "','" . $dvere . "','" . $jmeno . "', '" . $prijmeni . "', '" . $rfid . "')";
   		     if ($conn->query($sql) === TRUE) {
   	         echo "New record created successfully";
   		     } 
   		     else {
   		         echo "Error: " . $sql . "<br>" . $conn->error;
   		     }
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }
}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
   	$data = htmlspecialchars($data);
  	return $data;
}       
?>
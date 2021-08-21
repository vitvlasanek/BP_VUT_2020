<html>
<!-- stránka pro přidávání nových uživatelů -->
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel = "icon" href = "FSI_icon.png"type = "image/x-icon">
<title>Přidat uživatele</title>
<style>
.button{
width: 15%;
padding:16px 0px;
}
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 500%;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
    left: -200%;
  z-index: 1;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
</head>
<body>
<button class="button button1" onclick="window.location.href='uzivatele.php?sort=';">Zpět</button><br><br><br>
<form action="e.php" method="post">
<div style="text-align:center;">
<label for="cislo">Číslo:</label><br>
<input type="number" name="cislo"placeholder="Číslo" autocomplete="off"><br><br>
<label for="jmeno">Jméno:</label><br>
<input type="text" minlength="2" name="jmeno" placeholder="Jméno" required autocomplete="off"><br><br>
<label for="prijmeni">Příjmení:</label><br>
<input type="text" minlength="2" name="prijmeni" placeholder="Příjmení" required autocomplete="off"><br><br>
<label for="nazev_karty">Typ karty:</label><br>
<input type="text" name="nazev_karty" placeholder="Název karty" autocomplete="off"><br><br>
<label for="rfid">RFID:</label><br>
<input type="number" name="rfid"  min="100000000" max="99999999999" placeholder="RFID" value=<?= $_GET['rfid']; ?> required autocomplete="off"><br><br>
<div class="tooltip">Neznám RFID<span class="tooltiptext">Přiložte ke čtečce kartu, kterou chcete novému uživateli přiřadit a pak použijte tlačítko <b>Přidat uživatele</b> v sekci <b>Příchody</b>.</span>
</div><br><br><br><br>
<input type="submit" value="Uložit uživatele">
</div>
</form>
</body>
</html>
<?php
function getDb() {
	$link = mysqli_connect("localhost", "root", "")
			or die("Kapcsolodasi hiba" . mysqli_error());
	mysqli_select_db($link, "nagyhazi");
    mysqli_query($link, "SET names 'utf8'");//beállítjuk a karakterkódolást
	mysqli_query($link, "SET charset 'utf8'");
	return $link;
}
?>
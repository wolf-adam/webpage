<!-- Ez lesz amivel majd a helyeket törlöm -->
<?php
	include 'db.php';
	$link = getDb();
	$id=$_GET['id'];
	$query = "DELETE FROM ertekeles WHERE hamburgerid in (SELECT id FROM hamburger WHERE hamburgerezoid =" . mysqli_real_escape_string($link, $id).")";
	mysqli_query($link, $query);
	$query1 = "DELETE FROM hamburger WHERE hamburgerezoid= " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query1);
	$query2 = "DELETE FROM hamburgerezocim WHERE hamburgerezoid = " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query2);
	$query3 = "DELETE FROM hamburgerezo WHERE id = " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query3);
	mysqli_close($link);
	
	//echo $query;
	//echo $query1;
	//echo $query2;
	//echo $query3;
	
	header("Location: burgerezo.php");
?>
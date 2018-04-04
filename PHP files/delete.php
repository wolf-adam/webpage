<?php
	include 'db.php';
	$link = getDb();
	$id=$_GET['id'];
	$query = "DELETE FROM velemeny WHERE hamburgerid = " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query);
	$query = "DELETE FROM ertekeles WHERE hamburgerid = " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query);
	$query1 = "DELETE FROM hamburger WHERE id = " . mysqli_real_escape_string($link, $id);
	mysqli_query($link, $query1);
	mysqli_close($link);
	header("Location: hambi.php");
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
		<title>Wolf Burger</title>
		<link href="design3.css" rel="stylesheet" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Inline" rel="stylesheet">
		<link rel="shortcut icon" href="burger_w.png"/>
        <meta charset="ansi"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
        
            <div class="fejlec">
				<a href="index.php"/><img class="logo" src="burger_w.png"/></a>
				<ul class="wolf_nav">
					<li><a href="index.php">Wolf Burger</a></li>
				</ul>	
                <ul class="navigation">
					<li><a href="index.php">Főoldal</a></li>
					<li><a href="hambi.php">Hamburgerek</a></li>
					<li><a href="burgerezo.php" id="onpage">Burgerezők</a></li>
					<li><a href="search.php">Keresés</a></li>
					<li><a href="#" id="notnow">Vélemény</a></li>
				</ul>
            </div>
			
			<!--Hamburgerezők--->
			<!-- Új hely felvétele-->
			<div class="insert_element">
				<p>
                   <a class ="new_item" href="insert_b.php">Új Hely megadása:</a>
				</p>
			
                <?php
                    $link = mysqli_connect("localhost", "root", "")
                    or die("Kapcsolodasi hiba " . mysqli_error());
                    mysqli_select_db($link, "nagyhazi");
                    mysqli_query($link, "set character_set_results='utf8'");
                    $eredmeny = mysqli_query($link, "SELECT id, nyitas, uzletnev, arkategoria, ertekeles, iranyitoszam, kerulet, varos, utcaplushazszam FROM hamburgerezo LEFT OUTER JOIN hamburgerezocim ON hamburgerezo.id=hamburgerezocim.hamburgerezoid;"); //kép
                    echo mysqli_error($link);
                ?>
				<div class="insert_table_b">
					<table>
						<tr>
							<th>Nyitás</th>
							<th>Üzletnév</th>
							<th>Árkategória</th>
							<th>Értékelés</th>
							<th>Irányítószám</th>
							<th>Kerület</th>
							<th>Város</th>
							<th>Cím</th>
							<th>Törlés</th>
							<th>Módosítás</th>
						</tr> 
						<?php while($row = mysqli_fetch_array($eredmeny)): ?>
						<tr>
							<td> <?=$row['nyitas'] ?> </td>
							<td class="shop"> <?=$row['uzletnev'] ?> </td>
							<td> <?=$row['arkategoria'] ?> </td>
							<td class="shop"> <?=$row['ertekeles'] ?> </td>
							<td> <?=$row['iranyitoszam'] ?> </td>
							<td> <?=$row['kerulet'] ?> </td>
							<td> <?=$row['varos'] ?> </td>
							<td> <?=$row['utcaplushazszam'] ?> </td>
							<td><a href="delete_b.php?id=<?=$row['id'] ?>"><img class="bin_icon" src="kuka.png"/></a></td>
							<td><a href="modify_burgerezo.php?id=<?=$row['id'] ?>"><img class="pen_icon" src="pen.png"/></a></td>
						</tr>
						<?php endwhile; ?>

					</table>
					<br/>
					<?php
						mysqli_close($link);
					?>
				</div>
            </div>
			
            <div class="lablec">
                <p>2017 &copy Made by <i>Adam Wolf</i> <br> (A59CR0) with ♥</p>
            </div>
        
	</body>
</html>
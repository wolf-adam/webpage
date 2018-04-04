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
					<li><a href="hambi.php" id="onpage">Hamburgerek</a></li>
					<li><a href="burgerezo.php">Burgerezők</a></li>
					<li><a href="search.php">Keresés</a></li>
					<li><a href="#" id="notnow">Vélemény</a></li>
				</ul>
            </div>
			
            <!-- megjelenítésért és beszúrásért felelős -->
			<div class="insert_element">	
				<p>
                   <a class ="new_item" href="insert.php">Új Hamburger megadás:</a>
				</p>
			
                <?php
                    $link = mysqli_connect("localhost", "root", "")
                    or die("Kapcsolodasi hiba " . mysqli_error());
                    mysqli_select_db($link, "nagyhazi");
                    mysqli_query($link, "set character_set_results='utf8'");
                    $eredmeny = mysqli_query($link, "	SELECT h.id, o.uzletnev, h.kep, cast(e.szumma/e.db AS decimal(3,1)) AS avg, h.fantazianev, h.ara, h.osszetevok 
														FROM hamburger h
														LEFT OUTER JOIN ertekeles e ON h.id=e.hamburgerid
														LEFT OUTER JOIN hamburgerezo o ON h.hamburgerezoid = o.id;"); 
                    echo mysqli_error($link);
                ?>
                <table class="insert_table">
                    <tr>
						<th>Hamburger</th>
                        <th>Fantázianév</th>
						<th>Értékelése</th>
                        <th>Ára</th>
						<th>Üzletnév</th>
						<th>Összetevők</th>
                        <th>Törlés</th>
						<th>Módosítás</th>
                    </tr> 
                    <?php while($row = mysqli_fetch_array($eredmeny)): ?>
                    <tr>
                        <td><img id="pic" src="feltoltes/<?=$row['kep'] ?>" ></td>
                        <td> <?=$row['fantazianev'] ?> </td>
                        <td> <?=$row['avg'] ?> </td>
						<td> <?=$row['ara'] ?> </td>
						<td class="shop"> <?=$row['uzletnev'] ?> </td>
                        <td class="osszetevok_row"> <?=$row['osszetevok'] ?> </td>
                        <td><a href="delete.php?id=<?=$row['id'] ?>"><img class="bin_icon" src="kuka.png"/></a></td>
						<td><a href="modify_hambi.php?id=<?=$row['id'] ?>"><img class="pen_icon" src="pen.png"/></a></td>
                    </tr>
                    <?php endwhile; ?>

                </table>
				<br/>
                <?php
                    mysqli_close($link);
                ?>
            </div>
            
            <div class="lablec">
                <p>2017 &copy Made by <i>Adam Wolf</i> <br> (A59CR0) with ♥</p>
            </div>
        
	</body>
</html>
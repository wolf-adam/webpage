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
				<li><a href="burgerezo.php">Burgerezők</a></li>
				<li><a href="search.php" id="onpage">Keresés</a></li>
				<li><a href="#" id="notnow">Vélemény</a></li>
			</ul>
        </div>
			
		<div>
			<!-- megjelenítésért és beszúrásért felelős -->
			<div class="insert_element">	
				<h1 class="new_item2">Allergén összetevő keresése:</h1>
				<p><span class="err1">* kötelező kitölteni / választani</span></p>
				<br/>
				<form class="form" action="search.php" method="post">
						<label>Allergén összetevő #1:</label>
						<input id="alle_12" type="text" placeholder="bacon" name="alle_1" />
						<span class="error">*</span>
							<br>
						<label>Allergén összetevő #2:</label>
						<input id="alle_22" type="text" placeholder="mozzarella / sajt" name="alle_2" />
							<br>
						<label>Allergén összetevő #3:</label>
						<input id="alle_32" type="text" placeholder="paradicsom" name="alle_3" />
							<br>
						<input class="submit_btn" type="submit" value="Elküld" name="uj5" />
						<input class="reset_btn" type="reset" value="Visszaállítás"/>
					</form>
			</div>
				
			<div>
				<?php
				//spec karakterektől megszabadulás:
				$egy='';
				$ketto='';
				$harom='';
				$okes=0;
				$hiba=0;			
				$link = mysqli_connect("localhost", "root", "")
                or die("Kapcsolodasi hiba " . mysqli_error());
				
				function test_input($data) {
					//$data = mysqli_real_escape_string($link, $data);
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data, ENT_QUOTES);
					$data = utf8_decode($data);
					return $data;
				}
				
				if(isset($_POST['uj5'])) {
					$egy = test_input($_POST['alle_1']);
					$ketto= test_input($_POST['alle_2']);
					$harom= test_input($_POST['alle_3']);
					$okes=1;
				}
				
				
				//NULL csekk
				if ($ketto==NULL)  $ketto='?';
				if ($harom==NULL)  $harom='?';
				
				//hibakezelés
				
				if (!preg_match('/^[a-zA-Z�?]/',$egy) || $egy==NULL) {
						echo "<p style = 'color: red; '>Első mező kitöltése kötelező és / vagy csak betűt tartalmazhat!</p>";
						$hiba=1;
				}
					
				if (!preg_match('/^[a-zA-Z�?]/',$ketto)) {
						echo "<p style = 'color: red; '>Második mező csak betűt tartalmazhat!</p>";
						$hiba=1;
				}
					
				if (!preg_match('/^[a-zA-Z�?]/',$harom)) {
						echo "<p style = 'color: red; '>Harmadik mező csak betűt tartalmazhat!</p>";
						$hiba=1;
				}
				
				//$egyke= '%'.$egy.'%';
				//$kettoke= '%'.$ketto.'%';
				//$haromka= '%'.$harom.'%';
                mysqli_select_db($link, "nagyhazi");
				mysqli_query($link, "set character_set_results='utf8'");
				$szures ="	SELECT h.id, o.uzletnev, h.kep, cast(e.szumma/e.db AS decimal(3,1)) AS avg, h.fantazianev, h.ara, h.osszetevok 
															FROM hamburger h
															LEFT OUTER JOIN ertekeles e ON h.id=e.hamburgerid
															LEFT OUTER JOIN hamburgerezo o ON h.hamburgerezoid = o.id
															WHERE h.osszetevok NOT LIKE '%$egy%'
																			AND h.osszetevok NOT LIKE '%$ketto%'
																			AND h.osszetevok NOT LIKE '%$harom%'"; 
			
				$eredmeny = mysqli_query ($link,$szures);
				echo mysqli_error($link);
				
				if($okes==0 && $hiba==0): ?>
					<br>
					<br>
					<table class="insert_table">
						<tr>
							<th>Hamburger</th>
							<th>Fantázianév</th>
							<th>Értékelése</th>
							<th>Ára</th>
							<th>Üzletnév</th>
							<th>Összetevők</th>
							
						</tr> 
						<?php while($row = mysqli_fetch_array($eredmeny)): ?>
						<tr>
							<td><img id="pic" src="feltoltes/<?=$row['kep'] ?>" ></td>
							<td> <?=$row['fantazianev'] ?> </td>
							<td> <?=$row['avg'] ?> </td>
							<td> <?=$row['ara'] ?> </td>
							<td class="shop"> <?=$row['uzletnev'] ?> </td>
							<td class="osszetevok_row"> <?=$row['osszetevok'] ?> </td>
						</tr>
						<?php endwhile; ?>
					</table>
					
				<?php endif; ?>
				
				<?php mysqli_close($link);?>
			</div>	
		</div>
			
        <div class="lablec">
            <p>2017 &copy Made by <i>Adam Wolf</i> <br> (A59CR0) with ♥</p>
        </div>
        
	</body>
</html>
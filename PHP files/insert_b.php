<!DOCTYPE html>
<html>
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
			
	
			<div class="new_burger">	
				<h1 class="new_item2">Új Hely hozzáadása:</h1>
				<p><span class="err1">* kötelező kitölteni</span></p>
				<br/>
				<div class="form">	
					<form action="insert_b.php" method="post">
						<label for="uzletnev2">Üzletnév:</label>
						<input id="uzletnev1" type="text" placeholder="Nosztalgia Falatozó" name="uzletnev" />
						<span class="error">*</span>
							<br/>
						<label for="ara2">Árkategória:</label>
						<input id="ara1" type="text" placeholder="$$$$$" name="ara" />
						<span class="error">*</span>
							<br/>
						<label for="datum2">Nyitás Éve:</label>
						<input id="datum1" type="text" placeholder="2010" name="datum" />
						<span class="error">*</span>
							<br/>
						<label for="ertek2">Értékelés:</label>
						<input id="ertek1" type="text" placeholder="8.9" name="ertek" />
						<span class="error">*</span>
							<br/>
						<label for="ir2">Irányítószám:</label>
						<input id="ir1" type="text" placeholder="2484" name="ir" />
						<span class="error">*</span>
							<br/>
						<label for="ker2">Kerület</label>
						<input id="ker1" type="text" placeholder="5" name="ker" />
							<br/>
						<label for="var2">Város:</label>
						<input id="var1" type="text" placeholder="Agárd" name="var" />
						<span class="error">*</span>
							<br/>
						<label for="cim2">Cím:</label>
						<input id="cim1" type="text" placeholder="Petőfi Sándor 2.A" name="cim" />
						<span class="error">*</span>
							<br/>
						<input class="submit_btn"type="submit" value="Elküld" name="uj2" />
						<input class="reset_btn" type="reset" value="Visszaállítás"/>
					</form>
				</div>
			</div>
			
			<div>
				<?php
				//spec karakterektől megszabadulás:
				function test_input($data) {
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data, ENT_QUOTES);
					return $data;
				}
				
				include 'db.php';
				$link = getDb();
				if(isset($_POST['uj2'])) {
					$uzletnev = test_input($_POST['uzletnev']);
					$arkategoria = test_input($_POST['ara']);
					$ev = test_input($_POST['datum']);
					$ertekeles = test_input($_POST['ertek']);
					$ir = test_input($_POST['ir']);
					$ker = test_input($_POST['ker']);
					$var = test_input($_POST['var']);
					$cim = test_input($_POST['cim']);
					$hiba=0;
					
					//Minta illesztés
					//nyitás éve
					if ($uzletnev==NULL) {
						echo "<p style = 'color: red;'>Üzletnév mező kitöltése kötelező!</p>";
						$hiba=1;
					}
					
					//kategória
					if (preg_match('#^[0-9A-Za-zÆØÖÅæøöåÀàÉé\s,;.:?!´`\(\)/-/+]#',$arkategoria) || $arkategoria==NULL) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy az árkategória csak $$$$$ és $ közti lehet!</p>";
						$hiba=1;
					}
					
					//nyitás éve
					if ($ev==NULL || $ev<1800) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy a nyitás éve csak 1800 utáni lehet!</p>";
						$hiba=1;
					}
					
					//értékelés
					if ($ertekeles==NULL || !preg_match('/^[0-9]{1,2}.[0-9]/',$ertekeles) || $ertekeles>10.0) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy az értékelés csak 10.0 és 0.0 közti lehet!</p>";
						$hiba=1;
					}
					
					//Irányítószám
					if (!preg_match('/^[0-9]{4}/',$ir)) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy az irányítószám csak a mintának megfelelő lehet!</p>";
						$hiba=1;
					}
					
					//Kerület
					if (!preg_match('#^[0-9]{1,2}#',$ker) && $ker!=NULL) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy a kerület száma csak 1 - 23-ig lehet!</p>";
						$hiba=1;
					}
					
					//Város
					if ($var==NULL || !preg_match('/^[a-zA-Z]/', $var)) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy a városnév csak betű lehet!</p>";
						$hiba=1;
					}
					
					//Cím
					// a per jelet bele kell rakni h megengedje
					if ($cim==NULL || !preg_match('/[0-9a-zA-z]/', $cim)) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy a címben semmilyen speciális karaktert nem lehet!</p>";
						$hiba=1;
					}
					
					
					//Ha nincs semmi hiba akkor beillesztés
					if(!$hiba){
						//Új elem beszúrásához
						$query = sprintf("INSERT INTO hamburgerezo(uzletnev, arkategoria, nyitas, ertekeles) VALUES ('%s', '%s', '%s', '%s')", mysqli_real_escape_string($link, $uzletnev), mysqli_real_escape_string($link, $arkategoria), mysqli_real_escape_string($link, $ev), mysqli_real_escape_string($link, $ertekeles));
						mysqli_query($link, $query);
						
						
						$nev0 = "SELECT id FROM hamburgerezo where uzletnev like '%$uzletnev%'";
						$nevko1 = mysqli_query($link, $nev0);
						$nev1= mysqli_fetch_assoc($nevko1);
						$nevID2=$nev1['id'];
						
						$query2 = sprintf("	INSERT INTO hamburgerezocim (hamburgerezoid,
													iranyitoszam, kerulet, varos, utcaplushazszam) 
											VALUES ('%s', '%s', '%s', '%s', '%s')", mysqli_real_escape_string($link, $nevID2), mysqli_real_escape_string($link, $ir), mysqli_real_escape_string($link, $ker), mysqli_real_escape_string($link, $var), mysqli_real_escape_string($link, $cim));
						mysqli_query($link, $query2);
						mysqli_close($link);
					
						//echo $nev0;
						//echo ','.$nevID2;
						//echo ','.$query2;
						header("Location: burgerezo.php"); //Helyekhez való visszalépésért felelős
					}
				}
				?>
			
			</div>
            
			<div class="lablec">
               <p>2017 &copy Made by <i>Adam Wolf</i> <br> (A59CR0) with ♥</p>
            </div>
		
    </body>
</html>
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
			
			<div class="new_burger">
				<!-- A legördülő menühöz szükséges-->
				<?php		
					$id=0;
					$id=$_GET['id'];
                    $link = mysqli_connect("localhost", "root", "")
                    or die("Kapcsolodasi hiba " . mysqli_error());
                    mysqli_select_db($link, "nagyhazi");
                    mysqli_query($link, "set character_set_results='utf8'");
                    $eredmeny = mysqli_query($link, "SELECT uzletnev FROM hamburgerezo;"); 
                    echo mysqli_error($link);
                ?>
				<!-- menü vége -->
			
				<div class="new_burger">			
					<h1 class="new_item2">Hely módosítása:</h1>
					<p><span class="err1">* kötelező kitölteni</span></p>
					<br/>
					<div class="form">	
						<form action="modify_burgerezo.php?id=<?=$id?>" method="post">
							<label for="uzletnev2">Üzletnév:</label>
							<input id="uzletnev1" type="text" placeholder="Nosztalgia Falatozó" name="uzletnev3" />
							<span class="error">*</span>
								<br/>
							<label for="ara2">Árkategória:</label>
							<input id="ara1" type="text" placeholder="$$$$$" name="ara3" />
							<span class="error">*</span>
								<br/>
							<label for="datum2">Nyitás Éve:</label>
							<input id="datum1" type="text" placeholder="420" name="datum3" />
							<span class="error">*</span>
								<br/>
							<label for="ertek2">Értékelés:</label>
							<input id="ertek1" type="text" placeholder="6.9" name="ertek3" />
							<span class="error">*</span>
								<br/>
							<label for="ir2">Irányítószám:</label>
							<input id="ir1" type="text" placeholder="2484" name="ir3" />
							<span class="error">*</span>
								<br/>
							<label for="ker2">Kerület</label>
							<input id="ker1" type="text" placeholder="5" name="ker3" />
								<br/>
							<label for="var2">Város:</label>
							<input id="var1" type="text" placeholder="Agárd" name="var3" />
							<span class="error">*</span>
								<br/>
							<label for="cim2">Cím:</label>
							<input id="cim1" type="text" placeholder="Petőfi Sándor 2/A" name="cim3" />
							<span class="error">*</span>
								<br/>
							<input class="submit_btn"type="submit" value="Elküld" name="uj4" />
							<input class="reset_btn" type="reset" value="Visszaállítás"/>
						</form>
						<?php
							mysqli_close($link);
							$id=$_GET['id'];
							$_SESSION['id'] = $id;
						?>
					</div>
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
				if(isset($_POST['uj4'])) {
					$uzletnev2 = test_input($_POST['uzletnev3']);
					$arkategoria2 = test_input($_POST['ara3']);
					$ev2 = test_input($_POST['datum3']);
					$ertekeles2 = test_input($_POST['ertek3']);
					$ir2 = test_input($_POST['ir3']);
					$ker2 = test_input($_POST['ker3']);
					$var2 = test_input($_POST['var3']);
					$cim2 = test_input($_POST['cim3']);
					$hiba=0;
					
					//Minta illesztés
					//nyitás éve
					if ($uzletnev2==NULL) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Üzletnév mező kitöltése kötelező!</p>";
						$hiba=1;
					}
					
					//kategória
					if (preg_match('#^[0-9A-Za-zÆØÖÅæøöåÀàÉé\s,;.:?!´`\(\)/-/+]#',$arkategoria2) || $arkategoria2==NULL) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy az árkategória csak $$$$$ és $ közti lehet!</p>";
						$hiba=1;
					}
					
					//nyitás éve
					if ($ev2==NULL || $ev2<1800) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy a nyitás éve csak 1800 utáni lehet!</p>";
						$hiba=1;
					}
					
					//értékelés
					if ($ertekeles2==NULL || !preg_match('/^[0-9]{1,2}.[0-9]/',$ertekeles2) || $ertekeles2>10.0) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy az értékelés csak 10.0 és 0.0 közti lehet!</p>";
						$hiba=1;
					}
					
					//Irányítószám
					if (!preg_match('/^[0-9]{4}/',$ir2)) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy az irányítószám csak a mintának megfelelő lehet!</p>";
						$hiba=1;
					}
					
					//Kerület
					if (!preg_match('#^[0-9]{1,2}#',$ker2) && $ker2!=NULL) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy a kerület száma csak 1 - 23-ig lehet!</p>";
						$hiba=1;
					}
					
					//Város
					if ($var2==NULL || !preg_match('/^[a-zA-Z]/', $var2)) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy a városnév csak betű lehet!</p>";
						$hiba=1;
					}
					
					//Cím
					// a per jelet bele kell rakni h megengedje
					if ($cim2==NULL || !preg_match('/[0-9a-zA-z]/', $cim2)) {
						echo "<p style = 'color: red; position: relative; top:150px;'>Mező kitöltése kötelező és / vagy a címben semmilyen speciális karaktert nem lehet!</p>";
						$hiba=1;
					}	
					
					//Ha nincs semmi hiba akkor beillesztés
					if(!$hiba){
						//hely módosítása
						$query = sprintf("	UPDATE hamburgerezocim
											SET iranyitoszam = '%s',
												kerulet = '%s',
												varos = '%s',
												utcaplushazszam = '%s'
											WHERE hamburgerezoid='%s'",  mysqli_real_escape_string($link, $ir2), mysqli_real_escape_string($link, $ker2), mysqli_real_escape_string($link, $var2), mysqli_real_escape_string($link, $cim2), mysqli_real_escape_string($link, $id));
						mysqli_query($link, $query);
						
						//cím módosítása
						$query = sprintf("	UPDATE hamburgerezo
											SET uzletnev = '%s',
												arkategoria = '%s',
												nyitas = '%s',
												ertekeles = '%s'
											WHERE id='%s'",  mysqli_real_escape_string($link, $uzletnev2), mysqli_real_escape_string($link, $arkategoria2), mysqli_real_escape_string($link, $ev2), mysqli_real_escape_string($link, $ertekeles2), mysqli_real_escape_string($link, $id));
						mysqli_query($link, $query);
						
						//kapcsolat bontás
						mysqli_close($link);
						//echo $query;
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
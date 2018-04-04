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
					<li><a href="hambi.php" id="onpage">Hamburgerek</a></li>
					<li><a href="burgerezo.php">Burgerezők</a></li>
					<li><a href="search.php">Keresés</a></li>
					<li><a href="#" id="notnow">Vélemény</a></li>
				</ul>
            </div>
			
			<div class="new_burger">
				<!-- A legördülő menühöz szükséges-->
				<?php
                    $link = mysqli_connect("localhost", "root", "")
                    or die("Kapcsolodasi hiba " . mysqli_error());
                    mysqli_select_db($link, "nagyhazi");
                    mysqli_query($link, "set character_set_results='utf8'");
                    $eredmeny = mysqli_query($link, "SELECT uzletnev FROM hamburgerezo;"); 
                    echo mysqli_error($link);
                ?>
				<!-- menü vége -->
			
				<h1 class="new_item2">Új Burger hozzáadása:</h1>
				<p><span class="err1">* kötelező kitölteni / választani</span></p>
				<p><span class="err2">Ha új helyhez tartozó hamburgert szeretnénk megadni,<br>először a burgerezőknél kell a helyet létrehozni!</span></p>
				<br/>
				<div class="form">	
					<form action="insert.php" method="post" enctype="multipart/form-data">
						<label for="f_nev2">Fantázianév:</label>
						<input id="f_nev1" type="text" placeholder="Walking Dead Burger" name="f_nev" />
						<span class="error">*</span>
							<br>
						<label for="ara2">Ára:</label>
						<input id="ara1" type="text" placeholder="1994" name="ara" />
						<span class="error">*</span>
							<br>
						<label for="ara2">Értékelés:</label>
						<input id="ertek1" type="text" placeholder="10.0" name="ertek" />
						<span class="error">*</span>
							<br>
						<label for="osszetevok2">Összetevők:</label>
						<input id="osszetevok1" type="text" placeholder="Szeretet" name="osszetevok" />
						<span class="error">*</span>
							<br>
						<label for="kep2">Kép:</label>
						<input id="kep1" type="file" name="kep" />
							<br>
						<label for="h_nev2" >Burgerező Neve:</label>
						<select name="taskOption">
							<?php while($row = mysqli_fetch_array($eredmeny)): ?>
								<option value="<?=$row['uzletnev'] ?>"> <?=$row['uzletnev'] ?></option>
							<?php endwhile; ?>
						<select/>
						<span class="error">*</span>
							<br>
						<input class="submit_btn" type="submit" value="Elküld" name="uj" />
						<input class="reset_btn" type="reset" value="Visszaállítás"/>
					</form>
					<?php
                    mysqli_close($link);
                ?>
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

				//Új elem beszúrásához
				include 'db.php';
				$link = getDb();
				if(isset($_POST['uj'])) {
					$f_nev = test_input($_POST['f_nev']);
					$ara = test_input($_POST['ara']);
					$osszetevok = test_input($_POST['osszetevok']);
					$kep = $_FILES['kep']['tmp_name'];
					$h1 = test_input($_POST['taskOption']);
					$szumma = test_input($_POST['ertek']);
					$db= 10;
					$hiba=0;
					
					
					
					//kép meg minden 
					$target_dir = "feltoltes/";
					$target_file = $target_dir . basename($_FILES['kep']['name']);
					$uploadOk = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					
					
					
					
					//Minta illesztés
					//Fantázianév
					if ($f_nev==NULL) {
						echo "<p style = 'color: red;'>Fantázianév mező kitöltése kötelező!</p>";
						$hiba=1;
					}
					
					//Ára (csak szám lehet)
					if ($ara==NULL || $ara>10000 || !preg_match('#[0-9]#',$ara)) {
						echo "<p style = 'color: red; '>Ár mező kitöltése kötelező és/ vagy csak szám és maximum 6 számjegyű lehet!</p>";
						$hiba=1;
					}
					
					//Összetevők
					if ($osszetevok==NULL) {
						echo "<p style = 'color: red'>Összetevők mező kitöltése kötelező!</p>";
						$hiba=1;
					}
					
					//Értékelés
					if (!preg_match('/^[0-9]{1,2}.[0-9]/',$szumma) || $szumma>10.0 || $szumma==NULL) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy az értékelés csak 10.0 és 0.0 közti lehet!</p>";
						$hiba=1;
					}
					
					// bizonyos formátumok engedése
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						echo "<p style='color: red;'>Csak a következő fájlok megengedettek: JPG, JPEG, PNG és GIF.";
						$uploadOk = 0;
					}
					
					if($uploadOk == 1 && $hiba == 0){
						//feltölés
						move_uploaded_file($_FILES['kep']['tmp_name'], $target_file);
						
						//burgerező meghatározása
						$hely = "SELECT id FROM hamburgerezo where uzletnev like '%$h1%'";
						$helyko = mysqli_query($link, $hely);
						$hely1= mysqli_fetch_assoc($helyko);
						$helyID=$hely1['id'];
						
						$kep_neve=addslashes($_FILES['kep']['name']);
						$query = sprintf("INSERT INTO hamburger(fantazianev, ara, kep, osszetevok, hamburgerezoid) VALUES ('%s', '%s', '%s', '%s', '%s')", mysqli_real_escape_string($link, $f_nev), mysqli_real_escape_string($link, $ara), mysqli_real_escape_string($link,$kep_neve),mysqli_real_escape_string($link, $osszetevok), mysqli_real_escape_string($link, $helyID) );
						mysqli_query($link, $query);
						
						//hamburger értékelésének beillesztése
						$nev = "SELECT id FROM hamburger where fantazianev like '%$f_nev%'";
						$nevko = mysqli_query($link, $nev);
						$nev1= mysqli_fetch_assoc($nevko);
						$nevID=$nev1['id'];
						$query2 = sprintf("INSERT INTO ertekeles (hamburgerid, szumma, db) VALUES ('%d', '%d', '%d')", mysqli_real_escape_string($link,$nevID), mysqli_real_escape_string($link,$szumma*10), mysqli_real_escape_string($link,$db));
						mysqli_query($link, $query2);
						mysqli_close($link);
						
						
						//echo $h1.' |';
						//echo $hely.' |';
						//echo $helyID.' |';
						//echo $query.' |';
						//echo $query2.' |';
						header("Location: hambi.php"); //Hambikhoz való visszalépésért felelős
						
					}
				}
			?>
			</div>
			
            <div class="lablec">
                <p>2017 &copy Made by <i>Adam Wolf</i> <br> (A59CR0) with ♥</p>
            </div>
		
    </body>
</html>
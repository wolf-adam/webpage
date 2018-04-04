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
			
				<h1 class="new_item2">Burger adatainak módosítása</h1>
				<p><span class="err1">* kötelező kitölteni / választani</span></p>
				<br/>
				<div class="form">	
					<form action="modify_hambi.php?id=<?=$id?>" method="post" enctype="multipart/form-data">
						<label for="f_nev2">Fantázianév:</label>
						<input id="f_nev1" type="text" placeholder="Walking Dead Burger" name="f_nev3" />
						<span class="error">*</span>
							<br>
						<label for="ara2">Ára:</label>
						<input id="ara1" type="text" placeholder="1994" name="ara3" />
						<span class="error">*</span>
							<br>
						<label for="ara2">Értékelés:</label>
						<input id="ertek1" type="text" placeholder="10.0" name="ertek3" />
						<span class="error">*</span>
							<br>
						<label for="osszetevok2">Összetevők:</label>
						<input id="osszetevok1" type="text" placeholder="Szeretet" name="osszetevok3" />
						<span class="error">*</span>
							<br>
						<label for="kep">Kép:</label>
						<input id="kep1" type="file" name="kep3" />
							<br>
						<label for="h_nev2" >Burgerező Neve:</label>
						<select name="taskOption3">
							<?php while($row = mysqli_fetch_array($eredmeny)): ?>
								<option value="<?=$row['uzletnev'] ?>"> <?=$row['uzletnev'] ?></option>
							<?php endwhile; ?>
						<select/>
						<span class="error">*</span>
							<br>
						<input class="submit_btn" type="submit" value="Elküld" name="uj3" />
						<input class="reset_btn" type="reset" value="Visszaállítás"/>
					</form>
					<?php
                    mysqli_close($link);
					$id=$_GET['id'];
					$_SESSION['id'] = $id;
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
				
				if(isset($_POST['uj3'])) {
					$f_nev3 = test_input($_POST['f_nev3']);
					$ara3 = test_input($_POST['ara3']);
					$osszetevok3 = test_input($_POST['osszetevok3']);
					$kep3 = $_FILES['kep3']['tmp_name'];
					$h3 = test_input($_POST['taskOption3']);
					$szumma3 = test_input($_POST['ertek3']);
					$db= 10;
					$hiba3=0;
					
					//kép meg minden 
					$target_dir = "feltoltes/";
					$target_file = $target_dir . basename($_FILES['kep3']['name']);
					$uploadOk3 = 1;
					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					
					
					
					
					//Minta illesztés
					//Fantázianév
					if ($f_nev3==NULL) {
						echo "<p style = 'color: red;'>Fantázianév mező kitöltése kötelező!</p>";
						$hiba3=1;
					}
					
					//Ára (csak szám lehet)
					if ($ara3==NULL || $ara3 > 10000 || !preg_match('#[0-9]#',$ara3)) {
						echo "<p style = 'color: red; '>Ár mező kitöltése kötelező és/ vagy csak szám és maximum 6 számjegyű lehet!</p>";
						$hiba3=1;
					}
					
					//Összetevők
					if ($osszetevok3==NULL) {
						echo "<p style = 'color: red'>Összetevők mező kitöltése kötelező!</p>";
						$hiba3=1;
					}
					
					//Értékelés
					if (!preg_match('/^[0-9]{1,2}.[0-9]/',$szumma3) || $szumma3>10.0 || $szumma3==NULL) {
						echo "<p style = 'color: red;'>Mező kitöltése kötelező és / vagy az értékelés csak 10.0 és 0.0 közti lehet!</p>";
						$hiba3=1;
					}
					
					// bizonyos formátumok engedése
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
						echo "<p style='color: red;'>Csak a következő fájlok megengedettek: JPG, JPEG, PNG és GIF.";
						$uploadOk3 = 0;
					}
					
					if($uploadOk3 == 1 && $hiba3 == 0){
						//feltölés
						move_uploaded_file($_FILES['kep3']['tmp_name'], $target_file);
						
						//burgerező meghatározása
						$hely2 = "SELECT id FROM hamburgerezo where uzletnev like '%$h3%'";
						echo $hely2;
						
						$helyko1 = mysqli_query($link, $hely2);
						$hely3= mysqli_fetch_assoc($helyko1);
						$helyID2=$hely3['id'];
						
						$kep_neve=addslashes($_FILES['kep3']['name']);
						$query = sprintf("	UPDATE hamburger 
											SET fantazianev ='%s',
												ara='%s', 
												kep='%s', 
												osszetevok='%s',
												hamburgerezoid='%s'
											WHERE id = '%s'", mysqli_real_escape_string($link, $f_nev3), mysqli_real_escape_string($link, $ara3), mysqli_real_escape_string($link,$kep_neve),mysqli_real_escape_string($link, $osszetevok3), mysqli_real_escape_string($link, $helyID2), mysqli_real_escape_string($link, $id));
						mysqli_query($link, $query);
						
						//echo $id;
						echo $query;
						
						//hamburger értékelésének beillesztése
						$query2 = sprintf("	UPDATE ertekeles 
											SET szumma = '%s',
												db = '%s'
											WHERE hamburgerid = '%s'", mysqli_real_escape_string($link,($szumma3)*10), mysqli_real_escape_string($link,$db), mysqli_real_escape_string($link, $id));
						mysqli_query($link, $query2);
						mysqli_close($link);
						//echo ' --------------------------------------------------------------------------------------------------------
						//'.PHP_EOL;
						echo $query2;
						
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
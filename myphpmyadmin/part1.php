<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/part1.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<?php
			session_start();
		?>
		<nav>
			<div class="nav-wrapper indigo lighten-3">
				<a href="#!" class="brand-logo">MyPhpMyAdmin</a>
				<ul class="right hide-on-med-and-down">
					<li><a><i class="material-icons left">power</i>Connection</a></li>
					<li><a href="#modal1" class="modal-trigger"><i class="material-icons right">help</i>Help</a></li>
				</ul>
			</div>
		</nav>
		<section id="pan_base">
			<div id="ico_crea">
				<a href='/myphpmyadmin/part1.php?#new_base' id='ico_creation_a'><img id='ico_creation' src='ico/crea.png' alt='Création' title='Création'></a>
			</div>
			<div id="new_base">
				<div id="fen_new_base">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<input type="text" name="name_base" id="inp_new_base" placeholder="Nom base"/>
						<input type="hidden" name="creation_base" value="1" />
						<input type="submit" name="val_new_base" id="val_new_base" value="Création"/>
					</form>
				</div>
			</div>
			<div id="edit_base">
				<div id="fen_new_base">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<input type="text" name="name_base" id="inp_new_base" placeholder="Nouveau nom"/>
						<input type="hidden" name="rename_base" value="1" />
						<?php
							$name_base = 0;
							if (isset($_GET['name_base']))
								$name_base = $_GET['name_base'];
							echo "<input type='hidden' name='ancien_base' value=" . $name_base . " />";
						?>
						<input type="submit" name="val_new_base" id="val_new_base" value="Renommer"/>
					</form>
				</div>
			</div>
			<div id="sup_base">
				<div id="fen_sup_base">
					<h5>Confirmer la suppression :</h5>
					<div id="sup_yes_or_no">
						<?php
							$name_base = 0;
							$conn = 0;
							if (isset($_GET['name_base']))
								$name_base = $_GET['name_base'];
							echo "<a href='/myphpmyadmin/part1.php?sup_base=1&name_base=" . $name_base . "'><img id='ico_sup_base_ex' src='ico/yes.png' alt='Supprimer' title='Supprimer'/></a>";
						?>
						<a href="#noWhere"><img id="ico_sup_base" src="ico/no.png" alt="Revenir" title="Revenir"/></a>
					</div>
				</div>
			</div>
			<div id="l_base">
				<?php
					$name = 0;
					$creation_base = 0;
					$sup_base = 0;
					$rename_base = 0;
					$ancien_name = 0;
					if (isset($_SESSION['host']) && isset($_SESSION['loggin']) && isset($_SESSION['pass']))
						$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], '');
					if (isset($_GET['creation_base']))
						$creation_base = $_GET['creation_base'];
					if (isset($_GET['ancien_base']))
						$ancien_name = $_GET['ancien_base'];
					if (isset($_GET['rename_base']))
						$rename_base = $_GET['rename_base'];
					if (isset($_GET['name_base']))
						$name = $_GET['name_base'];
					if (isset($_GET['sup_base']))
						$sup_base = isset($_GET['sup_base']);
					
					if ($creation_base == 1 && $name != NULL)
					{
						
						if ($conn)
						{
							$sql = "CREATE DATABASE " . $name . ";";
							$conn->query($sql);
						}
					}
					
					if ($sup_base == 1 && $name != NULL)
					{
						if ($conn)
						{
							$sql = "DROP DATABASE " . $name . ";";
							$conn->query($sql);
						}
					}
					
					if ($rename_base == 1 && $name != NULL && $ancien_name != NULL)
					{
						if ($conn)
						{
							$sql = "CREATE DATABASE " . $name . ";";
							$conn->query($sql);
							$sql = "SHOW TABLES FROM " . $ancien_name . ";";
							foreach  ($conn->query($sql) as $row) {
								$sql = "CREATE TABLE " . $name . "." . $row[0] . " AS SELECT * FROM " . $ancien_name . "." . $row[0] . " ;";
								$conn->query($sql);
							}
							$sql = "DROP DATABASE " . $ancien_name . ";";
							$conn->query($sql);
						}
					}
			
					if ($conn)
					{
						$sql =  'SHOW DATABASES;';
						echo "<ul id='ico_ul'>";
						foreach  ($conn->query($sql) as $row) {
							echo "<li id='ico_li'><a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&#sup_base' id='ico'><img src='ico/sup.png' id='ico_img' alt='Supprimer' title='Supprimer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&#edit_base' id='ico'><img src='ico/edit.png' id='ico_img' alt='Editer' title='Editer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&info_base=1' id='ico'><img src='ico/info.png' id='ico_img' alt='Information' title='Information'></a>" . $row[0] . "</li>";
						}
						echo "</ul>";
					}
					else
						echo "erreur connection";
				?>
			</div>
			<div id="div_info_base">
				<?php
					$name = 0;
					$info_base = 0;
					$esp_men = 0;
					if (isset($_SESSION['host']) && isset($_SESSION['loggin']) && isset($_SESSION['pass']))
						$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], '');
					if (isset($_GET['info_base']))
						$info_base = $_GET['info_base'];
					if (isset($_GET['name_base']))
						$name = $_GET['name_base'];
					
					if ($info_base == 1)
					{
						if ($conn)
						{
							$sql1 = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $name . "';";
							$sql2 = "SELECT DISTINCT CREATE_TIME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $name . "'ORDER BY CREATE_TIME ASC;";
							$sql3 = "SELECT DATA_LENGTH FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $name . "';";
							echo "<table id='tab_info_base'>";
							echo "<tbody>
									<tr><td>Nb tables :</td><td>";
							$reponse = $conn->query($sql1);
							foreach  ($conn->query($sql1) as $row) {
								echo $row[0];
							}
							echo "</td></tr><tr><td>Créé le :</td><td>";
							foreach  ($conn->query($sql2) as $row) {
								echo $row[0];
								break;
							}
							echo "</td></tr><tr><td>Esp. mémoire :</td><td>";
							foreach  ($conn->query($sql3) as $row) {
								$esp_men = $esp_men + $row[0];
							}
							echo $esp_men;
							echo "</td></tr></tbody>";
							echo "</table>";
						}
						else
							echo "erreur connexion";
					}
				?>
			</div>
		</section>
		<section id="pan_table">
		</section>
	</body>
</html>
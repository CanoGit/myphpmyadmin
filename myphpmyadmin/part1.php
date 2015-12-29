<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/part1.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
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
				<?php
					$pass = 0;
					$loggin = 0;
					$host = 0;
					if (isset($_GET['name_base']))
						$name_base = $_GET['name_base'];
					if (isset($_GET['loggin']))
						$loggin = $_GET['loggin'];
					if (isset($_GET['pass']))
						$pass = $_GET['pass'];
					if (isset($_GET['host']))
						$host = $_GET['host'];
					echo "<a href='/myphpmyadmin/part1.php?pass=" . $pass . "&loggin=" . $loggin . "&host=" . $host . "&#new_base' id='ico_creation_a'><img id='ico_creation' src='ico/crea.png' alt='Création' title='Création'></a>";
				?>
			</div>
			<div id="new_base">
				<div id="fen_new_base">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<input type="text" name="name_new_base" id="inp_new_base" placeholder="Nom base"/>
						<input type="hidden" name="creation_base" value="1" />
						<?php
							$pass = 0;
							$loggin = 0;
							$host = 0;
							if (isset($_GET['name_base']))
								$name_base = $_GET['name_base'];
							if (isset($_GET['loggin']))
								$loggin = $_GET['loggin'];
							if (isset($_GET['pass']))
								$pass = $_GET['pass'];
							if (isset($_GET['host']))
								$host = $_GET['host'];
							echo "<input type='hidden' name='host' value=" . $host . " />";
							echo "<input type='hidden' name='pass' value=" . $pass . " />";
							echo "<input type='hidden' name='loggin' value=" . $loggin . " />";
						?>
						<input type="submit" name="val_new_base" id="val_new_base" value="Création"/>
					</form>
				</div>
			</div>
			<div id="edit_base">
				<div id="fen_new_base">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<input type="text" name="name_new_nom" id="inp_new_base" placeholder="Nouveau nom"/>
						<input type="hidden" name="rename_base" value="1" />
						<?php
							$pass = 0;
							$loggin = 0;
							$host = 0;
							$name_base = 0;
							if (isset($_GET['name_base']))
								$name_base = $_GET['name_base'];
							if (isset($_GET['loggin']))
								$loggin = $_GET['loggin'];
							if (isset($_GET['pass']))
								$pass = $_GET['pass'];
							if (isset($_GET['host']))
								$host = $_GET['host'];
							echo "<input type='hidden' name='ancien_base' value=" . $name_base . " />";
							echo "<input type='hidden' name='host' value=" . $host . " />";
							echo "<input type='hidden' name='pass' value=" . $pass . " />";
							echo "<input type='hidden' name='loggin' value=" . $loggin . " />";
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
							$name_sup_base = 0;
							$conn = 0;
							if (isset($_GET['name_sup_base']))
								$name_sup_base = $_GET['name_sup_base'];
							echo "<a href='/myphpmyadmin/part1.php?pass=" . $pass . "&loggin=" . $loggin . "&host=" . $host . "&sup_base=1&name_sup_base=" . $name_sup_base . "'><img id='ico_sup_base_ex' src='ico/yes.png' alt='Supprimer' title='Supprimer'/></a>";
						?>
						<a href="#noWhere"><img id="ico_sup_base" src="ico/no.png" alt="Revenir" title="Revenir"/></a>
					</div>
				</div>
			</div>
			<div id="l_base">
				<?php
					$pass = 0;
					$loggin = 0;
					$host = 0;
					$name = 0;
					$creation_base = 0;
					$sup_base = 0;
					$rename_base = 0;
					$ancien_name = 0;
					if (isset($_GET['host']) && isset($_GET['loggin']) && isset($_GET['pass']))
						$conn = new PDO('mysql:host=' . $_GET['host'], $_GET['loggin'], '');
					if (isset($_GET['loggin']))
						$loggin = $_GET['loggin'];
					if (isset($_GET['pass']))
						$pass = $_GET['pass'];
					if (isset($_GET['host']))
						$host = $_GET['host'];
					if (isset($_GET['creation_base']))
						$creation_base = $_GET['creation_base'];
					if (isset($_GET['ancien_base']))
						$ancien_name = $_GET['ancien_base'];
					if (isset($_GET['rename_base']))
						$rename_base = $_GET['rename_base'];
					if (isset($_GET['name_new_base']))
						$name = $_GET['name_new_base'];
					if (isset($_GET['name_new_nom']))
						$name = $_GET['name_new_nom'];
					if (isset($_GET['sup_base']))
						$sup_base = isset($_GET['sup_base']);
					if (isset($_GET['name_sup_base']))
						$name = $_GET['name_sup_base'];
					
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
								$sql = "CREATE TABLE " . $row[0] . ";";
								$conn->query($sql);
								$sql = "INSERT INTO " . $name . "." . $row[0] . " (SELECT * FROM " . $ancien_name . "." . $row[0] . " );";
								$conn->query($sql);
							}
							$conn->query($sql);
							#$sql = "DROP DATABASE " . $name . ";";
						}
					}
			
					if ($conn)
					{
						$sql =  'SHOW DATABASES;';
						echo "<ul id='ico_ul'>";
						foreach  ($conn->query($sql) as $row) {
							echo "<li id='ico_li'><a href='/myphpmyadmin/part1.php?pass=" . $pass . "&loggin=" . $loggin . "&host=" . $host . "&name_sup_base=" . $row[0] . "&#sup_base' id='ico'><img src='ico/sup.png' id='ico_img' alt='Supprimer' title='Supprimer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?pass=" . $pass . "&loggin=" . $loggin . "&host=" . $host . "&name_base=" . $row[0] . "&#edit_base' id='ico'><img src='ico/edit.png' id='ico_img' alt='Editer' title='Editer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?pass=" . $pass . "&loggin=" . $loggin . "&host=" . $host . "&name_base=" . $row[0] . "&infp_base=1' id='ico'><img src='ico/info.png' id='ico_img' alt='Information' title='Information'></a>" . $row[0] . "</li>";
						}
						echo "</ul>";
					}
					else
						echo "erreur connection";
				?>
			</div>
			<div id="div_info_base">
				
			</div>
		</section>
		<section id="pan_table">
		</section>
	</body>
</html>
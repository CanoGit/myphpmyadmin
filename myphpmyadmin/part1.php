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
				<a href="/myphpmyadmin/part1.php?#new_base"><img id="ico_creation" src="ico/crea.png" alt="Création" title="Creéation"></p>
			</div>
			<div id="new_base">
				<div id="fen_new_base">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<fieldset id="field_new_base">
							<p><input type="text" name="name_new_base" id="inp_new_base" placeholder="Nom base"/></p>
							<p><input type="hidden" name="creation_base" value="1" /></p>
						</fieldset>
						<input type="submit" name="val_new_base" id="val_new_base" value="Connection"/>
					</form>
				</div>
			</div>
			<div id="sup_base">
				<div id="fen_sup_base">
					<h4>Confirmer la suppression :</h4>
					<div id="sup_yes_or_no">
						<?php
							$name_sup_base = 0;
							if (isset($_GET['name_sup_base']))
								$name_sup_base = $_GET['name_sup_base'];
							echo "<a href='/myphpmyadmin/part1.php?sup_base=1&name_sup_base=" . $name_sup_base . "'><img id='ico_sup_base_ex' src='ico/yes.png' alt='Supprimer' title='Supprimer'/></a>";
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
					
					if (isset($_GET['creation_base']))
						$creation_base = $_GET['creation_base'];
					if (isset($_GET['name_new_base']))
						$name = $_GET['name_new_base'];
					if (isset($_GET['sup_base']))
						$sup_base = isset($_GET['sup_base']);
					if (isset($_GET['name_sup_base']))
						$name = $_GET['name_sup_base'];
					
					if ($creation_base == 1 && $name != NULL)
					{
						$conn = new PDO('mysql:host=localhost;', 'root', '');
						if ($conn)
						{
							
							$sql = "CREATE DATABASE " . $name . ";";
							$conn->query($sql);
						}
					}
					
					if ($sup_base == 1 && isset($name) != NULL)
					{
						$conn = new PDO('mysql:host=localhost;', 'root', '');
						if ($conn)
						{
							$sql = "DROP DATABASE " . $name . ";";
							$conn->query($sql);
						}
					}
				?>
				<?php
					$conn = new PDO('mysql:host=localhost;', 'root', '');
					if ($conn)
					{
						$sql =  'SHOW DATABASES;';
						echo "<ul>";
						foreach  ($conn->query($sql) as $row) {
							echo "<li><a href='/myphpmyadmin/part1.php?name_sup_base=" . $row[0] . "&#sup_base' id='ico'><img src='ico/sup.png' id='ico_img' alt='Supprimer' title='Supprimer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&edit_base=1' id='ico'><img src='ico/edit.png' id='ico_img' alt='Editer' title='Editer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&infp_base=1' id='ico'><img src='ico/info.png' id='ico_img' alt='Information' title='Information'></a>" . $row[0] . "</li>";
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
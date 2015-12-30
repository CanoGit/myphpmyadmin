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
						$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], $_SESSION['pass']);
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
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&info_base=1' id='ico'><img src='ico/info.png' id='ico_img' alt='Information' title='Information'></a><a href='/myphpmyadmin/part1.php?name_base=" . $row[0] . "&aff_base=1'>" . $row[0] . "</a></li>";
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
						$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], $_SESSION['pass']);
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
			<div id="sup_table">
				<div id="fen_sup_base">
					<h5>Confirmer la suppression :</h5>
					<div id="sup_yes_or_no">
						<?php
							$name = 0;
							$name_table = 0;
							$id = 0;
							$name_id = 0;
							if (isset($_GET['id']))
								$id = $_GET['id'];
							if (isset($_GET['name_table']))
								$name_table = $_GET['name_table'];
							if (isset($_GET['name_pri']))
								$name_id = $_GET['name_pri'];
							if (isset($_GET['name_base']))
								$name = $_GET['name_base'];
							
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $name . "&name_table=" . $name_table . "&id=" . $id . "&name_pri=" . $name_id . "&sup_tab=1&aff_table=1'><img id='ico_sup_base_ex' src='ico/yes.png' alt='Supprimer' title='Supprimer'/></a>";
						?>
						<a href="#noWhere"><img id="ico_sup_base" src="ico/no.png" alt="Revenir" title="Revenir"/></a>
					</div>
				</div>
			</div>
			<?php
				$aff_base = 0;
				$aff_table = 0;
				$pri = 0;
				$name = 0;
				$conn = 0;
				$sup_tab = 0;
				$name_table = 0;
				$id = 0;
				$name_id = 0;
				$edit_row = 0;
				$add_row = 0;
				if (isset($_SESSION['host']) && isset($_SESSION['loggin']) && isset($_SESSION['pass']))
					$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], $_SESSION['pass']);
				if (isset($_GET['aff_base']))
					$aff_base = $_GET['aff_base'];
				if (isset($_GET['aff_table']))
					$aff_table = $_GET['aff_table'];
				if (isset($_GET['name_base']))
					$name = $_GET['name_base'];
				if (isset($_GET['name_table']))
					$name_table = $_GET['name_table'];
				if (isset($_GET['sup_tab']))
					$sup_tab = $_GET['sup_tab'];
				if (isset($_GET['id']))
					$id = $_GET['id'];
				if (isset($_GET['name_pri']))
					$name_id = $_GET['name_pri'];
				if (isset($_GET['edit_row']))
					$edit_row = $_GET['edit_row'];
				if (isset($_GET['add_row']))
					$add_row = $_GET['add_row'];
				
				if ($sup_tab == 1)
				{
					if ($conn)
					{
						$sql = "DELETE FROM " . $name . "." . $name_table ." WHERE ". $name_id . "=" . $id . ";";
						$conn->query($sql);
					}
					else
						echo "erreur connexion";
				}
				
				if ($edit_row == 1)
				{
					$tab_info = array();
					$tab_title = array();
					$i = 0;
					$n_col = '';
					$sql1 = '';
					$sql2 = '';
					$sql = "DESCRIBE " . $name . "." . $name_table . ";";
					foreach  ($conn->query($sql) as $row) {
						$tab_info[$i] = $_GET[$row['Field']];
						$tab_title[$i] = $row['Field'];
						$i++;
					}
					for ($j = 0; $j < $i; $j++)
					{
						if ($j != $i - 1)
							$sql1 = $sql1 . $tab_title[$j] . "="  . "'" . $tab_info[$j] . "',";
						else
							$sql1 = $sql1 . $tab_title[$j] . "=" . "'" . $tab_info[$j] . "'";
					}
					$sql = "UPDATE " . $name . "." .$name_table . " SET " . $sql1 . " WHERE " . $name_id . "=" . $id . ";";
					$conn->query($sql);
				}
				
				if ($add_row == 1)
				{
					$tab_info = array();
					$tab_title = array();
					$i = 0;
					$n_col = '';
					$sql1 = '';
					$sql2 = '';
					$sql = "DESCRIBE " . $name . "." . $name_table . ";";
					foreach  ($conn->query($sql) as $row) {
						if ($row['Key'] != 'PRI')
							$tab_info[$i] = $_GET[$row['Field']];
						else
						{
							$sql = "SELECT MAX(" . $row['Field'] . ") FROM " . $name . "." . $name_table . ";";
							$id_pri = $conn->query($sql);
							$id_pri = $id_pri->fetchAll();
							$tab_info[$i] = $id_pri[0][0] + 1;
						}
						$tab_title[$i] = $row['Field'];
						$i++;
					}
					for ($j = 0; $j < $i; $j++)
					{
						if ($j != $i - 1)
						{
							$sql1 = $sql1 . "'" . $tab_info[$j] . "',";
							$sql2 = $sql2 . $tab_title[$j] . ",";
						}
						else
						{
							$sql1 = $sql1 . "'" . $tab_info[$j] . "'";
							$sql2 = $sql2 . $tab_title[$j];
						}	
					}
					$sql1 = $sql1 . ")";
					$sql2 = $sql2 . ")";
					$sql = "INSERT INTO " . $name . "." .$name_table . " (" . $sql2 . " VALUES (" . $sql1 . ";";
					$conn->query($sql);
				}
				
				if ($aff_base == 1)
				{
					if ($conn)
					{
						$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $name . "';";
						echo "<table>";
						echo "<tbody>";
						foreach  ($conn->query($sql) as $row) {
							echo "<tr><td><a href='/myphpmyadmin/part1.php?name_table=" . $row[0] . "&name_base=" . $name . "&aff_table=1'>" . $row[0] . "</td></tr>";
						}
						echo "</tbody>";
						echo "</table>";
					}
					else
						echo "erreur connexion";
				}
				
				if ($aff_table == 1)
				{
					if ($conn)
					{
						$sql = "SHOW COLUMNS FROM " . $name . "." . $name_table . ";";
						$i = 0;
						echo "<table id='tab_inf_table'>";
						echo "<thead id='thead_inf_table'><tr><th><a href='/myphpmyadmin/part1.php?name_base=" . $name . "&name_table=" . $name_table . "&aff_table=1&#add_row' id='ico_creation_a'><img id='ico_creation' src='ico/crea.png' alt='Création' title='Création'></a></th>";
						foreach  ($conn->query($sql) as $row) {
							$i++;
							echo "<th>" . $row[0] . "</th>";
						}
						echo "</tr></thead>";
						echo "<tbody id='tbody_table'>";
						$sql = "DESCRIBE " . $name . "." . $name_table . ";";
						foreach  ($conn->query($sql) as $row) {
							if(isset($row['Key']) && $row['Key'] == 'PRI'){ 
								$pri= $row['Field']; 
								break; 
							} 
						}
						$sql = "SELECT * FROM " . $name . "." . $name_table . ";";
						foreach  ($conn->query($sql) as $row) {
							echo "<tr id='tr_inf_table'>";
							echo "<td><a href='/myphpmyadmin/part1.php?name_base=" . $name . "&name_table=" . $name_table . "&id=" . $row[$pri] . "&name_pri=" . $pri . "&aff_table=1&#sup_table' id='ico'><img src='ico/sup.png' id='ico_img' alt='Supprimer' title='Supprimer'></a>";
							echo "<a href='/myphpmyadmin/part1.php?name_base=" . $name . "&name_table=" . $name_table . "&id=" . $row[$pri] . "&name_pri=" . $pri . "&aff_table=1&#edit_table' id='ico'><img src='ico/edit.png' id='ico_img' alt='Editer' title='Editer'></a></td>";
							for ($j = 0; $j < $i; $j++)
							{
								echo "<td>";
								if (isset($row[$j]))
									echo $row[$j];
								echo "</td>";
							}
							echo "</tr>";
						}
						echo "</tbody><tfoot></tfoot>";
						echo "</table>";
					}
					else
						echo "erreur connexion";
				}
			?>
			<div id="add_row">
				<div id="fen_edit_table">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<?php
							$name = 0;
							$name_table = 0;
							$id = 0;
							$name_id = 0;
							$i = 0;
							if (isset($_SESSION['host']) && isset($_SESSION['loggin']) && isset($_SESSION['pass']))
								$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], $_SESSION['pass']);
							if (isset($_GET['id']))
								$id = $_GET['id'];
							if (isset($_GET['name_table']))
								$name_table = $_GET['name_table'];
							if (isset($_GET['name_pri']))
								$name_id = $_GET['name_pri'];
							if (isset($_GET['name_base']))
								$name = $_GET['name_base'];
							
							$sql = "DESCRIBE " . $name . "." . $name_table . ";";
							foreach  ($conn->query($sql) as $row) {
								if ($row['Key'] != 'PRI')
								{
									if ($row['Type'] == "datetime" && $row['Type'] == "date")
										echo "<input type='date' name=" . $row['Field'] . " id=" . $row['Field'] . " placeholder=" . $row['Field'] . " />";
									else
									{
										$nb_1 = explode(')',$row['Type']);
										$nb = explode('(', $nb_1[0]);
										if ($nb[0] == "char")
											echo "<input type='text' name=" . $row['Field'] . " id=" . $row['Field'] . " maxlength=" . $nb[1] . " placeholder=" . $row['Field'] . " />";
										if ($nb[0] == "int")
											echo "<input type='number' name=" . $row['Field'] . " id=" . $row['Field'] . " placeholder=" . $row['Field'] . " />";
									}
									$i++;
								}
							}
							echo "<input type='hidden' name='name_table' value=" . $name_table . " />";
							echo "<input type='hidden' name='name_pri' value=" . $name_id . " />";
							echo "<input type='hidden' name='name_base' value=" . $name_base . " />";
							echo "<input type='hidden' name='id' value=" . $id . " />";
							echo "<input type='hidden' name='aff_table' value='1' />";
							echo "<input type='hidden' name='add_row' value='1' />";
						?>
						<input type="submit" name="val_new_base" id="val_new_base" value="Ajouter"/>
					</form>
				</div>
			</div>
			<div id="edit_table">
				<div id="fen_edit_table">
					<a href="#noWhere" id="fermer_new_base">X</a>
					<form id="new_base_form" action="part1.php" method="GET">
						<?php
							$name = 0;
							$name_table = 0;
							$id = 0;
							$name_id = 0;
							$i = 0;
							if (isset($_SESSION['host']) && isset($_SESSION['loggin']) && isset($_SESSION['pass']))
								$conn = new PDO('mysql:host=' . $_SESSION['host'], $_SESSION['loggin'], $_SESSION['pass']);
							if (isset($_GET['id']))
								$id = $_GET['id'];
							if (isset($_GET['name_table']))
								$name_table = $_GET['name_table'];
							if (isset($_GET['name_pri']))
								$name_id = $_GET['name_pri'];
							if (isset($_GET['name_base']))
								$name = $_GET['name_base'];
							
							$sql = "SELECT * FROM " . $name . "." . $name_table . " WHERE " . $name_id . "=" . $id . ";";
							$value = $conn->query($sql);
							$value = $value->fetchAll();
							$sql = "DESCRIBE " . $name . "." . $name_table . ";";
							foreach  ($conn->query($sql) as $row) {
								if ($row['Key'] != 'PRI')
								{
									if ($row['Type'] == "datetime" && $row['Type'] == "date")
										echo "<input type='date' name=" . $row['Field'] . " id=" . $row['Field'] . " value=" . $value[0][$i] . " />";
									else
									{
										$nb_1 = explode(')',$row['Type']);
										$nb = explode('(', $nb_1[0]);
										if ($nb[0] == "char")
											echo "<input type='text' name=" . $row['Field'] . " id=" . $row['Field'] . " maxlength=" . $nb[1] . " value=" . $value[0][$i] . " />";
										if ($nb[0] == "int")
											echo "<input type='number' name=" . $row['Field'] . " id=" . $row['Field'] . " value=" . $value[0][$i] . " />";
									}
									
								}
								$i++;
							}
							echo "<input type='hidden' name='name_table' value=" . $name_table . " />";
							echo "<input type='hidden' name='name_pri' value=" . $name_id . " />";
							echo "<input type='hidden' name='name_base' value=" . $name_base . " />";
							echo "<input type='hidden' name='id' value=" . $id . " />";
							echo "<input type='hidden' name='aff_table' value='1' />";
							echo "<input type='hidden' name='edit_row' value='1' />";
						?>
						<input type="submit" name="val_new_base" id="val_new_base" value="Ajouter"/>
					</form>
				</div>
			</div>
		</section>
	</body>
</html>
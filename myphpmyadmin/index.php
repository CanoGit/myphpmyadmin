<!DOCTYPE html>
<html>
	<head>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<?php 
			$conn = 0;
			if (isset($_POST['host']) && isset($_POST['loggin']) && isset($_POST['pass']))
			{
				try
				{
					$conn = new PDO('mysql:host=' . $_POST['host'], $_POST['loggin'], '');
				}
				catch (PDOException $e)
				{
					$error = $e->getmessage();
				}
			}
			if ($conn != 0)
			{
				session_start();
				$_SESSION['host'] = $_POST['host'];
				$_SESSION['loggin'] = $_POST['loggin'];
				$_SESSION['pass'] = $_POST['pass'];
				header('Location: part1.php');
				exit();
			}
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
		<div class="row">
			<div class="col s8 offset-s2">
				<div class="section">
					<h5>Bienvenue</h5>
					<p>
						<div class="row">
							<form class="col s12" action="index.php" method="post">
								<div class="row">
									<div class="input-field col s12">
										<input id="host" name="host" type="text" class="validate">
										<label for="host">HostName</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s6">
										<input id="loggin" name="loggin" type="text" class="validate">
										<label for="loggin">Loggin</label>
									</div>
									<div class="input-field col s6">
										<input id="pass" type="password" name="pass" class="validate">
										<label for="pass">Password</label>
									</div>
								</div>
								<div class="row">
									<button disabled id="connect" class="btn waves-effect waves-light indigo lighten-3" type="submit" name="connexion" value="Log in">Connection
										<i class="material-icons right">power</i>
									</button>
								</div>
							</form>
						</div>
					</p>
				</div>
			</div>
		</div>
		<div id="modal1" class="modal">
			<div class="modal-content">
				<h4>Help</h4>
				<p>Remplissez les différants champs pour vous connecter sur le serveur de bases de données</p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Fermer</a>
			</div>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="script-index.js"></script>
	</body>
</html>
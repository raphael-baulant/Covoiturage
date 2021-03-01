<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<?php
	$title = "Bienvenue sur le site de covoiturage de l'IUT.";?>
	<title>
		<?php echo $title ?>
	</title>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>
<body>
	<div id="header">	
		<div id="entete">
			<div class="colonne">
				<a href="index.php?page=0">
					<img src="image/logo.png" alt="Logo covoiturage IUT" title="Logo covoiturage IUT Limousin" />
				</a>
			</div>
			<div class="colonne">
				Covoiturage de l'IUT,<br />Partagez plus que votre véhicule !!!
			</div>
		</div>
		<div id="connect">
			<?php
			if (empty($_SESSION["per_login"])) {
			?>
				<a href="index.php?page=13">Connexion</a>
			<?php
			} else {
				?>
				<table class="nobordered">
					<tr>
						<td class="nonBorder">Utilisateur : <b><?php echo $_SESSION["per_login"]; ?></b></td>
						<td class="nonBorder"><a href="index.php?page=14">Déconnexion</a></td>
					</tr>
				</table>
				<?php
			}
			?>
		</div>
	</div>
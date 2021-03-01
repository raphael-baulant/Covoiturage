<?php
if (!empty($_SESSION["per_login"])) {
?>
	<h1>Rechercher un trajet</h1>
	<?php
	if ((empty($_POST["vil_num_depart"]) || $_POST["vil_num_depart"]=="0") && empty($_POST["vil_num_arrivee"]) && empty($_GET["per_num"])) {
		$listeVillesDepart = $managerPropose->getVillesRechercheDepart();
	?>
		<form method="post" action="#">
			<table class="nobordered">
				<tr>
					<td class="nonBorder espaceDansFormulaire"><label>Ville de départ :</label></td>
				</tr>
				<tr>
					<td class="nonBorder espaceDansFormulaire">
						<select size="1" name="vil_num_depart">
							<option value="0">Choisissez</option>
							<?php
							foreach ($listeVillesDepart as $ville) {
							?>
								<option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="nonBorder espaceDansFormulaire"><input type="submit" class="buttonValider" value="Valider"></td>
				</tr>
			</table>
		</form>
	<?php
	} else {
		if(empty($_POST["vil_num_arrivee"]) && empty($_GET["per_num"])) {
			$listeVillesArrivee = $managerPropose->getVillesRechercheArrivee($_POST["vil_num_depart"]);
		?>
			<form method="post" action="#">
				<table class="nobordered">
					<tr>
						<td class="nonBorder espaceDansFormulaire gauche"><label>Ville de départ : <?php echo $managerVille->getVilNom($_POST["vil_num_depart"]); ?></label></td>
						<td class="nonBorder espaceDansFormulaire gauche"><label>Ville d'arrivée :</label>
							<select size="1" name="vil_num_arrivee">
								<?php
								foreach ($listeVillesArrivee as $ville) {
								?>
									<option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="nonBorder espaceDansFormulaire gauche"><label>Date de départ : </label><input type="date" name="pro_date" value="<?php echo date('Y-m-d');?>" required></td>
						<td class="nonBorder espaceDansFormulaire gauche"><label>Précision :</label>
							<select size="1" name="precision">
								<option value="0">Ce jour</option>
								<option value="1">+/- 1 jour</option>
								<option value="2">+/- 2 jours</option>
								<option value="3">+/- 3 jours</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="nonBorder espaceDansFormulaire gauche"><label>A partir de: </label>
							<select size="1" name="pro_time">
								<?php
								for ($x=0;$x<24;$x++) {
								?>
									<option value="<?php echo $x; ?>"><?php echo $x; ?>h</option>
								<?php
								}
								?>
							</select></td>
						<td class="nonBorder espaceDansFormulaire"></td>
					</tr>
				</table>
				<input type="submit" class="buttonValider" value="Valider">
				<input type="hidden" name="vil_num_depart" value="<?php echo $_POST['vil_num_depart']; ?>">		
			</form>		
		<?php
		} else {
			if (empty($_GET["per_num"])) {
				$listeTrajets = $managerPropose->rechercherTrajet($_POST["vil_num_depart"], $_POST["vil_num_arrivee"], $_POST["pro_date"], $_POST["precision"], $_POST["pro_time"]);
				$nbTrajets = COUNT($listeTrajets);

				if($nbTrajets > 0) {
					?>	
					<table>
						<tr>
							<th>Ville départ</th>
							<th>Ville arrivée</th>
							<th>Date départ</th>
							<th>Heure départ</th>
							<th>Nombre de place(s)</th>
							<th>Nom du covoitureur</th>
						</tr>

						<?php
						foreach ($listeTrajets as $trajet) {
						?>				
							<tr>
								<td> <?php echo $trajet["vil_nom_depart"]; ?> </td>
								<td> <?php echo $trajet["vil_nom_arrivee"]; ?> </td>
								<td> <?php echo $trajet["pro_date"]; ?> </td>
								<td> <?php echo $trajet["pro_time"]; ?> </td>
								<td> <?php echo $trajet["pro_place"]; ?> </td>
								<?php
								$per_num = $managerPersonne->getPerNum2($trajet['per_nom'], $trajet['per_prenom']);
								?>
								<td class="background"> <a class="nomPersonneSouligne" href="index.php?page=10&per_num=<?php echo $per_num; ?>" title="Moyenne des avis : <?php echo $managerAvis->getMoyenne($per_num)."\n"; ?> Dernier avis : <?php echo $managerAvis->getDernierAvis($per_num); ?>"> <?php echo $trajet["per_prenom"]." ". $trajet["per_nom"]; ?> </a> </td>
							</tr>
						<?php
						}
						?>
					</table>
					<?php
				} else {
				?>
					<p>
						<img src="image/erreur.png"> Désolé, pas de trajet disponible !
					</p>
				<?php
				}
			} else {
				$personne = $managerPersonne->getPersonne($_GET["per_num"]);
				$listeAvis = $managerAvis->getListAvis($_GET["per_num"]);
				$nbAvis = COUNT($listeAvis);

				if($nbAvis > 0) {
					?>
					<h2>Liste des avis pour le conducteur <?php echo $personne->getPerPrenom()." ".$personne->getPerNom(); ?></h2>
					<table>
						<tr>
							<th>Prénom Nom</th>
							<th>Commentaire</th>
							<th>Note</th>
							<th>Date</th>		
						</tr>
						<?php
						foreach ($listeAvis as $avis) {
							$personne = $managerPersonne->getPersonne($avis->getPerNum());
							$prenom = $personne->getPerPrenom();
							$nom = $personne->getPerNom();
							?>
							<tr>
								<td> <?php echo $prenom." ".$nom; ?> </td>
								<td> <?php echo $avis["avi_comm"]; ?> </td>
								<td> <?php echo $avis["avi_note"]; ?> </td>
								<td> <?php echo $avis["avi_date"]; ?> </td>
							</tr>
						<?php
						}
						?>
					</table>
				<?php
				} else {
				?>
					<p>
						<img src="image/erreur.png"> Aucun avis pour cette personne !
					</p>
				<?php
				}
			}
		}
	}
} else {
	header("Location: index.php?page=0");
	exit;
}
?>
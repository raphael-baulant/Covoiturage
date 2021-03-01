<?php
if (!empty($_SESSION["per_login"])) {
?>
	<h1>Ajouter un avis</h1>
	<?php
	$listePersonnes = $managerPersonne->getList();
	$listeParcours = $managerParcours->getList();
	if (empty($_POST["avi_comm"]) || empty($_POST["avi_note"])) {
	?>
		<form method="post" action="#">
			<table class="nobordered">
				<tr>
					<td class="nonBorder espaceDansFormulaire gauche"><label>Nom du covoitureur :</label></td>
					<td class="nonBorder espaceDansFormulaire gauche">
						<select size="1" name="per_per_num">
							<?php
							foreach ($listePersonnes as $personne) {
							?>
								<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getPerNom()." ".$personne->getPerNom(); ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="nonBorder espaceDansFormulaire gauche"><label>Parcours :</label></td>
					<td class="nonBorder espaceDansFormulaire gauche">
						<select size="1" name="par_num">
							<?php
							foreach ($listeParcours as $parcours) {
								$ville1 = $managerVille->getVilNom($parcours->getVilNum1());
								$ville2 = $managerVille->getVilNom($parcours->getVilNum2());
								?>
								<option value="<?php echo $parcours->getParNum(); ?>"><?php echo $ville1." ".$ville2; ?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="nonBorder espaceDansFormulaire gauche"><label>Commentaire :</label></td>
					<td class="nonBorder espaceDansFormulaire gauche"><input type="text" name="avi_comm" required></td>
				</tr>
				<tr>
					<td class="nonBorder espaceDansFormulaire gauche"><label>Note :</label></td>
					<td class="nonBorder espaceDansFormulaire gauche"><input type="number" name="avi_note" min=0 max=5 required></td>
				</tr>
			</table>
			<input type="submit" value="Valider">
		</form>
	<?php
	} else {
		if ($managerAvis->isValide($_SESSION["per_num"], $_POST["per_per_num"], $_POST["par_num"])) {
			$_POST["per_num"] = $_SESSION["per_num"];
			$_POST["avi_date"] = date('Y-m-d H:i:s');
			$avis = new Avis($_POST);
			$managerAvis->add($avis);
			?>
			<p>
				<img src="image/valid.png" alt="Image Validité"> Votre avis a été ajouté
			</p>
		<?php
		} else {
		?>
			<p>
				<img src="image/erreur.png"> Vous avez déjà ajouté un avis pour ce trajet !
			</p>
		<?php
		}
	}
} else {
	header("Location: index.php?page=0");
	exit;
}
?>
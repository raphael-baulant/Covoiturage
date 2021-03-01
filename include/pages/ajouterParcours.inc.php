<h1>Ajouter un parcours</h1>
<?php
$listeVilles = $managerVille->getList();
if (empty($_POST["par_km"]) || $_POST["vil_num1"] == $_POST["vil_num2"]) {
?>
	<form method="post" action="#">
		<table class="nobordered">
			<tr>
				<th><label>Ville 1 :</label></th>
				<th>
					<select size="1" name="vil_num1">
						<?php
						foreach ($listeVilles as $ville) {
						?>
							<option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
						<?php
						}
						?>
					</select>
				</th>
				<th><label>Ville 2 :</label></th>
				<th>
					<select size="1" name="vil_num2">
						<?php
						foreach ($listeVilles as $ville) {
						?>
							<option value="<?php echo $ville->getVilNum(); ?>"><?php echo $ville->getVilNom(); ?></option>
						<?php
						}
						?>
					</select>
				</th>
				<th><label>Nombre de kilomètre(s)</label></th>
				<th><input type="number" name="par_km" min="0" required></th>
			</tr>
		</table>
		<input class="buttonValider" type="submit" value="Valider">
	</form>
<?php
} else {
	if ($managerParcours->isValide($_POST["vil_num1"], $_POST["vil_num2"])) {
		$parcours = new Parcours($_POST);
		$managerParcours->add($parcours);
		?>
		<p>
			<img src="image/valid.png" alt="Img validité"> Le parcours a été ajouté
		</p>
	<?php
	} else {
	?>
		<p>
			<img src="image/erreur.png" alt="Img erreur"> Ce parcours a déjà été ajouté
		</p>
	<?php
	}
}
?>
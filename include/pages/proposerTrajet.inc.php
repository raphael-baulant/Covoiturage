<?php
if (!empty($_SESSION["per_login"])) {
?>
	<h1>Proposer un trajet</h1>
	<?php
	if ((empty($_POST["vil_num_depart"]) || $_POST["vil_num_depart"]=="0") && empty($_POST["pro_place"])) {
		$listeVillesDepart = $managerPropose->getVillesProposeDepart();
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
					<td class="nonBorder espaceDansFormulaire"><input class="buttonValider" type="submit" value="Valider"></td>
				</tr>
			</table>		
		</form>
	<?php
	} else {
		if(empty($_POST["pro_place"])){
			$listeVillesArrivee = $managerPropose->getVillesProposeArrivee($_POST["vil_num_depart"]);
		?>
			<form method="post" action="#">
				<table class="nobordered">
					<tr>
						<td class="nonBorder espaceDansFormulaire"><label>Ville de départ : <?php echo $managerVille->getVilNom($_POST["vil_num_depart"]); ?></label></td>
						<td class="nonBorder espaceDansFormulaire"><label>Ville d'arrivée :</label>
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
						<td class="nonBorder espaceDansFormulaire"><label>Date de départ :</label> <input type="date" name="pro_date" value="<?php echo date('Y-m-d'); ?>" required></td>
						<td class="nonBorder espaceDansFormulaire"><label>Heure de départ : </label><input type="time" name="pro_time" step="2" value="<?php echo date('H:i:s'); ?>" required></td>
					</tr>
					<tr>
						<td class="nonBorder espaceDansFormulaire"><label>Nombre de places : </label><input type="number" name="pro_place" min="1" required></td>
						<td class="nonBorder espaceDansFormulaire"></td>
					</tr>
				</table>
				<input class="buttonValider" type="submit" value="Valider">
				<input type="hidden" name="vil_num_depart" value="<?php echo $_POST['vil_num_depart']; ?>">			
			</form>		
		<?php
		} else {		
			$_POST["par_num"] = $managerPropose->getParNum($_POST["vil_num_depart"], $_POST["vil_num_arrivee"]);
			$_POST["pro_sens"] = $managerPropose->getProSens($_POST["par_num"], $_POST["vil_num_depart"], $_POST["vil_num_arrivee"]);
			$_POST["per_num"] = $_SESSION["per_num"];
			
			$trajet = new Propose($_POST);
			$managerPropose->add($trajet);
			?>
			<p>
				<img src="image/valid.png" alt="Image validité"> Le trajet a été ajouté
			</p>
		<?php
		}
	}
} else {
	header("Location: index.php?page=0");
	exit;
}
?>
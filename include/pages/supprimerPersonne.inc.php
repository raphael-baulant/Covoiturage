<h1>Supprimer une personne</h1>
<?php
$listePersonnes = $managerPersonne->getList();
if (empty($_POST["per_num"])) {
?>	
	<form method="post" action="#">
		<table class="nobordered">
			<tr>
				<td class="nonBorder">Nom Prénom</td>
				<td class="nonBorder">
					<select size="1" name="per_num">
						<?php						
						foreach ($listePersonnes as $personne) {
						?>
							<option value="<?php echo $personne->getPerNum(); ?>"><?php echo $personne->getPerNom()." ".$personne->getPerPrenom(); ?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>		
		</table>	
		<input class ="buttonValider" type="submit" value="Supprimer">
	</form>
<?php
} else {	
	if ($managerPersonne->isEtudiant($_POST["per_num"])) {
		$managerEtudiant->supprimerEtudiant($_POST["per_num"]);
	} else {
		$managerSalarie->supprimerSalarie($_POST["per_num"]);
	}
	$managerAvis->supprimerAvis($_POST["per_num"]);
	$managerPropose->supprimerTrajet($_POST["per_num"]);
	$managerPersonne->supprimerPersonne($_POST["per_num"]);
	?>
	<p>
		<img src="image/valid.png" alt="Image validité"> La personne a été supprimée
	</p>
<?php
}
?>
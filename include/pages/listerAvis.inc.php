<?php
if (!empty($_SESSION["per_login"])) {
?>
	<h1>Liste des avis</h1>
	<?php
		$listeAvis = $managerAvis->getList();
		$nbAvis = COUNT($listeAvis);
		echo "Actuellement $nbAvis avis sont enregistrés";
	?>
	<table>
		<tr>
			<th>Avis de</th>
			<th>Nom du covoitureur</th>
			<th>Commentaire</th>
			<th>Note</th>
			<th>Date</th>
		</tr>
		<?php
		foreach ($listeAvis as $avis) {
			$personne = $managerPersonne->getPersonne($avis->getPerNum());
			$covoitureur = $managerPersonne->getPersonne($avis->getPerPerNum());
			?>
			<tr>
				<td> <?php echo $personne->getPerPrenom()." ".$personne->getPerNom(); ?> </td>
				<td> <?php echo $covoitureur->getPerPrenom()." ".$covoitureur->getPerNom(); ?> </td>			
				<td> <?php echo $avis->getAviComm(); ?> </td>
				<td> <?php echo $avis->getAviNote(); ?> </td>
				<td> <?php echo $avis->getAviDate(); ?> </td>
			</tr>
		<?php
		}
		?>
	</table>
<?php
} else {
	header("Location: index.php?page=0");
	exit;
}
?>
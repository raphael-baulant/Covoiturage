<?php
if (empty($_GET["per_num"])) {
?>
	<h1>Liste des personnes enregistrées</h1>
	<?php
	$listePersonnes = $managerPersonne->getList();
	$nbPersonnes = COUNT($listePersonnes);
	echo "Actuellement $nbPersonnes personnes sont enregistrées";	
	?>	
	<table>
		<tr>
			<th>Numéro</th>
			<th>Nom</th>
			<th>Prénom</th>
		</tr>
		<?php
		foreach ($listePersonnes as $personne) {
		?>
			<tr>
				<td> <a href="index.php?page=2&per_num=<?php echo $personne->getPerNum(); ?>"> <?php echo $personne->getPerNum(); ?> </a> </td>
				<td> <?php echo $personne->getPerNom(); ?> </td>
				<td> <?php echo $personne->getPerPrenom(); ?> </td>
			</tr>
		<?php
		}
		?>
	</table>
<?php
} else {	
	$personne = $managerPersonne->getPersonne($_GET["per_num"]);
	$isEtudiant = $managerPersonne->isEtudiant($_GET["per_num"]);
	if ($isEtudiant) {
	?>
		<h1>Détail sur l'étudiant <?php echo $personne->getPerNom(); ?></h1>
	<?php
	} else {
	?>
		<h1>Détail sur le salarié <?php echo $personne->getPerNom(); ?></h1>
	<?php
	}
	?>
	<table>
		<tr>
			<th>Prénom</th>
			<th>Mail</th>
			<th>Tel</th>
			<?php
			if ($isEtudiant) {
			?>
				<th>Département</th>
				<th>Ville</th>
			<?php
			} else {
			?>
				<th>Tel pro</th>
				<th>Fonction</th>
			<?php
			}
			?>
		</tr>
		<tr>
			<td> <?php echo $personne->getPerPrenom(); ?> </td>
			<td> <?php echo $personne->getPerMail(); ?> </td>
			<td> <?php echo $personne->getPerTel(); ?> </td>
			<?php
			if ($isEtudiant) {
			?>
				<td> <?php echo $managerEtudiant->getDepNom($_GET["per_num"]); ?> </td>
				<td> <?php echo $managerEtudiant->getVilNom($_GET["per_num"]); ?> </td>
			<?php
			} else {
			?>
				<td> <?php echo $managerSalarie->getSalTelProf($_GET["per_num"]); ?> </td>
				<td> <?php echo $managerSalarie->getFonLibelle($_GET["per_num"]); ?> </td>
			<?php
			}
			?>
		</tr>
	</table>
<?php
}
?>
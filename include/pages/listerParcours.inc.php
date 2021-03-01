<h1>Liste des parcours proposés</h1>
<?php
	$listeParcours = $managerParcours->getList();
	$nbParcours = COUNT($listeParcours);
	echo "Actuellement $nbParcours parcours sont enregistrés";
?>
<table>
	<tr>
		<th>Numéro</th>
		<th>Nom ville</th>
		<th>Nom ville</th>
		<th>Nombre de Km</th>
	</tr>
	<?php
	foreach ($listeParcours as $parcours) {
	?>
		<tr>
			<td> <?php echo $parcours->getParNum(); ?> </td>
			<td> <?php echo $managerVille->getVilNom($parcours->getVilNum1()); ?> </td>
			<td> <?php echo $managerVille->getVilNom($parcours->getVilNum2()); ?> </td>
			<td> <?php echo $parcours->getParKm(); ?> </td>
		</tr>
	<?php
	}
	?>
</table>
<h1>Liste des villes</h1>
<?php
	$listeVilles = $managerVille->getList();
	$nbVilles = COUNT($listeVilles);
	echo "Actuellement $nbVilles villes sont enregistrées";
?>
<table>
	<tr>
		<th>Numéro</th>
		<th>Nom</th>
	</tr>
	<?php
	foreach ($listeVilles as $ville) {
	?>
		<tr>
			<td> <?php echo $ville->getVilNum(); ?> </td>
			<td> <?php echo $ville->getVilNom(); ?> </td>
		</tr>
	<?php
	}
	?>
</table>
<h1>Ajouter une ville</h1>
<?php
if (empty($_POST["vil_nom"])) {
?>
	<form method="post" action="#">
		<table class="nobordered">
			<tr>
				<td class="nonBorder"><label>Nom :</label></td>
				<td class="nonBorder"><input type="text" name="vil_nom" required></td>
				<td class="nonBorder"><input class="buttonValider" type="submit" value="Valider"></td>
			</tr>
		</table>
	</form>
<?php
} else {
	if ($managerVille->isValide($_POST["vil_nom"])) {
		$ville = new Ville($_POST);
		$managerVille->add($ville);
		?>
		<p>
			<img src="image/valid.png"  alt="Img validité"> La ville <b>"<?php echo $_POST["vil_nom"]; ?>"</b> a été ajoutée
		</p>
	<?php
	} else {
	?>
		<p>
			<img src="image/erreur.png" alt="Img erreur"> La ville <b>"<?php echo $_POST["vil_nom"]; ?>"</b> a déjà été ajoutée
		</p>
	<?php
	}
}
?>
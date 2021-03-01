<?php
if (empty($_POST["per_login"]) || empty($_POST["per_pwd"]) || !$managerPersonne->isValide($_POST["per_login"], $_POST["per_pwd"]) || $_POST["reponse"] != $_POST["reponse_utilisateur"]) {
?>
	<h1>Pour vous connecter</h1>
	<form method="post" action="#">
		<table class="nobordered">
			<tr>
				<td class="nonBorder"><label>Nom d'utilisateur:</label></td>
			</tr>
			<tr>
				<td class="nonBorder"><input type="text" name="per_login" required></td>
			</tr>
			<tr>
				<td class="nonBorder"><label>Mot de passe:</label></td>
			</tr>
			<tr>
				<td class="nonBorder"><input type="password" name="per_pwd" required></td>
			</tr>
			<tr>
				<td class="nonBorder">
					<?php 
					$chiffre1=rand(1,9);
					$chiffre2=rand(1,9);
					$resultat=$chiffre1+$chiffre2;
					?>
					<img class="verificationImage" src="image/nb/<?php echo $chiffre1; ?>.jpg" alt="Image Verification chiffre1">
					<label class="sympolePlusEgale"> + </label>
					<img class="verificationImage" src="image/nb/<?php echo $chiffre2; ?>.jpg" alt="Image Verification chiffre2">
					<label class="sympolePlusEgale"> = </label>
				</td>
			</tr>
			<tr>
				<td class="nonBorder derniereLigneConnecterTable">
					<input type="text" name="reponse_utilisateur" required>
					<input type="hidden" name="reponse" value="<?php echo $resultat; ?>">
				</td>
			</tr>
			<tr>
				<td class="nonBorder"><input class="buttonValider" type="submit" value="Valider"></td>
			</tr>
		</table>
	</form>
<?php
} else {
	$_SESSION["per_num"] = $managerPersonne->getPerNum($_POST["per_login"], $_POST["per_pwd"]);
	$_SESSION["per_login"] = $_POST["per_login"];
	header("Location: index.php?page=0");
	exit;
}
?>
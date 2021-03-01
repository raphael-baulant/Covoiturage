<?php
if ((empty($_POST["per_nom"]) || empty($_POST["per_prenom"]) || empty($_POST["per_tel"]) || empty($_POST["per_mail"]) || empty($_POST["per_login"]) || empty($_POST["per_pwd"])) && empty($_POST["div_num"]) && empty($_POST["fon_num"])) {
?>
	<h1>Ajouter une personne</h1>
	<form method="post" action="#">
		<table class="nobordered">		
			<tr>
				<td class="nonBorder gauche"><label>Nom :</label></td>
				<td class="nonBorder"><input type="text" name="per_nom" required></td>
				<td class="nonBorder gauche"><label>Prénom :</label></td>
				<td class="nonBorder"><input type="text" name="per_prenom" required></td>
			</tr>
			<tr>
				<td class="nonBorder gauche"><label>Téléphone :</label></td>
				<td class="nonBorder"><input type="tel" name="per_tel" placeholder="0555555555" pattern="[0]{1}[0-9]{9}" required></td>
				<td class="nonBorder gauche"><label>Mail :</label></td>
				<td class="nonBorder"><input type="email" name="per_mail" placeholder="abc@operateur.fr" pattern="[a-zA-Z0-9.]+@[a-z]+\.[a-z]{2,4}" required></td>
			</tr>
			<tr>
				<td class="nonBorder gauche"><label>Login :</label></td>
				<td class="nonBorder"><input type="text" name="per_login" required></td>
				<td class="nonBorder gauche"><label>Mot de passe :</label></td>
				<td class="nonBorder"><input type="password" name="per_pwd" required></td>
			</tr>
		</table>
		<p>
			<label>Catégorie :</label>
			<input class="radio" id="etudiant" type="radio" name="categorie" value="etudiant" checked>
			<label for="etudiant">Etudiant</label>
			<input class="radio" id="personnel" type="radio" name="categorie" value="personnel">
			<label for="personnel">Personnel</label>
		</p>
		<input class="nonBorder buttonValider" type="submit" value="Valider">
	</form>
<?php
} else {
	if (empty($_POST["div_num"]) && empty($_POST["fon_num"])) {
		$personne = new Personne($_POST);
		$managerPersonne->add($personne);
		$per_num = $pdo->lastInsertId();
		$_SESSION["per_num"] = $per_num;

		if ($_POST["categorie"] == "etudiant") {
			$listeDivisions = $managerDivision->getList();
			$listeDepartements = $managerDepartement->getList();
			?>
			<h1>Ajouter un étudiant</h1>
			<form method="post" action="#">
				<table class="nobordered">
					<tr>
						<td class="nonBorder identite"> <!-- identite est pour spécifier les css d'ajouter un étudiant ou d'ajouter un salarié -->
							<label>Année :</label>
							<select size="1" name="div_num">
								<?php
								foreach ($listeDivisions as $division) {
								?>
									<option value="<?php echo $division->getDivNum(); ?>"><?php echo $division->getDivNom(); ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="nonBorder identite">
							<label>Département :</label>
							<select size="1" name="dep_num">
								<?php						
								foreach ($listeDepartements as $departement) {
								?>
									<option value="<?php echo $departement->getDepNum(); ?>"><?php echo $departement->getDepNom(); ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
				</table>
				<input class="buttonValider" type="submit" value="Valider">
			</form>
		<?php
		} else { //$_POST["categorie"] = "personnel"
			$listeFonctions = $managerFonction->getList();
			?>
			<h1>Ajouter un salarié</h1>
			<form method="post" action="#">
				<table class="nobordered">
					<tr>
						<td class="nonBorder identite"> <!-- identite est pour spécifier les css d'ajouter un étudiant ou d'ajouter un salarié -->
							<label>Téléphone professionnel :</label>
							<input type="tel" name="sal_telprof" placeholder="0555555555" pattern="[0]{1}[0-9]{9}" required>
						</td>
					</tr>
					<tr>
						<td class="nonBorder identite">
							<label>Fonction :</label>
							<select size="1" name="fon_num">
								<?php						
								foreach ($listeFonctions as $fonction) {
								?>
									<option value="<?php echo $fonction->getFonNum(); ?>"><?php echo $fonction->getFonLibelle(); ?></option>
								<?php
								}
								?>
							</select>
						</td>
					</tr>
				</table>
				<input class="buttonValider" type="submit" value="Valider">
			</form>
		<?php
		}
	} else {
		$merge = array_merge($_POST, $_SESSION);
		if (empty($_POST["div_num"])) {			
			$salarie = new Salarie($merge);
			$managerSalarie->add($salarie);
			?>
			<h1>Ajouter un salarié</h1>
			<p>
				<img src="image/valid.png" alt="Image validité"> Le salarié a été ajouté
			</p>
			<?php
		} else {
			$etudiant = new Etudiant($merge);
			$managerEtudiant->add($etudiant);
			?>
			<h1>Ajouter un étudiant</h1>
			<p>
				<img src="image/valid.png" alt="Image validité"> L'étudiant a été ajouté
			</p>
			<?php
		}
	}
}
?>
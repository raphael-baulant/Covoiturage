<h1>Modifier une personne</h1>
<?php
$listePersonnes = $managerPersonne->getList();
if (empty($_POST["per_num"]) && empty($_POST["per_nom"]) && empty($_POST["div_num"]) && empty($_POST["fon_num"])) {
?>	
	<form method="post" action="#">
		<table>
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
		<input class ="buttonValider" type="submit" value="Modifier">
	</form>
<?php
} else {
	if (empty($_POST["per_nom"]) && empty($_POST["div_num"]) && empty($_POST["fon_num"])) {
		$_SESSION["per_num"] = $_POST["per_num"];
		$personne = $managerPersonne->getPersonne($_POST["per_num"]);
		?>
		<form method="post" action="#">
			<input type="hidden" name="per_num" value="<?php echo $_POST["per_num"] ?>">
			<table>
				<tr>
					<td class="nonBorder">Nom :</td>
					<td class="nonBorder"><input type="text" name="per_nom" value="<?php echo $personne->getPerNom(); ?>" required></td>
					<td class="nonBorder">Prénom :</td>
					<td class="nonBorder"><input type="text" name="per_prenom" value="<?php echo $personne->getPerPrenom(); ?>" required></td>
				</tr>
				<tr>
					<td class="nonBorder">Téléphone :</td>
					<td class="nonBorder"><input type="tel" name="per_tel" value="<?php echo $personne->getPerTel(); ?>" placeholder="0555555555" pattern="[0]{1}[0-9]{9}" required></td>
					<td class="nonBorder">Mail :</td>
					<td class="nonBorder"><input type="email" name="per_mail" value="<?php echo $personne->getPerMail(); ?>" placeholder="abc@operateur.fr" pattern="[a-zA-Z0-9.]+@[a-z]+\.[a-z]{2,4}" required></td>
				</tr>
				<tr>
					<td class="nonBorder">Login :</td>
					<td class="nonBorder"><input type="text" name="per_login" value="<?php echo $personne->getPerLogin(); ?>" required></td>
					<td class="nonBorder">Mot de passe :</td>
					<td class="nonBorder"><input type="password" name="per_pwd" required></td>
				</tr>
			</table>
			<p>
				Catégorie :
				<input class="radio" id="etudiantModifier" type="radio" name="categorie" value="etudiantModifier" checked>
				<label for="etudiantModifier">Etudiant</label>
				<input class="radio" id="personnelModifier" type="radio" name="categorie" value="personnelModifier">
				<label for="personnelModifier">Personnel</label>
			</p>
			<input class ="buttonValider nonBorder" type="submit" value="Valider">
		</form>
	<?php
	} else {
		if (empty($_POST["div_num"]) && empty($_POST["fon_num"])) {
			$per_num = $_POST["per_num"];
			$personne = $managerPersonne->getPersonne($per_num);
			if ($_POST["per_nom"] != $personne->getPerNom()) {
				$managerPersonne->modifierNom($per_num, $_POST["per_nom"]);
			}
			if ($_POST["per_prenom"] != $personne->getPerPrenom()) {
				$managerPersonne->modifierPrenom($per_num, $_POST["per_prenom"]);
			}
			if ($_POST["per_tel"] != $personne->getPerTel()) {
				$managerPersonne->modifierTel($per_num, $_POST["per_tel"]);
			}
			if ($_POST["per_mail"] != $personne->getPerMail()) {
				$managerPersonne->modifierMail($per_num, $_POST["per_mail"]);
			}
			if ($_POST["per_login"] != $personne->getPerLogin()) {
				$managerPersonne->modifierLogin($per_num, $_POST["per_login"]);
			}
			if (Personne::cryptPWD($_POST["per_pwd"]) != $personne->getPerPwd()) {
				$managerPersonne->modifierPwd($per_num, $_POST["per_pwd"]);
			}
			
			if ($_POST["categorie"] == "etudiantModifier") {
				$listeDivisions = $managerDivision->getList();
				$listeDepartements = $managerDepartement->getList();
				?>
				<form method="post" action="#">
					<table>
						<tr>
							<td class="nonBorder">Année :</td>
							<td class="nonBorder">
								<select size="1" name="div_num">
									<?php
									foreach ($listeDivisions as $division) {
										if ($managerPersonne->isEtudiant($per_num) && $division->getDivNum() == $managerEtudiant->getDivNum($per_num)) {
											?>
											<option value="<?php echo $division->getDivNum(); ?>" selected ><?php echo $division->getDivNom(); ?></option>
											<?php
										} else {
											?>
											<option value="<?php echo $division->getDivNum(); ?>"><?php echo $division->getDivNom(); ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class="nonBorder">Département :</td>
							<td class="nonBorder">
								<select size="1" name="dep_num">
									<?php						
									foreach ($listeDepartements as $departement) {
										if ($managerPersonne->isEtudiant($per_num) && $departement->getDepNum() == $managerEtudiant->getDepNum($per_num)) {
											?>
											<option value="<?php echo $departement->getDepNum(); ?>" selected><?php echo $departement->getDepNom(); ?></option>
											<?php
										} else {
											?>
											<option value="<?php echo $departement->getDepNum(); ?>"><?php echo $departement->getDepNom(); ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
					</table>
					<input class ="buttonValider" type="submit" value="Valider">
				</form>
				<?php
			}

			if ($_POST["categorie"] == "personnelModifier") {
				$listeFonctions = $managerFonction->getList();
				?>
				<form method="post" action="#">
					<table>
						<tr>
							<td class="nonBorder">Téléphone professionnel :</td>
							<?php
							if (!$managerPersonne->isEtudiant($per_num)){
								?>
								<td class="nonBorder"><input type="tel" name="sal_telprof" value="<?php echo $managerSalarie->getSalTelProf($per_num); ?>" placeholder="0555555555" pattern="[0]{1}[0-9]{9}" required></td>
								<?php 
							}else {
								?>
								<td class="nonBorder"><input type="tel" name="sal_telprof" placeholder="0555555555" pattern="[0]{1}[0-9]{9}" required></td>
								<?php
							}
						?>
						</tr>
						<tr>
							<td class="nonBorder">Fonction :</td>
							<td class="nonBorder">
								<select size="1" name="fon_num">
									<?php
									foreach ($listeFonctions as $fonction) {
										if (!$managerPersonne->isEtudiant($per_num) && $fonction->getFonNum() == $managerSalarie->getFonNum($per_num)) {
											?>
											<option value="<?php echo $fonction->getFonNum(); ?>" selected ><?php echo $fonction->getFonLibelle(); ?></option>
											<?php
										} else {
											?>
											<option value="<?php echo $fonction->getFonNum(); ?>"><?php echo $fonction->getFonLibelle(); ?></option>
											<?php
										}
									}
									?>
								</select>
							</td>
						</tr>
					</table>
					<input class ="buttonValider" type="submit" value="Valider">
				</form>
				<?php
			}
		} else {
			$per_num = $_SESSION["per_num"];
			$merge = array_merge($_POST, $_SESSION);
			
			if (empty($_POST["div_num"])) {
				if ($managerPersonne->isEtudiant($per_num)) {
					$managerEtudiant->supprimerEtudiant($per_num);
					$salarie = new Salarie($merge);
					$managerSalarie->add($salarie);
				} else {
					if ($_POST["sal_telprof"] != $managerSalarie->getSalTelProf($per_num)) {
						$managerSalarie->modifierSalTelProf($per_num, $_POST["sal_telprof"]);
					}
					if ($_POST["fon_num"] != $managerSalarie->getFonNum($per_num)) {
						$managerSalarie->modifierFonNum($per_num, $_POST["fon_num"]);
					}
				}
			} else {				
				if (!$managerPersonne->isEtudiant($per_num)) {
					$managerSalarie->supprimerSalarie($per_num);
					$etudiant = new Etudiant($merge);
					$managerEtudiant->add($etudiant);
				} else {
					if ($_POST["dep_num"] != $managerEtudiant->getDepNum($per_num)) {
						$managerEtudiant->modifierDepNum($per_num, $_POST["dep_num"]);
					}
					if ($_POST["div_num"] != $managerEtudiant->getDivNum($per_num)) {
						$managerEtudiant->modifierDivNum($per_num, $_POST["div_num"]);
					}
				}
			}

			?>
			<p>
				<img src="image/valid.png" alt="Image validité"> Les modifications ont été effectuées
			</p>
			<?php
		}
	}
}
?>
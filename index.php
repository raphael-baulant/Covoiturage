<?php
require_once("include/config.inc.php");
require_once("include/autoload.inc.php");
require_once("include/header.inc.php");
$pdo = new Mypdo();
$managerVille = new VilleManager($pdo);
$managerParcours = new ParcoursManager($pdo);
$managerPersonne = new PersonneManager($pdo);
$managerDepartement = new DepartementManager($pdo);
$managerDivision = new DivisionManager($pdo);
$managerFonction = new FonctionManager($pdo);
$managerEtudiant = new EtudiantManager($pdo);
$managerSalarie = new SalarieManager($pdo);
$managerPropose = new ProposeManager($pdo);
$managerAvis = new AvisManager($pdo);

?>
<div id="corps">
<?php
require_once("include/menu.inc.php"); 
require_once("include/texte.inc.php");
?>
</div>
<div id="spacer"></div>
<?php
require_once("include/footer.inc.php");
?>
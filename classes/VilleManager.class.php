<?php
class VilleManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($ville) {
		$sql = 'INSERT INTO ville (vil_nom) VALUES(:vil_nom)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_nom', $ville->getVilNom(), PDO::PARAM_STR);
		$req->execute();
	}

	public function getList() {
		$sql = 'SELECT vil_num, vil_nom FROM ville';
		$req = $this->db->query($sql);
		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVilles;
	}

	public function getVilNom($vil_num) {
		$sql = 'SELECT vil_nom FROM ville WHERE vil_num = :vil_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num', $vil_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['vil_nom'];
	}

	public function isValide($vil_nom) {
		$sql = 'SELECT COUNT(*) AS nb FROM ville WHERE vil_nom = :vil_nom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_nom', $vil_nom, PDO::PARAM_STR);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['nb'] == 0;
	}
}
?>
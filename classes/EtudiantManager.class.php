<?php
class EtudiantManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($etudiant) {
		$sql = 'INSERT INTO etudiant (per_num, dep_num, div_num) VALUES(:per_num, :dep_num, :div_num)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $etudiant->getPerNum(), PDO::PARAM_INT);
		$req->bindValue(':dep_num', $etudiant->getDepNum(), PDO::PARAM_INT);
		$req->bindValue(':div_num', $etudiant->getDivNum(), PDO::PARAM_INT);
		$req->execute();
	}

	public function getDepNom($per_num) {
		$sql = 'SELECT dep_nom FROM etudiant e INNER JOIN departement d ON e.dep_num = d.dep_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['dep_nom'];
	}

	public function getVilNom($per_num) {
		$sql = 'SELECT vil_nom FROM etudiant e INNER JOIN departement d ON e.dep_num = d.dep_num INNER JOIN ville v ON d.vil_num = v.vil_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['vil_nom'];
	}

	public function getDivNum($per_num) {
		$sql = 'SELECT div_num FROM etudiant WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['div_num'];
	}

	public function getDepNum($per_num) {
		$sql = 'SELECT dep_num FROM etudiant WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['dep_num'];
	}

	public function supprimerEtudiant($per_num) {		
		$sql = 'DELETE FROM etudiant WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierDepNum($per_num, $dep_num) {
		$sql = 'UPDATE etudiant SET dep_num = :dep_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':dep_num', $dep_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierDivNum($per_num, $div_num) {
		$sql = 'UPDATE etudiant SET div_num = :div_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':div_num', $div_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}
}
?>
<?php
class SalarieManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($salarie) {
		$sql = 'INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES(:per_num, :sal_telprof, :fon_num)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $salarie->getPerNum(), PDO::PARAM_INT);
		$req->bindValue(':sal_telprof', $salarie->getSalTelprof(), PDO::PARAM_STR);
		$req->bindValue(':fon_num', $salarie->getFonNum(), PDO::PARAM_INT);
		$req->execute();
	}

	public function getSalTelProf($per_num) {
		$sql = 'SELECT sal_telprof FROM salarie WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['sal_telprof'];
	}

	public function getFonLibelle($per_num) {
		$sql = 'SELECT fon_libelle FROM salarie s INNER JOIN fonction f ON s.fon_num = f.fon_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['fon_libelle'];
	}

	public function supprimerSalarie($per_num) {		
		$sql = 'DELETE FROM salarie WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}

	public function getFonNum($per_num) {		
		$sql = 'SELECT fon_num FROM salarie WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['fon_num'];
	}

	public function modifierSalTelProf($per_num, $sal_telprof) {
		$sql = 'UPDATE salarie SET sal_telprof = :sal_telprof WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':sal_telprof', $sal_telprof, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierFonNum($per_num, $fon_num) {
		$sql = 'UPDATE salarie SET fon_num = :fon_num WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':fon_num', $fon_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}
}
?>
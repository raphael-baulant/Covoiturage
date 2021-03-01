<?php
class AvisManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($avis) {
		$sql = 'INSERT INTO avis (per_num, per_per_num, par_num, avi_comm, avi_note, avi_date) VALUES(:per_num, :per_per_num, :par_num, :avi_comm, :avi_note, :avi_date)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $avis->getPerNum(), PDO::PARAM_INT);
		$req->bindValue(':per_per_num', $avis->getPerPerNum(), PDO::PARAM_INT);
		$req->bindValue(':par_num', $avis->getParNum(), PDO::PARAM_INT);
		$req->bindValue(':avi_comm', $avis->getAviComm(), PDO::PARAM_STR);
		$req->bindValue(':avi_note', $avis->getAviNote(), PDO::PARAM_INT);
		$req->bindValue(':avi_date', $avis->getAviDate());
		$req->execute();
	}

	public function getList() {
		$sql = 'SELECT per_num, per_per_num, par_num, avi_comm, avi_note, avi_date FROM avis';
		$req = $this->db->query($sql);
		while ($avis = $req->fetch(PDO::FETCH_OBJ)) {
			$listeAvis[] = new Avis($avis);
		}
		$req->closeCursor();
		return $listeAvis;
	}

	public function getMoyenne($per_num) {
		$sql = 'SELECT cast(avg(avi_note) as decimal(5,1)) as moyenne FROM avis WHERE per_per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['moyenne'];
	}

	public function getDernierAvis($per_num) {
		$sql = 'SELECT avi_comm FROM avis WHERE per_per_num = :per_num AND avi_date >= ALL(SELECT avi_date FROM avis WHERE per_per_num = :per_num)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['avi_comm'];
	}

	public function getListAvis($per_num) {
		$sql = 'SELECT per_num, per_per_num, par_num, avi_comm, avi_note, avi_date FROM avis WHERE per_per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		/*while ($avis = $req->fetch(PDO::FETCH_OBJ)) {
			$listeAvis[] = new Avis($avis);
		}
		$req->closeCursor();
		if (COUNT($listeAvis) == 0) {
			return null;
		}
		return $listeAvis;*/
		$listeTrajets = $req->fetchAll(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $listeTrajets;
	}

	public function isValide($per_num, $per_per_num, $par_num) {	
		$sql = 'SELECT COUNT(*) AS nb FROM avis WHERE per_num = :per_num AND per_per_num = :per_per_num AND par_num = :par_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_per_num', $per_per_num, PDO::PARAM_INT);
		$req->bindValue(':par_num', $par_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['nb'] == 0;
	}

	public function supprimerAvis($per_num) {
		$sql = 'DELETE FROM avis WHERE per_num = :per_num OR per_per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}
}
?>
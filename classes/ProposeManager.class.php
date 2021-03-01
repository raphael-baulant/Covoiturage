<?php
class ProposeManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($trajet) {
		$sql = 'INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES(:par_num, :per_num, :pro_date, :pro_time, :pro_place, :pro_sens)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':par_num', $trajet->getParNum(), PDO::PARAM_INT);
		$req->bindValue(':per_num', $trajet->getPerNum(), PDO::PARAM_INT);
		$req->bindValue(':pro_date', $trajet->getProDate());
		$req->bindValue(':pro_time', $trajet->getProTime());
		$req->bindValue(':pro_place', $trajet->getProPlace(), PDO::PARAM_INT);
		$req->bindValue(':pro_sens', $trajet->getProSens(), PDO::PARAM_INT);
		$req->execute();
	}
	
	public function getVillesProposeDepart() {
		$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num IN (SELECT vil_num1 FROM parcours UNION SELECT vil_num2 FROM parcours)';
		$req = $this->db->query($sql);
		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVilles;
	}

	public function getVillesProposeArrivee($vil_num) {
		$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num IN (SELECT vil_num1 FROM parcours WHERE vil_num2 = :vil_num UNION SELECT vil_num2 FROM parcours WHERE vil_num1 = :vil_num)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num', $vil_num, PDO::PARAM_INT);
		$req->execute();
		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVilles;
	}

	public function getParNum($vil_num_depart, $vil_num_arrivee) {
		$sql = 'SELECT par_num FROM parcours WHERE (vil_num1 = :vil_num_depart AND vil_num2 = :vil_num_arrivee) OR (vil_num1 = :vil_num_arrivee AND vil_num2 = :vil_num_depart)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num_depart', $vil_num_depart, PDO::PARAM_INT);
		$req->bindValue(':vil_num_arrivee', $vil_num_arrivee, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['par_num'];
	}

	public function getProSens($par_num, $vil_num_depart, $vil_num_arrivee) {
		$sql = 'SELECT CASE WHEN vil_num1=:vil_num_depart AND vil_num2=:vil_num_arrivee THEN 0 ELSE 1 END AS pro_sens FROM parcours WHERE par_num=:par_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num_depart', $vil_num_depart, PDO::PARAM_INT);
		$req->bindValue(':vil_num_arrivee', $vil_num_arrivee, PDO::PARAM_INT);
		$req->bindValue(':par_num', $par_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['pro_sens'];
	}

	public function getVillesRechercheDepart() {
		$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num IN (
			SELECT vil_num1 FROM parcours pa INNER JOIN propose pr ON pa.par_num=pr.par_num WHERE pro_sens=0
			UNION
			SELECT vil_num2 FROM parcours pa INNER JOIN propose pr ON pa.par_num=pr.par_num WHERE pro_sens=1
		)';
		$req = $this->db->query($sql);
		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVilles;
	}

	public function getVillesRechercheArrivee($vil_num) {
		$sql = 'SELECT vil_num, vil_nom FROM ville WHERE vil_num IN (
			SELECT vil_num1 FROM parcours pa INNER JOIN propose pr ON pa.par_num=pr.par_num WHERE pro_sens=1 AND vil_num2=:vil_num
			UNION
			SELECT vil_num2 FROM parcours pa INNER JOIN propose pr ON pa.par_num=pr.par_num WHERE pro_sens=0 AND vil_num1=:vil_num
		)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num', $vil_num, PDO::PARAM_INT);
		$req->execute();
		while ($ville = $req->fetch(PDO::FETCH_OBJ)) {
			$listeVilles[] = new Ville($ville);
		}
		$req->closeCursor();
		return $listeVilles;
	}

	public function rechercherTrajet($vil_num_depart, $vil_num_arrivee, $pro_date, $precision, $pro_time) {
		$sql = 'SELECT v1.vil_nom as vil_nom_depart, v2.vil_nom as vil_nom_arrivee, pro_date, pro_time, pro_place, per_nom, per_prenom
				FROM ville v1, ville v2, parcours pa, propose pr, personne pe
				WHERE v1.vil_num=vil_num1 AND v2.vil_num=vil_num2 AND pr.par_num=pa.par_num AND pe.per_num=pr.per_num AND vil_num1=:vil_num_depart AND vil_num2=:vil_num_arrivee AND pro_sens=0 AND pro_time>="$pro_time:00:00" AND abs(datediff(pro_date, :pro_date))<=:precision
				UNION
				(SELECT v1.vil_nom as vil_nom_depart, v2.vil_nom as vil_nom_arrivee, pro_date, pro_time, pro_place, per_nom, per_prenom
				FROM ville v1, ville v2, parcours pa, propose pr, personne pe
				WHERE v1.vil_num=vil_num1 AND v2.vil_num=vil_num2 AND pr.par_num=pa.par_num AND pe.per_num=pr.per_num AND vil_num2=:vil_num_depart AND vil_num1=:vil_num_arrivee AND pro_sens=1 AND pro_time>="$pro_time:00:00" AND abs(datediff(pro_date, :pro_date))<=:precision)
				';

		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num_depart', $vil_num_depart, PDO::PARAM_INT);
		$req->bindValue(':vil_num_arrivee', $vil_num_arrivee, PDO::PARAM_INT);
		$req->bindValue(':pro_date', $pro_date);
		$req->bindValue(':precision', $precision, PDO::PARAM_INT);
		$req->bindValue(':pro_time', $pro_time, PDO::PARAM_INT);
		$req->execute();
		$listeTrajets = $req->fetchAll(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $listeTrajets;
	}

	public function supprimerTrajet($per_num) {
		$sql = 'DELETE FROM propose WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}
}
?>
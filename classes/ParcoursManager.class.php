<?php
class ParcoursManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($parcours) {
		$sql = 'INSERT INTO parcours (vil_num1, vil_num2, par_km) VALUES(:vil_num1, :vil_num2, :par_km)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num1', $parcours->getVilNum1(), PDO::PARAM_INT);
		$req->bindValue(':vil_num2', $parcours->getVilNum2(), PDO::PARAM_INT);
		$req->bindValue(':par_km', $parcours->getParKm(), PDO::PARAM_INT);
		$req->execute();
	}

	public function getList() {
		$sql = 'SELECT par_num, vil_num1, vil_num2, par_km FROM parcours';
		$req = $this->db->query($sql);
		while ($parcours = $req->fetch(PDO::FETCH_OBJ)) {
			$listeParcours[] = new Parcours($parcours);
		}
		$req->closeCursor();
		return $listeParcours;
	}

	public function isValide($vil_num1, $vil_num2) {
		$sql = 'SELECT COUNT(*) AS nb FROM parcours WHERE (vil_num1 = :vil_num1 AND vil_num2 = :vil_num2) OR (vil_num1 = :vil_num2 AND vil_num2 = :vil_num1)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':vil_num1', $vil_num1, PDO::PARAM_INT);
		$req->bindValue(':vil_num2', $vil_num2, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['nb'] == 0;
	}
}
?>
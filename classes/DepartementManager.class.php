<?php
class DepartementManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}
	
	public function getList() {
		$sql = 'SELECT dep_num, dep_nom FROM departement';
		$req = $this->db->query($sql);
		while ($departement = $req->fetch(PDO::FETCH_OBJ)) {
			$listeDepartements[] = new Departement($departement);
		}
		$req->closeCursor();
		return $listeDepartements;
	}
}
?>
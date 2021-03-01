<?php
class FonctionManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}
	
	public function getList() {
		$sql = 'SELECT fon_num, fon_libelle FROM fonction';
		$req = $this->db->query($sql);
		while ($fonction = $req->fetch(PDO::FETCH_OBJ)) {
			$listeFonctions[] = new Fonction($fonction);
		}
		$req->closeCursor();
		return $listeFonctions;
	}
}
?>
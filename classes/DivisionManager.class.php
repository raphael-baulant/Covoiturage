<?php
class DivisionManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}
	
	public function getList() {
		$sql = 'SELECT div_num, div_nom FROM division';
		$req = $this->db->query($sql);
		while ($division = $req->fetch(PDO::FETCH_OBJ)) {
			$listeDivisions[] = new Division($division);
		}
		$req->closeCursor();
		return $listeDivisions;
	}
}
?>
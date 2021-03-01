<?php
class PersonneManager {
	protected $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($personne) {
		$sql = 'INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES(:per_nom, :per_prenom, :per_tel, :per_mail, :per_login, :per_pwd)';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_nom', $personne->getPerNom(), PDO::PARAM_STR);
		$req->bindValue(':per_prenom', $personne->getPerPrenom(), PDO::PARAM_STR);
		$req->bindValue(':per_tel', $personne->getPerTel(), PDO::PARAM_STR);
		$req->bindValue(':per_mail', $personne->getPerMail(), PDO::PARAM_STR);
		$req->bindValue(':per_login', $personne->getPerLogin(), PDO::PARAM_STR);
		$req->bindValue(':per_pwd', $personne->getPerPwd(), PDO::PARAM_STR);
		$req->execute();
	}

	public function getList() {
		$sql = 'SELECT per_num, per_nom, per_prenom FROM personne';
		$req = $this->db->query($sql);
		while ($personne = $req->fetch(PDO::FETCH_OBJ)) {
			$listePersonnes[] = new Personne($personne);
		}
		$req->closeCursor();
		return $listePersonnes;
	}

	public function getPersonne($per_num) {
		$sql = 'SELECT * FROM personne WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_OBJ);
		$req->closeCursor();
		return new Personne($res);
	}
	
	public function isEtudiant($per_num) {
		$sql = 'SELECT COUNT(*) AS nb FROM etudiant WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['nb'] == 1;
	}

	public function isValide($per_login, $per_pwd) {
		$per_pwd = Personne::cryptPWD($per_pwd);
		$sql = 'SELECT COUNT(*) AS nb FROM personne WHERE per_login = :per_login AND per_pwd = :per_pwd';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_login', $per_login, PDO::PARAM_STR);
		$req->bindValue(':per_pwd', $per_pwd, PDO::PARAM_STR);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['nb'] == 1;
	}

	public function getPerNum($per_login, $per_pwd) {
		$per_pwd = Personne::cryptPWD($per_pwd);
		$sql = 'SELECT per_num FROM personne WHERE per_login = :per_login AND per_pwd = :per_pwd';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_login', $per_login, PDO::PARAM_STR);
		$req->bindValue(':per_pwd', $per_pwd, PDO::PARAM_STR);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['per_num'];
	}

	public function getPerNum2($per_nom, $per_prenom) {
		$sql = 'SELECT per_num FROM personne WHERE per_nom = :per_nom AND per_prenom = :per_prenom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_nom', $per_nom, PDO::PARAM_STR);
		$req->bindValue(':per_prenom', $per_prenom, PDO::PARAM_STR);
		$req->execute();
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $res['per_num'];
	}

	public function supprimerPersonne($per_num) {		
		$sql = 'DELETE FROM personne WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierNom($per_num, $per_nom) {
		$sql = 'UPDATE personne SET per_nom = :per_nom WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_nom', $per_nom, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierPrenom($per_num, $per_prenom) {
		$sql = 'UPDATE personne SET per_prenom = :per_prenom WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_prenom', $per_prenom, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierTel($per_num, $per_tel) {
		$sql = 'UPDATE personne SET per_tel = :per_tel WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_tel', $per_tel, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierMail($per_num, $per_mail) {
		$sql = 'UPDATE personne SET per_mail = :per_mail WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_mail', $per_mail, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierLogin($per_num, $per_login) {
		$sql = 'UPDATE personne SET per_login = :per_login WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_login', $per_login, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}

	public function modifierPwd($per_num, $per_pwd) {
		$per_pwd = Personne::cryptPWD($per_pwd);
		$sql = 'UPDATE personne SET per_pwd = :per_pwd WHERE per_num = :per_num';
		$req = $this->db->prepare($sql);
		$req->bindValue(':per_num', $per_num, PDO::PARAM_INT);
		$req->bindValue(':per_pwd', $per_pwd, PDO::PARAM_STR);
		$req->execute();
		$req->closeCursor();
	}
}
?>
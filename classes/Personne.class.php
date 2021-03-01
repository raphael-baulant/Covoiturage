<?php
class Personne {
	private $per_num;
	private $per_nom;
	private $per_prenom;
	private $per_tel;
	private $per_mail;
	private $per_login;
	private $per_pwd;
	
	public function __construct($valeurs) {
		if (!empty($valeurs)) {
			$this->affecte($valeurs);
		}
	}
	
	public function setPerNum($per_num) {
		$this->per_num = $per_num;
	}
	public function setPerNom($per_nom) {
		$this->per_nom = $per_nom;
	}
	public function setPerPrenom($per_prenom) {
		$this->per_prenom = $per_prenom;
	}
	public function setPerTel($per_tel) {
		$this->per_tel = $per_tel;
	}
	public function setPerMail($per_mail) {
		$this->per_mail = $per_mail;
	}
	public function setPerLogin($per_login) {
		$this->per_login = $per_login;
	}
	public function setPerPwd($per_pwd) {
		$this->per_pwd = $per_pwd;
	}
	
	public function getPerNum() {
		return $this->per_num;
	}
	public function getPerNom() {
		return $this->per_nom;
	}
	public function getPerPrenom() {
		return $this->per_prenom;
	}
	public function getPerTel() {
		return $this->per_tel;
	}
	public function getPerMail() {
		return $this->per_mail;
	}
	public function getPerLogin() {
		return $this->per_login;
	}
	public function getPerPwd() {
		return $this->per_pwd;
	}
	
	public static function cryptPWD($pwd) {
		return sha1(sha1(Personne::encodeToUTF8($pwd)).Personne::encodeToUTF8(SALT));
	}
	public static function encodeToUTF8($string) {
		return mb_convert_encoding($string, 'UTF-8');
	}

	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'per_num':
					$this->setPerNum($valeur);
					break;
				case 'per_nom':
					$this->setPerNom($valeur);
					break;
				case 'per_prenom':
					$this->setPerPrenom($valeur);
					break;
				case 'per_tel':
					$this->setPerTel($valeur);
					break;
				case 'per_mail':
					$this->setPerMail($valeur);
					break;
				case 'per_login':
					$this->setPerLogin($valeur);
					break;
				case 'per_pwd':
					$this->setPerPwd($this->cryptPWD($valeur));
					break;
			}
		}
	}
}
?>
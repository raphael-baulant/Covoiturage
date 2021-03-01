<?php
class Salarie {
	private $per_num;
	private $sal_telprof;
	private $fon_num;
	
	public function __construct($valeurs) {
		if (!empty($valeurs)) {
			$this->affecte($valeurs);
		}
	}
	
	public function setPerNum($per_num) {
		$this->per_num = $per_num;
	}
	public function setSalTelprof($sal_telprof) {
		$this->sal_telprof = $sal_telprof;
	}
	public function setFonNum($fon_num) {
		$this->fon_num = $fon_num;
	}
	
	public function getPerNum() {
		return $this->per_num;
	}
	public function getSalTelprof() {
		return $this->sal_telprof;
	}
	public function getFonNum() {
		return $this->fon_num;
	}
	
	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'per_num':
					$this->setPerNum($valeur);
					break;
				case 'sal_telprof':
					$this->setSalTelprof($valeur);
					break;
				case 'fon_num':
					$this->setFonNum($valeur);
					break;
			}
		}
	}
}
?>
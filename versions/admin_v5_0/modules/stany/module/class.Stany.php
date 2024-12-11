<?php
class Stany extends Main {

	public function __construct() {
		parent::__construct();
		
		if ($this->en->IsLoggedIn() == true) {
			//aktywna zakładka
			$this->tpl->assign("activetab", "");
		}
		
		$this->Cron();
	}

	private function Cron() {
		$data = date("Y-m-d");
		$spr = $this->en->select_r("SELECT id FROM ".TABLE_PREFIX."magazyn_stany WHERE data = '".$data."'");
		if($spr['id'] > 0) {
			return false;
		}
		
		$dane = $this->en->select_r("SELECT SUM(sa.quantity) as stan
		FROM `".TABLE_PREFIX."product` p
		LEFT JOIN `".TABLE_PREFIX."stock_available` sa ON sa.id_product = p.id_product
		WHERE sa.id_product_attribute=0");
		
		$res = $this->en->query("INSERT INTO ".TABLE_PREFIX."magazyn_stany(data, stan) VALUES('".$data."', ".intval($dane['stan']).")");
		return false;
	}
}
?>
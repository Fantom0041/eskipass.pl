<?php
class Roles extends Main {

	public function __construct() {
		parent::__construct();
		
		if ($this->en->IsLoggedIn() == true) {
			//aktywna zakładka
			$this->tpl->assign("activetab", MODULE);
		}
		
		$this->tpl->assign("serwisy",$this->GetServices());
		
		switch($_GET['method']) {
			case 'list':
				$this->ListRole();
				break;
			
			case 'edit':
				$id=intval($_GET['id']);
							
				if($id>0) {
					$this->EditRola($_POST, $id);
				} 
				break;
				
		}
		
		
	}

	public function ListRole() {
		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[role]=="w") {
				$dane=$this->GetRole();
				$this->tpl->assign('dane',$dane);
			} else {
				$this->error=array("noperm"=>1);
				$this->tpl->display('templ_login.tpl.php');
				return false;
			} 

			if(count($this->error)>0) 
				$this->tpl->assign('err',$this->app->DisplayError($this->error));

			$this->tpl->display('modules/'.MODULE.'/views/'.MODULE.'.tpl.php');
		} else {
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}

	public function GetRole() {
		$dane=$this->en->select("SELECT round(id) as id, nazwa, skrot FROM ".TABLE_PREFIX."uzytkownik_role ORDER BY id ASC");
		return $dane;
	}

	public function EditRola($vars, $id) {
		$niebrac=array("id","nazwa","skrot","save");
		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[role]=="w") {
				if($id>0) {
					if($vars[save]!="") {
						if($this->ValidFormRola($vars, $id)) {

							//save page in database
							$qry=sprintf("UPDATE ".TABLE_PREFIX."uzytkownik_role SET nazwa='%s', skrot='%s' WHERE id=%d LIMIT 1",
							$this->en->Escape($vars[nazwa]),
							$this->en->Escape($vars[skrot]),
							$id
							);
							$res=$this->en->query($qry);

							foreach($vars as $k=>$w) {
								if(!in_array($k,$niebrac)) {
									$qry=sprintf("UPDATE ".TABLE_PREFIX."uzytkownik_role SET ".$k."='%s' WHERE id=%d LIMIT 1",
									$this->en->Escape($w),
									$id
									);
									$res=$this->en->query($qry);
								}
							}

							//postback
							$res=$this->en->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik_role WHERE id=".$id." LIMIT 1");
							$res[0][id]=round($res[0][id]);
							$postback=$res[0];
							$postback['updateok']=1;
							$this->tpl->assign('postback',$res[0]);
							
							$this->tpl->assign('update',true);

							//log
							$this->en->LogInsert("editrola",$id,$this->lang['class.Users.php.perm']);

						} else {
							$this->tpl->assign('postback',$vars);
						} 

					} else {

						//postback
						$res=$this->en->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik_role WHERE id=".$id." LIMIT 1");
						$res[0][id]=round($res[0][id]);
						$this->tpl->assign('postback',$res[0]);

					} 
				} else {
					$this->error=array("wrong_id"=>1);
				} 
			} else {
				$this->error=array("noperm"=>1);
				$this->tpl->display('views/templ_login.tpl.php');
				return false;
			} 

			//form elements
			$uprpola=array();
			$pola=$this->en->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik_role WHERE id=".$id." LIMIT 1");
			$pola=$pola[0];
			foreach($pola as $k=>$w) if(!in_array($k,$niebrac)) $uprpola[]=array("k"=>$k,"w"=>$w);
			$this->tpl->assign("uprpola", $uprpola);

			if(count($this->error)>0) 
				$this->tpl->assign('err',$this->app->DisplayError($this->error));

			$this->tpl->display('modules/'.MODULE.'/views/edit'.MODULE.'.tpl.php');
		} else {
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}

	private function ValidFormRola($vars) {
		$err=array();
		//check variables
		if($vars[nazwa]=="") $err[nazwa]=1;
		if($vars[skrot]=="") $err[skrot]=1;

		if(count($err)==0) {
			return true;
		} else {
			$this->error=$err;
			return false;
		} 
	}
	
}
?>
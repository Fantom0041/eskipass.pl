<?php
class Users extends Main {

	public function __construct() {
		parent::__construct();
		
		if ($this->en->IsLoggedIn() == true) {
			//aktywna zakładka
			$this->tpl->assign("activetab", MODULE);
		}
		
		$this->tpl->assign("serwisy",$this->GetServices());
		
		switch($_GET['method']) {
			case 'list':
				$this->ListUsers(intval($_GET['upr']));
				break;
			case 'add':
				$this->AddUser($_POST);
				break;
			case 'edit':
				$id=intval($_GET['id']);
				$del=intval($_GET['del']);
						
				if($id>0) {
					$this->EditUser($_POST, $id);
				} elseif($del>0) {
					$this->DeleteUser($del);
				}
				break;
			case 'ajax':
				echo $this->ListUsersAjax($_GET,10,1);
				break;

		}
		
		
	}

	public function ListUsers($upr) {

		if($upr==0) $upr=100;
		$this->tpl->assign('upr',$upr);

		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[users]=="w") {

				$role=$this->GetRole();
				$this->tpl->assign('role',$role);
			} else {
				$this->error=array("noperm"=>1);
				$this->tpl->display('templ_login.tpl.php');
				return false;
			} 

			if(count($this->error)>0) 
				$this->tpl->assign('err',$this->app->DisplayError($this->error));

			$this->tpl->display('modules/'.MODULE.'/views/'.MODULE.'.tpl.php');
			
			
			if($_GET['getcsv']==1) {
				$dane=$this->en->select("SELECT u.id, u.email, u.imie, u.nazwisko, um.imie as mimie, um.nazwisko as mnazwisko FROM ".TABLE_PREFIX."uzytkownik u 
				LEFT JOIN ".TABLE_PREFIX."uzytkownik_meta um ON um.item=u.id 
				ORDER BY u.id");
				
				foreach($dane as $d) {
					echo '"'.$d['email'].'","'.($d['imie']!='' ? $d['imie'] : $d['mimie']).'","'.($d['nazwisko']!='' ? $d['nazwisko'] : $d['mnazwisko']).'"<br />';
				}
			}
		} else {
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}
	
	public function ListUsersAjax($vars,$strcount=10,$s=1) {
		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[users]=="w" || $this->perm[users]=="r") {
				
				$rustart = getrusage();
				
				if ( isset( $vars['iDisplayStart'] ) && $vars['iDisplayLength'] != '-1' )
				{
					$s=floor(intval($vars['iDisplayStart'])/intval($vars['iDisplayLength']))+1;
					$strcount = intval($vars['iDisplayLength']);
				}
				if($s==0) $s=1;
				if($strcount==0) $strcount=10;
				
				if($vars['upr']==0) $vars['upr']=100;
				$dane=$this->en->select("SELECT round(u.id) as id, u.nazwa_uzytkownika, u.email, u.imie, u.nazwisko, r.nazwa FROM ".TABLE_PREFIX."uzytkownik u LEFT JOIN ".TABLE_PREFIX."uzytkownik_role r ON r.id=u.uprawnienia WHERE u.uprawnienia=".$vars['upr']." ORDER BY u.nazwa_uzytkownika");
				
				
				
				$dane_return = array();
				for($i=0;$i<count($dane);$i++) {
					
					
					/* 
					* Filtering
					* NOTE this does not match the built-in DataTables filtering which does it
					* word by word on any field. It's possible to do here, but concerned about efficiency
					* on very large tables, and MySQL's regex functionality is very limited
					*/
					if ( isset($vars['sSearch']) && $vars['sSearch'] != "" )
					{
						$dodawaj = false;
						if (strpos($this->add->ToLower($dane[$i]['nazwa_uzytkownika'].' '.$dane[$i]['email'].' '.$dane[$i]['imie'].' '.$dane[$i]['nazwisko']), $this->add->ToLower($vars['sSearch'])) !== false) $dodawaj=true;
						
						if($dodawaj) $dane_return[] = $dane[$i];
					} else {
						$dane_return[] = $dane[$i];
					}
				}
				
                                 
				$total = count($dane_return);
				$totalall = count($dane);
				
				$aColumns = array(
				  'id',
				  'id',
				  'nazwa_uzytkownika',
				  'nazwisko',
				  'nazwa',
				  'id'
				);
				
				
	
				/*
				* Ordering
				* msort($array, $id="id", $sort_ascending=true)
				*/
				/*
				$sOrder = array(
				  "col" => "sort_data",
				  "asc" => false
				);
				
				if ( isset( $vars['iSortCol_0'] ) )
				{
					for ( $i=0 ; $i<intval( $vars['iSortingCols'] ) ; $i++ )
					{
						if ( $vars[ 'bSortable_'.intval($vars['iSortCol_'.$i]) ] == "true" )
						{
							$sOrder = array(
							  "col" => $aColumns[ intval( $vars['iSortCol_'.$i] ) ],
							  "asc" => ($vars['sSortDir_'.$i]==='asc' ? true : false)
							);
						}
					}
				}
				
				$dane_return = $this->add->msort($dane_return, $sOrder['col'], $sOrder['asc']);
				*/
			
				
				$paginate=$this->add->PaginateSimple($dane_return, $strcount, $s);
				
				$output = array(
					"sEcho" => intval($vars['sEcho']),
					"iTotalRecords" => $totalall,
					"iTotalDisplayRecords" => $total,
					"aaData" => array()
				);
				
				for($i=0;$i<count($paginate['res']);$i++) {

				    $output['aaData'][]=array(
				      $paginate['res'][$i]['id'],
				      '<input type="checkbox" name="item['.$paginate['res'][$i]['id'].']" id="item_'.$paginate['res'][$i]['id'].'" />',
				      $paginate['res'][$i]['nazwa_uzytkownika'],
				      ($paginate['res'][$i]['nazwisko'] != '' || $paginate['res'][$i]['imie'] != '' ? $paginate['res'][$i]['nazwisko'].', '.$paginate['res'][$i]['imie'] : 'Brak danych' ),
				      $paginate['res'][$i]['nazwa'],
				      '<a href="admin.php?a='.MODULE.'_edit&id='.$paginate['res'][$i]['id'].'" class="btn" title="edytuj"><i class="icon-pencil"></i></a>'
				    );
				}
				
				//$this->tpl->assign('dane',$paginate[res]);
				//$this->tpl->assign('strony',$paginate[tabStr]);
				//$this->tpl->assign('strcount',$strcount);
				//$this->tpl->assign('s',$s);
				
				return json_encode($output);

			} else {
				$this->error=array("noperm"=>1);
				return json_encode(array('error'=>'no permission'));
			} 
		} else {
			return json_encode(array('error'=>'no permission'));
		} 
	}

	public function AddUser($vars) {
		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[users]=="w") {
				if($vars[save]!="") {
					if($this->ValidForm($vars)) {

						//save record in database
						$qry=sprintf("INSERT INTO ".TABLE_PREFIX."uzytkownik(nazwa_uzytkownika,md5_haslo,uprawnienia,email,imie,nazwisko,registerdate) " .
						"VALUES('%s','%s',%d,'%s','%s','%s',%d)",
						$this->en->Escape($vars[nazwa_uzytkownika]),
						md5($vars[newpwd].SALT),
						intval($vars[uprawnienia]),
						$this->en->Escape($vars[email]),
						$this->en->Escape($vars[imie]),
						$this->en->Escape($vars[nazwisko]),
						time()
						);
						$res=$this->en->query($qry);
						$insertID=intval($this->en->insertId());
						
				
						header("Location: admin.php?a=users_edit&id=".$insertID."&create=1");
				
						//log
						$this->en->LogInsert("editusers",$insertID,$this->lang['class.Users.php.add']);

					} else {
						$this->tpl->assign('postback',$vars);
					} 
				}
			} else {
				$this->error=array("noperm"=>1);
				$this->tpl->display('views/templ_login.tpl.php');
				return false;
			} 

			//form data
			$this->tpl->assign('dataUpr',$this->GetRole());

			if(count($this->error)>0) 
				$this->tpl->assign('err',$this->app->DisplayError($this->error));

			$this->tpl->display('modules/'.MODULE.'/views/edit'.MODULE.'.tpl.php');
		} else {
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}

	public function EditUser($vars, $id) {
		if ($this->en->IsLoggedIn() == true) {
			if($this->perm[users]=="w") {
				if($id>0) {
					if($vars[save]!="") {
						if($this->ValidForm($vars, $id)) {

							//save page in database
							$qry=sprintf("UPDATE ".TABLE_PREFIX."uzytkownik SET nazwa_uzytkownika='%s', uprawnienia=%d, email='%s', imie='%s', nazwisko='%s' WHERE id=%d LIMIT 1",
							$this->en->Escape($vars[nazwa_uzytkownika]),
							intval($vars[uprawnienia]),
							$this->en->Escape($vars[email]),
							$this->en->Escape($vars[imie]),
							$this->en->Escape($vars[nazwisko]),
							$id
							);
							$res=$this->en->query($qry);

							if($vars[newpwd]!="") $res=$this->en->query("UPDATE ".TABLE_PREFIX."uzytkownik SET md5_haslo='".md5($vars[newpwd].SALT)."' WHERE id=".$id." LIMIT 1");
							


							//postback
							$res=$this->en->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik WHERE id=".$id." LIMIT 1");

							$res[0][id]=round($res[0][id]);
							$postback=$res[0];
							$this->tpl->assign('postback',$postback);
							
							$this->tpl->assign('update',true);

							//log
							$this->en->LogInsert("editusers",$id,$this->lang['class.Users.php.edit']);

						} else {
							$vars[id]=$id;
							$this->tpl->assign('postback',$vars);
						} 
					} else {

						$res=$this->en->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik WHERE id=".$id." LIMIT 1");

						$res[0][id]=round($res[0][id]);
						$respostback=$res[0];
						$this->tpl->assign('postback',$respostback);

					} 
					
					//form data
					$this->tpl->assign('dataUpr',$this->GetRole());
					
					
					
				} else {
					$this->error=array("wrong_id"=>1);
				} 
			} else {
				$this->error=array("noperm"=>1);
				$this->tpl->display('views/templ_login.tpl.php');
				return false;
			} 

			

			if(count($this->error)>0) 
				$this->tpl->assign('err',$this->app->DisplayError($this->error));

			$this->tpl->display('modules/'.MODULE.'/views/edit'.MODULE.'.tpl.php');
		} else {
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}

	public function DeleteItem($id) {
		$res=$this->en->query("UPDATE ".TABLE_PREFIX."uzytkownik " .
		"SET uprawnienia=0, email=CONCAT(email,'-del'), nazwa_uzytkownika=CONCAT(nazwa_uzytkownika,'-del') " .
		"WHERE id=".$id." LIMIT 1");
		header("Location: admin.php?a=users&delete=1");
		//log
		$this->en->LogInsert("users",$id,$this->lang['class.Users.php.del']);
	}

	public function MultiDeleteItem($users) {
		if(count($users)>0) {
			foreach($users as $k=>$w) {
				if($w=="on") {
					$this->DeleteItem($k);
				}
			}
		}
	}

	

	private function ValidForm($vars, $id=0) {
		$err=array();
		//check variables
		if($vars[nazwa_uzytkownika]=="") $err[nazwa_uzytkownika]=1;
		if(strlen($vars[nazwa_uzytkownika])<3) $err[nazwa_uzytkownika]=2;
		if($vars[newpwd]!="") {
			if($vars[newpwd]!=$vars[newpwd2]) $err[newpwd]=2;
			if(strlen($vars[newpwd])<5) $err[newpwd]=3;
		}
		$spr=$this->en->select("SELECT count(id) as ile FROM ".TABLE_PREFIX."uzytkownik WHERE nazwa_uzytkownika='".$this->en->Escape($vars[nazwa_uzytkownika])."' AND id<>".$id);
		if($spr[0][ile]>0) $err[nazwa_uzytkownika]=3;

		$regemail = "/^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/";
		if (!preg_match($regemail, $vars[email])) $err[email]=1;

		if (intval($vars[uprawnienia])>100 || intval($vars[uprawnienia])==0) $err[uprawnienia]=1;

		if(count($err)==0) {
			return true;
		} else {
			$this->error=$err;
			return false;
		} 
	}
	
	private function GetRole() {
		$dane=$this->en->select("SELECT round(id) as id, nazwa, skrot FROM ".TABLE_PREFIX."uzytkownik_role ORDER BY id ASC");
		return $dane;
	}
	
}
?>
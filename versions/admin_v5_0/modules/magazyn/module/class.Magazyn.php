<?php
class Magazyn extends Main {

	public function __construct() {
		parent::__construct();
		
		if ($this->en->IsLoggedIn() == true) {
			//aktywna zakładka
			$this->tpl->assign("activetab", "magazyn");
			$this->tpl->assign("module", MODULE);
		}
		
		
		switch($_GET['method']) {
			case 'saveprice': echo $this->SavePrice(); break;
			case 'addprice': echo $this->AddPrice(); break;
			case 'delprice': echo $this->DelPrice(); break;
			case 'savequantity': echo $this->SaveQuantity(); break;
			case 'saveproduct': echo $this->SaveProduct(); break;
			case 'savemulti': echo $this->SaveMulti(); break;
			case 'saveallegro': echo $this->SaveAllegro(); break;
			
			case 'loadtable': echo $this->LoadTable(); break;
			
			case 'exportstany': $this->XLSStany(); break;
			case 'exportceny': $this->XLSCeny(); break;
			
			case 'list': 
			default: $this->DisplayMagazyn();
		}
	}

	private function DisplayMagazyn() {
		if ($this->en->IsLoggedIn() == true) {
		
			$dane = $this->LoadTableData($_GET['filters']);
			
			$s = intval($_GET['s']);
			if($s==0) $s=1;
			$paginate = $this->add->PaginateSimple($dane, 30, $s, "id_product");
			$this->tpl->assign("dane", $paginate['res']);
			$this->tpl->assign("pages", $paginate['tabStr']);
			$this->tpl->assign("s", $s);
			$this->tpl->assign("pagesurl", $this->PagesUrl($_GET['filters']));
			
			$this->tpl->assign("filters", $_GET['filters']);
			
			$meta = array();
			$meta['title'] = "Magazyn";
			$meta['css'] = '<link rel="stylesheet" href="'.THEMEDIR.'assets/vendor/editable-table/editable-table.css">';
			$meta['css'] .= '<link rel="stylesheet" href="'.THEMEDIR.'assets/vendor/toastr/toastr.css">';
			$meta['css'] .= '<link rel="stylesheet" href="'.THEMEDIR.'assets/vendor/icheck/icheck.css">';
			
			
			
			$this->tpl->assign("meta", $meta);
			$this->tpl->display('modules/'.MODULE.'/views/'.MODULE.'.tpl.php');
		} else {
			$meta = array();
			$meta['title'] = "Logowanie";
			$meta['css'] = '<link rel="stylesheet" href="'.THEMEDIR.'assets/css/pages/login.css">';
			$this->tpl->assign("meta", $meta);
			$this->tpl->display('views/templ_login.tpl.php');
		} 
	}
	
	private function XLSCeny() {
		$headers = array(
			'L.p.',
			'Nazwa'
		);
		$ft = $this->GetFeatures();
		foreach($ft as $f) {
			$headers[]=$f['name'];
		}
		
		
		$dane = $this->LoadTableData(array());
		$ileprogow = 0;
		for($i=0;$i<count($dane);$i++) {
			$ile = count($dane[$i]['sp']);
			if($ile>$ileprogow) $ileprogow = $ile;
		}
		
		//próg 1 na stałe
		$headers[]="Próg 1";
		$headers[]="Cena netto";
		$headers[]="Cena brutto";
		$headers[]="Cena Allegro";
		
		for($p=1;$p<=$ileprogow;$p++) {
			$headers[]="Próg ".($p+1);
			$headers[]="Cena netto";
			$headers[]="Cena brutto";
		}
		
		$return = array();
		$lp = 1;
		for($i=0;$i<count($dane);$i++) {
			$r = array();
			$r['lp'] = $lp;
			$r['name'] = $dane[$i]['name'];
			
			foreach($ft as $f) {
				$cecha = "";
				if(count($dane[$i]['ft']) > 0) {
					foreach ($dane[$i]['ft'] as $dft) 
						if ($dft['id_feature'] == $f['id_feature']) $cecha = $dft['value'];
				}
				$r[ $f['id_feature'] ]=$cecha;
			}
			
			$r['p1'] = "Od 1szt.";
			$r['p1n'] = round($dane[$i]['price'],4)."zł";
			$r['p1b'] = round($dane[$i]['price']*1.23,2)."zł";
			$r['p1a'] = round($dane[$i]['al']['price']*1.23*(1+($_GET['increase']/100)),2)."zł";
			
			for($p=0;$p<$ileprogow;$p++) {
				if(isset( $dane[$i]['sp'][$p] ) ) {
					$r['p'.($p+2)] = "Od ".$dane[$i]['sp'][$p]['from_quantity']."szt.";
					$r['p'.($p+2).'n'] = round($dane[$i]['sp'][$p]['price'],4)."zł";
					$r['p'.($p+2).'b'] = round($dane[$i]['sp'][$p]['price']*1.23,2)."zł";
				} else {
					$r['p'.($p+2)] = "";
					$r['p'.($p+2).'n'] = "";
					$r['p'.($p+2).'b'] = "";
				}
			}
			
			$return[]=$r;
			$lp++;
		}
		$this->CreateXLS($return,$headers,'Ceny');
	}
	
	private function XLSStany() {
		$headers = array(
			'L.p.',
			'Nazwa',
			'Stan magazynowy'
		);
		
		$ft = $this->GetFeatures();
		foreach($ft as $f) {
			$headers[]=$f['name'];
		}
		
		$dane = $this->LoadTableData(array());
		$return = array();
		$lp = 1;
		for($i=0;$i<count($dane);$i++) {
			$r = array();
			$r['lp'] = $lp;
			$r['name'] = $dane[$i]['name'];
			$r['quantity'] = $dane[$i]['quantity'];
			
			foreach($ft as $f) {
				$cecha = "";
				if(count($dane[$i]['ft']) > 0) {
					foreach ($dane[$i]['ft'] as $dft) 
						if ($dft['id_feature'] == $f['id_feature']) $cecha = $dft['value'];
				}
				$r[ $f['id_feature'] ]=$cecha;
			}
			$return[]=$r;
			$lp++;
		}
		
		$this->CreateXLS($return,$headers,'StanyMagazynowe');
	}
	
	private function LoadTable() {
		if ($this->en->IsLoggedIn() == true) {
			$filters = array(
			      "fname"=>$_POST['fname']
			);
			$dane = $this->LoadTableData($filters);
			
			$s = intval($_POST['s']);
			if($s==0) $s=1;
			$paginate = $this->add->PaginateSimple($dane, 30, $s, "id_product");
			$this->tpl->assign("dane", $paginate['res']);
			$this->tpl->assign("pages", $paginate['tabStr']);
			$this->tpl->assign("s", $s);
			$this->tpl->assign("pagesurl", $this->PagesUrl( $filters ));
			$this->tpl->assign("filters", $filters);

			return $this->tpl->fetch('modules/'.MODULE.'/views/table.tpl.php');
		}
	}
	
	private function AddPrice() {
		$return = array();
		if($_POST['product'] > 0) {
			$this->en->query("INSERT INTO `".TABLE_PREFIX."specific_price` (`id_specific_price_rule`, `id_cart`, `id_product`, `id_shop`, `id_shop_group`, `id_currency`, `id_country`, `id_group`, `id_customer`, `id_product_attribute`, `price`, `from_quantity`, `reduction`, `reduction_type`) 
			VALUES(0,0,".intval($_POST['product']).",0,0,0,0,0,0,0,0.00,0,0.00,'amount')");
			$id = $this->en->insertId();
			
			if($id > 0) {
				$return['status'] = true;
				$return['row'] = array(
					"id_product"=>intval($_POST['product']),
					"id_specific_price"=>$id
				);
			} else {
				$return['status'] = false;
				$return['err'] = 'Nieudane dodanie rekordu do bazy danych';
			}
		} else {
			$return['status'] = false;
			$return['err'] = 'Błędny identyfikator produktu';
		}
		
		return json_encode($return);
	}
	
	private function SavePrice() {
		$return = array();
		if($_POST['sp'] > 0) {
			$this->en->query("UPDATE `".TABLE_PREFIX."specific_price` SET `".$this->en->Escape($_POST['field'])."` = ".floatval($_POST['value'])." WHERE `id_specific_price`=".intval($_POST['sp'])." LIMIT 1");
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Nie udało się zapisać zmian';
		}
		
		return json_encode($return);
	}
	
	private function SaveQuantity() {
		$return = array();
		if($_POST['stockavailable'] > 0) {
			$this->en->query("UPDATE `".TABLE_PREFIX."stock_available` SET `".$this->en->Escape($_POST['field'])."` = ".floatval($_POST['value'])." WHERE `id_stock_available`=".intval($_POST['stockavailable'])." LIMIT 1");
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Nie udało się zapisać zmian';
		}
		
		return json_encode($return);
	}
	
	private function SaveProduct() {
		$return = array();
		if($_POST['product'] > 0) {
			$this->en->query("UPDATE `".TABLE_PREFIX."product` SET `".$this->en->Escape($_POST['field'])."` = ".floatval($_POST['value'])." WHERE `id_product`=".intval($_POST['product'])." LIMIT 1");
                                                      $this->en->query("UPDATE `".TABLE_PREFIX."product_shop` SET `".$this->en->Escape($_POST['field'])."` = ".floatval($_POST['value'])." WHERE `id_product`=".intval($_POST['product'])." ");
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Nie udało się zapisać zmian';
		}
		
		return json_encode($return);
	}
	
	private function SaveAllegro() {
		$return = array();
		if($_POST['product'] > 0) {
			$spr = $this->en->select_r("SELECT * FROM `".TABLE_PREFIX."magazyn_allegro` WHERE `id_product`=".intval($_POST['product'])." LIMIT 1");
			if($spr['id_product']>0) {
				$this->en->query("UPDATE `".TABLE_PREFIX."magazyn_allegro` SET `".$this->en->Escape($_POST['field'])."` = ".floatval($_POST['value'])." WHERE `id_product`=".intval($_POST['product'])." LIMIT 1");
			} else {
				$this->en->query("INSERT INTO `".TABLE_PREFIX."magazyn_allegro` (`".$this->en->Escape($_POST['field'])."`, `id_product`) VALUES (".floatval($_POST['value']).", ".intval($_POST['product']).")");
			}
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Nie udało się zapisać zmian';
		}
		
		return json_encode($return);
	}
	
	private function DelPrice() {
		$return = array();
		if($_POST['price'] > 0) {
			$this->en->query("DELETE FROM `".TABLE_PREFIX."specific_price` WHERE `id_specific_price`=".intval($_POST['price'])." LIMIT 1");
			
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Błędny identyfikator wariantu cenowego';
		}
		
		return json_encode($return);
	}
	
	private function SaveMulti() {
		$return = array();
		$filters = array();
		if($_POST['pname'] != "") $filters['pname'] = $_POST['pname'];
		
		$ok = false;
		
		switch($_POST['act']) {
			case 'all': break;
			case 'allpage': 
			case 'selected': 
			$ids = array();
			if(count($_POST['products'])>0) {
				foreach($_POST['products'] as $k => $product) {
					$ids[]=$product;
				}
				$filters['id'] = $ids;
			}
			break;
		}
		
		$products = $this->LoadTableData($filters);
		
		for($i=0;$i<count($products);$i++) {
			switch($_POST['action']) {
				case 'allpricechange': 
					$field = "price";
					$value = floatval($_POST['value']);
					if($_POST['method'] == "procent") {
						$value = "( ROUND(`".$field."` * (".$value.")) / 100 )";
					}
					$this->en->query("UPDATE `".TABLE_PREFIX."specific_price` SET `".$field."` = `".$field."` + ".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." AND `reduction_type`='amount'");
					
					$field = "price";
					$value = floatval($_POST['value']);
					if($_POST['method'] == "procent") {
						$value = round( ($products[$i]['price'] * $value)/100 ,2);
					}
					if($value > 0) $value="+".$value;
					
					$this->en->query("UPDATE `".TABLE_PREFIX."product` SET `".$field."` = `".$field."`".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." LIMIT 1");
                                                                                          $this->en->query("UPDATE `".TABLE_PREFIX."product_shop` SET `".$field."` = `".$field."`".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." ");
					$ok = true;
				break;
				case 'spricechange': 
					$field = "price";
					$value = floatval($_POST['value']);
					if($_POST['method'] == "procent") {
						$value = "( ROUND(`".$field."` * (".$value.")) / 100 )";
					}
					$this->en->query("UPDATE `".TABLE_PREFIX."specific_price` SET `".$field."` = `".$field."` + ".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." AND `reduction_type`='amount'");
					$ok = true;
				break;
				case 'pricechange': 
					$field = "price";
					$value = floatval($_POST['value']);
					if($_POST['method'] == "procent") {
						$value = round( ($products[$i]['price'] * $value)/100 ,2);
					}
					if($value > 0) $value="+".$value;
					
					$this->en->query("UPDATE `".TABLE_PREFIX."product` SET `".$field."` = `".$field."`".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." LIMIT 1");
					$ok = true;
				break;
				case 'qtychange': 
					$field = "quantity";
					$value = intval($_POST['value']);
					if($value > 0) $value="+".$value;
					$this->en->query("UPDATE `".TABLE_PREFIX."stock_available` SET `".$field."` = `".$field."`".$value." WHERE id_product=".intval( $products[$i]['id_product'] )." AND id_product_attribute=0 LIMIT 1");
					$ok = true;
				break;
			}
		}
		
		
		if($ok) {
			$return['status'] = true;
		} else {
			$return['status'] = false;
			$return['err'] = 'Nie udało się zapisać zmian';
		}
		
		return json_encode($return);
	}
	
	private function LoadTableData($filters) {
		$q = array();
		$q[] = "1=1";
		if($filters['pname']!="") $q[] = "LOWER(pl.name) LIKE '%".$this->en->Escape($this->add->ToLower(urldecode($filters['pname'])))."%'";
		if(count($filters['id']) > 0) $q[] = "p.id_product IN (".implode(",",$filters['id']).")";
		
		$dane = $this->en->select("SELECT p.id_product, p.price, pl.name
				FROM `".TABLE_PREFIX."product` p
				LEFT JOIN `".TABLE_PREFIX."product_lang` pl ON p.id_product=pl.id_product
				WHERE ".implode(" AND ", $q)." AND pl.id_lang = 1 
				ORDER BY 
				SUBSTRING_INDEX(SUBSTRING_INDEX(pl.name, ' ', 1), ' ', -1) ASC, 
				CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(   TRIM( SUBSTR(pl.name, LOCATE(' ', pl.name)) )   , 'x', 1), 'x', -1) AS SIGNED) ASC,
				CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(   TRIM( SUBSTR(pl.name, LOCATE(' ', pl.name)) )   , 'x', 2), 'x', -1) AS SIGNED) ASC,
				CAST( SUBSTRING_INDEX(SUBSTRING_INDEX(   TRIM( SUBSTR(pl.name, LOCATE(' ', pl.name)) )   , 'x', 3), 'x', -1) AS SIGNED) ASC,
				p.id_product ASC");
		
		$return = array();
		$ile = count($dane);
		for($i=0;$i<$ile;$i++) {
			$sp = $this->en->select("SELECT id_specific_price, price, from_quantity 
				FROM `".TABLE_PREFIX."specific_price`
				WHERE id_product=".intval( $dane[$i]['id_product'] )." AND `reduction_type`='amount' 
				ORDER BY from_quantity ASC");
				
			if(count($sp) > 0) {
				for($sss=0;$sss<count($sp); $sss++) $sp[$sss]['price_brutto'] = round( $sp[$sss]['price'] *1.23 ,2);
			}
				
			$qt = $this->en->select_r("SELECT id_stock_available, quantity
				FROM `".TABLE_PREFIX."stock_available`
				WHERE id_product=".intval( $dane[$i]['id_product'] )." AND id_product_attribute=0");
			
			$al = $this->en->select_r("SELECT *
				FROM `".TABLE_PREFIX."magazyn_allegro`
				WHERE id_product=".intval( $dane[$i]['id_product'] ));
			if($al['price'] > 0) $al['price_brutto'] = round($al['price']*1.23 ,2);
			
			$ft = $this->en->select("SELECT fvl.value, fl.name, fp.id_feature_value, fp.id_feature
				FROM `".TABLE_PREFIX."feature_product` fp 
				LEFT JOIN ".TABLE_PREFIX."feature_value_lang fvl ON fvl.id_feature_value = fp.id_feature_value
				LEFT JOIN ".TABLE_PREFIX."feature_lang fl ON fl.id_feature = fp.id_feature
				WHERE fp.id_product=".intval( $dane[$i]['id_product'] ) ." AND fvl.id_lang=1 AND fl.id_lang=1");
				
			$return[] = array(
				"id_product" => $dane[$i]['id_product'],
				"price" => $dane[$i]['price'],
				"price_brutto" => round($dane[$i]['price']*1.23 ,2),
				"name" => $dane[$i]['name'],
				"id_stock_available" => $qt['id_stock_available'],
				"quantity" => $qt['quantity'],
				"sp" => $sp,
				"ft" => $ft,
				"al" => $al
			);
		}
		return $return;
	}
	
	private function GetFeatures() {
		$ft = $this->en->select("SELECT fl.id_feature, fl.name 
				FROM `".TABLE_PREFIX."feature_lang` fl 
				LEFT JOIN ".TABLE_PREFIX."feature f ON fl.id_feature = f.id_feature 
				WHERE fl.id_lang=1
				ORDER BY f.position ASC");
		return $ft;
	}
	
	private function PagesUrl($filters) {
		$url = SITE_URL.MODULE."/list?";
		if($filters['pname'] != "") $url.="filters[pname]=".$filters['pname']."&";
		return $url;
	}
	
	private function CreateXLS($dane,$headers,$raport_name) {
		$literki = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ');
		// Create new PHPExcel object
		require_once(SMARTY_DIR.'PHPExcel/PHPExcel.php');
		$objPHPExcel = new PHPExcel();

		// Set properties
		// Set properties
		$objPHPExcel->getProperties()->setCreator("eSkipass")
					      ->setLastModifiedBy("eSkipass")
					      ->setTitle("eSkipass")
					      ->setSubject("eSkipass")
					      ->setDescription("eSkipass")
					      ->setKeywords("eSkipass")
					      ->setCategory("eSkipass");


		$wiersz = 1;
		//zrzut ekranów
		foreach($headers as $kh=>$header) $objPHPExcel->setActiveSheetIndex(0)->setCellValue($literki[$kh].$wiersz, $header);
			    
		$wiersz++;
		if(is_array($dane) && count($dane)>0) {
		  foreach($dane as $k=>$d) {
		  	$item=0;
		  	if(substr($k, -2) == "_d") {
				$styleArray = array(
				'font'  => array(
				    'color' => array('rgb' => '880000')
				));
		  	} else {
				if(isset($styleArray)) unset($styleArray);
		  	}
			
			
			
		  	foreach($d as $dd) { 
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($literki[$item].$wiersz, $dd); 
				if(isset($styleArray)) $objPHPExcel->getActiveSheet()->getStyle($literki[$item].$wiersz)->applyFromArray($styleArray);
				$item++; 
		  	}
		    $wiersz++;
		  }
		}
		$objPHPExcel->getActiveSheet()->setTitle($raport_name);
		
		$file_name = 'data/export/'.$raport_name.'_'.date("Y-m-d-H-i-s").'.xls';
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save($file_name);

		set_time_limit(0);	
		$this->output_file($file_name, basename($file_name));
		
		return false;
	}
	
	private function output_file($file, $name, $mime_type='')
	{
		/*
		This function takes a path to a file to output ($file), 
		the filename that the browser will see ($name) and 
		the MIME type of the file ($mime_type, optional).
		
		If you want to do something on download abort/finish,
		register_shutdown_function('function_name');
		*/
		if(!is_readable($file)) die('File not found or inaccessible!');
		
		$size = filesize($file);
		$name = rawurldecode($name);
		
		/* Figure out the MIME type (if not specified) */
		$known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
		);
		
		if($mime_type==''){
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			if(array_key_exists($file_extension, $known_mime_types)){
				$mime_type=$known_mime_types[$file_extension];
			} else {
				$mime_type="application/force-download";
			};
		};
		
		@ob_end_clean(); //turn off output buffering to decrease cpu usage
		
		// required for IE, otherwise Content-Disposition may be ignored
		if(ini_get('zlib.output_compression'))
		  ini_set('zlib.output_compression', 'Off');
		
		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');
		
		/* The three lines below basically make the 
		    download non-cacheable */
		header("Cache-control: private");
		header('Pragma: private');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
		// multipart-download and download resuming support
		if(isset($_SERVER['HTTP_RANGE']))
		{
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}
		
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		} else {
			$new_length=$size;
			header("Content-Length: ".$size);
		}
		
		/* output the file itself */
		$chunksize = 1*(1024*1024); //you may want to change this
		$bytes_send = 0;
		if ($file = fopen($file, 'r'))
		{
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);
		
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
			      )
			{
				$buffer = fread($file, $chunksize);
				print($buffer); //echo($buffer); // is also possible
				flush();
				$bytes_send += strlen($buffer);
			}
		fclose($file);
		} else die('Error - can not open file.');
		
		die();
	}
}
?>
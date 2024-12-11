<?php

class tools {

    public static $en = '';
    public static $urlparams = '';

    public static function __activate($baza, $vars) {
        self::$en = &$baza;
        self::$urlparams = &$vars;
    }

    /**
     * Zamienia dane GPS z formatu 12345678 do formatu 12.345678
     * @param int $gps Dane gps
     * @return float 
     */
    public static function GPSFromDB($gps) {
        $gps = $gps / 1000000;
        return $gps;
    }

    /**
     * Zamienia dane GPS z formatu 12.345678 do formatu 12345678 (zapis w DB)
     * @param float/string $gps
     * @return int
     */
    public static function GPSToDB($gps) {
        $gps = round($gps * 1000000);
        return $gps;
    }

    /**
     * Zwraca tablicę z ID obiektów usera
     * @param int $userid ID Usera
     * @param string $table Nazwa tabeli (typ obiektu)
     * @return array
     */
    public static function GetUserObjects($userid, $table = 'accommodation') {
//        if (!$en)
//            $en = $this->en;
        $tblname = self::$en->Escape($table);
        $r = self::$en->get_filtered_rows($tblname, 'id', array(array('id_user', $userid, 'INT')));
        if (self::$en->num_rows() > 0) {
            foreach ($r as $v) {
                $o[] = $v['id'];
            }
        } else
            $o = array();
        return $o;
    }

    /**
     * Wczytuje listę 'facilities' udogodnien
     * @param string $table Nazwa tabeli
     * @return array
     * @return false
     * @return null
     */
    public static function GetFacilities($table = 'accommodation_facilities') { 
//        if (!$en)
//            $en = $this->en;
        $tblname = $table . '_' . LANG;
        $fields = '*';
        return self::$en->get_filtered_rows($tblname, $fields);
    }

    /**
     * Pobiera listę 'facilities' przypisanych do obiektu
     * @param int $item_id ID obiektu
     * @return type
     */
    public static function GetObjectFacilities($module, $item_id) {
        $r = array();
		
		switch($module) {
			case 'service_specialities':
				$table_1 = TABLE_PREFIX.'service_specialities_new';
				$table_2 = TABLE_PREFIX.'service_specialities';
				break;
			default:
				$table_1 = TABLE_PREFIX.$module.'_facilities_new';
				$table_2 = TABLE_PREFIX.$module.'_facilities';
		}
		
        $sql = "SELECT n.f_id, f.name 
                FROM " . $table_1 ." n, " . $table_2." f 
                WHERE f.f_id = n.f_id AND n.item_id = " . $item_id . " AND f.lang_id=" . LANG;

        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $r[] = $w['f_id'];
            }
        }

        return $r;
    }

    /**
     * Pobiera listę tagów obiektu
     */
    public static function GetObjectTags($module, $item_id) {
        $r = array();
        
        $module = self::$en->Escape($module);
        
        $sql = "SELECT id_tag, name, color FROM ".TABLE_PREFIX.$module."_tags_objects_".LANG." WHERE id_object = {$item_id}";
        
        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $r[] = $w['id_tag'];
            }
        }
        
        return $r;
    }
    
    /**
     * Pobiera wszystkie dostępne tagi dla modułu
     */
    public static function GetTags($module) {
        $r = array();
        $module = self::$en->Escape($module);
        
        $sql = "SELECT type_id, name, color FROM ".TABLE_PREFIX.$module."_tags_".LANG." WHERE lang_id=".LANG;
        
        $r = self::$en->select($sql);
        
        return $r;
    }
    
	/**
	 *	Kasuje wyspossazenie dla obiektu
	 */
	 public static function deleteObjectFacilities($table, $id) {
		$objectid = intval($id);
		self::$en->query('DELETE FROM ' . $table . ' WHERE item_id = ' . $objectid);		
	 }
	 
    /**
     * Aktualizuje tabele wyposezen dla obiektu
     * @param array $facilities Przeslane wyposazenia
     * @param int $objectid ID obiektu
     */
    public static function checkFacilities($module, $facilities, $objectid) { 
        $objectid = intval($objectid);
        $cond[] = array('item_id', $objectid, 'INT');
		
		switch($module) {
			case 'service_specialities':
				$table = TABLE_PREFIX.'service_specialities_new';
				break;
			default:
				$table = TABLE_PREFIX.$module.'_facilities_new';
		}

        $count = self::$en->get_field_val($table, 'COUNT(id)', $cond);

        if (intval($count) > 0) {
            self::deleteObjectFacilities($table, $objectid);
        }

        if (count($facilities) > 0) {
            foreach ($facilities as $k => $v) {
                $params = array(
                    array('f_id', $v, 'INT'),
                    array('item_id', $objectid, 'INT')
                );
                self::$en->insert_row($table, $params);
            }
        }
    }

    /**
     * Zwraca rodzaje usług (lista) dla danego typu usług np: hotel, motel lub restauracja, bar...
     * @param string $table Nazwa tabeli
     * @return type
     */
    public static function GetAccommodationTypes($table = 'accommodation_types') {
        $tblname = $table . '_' . LANG;
        $fields = '*';
        return self::$en->get_filtered_rows($tblname, $fields);
    }

    /**
     * Pobiera listę ofert (Accommodation) zalogowanego usera
     * @param string $table Nazwa tabeli z listą obiektów
     * @param string $id_user Nazwa tabeli z listą obiektów
     * @return array Tablica get_filtered_row
     */
    public static function GetOffersList($table = 'accommodation', $all_users = false) {		
	/*
        $tblname = $table . '_' . LANG;
        $fields = '*';
        if ($all_users === false) {
            $cond[] = array('id_user', self::$en->GetUserID(), 'INT');
        } else
            $cond = false;
		
		if( self::$en->GetUserPerm() == 4 && $table == 'resorts' ) {
			
		}
		
        return self::$en->get_filtered_rows($tblname, $fields, $cond, 'objectname_short|ASC', null, false);
	*/
		$tblname = $table . '_' . LANG;
		$sql = "SELECT m.* FROM ".TABLE_PREFIX.$tblname." m";
		
		if( self::$en->GetUserPerm() == 4 && $table == 'resorts' ) {
			$sql .= " LEFT JOIN ".TABLE_PREFIX."resorts_perm p ON m.id = p.resort WHERE p.user=".self::$en->GetUserID();
		}
		
		if ($all_users === false) {
			$sql .= " WHERE m.id_user = ".self::$en->GetUserID();
		}
		
		return self::$en->select( $sql );
    }
	
	/**
	 * Sprawdza czy dany osrodek jest przypisany do miniadmina
	 */
	public static function CheckMiniAdminResort($resort_id, $user, $en=null) {
		if(!self::$en){
			self::$en = $en;
		}
		
		$resort_id = intval($resort_id);
		$user = intval($user);
		
		if( self::$en->GetUserPerm() == 100 ){ return true; }
	
		$valid = self::$en->select_r("SELECT COUNT(id) AS 'ile' FROM ".TABLE_PREFIX."resorts_perm WHERE user=".$user." AND resort=".$resort_id);

		if( intval($valid['ile']) > 0 ) { return true; }
		
		return false;
	}
	
	/**
	 * Pobiera listę ofert zarządzających przez zalogowanego mini admina
	 */
	public static function GetOffersMiniList($module, $user_id) {
		$user = intval($user_id);
		
		$sql = "SELECT ta.* FROM ".TABLE_PREFIX."manage tm
				LEFT JOIN ".TABLE_PREFIX.$module." ta ON tm.item = ta.id
				WHERE tm.module = '".$module."' AND tm.user = ".$user."";

		return self::$en->select($sql);
	}
	
	/**
	 *	Sprawdza czy wybrana oferta jest przypisana do mini admina
	 */
	public static function isOfferMiniAdmin($module, $user, $item, $en = null){
		if(!self::$en){
			self::$en = $en;
		}
		
		$item = intval($item);
		$user = intval($user);
		
		$where[] = array('module', $module, 'STRING');
		$where[] = array('item', $item, 'INT');
		$where[] = array('user', $user, 'INT');
		
		$ile = self::$en->get_field_val(TABLE_PREFIX."manage", "COUNT(id)", $where);
		
		if(intval($ile) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Sprawdza czy można usunąć zdjęcie w przypadku mini admina
	 */
	public static function isPhotoMiniAdmin($module, $user, $photoid, $en=null){
		if(!self::$en){
			self::$en = $en;
		}
		
		$user = intval($user);
		$photoid = intval($photoid);
		
		$sql = "SELECT COUNT( t1.id ) AS  'i' FROM ".TABLE_PREFIX.$module."_meta t1
				LEFT JOIN ".TABLE_PREFIX."manage t2 ON t1.id_object = t2.item
				WHERE t1.id = ".$photoid." AND t2.module = '".$module."' AND t2.user = {$user}";		
		$count = self::$en->select_r($sql);
		
		if(intval($count['i']) > 0){
			return true;
		}
		return false;
	}
		 
    /**
     * Pobiera listę ofert uzytkownika w postaci modul:id_oferty
     */
    public static function GetOfferToAbonament() {
        $offers = array();
        $cond = array(array('id_user', self::$en->GetUserID(), 'INT'));

        //noclegi
        $acco = self::$en->get_filtered_rows('accommodation', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['accommodation'] = $acco;

        //gastronomia
        $service = self::$en->get_filtered_rows('service', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['service'] = $service;

        //wydarzenia
        $events = self::$en->get_filtered_rows('events', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['events'] = $events;

        //activity
        $activity = self::$en->get_filtered_rows('activity', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['activity'] = $activity;

		//schools
        $schools = self::$en->get_filtered_rows('schools', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['schools'] = $schools;
		
		//rentals
        $rentals = self::$en->get_filtered_rows('rentals', array('id', 'objectname_short'), $cond, 'objectname_short', null, false);
        $offers['rentals'] = $rentals;
		
        return $offers;
    }

    /**
     * Pobiera listę ofert (Resort) dla Admina (nie sprawdza id_user)
     * @param string $table Nazwa tabeli z listą obiektów
     * @return array Tablica get_filtered_row
     */
    public static function GetResortsList($table = 'resorts') {
        $tblname = $table . '_' . LANG;
        $fields = '*';
        return self::$en->get_filtered_rows($tblname, $fields, false, 'objectname_short', null, false);
    }

    /**
     * Konwertuje jedną walutę na drugą
     * @param float $amount Wartość do przeliczenia
     * @return float $amount Wartość przeliczona
     */
    public static function ConvertCurrency($amount, $currcode = false) {
        if ($currcode) {
            if (CURRENCYCODESIDE == 'left') {
                return CURRENCYCODE . ' ' . number_format($amount / CURRENCYRATE, 0);								
            }
            if (CURRENCYCODESIDE == 'right') {
                return number_format($amount / CURRENCYRATE, 0) . ' ' . CURRENCYCODE;	
            }
        }
        return number_format($amount / CURRENCYRATE, 0, '.', '');
    }

    /**
     * 
     * @param string $path Ścieżka do pliku z nawą pliku
     * @param string $prefix prefiks do polecenia GLOB np '*'
     * @param string $suffix suffix do polecenia GLOB np '*'
     * @return boolean
     */
    public static function _deleteImages($path, $prefix = '', $suffix = '') {
        if ($path == DEFAULTIMAGE)
            return;
        $pparts = pathinfo($path);
		
        $ext = array('jpg', 'JPG', 'png', 'PNG');
        if (!in_array($pparts['extension'], $ext))
            return false;
        $path = $pparts['dirname'] . '/' . $prefix . $pparts['filename'] . $suffix . '.' . $pparts['extension'];
        $files = glob($path);
        foreach ($files as $file) {
            unlink($file);
        }		
    }

    /**
     * Generowanie opcji '&lt;option&gt;' z godzinami
     * @param string $selected Która godzina ma być zaznaczona
     * @param type $f Generowanie godzin w trybie 12 godzinnym (nie działa)
     * @return type
     */
    public static function GetHours($selected = '-', $f = 24) {
        switch ($f) {
            case 24:
                for ($i = 1; $i < 24; $i++) {
                    $selected == $i ? $zaz = 'selected' : $zaz = '';
                    $out.="<option value='" . str_pad($i, 2, '0', 0) . "' $zaz>" . str_pad($i, 2, '0', 0) . "</option>\n";
                }
                break;
            case 12:
                break;
        }

        return "<option value='--'>--</option>\n" . $out;
    }

    /**
     * Generowanie opcji '&lt;option&gt;' z minutami z możliwością określenia kroku
     * @param string/int $selected Która minuta ma być zaznaczona
     * @param int $step Co ile minut ma się pojawiać opcja
     * @return type
     */
    public static function GetMinutes($selected = '-', $step = 15) {
        for ($i = 0; $i < 59; $i = $i + $step) {
            $selected == $i ? $zaz = 'selected' : $zaz = '';
            $out.="<option value='" . str_pad($i, 2, '0', 0) . "' $zaz>" . str_pad($i, 2, '0', 0) . "</option>\n";
        }
        return "<option value='--'>--</option>\n" . $out;
    }

    public static function GetPostedInquiries() {
        $sql = "SELECT ac.objectname_short, inq.* FROM " . TABLE_PREFIX . "accommodation ac, " . TABLE_PREFIX . "inquires inq WHERE ac.id = inq.item AND inq.status_sender <> -1 AND inq.user = " . self::$en->GetUserID() . " ORDER BY inq.id ASC";
        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $inq[] = $w;
            }
            $tabela = 'inquires';
            $cond[] = array('status_sender', 1, 'INT');
            $cond[] = array('user', self::$en->GetUserID(), 'INT');
            $sql_up = self::$en->update_rows($tabela, array(array('status_sender', 0, 'INT')), $cond, false, false);
        }
		
        $sql = "SELECT ac.objectname_short, inq.* FROM " . TABLE_PREFIX . "activity ac, " . TABLE_PREFIX . "inquires inq WHERE ac.id = inq.item AND inq.status_sender <> -1 AND inq.user = " . self::$en->GetUserID() . " ORDER BY inq.id ASC";
        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $inq[] = $w;
            }
            $tabela = 'inquires';
            $cond[] = array('status_sender', 1, 'INT');
            $cond[] = array('user', self::$en->GetUserID(), 'INT');
            $sql_up = self::$en->update_rows($tabela, array(array('status_sender', 0, 'INT')), $cond, false, false);
        }
		$sql = "SELECT ac.objectname_short, inq.* FROM " . TABLE_PREFIX . "schools ac, " . TABLE_PREFIX . "inquires inq WHERE ac.id = inq.item AND inq.status_sender <> -1 AND inq.user = " . self::$en->GetUserID() . " ORDER BY inq.id ASC";
        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $inq[] = $w;
            }
            $tabela = 'inquires';
            $cond[] = array('status_sender', 1, 'INT');
            $cond[] = array('user', self::$en->GetUserID(), 'INT');
            $sql_up = self::$en->update_rows($tabela, array(array('status_sender', 0, 'INT')), $cond, false, false);
        }
		$sql = "SELECT ac.objectname_short, inq.* FROM " . TABLE_PREFIX . "rentals ac, " . TABLE_PREFIX . "inquires inq WHERE ac.id = inq.item AND inq.status_sender <> -1 AND inq.user = " . self::$en->GetUserID() . " ORDER BY inq.id ASC";
        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $inq[] = $w;
            }
            $tabela = 'inquires';
            $cond[] = array('status_sender', 1, 'INT');
            $cond[] = array('user', self::$en->GetUserID(), 'INT');
            $sql_up = self::$en->update_rows($tabela, array(array('status_sender', 0, 'INT')), $cond, false, false);
        }
        if (count($inq) > 0 && is_array($inq))
            return $inq;

        return false;
    }

    public static function GetReceivedInquiries() {
        $sql = "SELECT ac.objectname_short, inq.* FROM " . TABLE_PREFIX . "accommodation ac, " . TABLE_PREFIX . "inquires inq WHERE ac.id = inq.item AND inq.status_receiver <> -1 AND ac.id_user = " . self::$en->GetUserID() . " ORDER BY inq.id ASC";

        if (self::$en->query($sql)) {
            while ($w = self::$en->fetch_row()) {
                $inq[] = $w;
                $id[] = $w['id'];
            }
            /*
              if(count($id) >0) {
              $ids = join(',',$id);
              $sql_up = "UPDATE ".TABLE_PREFIX."inquires SET status_receiver=0 WHERE status_receiver=1 AND id IN($ids)";
              self::$en->query($sql_up);
              }
             */
        }
        /*
          $sql = "SELECT ac.objectname_short, inq.* FROM ".TABLE_PREFIX."activity ac, ".TABLE_PREFIX."inquires inq WHERE ac.id = inq.item AND inq.status_receiver <> -1 AND ac.id_user = ".self::$en->GetUserID()." ORDER BY inq.id ASC";

          if(self::$en->query($sql)){
          while ($w = self::$en->fetch_row()){
          $inq[] = $w;
          $id[] = $w['id'];
          }
          if(count($id) >0) {
          $ids = join(',',$id);
          $sql_up = "UPDATE ".TABLE_PREFIX."inquires SET status_receiver=0 WHERE status_receiver=1 AND id IN($ids)";
          self::$en->query($sql_up);
          }
          }
         */
        if (count($inq) > 0 && is_array($inq))
            return $inq;
        return false;
    }

    public static function DeleteInquiery($itemid, $dir = 'sender') {
        $sql_up = "UPDATE " . TABLE_PREFIX . "inquires SET status_" . $dir . "=-1 WHERE id=" . $itemid;
        $u = self::$en->query($sql_up);
        $sql_d = "DELETE FROM " . TABLE_PREFIX . "inquires WHERE status_sender = -1 AND status_receiver = -1";
//        die(var_dump($sql_d));
        $d = self::$en->query($sql_d);
        if (intval($u & $d) === 0)
            return false;
        return true;
    }

    /**
     * Generowanie kalendarza z checkboxami
     * @param string/int $month miesiąc MM 
     * @param string/int $year rok YYYY
     * @param array $disabed dni wyłączone z miesiąca (disabled)
     * @return string
     */
    public static function GetCalendar($month = '01', $year = '2014', $price, $disabled = array()) {
        $data = strtotime($year . '-' . $month . '-01');
        if ($year . '-' . $month == date('Y-m')) {
            $today = date('d');
            $tmd = range(1, $today);
            $disabled = array_merge($disabled, $tmd);
        }
        # numer 1 dnia miesiąca w tygodniu 
        $first_dofw = date('N', $data);
        # ilość dni w miesiącu
        $days = date('t', $data);
        $go = true;
        # dień w tygodniu
        $day = 1;
        $l = 1;
        # dzień miesiąca
        $dayn = 1;
        $out = "<table class='table-calendar banner mt-10'><thead><tr>"
                . "<td colspan=7 style='text-align:center;'>" . date('m/Y', $data) . " - wybierz wszystkie <input type='checkbox' id='sall" . $month . "' class='selectall' data-month=" . $month . "></td></tr><tr>"
                . "<td>Pn</td><td>Wt</td><td>Śr</td><td>Czw</td><td>Pt</td><td>So</td><td>Nie</td></tr></thead>";
        while ($go) {
            if ($l < $first_dofw) {
                $out.="<td class='cell empty'></td>";
                $l++;
                $day++;
                continue;
            }
            if (in_array($dayn, $disabled)) {
                $out.="<td class='cell red'>" . $dayn . "</td>";
            } else {
                $out.="<td class='cell free'>" . $dayn . "<br>"
                        . "<input type='checkbox' name='mth_" . $month . "[]' value='" . $dayn . "' data-cost='$price' class='calendarday'></td>";
            }
            $l++;
            if ($day == 7) {
                $out.="</tr><tr>";
                $day = 1;
            } else
                $day++;
            if ($dayn == $days)
                $go = false;
            $dayn++;
        }

        $out .= "</tr></table>";

        return $out;
    }

    /**
     * Weryfikuje sygnature podpisu płatności CashBill
     */
    public static function CashBillSign($params) {
        $sign = '';
        if (count($params) > 0) {
            foreach ($params as $param) {
                $sign .= $param;
            }
        }
        $param .= CB_KEY;
        return md5($sign);
    }

    /**
     * Sprawdza poprawność numeru NIP
     */
    public static function validateNIP($nip) {
		$nip_bez_kresek = preg_replace("/-/", "", $nip);		
		$reg = '/^[aA-zZ]{2}[0-9]{10}$/';

		if ( (bool)preg_match($reg, $nip_bez_kresek) ) {
            $country = substr($nip_bez_kresek, 0,2);
			$country = strtoupper( $country );
	
			switch( $country ) {
				case 'PL': return true; break;
				case 'EN': return true; break;
				case 'DE': return true; break;
				case 'SK': return true; break;
				case 'RU': return true; break;
				default: return false;
			}
		}
		return false;
	/*
        $nip_bez_kresek = preg_replace("/-/", "", $nip);
        $reg = '/^[0-9]{10}$/';
        if (preg_match($reg, $nip_bez_kresek) == false)
            return false;
        else {
            $dig = str_split($nip_bez_kresek);
            $kontrola = (6 * intval($dig[0]) + 5 * intval($dig[1]) + 7 * intval($dig[2]) + 2 * intval($dig[3]) + 3 * intval($dig[4]) + 4 * intval($dig[5]) + 5 * intval($dig[6]) + 6 * intval($dig[7]) + 7 * intval($dig[8])) % 11;
            if (intval($dig[9]) == $kontrola)
                return true;
            else
                return false;
        }
	*/
    }

    /**
     * Sprawdza poprawność danych do faktury
     */
    public static function validateDataInvoice($user) {
        $row = self::$en->select_r("SELECT * FROM " . TABLE_PREFIX . "uzytkownik_meta WHERE firma != '' AND nip != '' AND kod != '' AND miasto != '' AND adres != '' AND item = {$user}");
        if (is_array($row) && count($row) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Pobiera adres ip
     */
    public static function GetClientIP() {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    /**
     * Zwraca szczegołową kategorie oferty z modułu
     * 
     * @param type $module
     * @param type $id
     * @return type
     */
    public static function GetCategoryName($module, $id) {
        $table = $module.'_types';
        $where = array(
            array('type_id', $id, 'INT'),
            array('lang_id', LANG, 'INT')
        );
        return self::$en->get_field_val($table, 'name', $where); 
    }
    
	/**
	 * Sprawdza pozycję miasta na białej liście, w przypadku nie powodzenia wysyła mail do administratora
	 */
	public static function IsValidateCity($module, $city, $id, $user_id) {		

		$valid = self::$en->select_r("SELECT COUNT(id) AS 'id' FROM ".TABLE_PREFIX."whitelist WHERE city LIKE '{$city}'");

		$user_id = intval($user_id);
		$id = intval($id);
		$user_perm = self::$en->get_field_val(TABLE_PREFIX."uzytkownik", "uprawnienia", array(array('id', $user_id, 'INT')));
		
		$is_in_modetare = self::$en->get_field_val(TABLE_PREFIX."whitelist_moderate", "id", array( array('item_id', $id ,'INT'), array('module', $module,'STRING')));
		
		if(intval($user_perm) != 4 && intval($user_perm) != 100) {
			$data[] = array('user_id', $user_id, 'INT');
		}
		$data[] = array('item_id', $id, 'INT');
		$data[] = array('module', $module, 'STRING');
		
		if(intval($valid['id']) == 1 || !ACTIVE_WHITELIST) {
			$perm = 1;
		} else {
			$perm = -2;
		}
		
		$data[] = array('perm', $perm, 'INT');
		
		if(intval($is_in_modetare) > 0){
			self::$en->query("UPDATE ".TABLE_PREFIX."whitelist_moderate SET perm={$perm} WHERE id={$is_in_modetare} AND module='{$module}' AND item_id={$id}");
		} else {
			self::$en->insert_row(TABLE_PREFIX.'whitelist_moderate', $data);
		}
		
		if(intval($valid['id']) == 0 && ( intval($user_perm) != 100 || intval($user_perm) != 4) && ACTIVE_WHITELIST ) {
		
			require_once SETTINGSDIR.'/modules/mailsend/Mailsend.php';
			
			$userdata = self::$en->select_r("SELECT * FROM ".TABLE_PREFIX."uzytkownik WHERE id=".$user_id."");
			$offer_name = self::$en->get_field_val(TABLE_PREFIX.$module, 'objectname_short', array( array('id', $id, 'INT'), array('id_user', $user_id, 'INT') ));
			
			$params = array(
				'user'=>$userdata['id'],
				'email'=>$userdata['email'],
				'lang'=>11,
				md5('%SITE_URL%')=>SITE_URL,
				md5('%SITE_NAME%')=>SITE_NAME,
				md5('%USER_LOGIN%')=>$userdata['nazwa_uzytkownika'],
				md5('%USER_LNAME%')=>$userdata['nazwisko'],
				md5('%USER_FNAME%')=>$userdata['imie'],
				md5('%USER_EMAIL%')=>$userdata['email'],
				md5('%OFFER_NAME%')=>$offer_name,
				md5('%OFFER_MODERATE%')=>SITE_URL.'admin.php?whitelist&a=detail&id='.$id.'&m='.$module
			);			
			Mailsend::SendEmail('admin_whitelist_moderate', $params, self::$en);
		}
	}
	
	/**
	 * Sprawdza dostep oferty
	 * -2 - do rozpatrzenia
	 * -1 - dostęp zablokowany
	 * 0 - dostęp ograniczony
	 * 1 - pełen dostęp
	 */
	public static function checkPermissionOffer($module, $item_id, $user_id) {
		$where = array(
			array('user_id', intval($user_id), 'INT'),
			array('item_id', intval($item_id), 'INT'),
			array('module', $module, 'STRING')
		);
		$perm = self::$en->get_field_val(TABLE_PREFIX.'whitelist_moderate', 'perm', $where);
		if( intval($perm) >= 0 ) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Zwraca typ uprawnień listy
	 */
	public static function getOfferPerm($module, $item_id) {
		$where[] = array('item_id', intval($item_id), 'INT');
		$where[] = array('module', $module, 'STRING');
		
		return self::$en->get_field_val(TABLE_PREFIX.'whitelist_moderate', 'perm', $where);
	}
	 
	/**
	 * Kasowanie pozycji z białej listy
	 */
	public static function deleteObjectFromWhitelist($module, $objectid, $user_id) {
		$objectid = intval($objectid);
		$user_id = intval($user_id);

		$sql = "DELETE FROM ".TABLE_PREFIX."whitelist_moderate WHERE user_id={$user_id} AND item_id={$objectid} AND module='{$module}'";		
		self::$en->query($sql);
	}
	
	/**
	 * Kasowanie ofert z promocji
	 */
	public static function deletePromotions($module, $objectid) {
		$object_id = intval($objectid);
		
		//kasowanie pozycji w wyszukiwarce
		$date_now = date('d-m-Y 00:00:00');
		$strtotime_date_now = strtotime( $date_now );
		$sql_1 = "DELETE FROM ".TABLE_PREFIX."pozycjonowanie_historia WHERE item={$object_id} AND module='{$module}' AND data={$strtotime_date_now}";
		self::$en->query($sql_1);
		$sql_2 = "DELETE FROM ".TABLE_PREFIX."pozycjonowanie_config WHERE item={$object_id} AND module='{$module}'";
		self::$en->query($sql_2);
		$sql_3 = "DELETE FROM ".TABLE_PREFIX."pozycjonowanie WHERE item={$object_id} AND module='{$module}' AND data={$strtotime_date_now}";
		self::$en->query($sql_2);
		
		//kasowanie pozostalych promocji		
	 	$sql_4 = "DELETE FROM ".TABLE_PREFIX."promo WHERE object_id={$object_id} AND module='{$module}'";
		self::$en->query($sql_4);
	}
	
	/**
	 * pobiera listę dopuszczlanych miejscowości
	 */
	public static function getWhitelistCity(){
		return self::$en->select("SELECT city FROM ".TABLE_PREFIX."whitelist");		
	}
	
	/**
	 * Sprawdza czy daną ofertę modyfikował administrator
	 */
	public static function isEditAdmin($module, $offer_id) {
		$cond[] = array('module', $module, 'STRING');
		$cond[] = array('item_id', $offer_id, 'INT');
		
		return self::$en->get_field_val(TABLE_PREFIX.'whitelist_moderate', 'edit_admin', $cond);
	}
	
	/**
	 * Sprawdza czy oferta znajduje się w jakiej kolwiek promocji
	 */
	public static function checkPromotions($module, $offer_id, $en=null) {
		if(!self::$en){
			self::$en = $en;
		}
		
		$offer_id = intval($offer_id);
		
		$date = date('Y-m-d', strtotime("-1 days"));
		$sql = "SELECT COUNT(id) AS is_promo FROM ".TABLE_PREFIX."promo WHERE object_id={$offer_id} AND module='{$module}' AND ( active=1 OR date_start > '{$date}' )";
		$res = self::$en->select_r($sql);
		
		return intval($res['is_promo']) > 0 ? true : false;		
	}
	
	/**
	 * Informacja o abonamencie oferty 
	 * zwraca status i ilość dni do wygaśnięcia
	 */
	public static function getSubsInfo($module, $item_id, $en = null) {	
		if(!self::$en){
			self::$en = $en;
		}
		
		$item_id = intval($item_id);
		
		$date_to = self::$en->select_r("SELECT date_to as d FROM " . TABLE_PREFIX . "uzytkownik_abonament WHERE item_id=" . $item_id . " AND module='".$module."' ORDER BY date_to DESC LIMIT 1");
		$date_now = strtotime(date('d-m-Y 00:00:00'));
		$day_left = intval($date_to['d']) - intval($date_now);

		if ($day_left > 0) {
			$abonament_added = true;
			$day_left = floor($day_left / 3600 / 24);
		} elseif ($day_left == 0) {
			$abonament_added = true;
			$day_left = 0;
		} else {
			$day_left = -1;
			$abonament_added = false;
		}

		return array('status' => $abonament_added, 'day_left' => $day_left);
	}
	
	/**
	 *	Ustawia kolejny numer zdjecia przy dodawaniu
	 */
	 
	 public static function setOrderPhoto($module, $item_id, $en = null){
		if(!self::$en){
			self::$en = $en;
		}
		$item_id = intval($item_id);
		$nr = self::$en->get_field_val(TABLE_PREFIX.$module.'_meta', 'MAX(orderby)', array(array('id_object', $item_id, 'INT')));
		$nr = intval($nr);
		return ++$nr;
	 }
	 
	 /**
	  * Sprawdza czy można wyświetlić ofertę z pozostałych ośrodków
	  */
	public static function CheckAllowedOtherResort($module, $offerid, $en=null) {
		if(!self::$en){
			self::$en = $en;
		}
		
		$offerid = intval($offerid);		
		$resort_id = self::$en->get_field_val(TABLE_PREFIX.$module, 'id_resort', array(array('id',$offerid, 'INT')));

		if( intval($resort_id) == 0 && OTHER_RESEORTS) {
			return false;
		}
		
		return true;
	}
	 
	/**
	 * Automatyczne ustawienia bezpłatnego abonamentu dla oferty
	 */
	public static function SetFreeAbonament($module, $object_id, $abonament_info, $user_id, $en=null) {
		if(!self::$en){
			self::$en = $en;
		}
		
		if(!is_array($abonament_info)){ return false; }
		
		$object_id = intval($object_id);
		$user_id = intval($user_id);
		$date_added = strtotime(date('d-m-Y H:i:s'));
		$date_from = strtotime(date('d-m-Y 00:00:00'));		
		
		$check_dates = self::$en->select_r("SELECT MAX(date_to) AS new_data_from FROM ts_uzytkownik_abonament WHERE date_to > ".$date_from." AND user_id=".$user_id." AND item_id=".$object_id." AND module='{$module}'");
				 
		if(!is_null($check_dates['new_data_from'])){
			$date_from = $check_dates['new_data_from'];
		}

		$a_valid = intval($abonament_info['time']) * 86400;
		$date_to = ($date_from + $a_valid);

		$fields = array(
			array('user_id', $user_id, 'INT'),
			array('item_id', $object_id, 'INT'),
			array('date_added', $date_added, 'INT'),
			array('date_from', $date_from, 'INT'),
			array('date_to', $date_to, 'INT'),  
			array('module', $module, 'STRING')
		);
		
		self::$en->insert_row(TABLE_PREFIX."uzytkownik_abonament", $fields);
	}
	
	/**
	 * Pobiera pierwszy aktywny modul 
	 * @get_events:bool czy brać pod uwagę wydarzenia ?
	 */
	public static function GetFirstActiveModule($get_events = false){
		if( ACTIVE_ACCOMMODATION ) { return 'accommodation'; }
		if( ACTIVE_SERVICE ) { return 'service'; }		
		if( ACTIVE_EVENTS && $get_events) { return 'events'; }
		if( ACTIVE_ACTIVITY ) { return 'activity'; }
		if( ACTIVE_SCHOOLS ) { return 'schools'; }
		if( ACTIVE_RENTALS ) { return 'rentals'; }
		
		return null;
	}
	
	public static function CheckAllowedModule($module) {
		switch($module){
			case 'accommodation':  return ACTIVE_ACCOMMODATION ? true : false; break;
			case 'activity':  return ACTIVE_ACTIVITY ? true : false; break;
			case 'service':  return ACTIVE_SERVICE ? true : false; break;
			case 'events':  return ACTIVE_EVENTS ? true : false; break;
			case 'schools':  return ACTIVE_SCHOOLS ? true : false; break;
			case 'rentals':  return ACTIVE_RENTALS ? true : false; break;
		}
		return false;
	}
	
	/**
	 * Ustawia znacznik meta do wyswietlanej strony
	 */	 
	public static function SetMetaTag($module, $type, $tag, $params=false, $en=null){
		if(!self::$en){
			self::$en = $en;
		}
		
		$module = strtoupper($module);
		
		$where[] = array('tag', 'META_'.$module.'_'.$type.'_'.$tag, 'STRING');
		$where[] = array('lang', LANG, 'INT');
		
		$content = self::$en->get_field_val(TABLE_PREFIX.'metatags', 'text', $where);

		if( is_array($params) ) {
			$all_params = self::GetAllMetaParam(self::$en);
			
			foreach($all_params as $p) {
				$content = str_replace($p['param'], $params[md5($p['param'])], $content);
			}
		} 
		return $content;
	}
	
	public static function GetAllMetaParam($en) {
		return $en->select("SELECT * FROM ".TABLE_PREFIX."metatags_params ORDER BY order_by ASC");
	}
}

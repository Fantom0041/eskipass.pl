<?
require_once($EN_settings_dir."libs/class.Database.php");

class Engine extends Database {
	private $php_session_id;
	private $native_session_id;
	private $logged_in;

	//user
	private $user_id;
	private $nazwa_uzytkownika;
	private $imie;
	private $nazwisko;
	private $uprawnienia;
	private $email;

        //conf
	private $session_timeout = 2592000; //max czas nieaktywnosci
	private $session_lifespan = 2592000; //max termin waznosci

	public function __construct() {

		$this->startdb();

		//kodowanie znakow z bazy danych
		$this->query("SET character_set_server = 'utf8'");
		$this->query("SET collation_connection = 'utf8_unicode_ci'");
		$this->query("SET character_set_connection = 'utf8'");
		$this->query("SET character_set_client = 'utf8'");
		$this->query("SET character_set_results = 'utf8'");
		$this->query("SET names = 'utf8'");

		//startujemy obsluge sesji
		session_set_save_handler(
			array(&$this, '_session_open_method'),
			array(&$this, '_session_close_method'),
			array(&$this, '_session_read_method'),
			array(&$this, '_session_write_method'),
			array(&$this, '_session_destroy_method'),
			array(&$this, '_session_gc_method')
		);
		
		//sprawdzanie cookies
		$strUserAgent = $_SERVER["HTTP_USER_AGENT"];
		$failed=0;
		if($_COOKIE["PHPSESSID"]) {
			//czy wazne?
			$this->php_session_id = $_COOKIE["PHPSESSID"];
			
			$stmt = "SELECT id FROM ".TABLE_PREFIX."sesja_uzytkownika
			WHERE identyfikator_sesji_ascii = '" . $this->php_session_id . "'
			AND ((".time()."-utworzono) < " . $this->session_lifespan . " )
			AND ((".time()."-ostatnia_reakcja) <= ".$this->session_timeout . " 
			OR ostatnia_reakcja IS NULL)";
			
			$result=$this->select($stmt);
			if(intval($result[0][id])==0) {
				//ustawienie znacznika niepowodzenia
				$failed=1;
				//wywalamy z bazy
				/*$res = $this->query("DELETE FROM ".TABLE_PREFIX."sesja_uzytkownika
				WHERE (identyfikator_sesji_ascii = '" . $this->php_session_id . "')
				OR (".time()."-utworzono) > " . $this->session_lifespan);
				//wywalamy nieprzydatne zmienne sesji
				$res = $this->query("DELETE FROM ".TABLE_PREFIX."zmienna_sesji
				WHERE identyfikator_sesji NOT IN (SELECT id FROM ".TABLE_PREFIX."sesja_uzytkownika)");*/

				unset($_COOKIE["PHPSESSID"]);
			} else {
				$this->native_session_id=$result[0][id];
			}
		}
		//ustawiamy czas zycia cookie
		//session_set_cookie_params();
		session_set_cookie_params($this->session_lifespan, '/');
		//echo var_dump(session_get_cookie_params());
		//inicjujemy sesje
		
		//get the right domain name cause if not ie(s) will drop the dam cookies, also check if we are on localhost, credit php.net user comments
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		ini_set('session.cookie_domain',$domain);
		//start the session so we have an session id to assign to the cookie
		session_start();
		//set the cookie by sending it in a header.  
		$this->set_cookie_fix_domain('PHPSESSID',session_id(),time() + $this->session_lifespan,'/',$domain);
		
		
	}
	
	private function set_cookie_fix_domain($Name, $Value = '', $Expires = 0, $Path = '', $Domain = '', $Secure = false, $HTTPOnly = false)
	  {
	    if (!empty($Domain))
	    {
	      // Fix the domain to accept domains with and without 'www.'.
	      if (strtolower(substr($Domain, 0, 4)) == 'www.')  $Domain = substr($Domain, 4);
	      $Domain = '.' . $Domain;
	
	      // Remove port information.
	      $Port = strpos($Domain, ':');
	      if ($Port !== false)  $Domain = substr($Domain, 0, $Port);
	    }
	
	    header('Set-Cookie: ' . rawurlencode($Name) . '=' . rawurlencode($Value)
	                          . (empty($Expires) ? '' : '; expires=' . gmdate('D, d-M-Y H:i:s', $Expires) . ' GMT')
	                          . (empty($Path) ? '' : '; path=' . $Path)
	                          . (empty($Domain) ? '' : '; domain=' . $Domain)
	                          . (!$Secure ? '' : '; secure')
	                          . (!$HTTPOnly ? '' : '; HttpOnly'), false);
	  }
	
	private function Escape( $text ) {
		if ( get_magic_quotes_gpc() ) {
			$text = stripslashes($text);
		}
		if ( !is_numeric($text) ) {
			$text = mysql_real_escape_string($text);
		}
		return $text;
	}

	public function Impress() {
		if($this->native_session_id) {
			$result=$this->query("UPDATE ".TABLE_PREFIX."sesja_uzytkownika
			SET ostatnia_reakcja = ".time()." WHERE id = " . $this->native_session_id);
		}
	}

	public function IsLoggedIn() {
		return($this->logged_in);
	}

	//informacje o zalogowanym userze

	public function GetUserID() {
		if($this->logged_in) {
			return intval($this->user_id);
		} else {
			return false;
		}
	}

	public function GetUserPerm() {
		if($this->logged_in) {
			return($this->uprawnienia);
		} else {
			return false;
		}
	}

	public function GetUserItemPerm() {
		if($this->logged_in) {
			$res=$this->select("SELECT * FROM ".TABLE_PREFIX."uzytkownik_role WHERE id=".intval($this->uprawnienia));
			return $res[0];
		} else {
			return false;
		}
	}

	public function GetUserName() {
		if($this->logged_in) {
			return($this->nazwa_uzytkownika);
		} else {
			return false;
		}
	}

	public function GetUserFullName() {
		if($this->logged_in) {
			return($this->imie . " " . $this->nazwisko);
		} else {
			return false;
		}
	}

	public function GetUserFName() {
		if($this->logged_in) {
			return($this->imie);
		} else {
			return false;
		}
	}

	public function GetUserSName() {
		if($this->logged_in) {
			return($this->nazwisko);
		} else {
			return false;
		}
	}


	public function GetUserEmail() {
		if($this->logged_in) {
			return($this->email);
		} else {
			return false;
		}
	}


	public function GetUserObject() {
		if($this->logged_in) {
			if(class_exists("user")) {
				$objUser = new User($this->user_id);
				return($objUser);
			} else {
				return false;
			}
		}
	}


	public function GetSessionIdentifier() {
		return($this->php_session_id);
	}

	public function LogInsert($rodzaj,$rid,$opis) {
		$res=$this->query(sprintf("INSERT INTO `".TABLE_PREFIX."log`(`data`,`rodzaj`,`rid`,`opis`,`user`) VALUES('%s','%s',%d,'%s',%d)",
		date("Y-m-d H:i:s"),
		$rodzaj,
		$rid,
		$opis,
		$this->user_id
		));
		return false;
	}


	//sesje i inne bzdey ;)
	public function SaveUserData($id) {
		if($this->logged_in) {
			$stmt = "SELECT * FROM ".TABLE_PREFIX."uzytkownik
			WHERE id=" . $id;
			$result = $this->select($stmt);
			$this->user_id = $result[0]["id"];
			$this->nazwa_uzytkownika = $result[0]["nazwa_uzytkownika"];
			$this->imie = $result[0]["imie"];
			$this->nazwisko = $result[0]["nazwisko"];
			$this->uprawnienia = $result[0]["uprawnienia"];
			$this->email = $result[0]["email"];

			return(true);
		} else {
			return false;
		}
	}

	public function Login($strUsername, $strPlainPassword) {
		$strMD5Password = md5($strPlainPassword.SALT);
		$stmt = "SELECT * FROM ".TABLE_PREFIX."uzytkownik
		WHERE ((nazwa_uzytkownika = '$strUsername' AND md5_haslo = '$strMD5Password') OR (email = '$strUsername' AND md5_haslo = '$strMD5Password')) AND uprawnienia>=1";
		$result = $this->select($stmt);
		if(count($result)>0) {
			$this->user_id = $result[0]["id"];
			$this->nazwa_uzytkownika = $result[0]["nazwa_uzytkownika"];
			$this->logged_in = true;
			$result = $this->query("UPDATE ".TABLE_PREFIX."sesja_uzytkownika
			SET zalogowany = 't', identyfikator_uzytkownika = " . $this->user_id . "
			WHERE id = " . $this->native_session_id);

			$this->SaveUserData($this->user_id);

			return(true);
		} else {
			return(false);
		}
	}
	
	public function LoginSocial($id) {
		$stmt = "SELECT * FROM ".TABLE_PREFIX."uzytkownik
		WHERE id = ".intval($id)." AND uprawnienia>=1";
		$result = $this->select($stmt);
		if(count($result)>0) {
			$this->user_id = $result[0]["id"];
			$this->nazwa_uzytkownika = $result[0]["nazwa_uzytkownika"];
			$this->logged_in = true;
			$result = $this->query("UPDATE ".TABLE_PREFIX."sesja_uzytkownika
			SET zalogowany = 't', identyfikator_uzytkownika = " . $this->user_id . "
			WHERE id = " . $this->native_session_id);

			$this->SaveUserData($this->user_id);

			return(true);
		} else {
			return(false);
		}
	}

	public function Logout() {
		if($this->logged_in == true) {
			$result = $this->query("UPDATE ".TABLE_PREFIX."sesja_uzytkownika
			SET zalogowany = 'f', identyfikator_uzytkownika = 0
			WHERE id = " . $this->native_session_id);
			$this->logged_in = false;
			$this->user_id = 0;
			return(true);
		} else {
			return(false);
		}
	}

	public function __get($nm) {
		$result = $this->select("SELECT wartosc_zmiennej FROM ".TABLE_PREFIX."zmienna_sesji
		WHERE identyfikator_sesji = " . $this->native_session_id . "
		AND nazwa_zmiennej = '" . $nm . "'");
		if(count($result)>0) {
			return unserialize(base64_decode($result[0]["wartosc_zmiennej"]));
		} else {
			return(false);
		}
	}

	public function __set($nm, $val) {
		$strSer = base64_encode(serialize($val));
		//sprawdzamy, czy zmienna już istnieje
		$spr=$this->select("SELECT round(id) as id FROM ".TABLE_PREFIX."zmienna_sesji WHERE nazwa_zmiennej='".$nm."' AND identyfikator_sesji=".$this->native_session_id);
		if($spr[0][id]>0) {
			$stmt = "UPDATE ".TABLE_PREFIX."zmienna_sesji SET wartosc_zmiennej='".$strSer."' WHERE id=".$spr[0][id]." LIMIT 1";
		} else {
			$stmt = "INSERT INTO ".TABLE_PREFIX."zmienna_sesji(identyfikator_sesji, nazwa_zmiennej, wartosc_zmiennej)
			VALUES(" . $this->native_session_id . ", '$nm', '$strSer')";
		}
		$result = $this->query($stmt);
	}

	public function _session_open_method($save_path, $session_name) {
		//po prostu nic nie robi ;)
		return(true);
	}

	public function _session_close_method() {
		if(is_resource($this->hConn)) {
			@mysql_close($this->hConn);
		}
		return(true);
	}

	public function _session_read_method($id) {
		//sprawdzamy, czy sesja istnieje
		$strUserAgent = $_SERVER["HTTP_USER_AGENT"];
		$this->php_session_id = $id;
		//tymczasowo ustawiamy niepowodzenie
		$failed = 1;
		//sprawdzamy, czy sesja jest w bazie
		/*
		$result = mysql_query("SELECT id, zalogowany, identyfikator_uzytkownika
		FROM sesja_uzytkownika WHERE identyfikator_sesji_ascii = '$id'");
		*/
		$result=$this->select("SELECT id, zalogowany, identyfikator_uzytkownika
		FROM ".TABLE_PREFIX."sesja_uzytkownika WHERE identyfikator_sesji_ascii = '$id'");
				
		if(count($result)>0) {
			$this->native_session_id = $result[0]["id"];
			if($result[0]["zalogowany"]=="t") {
				$this->logged_in = true;
				$this->user_id = $result[0]["identyfikator_uzytkownika"];

				$this->SaveUserData($this->user_id);
			} else {
				$this->logged_in = false;
			}
			$this->Impress();

		} else {
			$this->logged_in = false;
			//trzeba wstawic wpis do bazy
			$result = $this->query("INSERT INTO ".TABLE_PREFIX."sesja_uzytkownika(identyfikator_sesji_ascii, zalogowany, identyfikator_uzytkownika, utworzono, ostatnia_reakcja, user_agent)
			VALUES('$id', 'f', '0', ".time().", ".time().", '$strUserAgent')");
			//teraz pobieramy prawdziwy identyfikator
			$result = $this->select("SELECT id FROM ".TABLE_PREFIX."sesja_uzytkownika
			WHERE identyfikator_sesji_ascii = '$id'");
			$this->native_session_id = $result[0]["id"];
		}
		//zwracamy ciag pusty
		return("");
	}

	public function _session_write_method($id, $sess_data) {
		return(true);
	}

	public function _session_destroy_method($id) {
		//2011-10-31 12:04
		/*$result = $this->query("DELETE FROM '".TABLE_PREFIX."sesja_uzytkownika'
		WHERE identyfikator_sesji_ascii = '$id'");
		return($result);
		*/
		return true;
	}

	public function _session_gc_method($maxlifetime) {
		return(true);
	}
	
	public function __destruct() {
		session_write_close();
		return false;
	}
}
?>

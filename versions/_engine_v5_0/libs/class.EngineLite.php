<?php
require_once($EN_settings_dir."libs/class.Database.php");

class Engine extends Database {
	private $php_session_id;
	private $logged_in;


	public function __construct() {

		$this->startdb();

		//kodowanie znakow z bazy danych
		$this->query("SET character_set_server = 'utf8'");
		$this->query("SET collation_connection = 'utf8_unicode_ci'");
		$this->query("SET character_set_connection = 'utf8'");
		$this->query("SET character_set_client = 'utf8'");
		$this->query("SET character_set_results = 'utf8'");
		$this->query("SET names = 'utf8'");
		session_start();
		
		$this->php_session_id = session_id();
	}
	
	
	
//	private function Escape( $text ) {
//		if ( get_magic_quotes_gpc() ) {
//			$text = stripslashes($text);
//		}
//		if ( !is_numeric($text) ) {
//			$text = mysql_real_escape_string($text);
//		}
//		return $text;
//	}

	public function IsLoggedIn() {
		return($_SESSION['logged_in']);
	}
	
	public function Login($strUsername, $strPlainPassword) {
		$strMD5Password = md5($strPlainPassword.SALT);
		$stmt = "SELECT * FROM ".TABLE_PREFIX."uzytkownik
		WHERE ((nazwa_uzytkownika = '$strUsername' AND md5_haslo = '$strMD5Password') OR (email = '$strUsername' AND md5_haslo = '$strMD5Password')) AND uprawnienia=100";
		$result = $this->select($stmt);
		if(count($result)>0) {
			$_SESSION['uprawnienia'] = $result[0]["uprawnienia"];
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $result[0]["id"];
			$_SESSION['nazwa_uzytkownika'] = $result[0]["nazwa_uzytkownika"];
			
			return(true);
		} else {
			return(false);
		}
	}
	
	public function Logout() {
		$_SESSION['logged_in'] = false;
		$_SESSION['user_id'] = 0;
		$_SESSION['nazwa_uzytkownika'] = '';
		$_SESSION['uprawnienia'] = 0;
	}
	
	public function GetUserPerm() {
		if($_SESSION['logged_in']) {
			return($_SESSION['uprawnienia']);
		} else {
			return false;
		}
	}

	//informacje o zalogowanym userze

	public function GetUserID() {
		if($this->logged_in) {
			return intval($this->user_id);
		} else {
			return false;
		}
	}
	
	public function GetSessionIdentifier() {
		return($this->php_session_id);
	}


	
	public function __destruct() {
		if(is_resource($this->hConn)) {
			@mysql_close($this->hConn);
		}
		return false;
	}
}
?>

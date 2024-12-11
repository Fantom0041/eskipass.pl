<?php
date_default_timezone_set('Europe/Warsaw'); 
######################### VERSION ################################
error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
class SkiraportAPI {
	
	private $data=array();
	private $aes=null;
	private $login='skiraportmobileios';
	private $haslo='lfvojh385y0JIUGBEf39o0lkoJGu8f2';
	private $aeskey='kjdh2873r29iuajh';
	private $defaultlang='pol';
	private $encrypted_res = false;
	
	private $cachedir = "data/skiraport/";
	private $tokenfile = 'skiraport.token.txt';

	public function __construct() {
		
		define("AESKEY",$this->aeskey);
		define("DEFAULTLANGUAGE",$this->defaultlang);
		
		require_once("AES.php");
		$this->aes = new Crypt_AES(CRYPT_AES_MODE_ECB);
		$this->aes->setKey(AESKEY);
	}

	private function ConvertFromUTF($string) {
		$from = array("\u017c","\u017a","\u0107","\u0144","\u0105","\u015b","\u0142","\u0119","\u00f3","\u017b","\u0179","\u0106","\u0143","\u0104","\u015a","\u0141","\u0118","\u00d3", "\/", "\u00b0");
		$to = array("ż","ź","ć","ń","ą","ś","ł","ę","ó","Ż","Ź","Ć","Ń","Ą","Ś","Ł","Ę","Ó","/",""); 
		$string = str_replace($from, $to, $string);
		return $string;
	}
	
	private function ApiParseAES($aes_string) // zwraca tablice parametrow
	{
		if($aes_string=='') return array();
		
		$decoded_string = $this->aes->decrypt(pack('H*', $aes_string));
		$resp=array();
		parse_str($decoded_string, $resp);
		
		if (!isset($resp['lan'])) $resp['lan']='pol';
		$resp['lan']=strtoupper($resp['lan']);
		
		return $resp;
	}
	
		
	private function ToJSON($array) {
		return json_encode($array);
	}
	
	private function CreateQuery($query) {
		$encoded = bin2hex($this->aes->encrypt($query));
		return $encoded;
	}
	
	private function DecodeQuery($query) {
		$decoded = $this->ApiParseAES($query);
		return $decoded;
	}
	
	private function GetToken() {
		if(file_exists($this->cachedir.$this->tokenfile)) {
			$dane = file_get_contents($this->cachedir.$this->tokenfile);
			$dane = $this->DecodeQuery($dane);			
			return $dane['token'];
		} else {
			return false;
		}
	}
	
	private function Login() {
		$query="user=".$this->login."&password=".$this->haslo;
		$res = $this->RunTask("login", $query);
		$res_array = json_decode($res, true);
		if($res_array['result']==true && $res_array['dane']['token']!="") {
			file_put_contents($this->cachedir.$this->tokenfile, $this->CreateQuery("token=".$res_array['dane']['token']));
			return true;
		} else {
			return false;
		}
	}
	
	private function RunTask($task, $query) {
		$query = $this->CreateQuery($query);
		if ($handle = opendir($this->cachedir)) {
		    while (false !== ($file = readdir($handle))) {
			if ( filemtime($this->cachedir.$file) <= time()-60*60*5 && ($file!="." && $file!=".." && substr($file,0,5)=="query")) {
			  unlink($this->cachedir.$file);
			}
		    }
		    closedir($handle);
		}
		if(file_exists($this->cachedir."query_".md5($task.$query).".txt")) $res = file_get_contents($this->cachedir."query_".md5($task.$query).".txt");
		else { 
		  $res = file_get_contents("http://api.skiraport.pl/api2.php?task=".$task."&id=".$query."&rel=widget");
		  file_put_contents($this->cachedir."query_".md5($task.$query).".txt", $res);
		}
		if($this->encrypted_res) $res = $this->aes->decrypt(pack('H*', $res));
		return $res;
	}
	
	public function Task($task, $query, $proba=0) {
		if($proba==10) return false;
		$query_tokenined = $query."&token=".$this->GetToken();
		$res = $this->RunTask($task, $query_tokenined);
		$res_array = json_decode($res, true);
		if($res_array['result']==true) {
			return json_encode($res_array['dane']);
		} else {
			if($this->Login()) {
				return $this->Task($task, $query, $proba+1);
			} else {
				return false;
			}
		}
	}
}
?>

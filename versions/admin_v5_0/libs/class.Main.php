<?php
class Main {
	public $en = null;
	protected $tpl = null;
	protected $add = null;
	protected $mailer = null;
	protected $perm;
	protected $lang;

	// error messages
	protected $error = null;
    
	public function __construct() {
	    global $lang;
	    $this->lang=$lang;

	    
	    $this->tpl = new SmartySetup;
	    $this->en = new Engine;
	    $this->add = new Additional;
	    
	    //pobranie uprawnień do modułów
	    //$this->perm=$this->en->GetUserItemPerm();
	        
	    $this->SendSettings();
	    $this->SendEngineData();
	    
	    global $_POST;
	    global $_GET;
	    if($_POST["login"]!="") {
		    $login=addslashes(htmlentities($_POST[login]));
		    $passwd=addslashes(htmlentities($_POST[passwd]));
		    
		    $this->en->Login($login, $passwd);
		    if ($this->en->IsLoggedIn() == true) {
			    header('Location: '.$_SERVER['REQUEST_URI']);
		    } else {
			    $this->error=array("badlogin"=>1);
			    if(count($this->error)>0) 
				    $this->tpl->assign('err',$this->ArrToStr($this->error, "<br>"));
		    }
	    }

	    if($_GET["go"]=="logout") {
		    if($this->en->IsLoggedIn() == true) {
			    $this->en->Logout();
			    
		    }
		    header('Location: '.SITE_URL);
	    }
	    
	    $this->SetNotification();
		
		$this->tpl->assign('installations',$this->GetInstallationsList());
	}

	protected function SendSettings() {
		global $settings_ver;
		global $a;

		$this->tpl->assign("parama", $a);
		$this->tpl->assign("settings_ver", $settings_ver);
		$this->tpl->assign("settings_dir", SETTINGSDIR);
		$this->tpl->assign("themedir", THEMEDIR);
		
		$this->tpl->assign("siteUrl", SITE_URL);
		$this->tpl->assign("siteName", SITE_NAME);
		$this->tpl->assign("module", MODULE);
		$this->tpl->assign("perm", $this->perm);
	}

	protected function SendEngineData() {
		$this->tpl->assign("en", $this->en);
		$this->tpl->assign("add", $this->add);		
	}
	
	protected function BezPL($tekst) {
		$s=array('ż','ź','ć','ń','ą','ś','ł','ę','ó','Ż','Ź','Ć','Ń','Ą','Ś','Ł','Ę','Ó');
		$z=array('z','z','c','n','a','s','l','e','o','Z','Z','C','N','A','S','L','E','O');
		return str_replace($s,$z,$tekst);
	}
	
	
	protected function Odmiana($ile, $co) {
		switch($co) {
			case 'pokoje': 
				if($ile==1) $odmiana="pokój";
				elseif($ile<5) $odmiana="pokoje";
				else $odmiana="pokoi";
				break;
			case 'pakiety': 
				if($ile==1) $odmiana="pakiet";
				elseif($ile<5) $odmiana="pakiety";
				else $odmiana="pakietów";
				break;
			case 'dni': 
				if($ile==1) $odmiana="dzień";
				elseif($ile<5) $odmiana="dni";
				else $odmiana="dni";
				break;
			case 'nocy': 
				if($ile==1) $odmiana="noc";
				elseif($ile<5) $odmiana="noce";
				else $odmiana="nocy";
				break;
		}
		return $odmiana;
	}
	
	
	private function SetNotification() {
		if($_GET['create']==1) $this->tpl->assign('create',true);
		if($_GET['delete']==1) $this->tpl->assign('delete',true);
	}

	private function GetInstallationsList() {
		$dane = array();
		$dane[]=array("id"=>1, "nazwa"=>"Magnes.com.pl");
		return $dane;
	}
	
	private function ArrToStr($arr,$br=" ") {
		if(is_array($arr)) return implode($br, $arr);
		else return $arr;
	}
	
	########### CURL
	protected function setCallback($func_name) {
	    $this->callback = $func_name;
	}
	
	protected function doRequest($method, $url, $vars) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    if ($method == 'POST') {
	        curl_setopt($ch, CURLOPT_POST, 1);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
	    }
	    $data = curl_exec($ch);
	    
	    if ($data) {
	        if ($this->callback)
	        {
	            $callback = $this->callback;
	            $this->callback = false;
	            return call_user_func($callback, $data);
	        } else {
	            return $data;
	        }
	    } else {
	        return curl_error($ch);
	    }
	    curl_close($ch);
	}
	
	protected function reqget($url) {
	    return $this->doRequest('GET', $url, 'NULL');
	}
	
	protected function reqpost($url, $vars) {
	    return $this->doRequest('POST', $url, $vars);
	}
	
	
	
	protected function SendSmsMessage($numer, $wiadomosc) {
		$url="https://www.serwersms.pl/zdalnie/index.php";
		
		$vars=array(
		"akcja"=>"wyslij_sms",
		"login"=>SMS_LOGIN,
		"haslo"=>SMS_HASLO,
		"numer"=>$numer,
		"wiadomosc"=>$wiadomosc,
		"test"=>0
		);
		$dane=$this->reqpost($url, $vars);
		
		$dane=str_replace("\n", "", $dane);
		$dane=str_replace("\r", "", $dane);
		preg_match('|<Skolejkowane>(.*)<\/Skolejkowane>|U',$dane, $odp);
		$odp=$odp[1];
		
		if($odp!="") return true;
		
		return $dane;
	}
	
	//MAILER
	protected function SendMessage($subject, $content, $recipent, $sender, $sendername, $method="mail", $conf=array()) {
		/** If you're using sendmail or smtp for senting mails, you need to setup mailer using $conf array.
		 *  SENDMAIL:
		 *  1) set option $method to "sendmail";
		 *  2) configure path to sendmail, using "sendmailpath" key, eg. $conf['sendmailpath'] = '/usr/sbin/sendmail'
		 * 
		 * 	SMTP:
		 * 	1) set option $method to "smtp";
		 *  2) configure options (key => value):
		 * 		'host' => 'your smtp host'
		 * 		'port' => 'smtp port'
		 * 		'auth' => 'true or false - use smtp authorisation?'
		 * 		'username' => 'smtp username'
		 * 		'password' => 'smtp password'
		 */
		try {
			switch($method) {
				case "mail":
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				$this->mailer->ClearCustomHeaders();
				$this->mailer->IsMail();
				$this->mailer->CharSet = "UTF-8";
				$this->mailer->AddAddress($recipent);
				$this->mailer->SetFrom($sender, $sendername);
				$this->mailer->AddReplyTo($sender, $sendername);
				$this->mailer->Subject = $subject;
				$this->mailer->MsgHTML($content);
				$this->mailer->Send();
				break;
				
				case "sendmail":
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				$this->mailer->ClearCustomHeaders();
				$this->mailer->IsSendmail();
				$this->mailer->Sendmail = $conf['sendmailpath'];
				$this->mailer->CharSet = "UTF-8";
				$this->mailer->AddAddress($recipent);
				$this->mailer->SetFrom($sender, $sendername);
				$this->mailer->AddReplyTo($sender, $sendername);
				$this->mailer->Subject = $subject;
				$this->mailer->MsgHTML($content);
				$this->mailer->Send();
				break;
				
				case "smtp":
				$this->mailer->ClearAllRecipients();
				$this->mailer->ClearAttachments();
				$this->mailer->ClearCustomHeaders();
				$this->mailer->IsSMTP();
				$this->mailer->Host = $conf['host'];
				$this->mailer->Port = $conf['port'];
				$this->mailer->SMTPAuth = $conf['auth'];
				$this->mailer->Username = $conf['username'];
				$this->mailer->Password = $conf['password'];
				$this->mailer->CharSet = "UTF-8";
				$this->mailer->AddAddress($recipent);
				$this->mailer->SetFrom($sender, $sendername);
				$this->mailer->AddReplyTo($sender, $sendername);
				$this->mailer->Subject = $subject;
				$this->mailer->MsgHTML($content);
				$this->mailer->Send();
				break;
			}
			return true;

		} catch (phpmailerException $e) {
		  return false;
		} catch (Exception $e) {
		  return false;
		}
	}
}
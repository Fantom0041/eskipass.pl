<?php

/**
 * Klasa obsługuje system pocztowy aplikacji
 * @package Application
 * @subpackage Libs
 */
class Mailsend{
	
	private static $active = false;
	private static $en = false;
	
        /**
         * Aktywacja klasy
         */
	public static function activate() {
        if(!self::$active){
           Tools::activate();
           self::$en = Database::activate();
           self::$active = true;
        }	
	}
		
        /**
         * Klasa odpowiedzialna za przygotowanie i wysyłkę wiadomości wg. szablonu
         * @param string $section Wzór wiadomości email
         * @param array $params Zmienne miela
         * @return boolean
         */
	public static function SendEmail($section, $params, $sender = false ) {
//            die(var_dump($params));
            if( !self::$active )
            {
                self::activate();
            }

            if ( !$sender )
            {
            	$sender = MAILER_FROM;
            }
            
            if ( $params[ 'email' ] != '' )
            {
                $sql = "SELECT ml.*, m.attach FROM " . TABLE_PREFIX . "mail m LEFT JOIN " . TABLE_PREFIX . "mail_lang ml ON ml.item=m.id WHERE m.section='" . self::$en->Escape( $section ) . "' AND ml.lang_id=" . $params[ 'lang' ];
                $email_template = self::$en->select_r( $sql );
                $subject = self::ReplaceTags( $email_template[ 'nazwa' ], $params );
                $body = self::ReplaceTags( $email_template[ 'content' ], $params );
                $files = array();
                if($email_template[ 'attach' ] != "" && $params[ 'ubezpieczenie' ] === true) $files = unserialize($email_template[ 'attach' ]);
                if(is_array($params['files'])){
                    $files = array_merge($files, $params['files']);
                }
                file_put_contents('filesmails.txt', var_export($params['files'],true));
                self::SendMessage( $subject, $body, $params[ 'email' ], $sender, MAILER_NAME, MAILER, unserialize(MAILER_CONF), $files );
                
                return true;
            }
            
            return false;
        }
	
        
	private static function ReplaceTags($content, $params) {
		$tags = self::GetTagsAvailable();
		foreach($tags as $t) {
			$content = str_replace($t['tag'], $params[md5($t['tag'])], $content);
		}
		return $content;
	}
	
        /**
         * Klasa odpowiedzialna za wysyłkę gotowej wiadomości
         * @param string $subject Temat meila
         * @param string $content Treść meila
         * @param string $recipent Odbiorca
         * @param string $sender Adres e-mail wysyłającego
         * @param string $sendername Nazwa wysyłającego
         * @param string $method Sterownik systemowy odpowiedzilny za wysyłkę. Default 'mail'. Możliwe: <b>mail</b>, <b>sendmail</b>, <b>smtp</b>
         * @param array $conf Konfiguracja początkowa klasy PHPMailer Default empty
         * @see PHPMailer
         * @return boolean
         */
	public static function SendMessage($subject, $content, $recipent, $sender, $sendername, $method="mail", $conf=array(), $files=array()) {
		$mailer = new PHPMailer;
		
		
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
		$replyTo = $sender;
		if(array_key_exists('replyTo',$conf)){
		    $replyTo = $conf['replyTo'];
        }
		try {
			switch($method) {
				case "mail":
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();
					$mailer->ClearCustomHeaders();
					$mailer->IsMail();
					$mailer->CharSet = "UTF-8";
					if(is_array($files) && count($files)>0){
						foreach($files as $f) {
							$mailer->AddAttachment($f['plik'],$f['nazwa']);
						}
					}
					$mailer->AddAddress($recipent);
					$mailer->SetFrom($sender, $sendername);
					$mailer->AddReplyTo($replyTo, $replyTo);
					$mailer->Subject = $subject;
					$mailer->MsgHTML($content);
					$mailer->Send();
					break;
	
				case "sendmail":
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();
					$mailer->ClearCustomHeaders();
					$mailer->IsSendmail();
					$mailer->Sendmail = $conf['sendmailpath'];
					$mailer->CharSet = "UTF-8";
					if(is_array($files) && count($files)>0){
						foreach($files as $f) {
							$mailer->AddAttachment($f['plik'],$f['nazwa']);
						}
					}
					$mailer->AddAddress($recipent);
					$mailer->SetFrom($sender, $sendername);
					$mailer->AddReplyTo($replyTo, $replyTo);
					$mailer->Subject = $subject;
					$mailer->MsgHTML($content);
					$mailer->Send();
					break;
	
				case "smtp":
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();
					$mailer->ClearCustomHeaders();
					$mailer->IsSMTP();
					$mailer->Host = $conf['host'];
					$mailer->Port = $conf['port'];
					$mailer->SMTPAuth = $conf['auth'];
                    $mailer->SMTPSecure = $conf['SMTPSecure'];
                    if ($mailer->SMTPSecure === 'tls' || $mailer->SMTPSecure === 'ssl') {
                        $mailer->SMTPAutoTLS = true;
                        $mailer->SMTPOptions = [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            ]
                        ];
                    }
					$mailer->Username = $conf['username'];
					$mailer->Password = $conf['password'];
					$mailer->CharSet = "UTF-8";
					if(is_array($files) && count($files)>0){
						foreach($files as $f) {
							$mailer->AddAttachment($f['plik'],$f['nazwa']);
						}
					}
					$mailer->AddAddress($recipent);
					$mailer->SetFrom($sender, $sendername);
					$mailer->AddReplyTo($replyTo, $replyTo);
					$mailer->Subject = $subject;
					$mailer->MsgHTML($content);
					$mresp = $mailer->Send();
					break;
			}
                        if(DEBUG){
                            @file_put_contents('maile_log.txt', date('Y-m-d H:i:s')."\t".$subject."\t".$recipent."\t".$method." - resp: $mresp\n", FILE_APPEND);
                        }
			return true;
	
		} catch (phpmailerException $e) {
			$log_message = date('Y-m-d H:i:s') . "\t" .
                           "Subject: " . $subject . "\t" .
                           "Recipient: " . $recipent . "\t" .
                           "Method: " . $method . "\t" .
                           "Error (phpmailerException): " . $e->getMessage() . "\n";
            @file_put_contents('maile_log.txt', $log_message, FILE_APPEND);
		    var_dump($e);
		    die();
			return false;
		} catch (Exception $e) {
			$log_message = date('Y-m-d H:i:s') . "\t" .
                           "Subject: " . $subject . "\t" .
                           "Recipient: " . $recipent . "\t" .
                           "Method: " . $method . "\t" .
                           "Error (Exception): " . $e->getMessage() . "\n";
            @file_put_contents('maile_log.txt', $log_message, FILE_APPEND);
            var_dump($e);
            die();
			return false;
		}
	}
	
	public static function GetTagsAvailable() {
		$tags = array();
		//serwis
		$tags[]=array('tag'=>'%SITE_URL%', 'description'=>App::_Lang('URL serwisu','E-maile'));
		$tags[]=array('tag'=>'%SITE_NAME%', 'description'=>App::_Lang('Nazwa serwisu','E-maile'));
		$tags[]=array('tag'=>'%SITE_EMAIL%', 'description'=>App::_Lang('Główny adres email','E-maile'));
		$tags[]=array('tag'=>'%SITE_TEL%', 'description'=>App::_Lang('Numer telefonu','E-maile'));
		$tags[]=array('tag'=>'%SITE_PARTNERURL%', 'description'=>App::_Lang('URL panelu partnera','E-maile'));
		
		//user
		$tags[]=array('tag'=>'%USER_LOGIN%', 'description'=>App::_Lang('Login użytkownika','E-maile'));
		$tags[]=array('tag'=>'%USER_FNAME%', 'description'=>App::_Lang('Imię użytkownika','E-maile'));
		$tags[]=array('tag'=>'%USER_LNAME%', 'description'=>App::_Lang('Nazwusko użytkownika','E-maile'));
		$tags[]=array('tag'=>'%USER_EMAIL%', 'description'=>App::_Lang('Adres email użytkownika','E-maile'));
		$tags[]=array('tag'=>'%USER_NEWPWD%', 'description'=>App::_Lang('Nowe hasło użytkownika','E-maile'));
		$tags[]=array('tag'=>'%USER_CONFIRMURL%', 'description'=>App::_Lang('URL potwierdzający reset hasła','E-maile'));
		
		//offer
		$tags[]=array('tag'=>'%OFFER_ENDOFSEASON%', 'description'=>App::_Lang('Data końca bieżącego sezonu','E-maile'));
		
		//zamówienia
		$tags[]=array('tag'=>'%ORDER_DETAILS%', 'description'=>App::_Lang('Szczegóły zamówienia - tabelka z produktami i adresami','E-maile'));
		$tags[]=array('tag'=>'%ORDER_ID%', 'description'=>App::_Lang('Numer zamówienia','E-maile'));
		$tags[]=array('tag'=>'%ORDER_DATE%', 'description'=>App::_Lang('Data złożenia zamówienia','E-maile'));
		$tags[]=array('tag'=>'%ORDER_STATUS%', 'description'=>App::_Lang('Aktualny status zamówienia','E-maile'));
		$tags[]=array('tag'=>'%ORDER_PAYURL%', 'description'=>App::_Lang('Link do panelu płatności za zamówienie','E-maile'));
		$tags[]=array('tag'=>'%ORDER_TOTAL%', 'description'=>App::_Lang('Kwota zamówienia','E-maile'));
		$tags[]=array('tag'=>'%INVOICE_LINK%', 'description'=>App::_Lang('Odnośnik do faktury','E-maile'));
		
		//mediacje
		$tags[]=array('tag'=>'%MED_URL%', 'description'=>App::_Lang('Link do ostatniej wiadomości od nas w panelu zwrotów lub mediacji w koncie klienta','E-maile'));
		$tags[]=array('tag'=>'%MED_ID%', 'description'=>App::_Lang('Numer id sprawy dla zwrotu, reklamacji lub mediacji','E-maile'));
		$tags[]=array('tag'=>'%MED_TYPE%', 'description'=>App::_Lang('Rodzaj mediacji','E-maile'));
		$tags[]=array('tag'=>'%MED_WHERE%', 'description'=>App::_Lang('Określa miejsce, w którym użytkownik może znaleźć mediację','E-maile'));


		
		//rozliczenia
		$tags[]=array('tag'=>'%SETTLE_PERIOD%', 'description'=>App::_Lang('Okres rozliczenia','E-maile'));
		$tags[]=array('tag'=>'%SETTLE_INVOICE%', 'description'=>App::_Lang('Numer faktury rozliczeniowej','E-maile'));
		
		
		//WP
		$tags[]=array('tag'=>'%WALLET_BALLANCE%', 'description'=>App::_Lang('Aktualne saldo wirtualnego portfela','E-maile'));
		$tags[]=array('tag'=>'%WALLET_CHARGE_DETAILS%', 'description'=>App::_Lang('Szczegóły operacji na wirtualnym portfelu - tabelka','E-maile'));
		
                //WP VOUCHER
		$tags[]=array('tag'=>'%VOUCHER_SERIAL%', 'description'=>App::_Lang('Numer Vouchera','E-maile'));
		$tags[]=array('tag'=>'%VOUCHER_LINK%', 'description'=>App::_Lang('Link do pliku vouchera','E-maile'));
		
		return $tags;
	}
}

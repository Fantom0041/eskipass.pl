<?php
/**
 * Klasa obsługująca portfel płatności DotPay.pl
 *
 * @package Application
 * 
 * @subpackage Libs
 * 
 * @author Rafal
 */

class DotPay {
    public $payment_data = array();
    
    protected $baza = null;
    
    /**
     * Inicjacja klasy
     * @param mixed $dane_zamowienia Jeżeli array: Tablica z zamówieniem, default: null
     * @param mixed $dane_platnosci Jeżeli array: dane płatności, default: null
     */
    
    public function __contruct ( $dane_zamowienia = null, $dane_platnosci = null ) {
        
        $this->baza = Database::activate();
        
        if( $dane_zamowienia ) {
            
            if( $dane_zamowienia['adres_dostawy'] ) {
                
                $ad = $dane_zamowienia['adres_dostawy'];
                
            } elseif( $dane_zamowienia['adres_faktury'] ) {
                
                $ad = $dane_zamowienia['adres_faktury'];
                
            }                   
        
            if( $ad ) {
                
                $this->payment_data['userdata']['first_name'] = $ad['imie'];
                $this->payment_data['userdata']['last_name'] = $ad['nazwisko'];
                $this->payment_data['userdata']['phone'] = $ad['tel'];
                $this->payment_data['userdata']['email'] = $ad['email'];
                $this->payment_data['userdata']['city'] = $ad['miasto'];
                $this->payment_data['userdata']['postcode'] = $ad['kod'];
                $this->payment_data['userdata']['country'] = $ad['kraj'];

                if( $ad['firma'] ) {
                    
                    $this->payment_data['userdata']['company'] = $ad['firma'];
                    
                }
                
                if( $ad['nip'] ) { 
                    
                    $this->payment_data['userdata']['nip'] = $ad['nip'];
                    
                }
            }

            $this->payment_data['service'] = DP_ID;
            $this->payment_data['amount'] = $dane_zamowienia['koncowa_wartosc_zamowienia_brutto'];
            $this->payment_data['item'] = $dane_zamowienia['id_zamowienia'];
            $this->payment_data['desc'] = 'Zapłata za zamówienie ' . $dane_zamowienia['id_zamowienia'];
            $this->payment_data['client_ip'] = $_SERVER['REMOTE_ADDR'];
            $this->payment_data['user'] = User::GetUserID();
            $this->payment_data['pay_type'] = $dane_zamowienia['system_platnosci'];
            $this->payment_data['module'] = 'order';
            $this->payment_data['id_zamowienia_mgo'] = $dane_zamowienia['id_zamowienia_mgo'];
                                
            $code = $this->payment_data['service']; //DP_ID
            $code .= $this->payment_data['amount'];
            $code .= $this->payment_data['operation_datetime'];
            $code .= $this->payment_data['control'];
            $code .= $this->payment_data['description'];
            $code .= $this->payment_data['userdata']['email'];            
                    
            $this->payment_data['sign'] = hash( 'sha256', $code );
            
        } elseif( $dane_platnosci ) {
            
            $this->payment_data = $dane_platnosci;
            
        }
    }
    
    /**
     * Wykonuje operację płatności na portfelu
     */
    public function MakePayment() {
        
        $this->AddPayment();
        
    }
    
    /**
     * Dodaje dane do tabeli płatności
     * 
     * @return boolean
     * @throws Exception
     */
    public function AddPayment() {
        
        $dane[] = array( 'amount', $this->payment_data['amount'] * 100, 'INT' );
        $dane[] = array( 'desc', $this->payment_data['desc'], 'STRING' );
        $dane[] = array( 'client_ip', $this->payment_data['client_ip'], 'STRING' );
        $dane[] = array( 'item', $this->payment_data['item'], 'INT' );
        $dane[] = array( 'user', $this->payment_data['user'], 'INT' );
        $dane[] = array( 'installation', INSTALLATION, 'INT' );
        $dane[] = array( 'ts', time(), 'STRING' );
        $dane[] = array( 'pay_type', $this->payment_data['pay_type'], 'STRING' );
        $dane[] = array( 'module', $this->payment_data['module'], 'STRING' );
                
        if( $this->payment_data['userdata'] ) {
            
            $dane[] = array( 'first_name', $this->payment_data['userdata']['first_name'], 'STRING' );
            $dane[] = array( 'last_name', $this->payment_data['userdata']['last_name'], 'STRING' );
            $dane[] = array( 'email', $this->payment_data['userdata']['email'], 'STRING' );
            $dane[] = array( 'address', $this->payment_data['userdata']['address'], 'STRING' );
            $dane[] = array( 'city', $this->payment_data['userdata']['city'], 'STRING' );
            $dane[] = array( 'first_name', $this->payment_data['userdata']['first_name'], 'STRING' );
            
            if ( $this->company ) {
                
                $dane[] = array( 'company', $this->$this->payment_data['userdata']['company'], 'STRING' );
                
            }
            
            if ( $this->nip ) {
                
                $dane[] = array( 'nip', $this->$this->payment_data['userdata']['nip'], 'STRING' );
                
            }
        }
        
        if ( $this->baza->insert_row( 'platnosci', $dane ) ) {
            
            return true;
            
        } else {
            
            throw new Exception( 'Nie udało się dodać płatności do bazy' );
            
        }
    }
    
    /**
     * Przygotowanie danych formularza
     * @return array
     */
    public function FormData() {
        
        $form_data['action'] = DP_PAYMENT;
        $form_data['method'] = 'POST';
        $form_data['input']  = array();
        $form_data['input']['type']          = DP_TYPE; //4 
        $form_data['input']['id']            = DP_ID;
        $form_data['input']['currency']      = 'PLN';
        $form_data['input']['amount']        = $this->payment_data['amount'];       
        $form_data['input']['description']   = $this->payment_data['desc'];
        $form_data['input']['lang']          = 'PL';
        $form_data['input']['control']       = $this->payment_data['id_zamowienia_mgo'];
        $form_data['input']['URL']           = DP_URL;
        $form_data['input']['buttontext']    = 'Powrót do sklepu';
        
        if ( $this->payment_data['userdata'] ) {
            
            $form_data['input']['firstname']  = substr( $this->payment_data['userdata']['first_name'], 0, 32 );
            $form_data['input']['lastname']   = substr( $this->payment_data['userdata']['last_name'], 0, 32 );
            $form_data['input']['email']      = substr( $this->payment_data['userdata']['email'], 0, 127 );            
            $form_data['input']['street']     = substr( $this->payment_data['userdata']['address'], 0, 100 );            
            $form_data['input']['city']       = substr( $this->payment_data['userdata']['city'], 0, 40 );
            $form_data['input']['country']    = 'PL';            
            $form_data['input']['postcode']   = substr( $this->payment_data['userdata']['postcode'], 0, 32 );
            
        }
        
        return $form_data;
    }
}

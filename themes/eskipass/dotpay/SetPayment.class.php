<?php

class SetPayment {
    public $id_systemu;
    public $dane_platnosci;
    public $dane_zamowienia;
    
    public function addSystem() {
        if( $this-> id_systemu ) {
            switch ( $this->id_systemu ) {
                case PAYDP_ID:
                    $this->system = new DotPay( $this->dane_zamowienia, $this->dane_platnosci );
                    break;
                //...
            }
        }
    }
    
    public function checkResponse( $response ) {
        switch ( $this->id_systemu ) {
            case PAYDP_ID: 
                if ( strtoupper( $response['status'] ) != 'OK' ) {
                    throw new Exception( 'Błędny status odpowiedzi' );
                } else {
                    $sign = P_ID;
                    $sign .= $response['amount'];
                    $sign .= $response['operation_datetime'];
                    $sign .= $response['control'];
                    $sign .= $response['description'];
                    $sign .= $response['userdata']['email'];
                    
                    $sign = hash( 'sha256', $sign );
                    
                    if( $sign != $response['sign'] ) {
                        throw new Exception( 'Nieprawidłowy klucz odpowiedzi' );
                    }
                }
                break;
            //...
        }
    }
}

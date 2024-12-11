<?php

class Payment {
    //..
    protected function Notify() {
        $type = $this->app->urlparam['type'];
        
        switch( strtoupper( $type ) ) {
            //..
            case 'DOTPAY':
                try {
                    $response = $this->app->postparam;
                    $payment = new SetPayment();
                    $payment->getPaymentData( $response['userdata'] );
                    $payment->addSystem();
                    $payment->checkResponse( $response );
                    $payment->finishPaymentSystem();
                    
                } catch (Exception $e) {
                    $data[] = array( 'opis', $e->getMessage(), 'STRING' );
                    $data[] = array( 'user', 0, 'INT' );
                    $data[] = array( 'rid', 0, 'INT' );
                    $data[] = array( 'rodaj', 'payment_notify', 'STRING' );
                    $data[] = array( 'data', date('Y-m-d H:i:s'), 'STRING' );
                    $this->baza->insert_row( 'log', $data );
                }
                
                echo "OK";
                
                break;
        }
    }
}

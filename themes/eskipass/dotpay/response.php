<?php

define( 'PID', '788580' );
define( 'PIN', '1LHcCFvfRgvP97vul2CzSeDg3rlFo7AM' );
define( 'PAYMENT_URL', 'https://ssl.dotpay.pl/test_payment' );
define( 'DOTPAY_IP', '195.150.9.37' );

function makeSignature( $postparam ) {
    $signature = md5(PIN.":".$postparam['id'].":".$postparam['control'].":".$postparam['t_id'].":".$postparam['amount'].":".$postparam['email'].":".$postparam['service'].":".$postparam['code'].":".$postparam['username'].":".$postparam['password'].":".$postparam['t_status']);
    return $signature;
}

if( isset( $_POST ) ) {
    $postparam = $_POST;
    
    $signature = makeSignature( $postparam );
    
    // Przeszukanie bazy po numerze transakcji w celu ustalenia czy nie było już powiadomienia dla danej transakcji np. ze statusem NOWA. 
    // Numer transakcji jest numerem unikalnym. 
    $check = "SELECT * FROM `urlc` WHERE numer_transakcji = '{$numer_transakcji}'";
    $go_check = mysql_query($check);
    $count_rows = mysql_num_rows($go_check);
    
    //Jeśli sygnatura jest poprawna a w bazie nie ma jeszcze transakcji o numerze z parametru t_id
    //i trasakcja nie jest testowa dodany zostanie dodany nowy rekord w bazie.
    if ($count_rows == 0 && $signature == $postparam['md5'] && PID == $postparam['id'] && $_SERVER['REMOTE_ADDR'] == DOTPAY_IP ){
        
        echo "OK";
        exit;        
        
    } elseif( $count_rows != 0 && $signature == $postparam['md5'] && PID == $postparam['id'] && $_SERVER['REMOTE_ADDR'] == DOTPAY_IP ) { 
        // Jeśli dane transakcji są już w bazie to uaktualniamy jej status
        
        $new_status = "";
        
        switch( $status ) {
            case "1": $new_status = "NOWA"; break;
            case "2": $new_status = "WYKONANA"; break;
            case "3": $new_status = "ODRZUCONA"; break;
            case "4": $new_status = "ANULOWANA"; break;
            case "5": $new_status = "REKLAMACJA"; break;
            default: $new_status = "NOWA";
        }
        
        
        
        echo "OK";
        exit;
    } else {
        
        echo "ERROR";   
        exit;
    }
    exit;
}

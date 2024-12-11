<?php 
define( 'PID', '788580' );
define( 'PAYMENT_URL', 'https://ssl.dotpay.pl/test_payment' );

$dotpay = array(
    'client'    =>  array(
        'firstname' =>  'Jan',
        'lastname'  =>  'Kowalski',
        'email'     =>  'kowal@kowal.pl',
        'street'    =>  'Kowali',
        'street_n1' =>  '12',
        'street_n2' =>  '1a',
        'city'      =>  'Olsztyn',
        'postalcode'=>  '11-111'
    ),
    'payment'   =>  array(
        'account'       =>  '100.99',
        'currency'      =>  'PLN',
        'description'   =>  'Zapłata za..',
        'lang'          =>  'pl',
        'URL'           =>  'http://eskipass.tekw.info/dotpay/status.php',
        'control'       =>  '9999',
    )
);
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>DotPay.pl - test</title>
    </head>
    <body>
    
        <form action="<?php echo PAYMENT_URL;?>" method="post">
            <input type="hidden" name="id" value="<?php echo PID;?>" />
            <input type="hidden" name="account" value="<?php echo $dotpay['payment']['amount'];?>" />
            <input type="hidden" name="currency" value="<?php echo $dotpay['payment']['currency'];?>" />
            <input type="hidden" name="description" value="<?php echo $dotpay['payment']['description'];?>" />
            <input type="hidden" name="lang" value="<?php echo $dotpay['payment']['lang'];?>" />
            <input type="hidden" name="URL" value="<?php echo $dotpay['payment']['URL'];?>" />	
            <input type="hidden" name="control" value="<?php echo $dotpay['payment']['control'];?>" />

            <input type="hidden" name="firstname" value="<?php echo $dotpay['payment']['firstname'];?>" />
            <input type="hidden" name="lastname" value="<?php echo $dotpay['payment']['lastname'];?>" />
            <input type="hidden" name="email" value="<?php echo $dotpay['payment']['email'];?>" />
            <input type="hidden" name="street" value="<?php echo $dotpay['payment']['street'];?>" />
            <input type="hidden" name="street_n1" value="<?php echo $dotpay['payment']['street_n1'];?>" />
            <input type="hidden" name="street_n2" value="<?php echo $dotpay['payment']['street_n2'];?>" />
            <input type="hidden" name="city" value="<?php echo $dotpay['payment']['city'];?>" />
            <input type="hidden" name="postcode" value="<?php echo $dotpay['payment']['postalcode'];?>" />

            <input type="submit" value="zaplac" />
        </form>
        
    </body>
</html>
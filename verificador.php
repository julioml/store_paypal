<?php
    print_r($_GET);
    $ClientID="AenYNClyuRnl9GmeZlLhmDyypxqHxUSFw3iLluMBUve4Rl8wNYBmpUsYqDMLaPuZVSfKgibq0P-xCU-R";
    $Secret="EBaOeZQs79nkB-myTwWIJAm_8mewJkbQnV-Kg0bLFCbD1VOpjvi-2_II62_0DSmA4YSpkYmC6Xk_pgGC";

    $Login = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");
    curl_setopt($Login, CURLOPT_USERPWD, $ClientID.":".$Secret);
    curl_setopt($Login, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($Login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $Respuesta=curl_exec($Login);
    
    $objRespuesta = json_decode($Respuesta);
    $AccessToken = $objRespuesta->access_token;
    print_r($AccessToken);

    $venta=curl_init("https://api-m.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']."/execute");
    curl_setopt($venta, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer ".$AccessToken));
    curl_setopt($venta, CURLOPT_USERPWD, "payer_id:".$_GET['payerID']);
    $RespuestaVenta=curl_exec($venta);
    print_r($RespuestaVenta);
?>
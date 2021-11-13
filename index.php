<?php
header('refresh: 60');//REFRESH OF QUERY
include "functions.php";
include "config.php";//$token(telegram bot) $client_id(avito api) $client_secret(avito api)
//-------------------------------------DB CONNECT-------------------------------------------------------//
$pdo=db_connect();//COONECTING TO DATABASE
telegram_messenger($token);//TELEGRAM EXCHANGE
$recipients=get_recipients($pdo);//GET RECIPIENTS LIST FROM DATABASE
$data=get_data_from_avito();//GET DATA FROM AVITO MARKET PAGE
// echo '<pre>';
// print_r($data);
put_data($pdo, $data, $recipients, $token);//PUT SIGNALS IN TELEGRAM
// $response=file_get_contents('https://avito.ru/oauth?response_type=code&client_id='.
// $client_id.'&scope=messenger:read,messenger:write');
// print_r($response);
?>
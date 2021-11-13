<?php
header('refresh: 60');//REFRESH OF QUERY
include "functions.php";
include "config.php";//$token(telegram bot) $client_id(avito api) $client_secret(avito api)
include "avito_message_sending.php";
include "telegram_bot_talk.php";
//-------------------------------------DB CONNECT-------------------------------------------------------//
$pdo=db_connect();//COONECTING TO DATABASE
telegram_messenger($token);//TELEGRAM EXCHANGE
$recipients=get_recipients($pdo);//GET RECIPIENTS LIST FROM DATABASE
$avito_messages=get_message_templates($pdo);//GET TEMPLATES OF ANSWER ON AVITO
$data=get_data_from_avito();//GET DATA FROM AVITO MARKET PAGE
// echo '<pre>';
// print_r($data);
put_data($pdo, $data, $recipients, $token);//PUT SIGNALS IN TELEGRAM

//avito_message_send('216016082', 'u2i-2280841386-216016082', text_of_message_randomizer($avito_messages));
//first param-user_id, second param-chat_id, third param-text of message
?>
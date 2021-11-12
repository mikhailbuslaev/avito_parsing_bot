<?php
header('refresh: 60');//REFRESH OF QUERY
include "functions.php";
$token='2038362504:AAECSDSnzU3w3awKr9c6Go6LqcuvT_6dhv0';
//-------------------------------------DB CONNECT-------------------------------------------------------//
$pdo=db_connect();
////////////////////////////////////////TELEGRAM EXCHANGE///////////////////////////////////////////////////////
$bot_data=file_get_contents('https://api.telegram.org/bot'.$token.'/getUpdates');
$bot_data=json_decode($bot_data);
$bot_data=json_decode(json_encode($bot_data), true);
//--------------------------------------CHECKING INCOME MESSAGES---------------------------------------------//
while ($bot_data[result][0][message][text]!=false) {
//--------------------------------------START AND STOP FUNCTION---------------------------------------------//
switch ($bot_data[result][0][message][text]) {

    case '/start':
        $add_recipients_request='insert into recipients(recipient_id) values('.$bot_data[result][0][message][chat][id].')';
        $pdo->query($add_recipients_request);
        sendMessage(array("chat_id" => $bot_data[result][0][message][chat][id], "text" => 'Bot is started'), $token);
        $offset=$bot_data[result][0][update_id]+1;
        break;
    case '/stop':
        sendMessage(array("chat_id" => $bot_data[result][0][message][chat][id], "text" => 'Bot is stopped'), $token);
        $delete_recipients_request='delete from recipients where recipient_id='.$bot_data[result][0][message][chat][id];
        $pdo->query($delete_recipients_request);
        $offset=$bot_data[result][0][update_id]+1;
        break;
    default:
        break;
    }
$offset=strval($offset);
$param='?offset='.$offset;
$bot_data=file_get_contents('https://api.telegram.org/bot'.$token.'/getUpdates'.$param);
$bot_data=file_get_contents('https://api.telegram.org/bot'.$token.'/getUpdates');
$bot_data=json_decode($bot_data);
$bot_data=json_decode(json_encode($bot_data), true);
}


////////////////////////////////////////PARSING AVITO AND SENDING MESSAGES PART////////////////////////////////////
//--------------------------------------GET RECIPIENTS LIST FROM DATABASE-------------------------------//
$get_recipients_request='select recipient_id from recipients';
$recipients=$pdo->query($get_recipients_request);
$recipients=$recipients->fetchAll();
//--------------------------------------GET DATA FROM AVITO MARKET PAGE---------------------------------//
$data=get_data_from_avito();
//------------------------------------PUT DATA IN TELEGRAM-----------------------------------------------//
$put_data = $pdo->prepare("insert into avito_parsing(reference, price, description) values(?, ?, ?)");
$data_array_count=count($data);
for ($i = 0; $i < $data_array_count; $i++) {
    $unique_check = $pdo->prepare("select reference from avito_parsing where reference = :reference");
    $unique_check->bindParam(':reference', $data[$i]['reference'], PDO::PARAM_STR);
    $unique_check->execute();
    $unique_check = $unique_check->fetchAll();
    $unique_check=$unique_check[0][0];
//------------------------------------CHECK OF ORDER UNIQUENESS------------------------------------------//
    if ($unique_check==false) {
        $put_data->bindParam(1, $data[$i]['reference']);
        $put_data->bindParam(2, $data[$i]['price']);
        $put_data->bindParam(3, $data[$i]['description']);
        $put_data->execute();
        //----------------------------------------------TELEGRAM MESSAGE SENDING--------------------------//
        $recipients_count=count($recipients);
        for ($j=0; $j < $recipients_count; $j++) { 
            sendMessage(array("chat_id" => $recipients[$j][recipient_id], "text" => $data[$i]['reference'].' '.$data[$i]['price'].' руб'), $token);
        }

    }
}

?>
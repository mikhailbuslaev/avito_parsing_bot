<?php
function telegram_messenger($token) {
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
}
?>
<?php

function avito_message_send($user_id, $chat_id, $text_of_message, $client_id, $client_secret) {
    $response=file_get_contents('https://api.avito.ru/token/?grant_type=client_credentials&client_id='.
    $client_id.'&client_secret='.$client_secret);
    print_r($response);
    $response=json_decode($response);
    $avito_access_token=$response->access_token;
    $message = new avito_message;
    $message->text=$text_of_message;
    $avito_message=json_encode(array("message"=>$message, "type"=>"text"));

    $sURL = 'https://api.avito.ru/messenger/v1/accounts/'.$user_id.'/chats/'.$chat_id.'/messages';
    $aHTTP = array(
    'http' =>
        array(
        'method'  => 'POST',
        'header'  => 'Authorization: Bearer '.$avito_access_token,
        'content' => $avito_message
    )
    );
    $context = stream_context_create($aHTTP);
    $contents = file_get_contents($sURL, false, $context);
}
?>
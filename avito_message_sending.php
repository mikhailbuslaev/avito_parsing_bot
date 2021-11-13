<?php
function avito_message_send($user_id, $chat_id) {
    $response=file_get_contents('https://api.avito.ru/token/?grant_type=client_credentials&client_id='.
    $client_id.'&client_secret='.$client_secret);
    print_r($response);
    $response=json_decode($response);
    $avito_access_token=$response->access_token;

    class avito_message
    {
        public $text;
    }

    $message = new avito_message;
    $message->text="Здравствуйте";
    $avito_message=json_encode(array("message"=>$message, "type"=>"text"));

    $sURL = 'https://api.avito.ru/messenger/v1/accounts/'.$user_id.'/chats/'.$chat_id.'/messages'; // URL-адрес POST 
    //$avito_message = "name=Jacob&bench=150"; // Данные POST
    $aHTTP = array(
    'http' => // Обертка, которая будет использоваться
        array(
        'method'  => 'POST', // Метод запроса
        // Ниже задаются заголовки запроса
        'header'  => 'Authorization: Bearer '.$avito_access_token,
        'content' => $avito_message
    )
    );
    $context = stream_context_create($aHTTP);
    // $contents = file_get_contents($sURL, false, $context);
}
?>
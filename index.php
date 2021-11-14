<?php
header('refresh: 60');//REFRESH OF QUERY
include "functions.php";
include "config.php";//$token(telegram bot) $client_id(avito api) $client_secret(avito api)
include "avito_message_sending.php";
include "telegram_bot_talk.php";
class avito_message
{
    public $text;
}
//-------------------------------------DB CONNECT-------------------------------------------------------//
$pdo=db_connect();//COONECTING TO DATABASE
telegram_messenger($token);//TELEGRAM EXCHANGE
$recipients=get_recipients($pdo);//GET RECIPIENTS LIST FROM DATABASE
$data=get_data_from_avito();//GET DATA FROM AVITO MARKET PAGE
// echo '<pre>';
// print_r($data);
put_data($pdo, $data, $recipients, $token, $user_id, $client_id, $client_secret);

// $response=file_get_contents('https://api.avito.ru/token/?grant_type=client_credentials&client_id='.
// $client_id.'&client_secret='.$client_secret);
// print_r($response);
// $response=json_decode($response);
// $avito_access_token=$response->access_token;
// $text_of_message='Здравствуйте';
// $avito_access_token='ageXzTgiSLCqxAv9swkIVwD7nycbZsUptziCrhKQ';
// $message = new avito_message;
// $message->text=$text_of_message;
// $avito_message=json_encode(array("message"=>$message, "type"=>"text"));
// $chat_id='u2i-2266109428-216016082';
// $sURL = 'https://api.avito.ru/messenger/v1/accounts/216016082/chats/'.$chat_id.'/messages';
// $aHTTP = array(
// 'http' =>
//     array(
//     'method'  => 'POST',
//     'header'  => 'Authorization: Bearer '.$avito_access_token,
//     'content' => $avito_message
// )
// );
// $context = stream_context_create($aHTTP);
// $contents = file_get_contents($sURL, false, $context);
// fetch("https://www.avito.ru/k8s/events/put", {
//     "headers": {
//       "accept": "*/*",
//       "accept-language": "ru,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
//       "cache-control": "no-cache",
//       "content-type": "text/plain;charset=UTF-8",
//       "pragma": "no-cache",
//       "sec-fetch-dest": "empty",
//       "sec-fetch-mode": "cors",
//       "sec-fetch-site": "same-origin"
//     },
//     "referrer": "https://www.avito.ru/moskva/telefony/iphone_xr_128_gb_2262806947",
//     "referrerPolicy": "strict-origin-when-cross-origin",
//     "body": "{\"eid\":3184,\"version\":0,\"src_id\":96,\"uid\":216016082,\"s\":\"from_mini_messenger\"}",
//     "method": "POST",
//     "mode": "cors",
//     "credentials": "include"
//   });

//   fetch("https://www.avito.ru/profile/messenger/channel/u2i-2262806947-216016082", {
//     "headers": {
//       "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
//       "accept-language": "ru,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
//       "cache-control": "no-cache",
//       "pragma": "no-cache",
//       "sec-fetch-dest": "document",
//       "sec-fetch-mode": "navigate",
//       "sec-fetch-site": "same-origin",
//       "sec-fetch-user": "?1",
//       "upgrade-insecure-requests": "1"
//     },
//     "referrer": "https://www.avito.ru/moskva/telefony/iphone_xr_128_gb_2262806947",
//     "referrerPolicy": "strict-origin-when-cross-origin",
//     "body": null,
//     "method": "GET",
//     "mode": "cors",
//     "credentials": "include"
//   });

//   fetch("https://m.avito.ru/profile/messenger/channel/u2i-2262806947-216016082", {
//     "headers": {
//       "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
//       "accept-language": "ru,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
//       "cache-control": "no-cache",
//       "pragma": "no-cache",
//       "sec-fetch-dest": "document",
//       "sec-fetch-mode": "navigate",
//       "sec-fetch-site": "same-site",
//       "sec-fetch-user": "?1",
//       "upgrade-insecure-requests": "1"
//     },
//     "referrer": "https://www.avito.ru/",
//     "referrerPolicy": "strict-origin-when-cross-origin",
//     "body": null,
//     "method": "GET",
//     "mode": "cors",
//     "credentials": "include"
//   });

//   fetch("https://www.avito.ru/profile/messenger/channel/u2i-2262806947-216016082", {
//     "headers": {
//       "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
//       "accept-language": "ru,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
//       "cache-control": "no-cache",
//       "pragma": "no-cache",
//       "sec-fetch-dest": "document",
//       "sec-fetch-mode": "navigate",
//       "sec-fetch-site": "same-site",
//       "sec-fetch-user": "?1",
//       "upgrade-insecure-requests": "1"
//     },
//     "referrer": "https://www.avito.ru/",
//     "referrerPolicy": "strict-origin-when-cross-origin",
//     "body": null,
//     "method": "GET",
//     "mode": "cors",
//     "credentials": "include"
//   });
?>
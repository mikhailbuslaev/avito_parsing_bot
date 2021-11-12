<?php

function db_connect() {
    try {
        $pdo = new PDO('pgsql:host=mbesl;port=5432;dbname=avito_parsing;user=postgres;password=postgres');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
return $pdo;
}

function get_data_from_avito() {
    $page = file_get_contents('https://www.avito.ru/moskva?q=iphone+xr&s=104');//FIND IPHONE XR WITH SORTING BY DATE OF PUBLICATION
    //THIS URL IS OPTIONAL
    preg_match_all('#<div class="iva-item-titleStep-_CxvN">(.+?)</div>#su', $page, $reference1);//GET LINK PART1
    $reference1_count=count($reference1[0]);
    for ($i = 0; $i < $reference1_count; $i++) {
        preg_match_all('#"/moskva/telefony(.+?)"#su', $reference1[0][$i], $reference[$i]);//GET LINK PART2
        $reference[$i] = $reference[$i][0][0];
        $reference[$i] = str_replace('"', '', $reference[$i]);
        $reference[$i] = 'https://www.avito.ru' . $reference[$i];
    }
    preg_match_all('#<span class="price-text-E1Y7h text-text-LurtD text-size-s-BxGpL">(.+?)</span>#su', $page, $price1);//GET PRICE PART1
    $price1_count=count($price1[0]);
    for ($i = 0; $i < $price1_count; $i++) {
        preg_match_all('#>(.+?)<#su', $price1[0][$i], $price[$i]);//GET PRICE PART2
        $price[$i] = $price[$i][0][0];
        $price[$i] = str_replace("\xc2\xa0", '', $price[$i]);
        $price[$i] = str_replace(array('<', '>'), '', $price[$i]);
        $price[$i] = intval($price[$i]);
    }

    preg_match_all('#<div data-marker="item-date" class="date-text-VwmJG text-text-LurtD text-size-s-BxGpL text-color-noaccent-P1Rfs">(.+?)</div>#su', $page, $date);//GET DATE OF PUBLICATION
    preg_match_all('#<div class="iva-item-text-_s_vh iva-item-description-S2pXQ text-text-LurtD text-size-s-BxGpL">(.+?)</div>#su', $page, $description1);//GET DESCRIPTION PART1
    $desciption1_count=count($description1[0]);
    for ($i=0; $i < $desciption1_count; $i++) { 
        preg_match_all('#>(.+?)<#su', $description1[0][$i], $description[$i]);//GET DESCRIPTION PART2
        $description[$i]=$description[$i][0][0];

    $description[$i] = str_replace(array('<', '>'), '', $description[$i]);
    }
    $date = $date[1];
    //-----------------------------------------GET DATA ARRAY--------------------------------------------//
    $price_count=count($price);
    for ($i = 0; $i < $price_count; $i++) {
        $data[$i]['reference'] = $reference[$i];
        $data[$i]['price'] = $price[$i];
    //	$data[$i]['date']=$date[$i];
        $data[$i]['description'] = $description[$i];
        if ($data[$i]['reference'] == '' || $data[$i]['price'] > 23000 || $data[$i]['price'] < 10000) { //ORDER FILTER
            unset($data[$i]);
        }
    }
    $data = array_values($data);//ARRAY INDEX RECOUNT
return $data;
}
function sendMessage($parameters, $token) {

    $url='https://api.telegram.org/bot'.$token.'/sendMessage';
    if (!$curl = curl_init()) {
        exit();
    }
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $output=curl_exec($curl);
    return $output;
}
?>
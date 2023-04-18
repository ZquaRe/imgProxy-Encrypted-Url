<?php
echo generateProxyUrl(
    [
        'proxy_url' => 'http://192.168.88.130:8080',
        'url' => 'https://www.google.com.tr/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
        'gravity' => 'no',
        'extension' => 'jpg',
        'key' => '6ce30b284853daeccef9b0e4672ad27c0f5e8b16426065026064273bf169835d',
        'salt' => '6ce30b284853daeccef9b0e4672ad27c0f5e8b16426065026064273bf169835d',
        'height' => '150',
        'width' => '150',
        'resize' => 'fit',
        'enlarge' => '1',
    ]);


function generateProxyUrl($opts) {
    // URL'yi base64 olarak kodlar
    $encoded_url = base64_encode($opts['url']);
    // "=" karakterlerini çıkarır
    $encoded_url = str_replace("=", "", $encoded_url);
    // "/" karakterlerini çıkarır ve "-" karakterleriyle değiştirir
    $encoded_url = str_replace('/', '', $encoded_url);
    $encoded_url = str_replace('+', '-', $encoded_url);
    // URL'deki diğer parametreleri kullanarak bir path oluşturur
    $path = "/rs:" . $opts['resize'] . ":" . $opts['width'] . ":" . $opts['height'] . ":" .$opts['enlarge'].'/g:'.
    $opts['gravity'] . "/" . $encoded_url . "." . $opts['extension'];
    // Salt'ı hexadecimal formatından binary formata dönüştürür
    $salt = hex2bin($opts['salt']);
    // HMAC hash'ini hesaplar ve base64 olarak kodlar
    $hmac = hash_hmac('sha256', $salt . $path, hex2bin($opts['key']), true);
    $hmac = base64_encode($hmac);
    // "=" karakterlerini çıkarır
    $hmac = str_replace("=", "", $hmac);
    // "/" karakterlerini çıkarır ve "-" karakterleriyle değiştirir
    $hmac = str_replace('/', '', $hmac);
    $hmac = str_replace('+', '-', $hmac);
    // Proxy URL'yi ve path'i birleştirerek son URL'yi döndürür
    return $opts['proxy_url'] . "/" . $hmac . $path;
    }

 ?>
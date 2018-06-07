<?php

require('./include.php');

//请在此填入AppID与AppKey
$app_id = '1106872796';
$app_key = 'V27D1dj9Pz3uA3E7';

//设置AppID与AppKey
Configer::setAppInfo($app_id, $app_key);

// 通用OCR识别
$image_data = file_get_contents('./data/generalocr.jpg');
$params = array(
    'image' => base64_encode($image_data),
);
$response = API::generalocr($params);
var_dump($response);



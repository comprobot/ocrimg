<?php

require('./HttpUtil.php');

$image_data = file_get_contents('./data/generalocr.jpg');

$params = array(
    'image' => base64_encode($image_data),
);

echo 'testing..';
$base64 = base64_encode($image_data);

// 设置请求数据
$appkey = 'V27D1dj9Pz3uA3E7';
$params = array(
    'app_id'     => '1106872796',
    'image'      => $base64,
    'time_stamp' => strval(time()),
    'nonce_str'  => strval(rand()),
    'sign'       => '',
);

// 执行API调用
$url = 'https://api.ai.qq.com/fcgi-bin/ocr/ocr_generalocr';
$response = doHttpPost($url, $params);
echo $response;




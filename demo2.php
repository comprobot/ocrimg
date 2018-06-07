<?php
function http($url, $params = array(), $method = 'GET', $ssl = false){
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    );
    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $getQuerys = !empty($params) ? '?'. http_build_query($params) : '';
            $opts[CURLOPT_URL] = $url . $getQuerys;
            break;
        case 'POST':
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
    }
    if ($ssl) {
        $opts[CURLOPT_SSLCERTTYPE] = 'PEM';
        $opts[CURLOPT_SSLCERT]     = $ssl['cert'];
        $opts[CURLOPT_SSLKEYTYPE]  = 'PEM';
        $opts[CURLOPT_SSLKEY]      = $ssl['key'];;
    }
    /* 初始化并执行curl请求 */
    $ch     = curl_init();
    curl_setopt_array($ch, $opts);
    $data   = curl_exec($ch);
    $err    = curl_errno($ch);
    $errmsg = curl_error($ch);
    curl_close($ch);
    if ($err > 0) {
        $this->error = $errmsg;
        return false;
    }else {
        return $data;
    }
}
?>
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
$data = http($url, $params,"POST");
$data=json_decode($data,true)['data']['item_list'];
    $res='';
    foreach ($data as $k => $v) {
        $res.=$v['itemstring']."<br>";
    }
    echo $res;

?>

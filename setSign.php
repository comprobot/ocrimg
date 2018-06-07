<?php

$app_id = $_POST["app_id"];
$nonce_str = $_POST["nonce_str"];
$time_stamp = $_POST["userpass"];
$app_key = $_POST["app_key"];
$image_str = $_POST["image_str"];


$params = array(
    //'image' => base64_encode($image_str),
   'image' => $image_str,	
);

		
		
		$params['app_id'] = $app_id;

        if (!$params['nonce_str'])
        {
            $params['nonce_str'] = uniqid("{$params['app_id']}_");
        }

        if (!$params['time_stamp'])
        {
            $params['time_stamp'] = time();
        }

        // 1. 字典升序排序
        ksort($params);

        // 2. 拼按URL键值对
        $str = '';
        foreach ($params as $key => $value)
        {
            if ($value !== '')
            {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }

        // 3. 拼接app_key
        $str .= 'app_key=' . $app_key;

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
		
		echo $sign;

?>

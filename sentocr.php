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

$url = "https://api.ai.qq.com/fcgi-bin/ocr/ocr_generalocr";
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
	//$sign = strtoupper($str);	

        echo $str;

        $curl = curl_init();

        $response = false;
        do
        {
            // 1. 设置HTTP URL (API地址)
            curl_setopt($curl, CURLOPT_URL, $url);

            // 2. 设置HTTP HEADER (表单POST)
            $head = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

            // 3. 设置HTTP BODY (URL键值对)
            $body = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            // 4. 调用API，获取响应结果
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            self::$_http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (self::$_http_code != 200)
            {
                $msg = curl_error($curl);
                $response = json_encode(array('ret' => -1, 'msg' => "sdk http post err: {$msg}", 'http_code' => self::$_http_code));
                break;
            }
        } while (0);

        curl_close($curl);
        //return $response;
        echo $response;





		
?>

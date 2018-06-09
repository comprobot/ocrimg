<?php
    function getReqSign(&$params)
    {
        // 0. 补全基本参数
        $params['app_id'] = '1106872796';

        if (!$params['nonce_str'])
        {
           // $params['nonce_str'] = uniqid("{$params['app_id']}_");
	    $params['nonce_str'] = '1106872796';
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
        $str .= 'app_key=' . 'V27D1dj9Pz3uA3E7';

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        return $sign;
    }


 function getReqSignT(&$params)
    {
        // 0. 补全基本参数
        $params['app_id'] = '1106872796';

        if (!$params['nonce_str'])
        {
           // $params['nonce_str'] = uniqid("{$params['app_id']}_");
	    $params['nonce_str'] = '1106872796';
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
        $str .= 'app_key=' . 'V27D1dj9Pz3uA3E7';

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        return $str;
    }



?>

<?php


		
		
		$image_data = file_get_contents('./data/generalocr.jpg');
		
		$params = array(
			'image' => base64_encode($image_data),
		);     

 		$all_str = getReqSignT($params);
		
		
		$params['sign'] = getReqSign($params);

                echo 'sign  : <br/>';
		echo $params['sign'];
                echo '<br/>'	;		

                echo 'image  : <br/>';
		echo $params['image'];	
		echo '<br/>'	;	
                echo 'time_stamp  : <br/>';
		echo $params['time_stamp'];	
		echo '<br/>'	;	

		echo '$all_str  : <br/>';
		echo $all_str;	
		echo '<br/>'	;	


// $params['time_stamp']


        //print_r( $params ); 

        $curl = curl_init();
        $response = false;
        do
        {
            // 1. 设置HTTP URL (API地址)
            curl_setopt($curl, CURLOPT_URL, "https://api.ai.qq.com/fcgi-bin/ocr/ocr_generalocr");

            // 2. 设置HTTP HEADER (表单POST)
            $head = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

            // 3. 设置HTTP BODY (URL键值对)
            $body = http_build_query($params);
	    echo $body;	
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            // 4. 调用API，获取响应结果
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		
            print_r($curl);  		
		
		
            $response = curl_exec($curl);
	    echo '<br/>';            
            //$response = json_encode(array('ret' => -1, 'msg' => "sdk http post err: {$msg}", 'http_code' => self::$_http_code));
	    echo $response;            	
			
        } while (0);

        curl_close($curl);
        


?>

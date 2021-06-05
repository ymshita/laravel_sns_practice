<?php
$appAccessToken = '820272027994053|kXXjn0EHr2qi-INzmZhFb-RAA2A';
$appSecret = 'd3612df4e59aee8035b92fb4b7ab153a';
$appsecretProof= hash_hmac('sha256', $appAccessToken, $appSecret); 
echo $appsecretProof . "\n";
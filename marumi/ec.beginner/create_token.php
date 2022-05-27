<?php 
    //トークンの作成
    $token_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($token_byte);
    $_SESSION['token'] = $csrf_token;

?>
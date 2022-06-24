<?php 
    //DBに接続
    $dsn ='mysql:dbname=code.ec;host=localhost;port=3307;charset=utf8';
    $user ='root';
    $password= 'root';
    $driver_option = array(PDO::ATTR_PERSISTENT => true); //scriptが終了してもDB接続が閉じられずにキャッシュされ、同じ内容の接続が要求されたときに再利用する。webアプリケーションの高速化につながる。

    try {
        //PDOインスタンスの生成
        $db = new PDO($dsn, $user, $password, $driver_option);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    } catch (PDOException $e) {
            exit("エラー：" . $e->getMessage());
    } 
?>

<?php 
    require_once('config.php');
    require_once('./helper/db_helper.php');
    require_once('./helper/extra\helper.php');
    
    session_start();
    
    //ログイン中かどうか確認
    if(empty($_SESSION['member'])){
        header('Location:'.SITE_URL.'/login.php');
        exit();
    }
    
    //クライアントの会員データを取得
    $member=$_SESSION['member'];
    $dbh=get_db_connect();
    $members=array();
    
    //全会員データを取得する
    include_once('./views/member_view.php');

?>
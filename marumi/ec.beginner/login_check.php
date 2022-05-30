<?php 
    session_start();
    require ('db_connect.php');
    require_once ('security.php');

    $token = filter_input(INPUT_POST, 'token');

    //トークンが正しいかチェック
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        $_SESSION['login_error'] = '不正なリクエストです。再度入力してください。';
        header('Location: index.php');
        exit();
    }

    unset($_SESSION['token']);


    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch();

    //ユーザーが存在していたら、セッションにユーザーIDをセット
    //指定したハッシュがパスワードにマッチしているかチェック
    if ($row && password_verify($password, $row['password'])){ 
            session_regenerate_id(true); //セッションIDを再作成
            //DBのユーザー情報をセッションに保存
            $_SESSION['user'] = $row;
            header('Location: index.php');
            exit();
    } else {
        //1レコードも取得できなかったとき、ユーザー名・パスワードが間違っている可能性あり
        $_SESSION['login_error'] = "ユーザー名、またはパスワードが違います。";
        header('Location: login.php');
        exit();
    }

?>

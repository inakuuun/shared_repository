<?php 
    session_start();
    require("db_connect.php");

    $token = filter_input(INPUT_POST, 'token');

    //トークンが正しいかチェック
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        $_SESSION['login_error'] = '不正なアクセスです。再度入力してください。';
        header('Location: index.php');
        exit();
    }
    
    unset($_SESSION['token']);

    //ユーザー情報のセッションを変数に入れる
    $newUser = $_SESSION['join']; 
    
    $birthday = ($newUser['year'] !== 'none') ? $newUser['year'].'-'.$newUser['month'].'-'.$newUser['day'] : null;
    $password_hash = password_hash($newUser['password'], PASSWORD_DEFAULT);

    // 入力情報をデータベースに登録
    $stmt = $db->prepare("INSERT INTO users(name, email, birthday, gender, password) VALUES (:name, :email, :birthday, :gender, :password)");
    $stmt->bindParam(':name', $newUser['name'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $newUser['email'], PDO::PARAM_STR);
    $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $newUser['gender'], PDO::PARAM_INT);
    $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
    $stmt->execute();

    unset($_SESSION['join']);
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了画面</title>

    <link rel="stylesheet" href="./css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <main>
        <section class="l-thanks">
            <div class="l-thanks__inner">
                <h2 class="c-section__title">登録完了しました</h2>
        <p class="p-thanks__comment">下のボタンよりログインページに移動してください。</p>
        <a href="login.php" class="c-link c-link--signup">ログインページに移動する</a>            
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

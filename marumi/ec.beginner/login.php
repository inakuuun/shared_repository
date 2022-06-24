<?php 
session_start();
require_once('db_connect.php');
require_once ('security.php');

if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

?>


<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet">

</head>
<body>
    <div class="l-login">
    <div class="l-login__inner">
        <p class="c-section__title p-login__title">LOGIN</p>
        <p class="p-login__error"><?php echo isset($error) ? $error : ''; ?></p>
            <form class="p-login__form" action="login_check.php" method="POST">
                <label class="p-login__label" for="email">メールアドレス</label>
                <input type="text" id="name" name="email" class="p-login__input" required>
                <label class="p-login__label" for="password">パスワード</label>
                <input type="password" id="password" name="password" class="p-login__input" required>

                <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                <input type="submit" class="c-btn p-login__btn" value="ログイン">
            </form> <!--p-login__form-->
        <a href="signup.php" class="c-link c-link--signup">新規登録はこちら</a>
        <a class="c-link c-link--home" href="index.php">戻る</a>
    </div> <!--p-login-->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

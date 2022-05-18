<?php 

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
    <div class="p-myPage__background js-login">
    </div> <!--p-myPage__background js-login-->

    <div class="p-myPage  js-login">
        <div class="p-myPage__closeIcon js-close" type="button">
            <span class="p-closeIcon__bar"></span>
            <span class="p-closeIcon__bar"></span>
        </div> <!--p-myPage__closeIcon js-close-->
        <p class="c-section__title p-myPage__title">LOGIN</p>
            <p><?php isset($error) ? escape($error): ''; ?></p>
            <form class="p-myPage__wrap" action="login.php" method="post">
                <label class="p-login__label">ユーザー名</label>
                <input type="text" id="name" name="name" class="p-login__input" required>
                <label class="p-login__label">パスワード</label>
                <input type="password" id="password" name="password" class="p-login__input" required>
                <input type="submit" class="c-btn p-login__btn" value="ログイン">
            </form> <!--p-myPage__wrap-->
        <a href="/signUp.php" class="p-myPage__register">新規登録はこちら</a>
    </div> <!--p-myPage  js-login-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

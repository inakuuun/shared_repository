<?php 
session_start();
require ('db_connect.php');
require_once ('security.php');

$error = '';

if (isset($_POST['email'], $_POST['password'])) { //ログインしていないがメールアドレスとパスワードが送信された場合

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
            $error = "ユーザー名、またはパスワードが違います。";
        }
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
        <p class="p-login__error"><?php echo $error; ?></p>
            <form class="p-login__form" action="login.php" method="POST">
                <label class="p-login__label" for="email">メールアドレス</label>
                <input type="text" id="name" name="email" class="p-login__input" required>
                <label class="p-login__label" for="password">パスワード</label>
                <input type="password" id="password" name="password" class="p-login__input" required>

                <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                <input type="submit" class="c-btn p-login__btn" name="login" value="ログイン">
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

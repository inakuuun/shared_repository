<?php
require("db_connect.php");

session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$year = (!($_POST["year"] == 'none'))  ? $_POST["year"] : null;
$month = (!($_POST["month"] == 'none'))  ? $_POST["month"] : null;
$day = (!($_POST["day"] == 'none'))  ? $_POST["day"] : null;
$gender = $_POST['gender'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// 重複を検知 
$stmt = $db->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

$row = $stmt->fetch();
$error = '';

if (isset($_POST["signup"])) {
    //ユーザー名チェック
    if ($name == $row['name']) {
        $error_name = "ユーザー名は既に存在しています";
        $error = 'double';
    }

    //メールアドレスチェック
    if ($email == $row['email']) {
        $error_email = "メールアドレスは既に存在しています";
        $error = 'double';
    } else if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email)){
        $error_email = "メールアドレスが正しくありません";
        $error = 'wrong';
    }

    //生年月日チェック
    if (isset($year)) {
        if (!isset($month) || !isset($day)) {
            $error_birthday = "入力が正しくありません";
            $error = 'wrong';
        }
    } else if (isset($month)) {
        if (!isset($day)) {
            $error_birthday = "入力が正しくありません";
            $error = 'wrong';    
        }
    } 
    
    //パスワードチェック
    if ($password !== $password2) {
        $error_password2 = "確認のためもう一度入力してください";
        $error = 'wrong';
    } else {
        if (!preg_match("/^[a-z0-9]{4}$/", $password)) {
            $error_password = "4桁の英数字を入力してください";
            $error = 'wrong';
        } 
    }
    
    //エラーがなければ次のページへ
    if ($error == '') {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: check.php');   // check.phpへ移動
        exit();
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
</head>
<body>
    <?php require_once('header.php') ?>

    <main>
        <section class="l-signup">
            <div class="l-signup__inner">
                <h2 class="c-section__title">新規会員登録</h2>
                <form action="" method="post" id="js-form" class="p-signup__form">

                    <label class="p-signup__label">ユーザー名<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo $error_name; ?></span></label>
                    <input class="p-signup__input" type="text" name="name">

                    <label class="p-signup__label">メールアドレス<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo $error_email; ?></span></label>
                    <input class="p-signup__input" type="text" name="email">

                    <label class="p-signup__label">生年月日<span class="p-signup__error"><?php echo $error_birthday; ?></span></label>
                    <div class="p-signup__selectWrap">
                    <?php
                        for ($i=1980; $i <= 2022; $i++) {
		                    $year .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                        for ($i=1; $i <= 12; $i++) {
                            $month .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                        for ($i=1; $i <= 31; $i++) {
                            $day .= '<option value="'.$i.'">'.$i.'</option>';
                        }
                        echo '
                            <select class="p-signup__select" name="year">
                                <option value="none">--</option>
                                '.$year.'
                            </select><span class="p-select__unit">年</span>
                            <select class="p-signup__select" name="month">
                                <option value="none">--</option>
                                '.$month.'
                            </select><span class="p-select__unit">月</span>
                            <select class="p-signup__select" name="day">
                                <option value="none">--</option>
                                '.$day.'
                            </select><span class="p-select__unit">日</span>
                        ';
                    ?>
                    </div>

                    <p class="p-signup__label">性別</p>
                    <div class="p-signup__radioWrap">
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="1">
                            <span>男性</span>
                        </label>
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="2">
                            <span>女性</span>
                        </label>
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="3">
                            <span>無回答</span>
                        </label>
                    </div>

                    <label class="p-signup__label">パスワード<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo $error_password; ?></span></label>
                    <input class="p-signup__input" type="password" name="password" placeholder="4桁の半角英数字">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <label class="p-signup__label">パスワード(確認用)<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo $error_password2; ?></span></label>
                    <input class="p-signup__input" type="password" name="password2" value="" placeholder="再度パスワードを入力">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <input class="c-btn p-signup__btn" id="js-submit" type="submit" name="signup" value="確認する" disabled>
                </form>
                <a class="c-link c-link--home" href="index.php">戻る</a>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>
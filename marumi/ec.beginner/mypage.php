<?php
    session_start();
    require('db_connect.php');
    require("sanitize.php");

    if (!$_SESSION['user']) {
       $_SESSION['login_error'] = 'ログインしてください。';
        header('Location: index.php');
        exit();
    }

    //フォームからの値をそれぞれ変数に代入
    $name = $_SESSION['user']['name'];
    $email = $_SESSION['user']['email'];
    $birthday = $_SESSION['user']['birthday'];
    //(isset($year)) ? $year.'-'.$month.'-'.$day : null;
    $gender = $_SESSION['user']['gender'];


    //表示用
        //生年月日
        //$display_birthday = (isset($year)) ? $year.'年'.$month.'月'.$day.'日' : null;
        //性別
        switch ($gender) {
            case 1:
                $display_gender = '男性';
                break;
            case 2:
                $display_gender = '女性';
                break;
            case 3:
                $display_gender = '未回答';
                break;
            default:
                $display_gender = null;
                break;
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
    <?php require('header.php'); ?>
    <section class="l-mypage">
            <div class="l-mypage__inner">
                <h2 class="c-section_title">MY PAGE</h2>
                <div class="p-mypage__form">
                    <dl class="p-mypage__list">
                        <dd class="p-mypage__name"><?php echo $name; ?></dd>
                        <dt>メールアドレス</dt>
                        <dd><?php echo $email; ?></dd>
                        <dt>生年月日</dt>
                        <dd><?php echo $birthday; ?></dd>
                        <dt>性別</dt>
                        <dd><?php echo $display_gender; ?></dd>
                    </dl>
                
                    <a href="#" class="c-btn p-edit__btn">メールアドレスを変更する</a>
                    <a href="my_edit.php" class="c-btn p-edit__btn">その他の会員情報を変更する</a>
                    <p class="p-mypage__notice">※生年月日は1度登録すると変更ができません</p>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

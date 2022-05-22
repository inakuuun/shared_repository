<?php 
session_start();
require('db_connect.php');
require("sanitize.php");

/* if (!$_SESSION['user']) {
   $_SESSION['login_error'] = 'ログインしてください。';
    header('Location: index.php');
    exit();
}*/

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
                <h2 class="c-section_title">会員情報</h2>

                <form class="p-mypage__form">
                <dl class="p-mypage__list">
                    <dd class="p-maypage__name"><?php echo $name; ?></dd>
                    <dt>メールアドレス</dt>
                    <dd><?php echo $email; ?></dd>
                    <dt>生年月日</dt>
                    <dd><?php echo $birthday; ?></dd>
                    <dt>性別</dt>
                    <dd><?php echo $display_gender; ?></dd>
                </dl>
            
                <a href="edit.php" class="c-btn p-edit__btn">変更する</a>
                </form>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

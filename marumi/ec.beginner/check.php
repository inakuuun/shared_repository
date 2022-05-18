<?php
require("db_connect.php");
require("sanitize.php");
session_start();
 
/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: signup.php');
    exit();
}

//フォームからの値をそれぞれ変数に代入
$name = $_SESSION['join']['name'];
$email = $_SESSION['join']['email'];
$year = (!($_SESSION['join']['year'] == 'none'))  ? $_SESSION['join']['year'] : null;
$month = (!($_SESSION['join']['month'] == 'none'))  ? $_SESSION['join']['month'] : null;
$day = (!($_SESSION['join']['day'] == 'none'))  ? $_SESSION['join']['day'] : null;
$birthday = (isset($year)) ? $year.'-'.$month.'-'.$day : null;
$gender = $_SESSION['join']['gender'];
$password = password_hash($_SESSION['join']['password'], PASSWORD_DEFAULT);

//表示用
    //生年月日
    $display_birthday = (isset($year)) ? $year.'年'.$month.'月'.$day.'日' : null;
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
 
if (!empty($_POST['check'])) {

    // 入力情報をデータベースに登録
    $stmt = $db->prepare("INSERT INTO users(name, email, birthday, gender, password) VALUES (:name, :email, :birthday, :gender, :password)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->execute();

 
    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thanks.php');   // thank.phpへ移動
    exit();
}
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>確認画面</title>

    <link rel="stylesheet" href="./css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@700&family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <main>
        <section class="l-check">
            <div class="l-check__inner">
                <h2 class="c-section_title">入力情報の確認</h2>

                <form action="" method="POST" class="p-check__form">
                <p class="p-check__comment">※登録情報はあとから変更することもできます。</p>
                <dl class="p-check__list">
                    <dt class="p-check__label">ニックネーム</dt>
                    <dd class="p-check__input"><?php echo escape($name); ?></dd>
                    <dt class="p-check__label">メールアドレス</dt>
                    <dd class="p-check__input"><?php echo escape($email); ?></dd>
                    <dt class="p-check__label">生年月日</dt>
                    <dd class="p-check__input"><?php echo escape($display_birthday); ?></dd>
                    <dt class="p-check__label">性別</dt>
                    <dd class="p-check__input"><?php echo escape($display_gender); ?></dd>
                </dl>
            
            <a href="signup.php" class="c-btn p-fix__btn">変更する</a>
            <button type="submit" class="c-btn p-check__btn">登録する</button>
            <div class="clear"></div>
            <input type="hidden" name="check" value="checked">
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

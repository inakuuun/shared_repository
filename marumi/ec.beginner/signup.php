<?php
session_start();
require("db_connect.php");
require_once("security.php");

$error = [];

if (isset($_POST["signup"])) {

    $token = filter_input(INPUT_POST, 'token');

    //トークンが正しいかチェック
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        $_SESSION['login_error'] = '不正なリクエストです。再度入力してください。';
        header('Location: index.php');
        exit();
    }

    unset($_SESSION['token']);


        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        // 重複を検知 
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();

        //メールアドレスチェック
        if (isset($row['email'])) {
            $error['email'] = "メールアドレスは既に存在しています";
        } else if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $_POST['email'])){
            $error['email'] = "メールアドレスが正しくありません";
        }

        //生年月日チェック
        if (($_POST['year'] !== 'none' || $_POST['month'] !== 'none') && ($_POST['day'] === 'none')) {
            //年：選択ありor月：選択あり、日：選択なしの場合
            $error['birthday'] = "入力が正しくありません";
        } else if (($_POST['year'] === 'none' || $_POST['month'] === 'none') && ($_POST['day'] !== 'none')) {
            //年：選択なしor月：選択なし、日：選択ありの場合
            $error['birthday'] = "入力が正しくありません";
        } 
        
        //パスワードチェック
        if ($_POST['password'] !== $_POST['password2']) {
            //パスワードが確認用と違う場合
            $error['password2'] = "確認のためもう一度入力してください";
        } else if (!preg_match("/^[a-z0-9]{4}$/", $_POST['password'])) {
            //パスワードは2つ同じだが、4桁の英数字ではない場合
            $error['password']= "4桁の英数字を入力してください";
        }
        
        //エラーがなければ次のページへ
        if (!$error > 0) {
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
    <title>新規会員登録</title>

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
                <form action="" method="post" id="js-signup" class="p-signup__form">

                    <label class="p-signup__label">ユーザー名<span class="p-label__essential">必須</span></label>
                    <input class="p-signup__input" type="text" name="name">

                    <label class="p-signup__label">メールアドレス<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo isset($error['email']) ? $error['email'] : null; ?></span></label>
                    <input class="p-signup__input" type="text" name="email">

                    <label class="p-signup__label">生年月日<span class="p-signup__error"><?php echo isset($error['birthday']) ? $error['birthday'] : ''; ?></span></label>
                    <div class="p-signup__selectWrap">
                    <?php
                        $year = '';
                        $month = '';
                        $day = '';
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

                    <label class="p-signup__label">パスワード(4桁の半角英数字)<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo isset($error['password']) ? $error['password'] : null; ?></span></label>
                    <input class="p-signup__input" type="password" name="password" placeholder="4桁の半角英数字">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <label class="p-signup__label">パスワード(確認用)<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo isset($error['password2']) ? $error['password2'] : null; ?></span></label>
                    <input class="p-signup__input" type="password" name="password2" value="" placeholder="再度パスワードを入力">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                    <input class="c-btn p-signup__btn" id="js-signupBtn" type="submit" name="signup" value="確認する" disabled>
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

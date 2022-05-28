<?php 
    session_start();
    require('db_connect.php');
    require_once("security.php");

    //ログインしてない場合
    if (!$_SESSION['user']) {
        $_SESSION['login_error'] = 'ログインしてください。';
        header('Location: index.php');
        exit();
    } 
    
    if (isset($_SESSION['mypage_error'])) {
        //編集画面でのエラーがある場合
        //セッションの値を変数に代入
        $error = $_SESSION['mypage_error'];
        //エラーメッセージ表示後、セッションを破棄
        unset($error);
    }

    //セッションの値を変数に代入
    $currentUser = $_SESSION['user'];

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
    <?php include('header.php'); ?>
    <section class="l-mypage">
            <div class="l-mypage__inner">
                <h2 class="c-section_title">会員情報の変更</h2>

                <form action="mypage_update.php" method="post" id="js-edit" class="p-signup__form">

                    <label class="p-signup__label">ユーザー名<span class="p-signup__error"></span></label>
                    <input class="p-signup__input" type="text" name="name" value="<?php echo escape($currentUser['name']); ?>">

                    <label class="p-signup__label">生年月日<span class="p-signup__error"><?php echo isset($error) ? escape($error) : ''; ?></span></label>
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

                        if (isset($currentUser['birthday'])) {
                            echo "<p class='p-signup__input'>".escape($currentUser['birthday'])."<span class='p-signup__comment'>※変更できません</span></p>";
                        } else {
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
                        }
                    ?>
                    </div>

                    <p class="p-signup__label">性別</p>
                    <div class="p-signup__radioWrap">
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="1" <?php echo $currentUser['gender'] == 1 ? 'checked' : null ?>>
                            <span>男性</span>
                        </label>
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="2" <?php echo $currentUser['gender'] == 2 ? 'checked' : null ?>>
                            <span>女性</span>
                        </label>
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="3" <?php echo $currentUser['gender'] == 3 ? 'checked' : null ?>>
                            <span>無回答</span>
                        </label>
                    </div>

                    <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                    <input class="c-btn p-signup__btn" id="js-editBtn" type="submit" name="my_edit" value="変更を登録する" disabled>
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

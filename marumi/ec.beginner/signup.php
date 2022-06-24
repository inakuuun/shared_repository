<?php
    session_start();
    require_once("db_connect.php");
    require_once("security.php");
    require_once("display_gender.php");

    if (isset($_SESSION['signup_error'])) {
        $error = $_SESSION['signup_error'];    
        unset($_SESSION['signup_error']);
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
                <form action="signup_check.php" method="post" id="js-signup" class="p-signup__form">

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
                        <?php foreach (Gender::cases() as $v): ?>
                        <label class="p-signup__radio">
                            <input class="p-radio__gender" type="radio" name="gender" value="<?php echo $v->value; ?>">
                            <span><?php echo escape($v->description()); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>

                    <label class="p-signup__label">パスワード(4桁の半角英数字)<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo isset($error['password']) ? $error['password'] : null; ?></span></label>
                    <input class="p-signup__input" type="password" name="password" placeholder="4桁の半角英数字">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <label class="p-signup__label">パスワード(確認用)<span class="p-label__essential">必須</span><span class="p-signup__error"><?php echo isset($error['password2']) ? $error['password2'] : null; ?></span></label>
                    <input class="p-signup__input" type="password" name="password2" value="" placeholder="再度パスワードを入力">
                    <!--<span><i class="fas fa-eye-slash p-signup__eye" id="js-password"></i></span>-->

                    <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                    <input class="c-btn p-signup__btn" id="js-signupBtn" type="submit" value="確認する" disabled>
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

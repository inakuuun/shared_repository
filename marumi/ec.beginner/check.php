<?php
    session_start();
    require("db_connect.php");
    require_once("security.php");
    
    /* 会員登録の手続き以外のアクセスを飛ばす */
    if (!isset($_SESSION['join'])) {
        $_SESSION['login_error'] = '不正なアクセスです。再度入力してください。';
        header('Location: signup.php');
        exit();
    }

    //フォームからの値を変数に代入
    $checkUser = $_SESSION['join'];

    $birthday = ($checkUser['year'] !== 'none') ? $checkUser['year'].'-'.$checkUser['month'].'-'.$checkUser['day'] : null;
    $gender = isset($checkUser['gender']) ? (int)$checkUser['gender'] : null;

    //表示用
        //生年月日
        $displayBirthday = ($checkUser['year'] !== 'none') ? $checkUser['year'].'年'.$checkUser['month'].'月'.$checkUser['day'].'日' : '';
        //性別
        switch (true) {
            case $gender === 1:
                $displayGender = '男性';
                break;
            case $gender === 2:
                $displayGender = '女性';
                break;
            case $gender === 3:
                $displayGender = '未回答';
                break;
            default:
                $displayGender = '';
                break;
        }
    
    if (isset($_POST['check'])) {

        $token = filter_input(INPUT_POST, 'token');

        //トークンが正しいかチェック
        if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
            $_SESSION['login_error'] = '不正なアクセスです。再度入力してください。';
            header('Location: index.php');
            exit();
        }
    
        unset($_SESSION['token']);
    

            // 入力情報をデータベースに登録
            $stmt = $db->prepare("INSERT INTO users(name, email, birthday, gender, password) VALUES (:name, :email, :birthday, :gender, :password)");
            $stmt->bindParam(':name', $checkUser['name'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $checkUser['email'], PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_INT);
            $stmt->bindParam(':password', password_hash($checkUser['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->execute();

        
            unset($_SESSION['join']);   // セッションを破棄
            header('Location: thanks.html');   // thanks.htmlへ移動
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
                        <dd class="p-check__input"><?php echo escape($checkUser['name']); ?></dd>
                        <dt class="p-check__label">メールアドレス</dt>
                        <dd class="p-check__input"><?php echo escape($checkUser['email']); ?></dd>
                        <dt class="p-check__label">生年月日</dt>
                        <dd class="p-check__input"><?php echo escape($displayBirthday) ?></dd>
                        <dt class="p-check__label">性別</dt>
                        <dd class="p-check__input"><?php echo escape($displayGender); ?></dd>
                    </dl>
            
                    <a href="signup.php" class="c-btn p-fix__btn">変更する</a>

                    <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                    <input type="submit" name="check" class="c-btn p-check__btn" value="登録する"></input>
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

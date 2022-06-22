<?php
    session_start();
    require_once("db_connect.php");
    require_once("security.php");
    require_once("display_gender.php");
    
    $token = filter_input(INPUT_POST, 'token');
    
    //トークンが正しいかチェック
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        $_SESSION['login_error'] = '不正なリクエストです。再度入力してください。';
        header('Location: index.php');
        exit();
    }
    
    unset($_SESSION['token']);

    $error = [];
        
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
    
    //表示用
    //生年月日
    $displayBirthday = ($_POST['year'] !== 'none') ? $_POST['year'].'年'.$_POST['month'].'月'.$_POST['day'].'日' : '';
    //性別
    $displayGender = isset($_POST['gender']) ? Gender::cases()[$_POST['gender']]->description() : '';
            
    //エラーがあったら新規登録画面に戻す
    if (!empty($error)) {
        $_SESSION['signup_error'] = $error;
        header('Location: signup.php');
        exit();
    } 

    $_SESSION['join'] = $_POST;

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

                <form action="thanks.php" method="POST" class="p-check__form">
                    <p class="p-check__comment">※登録情報はあとから変更することもできます。</p>
                    <dl class="p-check__list">
                        <dt class="p-check__label">ニックネーム</dt>
                        <dd class="p-check__input"><?php echo escape($_POST['name']); ?></dd>
                        <dt class="p-check__label">メールアドレス</dt>
                        <dd class="p-check__input"><?php echo escape($_POST['email']); ?></dd>
                        <dt class="p-check__label">生年月日</dt>
                        <dd class="p-check__input"><?php echo escape($displayBirthday) ?></dd>
                        <dt class="p-check__label">性別</dt>
                        <dd class="p-check__input"><?php echo escape($displayGender); ?></dd>
                    </dl>
            
                    <a href="signup.php" class="c-btn p-fix__btn">変更する</a>

                    <input type="hidden" name="token" value="<?php echo escape(setToken()); ?>">
                    <input type="submit" class="c-btn p-check__btn" value="登録する"></input>
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

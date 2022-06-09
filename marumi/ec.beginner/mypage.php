<?php
    session_start();
    require('db_connect.php');
    require_once("security.php");
    require_once("display_gender.php");

    if (!$_SESSION['user_id']) {
       $_SESSION['login_error'] = 'ログインしてください。';
        header('Location: index.php');
        exit();
    }

    //編集した人のために、セッション更新
    //クエリ文字列(id)からユーザー情報を取得
    $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    //表示用
    $displayGender = isset($user['gender']) ? Gender::cases()[$user['gender']]->description() : '';

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
                <h2 class="c-section__title">MY PAGE</h2>
                <div class="p-mypage__form">
                    <dl class="p-mypage__list">
                        <dd class="p-mypage__name"><?php echo escape($user['name']); ?></dd>
                        <dt>メールアドレス</dt>
                        <dd><?php echo escape($user['email']); ?></dd>
                        <dt>生年月日</dt>
                        <dd><?php echo isset($user['birthday']) ? escape($user['birthday']) : ''; ?></dd>
                        <dt>性別</dt>
                        <dd><?php echo escape($displayGender); ?></dd>
                    </dl>
                
                    <a href="#" class="c-btn p-edit__btn">メールアドレスを変更する</a>
                    <a href="mypage_edit.php?id=<?php echo $user['id']; ?>" class="c-btn p-edit__btn">その他の会員情報を変更する</a>
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

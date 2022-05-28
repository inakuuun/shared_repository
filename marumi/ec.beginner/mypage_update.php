<?php 
    session_start();
    require('db_connect.php');
    require_once("security.php");

    if (!$_SESSION['user']) {
    $_SESSION['login_error'] = 'ログインしてください。';
        header('Location: index.php');
        exit();
    }

    $token = filter_input(INPUT_POST, 'token');

    //トークンが正しいかチェック
    if (!isset($_SESSION['token']) || $token !== $_SESSION['token']) {
        $_SESSION['login_error'] = '不正なリクエストです。再度入力してください。';
        header('Location: index.php');
        exit();
    }

    unset($_SESSION['token']);

        //セッションの値を変数に代入
        $currentUser = $_SESSION['user'];

        //生年月日
        if (isset($_POST["year"])) {

            //生年月日チェック
            if ($_POST['year'] !== 'none' && $_POST['month'] !== 'none' && $_POST['day'] !== 'none') {
                //OK:全部選択あり
                $editBirthday = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];

            } else if ($_POST['year'] === 'none' && $_POST['month'] === 'none' && $_POST['day'] === 'none') {
                //OK:全部選択なし
                $editBirthday = null;
            
            } else {
                //NG:選択してたりしてなかったり
                $_SESSION['mypage_error'] = "入力が正しくありません";
                header('Location: mypage_edit.php');
                exit();
            }

        } else {
            //既に登録済で変更不可のため、formに送られてきていない場合
            $editBirthday = $currentUser['birthday'];
        }

        //名前
        $editName = isset($_POST['name']) ? $_POST['name'] : $currentUser['name'];
        $editGender = isset($_POST['gender']) ? $_POST['gender'] : $currentUser['gender'];
        
        //エラーがなければ変更を保存し、マイページへ戻る
        if (!isset($_SESSION['mypage_error'])) {
            $stmt = $db->prepare("UPDATE users SET name = :name, birthday = :birthday, gender = :gender WHERE id = :id");
            $stmt->bindParam(':id', $currentUser['id'], PDO::PARAM_INT);
            $stmt->bindParam(':name', $editName, PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $editBirthday, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $editGender, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: mypage.php');   // mypage.phpへ移動
            exit();
        } 

?>

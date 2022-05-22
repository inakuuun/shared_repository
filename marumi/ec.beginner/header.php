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
    <header class="l-header">
        <div class="l-header__inner">
            <h1 class="p-header__logo">
                <img src="./img/logo.svg" alt="TOTALLY">
            </h1>
            <nav class="p-header__menu">
                <ul class="p-header__itemList">
                    <li class="p-header__item">
                        <a href="#" class="js-nav">ALL</a></li>
                    <li class="p-header__item">
                        <a href="#" class="js-nav">NEW</a></li>
                    <li class="p-header__item">
                        <a href="#" class="js-nav">VINTAGE</a></li>
                    <li class="p-header__item">
                        <a href="#" class="js-nav">CATEGORY</a></li>
                    <li class="p-header__item">
                        <a href="#" class="js-nav">LOOKBOOK</a></li>
                    <li class="p-header__item">
                        <a href="#" class="js-nav">BLOG</a></li>
                </ul>
                <ul class="p-header__userList">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="p-header__userItem">
                            <a href="mypage.php">MY PAGE</a>
                        </li>
                        <li class="p-header__userItem">
                            <a href="logout.php">LOGOUT</a>
                        </li>
                    <?php else: ?>
                        <li class="p-header__userItem">
                            <a href="login.php">LOGIN</a>
                        </li>
                    <?php endif; ?>
                    <li class="p-header__userItem">
                        <a href="#">CONTACT</a>
                    </li>
                </ul>
            </nav>
        </div> <!--l-header__inner-->
    </header>        
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

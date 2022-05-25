<?php 
session_start(); //セッション開始
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
    <?php include('header.php') ?>
    <main>
        <section class="l-product">
            <div class="l-product__inner">
                <figure class="p-product__image">
                    <img src="./img/item.jpg" alt="">
                </figure>
                <div class="p-product__box">
                    <h2 class="p-product__name">
                        TOTALLY Short Sleeve Shirt
                    </h2>
                    <p class="p-product__text">
                        テキストテキストテキストテキストテキストテキストテキスト
        テキストテキストテキストテキストテキストテキストテキスト
        テキストテキストテキストテキストテキストテキストテキスト
        テキストテキストテキストテキストテキストテキストテキスト
        テキストテキストテキストテキストテキストテキストテキスト
        テキストテキストテキスト
                    </p>
                    <p class="p-product__price">
                        ￥9,999 +tax
                    </p>
                    <table class="p-product__orderTable">
                        <thead>
                            <tr>
                                <th>Color</th>
                                <th>Size</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>White</td>
                                <td>S</td>
                                <td class="p-product__selectTd"><select name="" id="" class="p-product__select">
                                    <option value="none">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select></td>
                            </tr>
                            <tr>
                                <td>White</td>
                                <td>M</td>
                                <td class="p-product__selectTd"><select name="" id="" class="p-product__select">
                                    <option value="none">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select></td>
                            </tr>
                            <tr>
                                <td>White</td>
                                <td>L</td>
                                <td class="p-product__selectTd"><select name="" id="" class="p-product__select">
                                    <option value="none">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="ADD TO CART" class="p-product__btn">
                    <table class="p-product__sizeTable">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Chest</th>
                                <th>West</th>
                                <th>Height</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>S</th>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                            </tr>
                            <tr>
                                <th>M</th>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                            </tr>
                            <tr>
                                <th>L</th>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                                <td>99 ～ 99</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <footer class="l-footer">
        <div class="l-footer__inner">
            <p class="p-footer__copyright">© TOTALLY</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="./js/script.js"></script>
</body>
</html>

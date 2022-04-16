// ニュースのli要素数を変数に格納
const headerLengthArray = [headerLists0.length, headerLists1.length, headerLists2.length];
const headerLengthArray_Length = headerLengthArray.length;

// 菓子の項目数を変数に格納
const snack_length = snackSort.length;

// 各菓子項目のカウント数を配列に格納
const snackLengthArray = [snackItem0.length, snackItem1.length, snackItem2.length];
const snackLengthArray_length = snackLengthArray.length;

// ニュースのli要素数を変数に格納
const news_Length = news_days.length;

// カテゴリー画像パス
var snackItemPath0 = 'images/category/itemlist{0}.png';
// テイスト画像パス
var snackItemPath1 = 'images/taste/itemlist{0}.png';
// カロリー画像パス
var snackItemPath2 = 'images/calorie/itemlist{0}.png';

// ニュースアイテム画像パス
var newsItemPath = 'images/news/itemlist{0}.jpg';

// region
// 初期表示時の処理
window.onload = function () {
    // ===============================================================================
    //      ヘッダーリスト
    // ===============================================================================
    // ヘッダーリストの数ループ処理(3回)
    for (let i = 0; i < headerLengthArray_Length; i++) {
        // ヘッダーリストの要素分ループ処理
        for (let j = 0; j < headerLengthArray[i]; j++) {
            // li要素を作成
            let list = document.createElement('li');
            // 要素のid名を変数に格納
            let headerId = 'header' + i;
            switch (i) {
                // ヘッダーリスト0の場合
                case 0:
                    // リクルートの場合
                    if (j == 6) {
                        // リクルートのアイコン付きリスト要素の作成
                        list.innerHTML = '<a href="#"><i class="fa-solid fa-user fa-lg right_3px color_red"></i>' + headerLists0[j] + '</a>';
                    }
                    // オンラインストアの場合
                    else if (j == 7) {
                        // オンラインストアのアイコン付きリスト要素の作成
                        list.innerHTML = '<a href="#"><i class="fa-solid fa-user fa-lg right_3px color_red"></i>' + headerLists0[j] + '</a>';
                    }
                    // それ以外
                    else {
                        // リスト要素を作成
                        list.innerHTML = '<a href="#">' + headerLists0[j] + '</a>';
                    }
                    // 製品の場合
                    if (j == 1) {
                        // クラス名をactiveにする(アンダーラインを設定)
                        list.className = 'active';
                    }
                    break;
                // ヘッダーリスト1の場合
                case 1:
                    // リスト要素を作成
                    list.innerHTML = '<a href="#">' + headerLists1[j] + '</a>';
                    // ブランドの場合
                    if (j == 1) {
                        // クラス名をactiveにする(アンダーラインを設定)
                        list.className = 'active';
                    }
                    break;
                // ヘッダーリスト2の場合
                case 2:
                    // リストを作成
                    list.innerHTML = '<a href="#"><i class="fa-solid fa-caret-right right_3px"></i>' + headerLists2[j] + '</a>';
                    break;
            }
            // ul要素下に作成したリストを追加していく
            gID(headerId).appendChild(list);
        }
    }


    // ===============================================================================
    //      菓子リスト
    // ===============================================================================
    // 菓子リストの項目分ループ処理(3回)
    for (let i = 0; i < snack_length; i++) {
        // li要素を作成
        let list = document.createElement('li');
        // idを取得
        listSortId = 'sort' + i;
        // １回目のループ処理の場合
        if (i == 0) {
            // aタグのクラス名にtrueを設定したリストを作成
            list.innerHTML = '<a id="' + listSortId + '" class="true" onclick="listsort_click(this.id)">' + snackSort[i] + '</a>';
        }
        // ２回目以降のループ処理
        else {
            // aタグのクラス名に空を設定したリストを作成
            list.innerHTML = '<a id="' + listSortId + '" class="" onclick="listsort_click(this.id)">' + snackSort[i] + '</a>';
        }

        // id名が'sorts'のul要素下に作成したliを追加していく。
        gID('sorts').appendChild(list);

        // 配列で指定した数ループ処理をする
        for (let j = 0; j < snackLengthArray[i]; j++) {
            // h3要素作成判定用カウント用変数を初期化
            let snackCnt0 = null;
            let snackCnt2 = null;
            let snackCnt9 = null;

            // 要素の文字を初期化
            let snackitem = '';

            // li要素を作成
            let list = document.createElement('li');
            // 要素のid名を変数に格納
            let snackItemId = 'snack_itemLists' + i;

            switch (i) {
                // カテゴリーリストの場合
                case 0:
                    // h3要素作成判定用カウントを設定
                    snackCnt0 = 0;
                    // 要素の文字を設定
                    snackitem = snackItem0[j];
                    // 要素の画像パスを設定
                    var itemPath = snackItemPath0.replace('{0}', j);
                    break;

                // テイストの場合
                case 1:
                    // 要素の文字を設定
                    snackitem = snackItem1[j];
                    // 要素の画像パスを設定
                    var itemPath = snackItemPath1.replace('{0}', j);
                    break;

                // カロリーの場合
                case 2:
                    // h3要素作成判定用カウントを設定
                    snackCnt0 = 0;
                    snackCnt2 = 2;
                    snackCnt9 = 9;
                    // 要素の文字を設定
                    snackitem = snackItem2[j];
                    // 要素の画像パスを設定
                    var itemPath = snackItemPath2.replace('{0}', j);
                    break;
            }

            // jの値がsnackCnt変数と一致する場合
            if (j == snackCnt0
                || j == snackCnt2
                || j == snackCnt9) {
                // h3要素を作成する。
                list.innerHTML = '<h3 class="sn-item-label"><span>' + snackitem + '</span></h3>';
            }
            else {
                // li要素のクラス名を「sn-item-list」にする
                list.className = 'sn-item-list';

                // li要素の子要素を作成する。
                list.innerHTML = '<a href="#">'
                    + '<dt><img src ="' + itemPath + '"/></dt>'
                    + '<dd> ' + snackitem + '</dd></a>';
            }
            // ul要素下に作成したliを追加していく。
            gID(snackItemId).appendChild(list);
        }
    }
    // ===============================================================================
    //      ニュースリスト
    // ===============================================================================
    // ニュースリストの要素分ループ処理
    for (let i = 0; i < news_Length; i++) {
        // li要素を作成
        let list = document.createElement('li');
        var itemPath = newsItemPath.replace('{0}', i);

        // ニュース左　日付に入れる文字列を変数に格納
        let day = news_days[i];
        // ニュース左　アンカーに入れる文字列を変数に格納
        let a1_resouce = news_a1[i];
        // ニュース左　その他用の変数
        let addAthers = '';

        // ニュース右　h3要素に入れる文字列を変数に格納
        let h3_resouce = news_h3[i];
        // ニュース右　p要素に入れる文字列を変数に格納
        let p_resouce = news_p[i];

        // 配列のインデックスが2と5の場合
        if (i == 2
            || i == 5) {
            // その他を設定
            addAthers = ' , その他';
        }

        // ニュースリストの子要素の作成
        list.innerHTML =
            ' <dl class="wrapper">'
            + '   <dt>'
            + '    <span class="days"> ' + day + ' </span>'
            + '    <span><a class="press">プレスリリース</a></span>'
            + '    <span><a class="under_l">日清シスコ</a></span>'
            + '    <span><a class="under_l">' + a1_resouce + '<span>' + addAthers + '</span></a><span>'
            + '   </dt>'
            + '   <dd>'
            + '      <a class="ops" href="#">'
            + '         <figure>'
            + '             <img src="' + itemPath + '" />'
            + '         </figure>'
            + '         <div>'
            + '             <h3 class="sale_day">' + h3_resouce + '</h3>'
            + '             <p>' + p_resouce + '</p>'
            + '         </div>'
            + '      </a>'
            + '    </dd>'
            + ' </dl>';

        // ul要素下に作成したliを追加していく。
        gID('news_itemLists0').appendChild(list);
    }

};
// endregion

// 菓子選択ボタン押下時処理(カテゴリー/テイスト/カロリー)
function listsort_click(listId) {

    // お菓子リストの項目分ループ処理(3回)
    for (let i = 0; i < snackLengthArray_length; i++) {
        // 呼び出し元id名を変数に格納
        let sortId = 'sort' + i;
        // 呼び出し元項目と紐づくul要素のidを変数に格納
        let itemId = 'snack_itemLists' + i;

        // クリックした要素の場合
        if (listId == sortId) {
            // 要素の背景色を赤色にする
            gID(sortId).className = 'true';
            // 紐づくul要素を表示する
            gID(itemId).className = '';
        }
        // クリックした要素以外の場合
        else {
            // 要素にcssを設定しない。
            gID(sortId).className = '';
            // 紐づくul要素を非表示にする
            gID(itemId).className = 'hide-control';
        }
    }
}
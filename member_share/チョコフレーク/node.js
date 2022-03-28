// function fnclistSort(id) {
//     console.log(document.getElementById(id).className);
//     if(document.getElementById(id).className != 'true')
//     {
//         document.getElementById(id).className = 'sort';
//     }  
// }

// function fncresetSort(id) {
//     console.log(document.getElementById(id).className);
//     if(document.getElementById(id).className != 'true')
//     {
//         document.getElementById(id).className = '';
//     }
// }

window.onload = function(){
    // ddタグで使う文字を定義
    const createElementCount = 11;

    const resouce = [
        'チョコレート菓子','チョコフレーク マイメロディのメロメロアーモンド味','クリスプチョコ シナモロールのスイートカフェオレ味',
        'チキンラーメンチョコフレーク','チョコフレーク ポムポムプリンのキャラチョコプリン味',
        'チョコフレーク','チョコフレーク 至福の贅沢カカオ','チョコフレーク クリスプボール',
        'チョコフレーク ドーナツチョコ','チョコフレーク プチパック 8袋入り','クリスプチョコ'
    ]

    var imgPath = 'images/itemlist{0}.png';

    for(let i = 0;i < createElementCount;i++){
        var list = document.createElement('li');
        if(i == 0)
        {
            list.innerHTML = '<h3 class="sn-item-label"><span>'+ resouce[i] +'</span></h3>';
        }
        else
        {
            list.className = 'sn-item-list';

            list.innerHTML = '<a href="#">' 
            +'<dt><img src ="'+ imgPath.replace('{0}', i) + '"/></dt>'
            +'<dd> '+ resouce[i] + '</dd></a>';
        }
        document.getElementById('resultLists0').appendChild(list);
    }
};

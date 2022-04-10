const quiz = [
 {
    question: "眠くなりにくい花粉症薬は次の内どれ",
    answers: [
     "ジフェンヒドラミン塩酸塩",
     "ロラタジン",
     "イブプロフェン",
     "セチリジン"
    ],
    correct: "ロラタジン"
 }, {
    question: "鼻炎症状に効く漢方は次の内どれ",
    answers: [
     "半夏厚朴湯",
     "芍薬甘草湯",
     "小青竜湯",
     "六君子湯"
    ],
    correct: "小青竜湯"
 }, {
    question: "服用後、車の運転が可能な鼻炎薬は次の内どれ",
    answers: [
     "クラリチン",
     "アレジオン",
     "パブロン鼻炎薬",
     "コンタック600プラス"
    ],
    correct: "クラリチン"
 },{
    question: "服用後、車の運転可能な風邪薬は次の内どれ",
    answers: [
     "プレコール持続性カプセル",
     "パブロン50",
     "パイロンPL顆粒",
     "新ルルAゴールドDX"
    ],
    correct: "パブロン50"
    },{
        question: "車の運転が可能な解熱鎮痛薬は次の内どれ",
        answers: [
         "バファリンプレミアム",
         "バファリンプレミアムDX",
         "イブクイック頭痛薬DX",
         "イブA錠EX"
        ],
        correct: "バファリンプレミアムDX"
    }
];

const quizLength = quiz.length;
let quizIndex = 0;
let score = 0;
//$マークはHTMLのオブジェクト要素が入ってることを意味
const $button = document.getElementsByTagName("button");
const buttonLength = $button.length;
//クイズの問題文、選択肢を定義
const setupQuiz = () => {
//定数の文字列をHTMLに反映させる:HTMLにDIVタグは３つあるから独自のIDを名付ける
//HTML側にも反映させる:index.html L28 DIVタグの後に同じIDをつける→反映する
    document.getElementById("js-question").textContent = quiz[quizIndex].question;
    let buttonIndex = 0;
    //＜のあとは４でもいいけどボタンの増減に対応可能:レングス使う
    let buttonLength = $button.length;
    while(buttonIndex < buttonLength){
        $button[buttonIndex].textContent = quiz[quizIndex].answers[buttonIndex];
        buttonIndex++;
    }
}
//定義した関数を呼ぶ：ここのタイミングで関数実行！
setupQuiz();
//e.:マウスイベントのオブジェクト。target.:クリックされたボタン
const clickHandler = (e) => {
    if(quiz[quizIndex].correct === e.target.textContent) {
      window.alert("正解");
      //正解数カウント↓
      score++;
    } else {
      window.alert("はずれ");
    }
    quizIndex++;
    if(quizIndex < quizLength) {
//問題数がまだあれば実行
     setupQuiz();
    } else {
//問題数がもうなければ実行
      window.alert("問題終了です！あなたの正解数" + score + "/" + quizLength + "です！めざせ おくすりマスター☆");
    }
};

//ボタンクリックで正誤判定
let handlerIndex = 0;
while (handlerIndex < buttonLength) {
    $button[handlerIndex].addEventListener("click",(e) => {
        clickHandler(e);
    });    
     handlerIndex++;
};

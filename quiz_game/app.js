//問題記述
const quiz = [{
    question: "たぬきが宝くじを買いました。その結果はどうだったでしょう",
    answers: [
        "１等",
        "２等",
        "３等",
        "はずれ"
    ],
    colect: "はずれ"
}, {
    question: "「わきくけこ」が表す都道府県はなんでしょう",
    answers: [
        "北海道",
        "山梨県",
        "香川県",
        "神奈川県"
    ],
    colect: "香川県"
}, {
    question: "透明人間の職業はなんでしょう",
    answers: [
        "探偵",
        "ニート",
        "刀鍛冶",
        "自営業"
    ],
    colect: "ニート"
}, {
    question: "フランスの郵便ポストは黄色ですが、中国のポストは何色でしょう",
    answers: [
        "青",
        "緑",
        "黒",
        "赤"
    ],
    colect: "緑"
}, {
    question: "点を一つ取ると大きくなった生き物がいます。それはなんでしょう",
    answers: [
        "イヌ",
        "ネコ",
        "ニワトリ",
        "ウマ"
    ],
    colect: "イヌ"
}, {
    question: "どんなに噛んでも人が飲み込むことはないものはなんでしょう",
    answers: [
        "ガム",
        "きのこ",
        "飴",
        "ティッシュ"
    ],
    colect: "ティッシュ"
}, {
    question: "クリスマスパーティーの飾りつけをするために借りてきたものはなんでしょうか",
    answers: [
        "クリスマスリース",
        "クリスマスツリー",
        "雪だるま",
        "クラッカー"
    ],
    colect: "クリスマスリース"
}, 

];

//定数、変数
const quizLength = quiz.length;
let quizIndex = 0;
let score = 0;

const $button = document.getElementsByTagName("button");
const buttonLength = $button.length;

//クイズの問題文、選択肢を定義
const setupQuiz = () => {
    document.getElementById("js-question").textContent = quiz[quizIndex].question;
    let buttonIndex = 0;
    while (buttonIndex < buttonLength) {
        //ここに命令
        $button[buttonIndex].textContent = quiz[quizIndex].answers[buttonIndex];
        buttonIndex++;
    }
}
setupQuiz();

//正誤判断
const clickHandler = (e) => {
    if (quiz[quizIndex].colect === e.target.textContent) {
        window.alert("正解！");
        score++;
    } else {
        window.alert("不正解！");
    }

    quizIndex++;

    if (quizIndex < quizLength) {
        //問題数がまだあれば実行
        setupQuiz();
    } else {
        //問題数がなければ実行
        window.alert("終了！あなたの正解数は" + score + "/" + quizLength + "です！");
    }
};

//ボタンクリックで正誤判断
let handlerIndex = 0;
while (handlerIndex < buttonLength) {
    $button[handlerIndex].addEventListener("click", (e) => {
        clickHandler(e);
    });
    handlerIndex++;

}
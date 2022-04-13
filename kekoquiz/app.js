const quiz = [
  {
    question: 'クイズです',
    answers: [
      '4',
      '4',
      '4',
      '4'
    ],
    correct: '4' 
  },{
    question: '2問目です',
    answers: [
      '1',
      '1',
      '1',
      '1'
    ],
    correct: '1' 
  },{
    question: '3問目',
    answers: [
      '4',
      '4',
      '4',
      '4'
    ],
    correct: '4' 
  },{
    question: '今までの押したボタンの数字は？？',
    answers: [
      '1→2→3',
      '2→3→4',
      '3→4→5',
      '4→1→4'
    ],
    correct: '4→1→4' 
  },{
    question: 'それはなんの数字でしょう？？',
    answers: [
      'kekoさんのお誕生日',
      'kekoさんの体重',
      'kekoさんの身長',
      '林の結婚半年記念日'
    ],
    correct: '林の結婚半年記念日' 
  }
];

const quizLength = quiz.length;
let quizIndex = 0;




// 定数の文字列をHTMLに反映させる
const $button = document.getElementsByTagName('button');
const buttonLength = $button.length;

const setupQuiz = () => {
  document.getElementById('js-question').textContent = quiz[quizIndex].question;
  let buttonIndex = 0;
  let buttonLength = $button.length;
  while(buttonIndex < buttonLength){
    $button[buttonIndex].textContent = quiz[quizIndex].answers[buttonIndex];
    buttonIndex++;
  }
}
setupQuiz();

const clickHandler = (e) => {
  if(quiz[quizIndex].correct === e.target.textContent){
    alert('正解！');
  } else {
    alert('不正解');
    return false;
  }

  quizIndex++;

  if(quizIndex < quizLength){
    setupQuiz();
  } else {
    alert('いつも冗談に付き合ってくれてありがとう！');
  }


};

// ボタンをクリックしたら正誤判定

let handleIndex = 0;

while (handleIndex < $button.length) {
  $button[handleIndex].addEventListener('click',(e) => {
    clickHandler(e);
  });
  handleIndex++;
}

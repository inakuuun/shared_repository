// slickのサイトからSingleItemのコードをコピーし、
// 次へ前へボタンを非表示、ドットあり、自動再生あり、自動再生のスピードを2000にする

$(function(){
  $('.slider').slick({
    dots: true,
    autoplay: true,
    autoplaySpeed: 2000
  });
});
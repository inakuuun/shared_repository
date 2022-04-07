/*===========================================================*/
/*機能編  5-1-24 クリックしたら円形背景が拡大（中央から） */
/*===========================================================*/

$(".openbtn").click(function () { //ボタンがクリックされたら
	$(this).toggleClass('active'); //ボタン自身に activeクラスを付与し
	$("#g-nav").toggleClass('panelactive'); //ナビゲーションにpanelactiveクラスを付与
	$(".circle-bg").toggleClass('circleactive'); //丸背景にcircleactiveクラスを付与
});

$("#g-nav a").click(function () { //ナビゲーションのリンクがクリックされたら
	$(".openbtn").removeClass('active'); //ボタンの activeクラスを除去し
	$("#g-nav").removeClass('panelactive'); //ナビゲーションのpanelactiveクラスを除去
	$(".circle-bg").removeClass('circleactive'); //丸背景のcircleactiveクラスを除去
});

/*===========================================================*/
/*  ページ内の指定の場所にスクロール*/
/*===========================================================*/

$('#g-nav a,#footer a').click(function () {

	var elmHash = $(this).attr('href'); //ページ内リンクのHTMLタグhrefから、リンクされているエリアidの値を取得
	$(elmHash).css("position", "relative"); //idの上部の距離を取得するために1時的にstickyを無効にする
	var pos = $(elmHash).offset().top; //idの上部の距離を取得
	$(elmHash).css("position", "sticky"); //stickyを有効に戻す
	$('body,html').animate({
		scrollTop: pos
	}, 500); //取得した位置にスクロール。500の数値が大きくなるほどゆっくりスクロール
	return false;

});

/*===========================================================*/
/* 印象編 4 最低限おぼえておきたい動き*/
/*===========================================================*/


// 動きのきっかけの起点となるアニメーションの名前を定義
function fadeAnime() {

	// 4-7 にゅーん（滑らかに変形して出現）

	$('.smoothTrigger').each(function () { //smoothTriggerというクラス名が
		var elemPos = $(this).offset().top - 50; //要素より、50px上の
		var scroll = $(window).scrollTop();
		var windowHeight = $(window).height();
		if (scroll >= elemPos - windowHeight) {
			$(this).addClass('smooth'); // 画面内に入ったらsmoothというクラス名を追記
		} else {
			$(this).removeClass('smooth'); // 画面外に出たらsmoothというクラス名を外す
		}
	});
}


/*===========================================================*/
/* 印象編 8-16 滑らかに出現*/
/*===========================================================*/

// smoothTriggerにsmoothTextAppearというクラス名を付ける定義
function SmoothTextAnime() {
	$('.smoothTextTrigger').each(function () { //smoothTextTriggerというクラス名が
		var elemPos = $(this).offset().top - 50; //要素より、50px上の
		var scroll = $(window).scrollTop();
		var windowHeight = $(window).height();
		if (scroll >= elemPos - windowHeight) {
			$(this).addClass('smoothTextAppear'); // 画面内に入ったらsmoothTextAppearというクラス名を追記
		} else {
			$(this).removeClass('smoothTextAppear'); // 画面外に出たらsmoothTextAppearというクラス名を外す
		}
	});
}

/*===========================================================*/
/*印象編 5-14 波線（1つ）*/
/*===========================================================*/

var unit = 100,
	canvasList, // キャンバスの配列
	info = {}, // 全キャンバス共通の描画情報
	colorList; // 各キャンバスの色情報

/**
 * Init function.
 * 
 * Initialize variables and begin the animation.
 */
function init() {
	info.seconds = 0;
	info.t = 0;
	canvasList = [];
	colorList = [];
	// canvas1個めの色指定
	canvasList.push(document.getElementById("waveCanvas"));
	colorList.push(['#fff', '#fff', '#fff', '#fff', '#fff']); //重ねる波線の色設定


	// 各キャンバスの初期化
	for (var canvasIndex in canvasList) {
		var canvas = canvasList[canvasIndex];
		canvas.width = document.documentElement.clientWidth; //Canvasのwidthをウィンドウの幅に合わせる
		canvas.height = 200; //波の高さ
		canvas.contextCache = canvas.getContext("2d");
	}
	// 共通の更新処理呼び出し
	update();
}

function update() {
	for (var canvasIndex in canvasList) {
		var canvas = canvasList[canvasIndex];
		// 各キャンバスの描画
		draw(canvas, colorList[canvasIndex]);
	}
	// 共通の描画情報の更新
	info.seconds = info.seconds + .014;
	info.t = info.seconds * Math.PI;
	// 自身の再起呼び出し
	setTimeout(update, 35);
}

/**
 * Draw animation function.
 * 
 * This function draws one frame of the animation, waits 20ms, and then calls
 * itself again.
 */
function draw(canvas, color) {
	// 対象のcanvasのコンテキストを取得
	var context = canvas.contextCache;
	// キャンバスの描画をクリア
	context.clearRect(0, 0, canvas.width, canvas.height);

	//波線を描画 drawWave(canvas, color[数字], 透過, 波の幅のzoom,波の開始位置の遅れ )
	drawWave(canvas, color[0], 0.5, 3, 0);
	drawWave(canvas, color[1], 0.8, 4, 0);
	drawWave(canvas, color[2], 0.5, 1.6, 0);
	drawWave(canvas, color[3], 0.8, 3, 100);
	drawWave(canvas, color[4], 0.5, 1.6, 250);
}

/**
 * 波を描画
 * drawWave(色, 不透明度, 波の幅のzoom, 波の開始位置の遅れ)
 */
function drawWave(canvas, color, alpha, zoom, delay) {
	var context = canvas.contextCache;
	context.strokeStyle = color; //線の色
	context.lineWidth = 1; //線の幅
	context.globalAlpha = alpha;
	context.beginPath(); //パスの開始
	drawSine(canvas, info.t / 0.5, zoom, delay);
	context.stroke(); //線
}

/**
 * Function to draw sine
 * 
 * The sine curve is drawn in 10px segments starting at the origin. 
 * drawSine(時間, 波の幅のzoom, 波の開始位置の遅れ)
 */
function drawSine(canvas, t, zoom, delay) {
	var xAxis = Math.floor(canvas.height / 2);
	var yAxis = 0;
	var context = canvas.contextCache;
	// Set the initial x and y, starting at 0,0 and translating to the origin on
	// the canvas.
	var x = t; //時間を横の位置とする
	var y = Math.sin(x) / zoom;
	context.moveTo(yAxis, unit * y + xAxis); //スタート位置にパスを置く

	// Loop to draw segments (横幅の分、波を描画)
	for (i = yAxis; i <= canvas.width + 10; i += 10) {
		x = t + (-yAxis + i) / unit / zoom;
		y = Math.sin(x - delay) / 3;
		context.lineTo(i, unit * y + xAxis);
	}
}

init();

/*===========================================================*/
/*印象編 5-17 粒子が集まってタイポグラフィーを形成する*/
/*===========================================================*/

function particleTextAnime() {

	$("#particle").particleText({
		text: "T o m  S a e k i", // 表示させたいテキスト。改行の場合は<br>追加
		colors: ["#000"], // パーティクルの色を複数指定可能
		speed: "high", // slow, middle, high の3つから粒子が集まる速さを選択
	});
}

/*===========================================================*/
/*印象編 9-4-1 SVG アニメーション
/*===========================================================*/

//SVGの初期設定

var logoVivus1; //1つめのSVG設定
var logoVivus2; //2つめのSVG設定
var logoVivus3; //3つめのSVG設定

//1～3のSVG初期設定
function VivusInit() {
	//1つめのSVG初期設定
	logoVivus1 = new Vivus('logo', {
			start: 'autostart', //アニメーションの自動再生
			type: 'scenario', // アニメーションのタイプを設定
			pathTimingFunction: Vivus.EASE, //動きの加速減速設定
		},
		function (obj) {
			$("#logo").attr("class", "done"); //描画が終わったらdoneというクラスを追加
		}
	);
	logoVivus1.stop();

	//2つめのSVG初期設定
	logoVivus2 = new Vivus('logo2', {
			start: 'autostart', //アニメーションの自動再生
			duration: 80, //アニメーションの時間設定。数字が小さくなるほど速い
			type: 'scenario-sync', // アニメーションのタイプを設定
			pathTimingFunction: Vivus.EASE_OUT, //動きの加速減速設定
		},
		function (obj) {
			$("#logo2").attr("class", "done"); //描画が終わったらdoneというクラスを追加
		}
	);
	logoVivus2.stop();

	//3つめのSVG初期設定
	logoVivus3 = new Vivus('logo3', {
			start: 'autostart', //アニメーションの自動再生
			type: 'oneByOne', // アニメーションのタイプを設定
			pathTimingFunction: Vivus.EASE, //動きの加速減速設定
		},
		function (obj) {
			$("#logo3").attr("class", "done"); //描画が終わったらdoneというクラスを追加
		}
	);
	logoVivus3.stop();

}


//スクロールをしたらSVGが出現する設定
function VivusAnime() {
	//スクロールをしたら1つめのSVGが出現する設定
	var elemPos = $('#logo').offset().top - 50; //要素より、50px上の位置まで来たら出現
	var scroll = $(window).scrollTop();
	var windowHeight = $(window).height();
	if (scroll >= elemPos - windowHeight) {
		logoVivus1.play(1); //描画される速さ。数が大きくなるほど速い
	}

	//スクロールをしたら2つめのSVGが出現する設定
	var elemPos = $('#logo2').offset().top - 50; //要素より、50px上の位置まで来たら出現
	var scroll = $(window).scrollTop();
	var windowHeight = $(window).height();
	if (scroll >= elemPos - windowHeight) {
		logoVivus2.play(4); //描画される速さ。数が大きくなるほど速い
	}

	//スクロールをしたら3つめのSVGが出現する設定
	var elemPos = $('#logo3').offset().top - 50; //要素より、50px上の位置まで来たら出現
	var scroll = $(window).scrollTop();
	var windowHeight = $(window).height();
	if (scroll >= elemPos - windowHeight) {
		logoVivus3.play(2); //描画される速さ。数が大きくなるほど速い
	}
}


/*===========================================================*/
/* 関数をまとめる*/
/*===========================================================*/

// 画面をスクロールをしたら動かしたい場合の記述
$(window).scroll(function () {
	fadeAnime(); //印象編 4 最低限おぼえておきたい動きの関数を呼ぶ
	SmoothTextAnime(); //印象編 8-16テキストが滑らかに出現の関数を呼ぶ
	VivusAnime(); //印象編 9-4-1 SVG アニメーションの関数を呼ぶ
}); // ここまで画面をスクロールをしたら動かしたい場合の記述

// ページが読み込まれたらすぐに動かしたい場合の記述
$(window).on('load', function () {
	$("#splash-logo").delay(1200).fadeOut('slow'); //ロゴを1.2秒でフェードアウトする記述

	//=====ここからローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる
	$("#splash").delay(1500).fadeOut('slow', function () { //ローディングエリア（splashエリア）を1.5秒でフェードアウトする記述
		$('body').addClass('appear'); //フェードアウト後bodyにappearクラス付与
		VivusInit(); //印象編 9-4-1 SVG アニメーションの初期設定
		VivusAnime(); //印象編 9-4-1 SVG アニメーションの関数を呼ぶ
	});
	//=====ここまでローディングエリア（splashエリア）を1.5秒でフェードアウトした後に動かしたいJSをまとめる

	//=====ここから背景が伸びた後に動かしたいJSをまとめたい場合は
	$('.splashbg').on('animationend', function () {
		fadeAnime(); //印象編 4 最低限おぼえておきたい動きの関数を呼ぶ
		SmoothTextAnime(); //印象編 8-16テキストが滑らかに出現の関数を呼ぶ
		particleTextAnime(); //印象編 5-17粒子が集まってテキストになる関数を呼ぶ
	});
	//=====ここまで背景が伸びた後に動かしたいJSをまとめる    

}); // ここまでページが読み込まれたらすぐに動かしたい場合の記述
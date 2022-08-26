var setTimeoutId = null;
var _userAgent = window.navigator.userAgent.toLowerCase();
var _appVersion = window.navigator.appVersion.toLowerCase();
$(function () {

	if (!!$(window.location.hash) && window.location.hash !== "") {
		// 移動先を数値で取得
		var position = $(window.location.hash).offset().top - $('header').height();
		var browser = getBrowser();
		if (browser == 'ie9' || browser == 'ie10' || browser == 'ie11' || browser == 'edge') {
			// ieの場合1秒まつ
			setTimeout(function () {
				position = $(window.location.hash).offset().top - $('header').height();
				$('body,html').scrollTop(position);
			}, 1000);
		} else {
			$('body,html').scrollTop(position);
		}
	};


	// #pagetop aをクリックした場合に処理
	$('#pagetop, a[href^="#"]').click(function () {
		if ($(this).data("remodal-target") && 0 < $(this).data("remodal-target").length) {
			return;
		}
		// スクロールの速度
		var speed = 700; // ミリ秒
		// アンカーの値取得
		var href = $(this).attr("href");
		// 移動先の補正地を取得
		//var adjust = $(window).innerWidth() < 1000 ? -30 : 0;
		// 移動先を取得
		var target = $(href == "#" || href == "" ? 'html' : href);
		// 移動先を数値で取得
		var position = target.offset().top; // + adjust;
		if (href == "#") {
			position = 0;
		}
		/*		else if($('#head:visible').length < 1 ){
					position -= $('.head_top').height();
				}*/
		else {
			position -= $('#head').height() - 1;
		}

		var browser = getBrowser();
		if (browser == 'ie10' || browser == 'ie11') {
			position = position + 1;
		}

		// スムーススクロール
		$('body,html').animate({
			scrollTop: position
		}, speed, 'swing');
		return false;
	});

	$("#pagetop").hide();
	// ↑ページトップボタンを非表示にする

	$(window).on("scroll", function () {

		if (setTimeoutId) {
			clearTimeout(setTimeoutId);
		}
		// 新しくsetTimeoutイベントを設定
		setTimeoutId = setTimeout(function () {
			// スクロール終了時の処理内容
			if ($(this).scrollTop() > 100) {
				// ↑ スクロール位置が100よりも小さい場合に以下の処理をする
				$('#pagetop').slideDown();
				// ↑ (100より小さい時は)ページトップボタンをスライドダウン
			} else {
				$('#pagetop').slideUp();
				// ↑ それ以外の場合の場合はスライドアップする。
			}
			// setTimeoutIdを空にする
			setTimeoutId = null;
		}, 100);


		// フッター固定する
		var scrollHeight = $(document).height();
		// ドキュメントの高さ
		// var scrollPosition = $(window).height() + $(window).scrollTop();
		var scrollTop = $(window).scrollTop();
		var scrollPosition = $(window).height() + scrollTop;
		//　ウィンドウの高さ+スクロールした高さ→　現在のトップからの位置
		var footHeight = $("#foot").innerHeight();
		// フッターの高さ
		var humbergerTopPosition = ($(".main_vis .main_vis_head").position()) ? $(".main_vis .main_vis_head").position().top : 0;


		var right = "";
		var bottom = "";
		if ($(window).innerWidth() < 767) {
			footHeight -= $(".footer_banner").innerHeight();
			right = "0";
			bottom = "9.5vw";
		} else {
			footHeight += 147 - $("#pagetop").innerHeight();
			right = $(window).innerWidth() < 1000 ? "20px" : "50px";
			bottom = "10px";
		}

		// ヘッダーの高さ
		if (scrollHeight - scrollPosition <= footHeight) {
			// 現在の下から位置が、フッターの高さの位置にはいったら
			//  ".gotop"のpositionをabsoluteに変更し、フッターの高さの位置にする
			$("#pagetop").css({
				"position": "absolute",
				"right": right,
				"bottom": "",
				"top": ""
				//				"bottom": footHeight + "px"
			});

		} else {
			// それ以外の場合は元のcssスタイルを指定
			$("#pagetop").css({
				"position": "fixed",
				"right": right,
				"bottom": bottom,
				"top": "inherit",
				"z-index": 9
			});
		}

		/* menuの表示切替 */
		if (isSp() === false &&
			!!$("body").attr("id") &&
			$("body").attr("id") === "top") {
			var mvHeight = ($("#main_vis_nav").position()) ? $("#main_vis_nav").position().top + $("#main_vis_nav").innerHeight() : -1;

			if (0 < mvHeight) {
				if (mvHeight < scrollTop) {
					$("#head").slideDown();
				} else {
					$("#head").slideUp();
				}
			}
		} else {
			$("#head").slideDown();
		}
	});

});

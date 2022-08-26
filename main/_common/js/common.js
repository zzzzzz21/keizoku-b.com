// 全ページ共通

function isSp(){
	var windowWidth = $(window).width();
	if(windowWidth < 768){
		return true;
	}else{
		return false;
	}
}

function getBrowser() {
	if (_appVersion.indexOf("msie 9.") != -1) {
		return 'ie9';
	} else if (_appVersion.indexOf("msie 10.") != -1) {
		return 'ie10';
	} else if ((_appVersion.indexOf("msie 11.") != -1) || (_appVersion.indexOf("rv:11") != -1 && _appVersion.indexOf("trident") != -1)) {
		return 'ie11';
	} else if ((_appVersion.indexOf("safari") != -1) && (_appVersion.indexOf("chrome") == -1)) {
		return 'safari';
	}
	return '';
}

$(function() {
	/* menu開閉 */
	$('.head_menu.btn, #lnav a').click(function() {
		var target = $(this);
		if(!!target.hasClass('opened')) {
			target.removeClass('opened');
		} else {
			target.addClass('opened');
		}
		if(isSp() !== false){
			$("#lnav").fadeToggle();
		}
	});

	// カルーセル初期化
	initSlider(window.innerWidth);

	// リサイズ完了時
	var timer = false;
	var tmpW = 0;

	$(window).resize(function () {
		var w = window.innerWidth;

		if (w != tmpW) {
			tmpW = w;
			if (w < 768) {
				$("#head").show();
				// $("#lnav").hide();
			}else{
				$("#head").hide();
				// $("#lnav").show();
				$("#menu_tel").hide();
			}
		}

		if (timer !== false) {
			clearTimeout(timer);
		}
		timer = setTimeout(function () {
			initSlider(window.innerWidth);
		}, 200);
		
		if (isSp() === false &&
			!!$("body").attr("id") &&
			$("body").attr("id") === "top") {
			var mvHeight = ($("#main_vis_nav").position()) ? $("#main_vis_nav").position().top + $("#main_vis_nav").innerHeight() : -1;
			var scrollTop = $(window).scrollTop();
			if (0 < mvHeight) {
				if (mvHeight < scrollTop) {
					$("#head").slideDown();
				} else {
					$("#head").slideUp();
				}
			}
		}
		else{
			$("#head").show();
		}
	});
	
	
	function initSlider(wWidth) {
		// slider
		var $jsSlider = $('.js_slider');

		if(!$jsSlider || $jsSlider.length < 1){
			return;
		}
		
		// 初期化状況：ture初期化済/false未初期化
		var initialised = 0 < $(".slick-initialized").length;

		if (initialised == false) {
			// 初期化が済んでいない場合
			// SP幅ならsliderを設定する
			if (wWidth < 768) {
				$jsSlider.slick({
					infinite: true,
					slidesToShow: 1,
					variableWidth: true,
					swipeToSlide: true,
					autoplay: false,
					cssEase: 'linear',
					autoplaySpeed: 3000,
					centerMode: true
				});
			}
		} else {
			// 初期化が済んでいる場合
			// SP幅なら何もしない
			// PC幅ならsliderを解除する
			if (767 < wWidth) {
				$jsSlider.slick('unslick');
			}
		}
	}
});


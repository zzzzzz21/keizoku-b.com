// アコーディオン

$(function() {
	$('.accordion').click(function() {
		var target = $(this);
		if(!!target.hasClass('opened')) {
			target.removeClass('opened');
/*			if(0 < target.parents('#faq').length) {
				$(".faq_q_toggle_ic", target).text("詳細を見る");
			}*/
		} else {
			target.addClass('opened');
/*			if(0 < target.parents('#faq').length) {
				$(".faq_q_toggle_ic", target).text("閉じる");
			}*/
		}
//		if(0 < target.parents('#faq').length) {
			target.next().slideToggle();
/*
		}else{
			target.next().slideDown();
		}
*/
	});
});
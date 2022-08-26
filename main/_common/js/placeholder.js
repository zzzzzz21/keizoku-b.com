$(function () {
	$('input[type=text],input[type=password],textarea').each(function () {
		var thisTitle = $(this).attr('title');
		if($(this).hasClass("datepicker")){
			var baseDate = new Date();
			var datepickerIndex = $(".datepicker").index(this);
			for (var i=0; i<datepickerIndex; i++) {
				baseDate = getNextDate(baseDate);
			}
			var w = "";
			switch(baseDate.getDay()){
				case 0:
					w="(日)";
					break;
				case 1:
					w="(月)";
					break;
				case 2:
					w="(火)";
					break;
				case 3:
					w="(水)";
					break;
				case 4:
					w="(木)";
					break;
				case 5:
					w="(金)";
					break;
				case 6:
					w="(土)";
					break;
			}
			thisTitle += baseDate.getFullYear() + "/" + (baseDate.getMonth()+1) + "/" + baseDate.getDate() + w;
		}
		if (!(thisTitle === '')) {
			$(this).wrapAll('<span style="text-align:left;display:inline-block;position:relative;"></span>');
			$(this).parent('span').append('<span class="placeholder">' + thisTitle + '</span>');
			$('.placeholder').css({
				top: '1.0em',
				left: '5px',
				fontSize: '100%',
				lineHeight: '120%',
				textAlign: 'left',
				color: '#999',
				overflow: 'hidden',
				position: 'absolute',
				zIndex: '1'
			}).click(function () {
				$(this).prev().focus();
			});

			$(this).focus(function () {
				$(this).next('span').css({
					display: 'none'
				});
			});

			$(this).blur(function () {
				var thisVal = $(this).val();
				if (thisVal === '') {
					$(this).next('span').css({
						display: 'inline-block'
					});
				} else {
					$(this).next('span').css({
						display: 'none'
					});
				}
			});

			var thisVal = $(this).val();
			if (thisVal === '') {
				$(this).next('span').css({
					display: 'inline-block'
				});
			} else {
				$(this).next('span').css({
					display: 'none'
				});
			}
		}
	});
});


function getNextDate(baseDate) {
	baseDate = new Date(baseDate.setDate(baseDate.getDate() + 1));
	if (!!baseDate) {
		if (
			baseDate.getDay() == 0 ||
			baseDate.getDay() == 6
		) {
			return getNextDate(baseDate);
		}
	}
	return baseDate;

}
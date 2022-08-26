// form

// 祝日を配列で確保
var holidays = [
	'2012-10-08',
	'2012-11-03',
	'2012-12-24'
];

$(function () {

	// 1.$.ajaxメソッドで通信を行います。
	//  dataでは、フォームの内容をserialize()している
	//  →serialize()の内容は、cs1=custom1&cs2=custom2
	$.ajax({
		url: 'https://holidays-jp.github.io/api/v1/date.json', // 通信先のURL
		type: 'GET', // 使用するHTTPメソッド (GET/ POST)
		//data: '', // 送信するデータ
		dataType: 'json', // 応答のデータの種類 
		// (xml/html/script/json/jsonp/text)
		timeout: 1000, // 通信のタイムアウトの設定(ミリ秒)

		// 2. doneは、通信に成功した時に実行される
		//  引数のdata1は、通信で取得したデータ
		//  引数のtextStatusは、通信結果のステータス
		//  引数のjqXHRは、XMLHttpRequestオブジェクト
	}).done(function (data1, textStatus, jqXHR) {
		console.log(jqXHR.status); //jqXHR.statusを表示
		console.log(textStatus); //textStatusを表示
		holidays = data1;
		console.log("holidays:" + data1[1][1]);

		initDatePicker(data1);

		// 6. failは、通信に失敗した時に実行される
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.log(jqXHR.status); //jqXHR.statusを表示
		console.log(textStatus); //textStatusを表示
		console.log(errorThrown); //errorThrownを表示
		initDatePicker(holidays);

		// 7. alwaysは、成功/失敗に関わらず実行される
	}).always(function () {
		console.log("complete"); //表示3

	});



});

function initDatePicker(holidays) {
	$("#datepicker").datepicker({
		numberOfMonths: [1, 2],
		beforeShowDay: function (date) {
			// 祝日の判定
			for (var i = 0; i < holidays.length; i++) {
				var htime = Date.parse(holidays[i]); // 祝日を 'YYYY-MM-DD' から time へ変換
				var holiday = new Date();
				holiday.setTime(htime); // 上記 time を Date へ設定

				// 祝日
				if (holiday.getYear() == date.getYear() &&
					holiday.getMonth() == date.getMonth() &&
					holiday.getDate() == date.getDate()) {
					return [false, 'holiday'];
				}
			}
			// 日曜日
			if (date.getDay() == 0) {
				return [false, 'sunday'];
			}
			// 土曜日
			if (date.getDay() == 6) {
				return [false, 'saturday'];
			}
			/*
						// 水曜日
						if (date.getDay() == 3) {
							return [false, ''];
						}
			*/
			// 平日
			return [true, ''];
		},
		onSelect: function (dateText, inst) {
			$("#date_val").val(dateText);
		}
	});
	// サンプル用のデフォルト日付
	var baseDate = getNextDate(new Date(), holidays);
	$("#datepicker").datepicker("setDate", baseDate); // -1 for 0 based month.
}

function getNextDate(baseDate, holidays) {
	baseDate = new Date(baseDate.setDate(baseDate.getDate() + 1));
	console.log(baseDate);
	console.log("holidays:" + holidays);

	if (!!baseDate) {
		if (
			baseDate.getDay() == 0 ||
			baseDate.getDay() == 6
		) {
			console.log(0);
			return getNextDate(baseDate, holidays);
		} else if (!!holidays) {
			// 祝日の判定
			for (var i = 0; i < holidays.length; i++) {
				var htime = Date.parse(holidays[i]); // 祝日を 'YYYY-MM-DD' から time へ変換
				var holiday = new Date();
				holiday.setTime(htime); // 上記 time を Date へ設定


				// 祝日
				if (holiday.getYear() == baseDate.getYear() &&
					holiday.getMonth() == baseDate.getMonth() &&
					holiday.getDate() == baseDate.getDate()) {
					console.log(1);
					return getNextDate(baseDate, holidays);
				}
			}
			console.log(2);
			return baseDate;
		} else {
			console.log(3);
			return baseDate;
		}
	}
	return baseDate;

}

<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 最終更新日2014/12/12
#　改造や改変は自己責任で行ってください。
#
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "./";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "info@second-sapporo.com,info@plusta-sapporo.com,info@trbiz.biz,cw@connectgroup.co.jp,cw-toyohira@connectgroup.co.jp,cw-tsukisamu@connectgroup.co.jp,cb-kotoni@connectgroup.co.jp,cw-odori-e@connectgroup.co.jp";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "Email";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "google.co.jp/";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "お問合わせメール_LP";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "./thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです。
配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。*/
$require = array('お名前','Email','お問合せ種類','お問合せ内容');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "札幌継続支援センター（セコンド/プラスタ/コネクトワークス/コネクトベース）";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "送信ありがとうございました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

この度は札幌継続支援センター
［セコンド/プラスタ/コネクトワークス/コネクトベース］へお問合わせ、
誠にありがとうございます。
メールは問題無く送信されました。
当事業所担当者よりご返信させていただきます。

送信内容は以下になります。

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 1;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
札幌継続支援センター
http://keizoku-b.com/

■継続支援セコンド
〒063-0003
札幌市西区山の手3条1丁目3-25 プリエ琴似 2F
TEL：011-213-9825 / FAX：011-215-8438

■継続支援プラスタ
〒060-0061
札幌市中央区南1条西18丁目1-2 南1西18ビル 2Ｆ
TEL：011-624-5409 / FAX：011-624-6409

■継続支援コネクトワークス新さっぽろ
〒004-0051
札幌市厚別区厚別中央1条6丁目2−15 新札幌センタービル 4F
TEL：011-887-6381

■継続支援コネクトワークス 大通東
〒060-0032 札幌市中央区北2条東1丁目2-2
プラチナ札幌ビル 3F
TEL：011-200-0882 / FAX：011-215-0838

■継続支援コネクトワークス 豊平
札幌市豊平区美園10条7丁目2-1
ナリッシュ美園 2F
TEL：011-887-0306 / FAX：011-887-0316

■継続支援コネクトワークス 月寒
札幌市豊平区月寒中央通5丁目2-20
レジデンス月寒中央 1F
TEL：011-826-5555 / FAX：011-826-5099

■多機能型コネクトベース 琴似
札幌市西区山の手3条3丁目3-14
TEL：011-688-6699 / FAX：011-699-6644
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 0;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('電話番号','金額');


//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">メールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}
  
if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
	
	//差出人に届くメールをセット
	if($remail == 1) {
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($userMail,$post_mail,$BccMail,$to);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";
	
	mail($to,$subject,$adminBody,$header);
	if($remail == 1) mail($post_mail,$re_subject,$userBody,$reheader);
}
else if($confirmDsp == 1){ 

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?><!DOCTYPE html>
<html lang="ja">

	<head>
		<meta charset="UTF-8">
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>コネクトワークス|コネクトベース|プラスタ|セコンド|札幌の就労継続支援B型事業所 札幌継続支援センター</title>
		<meta name="description"
			content="各種障がい（精神、発達、身体、知的、難病）をもつ方々が活躍する札幌の就労継続支援B型事業所 札幌継続支援センター　コネクトワークス ｜ コネクトベース | プラスタ | セコンド">
		<meta name="keywords" content="継続支援B型,B型,就労支援,継続支援,自立訓練,生活訓練,セコンド,second,プラスタ,plusta,コネクトワークス,コネクトベース,コネクト,札幌,障がい者,障害者,就労">
		<meta name="author" content="札幌継続支援センター 継続支援コネクトワークス｜多機能型コネクトベース｜継続支援プラスタ｜継続支援セコンド">
		<link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/notosansjapanese.css">
		<link rel="stylesheet" href="../_common/css/reset.css">
		<link rel="stylesheet" href="../_common/css/remodal-default-theme.css">
		<link rel="stylesheet" href="../_common/css/remodal.css">
		<link rel="stylesheet" href="../_common/css/common.css">
		<link rel="stylesheet" href="../_common/css/subpage.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../_common/js/common.js"></script>
		<script src="../_common/js/remodal.js"></script>
		<script src="../_common/js/scroll.js" async defer></script>
	</head>

	<body id="inquiry" class="subpage">
		<header id="head" class="head">
			<div class="head_top clearfix">
				<span class="head_logo">
						<a href="../">
							<img src="../_common/img/head_logo2.png" alt="札幌の就労継続支援B型事業所 札幌継続支援センター" class="for_pc">
							<img src="../_common/img/sp/head_logo.png" alt="札幌の就労継続支援B型事業所 札幌継続支援センター" class="for_sp">
							<span class="for_pc">お電話は平日10時～17時までいつでもOK！</span>
						</a>
					</span>
					<div class="head_tel_block for_pc">
						<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_connect_tsukisamu">月寒</span><span
								class="head_name head_name_connect_tsukisamu">継続支援コネクトワークス</span>
							<br><span class="head_tel">011-826-5555</span>
						</div>
						<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_connect_toyohira">豊平</span><span
								class="head_name head_name_connect_toyohira">継続支援コネクトワークス</span>
							<br><span class="head_tel">011-887-0306</span>
						</div>
						<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_connect_kotoni">琴似</span><span
								class="head_name head_name_connect_kotoni">多機能型コネクトベース</span>
							<br><span class="head_tel">011-688-6699</span>
						</div>
						<!--<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_connect">大通東</span><span
								class="head_name head_name_connect">継続支援コネクトワークス</span>
							<br><span class="head_tel">011-200-0882</span>
						</div>-->
						<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_shin-sapporo">新さっぽろ</span><span
								class="head_name head_name_shin-sapporo">継続支援コネクトワークス</span>
							<br><span class="head_tel">011-887-6831</span>
						</div>
						<!--<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_plusta">西18丁目</span><span
								class="head_name head_name_plusta">継続支援プラスタ</span>
							<br><span class="head_tel">011-624-5409</span>
						</div>-->
						<!--<div class="head_tel_box">
							<span class="head_chiiki head_chiiki_second">琴似</span><span class="head_name head_name_second">継続支援セコンド</span>
							<br><span class="head_tel">011-213-9825</span>
						</div>-->
					</div>
					<!-- /.head_tel_block -->
					<a href="../inquiry/" class="head_inquiry_link">
						<img src="../_common/img/head_inquiry_bn.png" alt="お気軽にお問合せください！ お問合せ・見学のお申込み">
					</a>
				<div class="head_inquiry_link for_sp">
					<a href="tel:0110000000"><img src="../_common/img/sp/head_inquiry_tel.png" alt="TEL" class="head_inquiry_tel for_sp btn"></a>
					<a href="../inquiry/" class="head_inquiry_mail for_sp">
						<img src="../_common/img/sp/head_inquiry_mail.png" alt="MAIL">
					</a>
					<img src="../_common/img/sp/head_menu.png" alt="MENU" class="head_menu for_sp btn">
				</div>
			</div>
			<!-- /.head_top -->
			<nav class="lnav hnav for_sp" id="lnav">
				<img src="../_common/img/sp/head_menu_close.png" alt="MENU" class="head_menu for_sp btn">
				<ul class="lnav_inr hnav_inr for_pc">
					<li><a href="../#about">札幌継続支援<br>センターとは</a></li>
					<li><a href="../#syoshinsya">未経験者でも安心<br>こんな方大歓迎！</a></li>
					<li><a href="../#flow_day">一日の流れ<br>ステップアップ例</a></li>
					<li><a href="../#voice">職員と<br>利用者の声</a></li>
					<li><a href="../#faq">よくある<br>ご質問</a></li>
					<li><a href="../#howto">ご利用までの<br>流れ</a></li>
				</ul>
				<ul class="lnav_inr hnav_inr for_sp">
					<li><a href="../#about">札幌継続支援<br>センターとは</a></li>
					<li><a href="../#syoshinsya">未経験者でも安心！</a></li>
					<li><a href="../#flow_day">一日の流れ / ステップアップ例</a></li>
					<li><a href="../#voice">職員と<br>利用者の声</a></li>
					<li><a href="../#faq">よくある<br>ご質問</a></li>
					<li><a href="../#howto">ご利用までの<br>流れ</a></li>
				</ul>
			</nav>
			<div class="menu_tel" id="menu_tel">
			<div class="menu_tel_ttl">
				<img src="../_common/img/sp/menu_ttl.png" alt="お気軽にお問い合わせください！お問い合わせ・見学のお申込み">
				<img src="../_common/img/sp/head_menu_close.png" alt="MENU" class="menu_tel for_sp btn">
			</div>
			<p class="head_tel_txt">
				<span>各施設をタップすると電話がかかります！</span> お電話は平日10時～17時までいつでもOK！
			</p>
			<a href="tel:0118870306" class="access_box access_box_full access_box_connect_toyohira">
				<img src="../_common/img/sp/access_connect_toyohira_chiku.png" alt="豊平　継続支援コネクトワークス豊平 ConnectWorksToyohira"
					class="access_box_chiku">
				<img src="../_common/img/sp/access_connect_toyohira_txt.png" alt="継続支援コネクトワークス豊平 ConnectWorksToyohira" class="text">
				<div class="wrapper">
					<img class="tel" src="../_common/img/sp/access_connect_toyohira_tel.png" alt="豊平　継続支援コネクトワークス豊平 011-887-0306">
				</div>
			</a>
			<a href="tel:0112000882" class="access_box access_box_full access_box_connect">
				<img src="../_common/img/sp/access_connect_chiku.png" alt="大通東　継続支援コネクトワークス ConnectWorks"
					class="access_box_chiku">
				<img src="../_common/img/sp/access_connect_txt.png" alt="継続支援コネクトワークス ConnectWorks" class="text">
				<div class="wrapper">
					<img class="tel" src="../_common/img/sp/access_connect_tel.png" alt="大通東　継続支援コネクトワークス 011-200-0882">
				</div>
			</a>
			<a href="tel:0112998672" class="access_box access_box_trbiz">
				<img src="../_common/img/sp/access_trbiz_chiku.png" alt="札幌北" class="access_box_chiku">
				<div class="access_box_inr">
					<img src="../_common/img/sp/top/access_trbiz_txt.png" alt="札幌北 南北線「麻生駅」徒歩5分 南北線「北34条駅」徒歩5分 JR「新琴似駅」徒歩8分"
						class="access_eki">
					<img src="../_common/img/sp/top/access_trbiz_logo_02.png" alt="継続支援トラビズ TRbiz" class="access_logo">
					<p class="access_box_tel">
						<img src="../_common/img/sp/top/inquiry_tel_bn_trbiz.png" alt="札幌北 継続支援トラビズ 011-299-8672">
					</p>
				</div>
				<!-- /.access_box_inr -->
			</a>
			<!-- /.access_box -->
			<a onclick="javascript:goog_report_conversion('tel:011-213-9825');yahoo_report_conversion(undefined);return false;" href="tel:011-213-9825" class="access_box access_box_second">
				<img src="../_common/img/sp/access_second_chiku.png" alt="琴似" class="access_box_chiku">
				<div class="access_box_inr">
					<img src="../_common/img/sp/access_second_txt.png" alt="琴似 東西線「琴似駅」徒歩10分 JR「琴似駅」徒歩14分" class="access_eki">
					<img src="../_common/img/sp/access_second_logo.png" alt="継続支援セコンド Second" class="access_logo">
					<p class="access_box_tel">
						<img src="../_common/img/sp/inquiry_tel_bn_second.png" alt="琴似 継続支援セコンド 011-213-9825">
					</p>
				</div>
				<!-- /.access_box_inr -->
			</a>
			<!-- /.access_box -->
			<p class="menu_tel_txt">
				メールフォームからでもOK！
			</p>
			<a href="inquiry/" class="inquiry_bn">
				<img src="../_common/img/sp/top/inquiry_bn.png" alt="お気軽にお問合せください！お問合せ・見学のお申込み">
			</a>
		</div>
		</header>
		<main id="main">
			<div class="inquiry">
				<h2 class="inquiry_ttl section_ttl">
					確認画面
					<img src="../_common/img/top/ttl_bottom_arrow_orange.png" alt="" class="ttl_bottom_arrow">
				</h2>
<!-- ▲ Headerやその他コンテンツなど　※自由に編集可 ▲-->

<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
				<?php if($empty_flag == 1){ ?>
					<div class="inquiry_inr error" id="inquiry_box">
						<div class="inquiry_lead">
							<p>入力にエラーがあります。<br class="for_sp">下記をご確認の「前画面に戻る」ボタンにて<br class="for_sp">修正をお願い致します。</p>
						</div>
						<div class="form_box">
							<div class="message">
							<?php echo $errm; ?>
							</div>
							<div class="btn">
							<input type="button" value="前画面に戻る" onClick="history.back();return false;">
							</div>
						</div><!--.form_box-->
					</div><!--.inquiry_inr-->
				<?php }else{ ?>
				<div class="inquiry_inr confirm" id="inquiry_box">
						<div class="inquiry_lead">
							<p>以下の内容で間違いがなければ、<br class="for_sp">「送信する」ボタンを押してください。</p>
						</div>
						<div class="form_box">
							<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="POST">
								<?php echo confirmOutput($_POST);//入力内容を表示?>
								<div class="form_btn_box">
									<input type="hidden" name="mail_set" value="confirm_submit">
									<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']);?>">
									<div class="btn">
									<input type="submit" value="送信する">
									</div>
									<div class="btn">
									<input type="button" value="前画面に戻る" onClick="history.back();return false;">
									</div>
								</div>
							</form>
						</div><!--.form_box-->
					</div><!--.inquiry_inr-->
				<?php } ?>
			</div><!--inquiry-->
		</main>
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
		<div class="footer_banner for_sp">
			<p>豊平・大通東・札幌北・西18丁目・琴似の継続支援B型事業所</p>
		</div>
		<!-- /.footer_banner -->

	<footer id="foot" class="foot">
		<div class="foot_area">
			<ul class="foot_nav for_pc">
				<li>
					<a href="#" data-remodal-target="modal_privacy_policy">プライバシーポリシーについて</a>
				</li>
				<li>
					<a href="#" data-remodal-target="modal_corporation">運営会社について</a>
				</li>
			</ul>
			<h2 class="foot_ttl">
				札幌継続支援センターの施設一覧
			</h2>
			<div id="foot_address">
				<address class="address_connect clearfix">
					<p class="adress_name_connect_tsukisamu">継続支援コネクトワークス</p>
					<p class="adress_place_connect_tsukisamu">月寒</p>
					<p class="foot_jusyo">〒062-0020&nbsp;&nbsp;&nbsp;札幌市豊平区月寒中央通5丁目2-20 レジデンス月寒中央 1F</p>
				</address>
				<address class="address_connect clearfix">
					<p class="adress_name_connect_toyohira">継続支援コネクトワークス</p>
					<p class="adress_place_connect_toyohira">豊平</p>
					<p class="foot_jusyo">〒062-0010&nbsp;&nbsp;&nbsp;札幌市豊平区美園10条7丁目2-1 ナリッシュ美園 2F</p>
				</address>
				<address class="address_connect clearfix">
					<p class="adress_name_connect_kotoni">多機能型コネクトベース</p>
					<p class="adress_place_connect_kotoni">琴似</p>
					<p class="foot_jusyo">〒063-0003&nbsp;&nbsp;&nbsp;札幌市西区山の手3条3丁目3-14</p>
				</address>
				<address class="address_connect clearfix">
					<p class="adress_name_connect">継続支援コネクトワークス</p>
					<p class="adress_place_connect">大通東</p>
					<p class="foot_jusyo">〒060-0032&nbsp;&nbsp;&nbsp;札幌市中央区北2条東1丁目2-2 プラチナ札幌ビル 3F</p>
				</address>
				<address class="address_trbiz clearfix">
					<p class="adress_name_trbiz">継続支援コネクトワークス</p>
					<p class="adress_place_trbiz">新さっぽろ</p>
					<p class="foot_jusyo">〒004-0051&nbsp;&nbsp;&nbsp;札幌市厚別区厚別中央1条6丁目2−15 新札幌センタービル 4F</p>
				</address>
				<address class="address_plusta clearfix">
					<p class="adress_name_plusta">継続支援プラスタ</p>
					<p class="adress_place_plusta">西18丁目</p>
					<p class="foot_jusyo">〒060-0061&nbsp;&nbsp;&nbsp;札幌市中央区南1条西18丁目1-2 南1西18ビル 2F</p>
				</address>
				<address class="address_second clearfix">
					<p class="adress_name_second">継続支援セコンド</p>
					<p class="adress_place_second">琴似</p>
					<p class="foot_jusyo">〒063-0003&nbsp;&nbsp;&nbsp;札幌市西区山の手3条1丁目3-25 プリエ琴似2F</p>
				</address>
			</div>
			<ul class="foot_nav for_sp">
				<li>
					<a href="#" data-remodal-target="modal_privacy_policy">プライバシーポリシーについて</a>
				</li>
				<li>
					<a href="#" data-remodal-target="modal_corporation">運営会社について</a>
				</li>
			</ul>
			<span class="copy">&copy; 札幌継続支援センター<br class="for_sp"><span class="for_pc">｜</span>継続支援コネクトワークス | 多機能型コネクトベース<span class="for_pc">｜</span><br class="for_sp">継続支援プラスタ | 継続支援セコンド <br class="for_sp">All Rights
				Reserved.</span>
		</div>
		<a href="#" id="pagetop" class="pagetop">
			<img src="../_common/img/pagetop.png" alt="ページトップへ" class="for_pc">
			<img src="../_common/img/sp/pagetop.png" alt="ページトップへ" class="for_sp">
		</a>
		<!-- /.pagetop -->
	</footer>

	<div class="remodal map" data-remodal-id="modal_map_second" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
						<span></span>
				<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_second_logo.png" alt="継続支援セコンド second" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_second_logo.png" alt="継続支援セコンド second" class="access_logo for_sp">
				</h3>
				<p class="text">
					札幌市西区山の手3条1丁目3-25　<br class="for_sp">プリエ琴似 2F</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2914.4973608034547!2d141.29679431589585!3d43.07303797914556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b2835f4403419%3A0x6e962e42ab11245b!2z5bCx5Yq057aZ57aa5pSv5o-0QuWei-OCu-OCs-ODs-ODiQ!5e0!3m2!1sja!2sjp!4v1506391788790"></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_plusta" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
						<span></span>
				<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_plusta_logo.png" alt="継続支援プラスタ plusta" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_plusta_logo.png" alt="継続支援プラスタ plusta" class="access_logo for_sp">
				</h3>
				<p class="text">
					札幌市中央区南1条西18丁目1-2 <br class="for_sp">南1西18ビル2F</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2915.2983040181266!2d141.32761941589536!3d43.056193279146356!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b2994924a9b1b%3A0x84f8314cf1d7cb6b!2z57aZ57aa5pSv5o-044OX44Op44K544K_!5e0!3m2!1sja!2sjp!4v1506392022850"></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_trbiz" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
					<span></span>
				<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_trbiz_logo.png" alt="継続支援トラビズ trzib" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_trbiz_logo.png" alt="継続支援トラビズ trzib" class="access_logo for_sp">
				</h3>
				<p class="text">札幌市北区北36条西4丁目2-5<br class="for_sp">　第2泊ビル 1F</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d648.8169111174439!2d141.34042266605027!3d43.10263447947956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1z5pyt5bmM5biC5YyX5Yy65YyXMzbmnaHopb805LiB55uuMi0144CA56ysMuaziuODk-ODqyAxRg!5e0!3m2!1sja!2sjp!4v1529890024525" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_connect" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
					<span></span>
					<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_connect_logo.png" alt="継続支援トラビズ trzib" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_connect_logo.png" alt="継続支援トラビズ trzib" class="access_logo for_sp">
				</h3>
				<p class="text">北海道札幌市中央区北2条東1丁目2-2 <br class="for_sp">プラチナ札幌ビル 3F
					</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d612.7820623622714!2d141.3566787949686!3d43.0645884964146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b2976f5348969%3A0xe911505106c9be4e!2z44CSMDYwLTAwMzIg5YyX5rW36YGT5pyt5bmM5biC5Lit5aSu5Yy65YyX77yS5p2h5p2x77yR5LiB55uu77yS4oiS77ySIOODl-ODqeODgeODiuacreW5jOODk-ODqw!5e0!3m2!1sja!2sjp!4v1543210249138" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_connect_tsukisamu" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
					<span></span>
					<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_connect_logo.png" alt="継続支援コネクトワークス月寒 connect works tsukisamu" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_connect_logo.png" alt="継続支援コネクトワークス月寒 connect works tsukisamu"
						class="access_logo for_sp">
				</h3>
				<p class="text">北海道札幌市豊平区月寒中央通5丁目2-20<br class="for_sp">レジデンス月寒中央 1F
				</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2916.4077665245304!2d141.3930849864088!3d43.03285132556738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b2bcb17b37105%3A0xc71c0c3820423292!2z57aZ57aa5pSv5o-044Kz44ON44Kv44OI44Ov44O844Kv44K55pyI5a-SKOWwseWKtOe2mee2mkLlnosp!5e0!3m2!1sja!2sjp!4v1571981369054!5m2!1sja!2sjp" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_connect_kotoni" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
					<span></span>
					<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_connect_base_logo.png" alt="多機能型コネクトベース琴似 connect works kotoni" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_connect_base_logo.png" alt="多機能型コネクトベース琴似 connect works kotoni"
						class="access_logo for_sp">
				</h3>
				<p class="text">北海道札幌市西区山の手3条3丁目3-14
				</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4901.75770049976!2d141.29368989486497!3d43.070825687303355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b29a3720f1707%3A0xbf3b7098fe605b8e!2z5aSa5qmf6IO95Z6L5LqL5qWt5omAIOOCs-ODjeOCr-ODiOODmeODvOOCueeQtOS8vA!5e0!3m2!1sja!2sjp!4v1571980858104!5m2!1sja!2sjp" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
		</div>
	</div>
	<div class="remodal map" data-remodal-id="modal_map_connect_shin-sapporo" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
					<span></span>
					<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">
					<img src="../_common/img/top/access_connect_logo.png" alt="継続支援コネクトワークス新さっぽろ connect works shin-sapporo" class="access_logo for_pc">
					<img src="../_common/img/sp/top/access_connect_logo.png" alt="継続支援コネクトワークス新さっぽろ connect works shin-sapporo"
						 class="access_logo for_sp">
				</h3>
				<p class="text">札幌市厚別区厚別中央1条6丁目2-15  <br class="for_sp">新札幌センタービル 4F
				</p>
			</div>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2916.061981550203!2d141.47336121541665!3d43.040127379147044!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5f0b2d26cf350603%3A0x89200e7e2cc14a72!2z57aZ57aa5pSv5o-044Kz44ON44Kv44OI44Ov44O844Kv44K55paw44GV44Gj44G944KN!5e0!3m2!1sja!2sjp!4v1661248897920!5m2!1sja!2sjp" style="border:0;"></iframe>
		</div>
	</div>
	<div class="remodal" data-remodal-id="modal_corporation" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
						<span></span>
				<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">会社概要</h3>
				<address class="address">
					<p>〒063-0003<br>
						札幌市西区山の手3条3丁目3-14<br>
						株式会社ブリッジメディア<br>
						tel：011-311-1020</p>
					</address>
			</div>
		</div>
	</div>
	<div class="remodal" data-remodal-id="modal_privacy_policy" data-remodal-options="hashTracking:false">
		<div class="modal_area">
			<div data-remodal-action="cancel" class="remodal-cancel">
				<span class="btn_close">
						<span></span>
				<span></span>
				</span>
				閉じる
			</div>
			<div class="moral_wrap">
				<h3 class="title">プライバシーポリシー</h3>
				<h4 class="subtitle">個人情報の定義</h4>
				<p class="text">
					株式会社ブリッジメディア（以下、当社）では、お客様のプライバシーを尊重し、お客様の個人情報を大切に保護することを重要な責務と考えております。当ウェブサイトでは、個人情報保護に関する法令を遵守するとともに、個人情報の取扱に関して次のような姿勢で行動しています。
				</p>
				<h4 class="subtitle">個人情報の利用目的</h4>
				<p class="text">
					「個人情報」とは、個人に関する情報であって、当該情報に含まれる氏名、生年月日その他の記述等により当該個人を識別することができるものをいいます。
				</p>
				<h4 class="subtitle">第三者への提供</h4>
				<p class="text">
					お客様からのご提供いただいた個人情報は、お客様のご了承がない限り、収集した個人情報を第三者に提供いたしません。 利用目的を達成するための必要な範囲で、個人情報を業務委託先から有益と思われる情報のお届けを代行する場合にも、お客様のご承諾がない限り、個人情報はそうした企業／団体には開示･提供はいたしません。ただし、以下の場合は除きます。
				</p>
				<ul class="disc">
					<li>利用目的に必要な限りにおいて、当社または当社の業務委託先（販売加盟店や運送会社等）に対し開示を行う場合</li>
					<li>個人情報をご提供いただく際に予め明示した第三者に提供する場合</li>
					<li>法令に基づく場合</li>
				</ul>
			</div>
		</div>
	</div>
</body>

</html>

<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>完了画面</title>
</head>
<body>
<div align="center">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</body>
</html>
<?php }else{ ?>
送信ありがとうございました。<br />
送信は正常に完了しました。<br /><br />
<a href="<?php echo $site_top ;?>">トップページへ戻る&raquo;</a>
</div>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	if($empty_flag == 1){ ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<script src="js/html5.js" type="text/javascript"></script>
<![endif]-->
<title>継続支援セコンド｜札幌の継続支援B型事業所</title>
<meta name="description" content="札幌市西区にある継続支援セコンドは、各種障がい（精神、発達、身体、知的）のある方が働くパソコン作業がメインの就労継続支援B型事業所です。" />
<meta name="keywords" content="継続支援B型,B型,就労支援,セコンド,second,札幌,障がい者,障害者,就労" />
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="css/slick.css">
<link rel="stylesheet" href="css/slick-theme.css">
<link rel="stylesheet" href="../css/style2.css">
<link rel="stylesheet" href="../css/colorbox.css">
<link rel="shortcut icon" href="../img/favicon.ico">
<!--[if lt IE 9]><link rel="stylesheet" href="css/ie.css" media="screen" /><![endif]-->
<script src="../js/jquery-1.8.1.min.js"></script>
<script src="js/scroll_top.js"></script>
<script src="js/slick.js"></script>
<script src="js/accordion.js"></script>
<script src="../js/placeholder.js"></script>
<script src="../js/jquery.colorbox_ori.js"></script>
<script src="../js/jquery.colorbox-min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="../js/basic.js"></script>
</head>
<body>
	<header>
		<div id="header_area" class="cf">
			<div id="header_l">
				<p class="logo_left"><a href="../"><img src="../img/logo.png" alt="指定障がい福祉サービス継続支援セコンド"></a></p>
				<p class="logo_right">障がいを持つ方が働く、札幌西区にある<br />パソコン作業がメインの就労継続支援B型</p>
			</div>
			<div id="header_r">
				<p class="contact_l"><a href="../inquiry/"><img src="../img/header01.png" alt="お気軽にお問合せくださいお問合せ見学のお申し込み"></a></p>
				<p class="contact_r"><img src="../img/header02.png" alt="平日10時～17時までもちろん電話でも受付できます011-213-9825"></p>
			</div>
		</div>
	</header>

	<section class="future">
		<div id="inquiry_box">
			<div id="title">
				<h1 class="w1200">お問合せ・見学のお申込み(確認画面)</h1>
			</div>
			<div class="w960">
				<div class="form_box">
				<div align="center">
				<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
				<?php echo $errm; ?><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
				</div>
				</div>
			</div><!--w960-->
		</div>
		</div><!--content01-->
	</section>

	<footer>
		<div id="footer_area01" class="cf">
			<div class="w960">
				<div id="f_logo">
					<p>継続支援セコンド</p>
				</div>
				<div id="jusho">
					<p>〒063-0003<br />札幌市西区山の手3条1丁目3-25&nbsp;プリエ琴似&nbsp;2F</p>
				</div>
				<div id="tel">
					<p>TEL：011-213-9825<br />
	FAX：011-215-8438</p>
				</div>
			</div>
		</div>
		<div id="footer_area02" class="cf">
			<div class="w960">
				<ul>
					<li><a class="inline" href=".inline-content02">会社概要</a></li>
					<div style="display: none">
						<section class="inline-content02">
							<p>〒063-0003<br>
								札幌市西区山の手3条3丁目3-14<br>
								株式会社ブリッジメディア<br>
								tel：011-311-1020</p>
						</section>
					</div>
					<li><a class="inline" href=".inline-content">プライバシーポリシー</a></li>
					<div style="display: none">
						<section class="inline-content">
 						    <p><span>個人情報の定義</span><br>
株式会社ブリッジメディア（以下、当社）では、お客様のプライバシーを尊重し、お客様の個人情報を大切に保護することを重要な責務と考えております。当ウェブサイトでは、個人情報保護に関する法令を遵守するとともに、個人情報の取扱に関して次のような姿勢で行動しています。<br><br>
<span>個人情報の利用目的</span><br>
「個人情報」とは、個人に関する情報であって、当該情報に含まれる氏名、生年月日その他の記述等により当該個人を識別することができるものをいいます。<br><br>
<span>第三者への提供</span><br>
お客様からのご提供いただいた個人情報は、お客様のご了承がない限り、収集した個人情報を第三者に提供いたしません。 利用目的を達成するための必要な範囲で、個人情報を業務委託先から有益と思われる情報のお届けを代行する場合にも、お客様のご承諾がない限り、個人情報はそうした企業／団体には開示･提供はいたしません。ただし、以下の場合は除きます。<br><br>
・利用目的に必要な限りにおいて、当社または当社の業務委託先（販売加盟店や運送会社等）に対し開示を行う場合<br>
・個人情報をご提供いただく際に予め明示した第三者に提供する場合<br>
・法令に基づく場合</p>
						</section>
					</div>
				</ul>
				<p>Copyright&nbsp;2014&nbsp;BRIDGE.&nbsp;All&nbsp;Rights&nbsp;Reserved.</p>
			</div>
		</div>
		<div id="page-top">
			<p><a href="#"><img src="../img/top.png" alt="トップへ戻る"></a></p>
		</div>
	</footer>

</body>
</html>
<?php 
	}else{ header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	global $hankaku,$hankaku_array;
	$resArray = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){ 
				//連結項目の処理
				if(is_array($item)){
					if(!empty($key02) && $key02 !== '' && 1 < strlen($key02)){
						$out .= "\n　" . $key02.'　'.connect2val($item);
					}
					else{
						$out .= '　'.$item;
					}
				}else{
					if(!empty($key02) && $key02 !== '' && 1 < strlen($key02)){
						$out .= "\n　" . $key02.'　'.$item;
					}
					else{
						$out .= '　'.$item;
					}
				}
			}
			$out = rtrim($out,'　');
			
		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		
		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		if($out != "confirm_submit" && $key != "httpReferer") {
			$resArray .= "【 ".h($key)." 】\n".h($out)."\n\n";
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr){
	global $hankaku,$hankaku_array;
	$html = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){ 
				//連結項目の処理
				if(is_array($item)){
					if(!empty($key02) && $key02 !== '' && 1 < strlen($key02)){
						$out .= $key02.'　'.connect2val($item) . "\r\n";
					}
					else{
						$out .= $item . '';
					}
				}else{
					if(!empty($key02) && $key02 !== '' && 1 < strlen($key02)){
						$out .= $key02.'　'.$item . "\r\n";
					}
					else{
						$out .= $item . '';
					}
				}
			}
			$out = rtrim($out,"\r\n");
			
		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);
		
		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		
		// 項目名の改行
		$key = str_replace("を","を<br>",$key);
		
		$html .= "<dl class='cf'><dt>".$key."</dt><dd>".$out;
		$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
		$html .= "</dd></dl>\n";
	}
	return $html;
}

//全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array){
	global $encode;
	if(is_array($hankaku_array) && function_exists('mb_convert_kana')){
		foreach($hankaku_array as $hankaku_array_val){
			if($key == $hankaku_array_val){
				$out = mb_convert_kana($out,'a',$encode);
			}
		}
	}
	return $out;
}
//配列連結の処理
function connect2val($arr){
	$out = '';
	foreach($arr as $key => $val){
		if(is_numeric($key) || $val == ''){
			//配列名が未記入（数値）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
			$key = '';
		}elseif(strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)){
			$val = number_format($val);//金額の場合には3桁ごとにカンマを追加
		}
		$out .= $val . "　" . $key;
	}
	return $out;
}

//管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
	$header = '';
	if($userMail == 1 && !empty($post_mail)) {
		$header="From: $post_mail\n";
		if($BccMail != '') {
		  $header.="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$post_mail."\n";
	}else {
		if($BccMail != '') {
		  $header="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$to."\n";
	}
		$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp){
	$adminBody="「".$subject."」からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody.= postToMail($arr);//POSTデータを関数からセット
	$adminBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
	$adminBody.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody.="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	if($confirmDsp != 1){
		$adminBody.="問い合わせのページURL：".@$_SERVER['HTTP_REFERER']."\n";
	}else{
		$adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
	}
	if($mailFooterDsp == 1) $adminBody.= $mailSignature;
//	return mb_convert_encoding($adminBody,"JIS",$encode);

	//会社名の項目があるので(株)(有)などの機種依存文字に対応したい
	return mb_convert_encoding($adminBody,"ISO-2022-JP-ms","UTF-8");
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
	$reheader = "From: ";
	if(!empty($refrom_name)){
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != $encode){
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	}else{
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
	$userBody = '';
	if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody.= $remail_text;
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.= postToMail($arr);//POSTデータを関数からセット
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	if($mailFooterDsp == 1) $userBody.= $mailSignature;
//	return mb_convert_encoding($userBody,"JIS",$encode);

	if(isset($arr[$dsp_name])){
		$userBody = str_replace("##NAME##", h($arr[$dsp_name]), $userBody);
	}
	else{
		$userBody = str_replace("##NAME##", "", $userBody);
	}

	
	//会社名の項目があるので(株)(有)などの機種依存文字に対応したい
	return mb_convert_encoding($userBody,"ISO-2022-JP-ms","UTF-8");

}
//必須チェック関数
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal) {
				
				//連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}
						
					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				//デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
					$res['empty_flag'] = 1;
				}
				
				$existsFalg = 1;
				break;
			}
			
		}
		if($existsFalg != 1){
				$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}
	
	return $res;
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright(){
	echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>
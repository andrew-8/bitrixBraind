# bitrixBraind

<h4>Задание 1</h4>
<p>Подключается компонент в любом шаблоне компонента на публичной странице сайта</p>
<div class="highlight highlight-text-html-php">
<pre>
$APPLICATION->IncludeComponent(
	"svet:exchange.rates", 
	"",
	array(),
	false
);
</pre>
</div>
<p>Файлы задания 1:<br>
local/components/</p>


<h4>Задание 2</h4>
<p>В файле <strong>events.php</strong> 2 обработчика события. Подключается файл <strong>events.php</strong> в файл <strong>init.php</strong>. Файл <strong>init.php</strong> может содержать в себе инициализацию обработчиков событий</p>
<ol>
<li>
Функция <strong>addValuesToPropsByOrder</strong> обрабатывается с событием <strong>OnOrderNewSendEmail</strong>, событие происходит после оформления нового заказа до отправки письма получателю. До оформлении заказа в административной панеле в разделе Магазин -> Складской учет создается Склад, где вводится адрес самовывоза, далее Настроики -> Службы доставки создается Самовывоз и привязывается созданный склад для вывода и выбора при оформлении заказа. Обязательено в Cвоиствах Заказа создается свойство c кодом ADDRESS_PICKUP (обязательно, иначе адрес не будет выводится в заказах в административной панеле). Затем после оформления заказа обрабатывается событие, где берется адрес с текущего заказа Отгрузка, а это выбранный Самовывоз (привязанный склад) и сохраняется в текущем заказе в Адрес самовывоза покупателя   
и до отправки письма добавлется адрес в письмо получателя</li>
<li>Функция <strong>changePropsUserByOrder</strong> обрабатывается с событием <strong>OnSaleStatusOrderChange</strong>, событие происходит после смены статуза заказа. После смены статуса заказа на Выполнен данные покупателя, а именно пользователя обновляется (то есть стирается) Почтовый адрес в вкладке Личнные данные в административной панеле</li></ol>
<p>Файлы задания 2:<br>
bitrix/php_interface/include/events.php<br>
bitrix/php_interface/init.php</p>

<h4>Задание 3</h4>
<p>Класс <strong>Helper</strong> (файл helper.php) расположен в папке local/classes/. В классе 2 статических методов:<br>
Первый метод <strong>getDeclNum</strong> - обрабатывает обязательные 2 параметра (число, массив склонений слов). Выводит число с правильным склонением влово;<br>
Второй метод <strong>showVarWithHTML</strong> - обрабатывает 2 параметра, 1 обязательный - это строка, 2 необязательный ввод тега. Выводит строку обернутым правильным тегом. В методе проверяется тег с помощью класса <strong>HTML5DOMDocument</strong>. Для использования этого класса устанавлвивается через запуск composer, устанавливается в папку local</p>
<div class="highlight highlight-text-html-php"><pre>
composer require ivopetkov/html5-dom-document-php:2.*
</pre></div>
<p>Для использования класса Helper используется статисческий метод <strong>registerAutoLoadClasses</strong>, который срабатывает в <strong>init.php</strong> Класс можно использовать в любом файле bitrix</p>
<p>Пример вывода класса с методами:</p>
<div class="highlight highlight-text-html-php">
<pre>
use Svet\Classes\Helper;
echo Helper::getDeclNum(7, ['штука', 'штуки', 'штук']);
echo Helper::showVarWithHTML('Заголовок текста', 'h2');
</pre>
</div>

<p>Файлы задания 3:<br>
bitrix/php_interface/init.php<br>
local/classes/<br>
local/vendor/</p>
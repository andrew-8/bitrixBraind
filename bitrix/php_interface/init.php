<?
use Bitrix\Main\Loader;

/**
 * Регистрация класс для автозагрузок
 */
Loader::registerAutoLoadClasses(null, array(
    '\Svet\Classes\Helper' => '/local/classes/helper.php',
    '\IvoPetkov\HTML5DOMDocument' => '/local/vendor/autoload.php',
));


/**
 * Подключения файла с обработчиками события
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/events.php"))
    require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/events.php");

?>


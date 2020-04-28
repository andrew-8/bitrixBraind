<?php
namespace Svet\Classes;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use IvoPetkov\HTML5DOMDocument;

/**
 * Class Helper
 * @package Svet\Classes
 */
class Helper
{
    /**
     * Выводит число с склонением слово
     * @param $n
     * @param $strDecl
     * @return string
     */
    public static function getDeclNum($n, $strDecl){
        try {
            if (is_string($n)) {
                throw new SystemException(Loc::getMessage("HELPER_ERROR_DECL_PRMS_1"));
            }
            if (!is_array($strDecl)) {
                throw new SystemException(Loc::getMessage("HELPER_ERROR_DECL_PRMS_2"));
            }
            $n = trim($n);
            $n = (int)$n % 100;
            $n1 = $n % 10;
            $resN = $n . " ";
            if ($n > 10 && $n < 20) {
                return $resN . $strDecl[2]; }

            if ($n1 > 1 && $n1 < 5) {
                return $resN . $strDecl[1];
            }
            if ($n1 == 1) {
                return $resN . $strDecl[0];
            }
            return $resN . $strDecl[2];
        }
        catch (SystemException $exception)
        {
            echo $exception->getMessage();
        }

    }

    /**
     * Выводит строку с обертыванием тега
     * @param $str
     * @param bool $tag
     * @return string|void
     */
    public static function showVarWithHTML($str, $tag = false){
        try {
            if (is_int($str)) {
                throw new SystemException(Loc::getMessage("HELPER_ERROR_VAR_PRMS_1"));
            }
            if ((!empty($tag) && ($tag !== false)) && !preg_match("/\<(.*?)\>/", $tag)) {
                $tag = "<" . $tag . ">";
            }

            libxml_use_internal_errors(true);
            $htmlDoc = "<!DOCTYPE html><html><body>".$tag."</body></html>";
            $dom = new HTML5DOMDocument();
            $dom->loadHTML($htmlDoc);
            if (!empty(libxml_get_errors())) {
                throw new SystemException(Loc::getMessage("HELPER_ERROR_VAR_NOT_TEG"));
            }

            $cTag = str_replace('<', '</', $tag);
            $str = trim(strip_tags($str));
            $htmlString = $tag . $str . $cTag;
            return $htmlString;
        }
        catch (SystemException $exception)
        {
            echo $exception->getMessage();
        }
    }
}
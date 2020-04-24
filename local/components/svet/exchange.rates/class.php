<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class CExhangeRates extends CBitrixComponent
{
    /**
     * Получение определенных курс валют
     * @param bool $getCode
     * @param $arParams
     * @param $arResult
     * @return array
     */
    static function getCurr($getCode, $arParams = false, $arResult = false){
        global $APPLICATION;
        $obHttp = new CHTTP();
        $obHttp->Query(
            'GET',
            'www.cbr.ru',
            80,
            "/scripts/XML_daily.asp".(isset($arResult["RATE_DAY_TIMESTAMP"])? "?date_req=".date("d/m/Y", $arResult["RATE_DAY_TIMESTAMP"]):""),
            false,
            '',
            'N'
        );
        $strQueryText = $obHttp->result;
        if (empty($strQueryText))
            $bWarning = true;

        if (!$bWarning) {

            if (SITE_CHARSET != "windows-1251")
                $strQueryText = $APPLICATION->ConvertCharset($strQueryText, "windows-1251", SITE_CHARSET);

            require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/classes/general/xml.php");

            $strQueryText = preg_replace("#<!DOCTYPE[^>]+?>#i", "", $strQueryText);
            $strQueryText = preg_replace("#<" . "\\?XML[^>]+?\\?" . ">#i", "", $strQueryText);

            $objXML = new CDataXML();
            $objXML->LoadString($strQueryText);
            $arData = $objXML->GetArray();

            if (!empty($arData) && is_array($arData)) {
                if (!empty($arData["ValCurs"]) && is_array($arData["ValCurs"])) {
                    if (!empty($arData["ValCurs"]["#"]) && is_array($arData["ValCurs"]["#"])) {
                        if (!empty($arData["ValCurs"]["#"]["Valute"]) && is_array($arData["ValCurs"]["#"]["Valute"])) {
                            $arCBVal = $arData["ValCurs"]["#"]["Valute"];
                            $arCurr = array();
                            if ($getCode) {
                                foreach ($arCBVal as &$arOneCBVal) {
                                    $arCurr[$arOneCBVal["#"]["CharCode"][0]["#"]] = $arOneCBVal["#"]["Name"][0]["#"];
                                }
                                return $arCurr;
                            } else {
                                foreach ($arCBVal as &$arOneCBVal) {

                                    if (in_array($arOneCBVal["#"]["CharCode"][0]["#"], $arParams["ARR_CURR_RATES"]))
                                    {
                                        $arCurrCBRF[] = array(
                                            "CURRENCY" => $arOneCBVal["#"]["Name"][0]["#"],
                                            "VALUE" => doubleval(str_replace(",", ".", $arOneCBVal["#"]["Value"][0]["#"])),
                                        );
                                    }
                                }
                                return $arCurrCBRF;
                            }
                        }
                    }
                }
            }
        }
    }
}
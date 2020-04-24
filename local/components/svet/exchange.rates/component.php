<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
$cache = Bitrix\Main\Data\Cache::createInstance();
Loc::loadMessages(__FILE__);

if (!isset($arParams["CACHE_TIME"]))
    $arParams["CACHE_TIME"] = 86400;
$arParams["CACHE_TIME"] = intval($arParams["CACHE_TIME"]);

$arParams['CURR_RATE_DAY'] = trim($arParams['CURR_RATE_DAY']);

$arParams['SHOW_CURR_CB'] = ('Y' == $arParams['SHOW_CURR_CB'] ? 'Y' : 'N');

if ($arParams['SHOW_CURR_CB'] == 'N'){
    ShowMessage(Loc::getMessage('MSG_SHOW_EXCHANGE_RATES'));
    return;
}

if ($cache->startDataCache()) {

    if ('' == $arParams["CURR_RATE_DAY"])
    {
        $arResult["RATE_DAY_TIMESTAMP"] = time();
        $arResult["RATE_DAY_SHOW"] = ConvertTimeStamp($arResult["RATE_DAY_TIMESTAMP"], 'SHORT');
    }
    else
    {
        $arRATE_DAY_PARSED = ParseDateTime($arParams["CURR_RATE_DAY"], "DD-MM-YYYY");
        $arRATE_DAY_PARSED['YYYY'] = intval($arRATE_DAY_PARSED['YYYY']);
        if (1901 > $arRATE_DAY_PARSED["YYYY"] || 2038 < $arRATE_DAY_PARSED["YYYY"])
        {
            $arResult["RATE_DAY_TIMESTAMP"] = time();
            $arResult["RATE_DAY_SHOW"] = ConvertTimeStamp($arResult["RATE_DAY_TIMESTAMP"], 'SHORT');
        }
        else
        {
            $arResult["RATE_DAY_TIMESTAMP"] = mktime(0, 0, 0, $arRATE_DAY_PARSED["MM"], $arRATE_DAY_PARSED["DD"], $arRATE_DAY_PARSED["YYYY"]);
            $arResult["RATE_DAY_SHOW"] = ConvertTimeStamp($arResult["RATE_DAY_TIMESTAMP"], 'SHORT');
        }
    }

    if (!empty($arParams["ARR_CURR_RATES"])) {
        if (!$this->getCurr(false, $arParams, $arResult)) {
            $cache->abortDataCache();
            ShowError(Loc::getMessage('ERROR_EXCHANGE_RATES'));
            return;
        }
        $arResult['EXCHANGE_RATES'] = $this->getCurr(false, $arParams, $arResult);
    }
    $cache->endDataCache($arResult['EXCHANGE_RATES']);
    $this->IncludeComponentTemplate();
}
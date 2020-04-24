<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$curr = CBitrixComponent::includeComponentClass("svet:exchange.rates");

$arComponentParameters = array(
    "PARAMETERS" => array(
        "ARR_CURR_RATES" => array(
            "NAME" => GetMessage("EXCHANGE_FROM"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "ADDITIONAL_VALUES" => "N",
            "VALUES" => $curr::getCurr(true),
            "GROUP" => "BASE",
        ),
        "CURR_RATE_DAY" => array(
            "NAME" => GetMessage("EXCHANGE_RATE_DAY"),
            "TYPE" => "STRING",
            "GROUP" => "ADDITIONAL_PARAMETERS",
        ),
        "SHOW_CURR_CB" => array(
            "NAME" => GetMessage("SHOW_EXCHANGE_CBRF"),
            "TYPE" => "CHECKBOX",
            "MULTIPLE" => "N",
            "DEFAULT" => "Y",
            "ADDITIONAL_VALUES" => "N",
            "GROUP" => "ADDITIONAL_PARAMETERS",
        ),
        "CACHE_TIME" => array("DEFAULT" => "86400"),
    ),
);
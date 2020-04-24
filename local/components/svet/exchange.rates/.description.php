<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

$arComponentDescription = array(
    "NAME"			=> GetMessage("EXCHANGE_SHOW_RATES_COMPONENT_NAME"),
    "DESCRIPTION"	=> GetMessage("EXCHANGE_SHOW_RATES_COMPONENT_DESCRIPTION"),
    "ICON" => "/images/currency_rates.gif",
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "EXCHANGE",
            "NAME" => GetMessage("EXCHANGE_GROUP_NAME"),
        ),
    ),
);
?>
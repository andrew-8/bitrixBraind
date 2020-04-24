<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<table class="currency-list">
    <?if (is_array($arResult['EXCHANGE_RATES']) && $arParams["SHOW_CURR_CB"] == "Y"):?>
        <tr>
            <td colspan="3"><b><?=GetMessage("CURRENCY_CBRF")?></b></td>
        </tr>
        <?foreach ($arResult['EXCHANGE_RATES'] as $arCurrency):?>
            <tr>
                <td><?=$arCurrency["CURRENCY"]?></td>
                <td>=</td>
                <td><?=$arCurrency["VALUE"]?></td>
            </tr>
        <?endforeach?>
    <?endif?>
</table>
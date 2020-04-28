<?php
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('sale', "OnOrderNewSendEmail", ['SaleHandler', 'addValuesToPropsByOrder']);
$eventManager->addEventHandler('sale', "OnSaleStatusOrderChange", ['SaleHandler', 'changePropsUserByOrder']);


class SaleHandler {
    /**
     * Добавление адреса самовывоза в письмо и в адрес получателя заказа
     * @param $ID
     * @param $eventName
     * @param $arFields
     * @return \Bitrix\Main\EventResult
     * @throws Exception
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    function addValuesToPropsByOrder($ID, &$eventName, &$arFields)
    {
        $order = \Bitrix\Sale\Order::load($ID);

        /** Сохранения адреса в Адрес доставки получателя заказа */
        $arStore = [];
        $order = \Bitrix\Sale\Order::load($ID);
        $shipments = $order->getShipmentCollection();
        foreach ($shipments as $shipment) {
            if (!$shipment->isSystem()) {
                $storeId = $shipment->getStoreId();
                if ($storeId > 0) {
                    $dbList = \CCatalogStore::GetList(
                        array("ID" => "DESC"),
                        array("ID" => $storeId),
                        false,
                        false,
                        array("ID", "ADDRESS", "DESCRIPTION")
                    );
                    if ($store = $dbList->Fetch()) {
                        $arStore = $store;
                    }
                }
            }
        }
        $property = $order->getPropertyCollection();
        foreach ($property as $prop) {
            if ($prop->getField('CODE') == 'ADDRESS_PICKUP') {
                $prop->setField('VALUE', $arStore['ADDRESS']);
                $order->save();
            }
        }

        /** Добавление адреса в письмо */
        $arFields["PICKUP_ADDRESS"] = $arStore['ADDRESS'];

        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS
        );
    }


    /**
     * Очистка значений из определенных своиств пользователя
     * @param $event
     * @return \Bitrix\Main\EventResult
     */
    function changePropsUserByOrder($event)
    {
        $parameters = $event->getParameters();

        if ($parameters['VALUE'] === 'F')
        {
            /** @var \Bitrix\Sale\Order $order */
            $order = $parameters['ENTITY'];
            $user = new CUser;
            $fields = Array(
                'PERSONAL_COUNTRY' => '',
                'PERSONAL_CITY' => '',
                'PERSONAL_STATE' => '',
                'PERSONAL_ZIP' => '',
                'PERSONAL_STREET' => '',
                'PERSONAL_MAILBOX' => '',
                'PERSONAL_NOTES' => '',
            );
            $user->Update($order->getUserId(), $fields);
        }

        return new \Bitrix\Main\EventResult(
            \Bitrix\Main\EventResult::SUCCESS
        );
    }

}

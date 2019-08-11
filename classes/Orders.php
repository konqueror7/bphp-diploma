<?php

/**
 * Класс для работы с записями заказов
 */
class Orders extends JsonDataArray
{

    /**
     * Извлечение записи о заказе по ее ID
     * @param  string $orderNumber - номер заказа
     * @return object извлеченный объект записи заказа
     */
    public function getOrder($orderNumber)
    {
        $resultQuery = $this->newQuery()->byGuid($orderNumber)->getObjs(true);
        return $resultQuery[$orderNumber];
    }

    /**
     * Замена в интерфейсе редактора заказа аббревиатур на полные назвния
     * @param  string $langAbbreviation - аббревиатура
     * @return string $expLangAbbr - полное название
     */
    public static function expandLangAbbreviation($langAbbreviation)
    {
        switch ($langAbbreviation) {
            case 'ru':
                $expLangAbbr = 'Русский';
                break;
            case 'eng':
                $expLangAbbr = 'Английский';
                break;
            case 'it':
                $expLangAbbr = 'Итальянский';
                break;
            case 'de':
                $expLangAbbr = 'Немецкий';
                break;
            case 'fr':
                $expLangAbbr = 'Французский';
                break;
            case 'esp':
                $expLangAbbr = 'Испанский';
                break;
        }
        return $expLangAbbr;
    }
}

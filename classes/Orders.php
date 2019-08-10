<?php

class Orders extends JsonDataArray
{
    public function getOrder($orderNumber)
    {
        $resultQuery = $this->newQuery()->byGuid($orderNumber)->getObjs(true);
        return $resultQuery[$orderNumber];
    }

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

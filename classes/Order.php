<?php

/**
 * Создает объект класса Order
 * для записи в массив DataArray
 */
class Order extends DataRecordModel
{
    public $executor;
    public $client;
    public $deadline;
    public $state;
    public $origiLanguage;
    public $translations;

    /**
     * Конструктор извлекает значения
     * для записи в свойства объекта Order
     * из данных формы редактирования заказа
     */
    public function addOrderFromForm()
    {
        $this->executor = strval($_POST['executor']);
        $this->client = strval($_POST['client']);
        $this->deadline = strval($this->stringToTime($_POST['deadline']));
        $this->state = $_POST['state'] ?? 'new';
        $this->origiLanguage = (object) array($_POST['origilanguage'] => $_POST['origilanguage-text']);
        $this->translations = (object) $this->addTransLang();
    }

    /**
     * преобразует дату из строкового формата
     * во временную метку Unix
     * @param  string $stringDate дата вида дд/мм/гггг
     * @return string значение в секундах
     */
    public function stringToTime($stringDate)
    {
        $date = DateTime::createFromFormat('d/m/Y', $stringDate);
        return $date->getTimestamp();
    }

    /**
     * индексный массив аббревиатур языков на который надо сделать перевод текста
     */
    public function addTransLang()
    {
        $retObj = [];
        foreach ($_POST['translations'] as $abbr) {
            $retObj[$abbr] = '';
        }
        foreach ($_POST as $key => $value) {
            if (array_key_exists($key, $retObj)) {
                $retObj[$key] = $value;
            }
        }

        return $retObj;
    }
}

<?php

class JsonFileAccessModel extends FileAccessModel
{
    /**
     * чтение текста из json-файла и преобразование в json-объект
     * @return object Возвращает json-объект
     */
    public function readJson()
    {
        $jsonFileContent = json_decode($this->read());
        return $jsonFileContent;
    }

    /**
     * Запись из json-объекта в json-файл
     */
    public function writeJson($jsonArray)
    {
        $this->write(json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

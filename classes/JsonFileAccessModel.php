<?php

class JsonFileAccessModel extends FileAccessModel
{
    //Чтение json-файла
    public function readJson()
    {
        $jsonFileContent = json_decode($this->read());
        return $jsonFileContent;
    }

    //Запись в json-файл
    public function writeJson($jsonArray)
    {
        $this->write(json_encode($jsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

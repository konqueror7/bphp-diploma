<?php

class FileAccessModel
{
    protected $fileName;

    protected $file;

    public function __construct($jsonFileName)
    {
        $this->fileName = Config::DATABASE_PATH.$jsonFileName.'.json';
        //Присвоение свойству $this->fileName полного имени json-файла с информацией о пользователях
        // $this->fileName = $jsonFileName;
    }

    //Открытие json-файла в указанном режиме
    private function connect($modeConnect)
    {
        $this->file = fopen($this->fileName, $modeConnect);
    }

    //Закрытие файла
    private function disconnect()
    {
        fclose($this->file);
    }

    //Чтение файла
    public function read()
    {
        $this->connect('r');
        $filecontent = fread($this->file, filesize($this->fileName));
        $this->disconnect();
        return $filecontent;
    }

    //Запись в файл
    public function write($textContent)
    {
        $this->connect('w');
        fwrite($this->file, $textContent);
        $this->disconnect();
    }
}

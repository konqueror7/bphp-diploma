<?php

class Order extends DataRecordModel
{
    public $executor;
    public $client;
    public $deadline;
    public $state;
    public $origiLanguage;
    public $translations;

    public function addOrderFromForm()
    {
        $this->executor = strval($_POST['executor']);
        $this->client = strval($_POST['client']);
        $this->deadline = strval($this->stringToTime($_POST['deadline']));
        $this->state = $_POST['state'] ?? 'new';
        $this->origiLanguage = (object) array($_POST['origilanguage'] => $_POST['origilanguage-text']);
        $this->translations = (object) $this->addTransLang();
    }

    public function stringToTime($stringDate)
    {
        $date = DateTime::createFromFormat('d/m/Y', $stringDate);
        return $date->getTimestamp();
    }

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

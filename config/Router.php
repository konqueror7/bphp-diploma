<?php
class Router
{
    public $availableLinks;

    public function __construct($availableLinks)
    {
        $this->availableLinks = $availableLinks;
    }

    public function isAvailablePage()
    {
        if (is_int(array_search($_GET['order'], $this->availableLinks))) {
            return true;
        } else {
            throw new Exception("Error Processing Request. This page does not exist on the site.");
        }
    }
}

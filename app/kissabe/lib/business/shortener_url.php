<?php

require_once("shortener.php");

class shortener_url extends shortener
{
    function prepare()
    {
        $this->tbl->url = $this->content; 
        return true;
    }

    function validate()
    {
        return true;
    }
}

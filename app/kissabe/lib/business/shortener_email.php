<?php

require_once("shortener.php");

class shortener_email extends shortener
{
    function prepare()
    {
        $this->content = "mailto:".trim(str_replace("mailto:", "", $this->content));
        $this->tbl->url = $this->content;
        
        return true;
    }

    function validate()
    {
        // Todo Validate
        
        return true;
    }

}

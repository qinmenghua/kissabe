<?php

require_once("shortener.php");

class shortener_text extends shortener
{
    function prepare()
    {
        $file_extension = $this->file_extension();

        //TODO: Add Html, Header & Meta (encoding utf-8) Tags
        $filename = md5($this->content);
        $path = sprintf("%s/texts/%s%s", upload_root, $filename, $file_extension);
        $uri = sprintf("%s/texts/%s%s", upload_url, $filename, $file_extension);

        if (!file_exists($path)) {
            $fp = fopen($path, "w+");
            fwrite($fp, $this->content);
            fclose($fp);
        }

        $this->tbl->url = $uri;
        return true;
    }

    function validate()
    {
        $this->content_type = (self::is_html($this->content)) ? "text/html" : "text/plain";

        return true;
    } 
}

?>

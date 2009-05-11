<?php

require_library("/business/shortener_url.php");
require_library("/business/shortener_email.php");
require_library("/business/shortener_text.php");
require_library("/business/shortener_image.php");

class shortener_factory
{
    static function fixed_type($type, $content)
    {
        switch ($type)
        {
            case shortener::URL:
                if (shortener::is_email($content)) return shortener::EMAIL;
                else if (shortener::is_url($content)) return $type;
                else return shortener::TEXT;
            case shortener::EMAIL:
                if (shortener::is_url($content)) return shortener::URL;
                else if (shortener::is_email($content)) return $type;
                else return shortener::TEXT;
            case shortener::TEXT:
                return $type;
            case shortener::IMAGE:
                if (file_exists($content) || shortener::is_url($content)) return $type;
                else if (shortener::is_email($content)) return shortener::EMAIL;
                else return shortener::TEXT;
            default:
                throw new Exception("Type Not Found");
        }
    }
    static function from_type($type, $content, $data_object=null)
    {
        $type = self::fixed_type($type, $content);
        switch ($type)
        {
            case shortener::URL:
                return new shortener_url($data_object, $type, $content);
            case shortener::EMAIL:
                return new shortener_email($data_object, $type, $content);
            case shortener::TEXT:
                return new shortener_text($data_object, $type, $content);
            case shortener::IMAGE:
                return new shortener_image($data_object, $type, $content);
            default:
                throw new Exception("Type Not Found");
        }
    }

    static function from_code($code)
    {
        $url_id = base62::decode($code);
        $url = Doctrine::getTable("url");
        $tbl_user = $url->find($url_id);
        
        if ($tbl_user == null) {
             throw new Exception("Code Not Found");
        }

        return self::from_type($tbl_user->type, $tbl_user->url, $tbl_user);
    }
}

?>

<?php

$rule[] = array("alias" => "^/home/",
                "file" => "shortener.php",
                "class" => "ShortenerPage",
                "method" => "index");

$rule[] = array("alias" => "^/shortener/",
                "file" => "shortener.php",
                "class" => "ShortenerPage"
               );

$rule[] = array("alias" => "^/api/",
                "file" => "api.php",
                "class" => "APIPage"
               );

$rule[] = array("alias" => "^/site/",
                "file" => "site.php",
                "class" => "SitePage"
               );

$rule[] = array("alias" => "^/(.*)/",
                "request" => array("code"),
                "file" => "shortener.php",
                "class" => "ShortenerPage",
                "method" => "get"
               );


?>

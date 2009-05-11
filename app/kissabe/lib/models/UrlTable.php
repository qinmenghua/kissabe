<?php
/**
 */
class UrlTable extends Doctrine_Table
{
    function get_by_url($url) 
    {
        $q = new Doctrine_Query();
        $data = $q->from("Url u")->where("u.url = ? and status='live'", $url)->execute();

        return $data[0];
    }


    function exist_by_url($url) 
    {
        $q = new Doctrine_Query();
        $data = $q->select("count(*) as total")->
                    from("Url u")->where("u.url = ? and status='live'", $url)->execute();

        return (bool)((int)$data[0]["total"] > 0);
    }

    function pageview($url_id)
    {
        $q = new Doctrine_Query();
        $data = $q->select("count(v.created_by) as total")->
                    from("Visitor v")->where("v.url_id = ?", $url_id)->execute();

        return $data[0]["total"];
    }

    function uniq_pageview($url_id)
    {
        $q = new Doctrine_Query();
        $data = $q->select("count(distinct v.created_by) as total")->
                    from("Visitor v")->where("v.url_id = ?", $url_id)->execute();

        return $data[0]["total"];
    }

}

<?php

require_library("/controller.php");
require_library("/vendor/doctrine/Doctrine.php");

class BasePage extends controller
{
	public $mail;
	public $translation;

	function __construct($master_view="n/a")
	{
		parent::__construct($master_view);
        $this->model_boostrap();

        $this->db->url = Doctrine::getTable("url");
        $this->db->visitor = Doctrine::getTable("visitor");
        $this->db->user = Doctrine::getTable("user");
        $this->db->ownership = Doctrine::getTable("ownership");
        $this->db->statistic = Doctrine::getTable("statistic");

		//Mailer Helper
        $this->url = controller::full_url();
	}

    function model_boostrap()
    {
        require_library("/vendor/doctrine/Doctrine.php");

        spl_autoload_register(array('doctrine', 'autoload'));
        $conn = Doctrine_Manager::connection(dsn);
        $conn->setCollate('utf8_general_ci');
        $conn->setCharset('utf8');

        $conn->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $conn->setAttribute(Doctrine::ATTR_AUTOLOAD_TABLE_CLASSES, true);

        $servers = array(
            'host' => 'localhost',
            'port' => 11211,
            'persistent' => true
        );
        $cacheDriver = new Doctrine_Cache_Memcache(array(
                'servers' => $servers,
                'compression' => false
            )
        );

        $conn->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver); 

        Doctrine::loadModels(library_root.'/models/dal');
        Doctrine::loadModels(library_root.'/models');
    }

	function show_message($message, $back_url="")
	{ 
		$data["back_url"] = empty($back_url) ? $_SERVER["HTTP_REFERER"] : $back_url;
		$data["message"] = $message;
		$this->view->bind("master/message.action", $data);
		die();
	}

	static function remote_address()
	{
        // Get some server/environment variables values
        if (empty($REMOTE_ADDR)) {
            if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) {
                $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
            }
            else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])) {
                $REMOTE_ADDR = $_ENV['REMOTE_ADDR'];
            }
            else if (@getenv('REMOTE_ADDR')) {
                $REMOTE_ADDR = getenv('REMOTE_ADDR');
            }
        } // end if
        if (empty($HTTP_X_FORWARDED_FOR)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])) {
                $HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR'];
            }
            else if (@getenv('HTTP_X_FORWARDED_FOR')) {
                $HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR');
            }
        } // end if
        if (empty($HTTP_X_FORWARDED)) {
            if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])) {
                $HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED'];
            }
            else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])) {
                $HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED'];
            }
            else if (@getenv('HTTP_X_FORWARDED')) {
                $HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED');
            }
        } // end if


        $proxy_ip     = '';
        if (!empty($HTTP_X_FORWARDED_FOR)) {
            $proxy_ip = $HTTP_X_FORWARDED_FOR;
        } else if (!empty($HTTP_X_FORWARDED)) {
            $proxy_ip = $HTTP_X_FORWARDED;
        } else if (!empty($HTTP_FORWARDED_FOR)) {
            $proxy_ip = $HTTP_FORWARDED_FOR;
        } else if (!empty($HTTP_FORWARDED)) {
            $proxy_ip = $HTTP_FORWARDED;
        } else if (!empty($HTTP_VIA)) {
            $proxy_ip = $HTTP_VIA;
        } else if (!empty($HTTP_X_COMING_FROM)) {
            $proxy_ip = $HTTP_X_COMING_FROM;
        } else if (!empty($HTTP_COMING_FROM)) {
            $proxy_ip = $HTTP_COMING_FROM;
        } // end if... else if...
        
        return (($proxy_ip == '') ? $REMOTE_ADDR : $proxy_ip);
       
	
	}

}

?>

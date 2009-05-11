<?php

/* (C) 2009 Netology Joy Web Framework v.0.2, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, 
 * please view the LICENSE file that was distributed 
 * with this source code.
 */


require_library("/model.php");
require_library("/view.php");
require_library("/attribute.php");

class Controller
{
	public $db;
	public $view;
	public $master_view;
	protected $message;
	public $arguments;

	function __construct($master_view="n/a")
	{
		$this->arguments = array();
        Attribute::Loader(array(attribute_root, global_attribute_root));

		if ($master_view == "n/a") {
			$this->view = new view($this->master_view);
		}
		else {
			$this->view = new view($master_view);
		}		
	}

	function authentication($roles)
	{
		// override this!
	}

	function add_message($msg, $is_error=0, $owner="message")
	{
		$this->message .= sprintf("<span id='%s'>%s</span><br/>", 
				$is_error ? "error_message" : "info_message", $msg);

		$this->view->assign($owner, $this->message);
	}

	function assign($key, $val)
	{
		$this->arguments[$key] = $val;
	}

    function get_url()
    {
        $ignore = str_replace("/index.php", "", $_SERVER["PHP_SELF"]);
        $path = str_replace($ignore, "", $_SERVER["REQUEST_URI"]);
        $path = str_replace("?{$_SERVER["QUERY_STRING"]}", "", $path);

        return rtrim($path, "/")."/";
    }

    static function magic_quotes_gpc_off()
    {
        //TODO: Use stripslashes function for GET, POST, COOKIE
    }

	static function page_load()
	{
        self::magic_quotes_gpc_off();
		session_start();

        global $rule;
        $uri = self::get_url();
        if ("/" == trim($uri)) $uri .= home_page."/";
        foreach ($rule as $r) 
        {
            $filter = str_replace("{*}", "(.*)", $r["alias"]);
            $filter = str_replace("/", "\/", $filter);

            if (eregi($filter, $uri)) {
                preg_match("/^$filter/U", $uri, $matches);
                $uri =str_replace($matches[0], "", $uri);
                array_shift($matches);

                $page_args = array();
                for ($i=0; $i < count($matches); $i++) 
                {
                    $param = $r["request"][$i];

                    if (empty($param)) { $param = "param_$i"; }
                    $page_args[$param] = $matches[$i];
                }

                $class_name = $r["class"];
                $class_path = controller_root."/".$r["file"];

	            $items = trim($uri, "/");
                $items = split("/", $items);

                if ($r["method"]) {
                    $method = $r["method"];
                }
                else if (count($items) && !($method = array_shift($items))) {
                    $method = "index";
                }

		        $method_arguments = $items;
                break;
            }
        }

		if (!file_exists($class_path)) {
			die("Page Not Found");
		}
		else {
			require_once($class_path);
		}

		if(!method_exists($class_name, $method)) {
			die("Action Not Found");
		} 
		else {
			self::set_module_name($class_name);
			self::set_action_name($method);

			eval("\$class = new $class_name();");

            $class->page_parameters = (array)$page_args;

            $reflection = new ReflectionAnnotatedClass($class);
            $r = $reflection->getMethod($method);


            // Attribute Page'e parametre olarak aldığı sınıfın instanceof ile kontrol eder. 
            // Ornegin View Interface'inden implement edilmis ise View Layout bilgilerini alir gibi.

            $attributes = $r->getAnnotations();
            foreach ($attributes as $attr) {
                $attr->Run(&$class);
            }

#            $output = array();
#            $method_arguments = array($method_arguments, &$output);
			call_user_method_array($method, $class, $method_arguments);

// TODO:
//           if ($class instanceof IView) {
//               $class->view->items = array_merge($output, $class->view->items);
//           }

//            if ($class->is_serialize) {
//                $class->serialize();
//            }
//            else {
//                $class->render();
//            }
//            var_dump($output);
		}
	}

	static function execute($module, $method, $arguments)
	{
        //FIXME: Burası tek bir merkezden kontrol edilmeli.
        global $rule;

        foreach ($rule as $r) {
            if (eregi($r["class"], $module)) {
                $class_path = controller_root."/".$r["file"];
                $class_name = $r["class"];
                break;
            }
        }

		if (!file_exists($class_path)) {
			die("Page Not Found");
		}
		else {
			require_once($class_path);
		}

		if(!method_exists($module, $method)) {
			die("Action Not Found");
		} 
		else {
			eval("\$object = new $module();");
			call_user_method_array($method, $object, $arguments);
		}
	}

	static function set_module_name($module_name)
	{
		$_SESSION["active_module_name"] = $module_name;
	}

	static function set_action_name($action_name)
	{
		$_SESSION["active_action_name"] = $action_name;
	}

	static function get_module_name()
	{
		return $_SESSION["active_module_name"];
	}

	static function get_action_name()
	{
		return $_SESSION["active_action_name"];
	}

	static function redirect($url)
	{
		preg_match('/http:\/\/.*/', $url, $matches);
		$host = $matches[0];
		if ($host == "") {
			$host = site_url.$url;
		}

		header("Location:".$host);
		die();
	}

	function bind($view_file, $arguments=array())
	{
		$arguments = array_merge((array)$arguments, (array)$this->arguments);
		$this->view->bind($view_file, $arguments);
		$this->notification = "";
	}

	function render($view_file, $arguments=array())
	{
		$output = $this->view->render($view_file, $arguments);
		$this->notification = "";

		return $output;
	}

    static function full_url()
    {
        $host = rtrim($_SERVER["HTTP_HOST"], "/"); 
        $host = split(":", $host);
        $host = $host[0];
        $protocol = $_SERVER["SERVER_PROTOCOL"];
        $port = $_SERVER["SERVER_PORT"];
        $qs = $_SERVER["QUERY_STRING"];
        $uri = $_SERVER["REQUEST_URI"];

        if (stripos($protocol, "HTTPS") !== FALSE) {
            $_protocol = "https://";
            $default_port = 443;
        }
        else {
            $_protocol = "http://";
            $default_port = 80;
        }

        $_port = ($port == $default_port) ? "": ":$port";

        return sprintf("%s%s%s%s", $_protocol, $host, $_port, $uri);
    }
}

?>

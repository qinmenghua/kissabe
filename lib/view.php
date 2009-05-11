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


require_library("/vendor/smarty/Smarty.class.php");

class view extends smarty
{
	public $master_view;

 	function __construct($master_view)
	{
  		$this->left_delimiter  =  '{%';
		$this->right_delimiter  =  '}';
		$this->template_dir = view_root;
		$this->compile_dir = cache_template_root;     // compiled files
		$this->plugins_dir[] = plugin_root;
		$this->plugins_dir[] = global_plugin_root;
		$this->master_view = $master_view;
	}

	function initial($view_file, $arguments=array())
	{
		if (count($arguments) > 0)
		{
			foreach($arguments as $key=>$val)
			{
				$this->assign($key, $val);
			}
		}

		$this->view_file = view_root."/".ltrim($view_file, "/");

		if ($this->master_view) 
		{
			$this->assign("__ACTION_VIEW_FILE_PATH__", $this->view_file);
			$this->view_file = view_root."/".ltrim($this->master_view, "/");
		}

		$this->assign("request", $_REQUEST);
	}

	function bind($view_file, $arguments=array())
	{
		$this->initial($view_file, $arguments);
		$this->display($this->view_file);
	}

	function render($view_file, $arguments=array())
	{
		$this->initial($view_file, $arguments);
		return $this->fetch($this->view_file);
	}
}

?>

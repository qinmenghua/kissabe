<?php

require_library("/base.php");
require_library("/helpers/base62.php");
require_library("/business/shortener_factory.php");

/*
 * @Layout("shortener")
 * @Style("theme.css")
 * @Script("jquery.js")
 */
class ShortenerPage extends BasePage
{
	public $master_view = "";

    /*
     * @Authentication(roles={"user"})
     * @Layout("shortener")
     * @View("home")
     * @Style("theme.css")
     * @Script("jquery.js")
     * @SecurePage(true)
     */
    public function example_action($id, $name) 
    {
        $this->request["username"];
        $this->view["list"] = array();

        // HttpContext 
        //     |-- Request
        //     |-- Response
        //     |-- Cache
        //     |-- Cookie
        //     |-- Server
        //     |-- QueryString
        //     |-- Form
        //     |-- Location
        //     |-- Internalization
        //
/*
        $this->request->items["aa"];
        $this->request->get("aa");
        $this->request->set("aa", 32);

        $this->cache->get();
        $this->cache->set("aa", 34);

        $this->cookie->get();
        $this->cookie->set("aa", 34);

        $this->header->get();
        $this->header->set("aa", 34);
*/
    }

	public function index()
	{
		$this->bind("/shortener/home.action");
	}

    public function url()
    {
        //$this->request["gg"];
        //$this->view["aa"];
//        $output["aaa"] = 111;
//        $this->view->items["aaa"] = 111;
//        $this->view->layout_id = "master";
//        $this->view->id = "url";

/*        
        if (isset($_GET["html"]) == false) {
            $this->view->master_view = "master.layout";
        }
*/
		$this->bind("/shortener/url.action", $data);
    }    

    public function image()
    {
		$this->bind("/shortener/image.action", $data);
    }    

    public function text()
    {
		$this->bind("/shortener/text.action", $data);
    }    

    public function email()
    {
		$this->bind("/shortener/email.action", $data);
    }

    public function info($code="")
    {
        $shortener = $this->from_code($code);

        if ($shortener) {
            $this->view->master_view = "";

            $data["shortener"] = $shortener;
            $data["site_url"] = site_url;
            $data["site_name"] = "kissa.be";

		    $this->bind("/shortener/info.action", $data);
        }
    }

    public function set()
    {
        $this->view->master_view = "master.layout";

        $type = $_REQUEST["status"];
        $content = $_REQUEST["content_data"];
        if (!$content) {
            $content = $_FILES["content_data"]["tmp_name"];
        }

        if (empty($content)) {
             $this->show_message("Content Not Found", "/home");
        }

        $shortener = shortener_factory::from_type($type, $content);
        $shortener->insert();
        
        if ($shortener->error) {
            $this->show_message($shortener->error->Reason, "/home");
        }

        $this->redirect("/{$shortener->code}-");
    }

    public function get($code="")
    {
        $this->view->master_view = "master.layout";
        $code = $this->page_parameters["code"];
        
        $data["shortener"] = $this->from_code($code);

        if ($data["shortener"]->is_display) {
            $this->view->master_view = "info.layout";
    		$this->bind("/shortener/get.action", $data);
        }
        else {
            $data["shortener"]->add_visitor();
            header("Location: {$data["shortener"]->long_url}"); 
        }
    }

    private function from_code($code)
    {
        // is_display request
        $code_length = strlen($code);
        if ($code[$code_length-1] == "-") {
            $is_display = true;
            $code = substr($code, 0, $code_length-1);
        }

        try {
            $shortener = shortener_factory::from_code($code);
            if ($shortener) { $shortener->is_display = $is_display; }
        }
        catch (Exception $ex) {
            $this->show_message($ex->getMessage(), "/home");
        }
 
        return $shortener;
    }
} 

?>

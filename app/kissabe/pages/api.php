<?php

require_library("/base.php");
require_library("/helpers/base62.php");
require_library("/business/shortener_factory.php");

class APIPage extends BasePage
{
	public $master_view = "";

	public function index()
	{
        $this->view->master_view = "master.layout";
    	$this->bind("/api/reference.action");
	}

    public function expander($code="")
    {
        if ($code == "") {
            die("Code Required");
        }

        $data["shortener"] = $this->from_code($code);

        $data["shortener"]->add_visitor();
        die($data["shortener"]->long_url); 
    }

    public function shortener($type=shortener::URL, $content="")
    {
        if ($content == "") {
            $content = $_REQUEST["content"];
            if (!$content) {
                $content = $_FILES["content"]["tmp_name"];
            }

            if (empty($content)) {
                 die("Content Not Found");
            }
        }

        $shortener = shortener_factory::from_type($type, $content);
        $shortener->insert();
        
        if ($shortener->error) {
            $this->show_message($shortener->error->Reason, "/home");
        }

        die($shortener->url);
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

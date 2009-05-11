<?php

require_library("base.php");
require_library("/helpers/base62.php");
require_library("/business/shortener_factory.php");

class SitePage extends BasePage
{
	public $master_view = "master.layout";

	public function index()
	{
        $this->bind("/site/termsofuse.action");
	}

    public function termsofuse()
    {
        $this->bind("/site/termsofuse.action");
    } 

    public function contact()
    {
        $email = "contact@dahius.com";

        header("Location: mailto:$email");

        $data["email"] = $email;
        $this->bind("/site/contact.action", $data);

    } 

    public function privacy()
    {
         $this->bind("/site/privacy.action");  
    } 
} 

?>

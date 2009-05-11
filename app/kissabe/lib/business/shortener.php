<?php

abstract class shortener
{
    const URL   = "url";
    const EMAIL = "email";
    const TEXT  = "text";
    const IMAGE = "image";

    public $id;
    public $code;
    public $url;
    public $content;
    public $length;
    public $type;
    public $pageview;
    public $uniq_pageview;

    protected $tbl; 

    function __construct($_tbl_url=null, $type=null, $content=null)
    {
        $this->type = $type;
        $this->content = $content;

        $this->tbl = ($_tbl_url && $_tbl_url instanceof Url) ? $_tbl_url : new Url();
        $this->initial();
    }

    function initial() 
    {
        $this->id = $this->tbl->id;
        $this->code = $this->tbl->code;
        $this->long_url = $this->tbl->url;
        $this->url = sprintf("%s/%s", site_url, $this->code);
        $this->length = strlen($this->url);
        $this->type = ($this->tbl->id) ? $this->tbl->type : $this->type;
        $this->pageview = $this->tbl->table->pageview($this->id);
        $this->uniq_pageview = $this->tbl->table->uniq_pageview($this->id);
    }

    function __toString()
    {
        return (string)$this->code;
    }

    function get_short_code()
    {
        return base62::encode($this->id);
    }


    static function is_html($content)
    {
        return preg_match("/<\/?\w+((\s+\w+(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/", $content);
    }

    static function is_email($email)
    {
    	$myReg = "/^([mailto:|\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$/";

		return preg_match($myReg, $email);
    }

    static function is_url($url)
    {
        $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
        if (!$url || $url=="") return false;
        if (!($parts = @parse_url($url )) ) return false;
        else {
            if ($parts[scheme] != "http" && $parts[scheme] != "https" && 
                $parts[scheme] != "ftp" && $parts[scheme] != "gopher")  
            { 
                return false;
            }
        }
        return true;
    }

    function content_type()
    {
        if ($this->content_type) {
            return $this->content_type;
        }
    }

    function file_extension()
    {
        $extensions = array( 
                            "text/html" => ".html",
                            "text/plain" => ".txt",
                            "image/jpeg" => ".jpeg",
                            "image/jpg" => ".jpg",
                            "image/png" => ".png",
                            "image/gif" => ".gif",
                           );

        return $extensions[$this->content_type];
    }

    function get_domain($url)
	{
		$url = ltrim($url, "mailto:");
		if (shortener::is_email($url))
		{
			list($uname, $url) = split("@", $url);
			return $url;
		}

        return $this->get_base_domain($url);
	}	

    function add_visitor()
    {
        $visitor = new Visitor();

        $visitor->url_id = $this->tbl->id;
        $visitor->referrer = $_SERVER["HTTP_REFERER"];
        $visitor->created_by = $this->get_ip();
        $visitor->created_on = date('Y-m-d H:i:s');

        $visitor->save();
    }

    abstract function prepare();
    abstract function validate();

    function exist() 
    {
        $exist = false;
        $tbl = $this->tbl->table->get_by_url($this->tbl->url);

        if ($tbl->id > 0) {
            $this->tbl = $tbl;
            $exist = true;
        }

        return $exist;
    }

    function insert()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->prepare(); // protected inheritence
        
        if (!$this->exist()) {
            $this->insert_into_table();
        }

        $this->initial();
       
        return true;
/*

        // Prepare & Validate Content Data
        if (!$this->content()) {
            return false;
        }

        if ($obj = $this->data_object->table->getContent($this->content)) {
            $this->data_object = $obj;
        } 
        else {
            $this->data_object = new Content();
            $this->data_object->input = $this->content;
            $this->data_object->status = $this->type;
            $this->data_object->domain = $this->get_domain($this->content);
            $this->data_object->created_by = $this->get_ip(); 
            $this->data_object->created_on = date("Y-m-d H:i:s");
            $this->data_object->save();
        }

        $this->id = $this->data_object->id;
        $this->code = $this->get_short_code();
        $this->content = $this->data_object->input;
        $this->url = sprintf("%s/%s", site_url, $this);
        $this->length = strlen($this->url);

        $this->pageview = "0";//$this->data_object->statistic->pageview;
        $this->uniq_pageview = "0";//$this->data_object->statistic->uniq_pageview;

        return true;
*/
    }


    function insert_into_table()
    {
        $this->tbl->domain = $this->get_domain($this->tbl->url);
        $this->tbl->status = "live";
        $this->tbl->type = $this->type;
        $this->tbl->save();
        $this->tbl->code =  base62::encode($this->tbl->id);
        $this->tbl->save();

        $own = new Ownership();
        $own->url_id = $this->tbl->id;
        $own->user_id = 1; //TODO: basepage user_id'den gelecek... 
        $own->created_by = $this->get_ip();
        $visitor->created_on = date('Y-m-d H:i:s');
        $own->save();
    }

    protected function get_base_domain($url)
    {
        $debug = 0;
        $base_domain = '';

        // generic tlds (source: http://en.wikipedia.org/wiki/Generic_top-level_domain)
        $G_TLD = array('biz','com','edu','gov','info','int','mil','name','net','org',
                       'aero','asia','cat','coop','jobs','mobi','museum','pro','tel','travel',
                       'arpa','root','berlin','bzh','cym','gal','geo','kid','kids','lat','mail',
                       'nyc','post','sco','web','xxx','nato','example','invalid','localhost','test',
                       'bitnet','csnet','ip','local','onion','uucp',
                       'co' // note: not technically, but used in things like co.uk
                      );

        // country tlds (source: http://en.wikipedia.org/wiki/Country_code_top-level_domain)
        $C_TLD = array(// active
                       'ac','ad','ae','af','ag','ai','al','am','an','ao','aq','ar','as','at','au','aw','ax','az',
                       'ba','bb','bd','be','bf','bg','bh','bi','bj','bm','bn','bo','br','bs','bt','bw','by','bz',
                       'ca','cc','cd','cf','cg','ch','ci','ck','cl','cm','cn','co','cr','cu','cv','cx','cy','cz',
                       'de','dj','dk','dm','do','dz','ec','ee','eg','er','es','et','eu','fi','fj','fk','fm','fo',
                       'fr','ga','gd','ge','gf','gg','gh','gi','gl','gm','gn','gp','gq','gr','gs','gt','gu','gw',
                       'gy','hk','hm','hn','hr','ht','hu','id','ie','il','im','in','io','iq','ir','is','it','je',
                       'jm','jo','jp','ke','kg','kh','ki','km','kn','kr','kw','ky','kz','la','lb','lc','li','lk',
                       'lr','ls','lt','lu','lv','ly','ma','mc','md','mg','mh','mk','ml','mm','mn','mo','mp','mq',
                       'mr','ms','mt','mu','mv','mw','mx','my','mz','na','nc','ne','nf','ng','ni','nl','no','np',
                       'nr','nu','nz','om','pa','pe','pf','pg','ph','pk','pl','pn','pr','ps','pt','pw','py','qa',
                       're','ro','ru','rw','sa','sb','sc','sd','se','sg','sh','si','sk','sl','sm','sn','sr','st',
                       'sv','sy','sz','tc','td','tf','tg','th','tj','tk','tl','tm','tn','to','tr','tt','tv','tw',
                       'tz','ua','ug','uk','us','uy','uz','va','vc','ve','vg','vi','vn','vu','wf','ws','ye','yu',
                       'za','zm','zw',
                       // inactive
                       'eh','kp','me','rs','um','bv','gb','pm','sj','so','yt','su','tp','bu','cs','dd','zr'
                      );

        // get domain
        if (!$full_domain = $this->get_url_domain($url))
        {
            return $base_domain;
        }

        // now the fun
        // break up domain, reverse
        $DOMAIN = explode('.', $full_domain);
        if ($debug) print_r($DOMAIN);

        $DOMAIN = array_reverse($DOMAIN);
        if ($debug) print_r($DOMAIN);

        // first check for ip address
        if (count($DOMAIN) == 4 && is_numeric($DOMAIN[0]) && is_numeric($DOMAIN[3]))
        {
            return $full_domain;
        }

        // if only 2 domain parts, that must be our domain
        if ( count($DOMAIN) <= 2 ) return $full_domain;
        
        /* finally, with 3+ domain parts: obviously D0 is tld
        now, if D0 = ctld and D1 = gtld, we might have something like com.uk
        so, if D0 = ctld && D1 = gtld && D2 != 'www', domain = D2.D1.D0
        else if D0 = ctld && D1 = gtld && D2 == 'www', domain = D1.D0
        else domain = D1.D0
        these rules are simplified below
        */

        if (in_array($DOMAIN[0], $C_TLD) && in_array($DOMAIN[1], $G_TLD) && $DOMAIN[2] != 'www')
        {
            $full_domain = $DOMAIN[2] . '.' . $DOMAIN[1] . '.' . $DOMAIN[0];
        }
        else
        {
            $full_domain = $DOMAIN[1] . '.' . $DOMAIN[0];;
        }

        // did we succeed?
        return $full_domain;
    }

    private function get_url_domain($url)
    {
        $domain = '';
        $_URL = parse_url($url);

        // sanity check
        if (empty($_URL) || empty($_URL['host']))
        {
            $domain = '';
        }
        else
        {
            $domain = $_URL['host'];
        }

        return $domain;
    }

    protected function get_ip()
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

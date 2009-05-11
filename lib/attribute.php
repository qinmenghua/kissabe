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


require_library("/vendor/addendum/annotations.php");

class Attribute extends Annotation
{
    protected $page;

    public function Run($page)
    {
        $this->page = $page;

        $this->Execute();

        return $this->page;
    }

    protected function Execute()
    {
        //TODO anythin with $this->page;
    }

    public static function Loader($attribute_folders)
    {
        foreach ($attribute_folders as $folder) 
        {
            $dh = opendir($folder);
            while($file = readdir($dh)) 
            {
                if ($file != '.' && $file != '..' && preg_match("/^.*\.php$/", $file))
                {
                    require_once $folder."/".$file;
                }
                
            }
        }
    }
}

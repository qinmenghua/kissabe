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

class Authentication extends Attribute 
{
    public $roles;

    protected function Execute()
    {
        $this->page->authentication((array)$this->roles);
    }
}

class Https extends Attribute 
{
}

class Title extends Attribute 
{
}

class ContentType extends Attribute 
{
}



?>

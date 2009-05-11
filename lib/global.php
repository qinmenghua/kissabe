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

function require_library($path)
{
    $path = "/".ltrim($path, "/");

    if (file_exists(library_root.$path)) {
        require_once(library_root.$path);
    }
    else {
        require_once(global_library_root.$path);
    }

}

?>

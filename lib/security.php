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

require_library("/vendor/inputfilter/class.inputfilter_clean.php");

class security
{
    const FILTER_BLACKLIST = 1;
    const FILTER_WHITELIST = 0;

    /**
     * @desc xss_filter
     *
     * @param $input
     * @param $tags
     * @param $attributes
     * @param $filter_method
     **/
    public static function xss_filter($input, $tags="", $attributes="", $filter_method=self::FILTER_BLACKLIST)
    {
        // Eger api gibi bir sayfa ise hicbirsey yapma...
        if (self::is_immune()) {
            return $input;
        }

	    $tags = explode(',', $tags);
	    for ($i = 0; $i < count($tags); $i++) $tags[$i] = trim($tags[$i]);

	    $attributes = explode(',', $attributes);
	    for ($i = 0; $i < count($attributes); $i++) $attributes[$i] = trim($attributes[$i]);

        $filter = new InputFilter($tags, $attributes, 1, 1, $filter_method);
        return $filter->process($input);
    }

    /**
     * @desc sqli_filter
     *
     * @param $input
     **/
    public static function sqli_filter($input)
    {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }

        return mysql_escape_string($input);
    }

    public static function escape($input) 
    {
        return self::sqli_filter(self:xss_filter($input));
    }
}
 
?>

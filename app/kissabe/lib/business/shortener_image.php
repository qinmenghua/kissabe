<?php

require_once("shortener.php");

class shortener_image extends shortener
{
    function prepare()
    { 
        $file_extension = $this->file_extension();
        $filename = md5_file($this->content);
        $path = sprintf("%s/images/%s%s", upload_root, $filename, $file_extension);
        $uri = sprintf("%s/images/%s%s", upload_url, $filename, $file_extension);
        
        if (!file_exists($path)) {
            rename($this->content, $path) or die("olmadi");
        }

        $this->tbl->url = $uri;
        
        return true;
    }

    function validate()
    {
        $image_limit = 1024 * 1024 * 5;
        $info = @getimagesize($this->content);
        
        list($type, $extension) = split("/", $info["mime"]);
    
        if ($type != "image" || $info["size"] > $image_limit) {
            $this->error->Reason = sprintf("Please Check File!<br/><small>(Size Limit %s)</small>", 
                                     $this->get_size($image_limit));
            return false;
        }

        if (self::is_url($this->content)) {
            $file_path = $this->image_upload_from_url($this->content);

            if (!$file_path) {
                $this->error->Reason = "URL Not Image File or Uploaded!";
                return false;
            }
            $this->content = $file_path;
        }

        if (!file_exists($this->content)) {
            $this->error->Reason = "Image Not Uploaded!";
            return false;
        }

        $this->content_type = $info["mime"];

        return true;
    }

    function image_upload_from_url($url)
    {
        $path = sprintf("/tmp/%s", uniqid());
        $contents = file_get_contents($url);

        if ($contents) {
            $fp = fopen($path, 'wb');
            fwrite($fp, $contents);
            fclose($fp);
            return $path;
        }

        return false;
    } 

    /**
     * Get the human-readable size for an amount of bytes
     * @param int  $size      : the number of bytes to be converted
     * @param int $precision  : number of decimal places to round to;
     *                          optional - defaults to 2
     * @param bool $long_name : whether or not the returned size tag should
     *                          be unabbreviated (ie "Gigabytes" or "GB");
     *                          optional - defaults to true
     * @param bool $real_size : whether or not to use the real (base 1024)
     *                          or commercial (base 1000) size;
     *                          optional - defaults to true
     * @return string         : the converted size
     */
    function get_size($size,$precision=2,$long_name=true,$real_size=true) {
       $base=$real_size?1024:1000;
       $pos=0;
       while ($size>$base) {
          $size/=$base;
          $pos++;
       }
       $prefix=$this->get_size_prefix($pos);
       $size_name=$long_name?$prefix."bytes":$prefix[0].'B';
       return round($size,$precision).' '.ucfirst($size_name);
    }
    /**
     * @param int $pos : the distence along the metric scale relitive to 0
     * @return string  : the prefix
     */
    function get_size_prefix($pos) {
       switch ($pos) {
          case 00: return "";
          case 01: return "kilo";
          case 02: return "mega";
          case 03: return "giga";
          case 04: return "tera";
          case 05: return "peta";
          case 06: return "exa";
          case 07: return "zetta";
          case 08: return "yotta";
          case 09: return "xenna";
          case 10: return "w-";
          case 11: return "vendeka";
          case 12: return "u-";
          default: return "?-";
       }
    }


}

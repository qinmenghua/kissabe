<?php

define("domain", $_SERVER["HTTP_HOST"]);
define("site_url", "http://".domain.site_root);
define("asset_url", site_url.asset_folder);
define("image_url", asset_url.image_folder);
define("flash_url", asset_url.flash_folder);
define("style_url", asset_url.style_folder);
define("upload_url", asset_url.upload_folder);
define("script_url", asset_url.script_folder);

?>

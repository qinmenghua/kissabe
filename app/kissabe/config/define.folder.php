<?php

define("document_folder", "/www");
define("asset_folder", "/assets");
define("global_library_folder", "/lib");
define("vendor_folder", "/vendor");
define("cache_template_folder", "/cache/templates");
define("config_folder", "/config");
define("library_folder", "/lib");
define("plugin_folder", "/plugins");
define("attribute_folder", "/attributes");

define("controller_folder", "/pages");

define("view_folder", "/views");
define("upload_folder", "/uploads");
define("image_folder", "/images");
define("flash_folder", "/flashes");
define("text_folder", "/texts");
define("style_folder", "/styles");
define("script_folder", "/scripts");
define("text_folder", "/texts");

define("framework_root", realpath(dirname(__FILE__)."/../../.."));
define("global_library_root", framework_root.global_library_folder);
define("global_plugin_root", global_library_root.plugin_folder);
define("global_attribute_root", global_library_root.attribute_folder);
define("vendor_root", global_library_root.vendor_folder);

define("application_root", realpath(dirname(__FILE__)."/.."));
define("document_root", application_root.document_folder);
define("config_root", application_root.config_folder);
define("cache_template_root", application_root.cache_template_folder);
define("controller_root", application_root.controller_folder);

define("library_root", application_root.library_folder);
define("plugin_root", library_root.plugin_folder);
define("attribute_root", library_root.attribute_folder);

define("asset_root", document_root.asset_folder);
define("upload_root", asset_root.upload_folder);
define("image_root", asset_root.image_folder);
define("flash_root", asset_root.flash_folder);
define("script_root", asset_root.script_folder);
define("text_root", asset_root.text_folder);
define("view_root", asset_root.view_folder);

?>

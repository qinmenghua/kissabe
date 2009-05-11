<?php /* Smarty version 2.6.20, created on 2009-05-12 00:51:29
         compiled from /home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/shortener/info.action */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'script', '/home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/shortener/info.action', 3, false),array('function', 'image', '/home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/shortener/info.action', 64, false),array('modifier', 'cut', '/home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/shortener/info.action', 74, false),)), $this); ?>
<html>
<head>
    <?php echo smarty_function_script(array('name' => "jquery.js"), $this);?>

    <?php echo smarty_function_script(array('name' => "kissa.js"), $this);?>

    <?php echo smarty_function_script(array('name' => "ZeroClipboard.js"), $this);?>

</head>

<style>
body { margin:0; }
.table-header {
    border-bottom:1px solid #AAA; 
    width:100%; 
    height:35px; 
    padding:1px;
}
.black-link {
    color:black; 
    font-weight:bold; 
    text-decoration:none;
}
.long-url-link {
    font-size:12px; 
    color:#116; 
    text-decoration:none;
}


</style>

<script type="text/javascript">

var clip;
    function init() 
    {
        ZeroClipboard.setMoviePath('../../assets/flashes/ZeroClipboard.swf');
        clip = new ZeroClipboard.Client();
			clip.setHandCursor( true );
    }
	
    $(document).ready(function() 
    {
	    $('a').click(function() { 
                                  parent.location.href = this.href; 
                                  return false;
                            });
        init();
        $('#clipboard_button').click(function() {
            clip.setText("Hadii be"); 
        });

    });

	
		function my_complete(client, text) {
			alert("Copied text to clipboard: " + text );
		}
	

</script>
<body>
<table class="table-header">
<tr>
    <td rowspan="2" style="padding: 0 5px 0 3px; width:40px;">
        <?php echo smarty_function_image(array('src' => "mini-logo.png",'alt' => ($this->_tpl_vars['site_name']),'href' => ($this->_tpl_vars['site_url']),'style' => "border-width:0"), $this);?>

    </td>
    <td style="font-size:13px;">
        <a href="<?php echo $this->_tpl_vars['site_url']; ?>
" class="black-link"><?php echo $this->_tpl_vars['site_name']; ?>
<i>!</i></a>
        <div id="blip" style="display: none">Copied to clipboard, ready to paste.</div>
   </td>
    <td style="text-align:right; font-size:10px;"><b>Uniq Page View</b> <?php echo $this->_tpl_vars['shortener']->uniq_pageview; ?>
</td>
</tr>
<tr>
    <td>
        <a class="long-url-link" href="<?php echo $this->_tpl_vars['shortener']->long_url; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['shortener']->long_url)) ? $this->_run_mod_handler('cut', true, $_tmp) : smarty_modifier_cut($_tmp)); ?>
</a>
    </td>
    <td style="text-align:right; font-size:10px;"><b>Page View</b> <?php echo $this->_tpl_vars['shortener']->pageview; ?>
</td>
</tr>
</table>
<div style="display:none;">
<!-- Piwik -->
<a href="http://piwik.org" title="Google Analytics alternative" onclick="window.open(this.href);return(false);">
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://www.dahius.com/tools/analytics/" :
                 "http://www.dahius.com/tools/analytics/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
piwik_action_name = '';
piwik_idsite = 1;
piwik_url = pkBaseURL + "piwik.php";
piwik_log(piwik_action_name, piwik_idsite, piwik_url);
</script>
<object><noscript><p>Google Analytics alternative <img src="http://www.dahius.com/tools/analytics/piwik.php?idsite=1"
style="border:0" alt=""/></p></noscript></object></a>
<!-- End Piwik Tag -->
</div>


</body>
</html>
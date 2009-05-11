<?php /* Smarty version 2.6.20, created on 2009-05-12 00:51:29
         compiled from /home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/info.layout */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'path', '/home/meddah/Desktop/joy-0.0.2/framework/app/kissabe/www/assets/views/info.layout', 7, false),)), $this); ?>
<html>
<head>
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
</head>
<frameset rows="47px,*" noresize scrolling=auto frameborder=0>
  <frame src="<?php echo ((is_array($_tmp="/shortener/info/")) ? $this->_run_mod_handler('path', true, $_tmp) : smarty_modifier_path($_tmp)); ?>
<?php echo $this->_tpl_vars['shortener']; ?>
" />
  <frame src="<?php echo $this->_tpl_vars['shortener']->long_url; ?>
" />
</frameset>
</html>
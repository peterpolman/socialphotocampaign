<?php /* Smarty version 2.6.26, created on 2015-08-31 10:28:39
         compiled from front/layout/flash.tpl */ ?>
<?php if ($this->_tpl_vars['flash'] != ''): ?>
<script type="text/javascript" >
<?php echo '
	$(document).ready(function(){
		setTimeout(function(){
			$(\'#flash\').animate({opacity: \'hide\', height: \'hide\', marginTop: \'hide\', marginBottom: \'hide\', paddingTop: \'hide\', paddingBottom: \'hide\'}, 500,\'swing\',function() {
					$("#flash").remove();
			});
		}, 6000);
	});
'; ?>

</script>
<div align="center"><div id="flash" class='flash<?php echo $this->_tpl_vars['flash']['type']; ?>
'><?php echo $this->_tpl_vars['flash']['message']; ?>
</div></div>
<?php endif; ?>
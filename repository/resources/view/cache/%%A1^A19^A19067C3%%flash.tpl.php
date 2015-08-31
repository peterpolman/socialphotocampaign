<?php /* Smarty version 2.6.26, created on 2013-03-20 17:00:13
         compiled from system/layout/flash.tpl */ ?>
<?php if ($this->_tpl_vars['flash'] != ''): ?>
<script type="text/javascript" >
<?php echo '
	$(document).ready(function(){
		setTimeout(function(){
			$("#flash").fadeOut("slow", 
				function () {
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
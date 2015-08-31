<?php /* Smarty version 2.6.26, created on 2013-04-22 14:52:59
         compiled from beheer/dashboard/index.tpl */ ?>
<p>Met deze beheer-tool kunnen inzendingen en stemmen worden aangepast of verwijderd.</p>
<form action="<?php echo $this->_tpl_vars['system']; ?>
/entry/clearAll" method="get">
	<button type="submit">Unpublish alle inzendingen en stemmen</button>
</form>
<?php /* Smarty version 2.6.26, created on 2013-03-18 11:28:59
         compiled from beheer/mailing/zekerweten.tpl */ ?>
<h1>Mailing versturen</h1>

<p>Weet je heel zeker dat je onderstaande e-mail naar alle inzenders wilt versturen?</p>

<div class="mailing"><?php echo $this->_tpl_vars['mail']; ?>
</div>

<form action="" method="post">
	<input type="hidden" name="winnaar" value="<?php echo $this->_tpl_vars['entry']->getId(); ?>
"/>
	<input type="hidden" name="text" value="<?php echo $this->_tpl_vars['text']; ?>
"/>
	<input type="submit" name="bevestig" value="Ja, verstuur deze mail"/>
</form>
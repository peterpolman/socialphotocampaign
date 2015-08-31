<?php /* Smarty version 2.6.26, created on 2013-04-22 14:53:26
         compiled from beheer/mailing/index.tpl */ ?>
<h1>Mailing versturen</h1>

<p>U kunt een mailing versturen naar alle inzenders, om te informeren over de winnaar van de wedstrijd.</p>

<form action="" method="post">
	<h2>Kies een winnaar</h2>
	<select name="winnaar">
		<?php $_from = $this->_tpl_vars['votes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry'] => $this->_tpl_vars['vote']):
?>
			<?php $this->assign('myEntry', $this->_tpl_vars['entries'][$this->_tpl_vars['entry']]); ?>
			<option value="<?php echo $this->_tpl_vars['entry']; ?>
"><?php echo $this->_tpl_vars['myEntry']['first_name']; ?>
 <?php echo $this->_tpl_vars['myEntry']['last_name']; ?>
 -- <?php echo $this->_tpl_vars['vote']; ?>
 stem<?php if ($this->_tpl_vars['vote'] != 1): ?>men<?php endif; ?></option>
		<?php endforeach; endif; unset($_from); ?>
	</select>
	
	<h2>Begeleidende tekst</h2>
	<textarea name="text" rows="10" cols="60"></textarea><br/>
	
	<input type="submit" name="versturen" value="Versturen"/>
</form>
<?php /* Smarty version 2.6.26, created on 2013-03-18 11:53:35
         compiled from beheer/mailing/mail.tpl */ ?>
<p>Beste <?php if (isset ( $this->_tpl_vars['ontvanger'] )): ?><?php echo $this->_tpl_vars['ontvanger']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['ontvanger']->getLast_name(); ?>
<?php else: ?>&lt;naam&gt;<?php endif; ?>,</p>
<p>De winnaar van deze maand is <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
 met onderstaande foto.</p>
<p><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/medium/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
"/></p>
<p><?php echo $this->_tpl_vars['text']; ?>
</p>
<p>Groetjes!<br/>
De website</p>
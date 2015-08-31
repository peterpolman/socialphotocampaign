<?php /* Smarty version 2.6.26, created on 2013-09-07 21:05:36
         compiled from front/actiecode/mail.tpl */ ?>
<p><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
 heeft via de website www.opknappertjenodig.nl een actiecode ingevuld: <?php echo $this->_tpl_vars['actiecode']; ?>
</p>

<p>Naam: <?php echo $this->_tpl_vars['naam']; ?>
<br/>
E-mail: <?php echo $this->_tpl_vars['email']; ?>
<br/>
Telefoon: <?php echo $this->_tpl_vars['telefoon']; ?>
<br/>
Bankrekening: <?php echo $this->_tpl_vars['rekening']; ?>
<br/>
Order nummer: <?php echo $this->_tpl_vars['ordernr']; ?>
</p>

<?php if ($this->_tpl_vars['entry']): ?>
<p>De actiecode hoort bij de <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
">inzending van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</a></p>
<?php else: ?>
<p><strong>De actiecode hoort bij geen enkele inzending.</strong></p>
<?php endif; ?>
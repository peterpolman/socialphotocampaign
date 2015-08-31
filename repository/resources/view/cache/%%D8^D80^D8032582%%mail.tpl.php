<?php /* Smarty version 2.6.26, created on 2015-08-31 15:48:44
         compiled from front/keukens/mail.tpl */ ?>
<p>Hoi <?php if (isset ( $this->_tpl_vars['ontvanger'] )): ?><?php echo $this->_tpl_vars['ontvanger']->getFirst_name(); ?>
<?php else: ?>&lt;naam&gt;<?php endif; ?>,</p>

<p>Leuk dat je meedoet aan onze actie! Aan het einde van de actieperiode wordt de winnaar van de renovatiecheque via Facebook bekend gemaakt. Zorg tot die tijd dat je je unieke URL verspreidt onder uw vrienden, zij kunnen vervolgens op je keuken stemmen, waardoor je meer kans maakt om te winnen!</p>

<p>Dit is jouw link: <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><strong>U<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</strong></a></p>

<p>Vergeet ook niet onze <a href="http://www.facebook.com/ikookkeukens">Facebook pagina</a> te liken! Zo blijf je op de hoogte van alle nieuwtjes tijdens de actieperiode en geven we ook nog gratis renovatietips weg!</p>

<p>Veel succes!<br />
<strong>I-KOOK Keukens</strong></p>
<img src="" alt="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/logo.png" alt="" />
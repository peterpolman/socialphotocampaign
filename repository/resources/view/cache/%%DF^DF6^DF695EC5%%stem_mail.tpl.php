<?php /* Smarty version 2.6.26, created on 2014-10-02 07:14:52
         compiled from front/keukens/stem_mail.tpl */ ?>
<p>Hoi <?php if (isset ( $this->_tpl_vars['ontvanger'] )): ?><?php echo $this->_tpl_vars['ontvanger']->getFirst_name(); ?>
<?php else: ?>&lt;naam&gt;<?php endif; ?>,</p>

<p>Gefeliciteerd! Iemand heeft op je keuken gestemd. Bekijk <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
">hier</a> het totaal aantal stemmen op uw inzending en verspreid de link onder uw vrienden om meer kans te maken op de I-KOOK renovatiecheque.</p>

<p>Dit is jouw link: <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><strong>U<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</strong></a></p>

<p><strong>Schakel de hulp van je vrienden in:</strong><br />
Vrienden kunnen je helpen om te winnen! Deel je inzending op Facebook en vertel je vrienden waarom ze op jouw inzending moeten stemmen. </p>

<p>Veel succes!<br />
<strong>I-KOOK Keukens</strong></p>
<img src="" alt="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/logo.png" alt="" />
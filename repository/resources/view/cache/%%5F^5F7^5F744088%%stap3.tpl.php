<?php /* Smarty version 2.6.26, created on 2014-09-25 15:53:41
         compiled from front/keukens/stap3.tpl */ ?>
<article id="content" class="form" style="text-align: center;">
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-lg-12 content" style="text-align: center;">
			<h2>Verzamel nu zo veel mogelijk stemmen!</h2>
			<p>Gefeliciteerd! We hebben je inzending ontvangen. Nu is het aan jou om zoveel mogelijk stemmen te verzamelen voor jouw inzending. Via Facebook kun je je link verspreiden en je vrienden vragen om op jouw inzending te stemmen. Succes!</p>
			<div class="url">
				Dit is jouw link: <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><strong><?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</strong></a>
			</div>
			<p>Deel nu je inzending op Facebook en roep je vrienden op om hun stem uit te brengen.</p>
			<a href="http://www.facebook.com/sharer.php?u=<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/share-facebook.png" height="35" alt="" /></a>
		</div>
	</div>
</article>
<?php /* Smarty version 2.6.26, created on 2015-08-31 11:45:40
         compiled from front/keukens/fetch.tpl */ ?>
<?php $_from = $this->_tpl_vars['entries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
<?php $this->assign('entryId', $this->_tpl_vars['entry']->getId()); ?>
<li class="col-xs-12 col-sm-4 col-lg-3">
	<div class="wrapper">
		<div class="front">
			<div class="picture">
				<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/medium/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" alt="" />
			</div>
			<div class="vote-count">
				<?php echo $this->_tpl_vars['entry']->getTotal_vote_count(); ?>

			</div>
			<p class="username">
				<?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>

			</p>
			<p class="location">
				<?php echo $this->_tpl_vars['entry']->getPlace(); ?>

			</p>
		</div>
		<div class="back">
			<p class="username">
				<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entryId']; ?>
">Stem op <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 uit<br /><?php echo $this->_tpl_vars['entry']->getPlace(); ?>
</a>
			</p>
			<div class="vote">
				<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entryId']; ?>
"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
/cji/img/vote-heart.png" alt="" /></a>
			</div>
			<p class="vote-count">
				<?php echo $this->_tpl_vars['entry']->getTotal_vote_count(); ?>
 stemmen verzameld
			</p>
			<div class="fb-like" data-href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
		</div>
	</div>
</li>
<?php endforeach; endif; unset($_from); ?>
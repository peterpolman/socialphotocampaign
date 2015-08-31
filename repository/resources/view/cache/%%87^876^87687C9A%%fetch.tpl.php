<?php /* Smarty version 2.6.26, created on 2013-04-12 10:49:14
         compiled from front/inzendingen/fetch.tpl */ ?>
<?php $_from = $this->_tpl_vars['entries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?><?php $this->assign('entryId', $this->_tpl_vars['entry']->getId()); ?>
		<li>
			<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entryId']; ?>
">
				<div class="default toggle">
					<figure>
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/medium/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" alt="<?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
"/>
						<figcaption>
							<span><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</span>
						</figcaption>
					</figure>
				</div>
				<div class="hover toggle">
					<h3><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</h3>
					<figure>
						<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/medium/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" alt="<?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
"/>
						<figcaption>
							<div class="votes">
								<?php echo $this->_tpl_vars['votes'][$this->_tpl_vars['entryId']]; ?>

								<span>stemmen</span>
							</div>
						</figcaption>
					</figure>
					<div class="actions">
						<button>Stemmen!</button>
						<button>Neem een kijkje</button>
					</div>
				</div>
			</a>
		</li>
<?php endforeach; endif; unset($_from); ?>
<?php echo '
<script>
$(function() {
	
	// Toggle the default and hover state of an item
	$("#latest_posts ul.posts li a").hover(function(){
		$(this).find(\'.hover\').fadeIn(100);
		},function(){
		$(this).find(\'.hover\').fadeOut(100);
	});
});
</script>
'; ?>

<?php /* Smarty version 2.6.26, created on 2015-08-31 15:41:12
         compiled from front/keukens/opknapper.tpl */ ?>
<section id="photo">
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-lg-12 content">
				<div class="header">
					<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/large/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" alt="" />
				</div>

				<div class="url">
					Dit is jouw link: <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><strong><?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</strong></a>
				</div>
			</div>
		</div>
	</div>
	<div class="container ads">
		<div class="col-xs-12 col-sm-6 col-lg-6 content">
			<a class="ad" href="http://www.i-kook.nl/keukens-kijken/collectie-keukens/tot-%E2%82%AC2000" target="_blank">	<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/2013_keukens-onder-2000.jpg" alt="" />
			</a>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6 content">
			<a class="ad" href="http://www.i-kook.nl/catalog/apparatuur" target="_blank">
				<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/2013_altijd-op-voorraad_(app).jpg" alt="" />
			</a>
		</div>
	</div>
</section>

<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-8 col-lg-8 content">
			<h3>Het verhaal achter de keuken van: <br /><span><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</span></h3>
			<p><i><?php echo $this->_tpl_vars['entry']->getDescription(); ?>
</i></p>
			<h3>Wil je <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 helpen met het verzamelen van stemmen?</h3>
			<p><a class="share" href="http://www.facebook.com/sharer.php?u=<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/share-facebook.png" height="auto" width="100"alt="" /></a>
			<p>Gebruik de bovenstaande knop om de link van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 op je Facebook tijdlijn te plaatsen. Zo roep je niet alleen de vrienden van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
, maar ook jouw vrienden op om mee te helpen.</p>
		</div>
		<div class="col-xs-12 col-sm-4 col-lg-4">
			<section id="top-5">
				<header class="heading"><h1>De Top 5!</h1></header>
				<article>
					<ul>
						<?php $_from = $this->_tpl_vars['topEntries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['topEntry']):
?>
						<?php $this->assign('entryId', $this->_tpl_vars['topEntry']->getId()); ?>
						<li>
							<div class="picture">
								<img width="65" src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/small/<?php echo $this->_tpl_vars['topEntry']->getFilename(); ?>
" alt="<?php echo $this->_tpl_vars['topEntry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['topEntry']->getLast_name(); ?>
" />
							</div>
							<div class="vote-count">
								<?php echo $this->_tpl_vars['topEntry']->getTotal_vote_count(); ?>

							</div>
							<p class="username">
								<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entryId']; ?>
"><?php echo $this->_tpl_vars['topEntry']->getFirst_name(); ?>
</a>
							</p>
							<p class="location">
								<?php echo $this->_tpl_vars['topEntry']->getPlace(); ?>

							</p>
						</li>
						<?php endforeach; endif; unset($_from); ?>
					</ul>
				</article>
			</section>
		</div>
	</div>
</article>
<div class="container">
	<section id="comments">
		<h2>Wens <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 succes!</h2>
		<div class="fb-comments" data-href="http://www.opknappertjenodig.nl/keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-width="650" data-num-posts="10"></div>
	</section>
</div>
<?php echo '
	<script>
	(function(){
		$("#content .submission").hover(function(){
			$(this).find(\'.hover\').fadeIn(100);
			},function(){
			$(this).find(\'.hover\').fadeOut(100);
		});
	}(document));
	</script>
'; ?>

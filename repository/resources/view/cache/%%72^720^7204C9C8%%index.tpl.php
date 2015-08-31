<?php /* Smarty version 2.6.26, created on 2015-08-31 10:28:39
         compiled from front/dashboard/index.tpl */ ?>
<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-lg-8 content">
			<h2>Knap je keuken op!</h2>
			<p><strong>Heeft je vaatwasser het begeven? Krijg je die oude oven echt niet meer schoon? Of ben je gewoon toe aan nieuwe keuken inbouwapparatuur?</strong></p>
			<p>Misschien is het dan wel tijd om je apparatuur te vervangen! I-KOOK geeft namelijk iedere actieperiode 2 renovatiecheques t.w.v. € 250,- weg!  </p>
			<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/doemee">Volg de stappen en doe mee</a></p>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-4">
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
								<?php echo $this->_tpl_vars['topVotes'][$this->_tpl_vars['entryId']]; ?>

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
<section id="overview">	
	<div class="container">
		<h1>De laatste deelnemers</h1>
		<ul>
			<?php $_from = $this->_tpl_vars['lastEntries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
							<?php echo $this->_tpl_vars['votes'][$this->_tpl_vars['entryId']]; ?>

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
							<?php echo $this->_tpl_vars['votes'][$this->_tpl_vars['entryId']]; ?>
 stemmen verzameld
						</p>
						<div class="fb-like" data-href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/opknapper/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
					</div>
				</div>
			</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
</section>
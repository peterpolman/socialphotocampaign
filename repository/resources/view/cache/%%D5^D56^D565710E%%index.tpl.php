<?php /* Smarty version 2.6.26, created on 2015-08-31 10:28:46
         compiled from front/informatie/index.tpl */ ?>
<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-lg-8 content">
			<h2>Wat moet je doen?</h2>
			<p>Als je kans wilt maken op de renovatiecheque hoef je slechts je persoonsgegevens in te vullen en een foto van je huidige keuken inbouwapparaat te uploaden. Je krijgt vervolgens een bevestigingsmail met tips om zoveel mogelijk stemmen voor jouw inzending in te zamelen.</p>
			<ul>
				<li>Stap 1: Upload je foto</li>
				<li>Stap 2: Vul je gegevens in</li>
				<li>Stap 3: Laat je vrienden op je inzending stemmen!</li>
			</ul>
			<p>Als je alles netjes hebt ingezonden zal je moeten zorgen dat er zoveel mogelijk vrienden en andere bekenden op jouw inzending gaan stemmen. Aan het einde van de actieperiode wordt de winnaar met de meeste stemmen via Facebook bekend gemaakt. Daarnaast belonen we de meest creatieve en originele inzending ook nog eens met een renovatiecheque t.w.v. &euro; 250,-. Een vakman van I-KOOK zal contact met je zoeken om een afspraak te maken.</p>
			<h2>Wat kun je winnen?</h2>
			<p>De winnaars van de actie ontvangen een renovatiecheque t.w.v. &euro; 250,-. Tijdens een afspraak met de lokale vakman van I-KOOK zal gekeken worden hoe deze het best kan worden besteed.</p>
			<p><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/winnaars_opknappertje.png" width="100%" alt="" /><br />Winnaars van onze laatste keukenrenovatie actie.</p>
			<p>Vergeet ook niet onze Facebook pagina te liken! Zo blijf je op de hoogte van alle nieuwtjes tijdens de actieperiode en hier maken we uiteindelijk de winnaar bekend.</p>
			<div class="fb-like" data-href="http://www.facebook.com/ikookkeukens" data-send="false" data-width="350" data-show-faces="false" data-font="arial" data-colorscheme="light"></div>
			<p>Voor meer informatie leest u de <a href="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/files/actievoorwaarden.pdf">actievoorwaarden</a>.</p>
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
<?php /* Smarty version 2.6.26, created on 2013-04-12 13:34:25
         compiled from front/inzendingen/stap3.tpl */ ?>
<?php echo '
	<script type="text/javascript">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));
	</script>
	<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>
'; ?>


	<section id="content">
		<div class="wrapper">
			<div class="content">
				<h2>Verzamel nu zo veel mogelijk stemmen!</h2>
				
				<p>Gefeliciteerd! We hebben je inzending ontvangen. Nu is het aan jou om zoveel mogelijk stemmen te verzamelen voor jouw inzending. Verspreid de onderstaande link onder je vrienden, of verspreid je inzending over Twitter of Facebook.</p>
				<div class="url"><p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</a></p></div>
				<div class="col first">
					<h3>Twitter</h3>
					<p>Deel dit bericht met je Twitter volgers en laat ze op jouw inzending stemmen.</p>
					<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en"  data-lang="en" data-url="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-text="Stem op mijn keuken bij iKOOK, dan win ik misschien een opknapbeurt!">Tweet</a> 
				</div>
				<div class="col">
					<h3>Facebook</h3>
					<p>Plaats dit bericht op je Facebook wall, vraag mensen het te delen en op jouw inzending te stemmen.</p>
					<div class="fb-like" data-send="false" data-layout="button_count" data-width="100" data-show-faces="false" data-href="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"></div>
				</div>
			</div>
		</div>
	</section>
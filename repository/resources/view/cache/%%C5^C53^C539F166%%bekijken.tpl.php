<?php /* Smarty version 2.6.26, created on 2013-04-12 13:56:33
         compiled from front/inzendingen/bekijken.tpl */ ?>
<?php echo '
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1&appId=177969065690482";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));
	</script>
	<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>
'; ?>

		<div id="fb-root"></div>
		<section id="content">
			<div class="wrapper">
				<div class="content">
					<div class="submission">
						<div class="image">
							<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
files/large/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" alt="" />
						</div>
						<div class="hover">
							<div class="votes">
								<span><?php echo $this->_tpl_vars['votes']; ?>
</span>
								<form action="" method="post">
									<button type="submit" name="vote" value="1">Stem op deze keuken</button>
								</form>
							</div>
						</div>
					</div>
					<div class="url">
						<p><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
"><?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
</a></p>
					</div>
					<div class="col first">
						<h3>Het verhaal achter de keuken van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
:</h3>
						<p><?php echo $this->_tpl_vars['entry']->getDescription(); ?>
</p>
					</div>
					<div class="col">
						<h3>Schakel de hulp van je vrienden in!</h3>
						<p>Plaats dit bericht op je Facebook wall, vraag mensen het te delen en op jouw inzending te stemmen.</p>
						<div class="fb-like" data-href="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-send="true" data-width="450" data-show-faces="true" data-font="arial"></div>
						<p>Verspreid de link onder je Twitter volgers en laat ze op jouw inzending stemmen.</p>
						<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en"  data-lang="en" data-url="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entry']->getId(); ?>
" data-text="Mijn keuken heeft wel een opknappertje nodig! Help mij door op mijn inzending te stemmen">Tweet</a> 
					</div>
					<div style="clear: both;"></div>
				</div>
			</div>
		</section>
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
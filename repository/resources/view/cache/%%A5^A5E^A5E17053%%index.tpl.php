<?php /* Smarty version 2.6.26, created on 2015-08-31 15:31:38
         compiled from front/keukens/index.tpl */ ?>
	<section id="overview">	
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-lg-12 content">
				<h1>Dit zijn de <span><?php echo $this->_tpl_vars['totalcount']; ?>
</span> deelnemers!</h1>
				<div class="sort">
					<h2>Sorteer op:</h2>
					<button id="name" class=""><span>Naam</span></button>
					<button id="date" class=""><span>Datum</span></button>
					<button id="votes" class="sort_down"><span>Stemmen</span></button>
				</div>
				<ul class="posts" id="entries">
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
							</div>
						</div>
					</li>
					<?php endforeach; endif; unset($_from); ?>
				</ul>
			</div>
		</div>
	</section>

		
	<script type="text/javascript">
		<?php echo '
		var counter = 30;
		var currentsort = "votesdown";
		$(function() {

			// Function to get rid of all up and down arrows
			function removeClasses() {
				$("#name").removeClass("sort_up sort_down");
				$("#date").removeClass("sort_up sort_down");
				$("#votes").removeClass("sort_up sort_down");
			}
			
			// Change the sorting behaviour when we click a sort button
			$(\'#name\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "keukens/fetch/nameup/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "nameup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "keukens/fetch/namedown/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "namedown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
			$(\'#date\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "keukens/fetch/dateup/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "dateup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "keukens/fetch/datedown/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "datedown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
			$(\'#votes\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "keukens/fetch/votesup/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "votesup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "keukens/fetch/votesdown/0/30"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 30;
					currentsort = "votesdown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
		});
		'; ?>

	</script>
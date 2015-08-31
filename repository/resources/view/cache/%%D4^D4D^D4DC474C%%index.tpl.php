<?php /* Smarty version 2.6.26, created on 2013-04-12 14:45:51
         compiled from front/inzendingen/index.tpl */ ?>
	<section id="latest_posts">
		<h2>Al <span><?php echo $this->_tpl_vars['totalcount']; ?>
</span> inzendingen!</h2>
		<div class="sort">
			<h2>Sorteer op:</h2>
			<button id="name" class=""><span>Naam</span></button>
			<button id="date" class="sort_down"><span>Datum</span></button>
			<button id="votes" class=""><span>Stemmen</span></button>
		</div>
		<ul class="posts" id="entries">
			<?php $_from = $this->_tpl_vars['entries']->getResult(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entry']):
?>
				<?php $this->assign('entryId', $this->_tpl_vars['entry']->getId()); ?>
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
								<form action="<?php echo $this->_tpl_vars['secure_root']; ?>
inzendingen/bekijken/<?php echo $this->_tpl_vars['entryId']; ?>
" method="post">
									<button type="submit" name="vote" value="1">Stemmen!</button>
								</form>
								<button>Neem een kijkje</button>
							</div>
						</div>
					</a>
				</li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
		<div id="more" class="more">...</div>
		<div style="clear:both;"></div>
	</section>
	
		
	<script type="text/javascript">
		<?php echo '
		var counter = 12;
		var currentsort = "datedown";
		$(function() {

			// Toggle the default and hover state of an item
			

			$("#latest_posts ul.posts li a").hover(function(){
				$(this).find(\'.hover\').fadeIn(100);
				},function(){
				$(this).find(\'.hover\').fadeOut(100);
			});

			// Function to get rid of all up and down arrows
			function removeClasses() {
				$("#name").removeClass("sort_up sort_down");
				$("#date").removeClass("sort_up sort_down");
				$("#votes").removeClass("sort_up sort_down");
			}
			
			// Load in more entries when we scroll to the bottom
			$(\'#more\').waypoint(function(direction) {
				if (direction == \'down\') {
 				$.ajax({
					url: "inzendingen/fetch/"+currentsort+"/"+counter+"/12"
					}).done(function(data) {
						$("#entries").append(data);
					});
					counter += 12;
				}
			}, { enabled: true,  offset: \'bottom-in-view\' });
			
			// Load in more entries when we click the more button
			$(\'.more\').click(function() {
				$.ajax({
					url: "inzendingen/fetch/"+currentsort+"/"+counter+"/12"
				}).done(function(data) {
					$("#entries").append(data);
				});
				counter += 12;
			});

			// Change the sorting behaviour when we click a sort button
			$(\'#name\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "inzendingen/fetch/nameup/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "nameup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "inzendingen/fetch/namedown/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "namedown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
			$(\'#date\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "inzendingen/fetch/dateup/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "dateup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "inzendingen/fetch/datedown/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "datedown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
			$(\'#votes\').click(function() {
				if ( $(this).hasClass(\'sort_down\') ) {
					$.ajax({
						url: "inzendingen/fetch/votesup/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "votesup";
					removeClasses();
					$(this).addClass(\'sort_up\');
				} else {
					$.ajax({
						url: "inzendingen/fetch/votesdown/0/12"
					}).done(function(data) {
						$("#entries").html(data);
					});
					counter = 12;
					currentsort = "votesdown";
					removeClasses();
					$(this).addClass(\'sort_down\');
				}
			});
		});
		'; ?>

	</script>
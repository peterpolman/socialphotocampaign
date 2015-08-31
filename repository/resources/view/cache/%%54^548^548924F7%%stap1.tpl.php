<?php /* Smarty version 2.6.26, created on 2013-04-05 10:01:36
         compiled from front/inzendingen/stap1.tpl */ ?>
	<section id="content">
		<div class="wrapper">
			<div class="content">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="col">
						<h2>Jouw foto</h2>
						<p>Stuur ons een foto van je keuken en ontvang direct een cadeaubon t.w.v. &euro; 25,-</p>
						<input type="file" name="picture[]" value="Mijn foto"/><br/>
					</div>
					<div class="col">
						<h2>Omschrijving:</h2>
						<p>Waarom heeft jouw keuken wel een opknappertje nodig?</p>
						<textarea name="description"><?php if (isset ( $this->_tpl_vars['description'] )): ?><?php echo $this->_tpl_vars['description']; ?>
<?php endif; ?></textarea><br/>
					</div>
					<div class="clear">
						<button type="submit">Verzenden</button>
					</div>
				</form>
			</div>
		</div>
	</section>
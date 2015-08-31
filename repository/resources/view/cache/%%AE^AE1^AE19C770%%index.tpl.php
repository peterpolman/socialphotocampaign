<?php /* Smarty version 2.6.26, created on 2013-04-29 18:43:19
         compiled from front/actiecode/index.tpl */ ?>
	<section id="content">
		<div class="wrapper">
			<div class="content">
				<h2>Actiecode verzilveren</h2>
				<p>Verzilver hier de &euro; 25,- korting op je aankoop bij I-KOOK! Zorg dat je alle gegevens correct invult, dan storten we zo snel mogelijk &euro; 25,- op je bankrekening. In ieder geval bedankt voor het meedoen en wie weet win je de keukenrenovatie t.w.v. &euro; 750,- ook nog!</p>
				<form action="" method="post">
					<div class="col">
						<table>
							<tr>
								<td>Naam:</td><td><input type="text" name="naam" <?php if (isset ( $this->_tpl_vars['naam'] )): ?>value="<?php echo $this->_tpl_vars['naam']; ?>
"<?php endif; ?>/></td>
							</tr>
							<tr>
								<td>E-mail:</td><td><input type="text" name="email" <?php if (isset ( $this->_tpl_vars['email'] )): ?>value="<?php echo $this->_tpl_vars['email']; ?>
"<?php endif; ?>/></td>
							</tr>
							<tr>
								<td>Telefoon:</td><td><input type="text" name="telefoon" <?php if (isset ( $this->_tpl_vars['telefoon'] )): ?>value="<?php echo $this->_tpl_vars['telefoon']; ?>
"<?php endif; ?>/></td>
							</tr>
						</table>
					</div>
					<div class="col">
						<table>
							<tr>
								<td>Actiecode:</td><td><input type="text" name="actiecode" <?php if (isset ( $this->_tpl_vars['actiecode'] )): ?>value="<?php echo $this->_tpl_vars['actiecode']; ?>
"<?php endif; ?>/></td>
							</tr>
							<tr>
								<td>Bankrekening:</td><td><input type="text" name="rekening" <?php if (isset ( $this->_tpl_vars['rekening'] )): ?>value="<?php echo $this->_tpl_vars['rekening']; ?>
"<?php endif; ?>/></td>
							</tr>
							<tr>
								<td>Ordernummer:</td><td><input type="text" name="ordernr" <?php if (isset ( $this->_tpl_vars['ordernr'] )): ?>value="<?php echo $this->_tpl_vars['ordernr']; ?>
"<?php endif; ?>/></td>
							</tr>
						</table>
					</div>
					<div class="clear">
						<button type="submit">Verzenden</button>
					</div>
				</form>
			</div>
		</div>
	</section>
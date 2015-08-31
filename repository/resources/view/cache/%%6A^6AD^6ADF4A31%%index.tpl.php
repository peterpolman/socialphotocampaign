<?php /* Smarty version 2.6.26, created on 2015-08-31 16:19:19
         compiled from front/contact/index.tpl */ ?>
	<article id="content" class="form">
		<div class="container">
			<div class="col-xs-12 col-sm-12 col-lg-12 content">
				<h2>Contact</h2>
				<p>Heb je vragen over de campagne of loop je tegen problemen aan tijdens het uploaden van je foto? Stuur dan even een berichtje via het contactformulier en we proberen je zo snel mogelijk verder te helpen.</p>
				<form action="" method="post">
					<div class="container">
						<div class="col-xs-12 col-sm-6 col-lg-6">
							<h3 style="text-align: left;">Jouw gegevens</h3>
							<table width="100%">
								<tr>
									<td>Voornaam: </td><td><input type="text" name="firstname" value="<?php if (isset ( $this->_tpl_vars['firstname'] )): ?><?php echo $this->_tpl_vars['firstname']; ?>
<?php endif; ?>"/></td>
								</tr>
								<tr>
									<td>Achternaam: </td><td><input type="text" name="lastname" value="<?php if (isset ( $this->_tpl_vars['lastname'] )): ?><?php echo $this->_tpl_vars['lastname']; ?>
<?php endif; ?>"/></td>
								</tr>
								<tr>
									<td>E-mail: </td><td><input type="text" name="email" value="<?php if (isset ( $this->_tpl_vars['email'] )): ?><?php echo $this->_tpl_vars['email']; ?>
<?php endif; ?>"/></td>
								</tr>
							</table>
						</div>
						<div class="col-xs-12 col-sm-6 col-lg-6">
							<h3 style="text-align: left;">Bericht</h3>
							<textarea name="message"><?php if (isset ( $this->_tpl_vars['message'] )): ?><?php echo $this->_tpl_vars['message']; ?>
<?php endif; ?></textarea>
						</div>
					</div>
					<div class="container">
						<button type="submit">Verzenden</button>
					</div>
				</form>
			</div>
		</div>
	</article>
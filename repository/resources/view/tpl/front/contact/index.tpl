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
									<td>Voornaam: </td><td><input type="text" name="firstname" value="{if isset($firstname)}{$firstname}{/if}"/></td>
								</tr>
								<tr>
									<td>Achternaam: </td><td><input type="text" name="lastname" value="{if isset($lastname)}{$lastname}{/if}"/></td>
								</tr>
								<tr>
									<td>E-mail: </td><td><input type="text" name="email" value="{if isset($email)}{$email}{/if}"/></td>
								</tr>
							</table>
						</div>
						<div class="col-xs-12 col-sm-6 col-lg-6">
							<h3 style="text-align: left;">Bericht</h3>
							<textarea name="message">{if isset($message)}{$message}{/if}</textarea>
						</div>
					</div>
					<div class="container">
						<button type="submit">Verzenden</button>
					</div>
				</form>
			</div>
		</div>
	</article>

<article id="content" class="form">
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-lg-12 content">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<h2>Jouw foto</h2>
					<img src="{$secure_root}cji/img/landscape.png" width="75" alt="" style="float: right; margin-right: 10%; margin-left: 10px;" />
					<p>Stuur ons een <span style="text-decoration: underline;">horizontale foto</span> foto van je <strong>keuken inbouwapparaat</strong> en omschrijf hiernaast waarom jouw apparatuur een opknappertje kan gebruiken.
					<p><span class="fileinput-button" data-role="button" data-icon="plus">
						<strong>Maak / upload een foto</strong>
						<input type="file" name="picture[]" value="Mijn foto" />
					</span></p>
				</div>
				<div class="col-xs-12 col-sm-6 col-lg-6">
					<h2>Omschrijving:</h2>
					<p>Waarom heeft jouw apparaat een opknappertje nodig?</p>
					<textarea name="description">{if isset($description)}{$description}{/if}</textarea><br/>
				</div>
				<button type="submit">Volgende stap...</button>
			</form>
		</div>
	</div>
</article>
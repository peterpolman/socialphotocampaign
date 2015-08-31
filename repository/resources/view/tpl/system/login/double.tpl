<h1>Double login</h1>

<div id="login_screen">
	
	<form method="post">
		
		<p>
			<label for="username">Gebruikersnaam1: </label>
			<input id="username" type="text" name="username1"/>
			<p>Tijdelijk ivm sessiebug</p>
		</p>
		
		<p>
			<label for="password">Wachtwoord1: </label>
			<input id="password" type="password" name="password1"/>
			<p>Tijdelijk ivm sessiebug</p>
		</p>
		
		<p>
			<label for="username">Gebruikersnaam2: </label>
			<input id="username" type="text" name="username2"/>
		</p>
		
		<p>
			<label for="password">Wachtwoord2: </label>
			<input id="password" type="password" name="password2"/>
		</p>
		
		<p>
			<input type="submit" value="Inloggen"/>
		</p>
		
	</form>
	<a href="{$secure_root}{$system}/login/lostpassword">Wachtwoord vergeten?</a>
</div>
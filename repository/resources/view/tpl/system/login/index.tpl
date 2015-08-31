<div id="login_screen">
	
	<form method="post">
		
		<p>
			<label for="username">Gebruikersnaam: </label>
			<input id="username" type="text" name="username"/>
		</p>
		
		<p>
			<label for="password">Wachtwoord: </label>
			<input id="password" type="password" name="password"/>
		</p>
		
		<p>
			<input type="submit" value="Inloggen"/>
		</p>
		
	</form>
	<a href="{$secure_root}{$system}/login/lostpassword">Wachtwoord vergeten?</a>
</div>
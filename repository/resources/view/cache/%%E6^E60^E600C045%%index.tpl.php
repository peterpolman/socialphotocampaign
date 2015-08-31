<?php /* Smarty version 2.6.26, created on 2015-08-31 15:56:23
         compiled from system/login/index.tpl */ ?>
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
	<a href="<?php echo $this->_tpl_vars['secure_root']; ?>
<?php echo $this->_tpl_vars['system']; ?>
/login/lostpassword">Wachtwoord vergeten?</a>
</div>
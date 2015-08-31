<h1>Mailing versturen</h1>

<p>Weet je heel zeker dat je onderstaande e-mail naar alle inzenders wilt versturen?</p>

<div class="mailing">{$mail}</div>

<form action="" method="post">
	<input type="hidden" name="winnaar" value="{$entry->getId()}"/>
	<input type="hidden" name="text" value="{$text}"/>
	<input type="submit" name="bevestig" value="Ja, verstuur deze mail"/>
</form>
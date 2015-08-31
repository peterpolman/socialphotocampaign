<h1>Mailing versturen</h1>

<p>U kunt een mailing versturen naar alle inzenders, om te informeren over de winnaar van de wedstrijd.</p>

<form action="" method="post">
	<h2>Kies een winnaar</h2>
	<select name="winnaar">
		{foreach from=$votes item=vote key=entry}
			{assign var=myEntry value=$entries[$entry]}
			<option value="{$entry}">{$myEntry.first_name} {$myEntry.last_name} -- {$vote} stem{if $vote!=1}men{/if}</option>
		{/foreach}
	</select>
	
	<h2>Begeleidende tekst</h2>
	<textarea name="text" rows="10" cols="60"></textarea><br/>
	
	<input type="submit" name="versturen" value="Versturen"/>
</form>
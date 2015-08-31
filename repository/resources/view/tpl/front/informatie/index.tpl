<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-lg-8 content">
			<h2>Wat moet je doen?</h2>
			<p>Als je kans wilt maken op de renovatiecheque hoef je slechts je persoonsgegevens in te vullen en een foto van je huidige keuken inbouwapparaat te uploaden. Je krijgt vervolgens een bevestigingsmail met tips om zoveel mogelijk stemmen voor jouw inzending in te zamelen.</p>
			<ul>
				<li>Stap 1: Upload je foto</li>
				<li>Stap 2: Vul je gegevens in</li>
				<li>Stap 3: Laat je vrienden op je inzending stemmen!</li>
			</ul>
			<p>Als je alles netjes hebt ingezonden zal je moeten zorgen dat er zoveel mogelijk vrienden en andere bekenden op jouw inzending gaan stemmen. Aan het einde van de actieperiode wordt de winnaar met de meeste stemmen via Facebook bekend gemaakt. Daarnaast belonen we de meest creatieve en originele inzending ook nog eens met een renovatiecheque t.w.v. &euro; 250,-. Een vakman van I-KOOK zal contact met je zoeken om een afspraak te maken.</p>
			<h2>Wat kun je winnen?</h2>
			<p>De winnaars van de actie ontvangen een renovatiecheque t.w.v. &euro; 250,-. Tijdens een afspraak met de lokale vakman van I-KOOK zal gekeken worden hoe deze het best kan worden besteed.</p>
			<p><img src="{$secure_root}cji/img/winnaars_opknappertje.png" width="100%" alt="" /><br />Winnaars van onze laatste keukenrenovatie actie.</p>
			<p>Vergeet ook niet onze Facebook pagina te liken! Zo blijf je op de hoogte van alle nieuwtjes tijdens de actieperiode en hier maken we uiteindelijk de winnaar bekend.</p>
			<div class="fb-like" data-href="http://www.facebook.com/ikookkeukens" data-send="false" data-width="350" data-show-faces="false" data-font="arial" data-colorscheme="light"></div>
			<p>Voor meer informatie leest u de <a href="{$secure_root}cji/files/actievoorwaarden.pdf">actievoorwaarden</a>.</p>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<section id="top-5">
				<header class="heading"><h1>De Top 5!</h1></header>
				<article>
					<ul>
						{foreach from=$topEntries->getResult() item=topEntry}
						{assign var=entryId value=$topEntry->getId()}
						<li>
							<div class="picture">
								<img width="65" src="{$secure_root}files/small/{$topEntry->getFilename()}" alt="{$topEntry->getFirst_name()} {$topEntry->getLast_name()}" />
							</div>
							<div class="vote-count">
								{$topEntry->getTotal_vote_count()}
							</div>
							<p class="username">
								<a href="{$secure_root}keukens/opknapper/{$entryId}">{$topEntry->getFirst_name()}</a>
							</p>
							<p class="location">
								{$topEntry->getPlace()}
							</p>
						</li>
						{/foreach}
					</ul>
				</article>
			</section>
		</div>
	</div>
</article>

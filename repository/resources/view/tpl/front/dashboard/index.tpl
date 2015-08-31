<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-6 col-lg-8 content">
			<img class="hoofdprijs" src="cji/img/hoofdprijs.png" alt="">
			<h2>Knap je keuken op!</h2>
			<p><strong>Heeft je vaatwasser het begeven? Krijg je die oude oven echt niet meer schoon? Of ben je gewoon toe aan nieuwe keuken?</strong></p>
			<p>Misschien is het dan wel tijd voor een keukenrenovatie! I-KOOK geeft namelijk iedere actieperiode 1 renovatiecheque t.w.v. € 750,- weg!  </p>
			<p><a href="{$secure_root}keukens/doemee">Volg de stappen en doe mee</a></p>
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
								{$topVotes.$entryId}
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
<section id="overview">	
	<div class="container">
		<h1>De laatste deelnemers</h1>
		<ul>
			{foreach from=$lastEntries->getResult() item=entry}
			{assign var=entryId value=$entry->getId()}
			<li class="col-xs-12 col-sm-4 col-lg-3">
				<div class="wrapper">
					<div class="front">
						<div class="picture">
							<img src="{$secure_root}files/medium/{$entry->getFilename()}" alt="" />
						</div>
						<div class="vote-count">
							{$votes.$entryId}
						</div>
						<p class="username">
							{$entry->getFirst_name()}
						</p>
						<p class="location">
							{$entry->getPlace()}
						</p>
					</div>
					<div class="back">
						<p class="username">
							<a href="{$secure_root}keukens/opknapper/{$entryId}">Stem op {$entry->getFirst_name()} uit<br />{$entry->getPlace()}</a>
						</p>
						<div class="vote">
							<a href="{$secure_root}keukens/opknapper/{$entryId}"><img src="{$secure_root}/cji/img/vote-heart.png" alt="" /></a>
						</div>
						<p class="vote-count">
							{$votes.$entryId} stemmen verzameld
						</p>
						<div class="fb-like" data-href="{$secure_root}keukens/opknapper/{$entry->getId()}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
					</div>
				</div>
			</li>
			{/foreach}
		</ul>
	</div>
</section>

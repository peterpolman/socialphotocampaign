<section id="photo">
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-lg-12 content">
				<div class="header">
					<img src="{$secure_root}files/large/{$entry->getFilename()}" alt="" />
				</div>

				<div class="url">
					Dit is jouw link: <a href="{$secure_root}keukens/opknapper/{$entry->getId()}"><strong>{$secure_root}keukens/opknapper/{$entry->getId()}</strong></a>
				</div>
			</div>
		</div>
	</div>
	<div class="container ads">
		<div class="col-xs-12 col-sm-6 col-lg-6 content">
			<a class="ad" href="http://www.i-kook.nl/keukens-kijken/collectie-keukens/tot-%E2%82%AC2000" target="_blank">	<img src="{$secure_root}cji/img/2013_keukens-onder-2000.jpg" alt="" />
			</a>
		</div>
		<div class="col-xs-12 col-sm-6 col-lg-6 content">
			<a class="ad" href="http://www.i-kook.nl/catalog/apparatuur" target="_blank">
				<img src="{$secure_root}cji/img/2013_altijd-op-voorraad_(app).jpg" alt="" />
			</a>
		</div>
	</div>
</section>

<article id="content">
	<div class="container">
		<div class="col-xs-12 col-sm-4 col-lg-4 content">
			<h3>Het verhaal achter de keuken van: <br /><span>{$entry->getFirst_name()} {$entry->getLast_name()}</span></h3>
			<p><i>{$entry->getDescription()}</i></p>
		</div>
		<div class="col-xs-12 col-sm-4 col-lg-4 content">
			<h3>Wil je {$entry->getFirst_name()} helpen met het verzamelen van stemmen?</h3>
				<p><a class="share" href="http://www.facebook.com/sharer.php?u={$secure_root}keukens/opknapper/{$entry->getId()}" target="_blank"><img src="{$secure_root}cji/img/share-facebook.png" height="40" alt="" /></a>
				<p>Gebruik de bovenstaande knop om de link van {$entry->getFirst_name()} op je Facebook tijdlijn te plaatsen. Zo roep je niet alleen de vrienden van {$entry->getFirst_name()}, maar ook jouw vrienden op om mee te helpen.</p>
		</div>
		<div class="col-xs-12 col-sm-4 col-lg-4">
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
<section id="comments">
	<div class="container">
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<h2>Wens {$entry->getFirst_name()} succes!</h2>
			<div class="fb-comments" data-href="http://www.opknappertjenodig.nl/keukens/opknapper/{$entry->getId()}" data-width="650" data-num-posts="10"></div>
		</div>
	</div>
</section>
{literal}
	<script>
	(function(){
		$("#content .submission").hover(function(){
			$(this).find('.hover').fadeIn(100);
			},function(){
			$(this).find('.hover').fadeOut(100);
		});
	}(document));



	</script>
{/literal}

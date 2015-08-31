{foreach from=$entries->getResult() item=entry}
{assign var=entryId value=$entry->getId()}
<li class="col-xs-12 col-sm-4 col-lg-3">
	<div class="wrapper">
		<div class="front">
			<div class="picture">
				<img src="{$secure_root}files/medium/{$entry->getFilename()}" alt="" />
			</div>
			<div class="vote-count">
				{$entry->getTotal_vote_count()}
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
				{$entry->getTotal_vote_count()} stemmen verzameld
			</p>
			<div class="fb-like" data-href="{$secure_root}keukens/opknapper/{$entry->getId()}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
		</div>
	</div>
</li>
{/foreach}
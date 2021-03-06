<?php
if ($teaser) {
?>
<div class="contribution">
  <a href="<?php print $variables['node_url']; ?>">
		<div class="picture" style="background-image: url(<?php print $variables['contribution']['image']; ?>);">

		</div>
    <div class="vote-count">
      <?php print $variables['contribution']['vote_count']; ?>
    </div>
    <?php if (!empty($variables['user_profile']['first_name'])) :?>
		<span class="username"><?php print $variables['user_profile']['first_name']; ?><br />
    <?php endif; ?>
    <?php if (!empty($variables['user_profile']['city'])) :?>
    </span>
    <span class="location"><?php print $variables['user_profile']['city']; ?></span>
    <?php endif; ?>
  </a>
</div>
<?php
} else {
  $links = '';
  if ($user->uid == $variables['uid']) :
?>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="/node/<?php print $variables['nid']; ?>/edit">Bewerken</a></li>
    <?php if ($variables['campaign_status'] == 'voting') : ?>
      <li><a href="<?php print $variables['contribution']['fb_share_link']; ?>">Delen</a></li>
    <?php endif; ?>
    <li><a href="/node/<?php print $variables['nid']; ?>/delete">Verwijderen</a></li>
  </ul>
</div>
<?php
  endif;
?>
<h3>Het verhaal achter de keuken van: <br><span>
  <?php print $variables['user_profile']['first_name']; ?>
  <?php print $variables['user_profile']['last_name']; ?>
  </span>
 </h3>
<p><i><?php print $variables['contribution']['body']; ?></i></p>

<?php if ($variables['campaign_status'] == 'signup') : ?>
  <p><i><strong>Let op! Je kunt stemmen vanaf <?php print $variables['campaign_voting_start']; ?></strong></i></p>
<?php endif; ?>

<?php if ($variables['campaign_status'] == 'voting') : ?>
  <h3>Wil je <?php print $variables['user_profile']['first_name']; ?> helpen met het verzamelen van stemmen?</h3>
  <p><a class="btn btn-facebook" href="<?php print $variables['contribution']['fb_share_link']; ?>" target="_blank">Deel op Facebook!</a>
  </p><p>Gebruik de bovenstaande knop om de link van <?php print $variables['user_profile']['first_name']; ?> op je Facebook tijdlijn te plaatsen. Zo roep je niet alleen de vrienden van <?php print $variables['user_profile']['first_name']; ?>, maar ook jouw vrienden op om mee te helpen.</p>
<?php endif; ?>

<?php
}
?>

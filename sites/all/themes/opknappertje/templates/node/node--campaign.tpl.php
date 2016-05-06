<?php if ($teaser) { ?>
<a href="<?php print $variables['node_url']; ?>" class="campaign media <?php print $variables['campaign_info']['status']; ?>">
  <div class="media-left">
    <div class="date">
      <div class="month">
        <?php print date('M',$variables['field_date'][0]['value2']); ?>
      </div>
      <div class="day">
        <?php print date('d',$variables['field_date'][0]['value2']); ?>
      </div>
    </div>
  </div>
  <div class="media-body">
    <h3><?php print $title; ?></h3>
    <p><?php print $variables['campaign_info']['message']; ?></p>
  </div>
</a>
<?php } else { ?>
<div class="grid">
<?php
  if (!empty($variables['contributions'])) :
    foreach ($variables['contributions'] as $contribution) :
?>
<div class="contribution col-xs-12 col-sm-4 col-md-3" data-created="<?php print $contribution['created']; ?>" data-name="<?php print $contribution['first_name']; ?>" data-votecount="<?php print $contribution['vote_count']; ?>">
  <a href="<?php print $contribution['path']; ?>">
		<div class="picture" style="background-image: url(<?php print $contribution['image_url']; ?>);"></div>
    <div class="vote-count"><?php print $contribution['vote_count']; ?></div>
    <span class="username"><?php print $contribution['first_name']; ?><br></span>
    <span class="location"><?php print $contribution['city']; ?></span>
  </a>
</div>
<?php
    endforeach;
  endif;
}
?>
</div>

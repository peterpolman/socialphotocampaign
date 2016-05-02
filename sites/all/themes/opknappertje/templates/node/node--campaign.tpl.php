<?php if ($teaser) { ?>
<a href="<?php print $variables['node_url']; ?>" class="campaign media">
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

<button class="btn sort-by-name" data-sort-value="name">Sort by name</button>
<button class="btn sort-by-votes" data-sort-value="votes">Sort by votes</button>
<button class="btn sort-by-created" data-sort-value="created">Sort by date</button>

<div class="grid">
<?php
  if (!empty($variables['contributions'])) :
    foreach ($variables['contributions'] as $contribution) :
?>
<div class="contribution col-xs-12 col-sm-4 col-md-3">
  <a href="<?php print $contribution['path']; ?>">
		<div class="picture" style="background-image: url(<?php print $contribution['image_url']; ?>);"></div>
    <div class="vote-count"><?php print $contribution['vote_count']; ?></div>
    <span class="username"><?php print $contribution['first_name']; ?><br></span>
    <span class="location"><?php print $contribution['city']; ?></span>
    <span class="created"><?php print $contribution['created']; ?></span>
  </a>
</div>
<?php
    endforeach;
  endif;
}
?>
</div>

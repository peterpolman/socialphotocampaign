<!DOCTYPE html>
<html<?php print $html_attributes;?><?php print $rdf_namespaces;?>>
<head>
  <link rel="profile" href="<?php print $grddl_profile; ?>" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <!-- HTML5 element support for IE6-8 -->
  <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <?php print $scripts; ?>
</head>
<body<?php print $body_attributes; ?>>
  <div id="blobs">
  	<div id="blob0" class="hidden-xs"></div>
  	<div id="blob1" class="hidden-xs"></div>
  	<div id="blob2" class="hidden-xs"></div>
  	<div id="blob3" class="hidden-xs"></div>
  	<div id="blob4" class="hidden-xs"></div>

  	<div id="blob5" class="hidden-xs"></div>
  	<div id="blob6" class="hidden-xs"></div>
  	<div id="blob7" class="hidden-xs"></div>
  	<div id="blob8" class="hidden-xs"></div>
  	<div id="blob9" class="hidden-xs"></div>
  </div>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  <script src="https://npmcdn.com/isotope-layout@3.0/dist/isotope.pkgd.min.js"></script>
</body>
</html>

<?php /* Smarty version 2.6.26, created on 2015-08-31 10:28:39
         compiled from front/layout/header.tpl */ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

		<?php if ($this->_tpl_vars['controller'] == 'keukens' && $this->_tpl_vars['action'] == 'opknapper'): ?>
		<title>I-KOOK - Een kijkje in de keuken van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</title>

		<meta property="og:image" content="<?php echo $this->_tpl_vars['secure_root']; ?>
files/medium/<?php echo $this->_tpl_vars['entry']->getFilename(); ?>
" \>
		<meta property="og:title" content="Help <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 met het winnen van de I-KOOK Renovatiecheque t.w.v. &euro; 250,-!" />
		<meta property="og:description" content="<?php echo $this->_tpl_vars['entry']->getDescription(); ?>
" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $_SERVER['REQUEST_URI']; ?>
" />

		<?php else: ?>
		<title>I-KOOK - "Opknappertje nodig?"</title>
		<meta property="og:image" content="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/fb_meta.png" />
		<meta property="og:title" content="I-KOOK - Heeft je keuken ook een opknappertje nodig?" />
		<meta property="og:description" content="Doe mee en win een I-KOOK Renovatiecheque t.w.v. &euro; 250,-!" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST']; ?>
<?php echo $_SERVER['REQUEST_URI']; ?>
" />

		<?php endif; ?>
		<meta property="fb:app_id" content="177969065690482" />
		<link rel="icon" type="image/x-icon" href="<?php echo $this->_tpl_vars['secure_root']; ?>
favicon.ico">
			<!--[if IE]>
			<link rel="stylesheet" type="text/css" href="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/css/ie.css" />
		<![endif]-->
		<link href="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/css/bootstrap.min.css" rel="stylesheet">
    	<link href="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/css/style.css" rel="stylesheet">
	
		<?php echo '
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push([\'_setAccount\', \'UA-40578204-1\']);
		  _gaq.push([\'_trackPageview\']);

		  (function() {
		    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
		    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
		    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		'; ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/js/bootstrap.min.js"></script>
    	<script src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/js/jquery-ui-1.9.0.custom.min.js"></script>
    	<script src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/js/base.js"></script>
	</head>
	<body class="<?php echo $this->_tpl_vars['controller']; ?>
 <?php echo $this->_tpl_vars['action']; ?>
">
	
	<div id="fb-root"></div>

	<?php echo '
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&appId=177969065690482&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>
'; ?>

	<img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/fb_meta.png" alt="Opknappertje nodig?" style="display: none;"/>
	
	<img id="blob0" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo00.png" data-offset="" alt="" />
	<img id="blob1" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo01.png" data-offset="" alt="" />
	<img id="blob2" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo02.png" data-offset="" alt="" />
	<img id="blob3" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo03.png" data-offset="" alt="" />
	<img id="blob4" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo04.png" data-offset="" alt="" />
	<img id="blob5" src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/photo05.png" data-offset="" alt="" />

  	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	  	<div class="top-bar"></div>
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="<?php echo $this->_tpl_vars['secure_root']; ?>
cji/img/logo.png" alt=""></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li <?php if ($this->_tpl_vars['controller'] == 'dashboard'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
">Home</a></li>
					<li <?php if ($this->_tpl_vars['controller'] == 'informatie'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
informatie">Informatie</a></li>
					<li <?php if ($this->_tpl_vars['controller'] == 'keukens' && $this->_tpl_vars['action'] == 'doemee'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/doemee">Doe mee!</a></li>
					<li <?php if ($this->_tpl_vars['controller'] == 'keukens' && $this->_tpl_vars['action'] == 'index'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens">Deelnemers</a></li>
					<li <?php if ($this->_tpl_vars['controller'] == 'contact'): ?>class="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
contact">Contact</a></li>
				</ul>
			</div>
		</div>
    </nav>
    <header id="cta">
    	<div class="wrapper">
			<div class="container">
				<div class="col-xs-12 col-sm-2 col-lg-2">

				</div>
				<div class="col-xs-12 col-sm-8 col-lg-8">
					<?php if ($this->_tpl_vars['controller'] == 'keukens' && $this->_tpl_vars['action'] == 'opknapper'): ?>
						<h1 class="user">De inzending van<br /><span><?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 <?php echo $this->_tpl_vars['entry']->getLast_name(); ?>
</span></h1>
						<div class="vote">
							<p>Stem op de inzending van <?php echo $this->_tpl_vars['entry']->getFirst_name(); ?>
 en bevestig je stem via je e-mail</p>

							<form method="post" action="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/stem/">
								<input id="voteEmail" type="text" name="vote[email]" placeholder="E-mail adres" />
								<button id="voteButton" type="submit" class="button" name="submitVote" >Stem verzenden!</button>
								<input id="voteEntry" type="hidden" name="vote[entryId]" value="<?php echo $this->_tpl_vars['entry']->getId(); ?>
" />
								<small>* we gebruiken dit adres alleen om de stem te bevestigen</small>
							</form>
						</div>

					<?php else: ?>
						<h1>Knap je keuken op!</h1>
						<p>Maak een foto van je inbouwapparaat en maak kans op een checque t.w.v. &euro; 250,-</p>
						<ul><li><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens/doemee" class="button">Doe direct mee!</a></li><li><a href="<?php echo $this->_tpl_vars['secure_root']; ?>
keukens" class="button">De deelnemers</a></li></ul>
					<?php endif; ?>
				</div>
				<div class="col-xs-12 col-sm-2 col-lg-2">
					
				</div>
			</div>
		</div>
		<?php if ($this->_tpl_vars['flash'] != ''): ?>
		<script type="text/javascript" >
		<?php echo '
			$(document).ready(function(){
				setTimeout(function(){
					$(\'#flash\').animate({opacity: \'hide\', height: \'hide\', marginTop: \'hide\', marginBottom: \'hide\', paddingTop: \'hide\', paddingBottom: \'hide\'}, 500,\'swing\',function() {
							$("#flash").remove();
					});
				}, 6000);
			});
		'; ?>

		</script>
		<div align="center"><div id="flash" class='flash<?php echo $this->_tpl_vars['flash']['type']; ?>
'><?php echo $this->_tpl_vars['flash']['message']; ?>
</div></div>
		<?php endif; ?>

	</header>
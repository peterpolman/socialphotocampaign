<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

		{if $controller == "keukens" && $action == "opknapper"}
		<title>I-KOOK - Een kijkje in de keuken van {$entry->getFirst_name()} {$entry->getLast_name()}</title>

		<meta property="og:image" content="{$secure_root}files/medium/{$entry->getFilename()}" \>
		<meta property="og:title" content="Help {$entry->getFirst_name()} met het winnen van de I-KOOK Renovatiecheque t.w.v. &euro; 250,-!" />
		<meta property="og:description" content="{$entry->getDescription()}" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" />

		{else}
		<title>I-KOOK - "Opknappertje nodig?"</title>
		<meta property="og:image" content="{$secure_root}cji/img/fb_meta.png" />
		<meta property="og:title" content="I-KOOK - Heeft je keuken ook een opknappertje nodig?" />
		<meta property="og:description" content="Doe mee en win een I-KOOK Renovatiecheque t.w.v. &euro; 250,-!" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" />

		{/if}
		<meta property="fb:app_id" content="177969065690482" />
		<link rel="icon" type="image/x-icon" href="{$secure_root}favicon.ico">
			<!--[if IE]>
			<link rel="stylesheet" type="text/css" href="{$secure_root}cji/css/ie.css" />
		<![endif]-->
		<link href="{$secure_root}cji/css/bootstrap.min.css" rel="stylesheet">
    	<link href="{$secure_root}cji/css/style.css" rel="stylesheet">
	
		{literal}
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-40578204-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		{/literal}
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    	<script src="{$secure_root}cji/js/bootstrap.min.js"></script>
    	<script src="{$secure_root}cji/js/jquery-ui-1.9.0.custom.min.js"></script>
    	<script src="{$secure_root}cji/js/base.js"></script>
	</head>
	<body class="{$controller} {$action}">
	
	<div id="fb-root"></div>

	{literal}
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&appId=177969065690482&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
{/literal}
	<img src="{$secure_root}cji/img/fb_meta.png" alt="Opknappertje nodig?" style="display: none;"/>
	
	<img id="blob0" src="{$secure_root}cji/img/photo00.png" data-offset="" alt="" />
	<img id="blob1" src="{$secure_root}cji/img/photo01.png" data-offset="" alt="" />
	<img id="blob2" src="{$secure_root}cji/img/photo02.png" data-offset="" alt="" />
	<img id="blob3" src="{$secure_root}cji/img/photo03.png" data-offset="" alt="" />
	<img id="blob4" src="{$secure_root}cji/img/photo04.png" data-offset="" alt="" />
	<img id="blob5" src="{$secure_root}cji/img/photo05.png" data-offset="" alt="" />

  	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><img src="{$secure_root}cji/img/logo.png" alt=""></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li {if $controller == "dashboard"}class="active"{/if}><a href="{$secure_root}">Home</a></li>
					<li {if $controller == "informatie"}class="active"{/if}><a href="{$secure_root}informatie">Informatie</a></li>
					<li {if $controller == "keukens" && $action == "doemee"}class="active"{/if}><a href="{$secure_root}keukens/doemee">Doe mee!</a></li>
					<li {if $controller == "keukens" && $action == "index"}class="active"{/if}><a href="{$secure_root}keukens">Deelnemers</a></li>
					<li {if $controller == "contact"}class="active"{/if}><a href="{$secure_root}contact">Contact</a></li>
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
					{if $controller == "keukens" && $action == "opknapper"}
						<h1 class="user">De inzending van<br /><span>{$entry->getFirst_name()} {$entry->getLast_name()}</span></h1>
						<div class="vote">
							<p>Stem op de inzending van {$entry->getFirst_name()} en bevestig je stem via je e-mail</p>

							<form method="post" action="{$secure_root}keukens/stem/">
								<input id="voteEmail" type="text" name="vote[email]" placeholder="E-mail adres" />
								<button id="voteButton" type="submit" class="button" name="submitVote" >Stem verzenden!</button>
								<input id="voteEntry" type="hidden" name="vote[entryId]" value="{$entry->getId()}" />
								<small>* we gebruiken dit adres alleen om de stem te bevestigen</small>
							</form>
						</div>

					{else}
						<h1>Knap je keuken op!</h1>
						<p>Maak een foto van je inbouwapparaat en maak kans op een checque t.w.v. &euro; 250,-</p>
						<ul><li><a href="{$secure_root}keukens/doemee" class="button">Doe direct mee!</a></li><li><a href="{$secure_root}keukens" class="button">De deelnemers</a></li></ul>
					{/if}
				</div>
				<div class="col-xs-12 col-sm-2 col-lg-2">
					
				</div>
			</div>
		</div>
		{if $flash != ''}
		<script type="text/javascript" >
		{literal}
			$(document).ready(function(){
				setTimeout(function(){
					$('#flash').animate({opacity: 'hide', height: 'hide', marginTop: 'hide', marginBottom: 'hide', paddingTop: 'hide', paddingBottom: 'hide'}, 500,'swing',function() {
							$("#flash").remove();
					});
				}, 6000);
			});
		{/literal}
		</script>
		<div align="center"><div id="flash" class='flash{$flash.type}'>{$flash.message}</div></div>
		{/if}

	</header>

<!DOCTYPE html>
<html>
<head>
	<?php include($location . '/inc/head.tpl'); ?>
</head>
<body>

<script type="text/javascript">
if ("undefined" == typeof jQuery) {
	var psxUrl = location.href;
	var pos = psxUrl.indexOf('index.php');
	if (pos != -1) {
		psxUrl = psxUrl.substr(0, pos);
	}

	if (psxUrl.charAt(psxUrl.length - 1) == '/') {
		psxUrl = psxUrl.substr(0, psxUrl.length - 1);
	}

	document.write('<div><b>Warning: It looks like the project was not correctly configured. Please open the file configuration.php and change the key <code>"psx_url"</code> to: <code>"' + psxUrl + '"</code>.</b></div>');
}
</script>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<header class="psx-header">
				<div class="media">
					<a class="pull-left" href="#">
						<img src="<?php echo $base ?>/img/logo.png" alt="logo" class="media-object" />
					</a>
					<div class="media-body">
						<h2 class="media-heading"><a href="<?php echo $url ?>">PSX Framework</a></h2>
						<small>A framework to build RESTful APIs</small>
					</div>
				</div>
			</header>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<nav class="psx-navigation">
				<ul>
					<li><a href="<?php echo $router->getUrl('Sample\Welcome\Application\Index'); ?>">Getting started</a></li>
					<li><a href="<?php echo $router->getUrl('Sample\Api\InternetPopulation\Endpoint\Collection'); ?>">Api</a></li>
					<li><a href="<?php echo $router->getUrl('PSX\Controller\Tool\ToolController'); ?>">Tools</a></li>
					<li><a href="http://phpsx.org/doc">Documentation</a></li>
				</ul>
			</nav>
		</div>
		<div class="col-md-10">
			<div class="psx-content">
				<p><?php echo $message; ?></p>

				<p>This application has an example <a href="<?php echo $router->getUrl('Sample\Api\InternetPopulation\Endpoint\Collection'); ?>">API</a>
				endpoint wich showcases some features of PSX. Also there are some 
				<a href="<?php echo $router->getUrl('PSX\Controller\Tool\ToolController'); ?>">tools</a> 
				installed which i.e. can automatically generate a documentation 
				or an WSDL/Swagger definition for the API. In the following a short 
				description about each tool:</p>

				<dl>
					<?php foreach($links as $link): ?>
					<dt><a href="<?php echo $link['href']; ?>"><?php echo ucfirst($link['rel']); ?></a></dt>
					<dd><?php echo $link['meta']; ?></dd>
					<?php endforeach; ?>
				</dl>

				<p>More informations about PSX at:</p>
				<dl>
					<dt>Website</dt>
					<dd><a href="http://phpsx.org">http://phpsx.org</a></dd>
					<dt>Github</dt>
					<dd><a href="https://github.com/k42b3/psx">https://github.com/k42b3/psx</a></dd>
				</dl>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<footer class="psx-footer">
				<address>powered by <a href="http://phpsx.org">PSX</a> version <?php echo \PSX\Base::getVersion(); ?></address>
			</footer>
		</div>
	</div>
</div>

</body>
</html>

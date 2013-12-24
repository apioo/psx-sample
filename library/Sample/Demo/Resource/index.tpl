<!DOCTYPE html>
<html>
<head>
	<title>PSX Sample</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="generator" content="psx" />
	<link rel="icon" href="<?php echo $base; ?>/img/favicon.ico" type="image/x-icon" />
	<link href="<?php echo $base; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?php echo $base; ?>/css/default.css" rel="stylesheet" media="screen" />
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="<?php echo $base; ?>/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php include($location . '/inc/header.tpl'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h3>Welcome,</h3>
			<p>This is an PSX sample application. It should help to bootstrap a
			project by providing all needed files and some examples. You can 
			install this sample through composer:</p>

			<pre>php composer.phar create-project psx/sample .</pre>

			<p>This sample application has an <a href="<?php echo $url . 'api'; ?>">API</a>
			endpoint wich showcases some features of PSX howto easily build an 
			REST API. The API supports the following query GET parameters:</p>
			<dl>
				<dt>format</dt>
				<dd><code>xml</code>|<code>json</code>|<code>jsonp</code>|<code>atom</code></dd>
				<dt>fields</dt>
				<dd>A comma seperated list of fields wich should be selected</dd>
				<dt>startIndex</dt>
				<dd>Where to start in the resultset</dd>
				<dt>count</dt>
				<dd>The maximum number of entries</dd>
				<dt>sortBy</dt>
				<dd>The field after wich the resultset is sorted</dd>
				<dt>sortOrder</dt>
				<dd><code>ascending</code>|<code>descending</code></dd>
				<dt>filterBy</dt>
				<dd>The filter is applied on the given column</dd>
				<dt>filterOp</dt>
				<dd><code>contains</code>|<code>equals</code>|<code>startsWith</code>|<code>present</code></dd>
				<dt>filterValue</dt>
				<dd>The filter value</dd>
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

	<div class="row">
		<div class="col-md-12">
			<?php include($location . '/inc/footer.tpl'); ?>
		</div>
	</div>
</div>

</body>
</html>

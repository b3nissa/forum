<!DOCTYPE html>
<?php
defined('_JEXEC') or die;
// EDDY prevent Clickjacking
header('X-Frame-Options: SAMEORIGIN');
// JHtml::_('behavior.framework', true);
$app = JFactory::getApplication();
JHtml::_('bootstrap.loadCss', TRUE, JFactory::getDocument()->direction);
JHtml::_('behavior.framework', TRUE);
JHtml::_('bootstrap.framework');
?>
<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<html lang="nl-nl" dir="ltr">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
<jdoc:include type="head" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/custom.css" rel="stylesheet">
</head>

<body class="body">
	<div class="top-bar">
<div class="container">
	<?php if($this->countModules('topleft')) { ?>
		<jdoc:include type="modules" name="topleft" style="raw" />
	<?php } ?>
	<?php if($this->countModules('topright')) { ?>
		<jdoc:include type="modules" name="topright" style="raw" />
	<?php } ?>
</div>
</div>
		</div>
<div class="container">
	<?php if($this->countModules('header')) { ?>
		<jdoc:include type="modules" name="header" style="raw" />
			</div>
	<?php } ?>
	<?php if($this->countModules('mainmenu')) { ?>
		<div class="ommenu">
			<div class="container">
				<jdoc:include type="modules" name="mainmenu" style="raw" />
			</div>
	</div>
	<?php } ?>
<?php if($this->countModules('showcase')) { ?>
	<div class="omshowcase-wrapper">
<div class="omshowcase">
	<jdoc:include type="modules" name="showcase" style="raw" />
</div>

</div>
<?php } ?>

<?php if($this->countModules('usps')) { ?>
	<div class="omusps">
		<div class="container">
			<jdoc:include type="modules" name="usps" style="raw" />
		</div>
	</div>
<?php } ?>


<div class="container">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</div>
<?php if($this->countModules('ondercontent01')) { ?>
<div class="container">
	<jdoc:include type="modules" name="ondercontent01" style="raw" />
</div>
<?php } ?>
</div>

<?php if($this->countModules('ondercontent02')) { ?>
	<jdoc:include type="modules" name="ondercontent02" style="raw" />
<?php } ?>

	<?php if($this->countModules('footer')) { ?>
		<jdoc:include type="modules" name="footer" style="raw" />
	<?php } ?>
</div>

	<div class="copyrightregel">
		<div class="container">
			Copyright &copy; <?php echo date("Y"); ?> GekOpHout.com &nbsp;&nbsp; Marketing & Webdevelopment door <a href="/colofon/">Webdelta</a></div>
	<?php if($this->countModules('debug')) { ?>
	<div id="debug">
	<jdoc:include type="modules" name="debug" />
	</div>
	<?php } ?>
		</div>
</div>
<script defer src="/templates/<?php echo $this->template; ?>/js/script.js"></script>
</body>
</html>

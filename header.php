<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php wp_head() ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo get_bloginfo("name"); ?></title>
</head>
<body>
<div id="wrapper">
	<div id="wrapper-bgbtm">
		<div id="header">
			<div id="logo">
				<h1><a href="<?php echo home_url();?>">Wood Working </a></h1>
				<p>template design by <a href="http://www.freecsstemplates.org/" rel="nofollow">FreeCSSTemplates.org</a></p>
			</div>
		</div>
		<!-- end #header -->
		<div id="menu">
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
		</div>
		<!-- end #menu -->
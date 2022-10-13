<?php
/**
 * Header template (header.php)
 * @package WordPress
 * @subpackage new-clean-template-3
 * @author DHL
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php /* RSS and other */ ?>
	<link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
	<link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php wp_head(); ?>
	
</head>
<body <?php body_class(); ?>>

	<header class="header">
		<div class="container">
			<a href="/" class="logo">
    	        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg">
    	    </a>
    	    <nav>
				<?php
					wp_nav_menu([
                    	'menu_class' => 'menu-ul'
					]);
				?>
    	    </nav>
    	    <div class="menu-btn">
    	        <div class="menu-btn__item"></div>
    	        <div class="menu-btn__item"></div>
    	        <div class="menu-btn__item"></div>
    	    </div>
		</div>
	</header>
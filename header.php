<!DOCTYPE html>
<html <?php echo get_language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo wp_get_document_title(); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- 
	====================================================================
		DEVELOPED BY DimaWide (dimawide.io)
	====================================================================
	 -->
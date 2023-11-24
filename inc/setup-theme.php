<?php


/*
* Enqueueing Styles & Scripts
*/
function wcl_theme_enqueue_scripts() {
	//wp_deregister_script('jquery');

	wp_enqueue_style('swiper',  get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), WCL_THEME_VERSION);
	wp_enqueue_script('swiper',  get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), WCL_THEME_VERSION, true);

	wp_enqueue_style('wcl-custom-style', get_template_directory_uri() . '/css/wcl-style.min.css', array(), WCL_THEME_VERSION);
	wp_enqueue_script('wcl-functions-js', get_template_directory_uri() . '/js/wcl-functions.js', array(), WCL_THEME_VERSION, true);

	wp_localize_script('wcl-functions-js', 'wcl_obj', array(
		'ajax_url'     => admin_url('admin-ajax.php'),
		'site_url'     => site_url('/'),
		'template_url' => get_template_directory_uri(),
	));
}
add_action('wp_enqueue_scripts', 'wcl_theme_enqueue_scripts');



/*
* Enqueueing Styles & Scripts To Admin Panel
*/
function wcl_admin_enqueue_scripts($hook) {
	wp_enqueue_style('wcl-admin-style', get_template_directory_uri() . '/css/wcl-admin-style.min.css', array(), WCL_THEME_VERSION);
}

add_action('admin_enqueue_scripts', 'wcl_admin_enqueue_scripts');



/*
* Remove Gutenberg Block Library CSS from loading on the frontend
*/
function wcl_remove_wp_block_library_css() {
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('global-styles');
}
add_action('wp_enqueue_scripts', 'wcl_remove_wp_block_library_css', 100);



/*
* Remove default image sizes options
*/
function wcl_disable_unused_image_sizes($sizes) {

	unset($sizes['thumbnail']);    // disable thumbnail size
	unset($sizes['medium']);       // disable medium size
	unset($sizes['large']);        // disable large size
	unset($sizes['medium_large']); // disable medium-large size
	unset($sizes['1536x1536']);    // disable 2x medium-large size
	unset($sizes['2048x2048']);    // disable 2x large size
	return $sizes;
}
add_action('intermediate_image_sizes_advanced', 'wcl_disable_unused_image_sizes');



// disable other image sizes
function wcl_disable_other_images() {
	remove_image_size('post-thumbnail'); // disable set_post_thumbnail_size() 
	remove_image_size('another-size');   // disable other add image sizes
}
add_action('init', 'wcl_disable_other_images');



// disable scaled image size
add_filter('big_image_size_threshold', '__return_false');



/*
* Register Nav Manus
*/
function wcl_register_nav_menus() {
	register_nav_menu('header-menu', 'Header Menu');
	register_nav_menu('footer-menu', 'Footer Menu');
}

add_action('after_setup_theme', 'wcl_register_nav_menus');



/*
* ACF Option Page
*/
if (function_exists('acf_add_options_page')) {

	// Theme Settings page
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'WCL Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
		'icon_url'		=> 'dashicons-admin-home',
	));
}



/* 
 Setup Support Theme
 */
function wcl_after_theme_setup() {
	add_theme_support('html5', ['script', 'style']);
	add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'wcl_after_theme_setup');





/*
* Add custom image sizes 
*/
add_image_size('image-size-1', 167, 167, true);
add_image_size('image-size-1@2x', 334, 334, true);
add_image_size('image-size-2', 335, 229, true);
add_image_size('image-size-2@2x', 670, 458, true);

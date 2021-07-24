<?php
/**
 * Plugin Name: Youtube frugalisme feed rss
 * Description: bloc guntenberg pour remonter les données depuis la chaine youtube du frugalisme
 * Version: 1.0.0
 * Author: Hasina RAVONIMBOLA
 * License: GPL2
 * Text Domain: youtube-feed
 */


define( 'SB_PLUGIN_URL', plugins_url( 'youtube-feed' ) );
define( 'SB_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'wp_enqueue_scripts', 'guntenberg_enqueue_boostrap' );
function guntenberg_enqueue_boostrap(){
	wp_register_style('frugalisme_youtube_css_bootstrap', plugin_dir_url( __FILE__ ) .'css/bootstrap.min.css',array(),'','all');
	wp_enqueue_style('frugalisme_youtube_css_bootstrap');

	wp_register_script('frugalisme_youtube_js_bootstrap', plugin_dir_url( __FILE__ ) .'js/bootstrap.min.js', array(),'','true');
	wp_enqueue_script('frugalisme_youtube_js_bootstrap');
}

add_action( 'admin_init', 'guntenberg_enqueue_admin_value_js' );
function guntenberg_enqueue_admin_value_js(){
	//wp_enqueue_script('frugalisme_call_value', plugin_dir_url( __FILE__ ).'youtube-feed.js', array(), '' , true);
	wp_localize_script('frugalisme-editor-js', 'frugalisme_value', array(
		'render_youtube' => frugalisme_render_feed() ,

	));
}


add_action( 'init', 'gutenberg_frugalisme_custom_blocks' );
function gutenberg_frugalisme_custom_blocks() {
	// Block front end styles.
	wp_register_style(
		'frugalisme-front-end-styles',
		SB_PLUGIN_URL . '/style.css',
		array( 'wp-edit-blocks' ),
		filemtime( SB_PLUGIN_DIR_PATH . 'style.css' )
	);
	// Block editor styles.
	wp_register_style(
		'frugalisme-editor-styles',
		SB_PLUGIN_URL . '/editor.css',
		array( 'wp-edit-blocks' ),
		filemtime( SB_PLUGIN_DIR_PATH . 'editor.css' )
	);

	// Block Editor Script.
	wp_register_script(
		'frugalisme-editor-js',
		SB_PLUGIN_URL . '/youtube-feed.js',
		array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
		filemtime( SB_PLUGIN_DIR_PATH . 'youtube-feed.js' ),
		true
	);
	register_block_type(
		'youtube-feed/youtube-feed',
		array(
			'style'         => 'frugalisme-front-end-styles',
			'editor_style'  => 'frugalisme-editor-styles',
			'editor_script' => 'frugalisme-editor-js',
			'render_callback' => 'frugalisme_render_feed'
		)
	);

}

/**
 * display shortcode 'import_rss_feed'
 */
function frugalisme_render_feed(){
	//enter feed rss , eg : $feed_url = www.exemple.com/rss
	$feed_url = 'https://www.googleapis.com/youtube/v3/search?key=AIzaSyAGpdny2nEa4PV2rF7deb9xszI6MZpGYVs&channelId=UCyOe9_F5RhK85v3HheSso-A&part=snippet,id&order=date&maxResults=50';
	$rss = file_get_contents($feed_url);
	$decode_rss = json_decode($rss);
	ob_start();
	//display in template part (file_render.php) the content of $rss
	include 'file_render.php';
	$html = ob_get_contents();
	ob_clean();

	return $html;
}

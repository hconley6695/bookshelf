<?php
/**
* Plugin Name: GetUWired Bookshelf 
* Plugin URI:
* Description: A Bookshelf that pulls in multiple custom post types and displays each one as a "book" on a bookshelf.
* Version: 1.0
* Author: GetUWired
* Author URI: https://getuwired.com
**/


function guw_enqueue_files(){
	wp_enqueue_style('bookshelf', plugin_dir_url( __FILE__ ) . 'bookshelf.css');
	wp_enqueue_script( 'register', plugin_dir_url( __FILE__ ) . 'bookshelf.js' );

};

add_action( 'wp_enqueue_scripts', 'guw_enqueue_files' );


function guw_create_bookshelf(){
	get_custom_posttypes();
}

add_shortcode('create_bookshelf', 'guw_create_bookshelf');

// function shortcodes_init(){
//  	add_shortcode('create_bookshelf', 'guw_create_bookshelf');
// }
// add_action('init', 'shortcodes_init');



function get_custom_posttypes() {
	$args = array('post_type' => array('alerts', 'labor-reports', 'briefings'), 'posts_per_page' => 12, 'post_status' => 'publish', 'nopaging' => false);

	$loop = new WP_Query($args);
		
	$the_bookshelf ='<div class="container">';

	$the_bookshelf .= '<div class="bookshelf">';

	while ($loop->have_posts()) : $loop->the_post();

			$type = get_post_type();
			$picture = get_the_post_thumbnail_url(); 
			$link = get_the_permalink();

			$title = get_the_title();
			$shortened_title = substr($title, 0, 35);
			if (str_contains($title, ".")) {
				$front_title = substr($title, 0, strpos($title, '.'));
				
			} elseif (str_contains($title, "-")) {
				$front_title = substr($title, 0, strpos($title, '-'));
				
			} else {
				$front_title = substr($title, 0, 60);
				
			}

			
		$the_bookshelf .= '<div class="book">';
		$the_bookshelf .= '<div class="side spine">';
		$the_bookshelf .= '<span class="spine-title">' . $shortened_title . '</span>';
		$the_bookshelf .= '<span class="spine-author"></span>';
		$the_bookshelf .=  '</div>';
		$the_bookshelf .= '<div class="side top"></div>';
		$the_bookshelf .= 	'<div class="side cover" style="top: 1px;background-image: url(' . $picture . ');">';
				if($type !== 'labor-reports'):			
					$the_bookshelf .= '<p>' . $front_title . '</p>';
					
				endif;
			$the_bookshelf .= '</div>';
			$the_bookshelf .= '<a href="' .$link . '" draggable="false"></a>';
		$the_bookshelf .= '</div>';


	endwhile;

	$the_bookshelf .= '</div>';
	$the_bookshelf .= '</div>';

	echo $the_bookshelf;
}


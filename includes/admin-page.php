<?php

function query_test_admin_menu() {
	add_menu_page( 'Query Tests', 'Query Tests', 'edit_posts', 'query-test', 'query_test_display_page', 'dashicons-clock' );
}

function query_test_admin_enqueue(){
	if ( isset( $_GET['page'] ) && ( 'query-test' == $_GET['page'] ) ){
		wp_enqueue_style( 'query-test', QUERY_TEST_URL . 'assets/style.css' );
		wp_enqueue_script( 'query-test', QUERY_TEST_URL . 'assets/scripts.js', array('jquery'), '', true );
	}
}

/**
 * Display query performance
 */
function query_test_display_page(){
	if ( ! defined( 'SAVEQUERIES' ) ) {
		echo '<div class="wrap">';
		echo 'SAVEQUERIES needs to be defined for this plugin to function.';
		return;
	}

	global $wpdb;
	$wpdb->query( "SET SESSION query_cache_type=0;" );

	$num_posts = wp_count_posts( 'post' );
	if ( $num_posts && $num_posts->publish ) {
		$num = number_format_i18n( $num_posts->publish );
	}

	?>

	<div class="wrap">
	<h2><?php _e( 'Query Test Results', 'query-test' ); ?></h2>

	<div class="defaults">
		<h3>Defaults:</h3>
		<p>Posts per page: <?php echo get_option( 'posts_per_page' ); ?></p>
		<p>Total published posts: <?php echo $num ?></p>
	</div>

	<?php
	$stickies = get_option('sticky_posts');

	$queries = array(
		'Default query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => -1
		),
		'Taxonomy query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'tax_query' => array(
				'relation'=> 'AND',
				array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => array( 'beyond_the_beyond' ) ),
				array( 'taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => array( 'design-fiction' ) ),
			),
		),
		'Meta query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'meta_query' => array(
				array( 'key' => '_thumbnail_id', 'compare' => 'NOT EXISTS' ),
			),
		),
		'Exclude query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'post__not_in' => $stickies,
		),
		'Tax and Meta query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'meta_query' => array(
				array( 'key' => '_thumbnail_id', 'compare' => 'NOT EXISTS' ),
			),
			'tax_query' => array(
				array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => 'business' ),
			),
		),
		'Tax, Meta, and Not-Author query' => array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'meta_query' => array(
				array( 'key' => 'promoted', 'value' => '1' ),
			),
			'tax_query' => array(
				array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => 'business' ),
			),
			'author__not_in' => array( 81 ),
		),
	);

	foreach ( $queries as $label => $args ) {
		$qt = new QueryTest( $args );
		$qt->run();
		$qt->display( $label );
	}

	echo '</div>';
}

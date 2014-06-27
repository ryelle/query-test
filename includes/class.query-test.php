<?php
/**
* OueryTest class
*/
class QueryTest {

	private $args;

	private $query;

	/**
	 * Set up our QueryTest
	 *
	 * @param array  $args  The arguments to pass on to WP_Query
	 */
	function __construct( $args ) {
		$this->args = $args;
	}

	/**
	 * Run the query
	 */
	public function run() {
		if ( is_array( $this->args ) ) {
			$this->args['cache_results'] = false;
			$this->args['update_post_term_cache'] = false;
			$this->args['update_post_meta_cache'] = false;
			$this->query = new WP_Query( $this->args );
		}
	}

	/**
	 * Display query metadata
	 */
	public function display( $label = '' ) {
		global $wpdb;
		$elapsed = -1;

		$query_meta = wp_list_filter( $wpdb->queries, array( 0 => $this->query->request ) );
		if ( ! empty( $query_meta ) ) {
			$elapsed = current( $query_meta )[1];
			$elapsed = number_format(sprintf('%0.1f', $elapsed * 1000), 1, '.', ',');
		}

		echo '<div class="query">';

		printf( '<h3>%s returned %s of %s posts.</h3>', $label, count($this->query->posts), number_format_i18n( $this->query->found_posts ) );

		$set_qv = array_filter ( $this->query->query_vars );
		// $set_qv = $this->args;
		printf( '<div class="col-left"><pre>%s</pre></div>', var_export( $set_qv, true ) );

		printf( '<div class="col-right"><textarea>%s</textarea></div>', $this->query->request );

		printf( '<p>%1$s: <b>%2$s</b> ms</p>', __( 'Elapsed time' ), $elapsed );

		echo '</div>';
	}

}

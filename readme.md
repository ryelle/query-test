# Query Test

Create and display SQL queries and performance from WP_Query objects

	Contributors:      ryelle
	Tags:
	Requires at least: 3.9
	Tested up to:      4.0
	Stable tag:        0.1.0
	License:           GPLv2 or later
	License URI:       http://www.gnu.org/licenses/gpl-2.0.html

## How to use

Edit `includes/admin-page.php` to set up the `$queries` variable for your queries. `$queries` is an array of WP_Query parameters. The format for the array should be `label => args`:

	'Default query' => array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => -1
	),

## Installation

1. Clone or download the `/query-test` directory to the `/wp-content/plugins/` directory.
2. Activate Query Test through the 'Plugins' menu in WordPress.

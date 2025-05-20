<?php
use QuiqOwl\Admin\Helper\Quiqowl_Table;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	exit;
}

$search_column_args = array(
	'columns'  => array(
		'quiqowl_search_keyword' => esc_html__( 'Search Keyword', 'quiqowl' ),
		'quiqowl_search_count'   => esc_html__( 'Search Count', 'quiqowl' ),
	),
	'sortable' => array(
		'quiqowl_search_count' => array(
			'quiqowl_search_count',
			true,
			__( 'Search Count', 'quiqowl' ),
			__( 'Table order by Search Count.', 'quiqowl' ),
		),
	),
	'primary'  => 'quiqowl_search_keyword',
);

$qo_db       = new \QuiqOwl\Quiqowl_Database();
$args        = array(
	'order_clause'  => array(
		'created_at',
		'DESC',
	),
	'select_clause' => 'id, keyword as quiqowl_search_keyword, search_count as quiqowl_search_count',
);
$search_data = $qo_db->read( $args );

$table_args = array(
	'core'       => array(
		'singular' => 'search_keyword_table',
		'plural'   => 'search_keyword_tables',
	),
	'pagination' => true,
);


?>

<div class="quiqowl-admin__dashboard">
	<h3 class="table__caption"><?php esc_html_e( 'Search Analytics', 'quiqowl' ); ?></h3>

	<?php
	$search_results = new Quiqowl_Table( $table_args );

	$search_results->prepare_items( $search_column_args, $search_data );
	$search_results->display();
	?>

</div>

<?php
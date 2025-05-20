<?php
namespace QuiqOwl\Admin\Helper;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/screen.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Quiqowl_Table extends \WP_List_Table {
	/**
	 * Holds the table data to be displayed.
	 *
	 * @var array An array of associative arrays representing the rows of table data.
	 */
	private $table_data;

	/**
	 * Holds configuration arguments for the table.
	 *
	 * @var array An array containing various settings for table behavior, such as pagination.
	 */
	private $table_args;

	/**
	 * Class constructor to initialize the table with provided arguments.
	 *
	 * This constructor sets up the table configuration, including core settings such as
	 * singular and plural names for the records. If `core` settings are not provided
	 * or are invalid, default values are used.
	 *
	 * @param array $args {
	 *     Optional. An array of configuration arguments for the table.
	 *
	 *     @type array  $core {
	 *         Optional. Core settings for the table.
	 *
	 *         @type string $singular The singular name of a record. Defaults to 'record'.
	 *         @type string $plural   The plural name of the records. Defaults to 'records'.
	 *     }
	 * }
	 */
	public function __construct( $args = array() ) {
		$this->table_args = $args;

		if ( ! isset( $args['core'] ) || ( isset( $args['core'] ) && ! is_array( $args['core'] ) ) ) {
			$args['core'] = array();
		}

		if ( ! empty( $args['core'] ) ) {
			$core = $args['core'];

			$singular = isset( $core['singular'] ) && is_string( $core['singular'] ) ? sanitize_text_field( wp_unslash( isset( $core['singular'] ) && is_string( $core['singular'] ) ) ) : 'record';
			$plural   = isset( $core['plural'] ) && is_string( $core['plural'] ) ? sanitize_text_field( wp_unslash( isset( $core['plural'] ) && is_string( $core['plural'] ) ) ) : 'records';

			parent::__construct(
				array(
					'singular' => $singular,  // Singular name of the record.
					'plural'   => $plural, // Plural name of the records.
				// 'ajax'     => false,       // Disable Ajax.
				)
			);

		} else {
			parent::__construct();
		}
	}

	/**
	 * Handles the display of default column values in the table.
	 *
	 * This function returns the value for a given column based on the column name.
	 * It is used as a fallback when no specific method exists for rendering the column.
	 *
	 * @param array  $item        The current row of data as an associative array.
	 * @param string $column_name The name of the column being rendered.
	 *
	 * @return mixed The value to be displayed for the specified column.
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'quiqowl_search_keyword':
			case 'quiqowl_search_count':
			default:
				return $item[ $column_name ];
		}
	}

	/**
	 * Sorts an array based on a specified key and order.
	 *
	 * This function is used with `usort()` to sort an array of associative arrays.
	 * The key to sort by is determined by the `orderby` query parameter, and the sort order
	 * (ascending or descending) is determined by the `order` query parameter.
	 * If `orderby` is not provided, the first key of the array is used as the default.
	 * If `order` is not provided, the sort order defaults to ascending.
	 *
	 * @param array $a The first array for comparison.
	 * @param array $b The second array for comparison.
	 * @return int Returns -1, 0, or 1 depending on the comparison result and order.
	 *             -1 if $a should come before $b,
	 *              0 if they are equal,
	 *              1 if $a should come after $b.
	 */
	public function usort_reorder( $a, $b ) {
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? sanitize_key( wp_unslash( $_GET['orderby'] ) ) : '';

		// If no order, default to asc.
		$order = ( ! empty( $_GET['order'] ) ) ? sanitize_key( wp_unslash( $_GET['order'] ) ) : 'asc';

		// Check if the $orderby key exists in $a and $b to avoid undefined index errors.
		if ( ! isset( $a[ $orderby ], $b[ $orderby ] ) ) {
			return 0;
		}

		// Determine if values are numeric.
		if ( is_numeric( $a[ $orderby ] ) && is_numeric( $b[ $orderby ] ) ) {
			$result = ( floatval( $a[ $orderby ] ) <=> floatval( $b[ $orderby ] ) );
		} else {
			// Perform string comparison if values are not numeric.
			$result = strcmp( $a[ $orderby ], $b[ $orderby ] );
		}

		// Send final sort direction to usort.
		return ( $order === 'asc' ) ? $result : -$result;
	}

	/**
	 * Prepares the table items for display, including sorting and pagination.
	 *
	 * This function sets up the table data by defining the column headers, sorting the data
	 * using the `usort_reorder` function, and handling pagination if enabled.
	 *
	 * @param array $args {
	 *     Optional. An array of arguments to configure the table.
	 *
	 *     @type array  $columns  The columns to display in the table.
	 *     @type array  $hidden   The columns to hide from display.
	 *     @type array  $sortable The sortable columns.
	 *     @type string $primary  The primary column to display.
	 * }
	 * @param array $data The data to populate the table with, as an array of associative arrays.
	 */
	public function prepare_items( $args = array(), $data = array() ) {
		$this->table_data = $data;

		// Define the total number of items for pagination
		$columns  = isset( $args['columns'] ) ? $args['columns'] : array();
		$hidden   = isset( $args['hidden'] ) ? $args['hidden'] : array();
		$sortable = isset( $args['sortable'] ) ? $args['sortable'] : array();
		$primary  = isset( $args['primary'] ) ? sanitize_text_field( wp_unslash( $args['primary'] ) ) : '';

		$this->_column_headers = array( $columns, $hidden, $sortable, $primary );

		usort( $this->table_data, array( &$this, 'usort_reorder' ) );

		/*
		pagination */
		if ( isset( $this->table_args['pagination'] ) && filter_var( $this->table_args['pagination'], FILTER_VALIDATE_BOOLEAN ) ) {
			$per_page     = 5;
			$current_page = $this->get_pagenum();
			$total_items  = count( (array) $this->table_data );

			$this->table_data = array_slice( (array) $this->table_data, ( ( $current_page - 1 ) * $per_page ), $per_page );

			$this->set_pagination_args(
				array(
					'total_items' => $total_items, // total number of items
					'per_page'    => $per_page, // items to show on a page
					'total_pages' => ceil( $total_items / $per_page ), // use ceil to round up
				)
			);

		}

		$this->items = $this->table_data;
	}
}

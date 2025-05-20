<?php
namespace QuiqOwl;

/**
 * Class Database
 * Handles database operations (CRUD) for the custom search keywords table in WordPress.
 */
class Quiqowl_Database {
	/**
	 * @var string $table_name The database table name used for storing search keywords.
	 */
	private $table_name;

	/**
	 * @var wpdb $wpdb WordPress database object for executing SQL queries.
	 */
	private $wpdb;

	/**
	 * Constructor to initialize the global $wpdb object and set the table name.
	 */
	public function __construct() {
		global $wpdb;
		$this->wpdb       = $wpdb;
		$this->table_name = $wpdb->prefix . 'quiqowl_search_keywords';
	}

	/**
	 * Creates the database table for storing search keywords and their details.
	 *
	 * This method uses the `dbDelta` function to create or update the table structure.
	 * The table stores:
	 * - `id`: Unique identifier for each record.
	 * - `keyword`: Original search keyword.
	 * - `typo`: Corrected typo, if applicable.
	 * - `is_typo`: Flag to indicate if the keyword is a typo (1 for true, 0 for false).
	 * - `search_count`: Number of times the keyword has been searched.
	 * - `created_at`: Timestamp of the record creation.
	 */
	public function create_table() {
		$charset_collate = $this->wpdb->get_charset_collate();
		$sql             = "CREATE TABLE {$this->table_name} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            keyword TEXT NOT NULL,
            typo TEXT DEFAULT NULL,
            is_typo TINYINT(1) DEFAULT 0,
            search_count INT UNSIGNED DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id), 
			KEY quiqowl_idx_keyword (keyword(255))
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Inserts a new record into the database.
	 *
	 * @param array $data Associative array of column-value pairs to insert.
	 * @return int|false The number of rows affected, or false on failure.
	 */
	public function create( $data ) {
		return $this->wpdb->insert(
			$this->table_name,
			$data,
			$this->get_format( $data )
		);
	}

	/**
	 * Reads records from the database.
	 *
	 * @param array  $conditions Associative array of column-value pairs for the WHERE clause.
	 * @param string $columns Comma-separated string of columns to retrieve (default: '*').
	 * @return array|null Array of results, or null if no matching rows are found.
	 */
	public function read( $args ) {
		if ( ! isset( $args['select_clause'] ) || ( isset( $args['select_clause'] ) && ! is_string( $args['select_clause'] ) ) ) {
			$args['select_clause'] = '*';
		}
		$select_clause = sanitize_text_field( wp_unslash( $args['select_clause'] ) );
		$query         = "SELECT $select_clause FROM {$this->table_name}";

		if ( isset( $args['where_clause'] ) && is_array( $args['where_clause'] ) && ! empty( $args['where_clause'] ) ) {
			$where_clause = $this->build_where_clause( $args['where_clause'] );
			$query       .= " $where_clause";
		}

		if ( isset( $args['order_clause'] ) && is_array( $args['order_clause'] ) && ! empty( $args['order_clause'] ) ) {
			$order_clause = $this->build_order_clause( $args['order_clause'] );
			$query       .= " $order_clause";
		}

		if ( isset( $args['limit'] ) && ( is_string( $args['limit'] ) || is_int( $args['limit'] ) ) ) {
			$limit  = sanitize_text_field( wp_unslash( $args['limit'] ) );
			$query .= " LIMIT $limit";
		}

		return $this->wpdb->get_results( $query, ARRAY_A );
	}

	/**
	 * Updates existing records in the database.
	 *
	 * @param array $data Associative array of column-value pairs to update.
	 * @param array $conditions Associative array of column-value pairs for the WHERE clause.
	 * @return int|false The number of rows affected, or false on failure.
	 */
	public function update( $data, $conditions ) {
		return $this->wpdb->update(
			$this->table_name,
			$data,
			$conditions,
			$this->get_format( $data ),
			$this->get_format( $conditions )
		);
	}

	/**
	 * Deletes records from the database.
	 *
	 * @param array $conditions Associative array of column-value pairs for the WHERE clause.
	 * @return int|false The number of rows affected, or false on failure.
	 */
	public function delete( $conditions = array() ) {
		return $this->wpdb->delete(
			$this->table_name,
			$conditions,
			$this->get_format( $conditions )
		);
	}

	/**
	 * Builds a WHERE clause for SQL queries.
	 *
	 * @param array $conditions Associative array of column-value pairs for the WHERE clause.
	 * @return string The constructed WHERE clause (e.g., "WHERE key1 = value1 AND key2 = value2").
	 */
	private function build_where_clause( $conditions, $operator = 'AND' ) {
		if ( empty( $conditions ) ) {
			return '';
		}
		$where = array();
		foreach ( $conditions as $key => $value ) {
			$where[] = $this->wpdb->prepare( "$key = %s", $value );
		}
		
		return 'WHERE ' . implode( ' ' . $operator . ' ', $where );
	}

	/**
	 * Builds a WHERE clause for SQL queries.
	 *
	 * @param array $conditions Associative array of column-value pairs for the WHERE clause.
	 * @return string The constructed WHERE clause (e.g., "WHERE key1 = value1 AND key2 = value2").
	 */
	private function build_order_clause( $conditions, ) {
		if ( empty( $conditions ) ) {
			return '';
		}

		$order_query = '';
		if ( isset( $conditions[0] ) ) {
			$order_query .= "ORDER BY $conditions[0]";

			if ( isset( $conditions[1] ) ) {
				$order_query .= " $conditions[1]";
			}
		}

		return $order_query;
	}

	/**
	 * Determines the format of the values in an associative array for SQL queries.
	 *
	 * @param array $data Associative array of column-value pairs.
	 * @return array Array of formats (e.g., '%s' for strings, '%d' for integers).
	 */
	private function get_format( $data ) {
		return array_map(
			function ( $value ) {
				return is_numeric( $value ) ? '%d' : '%s';
			},
			$data
		);
	}
}

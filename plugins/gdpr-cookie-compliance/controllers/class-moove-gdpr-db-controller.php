<?php
/**
 * Moove_GDPR_Database_Controller File Doc Comment
 *
 * @category Moove_GDPR_Database_Controller
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Moove_GDPR_Database_Controller Class Doc Comment
 *
 * @category Class
 * @package  Moove_GDPR_Database_Controller
 * @author   Gaspar Nemes
 */
class Moove_GDPR_DB_Controller {

	/**
	 * Global variable used as primary key
	 *
	 * @var primary_key Primary key.
	 */
	public static $primary_key = 'id';

	/**
	 * Construct
	 */
	public function __construct() {
		global $wpdb;
		/**
		 * Creating database structure on the first time
		 */
		if ( $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}gdpr_cc_options'" ) != $wpdb->prefix . 'gdpr_cc_options' ) :
			$wpdb->query(
				"CREATE TABLE {$wpdb->prefix}gdpr_cc_options(
          id INTEGER NOT NULL auto_increment,
          option_key VARCHAR(255) NOT NULL DEFAULT 1,
          option_value LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          site_id INTEGER DEFAULT NULL,
          extras LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          PRIMARY KEY (id)
        );"
			);
		endif;
	}

	/**
	 * GDPR Table name
	 */
	private static function _table() {
		global $wpdb;
		$tablename = 'gdpr_cc_options';
		return $wpdb->prefix . $tablename;
	}

	/**
	 * Returns value to by site_id and option_key
	 *
	 * @param string $key Key.
	 * @param string $site_id Site ID .
	 */
	private static function _fetch_sql( $key, $site_id = '1' ) {
		global $wpdb;
		$table_name = self::_table();
		$result     = false;
		if ( $key ) :
			$results = $wpdb->prepare( "SELECT option_value, option_key FROM `$table_name` WHERE `option_key` = %s", $key);
		endif;
		return $results;
	}

	/**
	 * Option SQL
	 *
	 * @param string $site_id Site ID.
	 */
	private static function _fetch_options_sql( $site_id ) {
		global $wpdb;
		$table_name = self::_table();
		return "SELECT option_key, option_value FROM `$table_name`";
	}

	/**
	 * Get a Single value from database
	 *
	 * @param string $key Key name.
	 * @param string $site_id Site ID.
	 */
	public static function get( $key = false, $site_id = '1' ) {
		global $wpdb;
		return $wpdb->get_row( self::_fetch_sql( $key, $site_id ) );
	}

	/**
	 * Get all values from table
	 *
	 * @param string $site_id Site ID.
	 */
	public static function get_options( $site_id = '1' ) {
		global $wpdb;
		return $wpdb->get_results( self::_fetch_options_sql( $site_id ), OBJECT_K );
	}

	/**
	 * Update value in table
	 *
	 * @param mixed $data Data.
	 */
	public static function update( $data ) {
		global $wpdb;		
		self::remove_duplicate_entries();
		if ( self::get( $data['option_key'] ) ) :
			// Update.
			$where = [ 'option_key' => $data['option_key'] ];
			return $wpdb->update( self::_table(), $data, $where );
		else :
			// Insert.
			return $wpdb->insert( self::_table(), $data );
		endif;
	}

	/**
	 * Removing duplicate entries from table if found
	 */
	private static function remove_duplicate_entries() {
		global $wpdb;
		return $wpdb->query("DELETE c1 FROM {$wpdb->prefix}gdpr_cc_options c1 INNER JOIN {$wpdb->prefix}gdpr_cc_options c2 WHERE c1.id > c2.id AND c1.option_key = c2.option_key");

	}

	/**
	 * Remove values from database
	 */
	public static function delete_option() {
		global $wpdb;
		$table_name = self::_table();
		return $wpdb->query( "DELETE FROM `$table_name`" );
	}
}

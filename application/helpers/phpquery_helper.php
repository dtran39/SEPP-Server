<?php

if (!class_exists('phpQueryObject')) {
	/**
	 * The main Twilio.php file contains an autoload method for its dependent
	 * classes, we only need to include the one file manually.
	 */
	include_once(APPPATH.'libraries/PhpQuery.php');
}

/**
 * Return a twilio services object.
 *
 * Since we don't want to create multiple connection objects we
 * will return the same object during a single page load
 *
 * @return object phpQueryObject
 */
function get_phpquery_service() {
	static $phpquery_service;

	if (!($phpquery_service instanceof phpQueryObject)) {

        $CI =& get_instance();
		$phpquery_service = phpQuery;
	}

	return $phpquery_service;
}

?>

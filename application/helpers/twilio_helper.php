<?php

if (!class_exists('Services_Twilio')) {
	/**
	 * The main Twilio.php file contains an autoload method for its dependent
	 * classes, we only need to include the one file manually.
	 */
	include_once(APPPATH.'libraries/Twilio.php');
}

/**
 * Return a twilio services object.
 *
 * Since we don't want to create multiple connection objects we
 * will return the same object during a single page load
 *
 * @return object Services_Twilio
 */
function get_twilio_service() {
	static $twilio_service;

	if (!($twilio_service instanceof Services_Twilio)) {
		/**
		 * This assumes that you've defined your SID & TOKEN as constants
		 * Replace with a way to get your SID & TOKEN if different
		 */
        $CI =& get_instance();
        $CI->config->load('twilio');
        $twilio_settings = $CI->config->item('twilio');
        $account_sid = $twilio_settings['account_sid'];
        $auth_token = $twilio_settings['auth_token'];
		    $twilio_service = new Services_Twilio($account_id, $auth_token);
	}

	return $twilio_service;
}

?>

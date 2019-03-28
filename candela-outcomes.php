<?php

/**
* @wordpress-plugin
* Plugin Name: Candela Outcomes
* Description: Outcome GUID management for courseware
* Version: 1.0
* Author: Lumen Learning
* Author URI: https://lumenlearning.com
* Text Domain: learning, education
* License: MIT
* GitHub Plugin URI: https://github.com/lumenlearning/candela-outcomes
*/

use Candela\Outcomes;

// If file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoload
 */
include_once __DIR__ . '/autoloader.php';

Outcomes::init();

<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Candela Outcomes
 * Description:       Add Outcomes meta field for coursework
 * Version:           0.1
 * Author:            Lumen Learning
 * Author URI:        http://lumenlearning.com
 * Text Domain:       lti
 * License:           MIT
 * GitHub Plugin URI: https://github.com/lumenlearning/candela-outcomes
 */

use Candela\Outcomes;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

// -----------------------------------------------------------------------------
// SETUP
// -----------------------------------------------------------------------------

if( ! defined( 'CANDELA_OUTCOMES_GUID' ) ) {
  define( 'CANDELA_OUTCOMES_GUID', 'CANDELA_OUTCOMES_GUID' );
}

if ( ! defined( 'CANDELA_OUTCOMES_PLUGIN_DIR' ) ) {
  define( 'CANDELA_OUTCOMES_PLUGIN_DIR', __DIR__ . '/' );
}

// -----------------------------------------------------------------------------
// AUTOLOAD
// -----------------------------------------------------------------------------

require CANDELA_OUTCOMES_PLUGIN_DIR . 'autoloader.php';

Outcomes::init();

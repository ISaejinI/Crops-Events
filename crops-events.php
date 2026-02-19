<?php
/*
 * Plugin Name: Crops Events
 * Description: Gérer les événements de votre association avec Crops Events. Ce plugin vous permet de créer, organiser et promouvoir facilement vos événements.
 * Version: 1.0.0
 * Author: Lou-Anne Biet
 * Author URI: https://www.portfolio.louanne-biet.fr/
 * Text Domain: crops-events
 * Requires Plugins: advanced-custom-fields
*/

if (!defined('ABSPATH')) {
    exit;
}

if ( ! function_exists('acf_add_local_field_group') ) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>';
        echo __('Crops Events nécessite le plugin Advanced Custom Fields (version gratuite) pour fonctionner.', 'crops-events');
        echo '</p></div>';
    });
};

require_once plugin_dir_path(__FILE__) . 'inc/EventPostType.php';
require_once plugin_dir_path(__FILE__) . 'inc/EventTaxonomy.php';
require_once plugin_dir_path(__FILE__) . 'inc/EventFields.php';
require_once plugin_dir_path(__FILE__) . 'inc/EventRegisterTable.php';

use CropsEvents\EventPostType;
use CropsEvents\EventTaxonomy;
use CropsEvents\EventFields;
use CropsEvents\EventRegisterTable;

(new EventPostType())->register();
(new EventTaxonomy())->register();
(new EventFields())->register();

register_activation_hook(__FILE__, function() {
    (new EventRegisterTable())->createTable();
});
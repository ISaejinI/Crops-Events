<?php
/*
 * Plugin Name: Crops Events
 * Description: Gérer les événements de votre association avec Crops Events. Ce plugin vous permet de créer, organiser et promouvoir facilement vos événements.
 * Version: 1.0.0
 * Author: Lou-Anne Biet
 * Author URI: https://www.portfolio.louanne-biet.fr/
 * Text Domain: crops-events
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'inc/EventPostType.php';
require_once plugin_dir_path(__FILE__) . 'inc/EventTaxonomy.php';

use CropsEvents\EventPostType;
use CropsEvents\EventTaxonomy;

(new EventPostType())->register();
(new EventTaxonomy())->register();
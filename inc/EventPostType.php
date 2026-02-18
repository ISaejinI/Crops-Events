<?php
namespace CropsEvents;

class EventPostType
{
    const POST_TYPE = 'event';

    public function definePostType()
    {
        $labels = [
            'name' => __('Événements', 'crops-events'),
            'singular_name' => __('Événement', 'crops-events'),
            'add_new' => __('Ajouter un événement', 'crops-events'),
            'add_new_item' => __('Ajouter un nouvel événement', 'crops-events'),
            'edit_item' => __('Modifier l\'événement', 'crops-events'),
            'new_item' => __('Nouvel événement', 'crops-events'),
            'view_item' => __('Voir l\'événement', 'crops-events'),
            'search_items' => __('Rechercher des événements', 'crops-events'),
            'not_found' => __('Aucun événement trouvé', 'crops-events'),
            'not_found_in_trash' => __('Aucun événement trouvé dans la corbeille', 'crops-events'),
            'all_items' => __('Tous les événements', 'crops-events'),
            'menu_name' => __('Événements', 'crops-events'),
            'name_admin_bar' => __('Événement', 'crops-events'),
        ];

        $args = [
            'labels' => $labels,
            'description' => __('Gérer les événements de votre association avec Crops Events.', 'crops-events'),
            'public' => true,
            'rewrite' => ['slug' => self::POST_TYPE],
            'has_archive' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => ['title', 'thumbnail'],
        ];

        register_post_type(self::POST_TYPE, $args);
    }

    public function register()
    {
        add_action('init', [$this, 'definePostType']);
    }
}
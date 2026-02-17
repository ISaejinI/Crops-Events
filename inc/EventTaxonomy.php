<?php
namespace CropsEvents;

class EventTaxonomy
{
    public function defineTaxonomy()
    {
        $labels = [
            'name' => __('Types d\'événements', 'crops-events'),
            'singular_name' => __('Type d\'événement', 'crops-events'),
            'search_items' => __('Rechercher des types d\'événements', 'crops-events'),
            'all_items' => __('Tous les types d\'événements', 'crops-events'),
            'parent_item' => __('Type d\'événement parent', 'crops-events'),
            'parent_item_colon' => __('Type d\'événement parent:', 'crops-events'),
            'edit_item' => __('Modifier le type d\'événement', 'crops-events'),
            'update_item' => __('Mettre à jour le type d\'événement', 'crops-events'),
            'add_new_item' => __('Ajouter un nouveau type d\'événement', 'crops-events'),
            'new_item_name' => __('Nom du nouveau type d\'événement', 'crops-events'),
            'menu_name' => __('Types d\'événements', 'crops-events'),
        ];

        $args = [
            'labels' => $labels,
            'show_ui' => true,
            'public' => true,
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'type-evenement'],
        ];

        register_taxonomy('event_type', [EventPostType::POST_TYPE], $args);
    }

    public function register()
    {
        add_action('init', [$this, 'defineTaxonomy']);
    }
}
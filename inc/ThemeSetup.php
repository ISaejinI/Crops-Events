<?php
namespace CropsEvents;

class ThemeSetup
{
    private EventRegisterActions $event_register_actions;

    public function __construct()
    {
        $this->event_register_actions = new \CropsEvents\EventRegisterActions();
    }

    public function hideToolBarForSubscribers()
    {
        if (! is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();

        if (in_array('subscriber', (array) $user->roles, true)) {
            show_admin_bar(false);
        }
    }

    public function hideBoardForSubscribers()
    {
        if (! is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();

        if (in_array('subscriber', (array) $user->roles, true)) {
            add_action('admin_menu', function() {
                remove_menu_page('index.php');
            });
        }
    }

    public function addBackHomeForSubscribers()
    {
        if (! is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();
        if (in_array('subscriber', (array) $user->roles, true)) {
            add_action('admin_bar_menu', function($wp_admin_bar) {
                $wp_admin_bar->add_node([
                    'id' => 'crops-events-home',
                    'title' => __('Revenir à l\'accueil', 'crops-events'),
                    'href' => home_url(),
                ]);
            }, 999);
        }
    }

    public function addUserEventsPage()
    {
        if (! is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();
        if (in_array('subscriber', (array) $user->roles, true)) {
            add_menu_page(
                __('Mes événements', 'crops-events'),
                __('Mes événements', 'crops-events'),
                'read',
                'crops-events-user-events',
                function() {
                    echo '<div class="wrap"><h1>' . esc_html__('Mes événements', 'crops-events') . '</h1>';
                    $registered_events = $this->event_register_actions->get_registered_events(get_current_user_id());

                    if (! empty($registered_events)) {
                        echo '<table class="wp-list-table widefat fixed striped">';
                        echo '<thead><tr><th>' . esc_html__('Titre de l\'événement', 'crops-events') . '</th><th>' . esc_html__('Date', 'crops-events') . '</th><th>' . esc_html__('Actions', 'crops-events') . '</th></tr></thead>';
                        echo '<tbody>';
                        foreach ($registered_events as $event_id) {
                            $event = get_post($event_id);
                            if ($event) {
                                $date = get_post_meta($event_id, 'event_global_informations_event_begin_date', true);
                                $formatted_date = wp_date('j F Y \à H:i', strtotime($date));
                                $unregister_url = wp_nonce_url(
                                    admin_url('admin-post.php?action=crops_events_unregister&event_id=' . $event_id),
                                    'crops_events_unregister_' . $event_id
                                );

                                echo '<tr>';
                                echo '<td><a href="' . get_permalink($event_id) . '">' . esc_html(get_the_title($event_id)) . '</a></td>';
                                echo '<td>' . esc_html($formatted_date) . '</td>';
                                echo '<td><a href="' . esc_url($unregister_url) . '" class="button">' . esc_html__('Se désinscrire', 'crops-events') . '</a></td>';
                                echo '</tr>';
                            }
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<p>' . esc_html__('Vous ne vous êtes inscrit à aucun événement pour le moment.', 'crops-events') . '</p>';
                    }

                    echo '</div>';
                },
                'dashicons-calendar-alt'
            );
        }

    }

    public function register()
    {
        add_action('after_setup_theme', [$this, 'hideToolBarForSubscribers']);
        add_action('after_setup_theme', [$this, 'hideBoardForSubscribers']);
        add_action('after_setup_theme', [$this, 'addBackHomeForSubscribers']);
        add_action('after_setup_theme', [$this, 'addUserEventsPage']);
    }
}
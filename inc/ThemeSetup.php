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

    public function addEventParticipantLink(array $actions, \WP_Post $post)
    {
        if ($post->post_type !== 'event') {
            return $actions;
        }

        if (! current_user_can('edit_posts')) {
            return $actions;
        }

        $url = add_query_arg(
            [
                'page'     => 'crops-events-participants',
                'event_id' => $post->ID,
            ],
            admin_url('admin.php')
        );

        $url = wp_nonce_url($url, 'crops_events_view_participants_' . $post->ID);

        $actions['crops_events_participants'] =
            '<a href="' . esc_url($url) . '">' . esc_html__('Voir les participants', 'crops-events') . '</a>';

        return $actions;
    }

    public function addEventParticipantsPage()
    {
        add_submenu_page(
            null,
            __('Participants', 'crops-events'),
            __('Participants', 'crops-events'),
            'edit_posts',
            'crops-events-participants',
            [$this, 'addEventParticipantsPageCallback']
        );
    }

    public function addEventParticipantsPageCallback()
    {
        if (! current_user_can('edit_posts')) {
            wp_die(__('Accès refusé.', 'crops-events'));
        }

        $event_id = isset($_GET['event_id']) ? (int) $_GET['event_id'] : 0;
        if (! $event_id || get_post_type($event_id) !== 'event') {
            wp_die(__('Événement invalide.', 'crops-events'));
        }

        check_admin_referer('crops_events_view_participants_' . $event_id);

        $actions = new \CropsEvents\EventRegisterActions();
        $user_ids = $actions->get_registered_users($event_id);

        echo '<div class="wrap">';
        echo '<h1>' . esc_html(get_the_title($event_id)) . ' — ' . esc_html__('Participants', 'crops-events') . '</h1>';

        echo '<p><a href="' . esc_url(admin_url('edit.php?post_type=event')) . '">← ' . esc_html__('Retour aux événements', 'crops-events') . '</a></p>';

        if (empty($user_ids)) {
            echo '<p>' . esc_html__('Aucun participant pour le moment.', 'crops-events') . '</p>';
            echo '</div>';
            return;
        }

        echo '<table class="widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>' . esc_html__('Nom', 'crops-events') . '</th>';
        echo '<th>' . esc_html__('Email', 'crops-events') . '</th>';
        echo '<th>' . esc_html__('Profil', 'crops-events') . '</th>';
        echo '</tr></thead><tbody>';

        foreach ($user_ids as $user_id) {
            $user = get_user_by('id', (int) $user_id);
            if (! $user) {
                continue;
            }

            $profile_url = get_edit_user_link($user->ID);

            echo '<tr>';
            echo '<td>' . esc_html($user->display_name) . '</td>';
            echo '<td>' . esc_html($user->user_email) . '</td>';
            echo '<td><a href="' . esc_url($profile_url) . '">' . esc_html__('Voir le profil', 'crops-events') . '</a></td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '</div>';
    }

    public function addEventParticipantCount(array $actions, \WP_Post $post)
    {
        if ($post->post_type !== 'event') {
            return $actions;
        }

        if (! current_user_can('edit_posts')) {
            return $actions;
        }

        $participant_count = count($this->event_register_actions->get_registered_users($post->ID));
        $max_participants = (int) get_post_meta($post->ID, 'event_register_informations_event_capacity', true);

        $actions['crops_events_participant_count'] = '<span style="color: #666;">' . esc_html($participant_count) . '/' . esc_html($max_participants) . ' ' . esc_html__('participants', 'crops-events') . '</span>';

        return $actions;
    }

    public function register()
    {
        add_action('after_setup_theme', [$this, 'hideToolBarForSubscribers']);
        add_action('after_setup_theme', [$this, 'hideBoardForSubscribers']);
        add_action('after_setup_theme', [$this, 'addBackHomeForSubscribers']);
        add_action('after_setup_theme', [$this, 'addUserEventsPage']);
        add_filter('post_row_actions', [$this, 'addEventParticipantLink'], 10, 2);
        add_action('admin_menu', [$this, 'addEventParticipantsPage']);
        add_filter('post_row_actions', [$this, 'addEventParticipantCount'], 10, 2);
    }
}
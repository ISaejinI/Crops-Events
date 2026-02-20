<?php

namespace CropsEvents;

class RenderDatas
{
    private EventRegisterActions $event_register_actions;

    public function __construct()
    {
        $this->event_register_actions = new \CropsEvents\EventRegisterActions();
    }

    public function renderRemainingSeats($event_id): string
    {
        $post_id = get_the_ID();
        if (! $post_id || get_post_type($post_id) !== 'event') return '';

        $participants_count = $this->event_register_actions->count_participants($post_id);
        $capacity = get_post_meta($post_id, 'event_register_informations_event_capacity', true);
        $remaining_seats = $capacity - $participants_count;

        if ($remaining_seats <= 0) {
            return '<!-- wp:paragraph --><p class="crops-events__seats crops-events__seats--full">Complet</p><!-- /wp:paragraph -->';
        }

        return '<p class="crops-events__seats">' . esc_html($remaining_seats) . ' place' . ($remaining_seats > 1 ? 's' : '') . ' restante' . ($remaining_seats > 1 ? 's' : '') . '</p>';

    }

    public function renderRegisterButton($event_id): string
    {
        $post_id = get_the_ID();
        if (! $post_id || get_post_type($post_id) !== 'event') return '';

        $output = '';

        if (! is_user_logged_in()) {
            $login_url = wp_login_url(get_permalink($post_id));
            $output .= '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button">';
            $output .= '<a href="' . esc_url($login_url) . '" class="wp-block-button__link wp-element-button crops-events__register-button">Se connecter pour s\'inscrire</a>';
            $output .= '</div><!-- /wp:button --></div><!-- /wp:buttons --></div>';
            return $output;
        }

        $is_register_open = get_post_meta($post_id, 'event_register_informations_event_is_register_open', true);
        $register_limit_date = get_post_meta($post_id, 'event_register_informations_event_register_limit_date', true);
        $current_date = date('Y-m-d');
        if ($is_register_open === '0' || ($register_limit_date && $current_date > $register_limit_date)) {
            $output .= '<!-- wp:paragraph --><p>Les inscriptions sont fermées pour le moment</p><!-- /wp:paragraph -->';
            return $output;
        }

        $capacity = get_post_meta($post_id, 'event_register_informations_event_capacity', true);
        $participants_count = $this->event_register_actions->count_participants($post_id);
        if ($participants_count >= $capacity) {
            $output .= '<!-- wp:paragraph --><p>L\'événement est complet</p><!-- /wp:paragraph -->';
            return $output;
        }

        if ($this->event_register_actions->is_user_registered($post_id, get_current_user_id())) {
            $url = wp_nonce_url(
                admin_url('admin-post.php?action=crops_events_unregister&event_id=' . $post_id),
                'crops_events_unregister_' . $post_id
            );

            $output .= '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button">';
            $output .= '<a href="'. esc_url($url) .'" class="wp-block-button__link wp-element-button crops-events__register-button">Me désinscrire</a>';
            $output .= '</div><!-- /wp:button --></div><!-- /wp:buttons --></div>';
            return $output;
        } else {
            $url = wp_nonce_url(
                admin_url('admin-post.php?action=crops_events_register&event_id=' . $post_id),
                'crops_events_register_' . $post_id
            );

            $output .= '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button">';
            $output .= '<a href="'. esc_url($url) .'" class="wp-block-button__link wp-element-button crops-events__register-button">Je participe !</a>';
            $output .= '</div><!-- /wp:button --></div><!-- /wp:buttons --></div>';
            return $output;
        }
    }

    public function profileLink(): string
    {
        if (! is_user_logged_in()) {
            return '';
        }

        $url = get_edit_profile_url(get_current_user_id());

        return '<!-- wp:navigation-link {"label":"Profil","type":"page","url":"'. esc_url($url) .'","kind":"post-type"} /-->';
    }

    function register()
    {
        add_shortcode('crops_events_remaining_seats', [$this, 'renderRemainingSeats']);
        add_shortcode('crops_events_register_button', [$this, 'renderRegisterButton']);
        add_shortcode('crops_events_profile_link', [$this, 'profileLink']);
    }
}

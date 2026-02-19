<?php

namespace CropsEvents;

class RenderDatas
{
    public function renderRemainingSeats($event_id): string
    {
        $event_register_actions = new \CropsEvents\EventRegisterActions();

        $post_id = get_the_ID();
        if (! $post_id || get_post_type($post_id) !== 'event') return '';

        $participants_count = $event_register_actions->count_participants($post_id);
        $capacity = get_post_meta($post_id, 'event_register_informations_event_capacity', true);
        $remaining_seats = $capacity - $participants_count;

        if ($remaining_seats <= 0) {
            return '<p class="crops-events__seats crops-events__seats--full">Complet</p>';
        }

        return '<p class="crops-events__seats">' . esc_html($remaining_seats) . ' place' . ($remaining_seats > 1 ? 's' : '') . ' restante' . ($remaining_seats > 1 ? 's' : '') . '</p>';

    }

    function register()
    {
        add_shortcode('crops_events_remaining_seats', [$this, 'renderRemainingSeats']);
    }
}

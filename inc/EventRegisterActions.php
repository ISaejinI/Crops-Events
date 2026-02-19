<?php
namespace CropsEvents;

class EventRegisterActions
{
    private string $table;

    public function __construct()
    {
        global $wpdb;

        $this->table = $wpdb->prefix . 'crops_events_registrations';
    }

    public function is_user_registered(int $event_id, int $user_id): bool
    {
        global $wpdb;

        $request = $wpdb->prepare(
            "SELECT 1 FROM {$this->table} WHERE event_id = %d AND user_id = %d AND is_registered = 1 LIMIT 1",
            $event_id,
            $user_id
        );
        
        return (bool) $wpdb->get_var($request);
    }

    public function register_user(int $event_id, int $user_id): bool
    {
        global $wpdb;

        $request = $wpdb->query(
            $wpdb->prepare(
                "INSERT INTO {$this->table} (event_id, user_id, is_registered) VALUES (%d, %d, 1) ON DUPLICATE KEY UPDATE is_registered = 1",
                $event_id,
                $user_id
            )
        );
        
        return $request !== false;
    }

    public function unregister_user(int $event_id, int $user_id): bool
    {
        global $wpdb;

        $request = $wpdb->update(
            $this->table,
            ['is_registered' => 0],
            ['event_id' => $event_id, 'user_id' => $user_id],
            ['%d'],
            ['%d', '%d']
        );
        
        return $request !== false;
    }

    public function count_participants(int $event_id): int
    {
        global $wpdb;

        $request = $wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table} WHERE event_id = %d AND is_registered = 1",
            $event_id
        );
        
        return (int) $wpdb->get_var($request);
    }

    public function get_registered_users(int $event_id): array
    {
        global $wpdb;

        $request = $wpdb->prepare(
            "SELECT user_id FROM {$this->table} WHERE event_id = %d AND is_registered = 1",
            $event_id
        );
        
        return $wpdb->get_col($request);
    }

    public function get_registered_events(int $user_id): array
    {
        global $wpdb;

        $request = $wpdb->prepare(
            "SELECT event_id FROM {$this->table} WHERE user_id = %d AND is_registered = 1",
            $user_id
        );
        
        return $wpdb->get_col($request);
    }
}
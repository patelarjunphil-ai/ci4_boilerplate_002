<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Exceptions\DatabaseException;

class SettingsService
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * Get a setting value.
     *
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        try {
            $setting = $this->db->table('site_settings')
                ->where('setting_key', $key)
                ->get()
                ->getRow();

            return $setting ? $setting->setting_value : $default;
        } catch (DatabaseException $e) {
            // Log the error
            log_message('error', '[SettingsService] ' . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set a setting value.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function set(string $key, $value): bool
    {
        try {
            $data = [
                'setting_key'   => $key,
                'setting_value' => $value,
            ];

            // Use insert on duplicate key update
            return $this->db->table('site_settings')->replace($data);

        } catch (DatabaseException $e) {
            // Log the error
            log_message('error', '[SettingsService] ' . $e->getMessage());
            return false;
        }
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'   => 'site.name',
                'value' => 'CI4 Boilerplate',
            ],
            [
                'key'   => 'site.contactEmail',
                'value' => 'contact@example.com',
            ],
            [
                'key'   => 'site.maintenanceMode',
                'value' => '0',
            ],
            [
                'key'   => 'app.theme',
                'value' => 'default',
            ],
        ];

        // Using a loop to insert data with timestamps
        foreach ($data as $setting) {
            $this->db->table('site_settings')->insert([
                'key'   => $setting['key'],
                'value' => $setting['value'],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
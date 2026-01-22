<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name', 'value' => 'Web Development Agency', 'type' => 'string'],
            ['key' => 'company_email', 'value' => 'contact@webagency.com', 'type' => 'string'],
            ['key' => 'company_phone', 'value' => '081234567890', 'type' => 'string'],
            ['key' => 'company_address', 'value' => 'Jl. Example No. 123, Jakarta', 'type' => 'string'],
            ['key' => 'tax_percentage', 'value' => '0', 'type' => 'number'],
            ['key' => 'invoice_prefix', 'value' => 'INV', 'type' => 'string'],
            ['key' => 'quotation_prefix', 'value' => 'QUO', 'type' => 'string'],
            ['key' => 'payment_prefix', 'value' => 'PAY', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            ProjectSeeder::class,
            QuotationSeeder::class,
            InvoiceSeeder::class,
            PaymentSeeder::class,
            ProjectTaskSeeder::class,
            CommunicationSeeder::class,
            SettingSeeder::class,
        ]);
    }
}

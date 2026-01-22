<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'PT. Maju Jaya',
                'email' => 'contact@majujaya.com',
                'phone' => '081234567890',
                'company' => 'PT. Maju Jaya',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'website' => 'https://majujaya.com',
                'status' => 'active',
                'notes' => 'Klien potensial untuk project besar',
            ],
            [
                'name' => 'CV. Berkah Sejahtera',
                'email' => 'info@berkahsejahtera.co.id',
                'phone' => '081987654321',
                'company' => 'CV. Berkah Sejahtera',
                'address' => 'Jl. Gatot Subroto No. 456, Jakarta Selatan',
                'website' => 'https://berkahsejahtera.co.id',
                'status' => 'active',
                'notes' => 'Klien repeat order',
            ],
            [
                'name' => 'Toko Online Rahayu',
                'email' => 'admin@tokorahayu.com',
                'phone' => '082345678901',
                'company' => 'Toko Online Rahayu',
                'address' => 'Jl. Asia Afrika No. 789, Bandung',
                'website' => null,
                'status' => 'active',
                'notes' => 'Startup e-commerce',
            ],
            [
                'name' => 'PT. Global Tech',
                'email' => 'hello@globaltech.id',
                'phone' => '081122334455',
                'company' => 'PT. Global Tech',
                'address' => 'Jl. HR Rasuna Said No. 321, Jakarta',
                'website' => 'https://globaltech.id',
                'status' => 'active',
                'notes' => null,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@email.com',
                'phone' => '085678901234',
                'company' => 'Personal',
                'address' => 'Jl. Merdeka No. 111, Surabaya',
                'website' => null,
                'status' => 'active',
                'notes' => 'Project personal website',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Database\Seeder;

class QuotationSeeder extends Seeder
{
    public function run(): void
    {
        $quotations = [
            [
                'client_id' => 1,
                'quotation_number' => 'QUO-20240101-0001',
                'package_type' => 'professional',
                'subtotal' => 15000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 15000000,
                'status' => 'accepted',
                'valid_until' => '2024-01-31',
                'sent_date' => '2024-01-02',
                'accepted_date' => '2024-01-05',
                'notes' => 'Penawaran untuk company profile',
                'items' => json_encode([
                    ['description' => 'Company Profile Website', 'quantity' => 1, 'price' => 15000000],
                ]),
            ],
            [
                'client_id' => 2,
                'quotation_number' => 'QUO-20240201-0002',
                'package_type' => 'premium',
                'subtotal' => 35000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 35000000,
                'status' => 'accepted',
                'valid_until' => '2024-02-28',
                'sent_date' => '2024-02-02',
                'accepted_date' => '2024-02-05',
                'notes' => 'Penawaran untuk e-commerce',
                'items' => json_encode([
                    ['description' => 'E-Commerce Website', 'quantity' => 1, 'price' => 30000000],
                    ['description' => 'Payment Gateway Integration', 'quantity' => 1, 'price' => 5000000],
                ]),
            ],
            [
                'client_id' => 4,
                'quotation_number' => 'QUO-20240301-0003',
                'package_type' => 'custom',
                'subtotal' => 50000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 50000000,
                'status' => 'sent',
                'valid_until' => '2024-04-30',
                'sent_date' => '2024-03-05',
                'accepted_date' => null,
                'notes' => 'Penawaran untuk custom web application',
                'items' => json_encode([
                    ['description' => 'Custom Web Application', 'quantity' => 1, 'price' => 45000000],
                    ['description' => 'Training & Documentation', 'quantity' => 1, 'price' => 5000000],
                ]),
            ],
        ];

        foreach ($quotations as $quotation) {
            Quotation::create($quotation);
        }
    }
}

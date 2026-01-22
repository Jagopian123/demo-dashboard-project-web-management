<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = [
            [
                'project_id' => 1,
                'client_id' => 1,
                'invoice_number' => 'INV-20240215-0001',
                'subtotal' => 15000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 15000000,
                'paid_amount' => 15000000,
                'status' => 'paid',
                'issue_date' => '2024-02-15',
                'due_date' => '2024-03-01',
                'paid_date' => '2024-02-20',
                'notes' => 'Terima kasih atas pembayarannya',
                'items' => json_encode([
                    ['description' => 'Company Profile Website', 'quantity' => 1, 'price' => 15000000],
                ]),
            ],
            [
                'project_id' => 2,
                'client_id' => 2,
                'invoice_number' => 'INV-20240301-0002',
                'subtotal' => 35000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 35000000,
                'paid_amount' => 17500000,
                'status' => 'partial',
                'issue_date' => '2024-03-01',
                'due_date' => '2024-04-30',
                'paid_date' => null,
                'notes' => 'DP 50% sudah dibayar',
                'items' => json_encode([
                    ['description' => 'E-Commerce Website', 'quantity' => 1, 'price' => 30000000],
                    ['description' => 'Payment Gateway Integration', 'quantity' => 1, 'price' => 5000000],
                ]),
            ],
            [
                'project_id' => 3,
                'client_id' => 3,
                'invoice_number' => 'INV-20240315-0003',
                'subtotal' => 5000000,
                'discount' => 0,
                'tax' => 0,
                'total' => 5000000,
                'paid_amount' => 0,
                'status' => 'unpaid',
                'issue_date' => '2024-03-15',
                'due_date' => '2024-03-30',
                'paid_date' => null,
                'notes' => 'Pembayaran setelah approval final',
                'items' => json_encode([
                    ['description' => 'Landing Page', 'quantity' => 1, 'price' => 5000000],
                ]),
            ],
        ];

        foreach ($invoices as $invoice) {
            Invoice::create($invoice);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'invoice_id' => 1,
                'payment_number' => 'PAY-20240220-0001',
                'amount' => 15000000,
                'payment_method' => 'bank_transfer',
                'payment_date' => '2024-02-20',
                'reference_number' => 'TRF20240220001',
                'notes' => 'Pembayaran lunas',
            ],
            [
                'invoice_id' => 2,
                'payment_number' => 'PAY-20240305-0002',
                'amount' => 17500000,
                'payment_method' => 'bank_transfer',
                'payment_date' => '2024-03-05',
                'reference_number' => 'TRF20240305001',
                'notes' => 'Pembayaran DP 50%',
            ],
        ];

        foreach ($payments as $payment) {
            Payment::withoutEvents(function () use ($payment) {
                Payment::create($payment);
            });
        }
    }
}

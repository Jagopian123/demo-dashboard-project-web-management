<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'client_id' => 1,
                'name' => 'Website Company Profile PT. Maju Jaya',
                'code' => 'PRJ-2024-001',
                'status' => 'completed',
                'priority' => 'high',
                'description' => 'Pembuatan website company profile dengan fitur portfolio dan blog',
                'price' => 15000000,
                'progress' => 100,
                'start_date' => '2024-01-01',
                'deadline' => '2024-02-15',
                'completed_date' => '2024-02-10',
                'project_url' => 'https://majujaya.com',
                'notes' => 'Project selesai sebelum deadline',
            ],
            [
                'client_id' => 2,
                'name' => 'E-Commerce Website CV. Berkah Sejahtera',
                'code' => 'PRJ-2024-002',
                'status' => 'in_progress',
                'priority' => 'high',
                'description' => 'Website e-commerce dengan payment gateway dan admin dashboard',
                'price' => 35000000,
                'progress' => 65,
                'start_date' => '2024-02-01',
                'deadline' => '2024-04-30',
                'completed_date' => null,
                'project_url' => 'https://dev.berkahsejahtera.co.id',
                'notes' => 'Sedang tahap testing payment gateway',
            ],
            [
                'client_id' => 3,
                'name' => 'Landing Page Toko Online Rahayu',
                'code' => 'PRJ-2024-003',
                'status' => 'review',
                'priority' => 'medium',
                'description' => 'Landing page untuk campaign promo',
                'price' => 5000000,
                'progress' => 90,
                'start_date' => '2024-03-01',
                'deadline' => '2024-03-20',
                'completed_date' => null,
                'project_url' => 'https://promo.tokorahayu.com',
                'notes' => 'Menunggu approval final dari klien',
            ],
            [
                'client_id' => 4,
                'name' => 'Web Application PT. Global Tech',
                'code' => 'PRJ-2024-004',
                'status' => 'quotation',
                'priority' => 'high',
                'description' => 'Custom web application untuk internal management',
                'price' => 50000000,
                'progress' => 0,
                'start_date' => null,
                'deadline' => null,
                'completed_date' => null,
                'project_url' => null,
                'notes' => 'Menunggu approval quotation',
            ],
            [
                'client_id' => 5,
                'name' => 'Personal Portfolio Budi Santoso',
                'code' => 'PRJ-2024-005',
                'status' => 'on_hold',
                'priority' => 'low',
                'description' => 'Website portfolio personal dengan blog',
                'price' => 3000000,
                'progress' => 30,
                'start_date' => '2024-02-15',
                'deadline' => '2024-04-15',
                'completed_date' => null,
                'project_url' => null,
                'notes' => 'Klien request postpone karena kesibukan',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}

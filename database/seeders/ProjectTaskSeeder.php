<?php

namespace Database\Seeders;

use App\Models\ProjectTask;
use Illuminate\Database\Seeder;

class ProjectTaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'project_id' => 2,
                'title' => 'Setup Database',
                'description' => 'Design dan setup database structure',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-02-10',
                'completed_date' => '2024-02-08',
                'order' => 1,
            ],
            [
                'project_id' => 2,
                'title' => 'Design UI/UX',
                'description' => 'Design mockup dan prototype',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-02-20',
                'completed_date' => '2024-02-18',
                'order' => 2,
            ],
            [
                'project_id' => 2,
                'title' => 'Frontend Development',
                'description' => 'Coding frontend pages',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-03-15',
                'completed_date' => '2024-03-12',
                'order' => 3,
            ],
            [
                'project_id' => 2,
                'title' => 'Payment Gateway Integration',
                'description' => 'Integrate payment gateway',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => '2024-04-10',
                'completed_date' => null,
                'order' => 4,
            ],
            [
                'project_id' => 2,
                'title' => 'Testing & QA',
                'description' => 'Testing semua fitur',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-04-25',
                'completed_date' => null,
                'order' => 5,
            ],
        ];

        foreach ($tasks as $task) {
            ProjectTask::create($task);
        }
    }
}
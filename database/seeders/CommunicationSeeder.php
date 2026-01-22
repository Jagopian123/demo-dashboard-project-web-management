<?php

namespace Database\Seeders;

use App\Models\Communication;
use Illuminate\Database\Seeder;

class CommunicationSeeder extends Seeder
{
    public function run(): void
    {
        $communications = [
            [
                'client_id' => 1,
                'project_id' => 1,
                'type' => 'email',
                'subject' => 'Approval Design',
                'message' => 'Design sudah diapprove oleh klien',
                'communication_date' => '2024-01-15 10:30:00',
            ],
            [
                'client_id' => 2,
                'project_id' => 2,
                'type' => 'meeting',
                'subject' => 'Progress Meeting',
                'message' => 'Meeting untuk discuss progress dan next steps',
                'communication_date' => '2024-03-10 14:00:00',
            ],
            [
                'client_id' => 3,
                'project_id' => 3,
                'type' => 'phone',
                'subject' => 'Follow Up',
                'message' => 'Follow up untuk approval final',
                'communication_date' => '2024-03-18 09:00:00',
            ],
        ];

        foreach ($communications as $communication) {
            Communication::create($communication);
        }
    }
}


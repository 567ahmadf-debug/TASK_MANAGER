<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{

    public function run(): void
    {
        $tasks = [
            [
                'user_id' => '1',
                'title' => 't1',
                'description' => 'd1',
                'priority' => 'low',
            ],
            [
                'user_id' => '1',
                'title' => 't2',
                'description' => 'd2',
                'priority' => 'mid',
            ],
            [
                'user_id' => '2',
                'title' => 't3',
                'description' => 'd3',
                'priority' => 'mid',
            ],
            [
                'user_id' => '2',
                'title' => 't4',
                'description' => 'd3',
                'priority' => 'high',
            ]
        ];


        foreach ($tasks as $task)
            Task::create($task);
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function task_model_has_toggle_status_method()
    {
        // generate 1 record task pada table `tasks`
        $task = Task::factory()->create();

        // panggil method `toggleSTatus()`
        $task->toggleStatus();

        // kolom is_done pada record task berubah menjadi 1
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'is_done' => 1
        ]);

        // panggil methodnya lagi
        $task->toggleStatus();

        // kolom is_done pada record task barubah menjadi 0
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'is_done' => 0
        ]);

    }
}

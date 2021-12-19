<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_task()
    {
        // $this->assertTrue(true);

        // user buka halaman daftar task
        $this->visit('/tasks');

        // isi form `name` dan `description` kemudian submit
        $this->submitForm('Create Task', [
            'name' => 'My First Task',
            'description' => 'This is my first task on my new job.'
        ]);

        // lihat record terseimpan ke database
        $this->seeInDatabase('tasks', [
            'name' => 'My First Task',
            'description' => 'This is my first task on my new job.',
            'is_done' => 0,
        ]);

        // redirect ke halaman daftar task
        $this->seePageIs('/tasks');

        // tampil hasil task yang telah diinput
        $this->see('My First Task');
        $this->see('This is my first task on my new job.');
    }

    /** @test */
    public function task_entry_must_pass_validation()
    {
        // submit form baru
        // dengan field name & description kosong
        $this->post('/tasks', [
            'name' => '',
            'description' => '',
        ]);

        // cek pada session apakah ada error
        // untuk field nama dan description
        $this->assertSessionHasErrors(['name','description']);
    }

    /** @test */
    public function user_can_browser_tasks_index_page()
    {
        // generate 3 record task pada table `tasks`
        $task1 = Task::create([
            'name' => 'task 1',
            'description' => 'ini task 1'
        ]);

        $task2 = Task::create([
            'name' => 'task 2',
            'description' => 'ini task 2'
        ]);

        $task3 = Task::create([
            'name' => 'task 3',
            'description' => 'ini task 3'
        ]);



        // user membuka halaman Daftar Task
        $this->visit('/tasks');

        // user melihat ketiga task tampil pada halaman
        $this->see($task1->name);
        $this->see($task2->name);
        $this->see($task3->name);

        // user melihat link untuk edit task pada masing-masing item task
        $this->seeElement('a', [
            'id' => 'edit_task_' . $task1->id,
            'href' => url('tasks?action=edit&id='.$task1->id)
        ]);

        $this->seeElement('a', [
            'id' => 'edit_task_' . $task2->id,
            'href' => url('tasks?action=edit&id='.$task2->id)
        ]);

        $this->seeElement('a', [
            'id' => 'edit_task_' . $task3->id,
            'href' => url('tasks?action=edit&id='.$task3->id)
        ]);


    }

    /** @test */
    public function user_can_edit_an_existing_task()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function user_can_delete_an_existing_task()
    {
        $this->assertTrue(true);
    }
}

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
        // Generate 1 record task pada table `tasks`.
        $task = Task::create([
            'name' => 'task 1',
            'description' => 'deskripsi task 1'
        ]);

        // User membuka halaman Daftar Task
        $this->visit('/tasks');

        // Klik tombol edit task
        $this->click('edit_task_' . $task->id);

        // Lihat URL yang dituju sesuai dengan target
        $this->seePageIs('/tasks?action=edit&id=' . $task->id);

        // tampil form edit task
        $this->seeElement('form', [
            'id' => 'edit_task_' . $task->id,
            'action' => url('tasks/' . $task->id),
        ]);

        // user submit form berisi nama dan deskripsi
        $this->submitForm('Update Task', [
            'name' => 'Updated Task',
            'description' => 'Updated task description.'
        ]);

        // lihat halaman web ter-redirect ke url sesuai dengan target
        $this->seePageIs('/tasks');

        // record pada database berubah sesuai dengan nama dan deskripsi
        $this->seeInDatabase('tasks', [
            'id' => $task->id,
            'name' => 'Updated Task',
            'description' => 'Updated task description.'
        ]);
    }

    /** @test */
    public function user_can_delete_an_existing_task()
    {
        // generate 1 record task pada table `tasks`
        $task = Task::create([
            'name' => 'task 1',
            'description' => 'ini task 1'
        ]);

        // user membuka halaman daftar task
        $this->visit('/tasks');

        // user tekan tombol `hapus task`
        $this->press('delete_task_' . $task->id);

        // lihat halaman web ter-redirect ke halaman daftar task
        $this->seePageIs('/tasks');

        // record task hilang dari database
        $this->dontSeeInDatabase('tasks', [
            'id' => $task->id,
        ]);

    }
}

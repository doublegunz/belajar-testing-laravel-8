<?php

namespace Tests\Feature;

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
        $this->assertTrue(true);
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

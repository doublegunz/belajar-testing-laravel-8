<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    // trait refresh database agar migration dijalankan
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        // Kunjungi halaman '/register'
        $this->visit('/register');

        // Submit form register dengan name, email dan password 2 kali
        $this->submitForm('Register', [
            'name'                  => 'username',
            'email'                 => 'username@example.net',
            'password'              => 'secret12345',
            'password_confirmation' => 'secret12345',
        ]);

        // lihat halaman ter-redirect ke url '/home' (register sukses)
        $this->seePageIs('/home');

        // ada tulisan 'Dashboard' di halaman home
        $this->seeText('Dashboard');

        // lihat di database user yang sudah register
        $this->seeInDatabase('users', [
            'name' => 'username',
            'email' => 'username@example.net'
        ]);

        // cek hash passwrod
        $this->assertTrue(app('hash')->check('secret12345', User::first()->password));
    }

    /** @test */
    public function user_name_is_required()
    {
        $this->post('/register', [
            'name' => '',
            'email' => 'username@tes.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_name_maximum_is_255_character()
    {
        $this->post('/register', [
            'name' => str_repeat('John thor ', 26),
            'email' => 'username@tes.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['name']);
    }

    public function user_email_is_required()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => '',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['email']);
    }

    public function user_email_must_be_a_valid_email()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => 'nadia.example.net',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['email']);
    }

    public function user_email_maximum_is_255_characters()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => str_repeat('nadiarizky', 13) . '@gmail.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['email']);
    }

    public function user_email_must_be_unique_on_users_table()
    {
        $user = User::create([
            'name' => 'namename',
            'email' => 'emailsama@tes.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345'
        ]);

        $this->post('/register', [
            'name' => 'nadia rizky',
            'email' => 'emailsama@tes.com',
            'password' => 'secret123458',
            'password_confirmation' => 'secret123458'

        ]);

        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_password_is_required()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => 'nadia@tes.com',
            'password' => '',
            'password_confirmation' => 'secret12345'
        ]);

        $this->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_password_minimum_is_8_characters()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => 'nadia@tes.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->assertSessionHasErrors(['password']);

    }

    /** @test */
    public function user_password_must_be_same_with_password_confirmation()
    {
        $this->post('/register', [
            'name' => 'Nadia rizky',
            'email' => 'nadia@tes.com',
            'password' => 'secret12345',
            'password_confirmation' => 'secret432423'
        ]);

        $this->assertSessionHasErrors(['password']);

    }
}

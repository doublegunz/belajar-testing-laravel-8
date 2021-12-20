<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    // trait refresh database agar migration dijalankan
    use RefreshDatabase;

    /** @test */
    public function registered_user_can_login()
    {
        // memilki 1 user terdaftar
        $user = User::factory()->create([
            'email' => 'username@example.com',
            'password' => bcrypt('secret')
        ]);

        // kunjungi halaman '/login'
        $this->visit('/login');

        // submit form login dengan email dan password yang tepat
        $this->submitForm('Login', [
            'email' => 'username@example.com',
            'password' => 'secret',
        ]);

        // lihat halaman ter-redirect ke url '/home' (login sukses)
        $this->seePageIs('/home');

        // kita melihat halaman tulisan 'dashboard' pada halaman itu
        $this->seeText('Dashboard');
    }

    /** @test */
    public function logged_in_user_can_logout()
    {
        // kita memiliki 1 user terdaftar
        $user = User::factory()->create([
            'email' => 'username@example.com',
            'password' => bcrypt('secret')
        ]);

        // login sebagai user
        $this->actingAs($user);

        // kunjungi halaman home
        $this->visit('/home');

        // buat post request ke url '/logout'
        $this->post('/logout');

        // kunjungi lagi halaman 'home'
        $this->visit('/home');

        // user ter-redirect ke halaman '/login'
        $this->seePageIs('/login');
    }
}

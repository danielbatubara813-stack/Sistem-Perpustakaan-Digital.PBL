<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;

class LoginTest extends TestCase
{
    public function test_halaman_login_bisa_diakses()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_login_berhasil()
    {
        // Mock login berhasil
        Auth::shouldReceive('attempt')
            ->once()
            ->andReturn(true);

        $response = $this->post('/login', [
            'login_id' => 'user@test.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_login_gagal_jika_password_salah()
    {
        // Mock login gagal
        Auth::shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $response = $this->post('/login', [
            'login_id' => 'user@test.com',
            'password' => 'salah'
        ]);

        // Sesuai controller: pakai session 'error'
        $response->assertSessionHas('error');
    }

    public function test_validasi_input_kosong()
    {
        $response = $this->post('/login', [
            'login_id' => '',
            'password' => ''
        ]);

        $response->assertSessionHasErrors(['login_id', 'password']);
    }
}

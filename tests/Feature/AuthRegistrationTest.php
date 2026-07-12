<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_redirects_to_login_instead_of_logging_in_immediately(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Budi',
            'email' => 'budi@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertGuest();
        $response->assertSessionHas('alert_success', 'Pendaftaran berhasil! Silakan login terlebih dahulu.');
    }
}

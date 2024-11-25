<?php

use App\Models\User;

test('user can login through web interface', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password')
    ]);

    // Simula la navegación completa
    $response = $this->get('/login');
    $response->assertStatus(200);
    $response->assertSee('Log in');

    $response = $this->followingRedirects()->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password'
    ]);

    $response->assertStatus(200);
    expect(auth()->check())->toBeTrue();
    $response->assertSee($user->name);
})->group('e2e');

<?php

use App\Models\User;

test('user can login with correct credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password')
    ]);

    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'password'
    ]);

    $response->assertRedirect('/');
    expect(auth()->check())->toBeTrue();
});

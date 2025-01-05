<?php

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

test('Distintas sesiones en el mismo dispositivo', function () {
    $user1 = User::factory()->create([
        'email' => 'dani@malandrin.com',
        'password' => bcrypt('12345678'),
    ]);

    $user2 = User::factory()->create([
        'email' => 'primo@malandrin.com',
        'password' => bcrypt('12345678'),
    ]);

    $this->browse(function (Browser $firstBrowser, Browser $secondBrowser) use ($user1, $user2) {
        $firstBrowser->visit('/login')
                    ->type('email', $user1->email)
                    ->type('password', '12345678')
                    ->press('LOG IN')
                    ->assertPathIs('/')
                    ->assertSee($user1->name)
                    ->assertSee('Feedbacks')
                    ->type('title', 'Feedback de prueba')
                    ->type('description', 'Descripción de prueba')
                    ->press('Publicar Feedback')
                    ->waitFor('@vote-button')
                    ->click('@vote-button')
                    ->assertSee('Voto registrado con éxito')
                    ->waitFor('@vote-button')
                    ->click('@vote-button')
                    ->assertAttribute('#vote-debug', 'data-reason', 'error')
                    ->assertSee('Ya has votado')
                    ->deleteCookie('test')
                    ->waitFor('@vote-button')
                    ->click('@vote-button')
                    ->assertSee('Ya has votado')
                    ->assertAttribute('#vote-debug', 'data-reason', 'error');

        $secondBrowser->visit('/login')
                      ->type('email', $user2->email)
                      ->type('password', '12345678')
                      ->press('LOG IN')
                      ->assertPathIs('/')
                      ->assertSee($user2->name)
                      ->waitFor('@vote-button')
                      ->click('@vote-button')
                      ->assertSee('Ya has votado')
                      ->assertAttribute('#vote-debug', 'data-reason', 'error');
    });
});

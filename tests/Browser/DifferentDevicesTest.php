<?php

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

test('Diferentes dispositivos emulados', function () {
    $this->browse(function (Browser $iPhone, Browser $pixel, Browser $mac, Browser $windows) {
        $user1 = User::factory()->create([
            'email' => 'dani@malandrin.com',
            'password' => bcrypt('12345678'),
        ]);

        $iPhone->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15A372 Safari/604.1"});');
        sleep(1);
        $iPhone->resize(390, 844);
        $iPhone->visit('/login')
            ->type('email', $user1->email)
            ->type('password', '12345678')
            ->press('LOG IN')
            ->assertPathIs('/')
            ->assertDontSee($user1->name)
            ->assertSee('Feedbacks')
            ->type('title', 'Feedback de prueba')
            ->type('description', 'Descripción de prueba')
            ->press('Publicar Feedback')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Voto registrado con éxito')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertAttribute('#vote-debug', 'data-reason', 'cookie')                    
            ->assertSee('Ya has votado')
            ->deleteCookie('test')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $pixel->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Linux; Android 10; Pixel 4 XL) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Mobile Safari/537.36"});');
        sleep(1);
        $pixel->resize(1440, 3040);
        $pixel->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $mac->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Safari/537.36"});');
        sleep(1);
        $mac->resize(2560, 1600);
        $mac->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $windows->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"});');
        sleep(1);
        $windows->resize(1920, 1080);
        $windows->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');
    });
});

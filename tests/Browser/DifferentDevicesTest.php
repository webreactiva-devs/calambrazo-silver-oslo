<?php

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

test('Diferentes dispositivos emulados', function () {
    $this->browse(function (Browser $iPhone, Browser $Pixel, Browser $Mac, Browser $Windows) {
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
            ->screenshot('iphone')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $Pixel->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Linux; Android 10; Pixel 4 XL) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.77 Mobile Safari/537.36"});');
        sleep(1);
        $Pixel->resize(1440, 3040);
        $Pixel->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->screenshot('iphone')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $Mac->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Version/14.0 Safari/537.36"});');
        sleep(1);
        $Mac->resize(2560, 1600);
        $Mac->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->screenshot('iphone')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');

        $Windows->script('Object.defineProperty(navigator, "userAgent", {get: () => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36"});');
        sleep(1);
        $Windows->resize(1920, 1080);
        $Windows->visit('/')
            ->waitForText('Feedbacks')
            ->assertSee('Feedbacks')
            ->waitFor('@vote-button')
            ->click('@vote-button')
            ->assertSee('Ya has votado')
            ->screenshot('iphone')
            ->assertAttribute('#vote-debug', 'data-reason', 'device');
    });
});

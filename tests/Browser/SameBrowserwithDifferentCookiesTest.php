<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

test('Votar con el mismo navegador cambiando las cookies', function () {
    $this->browse(function (Browser $browser) {

        $browser->visit('/register')
                ->type('name', 'Sergio González Merino')
                ->type('email', 'sergiogonzalezmerino@gmail.com')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->press('REGISTER')
                // ->visit('/login')
                // ->type('email', 'sergiogonzalezmerino@gmail.com')
                // ->type('password', '12345678')
                // ->press('LOG IN')
                ->assertSee('Feedbacks')
                ->screenshot('feedback')
                ->type('title', 'Feedback de prueba')
                ->type('description', 'Descripción de prueba')
                ->press('Publicar Feedback')
                ->waitFor('@vote-button')
                ->click('@vote-button')
                ->assertSee('Voto registrado con éxito')
                ->screenshot('message-vote-ok')
                ->waitFor('@vote-button')
                ->click('@vote-button')
                ->assertAttribute('#vote-debug', 'data-reason', 'cookie')
                ->assertSee('Ya has votado')
                ->screenshot('message-vote-error-cookies')
                ->deleteCookie('test')
                ->waitFor('@vote-button')
                ->click('@vote-button')
                ->assertSee('Ya has votado')
                ->assertAttribute('#vote-debug', 'data-reason', 'device')
                ->screenshot('message-vote-error-wihtout-cookies');
    });
});

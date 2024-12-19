<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

test('Carga la vista de Feedbacks', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('Feedbacks');
    });
});

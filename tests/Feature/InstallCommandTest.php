<?php

it('asks to confirm overriding perscom credentials and exits when false', function () {
    $this->artisan('install')
        ->expectsQuestion('We found your saved PERSCOM credentials. Do you wish to overwrite these credentials and continue?', false)
        ->assertExitCode(0);
});

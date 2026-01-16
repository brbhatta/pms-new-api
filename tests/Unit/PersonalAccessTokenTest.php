<?php

use Modules\User\Domain\Models\PersonalAccessToken;

describe('PersonalAccessToken', function () {
    it('generates a custom token in the correct format', function () {
        $appName = 'myapp';
        $token = PersonalAccessToken::generateCustomToken($appName);
        $parts = explode(':', $token);
        expect($parts)->toHaveCount(3);
        expect($parts[0])->toBe($appName);
        expect($parts[1])->toMatch('/^[a-f0-9]{32}$/');
        expect($parts[2])->not->toBeEmpty();
    });

    it('generates a custom token with a provided unique filer', function () {
        $appName = 'myapp';
        $uniqueFiler = 'custom-uuid';
        $token = PersonalAccessToken::generateCustomToken($appName, $uniqueFiler);
        $parts = explode(':', $token);
        expect($parts)->toHaveCount(3);
        expect($parts[0])->toBe($appName);
        expect($parts[1])->toMatch('/^[a-f0-9]{32}$/');
        expect($parts[2])->toBe($uniqueFiler);
    });
});

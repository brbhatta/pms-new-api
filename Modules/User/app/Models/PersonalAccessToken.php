<?php

namespace Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Random\RandomException;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasUuids;

    /**
     * Generate a new token in the format <app_name>:<token>:<unique_filer>
     *
     * @param  string  $appName
     * @param  string|null  $uniqueFiler
     * @return string
     * @throws RandomException
     */
    public static function generateCustomToken(string $appName, ?string $uniqueFiler = null): string
    {
        // 128-bit random token (16 bytes, hex encoded)
        $token = bin2hex(random_bytes(16));
        $uniqueFiler = $uniqueFiler ?? Str::uuid()->toString();

        return sprintf('%s:%s:%s', $appName, $token, $uniqueFiler);
    }
}

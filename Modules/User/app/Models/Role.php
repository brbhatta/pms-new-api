<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'level'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

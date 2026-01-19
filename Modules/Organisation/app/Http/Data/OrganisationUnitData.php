<?php

namespace Modules\Organisation\Http\Data;

use Spatie\LaravelData\Data;

class OrganisationUnitData extends Data
{
    public function __construct(
        public ?string $id = null,
        public string $name,
        public ?string $code = null,
        public string $type = 'department',
        public ?string $parent_id = null,
        public ?array $metadata = null
    ) {
    }
}

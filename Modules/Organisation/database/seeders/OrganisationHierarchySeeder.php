<?php

namespace Modules\Organisation\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Organisation\Models\OrganisationUnit;

class OrganisationHierarchySeeder extends Seeder
{
    public function run(): void
    {
        // Ministry of home affairs
        // └── Department of drug administration
        //      └── Division of regulation
        //           └── Registration Division
        //           └── Import Division
        $ministry = OrganisationUnit::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Ministry of home affairs',
            'code' => 'MOHA',
            'type' => 'department',
            'parent_id' => null,
            'metadata' => null,
        ]);

        $department = OrganisationUnit::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Department of drug administration',
            'code' => 'DDA',
            'type' => 'department',
            'parent_id' => $ministry->id,
            'metadata' => null,
        ]);

        $division = OrganisationUnit::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Division of regulation',
            'code' => 'DRD',
            'type' => 'department',
            'parent_id' => $department->id,
            'metadata' => null,
        ]);

        OrganisationUnit::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Registration Division',
            'code' => 'REG_DIV',
            'type' => 'department',
            'parent_id' => $division->id,
            'metadata' => null,
        ]);

        OrganisationUnit::create([
            'id' => Str::uuid()->toString(),
            'name' => 'Import Division',
            'code' => 'REG_IMP_DIV',
            'type' => 'department',
            'parent_id' => $division->id,
            'metadata' => null,
        ]);
    }
}

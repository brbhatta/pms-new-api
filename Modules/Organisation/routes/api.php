<?php

use Illuminate\Support\Facades\Route;
use Modules\Organisation\Http\Controllers\OrganisationUnitController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('organisation-units', OrganisationUnitController::class)->names('organisation');
    Route::post('organisation-units/{unitId}/assign/{userId}', [OrganisationUnitController::class, 'assignUserToUnit']);
});

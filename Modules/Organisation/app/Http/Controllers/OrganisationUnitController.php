<?php

namespace Modules\Organisation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenericResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Organisation\Application\Contracts\OrganisationUnitServiceInterface;
use Modules\Organisation\Http\Data\OrganisationUnitData;

class OrganisationUnitController extends Controller
{
    public function __construct(private readonly OrganisationUnitServiceInterface $service)
    {
    }

    public function index(): JsonResource
    {
        $data = $this->service->getPaginatedUnits();
        return GenericResponse::collection($data);
    }

    public function store(Request $request)
    {
        $data = OrganisationUnitData::from($request->all());
        $result = $this->service->createUnit($data);
        return GenericResponse::resource($result);
    }

    public function show(string $id)
    {
        $result = $this->service->getUnitById($id);
        return GenericResponse::resource($result);
    }

    public function update(Request $request, string $id)
    {
        $data = OrganisationUnitData::from($request->all());
        $result = $this->service->updateUnit($id, $data);
        return GenericResponse::resource($result);
    }

    public function destroy(string $id)
    {
        $this->service->deleteUnit($id);
        return GenericResponse::success();
    }
}

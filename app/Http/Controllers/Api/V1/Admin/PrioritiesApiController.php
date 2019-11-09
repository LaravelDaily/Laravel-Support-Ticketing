<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePriorityRequest;
use App\Http\Requests\UpdatePriorityRequest;
use App\Http\Resources\Admin\PriorityResource;
use App\Priority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrioritiesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('priority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PriorityResource(Priority::all());
    }

    public function store(StorePriorityRequest $request)
    {
        $priority = Priority::create($request->all());

        return (new PriorityResource($priority))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Priority $priority)
    {
        abort_if(Gate::denies('priority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PriorityResource($priority);
    }

    public function update(UpdatePriorityRequest $request, Priority $priority)
    {
        $priority->update($request->all());

        return (new PriorityResource($priority))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Priority $priority)
    {
        abort_if(Gate::denies('priority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $priority->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

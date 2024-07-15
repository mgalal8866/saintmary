<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreViewServiceRequest;
use App\Http\Requests\UpdateViewServiceRequest;
use App\Models\Service;
use App\Models\ServicesAttribute;
use App\Models\ViewService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewServiceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('view_service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $viewServices = ViewService::with(['service', 'service_attribute'])->get();

        return view('admin.viewServices.index', compact('viewServices'));
    }

    public function create()
    {
        abort_if(Gate::denies('view_service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_attributes = ServicesAttribute::pluck('value', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.viewServices.create', compact('service_attributes', 'services'));
    }

    public function store(StoreViewServiceRequest $request)
    {

        $viewService = ViewService::create($request->all());

        return redirect()->route('admin.view-services.index');
    }

    public function edit(ViewService $viewService)
    {
        abort_if(Gate::denies('view_service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_attributes = ServicesAttribute::pluck('value', 'id')->prepend(trans('global.pleaseSelect'), '');

        $viewService->load('service', 'service_attribute');

        return view('admin.viewServices.edit', compact('service_attributes', 'services', 'viewService'));
    }

    public function update(UpdateViewServiceRequest $request, ViewService $viewService)
    {
        $viewService->update($request->all());

        return redirect()->route('admin.view-services.index');
    }

    public function show(ViewService $viewService)
    {
        abort_if(Gate::denies('view_service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $viewService->load('service', 'service_attribute');
        dd(       $viewService  )   ;
        return view('admin.viewServices.show', compact('viewService'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicesAttributeRequest;
use App\Http\Requests\StoreServicesAttributeRequest;
use App\Http\Requests\UpdateServicesAttributeRequest;
use App\Models\Service;
use App\Models\ServicesAttribute;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesAttributeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('services_attribute_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicesAttributes = ServicesAttribute::with(['service'])->get();

        return view('admin.servicesAttributes.index', compact('servicesAttributes'));
    }

    public function create()
    {
        abort_if(Gate::denies('services_attribute_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servicesAttributes.create', compact('services'));
    }

    public function store(StoreServicesAttributeRequest $request)
    {
        $data = [
            'value' => $request->value,
            'type' => $request->type,
            'service_id' => $request->service_id,
            'linkservice' => $request->linkservice,
        ];

        $servicesAttributecount = ServicesAttribute::where(['service_id' => $request->service_id])->get();
        
        if ($servicesAttributecount->count() > 0) {

            if ($request->main == 1) {
                ServicesAttribute::where(['service_id' => $request->service_id])->update(['main' => 0]);

                $data['main'] =  1 ;
            } else {
                $data['main'] =  0;
            }
        } else {

            $data['main'] =  1;
        }
        if ($request->has('selecttype')) {
            foreach ($request->selecttype as $index => $item) {
                $var[] = ['id' => ($index + 1), 'value' => $item];
            }
            $data['selecttype'] =  $var;
        }

        $servicesAttribute = ServicesAttribute::create($data);

        // return redirect()->route('admin.services-attributes.index');
    }

    public function edit(ServicesAttribute $servicesAttribute)
    {
        abort_if(Gate::denies('services_attribute_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicesAttribute->load('service');

        return view('admin.servicesAttributes.edit', compact('services', 'servicesAttribute'));
    }

    public function update(UpdateServicesAttributeRequest $request, ServicesAttribute $servicesAttribute)
    {
        $servicesAttribute->update($request->all());

        return redirect()->route('admin.services-attributes.index');
    }

    public function show(ServicesAttribute $servicesAttribute)
    {
        abort_if(Gate::denies('services_attribute_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicesAttribute->load('service');

        return view('admin.servicesAttributes.show', compact('servicesAttribute'));
    }

    public function destroy(ServicesAttribute $servicesAttribute)
    {
        abort_if(Gate::denies('services_attribute_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicesAttribute->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicesAttributeRequest $request)
    {
        $servicesAttributes = ServicesAttribute::find(request('ids'));

        foreach ($servicesAttributes as $servicesAttribute) {
            $servicesAttribute->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\ServicesAttribute;
use App\Models\ViewService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::with(['service', 'subservies'])->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subservies = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.services.create', compact('services', 'subservies'));
    }
    public function viewservice($id)
    {
        $modelservice = Service::with(['subservies', 'service_attribute'])->findOrFail($id);

        $modelviewservice = ViewService::where('service_id', $id)->whereIn('service_attribute_id', $modelservice->service_attribute->pluck('id')->toarray())->get();
        // dd( $id,$modelservice->service_attribute->pluck('id')->toarray());
        return view('admin.viewServices.view', compact('modelservice', 'modelviewservice'));
    }
    public function create_parent_service($id)
    {
        $services_attribute = ServicesAttribute::where('service_id', $id)->get();


        return view('admin.viewServices.create', compact(['services_attribute', 'id']));
    }
    public function save_parent_service(Request $request)
    {

        $data =[];

        foreach ($request->all() as  $key => $value) {
            if (preg_match('/^input-(\d+)$/', $key, $matches)) {
                $data[]=['name'=>$value,'service_id'=>$request->service_id,'service_attribute_id'=>$matches[1]];
            }
        };
        foreach ($data as $entry) {
            ViewService::create($entry);
        }
   

        return redirect()->route('admin.service.view',['id'=>$request->service_id]);
    }
    public function getSubservice(Request $request)
    {
        $service = Service::pluck('name', 'id');
        return response()->json($service);
    }
    public function store(StoreServiceRequest $request)
    {
        $service = Service::create($request->all());

        return redirect()->route('admin.services.index');
    }

    public function edit(Service $service)
    {
        abort_if(Gate::denies('service_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subservies = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service->load('service', 'subservies');

        return view('admin.services.edit', compact('service', 'services', 'subservies'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->all());

        return redirect()->route('admin.services.index');
    }

    public function show(Service $service)
    {
        abort_if(Gate::denies('service_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->load('service', 'subservies');

        return view('admin.services.show', compact('service'));
    }

    public function destroy(Service $service)
    {
        abort_if(Gate::denies('service_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $service->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceRequest $request)
    {
        $services = Service::find(request('ids'));

        foreach ($services as $service) {
            $service->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

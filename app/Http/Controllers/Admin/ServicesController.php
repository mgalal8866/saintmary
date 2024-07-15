<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Service;
use App\Models\Permission;
use App\Models\ViewService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ServicesAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyServiceRequest;

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
        $modelviewservice = ViewService::where('service_id', $id)->get();
        abort_if(Gate::denies($modelservice->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.viewServices.view', compact('modelservice', 'modelviewservice'));
    }
    public function create_parent_service($id)
    {
        $services_attribute = ServicesAttribute::where('service_id', $id)->get();


        return view('admin.viewServices.create', compact(['services_attribute', 'id']));
    }
    public function save_parent_service(Request $request)
    {
        $data = [];
        foreach ($request->all() as  $key => $value) {
            if (preg_match('/^input-(\d+)$/', $key, $matches)) {
                // $data[]=['name'=>$value,'service_id'=>$request->service_id,'service_attribute_id'=>$matches[1]];
                $data[] = ['id' => $matches[1], 'value' => $value];
            }
        };
        // foreach ($data as $entry) {
        ViewService::create([
            'service_id' => $request->service_id,
            'data'      => $data
        ]);
        // }
        return redirect()->route('admin.service.view', ['id' => $request->service_id]);
    }
    public function getSubservice(Request $request)
    {
        $service = ServicesAttribute::where('service_id', $request->service_id)->get(['id', 'value']);
        return response()->json($service);
    }
    public function getuserby(Request $request)
    {

        $service = ViewService::where('service_id', $request->service_id)->with(['service.service_attribute' =>function($q){
            $q->where('main','1');
        }])->get();
        return response()->json($service);
    }
    public function store(StoreServiceRequest $request)
    {
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;

        // Check if the slug already exists and generate a new one if necessary
        while (Service::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
        $data = $request->all();
        $data['slug'] = $slug;
        Permission::create(['title' => $data['slug']]);
        $service = Service::create($data);

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

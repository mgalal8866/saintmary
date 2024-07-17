<?php

namespace App\Http\Controllers\Admin;

use Gate;

use App\Models\Permission;
use App\Models\Viewcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\categorysAttribute;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroycategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categorys = Category::with(['service'])->get();
        return view('admin.category.index', compact('categorys'));
    }

    public function create()
    {
        // abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categorys = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.category.create', compact('categorys'));
    }
    public function viewcategory($id)
    {
        $modelcategory = Category::with(['subservies', 'category_attribute'])->findOrFail($id);
        $modelviewcategory = ViewCategory::where('category_id', $id)->get();
        // abort_if(Gate::denies($modelcategory->slug), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.category.view', compact('modelcategory', 'modelviewcategory'));
    }




    public function store(StorecategoryRequest $request)
    {



        Category::create(['name' => $request->name]);


        return redirect()->route('admin.category.index');
    }

    public function edit(category $category)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->load('service');
        return view('admin.category.edit', compact('category'));
    }

    public function update(StorecategoryRequest $request, category $category)
    {
        $category->update($request->all());

        return redirect()->route('admin.category.index');
    }

    public function show(Category $category)
    {
        abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $category->load('service');

        return view('admin.category.show', compact('category'));
    }

    public function destroy(category $category)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return back();
    }

    public function massDestroy(MassDestroycategoryRequest $request)
    {
        $categorys = Category::find(request('ids'));
        foreach ($categorys as $category) {
            $category->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

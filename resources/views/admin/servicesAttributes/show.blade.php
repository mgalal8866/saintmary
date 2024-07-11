@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.servicesAttribute.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.services-attributes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.id') }}
                        </th>
                        <td>
                            {{ $servicesAttribute->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.service') }}
                        </th>
                        <td>
                            {{ $servicesAttribute->service->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.value') }}
                        </th>
                        <td>
                            {{ $servicesAttribute->value }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\ServicesAttribute::TYPE_SELECT[$servicesAttribute->type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.services-attributes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
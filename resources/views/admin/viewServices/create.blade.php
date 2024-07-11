@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.viewService.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.parent.service.save') }}" enctype="multipart/form-data">
                @csrf
                <input class="form-control " name="service_id" id="service_id" value="{{ $id }}" hidden>

                @foreach ($services_attribute as $item)
                    @if ($item->type == 'text')
                        <div class="form-group">
                            <label for="name">{{ $item->value }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="input-{{ $item->id }}" id="input-{{ $item->id }}"
                                value="">
                        </div>
                    @endif
                    {{-- @if ($item->type == 'select')
                        <div class="form-group">
                            <label class="required" for="service_id">{{ trans('cruds.viewService.fields.service') }}</label>
                            <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}"
                                name="input-{{ $item->id }}" id="service_id" required>
                                @foreach ($item->selecttype as $item2)
                                    <option value="{{ $item2['id'] }}"> {{ $item2['name'] }}</option>
                                @endforeach
                            </select>

                        </div>
                    @endif --}}
                    {{-- @if ($item->type == 'image')
            <div class="form-group">
                <label for="name">{{ $item->value }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                    name="input-{{  $item->id }}" id="input-{{  $item->id }}" value="{{ old('name', '') }}">
            </div>
            @endif --}}
                @endforeach

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

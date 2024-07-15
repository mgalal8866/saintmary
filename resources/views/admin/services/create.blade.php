@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.service.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.service.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                        id="name" value="{{ old('name', '') }}" required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.service.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="service_id">{{ trans('cruds.service.fields.service') }}</label>
                    <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}" name="service_id"
                        id="service_id">
                        @foreach ($services as $id => $entry)
                            <option value="{{ $id }}" {{ old('service_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('service'))
                        <span class="text-danger">{{ $errors->first('service') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.service.fields.service_helper') }}</span>
                </div>

                {{-- <div class="form-group">
                <label for="subservies_id">{{ trans('cruds.service.fields.subservies') }}</label>
            <select class="form-control select2 {{ $errors->has('subservies') ? 'is-invalid' : '' }}" name="subservies_id" id="subservies_id">
                @foreach ($subservies as $id => $entry)
                <option value="{{ $id }}" {{ old('subservies_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                @endforeach
            </select>
            @if ($errors->has('subservies'))
            <span class="text-danger">{{ $errors->first('subservies') }}</span>
            @endif
            <span class="help-block">{{ trans('cruds.service.fields.subservies_helper') }}</span>
    </div>
    <div class="form-group">
        <div class="form-check {{ $errors->has('mainservice') ? 'is-invalid' : '' }}">
            <input type="hidden" name="mainservice" value="0">
            <input class="form-check-input" type="checkbox" name="mainservice" id="mainservice" value="1" {{ old('mainservice', 0) == 1 ? 'checked' : '' }}>
            <label class="form-check-label" for="mainservice">{{ trans('cruds.service.fields.mainservice') }}</label>
        </div>
        @if ($errors->has('mainservice'))
        <span class="text-danger">{{ $errors->first('mainservice') }}</span>
        @endif
        <span class="help-block">{{ trans('cruds.service.fields.mainservice_helper') }}</span>
    </div> --}}
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

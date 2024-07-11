@extends('layouts.admin')
@section('styles')
<style>
.select2.select2-container.select2-container--default.select2-container--focus.select2-container--below{
    width: 100% !important;
}
.select2{

    width: 100% !important;
}
</style>
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.servicesAttribute.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.services-attributes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="service_id">{{ trans('cruds.servicesAttribute.fields.service') }}</label>
                <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}" name="service_id" id="service_id" required>
                    @foreach($services as $id => $entry)
                    <option value="{{ $id }}" {{ old('service_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service'))
                <span class="text-danger">{{ $errors->first('service') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicesAttribute.fields.service_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="value">{{ trans('cruds.servicesAttribute.fields.value') }}</label>
                <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="text" name="value" id="value" value="{{ old('value', '') }}" required>
                @if($errors->has('value'))
                <span class="text-danger">{{ $errors->first('value') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicesAttribute.fields.value_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.servicesAttribute.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ServicesAttribute::TYPE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicesAttribute.fields.type_helper') }}</span>
            </div>
            <div class="form-group" id="gservice" style="display: none;">
                <label class="required">{{ trans('cruds.servicesAttribute.fields.table') }}</label>
                <select class="form-control {{ $errors->has('linkservice') ? 'is-invalid' : '' }}" name="linkservice" id="linkservice" >
                    <option value="">{{ trans("global.pleaseSelect") }}</option>
                </select>
                @if($errors->has('linkservice'))
                <span class="text-danger">{{ $errors->first('linkservice') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.servicesAttribute.fields.type_helper') }}</span>
            </div>
            <div class="form-group" id="selecttypediv" style="display: none;">
                <label class="required">{{ trans('cruds.servicesAttribute.fields.table') }}</label>
                <select class="form-control select2 " name="selecttype[]" id="selecttype" multiple >
                    <option value="">{{ trans("global.pleaseSelect") }}</option>
                </select>
                @if($errors->has('selecttype'))
                <span class="text-danger">{{ $errors->first('selecttype') }}</span>
                @endif

            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        $(".select2").select2({
            tags: true

        });
        $('#type').change(function() {
            var key = $(this).val();
            if (key == 'link') {
                $('#gservice').show();
                $.ajax({
                    url: '{{ route("getSubservice") }}'
                    , type: 'GET'
                    , dataType: 'json'
                    , headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    , success: function(data) {
                        console.log(data);
                        $('#linkservice').empty();
                        $('#linkservice').append('<option value="">{{ trans("global.pleaseSelect") }}</option>');
                        $.each(data, function(key, value) {
                            $('#linkservice').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
                $('#selecttypediv').attr('style', 'display: none;');
            } else if (key == 'select') {
                // console.log('select')
                $('#selecttypediv').attr('style', 'display: block;');

            } else {
                $('#selecttypediv').attr('style', 'display: none;');

                $('#linkservice').empty();
                $('#linkservice').append('<option value="">{{ trans("global.pleaseSelect") }}</option>');
                $('#gservice').hide();
            }
        });
    });

</script>


@endsection

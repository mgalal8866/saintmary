@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.account.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.accounts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="service_id">{{ trans('cruds.account.fields.service') }}</label>

                    <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}" name="service_id"
                        id="service_id" required>
                        <option value="" >اختار</option>
                        @foreach ($services as $id => $entry)
                            @can($entry->slug)
                                <option value="{{ $entry->id }}" {{ old('service_id') == $entry->id ? 'selected' : '' }}>
                                    {{ $entry->name }}</option>
                            @endcan
                        @endforeach
                    </select>
                    @if ($errors->has('service'))
                        <span class="text-danger">{{ $errors->first('service') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.account.fields.service_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="service_att">المستفيد</label>
                    <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}"
                        name="service_att" id="service_att" required>

                    </select>
                    @if ($errors->has('service'))
                        <span class="text-danger">{{ $errors->first('service') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.account.fields.service_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="value">{{ trans('cruds.account.fields.value') }}</label>
                    <input class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" type="number"
                        name="value" id="value" value="{{ old('value', '0') }}" step="0.01" required>
                    @if ($errors->has('value'))
                        <span class="text-danger">{{ $errors->first('value') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.account.fields.value_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.account.fields.type') }}</label>
                    <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type"
                        id="type" required>
                        <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>
                            {{ trans('global.pleaseSelect') }}</option>
                        @foreach (App\Models\Account::TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>
                                {{ $label }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.account.fields.type_helper') }}</span>
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
            $('#service_id').change(function() {
                var key = $(this).val();
                const serviceSelect = document.getElementById('service_id');
                // $('#gservice').show();
                $.ajax({
                    url: '{{ route('getuserby') }}',
                    type: 'GET',
                    data: {
                        service_id: serviceSelect.value
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        $('#service_att').empty();
                        $('#service_att').append(
                            '<option value="">{{ trans('global.pleaseSelect') }}</option>');
                        $.each(data, function(index, item) {
                            const serviceAttributeId = item['service'][
                                'service_attribute'
                            ][0]['id'];
                            const dataarray = item['data'];
                            const specificItem = dataarray.find(dataItem => {
                                return dataItem.id.toString() ===
                                    serviceAttributeId.toString();
                            });

                            if (specificItem) {
                                $('#service_att').append('<option value="' + item[
                                    'id'] + '">' + specificItem.value + '</option>');
                            }
                        });
                    }
                });

            });
        });
    </script>
@endsection

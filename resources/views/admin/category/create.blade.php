@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} قسم
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="required" for="name">name</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                        name="name" id="name" value="{{ old('name', '') }}"   required>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    {{-- <span class="help-block">{{ trans('cruds.category.fields.value_helper') }}</span> --}}
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
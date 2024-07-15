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
                                name="input-{{ $item->id }}" id="input-{{ $item->id }}" value="">
                        </div>
                    @elseif ($item->type == 'number')
                        <div class="form-group">
                            <label for="name">{{ $item->value }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="number"
                                name="input-{{ $item->id }}" id="input-{{ $item->id }}" value="">
                        </div>
                    @elseif ($item->type == 'select')
                        <div class="form-group">
                            <label for="name">{{ $item->value }}</label>
                            <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}"
                                name="input-{{ $item->id }}" id="service_id" required>
                                @foreach ($item->selecttype as $item2)
                                    <option value="{{ $item2['id'] }}"> {{ $item2['value'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($item->type == 'link')
                   
                        <div class="form-group">
                            <label for="name">{{ $item->value }}</label>
                            <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}"
                                name="input-{{ $item->id }}" id="service_id" required>
                                {{-- @foreach ($item->selecttype as $item2)
                                    <option value="{{ $item2['id'] }}"> {{ $item2['value'] }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                    @elseif ($item->type == 'image')
                    <div class="form-group">
                        <label for="image">{{ trans('cruds.img.fields.image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                        </div>
                        @if($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.img.fields.image_helper') }}</span>
                    </div>
                    @endif

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

@section('scripts')
    <script>
        Dropzone.options.imageDropzone = {
            url: '{{ route('admin.imgs.storeMedia') }}',
            maxFilesize: 2, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                $('form').find('input[name="image"]').remove()
                $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
            },
            removedfile: function(file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function() {
                @if (isset($img) && $img->image)
                    var file = {!! json_encode($img->image) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection

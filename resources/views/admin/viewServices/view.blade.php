@extends('layouts.admin')
@section('content')
    @can('service_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.parent.service.create', ['id' => $modelservice->id]) }}">
                    {{ trans('global.add') }} {{ trans('cruds.service.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ $modelservice->name }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Service">
                    <thead>
                        <tr>

                            @forelse ($modelservice->service_attribute as $item)
                                <th>
                                    {{ $item->value }}
                                </th>
                            @empty
                                No Data
                            @endforelse


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modelviewservice as $key => $service)
                            <tr>
                                @foreach ($modelservice->service_attribute as $item1)
                                    @if (is_array($service->data))
                                        {{-- @foreach ($service->data as $item) --}}
                                        {{-- @if ($item1->id == $item['id']) --}}
                                        {{-- {{    json_encode($service->data)}} --}}
                                        @php
                                        $it = json_encode($service->data);
                                        $data = collect(json_decode($it, true));
                                        $exists = $data->contains('id', $item1->id);
                                        $item = $data->firstWhere('id',$item1->id);
                                        @endphp

                                        @if ($exists)
                                            <td>
                                                @if ($item1->type == 'text')
                                                   {{$it[ $item] }}
                                                @elseif ($item1->type == 'link')
                                                      {{ $item['value'] }}
                                                    {{-- {{ $modelviewservice->where($service->service_id)->first() }} --}}
                                                @elseif ($item1->type == 'select')
                                                    {{ $item['value'] }}
                                                @elseif ($item1->type == 'number')
                                                      {{ $item['value'] }}
                                                @elseif ($item1->type == 'image')
                                                    {{ $item['value'] }}
                                                @endif
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif
                                    @else
                                        <td>
                                            {{ htmlspecialchars($service->data, ENT_QUOTES, 'UTF-8') }}
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('service_delete')
                let deleteButtonTrans =
                    '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                        global.datatables.delete ') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.services.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert(
                                '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        global.datatables.zero_selected ') }}'
                            )

                            return
                        }

                        if (confirm(
                                '{{ trans('
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                global.areYouSure ') }}'
                            )) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Service:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection

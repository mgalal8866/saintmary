@extends('layouts.admin')
@section('content')
    @can('category_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.category.create') }}">
                    {{ trans('global.add') }} قسم
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} الاقسام
        </div>
        <div class="card-body">
            <div class="card">

            </div>
            <div class="table-responsive">

                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                التصنيف
                            </th>

                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorys as $key => $category)
                            <tr data-entry-id="{{ $category->id }}">
                                <td>

                                </td>

                                <td>
                                    {{ $category->name ?? '' }}
                                </td>

                                <td>
                                    @can('category_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.category.show', $category->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('category_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.category.edit', $category->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('category_delete')
                                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

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
        // function getQueryParam(param) {
        //     var urlParams = new URLSearchParams(window.location.search);
        //     return urlParams.get(param);
        // }

        // // Function to set the selected option in the dropdown
        // function setSelectedOption() {
        //     var serviceId = getQueryParam('service_id');
        //     if (serviceId) {
        //         document.getElementById('serviceSelect').value = serviceId;
        //     }
        // }

        // // Set the selected option on page load
        // setSelectedOption();
        // document.getElementById('serviceSelect').addEventListener('change', function() {
        //     var serviceId = this.value;
        //     if (serviceId) {
        //         window.location.href = '?service_id=' + serviceId;
        //     } else {
        //         window.location.href = window.location.pathname; // URL without parameter
        //     }
        // });
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('category_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.categorys.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
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
            let table = $('.datatable-category:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection

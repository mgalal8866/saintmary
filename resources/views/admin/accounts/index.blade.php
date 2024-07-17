@extends('layouts.admin')
@section('content')
    @can('account_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.accounts.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.account.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('cruds.account.title_singular') }}
        </div>
        <div class="card-body">
            <div class="card">
                <form method="Get" action="accounts" enctype="multipart/form-data">

                    <div class="card-body">
                        @php
                            $sumIncome = 0;
                            $sumOutcome = 0;

                            foreach ($accounts as $account) {
                                if ($account['type'] == 'income') {
                                    $sumIncome += (float) $account['value'];
                                }
                                if ($account['type'] == 'expenses') {
                                    $sumOutcome += (float) $account['value'];
                                }
                            }
                        @endphp

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group ">
                                    <label class="required"
                                        for="service_id">{{ trans('cruds.account.fields.service') }}</label>
                                    <select id="serviceSelect" name="service_id" class="form-control">
                                        <option value="">جميع الخدمات</option>
                                        @foreach ($services as $item)
                                            @can($item->slug)
                                                <option value="{{ $item->id }}"
                                                    {{ request()->get('service_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endcan
                                        @endforeach
                                    </select>
                                    @if ($errors->has('service'))
                                        <span class="text-danger">{{ $errors->first('service') }}</span>
                                    @endif

                                </div>
                            </div>
                            <div class="col-4">


                                <div class="form-group">
                                    <label for="data">من</label>
                                    <input class="form-control date {{ $errors->has('data') ? 'is-invalid' : '' }}"
                                        type="text" name="fromdata" id="data"
                                        value="{{ request()->get('fromdata') }}">

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="data">الى</label>
                                    <input class="form-control date {{ $errors->has('data') ? 'is-invalid' : '' }}"
                                        type="text" name="todata" id="data"
                                        value="{{ request()->get('todata') }}">
                                    @if ($errors->has('data'))
                                        <span class="text-danger">{{ $errors->first('data') }}</span>
                                    @endif
                                    {{-- <span class="help-block">{{ trans('cruds.user.fields.data_helper') }}</span> --}}
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-outline-success" type="submit">Filter</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">

                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.account.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.account.fields.service') }}
                            </th>
                            <th>
                                المستفيد
                            </th>
                            <th>
                                {{ trans('cruds.account.fields.value') }}
                            </th>
                            <th>
                                {{ trans('cruds.account.fields.type') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $key => $account)
                            <tr data-entry-id="{{ $account->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $account->id ?? '' }}
                                </td>
                                <td>
                                    {{ $account->service->name ?? '' }}
                                </td>
                                <td>
                                    @php
                                        $viewService = App\Models\ViewService::find($account->service_att)->data ?? '';
                                        $service_attr = App\Models\ServicesAttribute::where([
                                            'main' => 1,
                                            'service_id' => $account->service_id,
                                        ])->first();
                                        $itselect = json_encode($viewService);
                                        $data_select = collect(json_decode($itselect, true));
                                        $ee = $data_select->firstWhere('id', $service_attr->id);
                                    @endphp
                                    <span>
                                        {{ $ee['value'] ?? '' }}

                                    </span>
                                    {{-- <span style="display:none">{{ $account->service->mainservice ?? '' }} --}}
                                    {{-- <input type="checkbox" disabled="disabled" {{ $account->service->mainservice ? 'checked' : '' }}> --}}
                                </td>
                                <td>
                                    {{ $account->value ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Account::TYPE_SELECT[$account->type] ?? '' }}
                                </td>
                                <td>
                                    @can('account_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.accounts.show', $account->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('account_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.accounts.edit', $account->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('account_delete')
                                        <form action="{{ route('admin.accounts.destroy', $account->id) }}" method="POST"
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
    <div class="card">
        <div class="card-body">
            <div class="table-basic">
                <tr>
                    <td>
                        <p>ايراد: {{ $sumIncome }}</p>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </div>
            <p>مصروف: {{ $sumOutcome }}</p>
            <p>الفرق: {{ $sumIncome - $sumOutcome }}</p>
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
            @can('account_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.accounts.massDestroy') }}",
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
            let table = $('.datatable-Account:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection

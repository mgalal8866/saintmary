@extends('layouts.admin')
@section('content')
@can('services_attribute_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.services-attributes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.servicesAttribute.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.servicesAttribute.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ServicesAttribute">
                <thead>
                    <tr>
                        <th width="10">
                            
                        </th>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.service') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.value') }}
                        </th>
                        <th>
                            {{ trans('cruds.servicesAttribute.fields.type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicesAttributes as $key => $servicesAttribute)
                        <tr data-entry-id="{{ $servicesAttribute->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $servicesAttribute->id ?? '' }}
                            </td>
                            <td>
                                {{ $servicesAttribute->service->name ?? '' }}
                            </td>
                            <td>
                                {{ $servicesAttribute->value ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\ServicesAttribute::TYPE_SELECT[$servicesAttribute->type] ?? '' }}
                            </td>
                            <td>
                                @can('services_attribute_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.services-attributes.show', $servicesAttribute->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('services_attribute_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.services-attributes.edit', $servicesAttribute->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('services_attribute_delete')
                                    <form action="{{ route('admin.services-attributes.destroy', $servicesAttribute->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('services_attribute_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.services-attributes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-ServicesAttribute:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection

@extends('layouts.admin')
@section('content')
@can('filing_data_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("filing-datas.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.filingData.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.filingData.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.filingData.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.filingData.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.filingData.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.filingData.fields.value') }}
                        </th>
                        <th>
                            {{ trans('cruds.filingData.fields.source') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filingDatas as $key => $filingData)
                        <tr data-entry-id="{{ $filingData->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $filingData->id ?? '' }}
                            </td>
                            <td>
                                {{ $filingData->code ?? '' }}
                            </td>
                            <td>
                                {{ $filingData->name ?? '' }}
                            </td>
                            <td>
                                {{ $filingData->value ?? '' }}
                            </td>
                            <td>
                                {{ $filingData->source ?? '' }}
                            </td>
                            <td>
                                @can('filing_data_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('filing-datas.show', $filingData->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('filing_data_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('filing-datas.edit', $filingData->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('filing_data_delete')
                                    <form action="{{ route('filing-datas.destroy', $filingData->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('filing_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('filing-datas.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 100,
  });
  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection

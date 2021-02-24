@extends('layouts.admin')
@section('content')
<div class="row grid-title" style="margin-bottom:65px;">
    <div class="col-lg-12">
            <h1>Audit Logs</h1>
    </div>
</div>
<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-AuditLog">
        <thead>
            <tr>
                <th width="10">
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.id') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.description') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.subject_id') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.subject_type') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.user_id') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.host') }}
                </th>
                <th>
                    {{ trans('cruds.auditLog.fields.created_at') }}
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($auditLogs as $key => $auditLog)
                <tr data-entry-id="{{ $auditLog->id }}">
                    <td>

                    </td>
                    <td>
                        {{ $auditLog->id ?? '' }}
                    </td>
                    <td>
                        {{ $auditLog->description ?? '' }}
                    </td>
                    <td>
                        {{ $auditLog->subject_id ?? '' }}
                    </td>
                    <td>
                        {{ $auditLog->subject_type ?? '' }}
                    </td>
                    <td>
                        <a href="{{ route('admin.users.show', $auditLog->user->id) }}">
                            {{ $auditLog->user->name ?? '' }}
                        </a>
                    </td>
                    <td>
                        {{ $auditLog->host ?? '' }}
                    </td>
                    <td>
                        {{ $auditLog->created_at ?? '' }}
                    </td>
                    <td>
                        @can('audit_log_show')
                            <a class="icons" href="{{ route('admin.audit-logs.show', $auditLog->id) }}">
                                <img class="client-icons" src="{{ asset('images/view.svg ')}}">
                                <span class="tooltiptext">View</span>
                            </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        let customButtons = [
            $.fn.dataTable.defaults.buttons[0],
            $.fn.dataTable.defaults.buttons[4],
            $.fn.dataTable.defaults.buttons[1],
            $.fn.dataTable.defaults.buttons[2],
            $.fn.dataTable.defaults.buttons[3]
        ]
        let dtButtons = $.extend(true, [], customButtons)

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
    lengthChange: false,
    language: {
        search: '',
        searchPlaceholder: "Search"
    },
  });
  $('.datatable-AuditLog:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection

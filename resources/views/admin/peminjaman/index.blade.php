@extends('layouts.admin')
@section('content')
@can('peminjaman_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.peminjaman.create") }}">
                {{ trans('global.add') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-peminjaman">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Nama Peminjam
                        </th>
                        <th>
                            Email Peminjam
                        </th>
                        <th>
                            Barang yang Dipinjam
                        </th>
                        <th>
                            Tanggal Peminjaman
                        </th>
                        <th>
                            Tanggal Kembali
                        </th>
                        <th>
                            Admin
                        </th>
                        
                        <th>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $key => $peminjaman)
                        <tr data-entry-id="{{ $peminjaman->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $peminjaman->nama ?? '' }}
                            </td>
                            <td>
                                {{ $peminjaman->email ?? '' }}
                            </td>
                            <td>
                                {{ $peminjaman->barang_pinjam ?? '' }}
                            </td>
                            <td>
                                {{ $peminjaman->tanggal_pinjam ?? '' }}
                            </td>
                            <td>
                                {{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}
                            </td>
                            <td>
                                {{ $peminjaman->user_id ?? '' }}
                            </td>
                            <td>

                                @can('peminjaman_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.peminjaman.edit', $peminjaman->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('peminjaman_delete')
                                    <form action="{{ route('admin.peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('peminjaman_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.peminjaman.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-peminjaman:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
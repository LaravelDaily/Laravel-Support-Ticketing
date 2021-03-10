@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Daftar Kunci Data Peminjaman
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <!-- FORM UNTUK FILTER BERDASARKAN DATE RANGE -->
            <form action="{{ route('admin.peminjaman.rangeReport') }}" method="get">
                <div class="input-group mb-3 col-md-3 float-right">
                    <input type="text" id="created_at" name="date" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">Filter</button>
                    </div>
                </div>
            </form>
            <table class=" table table-bordered table-striped table-hover datatable datatable-peminjaman">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            ID
                        </th>
                        <th>
                            Kunci
                        </th>
                        <th>
                            Peminjam
                        </th>
                        <th>
                            Tanggal Peminjaman
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Admin
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kuncis as $key => $kunci)
                        <tr data-entry-id="{{ $kunci->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $kunci->id ?? '' }}
                            </td>
                            <td>
                                {{ $kunci->kunci ?? '' }}
                            </td>
                            <td>
                                {{ $kunci->peminjaman->nama ?? '' }}
                            </td>
                            <td>
                                {{ $kunci->peminjaman->tanggal_pinjam ?? '' }}
                            </td>
                            <td>
                            @if ($kunci->status === 1)
                                Sudah Terpakai
                            @else
                                Belum Terpakai
                            @endif
                            </td>
                            <td>
                                {{ $kunci->peminjaman->user_id ?? '' }}
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
$(document).ready(function() {
    let start = moment().startOf('month')
    let end = moment().endOf('month')

    //INISIASI DATERANGEPICKER
    $('#created_at').daterangepicker({
        startDate: start,
        endDate: end
    })
})

</script>
@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Pengembalian Data Peminjaman {{$peminjaman->email}}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.peminjaman.updatePengembalian", [$peminjaman->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('barang_pinjam') ? 'has-error' : '' }}">
                <label for="barang_pinjam">Barang Pinjam*</label>
                <input type="text" id="barang_pinjam" name="barang_pinjam" class="form-control" value="{{ old('barang_pinjam', isset($peminjaman) ? $peminjaman->barang_pinjam : '') }}" disabled>
                <input type="text" id="barang_pinjam" name="barang_pinjam" class="form-control" value="{{ old('barang_pinjam', isset($peminjaman) ? $peminjaman->barang_pinjam : '') }}" hidden>
                @if($errors->has('barang_pinjam'))
                    <em class="invalid-feedback">
                        {{ $errors->first('barang_pinjam') }}
                    </em>
                @endif
                <!-- <p class="helper-block">
                    Daftar barang yang dipinjam, dipisahkan ';'
                </p> -->
            </div>
            <div class="form-group {{ $errors->has('nama') ? 'has-error' : '' }}">
                <label for="nama">Nama Peminjam*</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', isset($peminjaman) ? $peminjaman->nama : '') }}" disabled>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', isset($peminjaman) ? $peminjaman->nama : '') }}" hidden>
                @if($errors->has('nama'))
                    <em class="invalid-feedback">
                        {{ $errors->first('nama') }}
                    </em>
                @endif
                <!-- <p class="helper-block">
                    {{ trans('cruds.comments.fields.author_email_helper') }}
                </p> -->
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                <label for="email">Email Peminjam</label>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($peminjaman) ? $peminjaman->email : '') }}" disabled>
                <input type="text" id="email" name="email" class="form-control" value="{{ old('email', isset($peminjaman) ? $peminjaman->email : '') }}" hidden>
                @if($errors->has('email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('tanggal_pinjam') ? 'has-error' : '' }}">
                <label for="email">Tanggal Pinjam</label>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', isset($peminjaman) ? $peminjaman->tanggal_pinjam : '') }}" disabled>
                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" value="{{ old('tanggal_pinjam', isset($peminjaman) ? $peminjaman->tanggal_pinjam : '') }}" hidden>
                @if($errors->has('tanggal_pinjam'))
                    <em class="invalid-feedback">
                        {{ $errors->first('tanggal_pinjam') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('tanggal_kembali') ? 'has-error' : '' }}">
                <label for="tanggal_kembali">Tanggal Kembali</label>
                <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', isset($peminjaman) ? $peminjaman->tanggal_kembali : '') }}" required>
                @if($errors->has('tanggal_kembali'))
                    <em class="invalid-feedback">
                        {{ $errors->first('tanggal_kembali') }}
                    </em>
                @endif
            </div>
            <div class="form-group">
                <label for="key">Key</label>
                <input type="text" id="key" name="key" class="form-control" required>
                @if($errors->has('tanggal_kembali'))
                    <em class="invalid-feedback">
                        {{ $errors->first('tanggal_kembali') }}
                    </em>
                @endif
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection

@section('scripts')

@endsection
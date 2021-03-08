@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.peminjaman.title_singular') }}
    </div>

    <div class="card-body">
        <form action="{{ route("admin.peminjaman.update", [$peminjaman->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : '' }}">
                <label for="ticket">{{ trans('cruds.peminjaman.fields.ticket') }}</label>
                <select name="ticket_id" id="ticket" class="form-control select2">
                    @foreach($tickets as $id => $ticket)
                        <option value="{{ $id }}" {{ (isset($peminjaman) && $peminjaman->ticket ? $peminjaman->ticket->id : old('ticket_id')) == $id ? 'selected' : '' }}>{{ $ticket }}</option>
                    @endforeach
                </select>
                @if($errors->has('ticket_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('ticket_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('author_name') ? 'has-error' : '' }}">
                <label for="author_name">{{ trans('cruds.peminjaman.fields.author_name') }}*</label>
                <input type="text" id="author_name" name="author_name" class="form-control" value="{{ old('author_name', isset($peminjaman) ? $peminjaman->author_name : '') }}" required>
                @if($errors->has('author_name'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_name') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.peminjaman.fields.author_name_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('author_email') ? 'has-error' : '' }}">
                <label for="author_email">{{ trans('cruds.peminjaman.fields.author_email') }}*</label>
                <input type="text" id="author_email" name="author_email" class="form-control" value="{{ old('author_email', isset($peminjaman) ? $peminjaman->author_email : '') }}" required>
                @if($errors->has('author_email'))
                    <em class="invalid-feedback">
                        {{ $errors->first('author_email') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.peminjaman.fields.author_email_helper') }}
                </p>
            </div>
            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                <label for="user">{{ trans('cruds.peminjaman.fields.user') }}</label>
                <select name="user_id" id="user" class="form-control select2">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (isset($peminjaman) && $peminjaman->user ? $peminjaman->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('peminjaman_text') ? 'has-error' : '' }}">
                <label for="peminjaman_text">{{ trans('cruds.peminjaman.fields.peminjaman_text') }}*</label>
                <textarea id="peminjaman_text" name="peminjaman_text" class="form-control " required>{{ old('peminjaman_text', isset($peminjaman) ? $peminjaman->peminjaman_text : '') }}</textarea>
                @if($errors->has('peminjaman_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('peminjaman_text') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.peminjaman.fields.peminjaman_text_helper') }}
                </p>
            </div>
            <div>
                <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
            </div>
        </form>


    </div>
</div>
@endsection
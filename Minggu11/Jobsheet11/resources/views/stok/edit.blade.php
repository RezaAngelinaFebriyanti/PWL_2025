@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($stok)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/stok/'.$stok->stok_id) }}" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang butuh method PUT -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">ID Barang</label>
                        <div class="col-11">
                            <select class="form-control" id="barang_id" name="barang_id" required>
                                <option value="">- Pilih ID Barang -</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->barang_id }}"
                                        @if($item->barang_id == $stok->level_id) selected @endif>
                                        {{ $item->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">ID User</label>
                        <div class="col-11">
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">- Pilih ID User -</option>
                                @foreach($user as $item)
                                    <option value="{{ $item->user_id }}"
                                        @if($item->user_id == $stok->user_id) selected @endif>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jumlah</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $stok->jumlah) }}" required>
                            @error('jumlah')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush